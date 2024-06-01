<?php
// Include the database connection file
require 'connection.php';

session_start();


if (!isset($_SESSION['id'])) {
    die("Παρακαλώ συνδεθείτε για να δείτε αυτή τη σελίδα.");
}

// Check for session timeout
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 240)) {
    // Last request was more than SESSION_TIMEOUT seconds ago
    session_unset(); // Unset session variables
    session_destroy(); // Destroy the session
    die("Η συνεδρία σας έχει λήξει. Παρακαλώ συνδεθείτε ξανά.");
}

// Update last activity time
$_SESSION['LAST_ACTIVITY'] = time();


// Fetch data from the task_lists table
$result_lists = $conn->query("SELECT * FROM task_lists");

// Initialize an empty array to store records
$records = [];

// Check if the query was successful
if ($result_lists) {
    // Fetch each row from the result set and add it to the records array
    while ($row = $result_lists->fetch_assoc()) {
        
        $records[] = $row;
    }
}

// Fetch data from the tasks table
$result_tasks = $conn->query("SELECT * FROM tasks");

// Check if the query was successful
if ($result_tasks) {
    // Fetch each row from the result set and add it to the records array
    while ($row = $result_tasks->fetch_assoc()) {
        
        $records[] = $row;
    }
}

// Create a new XML document
$xml = new DOMDocument('1.0', 'UTF-8');
$xml->formatOutput = true;

// Create the root element
$datasetElement = $xml->createElement('dataset');
$xml->appendChild($datasetElement);

// Create records
foreach ($records as $record) {
    // Create record element
    $recordElement = $xml->createElement('record');
    $datasetElement->appendChild($recordElement);
    
    // Add fields to the record element
    foreach ($record as $key => $value) {
        $childElement = $xml->createElement($key, $value);
        $recordElement->appendChild($childElement);
    }
}

// Set the appropriate header for XML content
header('Content-type: application/xml');
header('Content-Disposition: attachment; filename="data.xml"');

// Output the XML data
echo $xml->saveXML();
?>

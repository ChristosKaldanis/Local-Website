<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Σελίδα Βοήθειας </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style4.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <h1 class="main-heading">Department of Informatics</h1>
        <p>Ionian University</p>
    </header>
    <nav class = "navbar">
        <ul>
            <li><a href="index.php"> Home</a></li>
            <li><a href="about.php"> About</a></li>
        </ul>
    </nav>
    <main>
        <h2 style="margin: top 20px;"> Βασική Βοήθεια </h2>
        
        <p style="text-align: center;">Πατήστε το κουμπί για να ανοίξετε το περιεχόμενο που παρέχεται για την βασική βοήθεια της ιστοσελίδας.</p>

        <button class="accordion">Σύνδεση και Εγγραφή</button>
        <div class="panel">
            <p>Για να χρησιμοποιήσετε την ιστοσελίδα, πρέπει να έχετε λογαριασμό. Αν δεν έχετε, παρακαλώ εγγραφείτε μέσω της σελίδας εγγραφής. Αν έχετε ήδη λογαριασμό, συνδεθείτε με το email και τον κωδικό σας.</p>
        </div>

        <button class="accordion">Διαχείριση Προφίλ</button>
        <div class="panel">
            <p>Μόλις συνδεθείτε, μπορείτε να διαχειριστείτε το προφίλ σας από τη σελίδα "Manage Profile". Εδώ μπορείτε να ενημερώσετε τα προσωπικά σας στοιχεία και να καταχωρήσετε το Simplepush key για να λαμβάνετε ειδοποιήσεις.</p>
        </div>

        <button class="accordion">Λίστες και Εργασίες</button>
        <div class="panel">
            <p>Από τη σελίδα "Lists and Tasks" μπορείτε να δημιουργήσετε και να διαχειριστείτε λίστες και εργασίες:</p>
            <ul>
                <li>Δημιουργία Λίστας: Συμπληρώστε τον τίτλο της λίστας και πατήστε το κουμπί "Create".</li>
                <li>Δημιουργία Εργασίας: Συμπληρώστε τον τίτλο της εργασίας και πατήστε το κουμπί "Create". Μόλις δημιουργήσετε την εργασία, θα λάβετε ειδοποίηση.</li>
            </ul>
        </div>

        <button class="accordion">Ειδοποιήσεις Push</button>
        <div class="panel">
            <p>Η ιστοσελίδα στέλνει ειδοποιήσεις στους χρήστες όταν:</p>
            <ul>
                <li>Δημιουργούν οι ίδιοι μια εργασία. </li>
                <li>Τους ανατίθεται μια εργασία από άλλο χρήστη. </li>
            </ul>
        </div>

        <button class="accordion">Αναζήτηση Εργασιών και Λιστών</button>
        <div class="panel">
            <p>Μπορείτε να αναζητήσετε συγκεκριμένες εργασίες και λίστες από τις σελίδες "Search Tasks" και "Search Lists":</p>
            <ul>
                <li>Αναζήτηση Λιστών: Πληκτρολογήστε τον τίτλο της λίστας που ψάχνετε και πατήστε "Search".</li>
                <li>Αναζήτηση Εργασιών: Εισάγετε τον τίτλο ή άλλα κριτήρια αναζήτησης και πατήστε "Search".</li>
            </ul>
        </div>

        <button class="accordion">Εξαγωγή σε XML</button>
        <div class="panel">
            <p>Για να εξάγετε τα δεδομένα σας σε XML:</p>
            <ul>
                <li>Μεταβείτε στη σελίδα "Export to XML".</li>
            </ul>
        </div>

        <button class="accordion">Αποσύνδεση</button>
        <div class="panel">
            <p>Για να αποσυνδεθείτε, επιλέξτε "Sign Out" από το μενού. Η συνεδρία σας θα λήξει και θα πρέπει να συνδεθείτε ξανά για να αποκτήσετε πρόσβαση στην ιστοσελίδα.</p>
        </div>

    </main>
    <script src="https://cdn.jsdelivr.net/npm/darkmode-js@1.5.7/lib/darkmode-js.min.js"></script>
    <script src="script2.js"></script>
</body>
</html>

# Local-Website
# Info

# Website Description
The local website, Local-Website, was created using XAMPP and contains both front-end and back-end elements. Its purpose is to manage task lists and individual tasks, facilitating interaction among multiple users.

# Website Functionality
Initially, before user authentication, there are two options in the navigation bar: Home and About. On the Home page, users can either Sign up or Sign in, depending on whether they already have an account. The About page provides basic help and information about each section of the website.

After user authentication, the navigation bar includes the pages Manage Profile, Lists and Tasks, Search Tasks, Search Lists, Export to XML, and Sign Out. On the Manage Profile page, users can manage their profile by editing their details or deleting their profile. If a user deletes their profile, it is not completely erased; the details are assigned random values to ensure that the actions they have performed are not fully deleted.

On the Lists and Tasks page, users can assign tasks to other users via username and the user's list. They can also manage their task lists and tasks, with the ability to create, edit, and delete them. If a user performs task assignment or task creation, a notification is automatically sent to the mobile phone of the user to whom the task is assigned or to the current user creating a task, depending on the performed function, using the simplepush.io API based on their Push Key. The first list and task for each user are provided by the website administrator.

On the Search Lists page, users can search for any list. Similarly, the Search Tasks page allows users to search for any task. The next option is Export to XML, which exports all lists and tasks to an XML file with a single click. Finally, the Sign Out option logs the user out and redirects them to the Home page.

Each page features an icon on the right side that allows users to toggle between light mode and dark mode.

# Implementation
The website implementation was carried out by Christos Kaldanis, an undergraduate student at the Department of Informatics, Ionian University.

# New Release
A new release has been posted, which includes the dockerization of the current Local-Website. A public OneDrive link containing a demonstration of the functionality after dockerizing the website is available:





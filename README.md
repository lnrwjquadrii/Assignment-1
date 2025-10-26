# Assignment-1

Mafe Fogofoluwa Daniel 23/2239-Handling POST form for submitting feedback.

Okachi-ben Christopher 23/2359-handling include keyword search and sorting options.

Chika-Alex Angell 23/2973-handling add form validation and input sanitization.

Osadolor Freda 23/1918-handling databse tables:feedback,admins.

Quadri uthman olanrewaju 23/0951-handling implement authentication for admin panel.

Ohiku favour adewale 23/0732-handling GET method for viewing all feedback(admin only).
For my part of the project, I implemented the GET method that allows the admin to view all submitted feedback.
I used PHP to read the stored feedback data from a JSON file and display it in a structured format.The system checks the admin credentials from the query parameters before showing the feedback list.
Once authenticated, all feedback messages are retrieved and displayed instantly in JSON format for easy review and debugging.

I tested the project in VS Code using the PHP local server (php -S localhost:5000) and confirmed that the admin can view all feedback entries properly.

Osadolor Divine Favour 23/1919-handling include keyword search and sorting options.

Ngwumohaike John-Victor chukwunedum 23/1332-handling implement authentication for admin panel.


Mafe Fogofoluwa Daniel 23/2239-Handling POST form for submitting feedback:
I did the first part of the project, which involved creating the Anonymous Feedback System using PHP, MySQL, HTML, and CSS.
I designed and coded the feedback form interface, connected it to the database, and made sure users could submit their feedback anonymously.
I also handled the database connection setup and created the feedback_db database with a feedback table that stores each message along with the time it was submitted.After submission, I added functionality to display all feedback messages instantly on the same page, allowing users to see every entry without refreshing manually.
Finally, I tested my code on VS Code with XAMPP, confirmed that the feedback was being saved in phpMyAdmin, and uploaded my completed part to GitHub so the rest of the group could integrate their sections easily.

Okachi-Ben Christopher - 23/2359
Handling keyword search and sorting options
I developed the keyword search functionality for the Online Feedback System's admin panel. The search feature allows administrators to quickly locate feedback entries by searching across name, email, and feedback content fields simultaneously using SQL LIKE operators with wildcard matching. This means partial word searches work perfectly - typing "great" finds "great service" or "greatest experience."
I implemented the search using PHP prepared statements with MySQLi to prevent SQL injection attacks while maintaining fast performance. The search query builds a WHERE clause that checks all three fields using OR logic, ensuring comprehensive coverage. I designed a minimalist interface with a single search input field and "Go" button that preserves current sort settings.
I added session-based authentication to restrict access to logged-in administrators only, integrating seamlessly with the existing admin panel login system. Throughout development, I collaborated with Osadolor Divine Favour on the sorting functionality, ensuring both features work together smoothly. After testing with XAMPP and phpMyAdmin to verify accuracy and security, I committed the code to GitHub with proper co-author attribution.

Osadolor Divine Favour - 23/1919 Handling keyword search and sorting options I developed the keyword search functionality for the Online Feedback System's admin panel. The search feature allows administrators to quickly locate feedback entries by searching across name, email, and feedback content fields simultaneously using SQL LIKE operators with wildcard matching. This means partial word searches work perfectly - typing "great" finds "great service" or "greatest experience." I implemented the search using PHP prepared statements with MySQL to prevent SQL injection attacks while maintaining fast performance. The search query builds a WHERE clause that checks all three fields using OR logic, ensuring comprehensive coverage. I designed a minimalist interface with a single search input field and "Go" button that preserves current sort settings. I added session-based authentication to restrict access to logged-in administrators only, integrating seamlessly with the existing admin panel login system. Throughout development, I collaborated with Okachi-Ben Christopher on the sorting functionality, ensuring both features work together smoothly. After testing with XAMPP and phpMyAdmin to verify accuracy and security, I committed the code to GitHub with proper co-author attribution.

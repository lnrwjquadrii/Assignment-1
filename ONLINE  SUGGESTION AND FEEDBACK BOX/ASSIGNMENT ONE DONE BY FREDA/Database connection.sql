< ? php $servername = "localhost";
$username = "your_username";
$password = "your_password";
$database = "your_database";
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) { die("Connection failed: ".$conn->connect_error);
}
else { echo "Connected successfully";
} // SQL query to create admins table $sql = "CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL
)";
$conn->query($sql);
// SQL query to create feedback table $sql = "CREATE TABLE IF NOT EXISTS feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT,
    feedback TEXT NOT NULL,
    rating INT NOT NULL,
    FOREIGN KEY (admin_id) REFERENCES admins(id)
)";
$conn->query($sql);
//
Insert data into admins table $sql = "INSERT INTO admins (username, password, email) VALUES ('admin', 'password', 'admin@example.com')";
$conn->query($sql);
//
Insert data into feedback table $sql = "INSERT INTO feedback (admin_id, feedback, rating) VALUES (1, 'This is a sample feedback.', 5)";
$conn->query($sql);
// SQL query to retrieve data
from both tables $sql = "SELECT admins.username, feedback.feedback, feedback.rating
        FROM admins
        INNER JOIN feedback
        ON admins.id = feedback.admin_id";
// Execute the query $result = $conn->query($sql);
// Check if there are any results if ($result->num_rows > 0) { while($row = $result->fetch_assoc()) { echo "Username: ".$row ["username"].", Feedback: ".$row ["feedback"].", Rating: ".$row ["rating"]."<br>";
} }
else { echo "0 results";
} // Close the connection $conn->close();
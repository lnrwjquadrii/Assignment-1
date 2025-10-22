<?php
// DATABASE CONNECTION
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feedback_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// FORM SUBMISSION LOGIC
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $message = htmlspecialchars(trim($_POST['message']));

  if (!empty($message)) {
    $sql = "INSERT INTO feedback (message) VALUES ('$message')";
    if ($conn->query($sql) === TRUE) {
      echo "<script>alert('Feedback submitted successfully!');</script>";
    } else {
      echo "<script>alert('Database error: " . $conn->error . "');</script>";
    }
  } else {
    echo "<script>alert('Feedback cannot be empty!');</script>";
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Anonymous Feedback Box</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .container {
      background-color: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      width: 400px;
    }
    textarea {
      width: 100%;
      height: 100px;
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
      resize: none;
    }
    button {
      margin-top: 10px;
      width: 100%;
      padding: 10px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Anonymous Feedback Box</h2>
    <form method="POST" action="">
      <textarea name="message" placeholder="Type your feedback..." required></textarea>
      <button type="submit">Submit Feedback</button>
    </form>
  </div>
</body>
</html>
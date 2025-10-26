<?php
// Simple Feedback System (index.php)

// File to store feedback
$file = "feedback.json";

// When form is submitted
if (isset($_POST['message'])) {
    $data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    $data[] = ["id" => time(), "message" => $_POST['message']];
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
    echo "<p style='color:green;'>Feedback submitted successfully!</p>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Feedback Form</title>
</head>
<body style="font-family:Arial; background:#f8f8f8; text-align:center;">
    <h2>Submit Your Feedback</h2>
    <form method="POST">
        <textarea name="message" placeholder="Enter feedback..." required style="width:300px; height:80px;"></textarea><br><br>
        <button type="submit">Submit</button>
    </form>

    <h3>All Feedbacks</h3>
    <?php
    // Display all feedback
    if (file_exists($file)) {
        $feedbacks = json_decode(file_get_contents($file), true);
        foreach ($feedbacks as $f) {
            echo "<p><b>ID:</b> {$f['id']} <br> <b>Message:</b> {$f['message']}</p><hr>";
        }
    } else {
        echo "No feedback yet.";
    }
    ?>
</body>
</html>

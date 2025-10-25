<?php
session_start();
if (!isset($_SESSION['admin'])) exit(header("Location: admin_panel.php"));

$conn = new mysqli("localhost", "root", "", "feedback_db");
if ($conn->connect_error) die("Connection failed");

$search = $_GET['search'] ?? '';
$sort = in_array($_GET['sort'] ?? '', ['id','name','email','rating','created_at']) ? $_GET['sort'] : 'created_at';
$order = ($_GET['order'] ?? 'DESC') == 'ASC' ? 'ASC' : 'DESC';

$sql = "SELECT * FROM feedback WHERE name LIKE ? OR email LIKE ? OR feedback LIKE ? ORDER BY $sort $order";
$stmt = $conn->prepare($sql);
$term = "%$search%";
$stmt->bind_param("sss", $term, $term, $term);
$stmt->execute();
$result = $stmt->get_result();

if (isset($_GET['logout'])) { session_destroy(); exit(header("Location: admin_panel.php")); }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Feedback</title>
    <style>
        body { font-family: Arial; max-width: 900px; margin: 20px auto; padding: 20px; background: #f5f5f5; }
        form { background: white; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        input, select, button { padding: 8px; margin: 5px; border: 1px solid #ddd; border-radius: 3px; }
        input { width: calc(100% - 20px); }
        button { background: #007bff; color: white; border: none; cursor: pointer; }
        .item { background: white; padding: 15px; margin-bottom: 10px; border-radius: 5px; }
        .item b { color: #333; }
        .item small { color: #999; }
        .rating { color: #ffc107; }
        a { float: right; color: #dc3545; text-decoration: none; }
    </style>
</head>
<body>
    <a href="?logout=1">Logout</a>
    <h2>Feedback</h2>
    
    <form>
        <input name="search" placeholder="Search..." value="<?= htmlspecialchars($search) ?>">
        <select name="sort">
            <option value="created_at" <?= $sort=='created_at'?'selected':'' ?>>Date</option>
            <option value="name" <?= $sort=='name'?'selected':'' ?>>Name</option>
            <option value="rating" <?= $sort=='rating'?'selected':'' ?>>Rating</option>
        </select>
        <select name="order">
            <option value="DESC" <?= $order=='DESC'?'selected':'' ?>>↓</option>
            <option value="ASC" <?= $order=='ASC'?'selected':'' ?>>↑</option>
        </select>
        <button>Go</button>
    </form>

    <?php while($r = $result->fetch_assoc()): ?>
        <div class="item">
            <b><?= htmlspecialchars($r['name']) ?></b> 
            <span class="rating">★<?= $r['rating'] ?></span>
            <p><?= nl2br(htmlspecialchars($r['feedback'])) ?></p>
            <small><?= $r['created_at'] ?></small>
        </div>
    <?php endwhile; ?>
    
    <?php if($result->num_rows == 0): ?>
        <div class="item">No feedback found.</div>
    <?php endif; ?>
</body>
</html>

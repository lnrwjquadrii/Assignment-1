username VARCHAR(100) NOT NULL UNIQUE,

<?php
// coding.php
// Simple admin authentication for XAMPP (MySQL). Drop into /C:/xampp/htdocs/coding.php
// Requirements: create a `users` table in your database (see SQL comment below).

// ---------- CONFIG ----------
$dbHost = '127.0.0.1';
$dbName = 'your_database';
$dbUser = 'root';
$dbPass = ''; // update as needed
$usersTable = 'users'; // table must have columns: id (int, pk), username (varchar), password_hash (varchar), role (varchar)
// ---------- END CONFIG ----------

/*
SQL to create users table and an admin user (run once via phpMyAdmin or CLI):

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    password_hash VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- create a password hash in PHP: password_hash('YourStrongPassword', PASSWORD_DEFAULT)
INSERT INTO users (username, password_hash, role) VALUES ('admin', '<PASTE_HASH_HERE>', 'admin');

You can generate the hash with:
<?php echo password_hash('YourStrongPassword', PASSWORD_DEFAULT); ?>
*/

// ---------- BOILERPLATE ----------
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Secure session cookie params (adjust for development vs production)
session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',    // set your domain in production
        'secure' => false, // set true if using HTTPS
        'httponly' => true,
        'samesite' => 'Lax'
]);
session_start();

try {
        $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
} catch (PDOException $e) {
        http_response_code(500);
        echo "Database connection failed.";
        exit;
}

// ---------- CSRF ----------
function csrf_token() {
        if (empty($_SESSION['csrf_token'])) {
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
}
function check_csrf($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], (string)$token);
}

// ---------- AUTH HELPERS ----------
function is_logged_in() {
        return !empty($_SESSION['user_id']) && !empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}
function require_admin() {
        if (!is_logged_in()) {
                header('Location: ?action=login');
                exit;
        }
}

// ---------- ROUTING ----------
$action = $_GET['action'] ?? ($_POST['action'] ?? 'panel');

if ($action === 'login' || ($action === 'panel' && $_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'login')) {
        // Show login form or handle login submit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Handle login
                $username = trim($_POST['username'] ?? '');
                $password = $_POST['password'] ?? '';
                $token = $_POST['csrf_token'] ?? '';
                if (!check_csrf($token)) {
                        $error = "Invalid CSRF token.";
                } elseif ($username === '' || $password === '') {
                        $error = "Username and password required.";
                } else {
                        // Fetch user
                        $stmt = $pdo->prepare("SELECT id, username, password_hash, role FROM $usersTable WHERE username = :u LIMIT 1");
                        $stmt->execute([':u' => $username]);
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);
                        if ($user && password_verify($password, $user['password_hash'])) {
                                // Only allow admins
                                if ($user['role'] !== 'admin') {
                                        $error = "Access denied.";
                                } else {
                                        // Successful login
                                        session_regenerate_id(true);
                                        $_SESSION['user_id'] = $user['id'];
                                        $_SESSION['username'] = $user['username'];
                                        $_SESSION['user_role'] = $user['role'];
                                        // refresh CSRF token after login
                                        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                                        header('Location: ./coding.php');
                                        exit;
                                }
                        } else {
                                $error = "Invalid credentials.";
                        }
                }
        }
        // Render login form
        $t = htmlspecialchars($_SERVER['PHP_SELF']);
        $csrf = csrf_token();
        ?>
        <!doctype html>
        <html>
        <head><meta charset="utf-8"><title>Admin Login</title></head>
        <body>
        <h2>Admin Login</h2>
        <?php if (!empty($error)): ?><p style="color:red"><?php echo htmlspecialchars($error); ?></p><?php endif; ?>
        <form method="post" action="<?php echo $t; ?>">
            <input type="hidden" name="action" value="login">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">
            <div><label>Username: <input type="text" name="username" required></label></div>
            <div><label>Password: <input type="password" name="password" required></label></div>
            <div><button type="submit">Log in</button></div>
        </form>
        </body>
        </html>
        <?php
        exit;
} elseif ($action === 'logout') {
        // Logout
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                        $params["path"], $params["domain"],
                        $params["secure"], $params["httponly"]
                );
        }
        session_destroy();
        header('Location: ./coding.php?action=login');
        exit;
} else {
        // Default: admin panel (protected)
        require_admin();
        $username = htmlspecialchars($_SESSION['username']);
        $csrf = csrf_token();
        ?>
        <!doctype html>
        <html>
        <head><meta charset="utf-8"><title>Admin Panel</title></head>
        <body>
        <h1>Admin Panel</h1>
        <p>Welcome, <?php echo $username; ?>. You are authenticated as admin.</p>

        <form method="post" action="./coding.php?action=logout" style="display:inline">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">
            <a href="?action=logout" onclick="event.preventDefault(); this.closest('form').submit();">Log out</a>
        </form>

        <hr>
        <h3>Example admin functionality</h3>
        <p>Place your admin pages/links here. All pages should call require_admin() to restrict access.</p>

        </body>
        </html>
        <?php
        exit;
}
?>
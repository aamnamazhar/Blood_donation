<?php
session_start(); // Start the session

require 'db.php'; // Include the database connection file

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user from the database
    $sql = "SELECT * FROM users WHERE username = :username OR email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':email', $username, PDO::PARAM_STR); // Allow login with username or email
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify password and proceed with login
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_type'] = $user['user_type']; // Assuming you have this column in your table

        // Redirect to profile page
        header('Location: profile.php'); 
        exit();
    } else {
        $message = 'Invalid username or password.';
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="container">
    <h2>Login</h2>
    <?php if (!empty($message)): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <div class="auth-forms">
        <form method="POST" action="login.php">
            <label for="username">Username or Email:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <div class="button-container">
                <button type="submit" name="login" class="search-btn">Login</button>
                <button type="button" class="index-btn" onclick="window.location.href='index.php'">Go To Home</button>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<?php
require 'db.php'; // Include the database connection file

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    // Registration logic
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $user_type = $_POST['user_type'];
    $blood_type = $_POST['blood_type'];
    $location = $_POST['location'];
    $contact_number = $_POST['contact_number'];
    $gender = $_POST['gender'];

    if ($password !== $confirm_password) {
        $message = 'Passwords do not match.';
    } else {
        $password_hashed = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (name, email, username, password, user_type, blood_type, location, contact_number, gender)
                VALUES (:name, :email, :username, :password, :user_type, :blood_type, :location, :contact_number, :gender)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password_hashed, PDO::PARAM_STR);
        $stmt->bindParam(':user_type', $user_type, PDO::PARAM_STR);
        $stmt->bindParam(':blood_type', $blood_type, PDO::PARAM_STR);
        $stmt->bindParam(':location', $location, PDO::PARAM_STR);
        $stmt->bindParam(':contact_number', $contact_number, PDO::PARAM_STR);
        $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $message = 'Registration successful. You can now <a href="login.php">login</a>.';
        } else {
            $message = 'Error during registration. Please try again.';
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="container">
    <h2>User Registration</h2>
    <?php if (!empty($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <div class="auth-forms">
        <form method="POST" action="registration.php">
            <h3>Register</h3>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <label for="user_type">I am a:</label>
            <select id="user_type" name="user_type" required>
                <option value="donor">Donor</option>
                <option value="patient">Patient</option>
            </select>
            <label for="blood_type">Blood Type:</label>
            <select id="blood_type" name="blood_type" required>
                <option value="">Select</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>
            <label for="contact_number">Contact Number:</label>
            <input type="text" id="contact_number" name="contact_number" required>
            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="">Select</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
            <div class="button-container">
                <button type="Register" class="search-btn">Register</button>
                <button type="button" class="index-btn" onclick="window.location.href='home.php'">Go To Home</button>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

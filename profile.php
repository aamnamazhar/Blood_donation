<?php
session_start(); // Start the session
require 'db.php'; // Include the database connection file

// Fetch user data from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<?php include 'includes/header.php'; ?>

<main>
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?></h2>
        <table class="profile-table">
            <tr>
                <th>Name</th>
                <td><?php echo htmlspecialchars($user['name']); ?></td>
            </tr>
            <tr>
                <th>Username</th>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
            </tr>
            <tr>
                <th>User Type</th>
                <td><?php echo htmlspecialchars($user['user_type']); ?></td>
            </tr>
            <tr>
                <th>Blood Type</th>
                <td><?php echo htmlspecialchars($user['blood_type']); ?></td>
            </tr>
            <tr>
                <th>Location</th>
                <td><?php echo htmlspecialchars($user['location']); ?></td>
            </tr>
            <tr>
                <th>Contact Number</th>
                <td><?php echo htmlspecialchars($user['contact_number']); ?></td>
            </tr>
        </table>
        <div class="profile-actions">
            <?php if ($user['user_type'] === 'patient'): ?>
                <a href="process_appointments.php" class="btn">Set Appointment</a>
            <?php endif; ?>
            <?php if ($user['user_type'] === 'donor'): ?>
                <a href="process_dates.php" class="btn">Set Donation Date</a>
            <?php endif; ?>
        </div>
        <div class="button-container">
            <button type="button" class="index-btn" onclick="window.location.href='index.php'">Go To Home</button>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

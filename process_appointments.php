<?php
session_start(); // Start the session

require 'db.php'; // Include the database connection file

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['appointment_date'])) {
        $appointmentDate = $_POST['appointment_date'];
    } else {
        $message = "Appointment date is required.";
    }

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
    } else {
        $message = "User not logged in.";
    }

    if (empty($message)) {
        try {
            $insertQuery = "INSERT INTO appointments (username, appointment_date) VALUES (:username, :appointment_date)";
            $stmt = $conn->prepare($insertQuery);

            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':appointment_date', $appointmentDate, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $message = "Appointment scheduled successfully.";
            } else {
                $message = "Error executing statement: " . implode(" ", $stmt->errorInfo());
            }
        } catch (PDOException $e) {
            $message = "Error preparing statement: " . $e->getMessage();
        }
    }
} else {
    $message = "Invalid request method.";
}
?>

<?php include 'includes/header.php'; ?>

<main>
    <div class="container">
        <h2>Schedule Appointment</h2>
        <?php if (!empty($message)): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form method="POST" action="process_appointments.php">
            <label for="appointment_date">Appointment Date:</label>
            <input type="date" id="appointment_date" name="appointment_date" required>
            <div class="button-container">
                <button type="submit" class="search-btn">Submit</button>
                <button type="button" class="index-btn" onclick="window.location.href='index.php'">Go To Home</button>
            </div>
        </form>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

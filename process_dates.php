<?php
session_start(); // Start the session

require 'db.php'; // Include the database connection file

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['donation_date'])) {
        $donationDate = $_POST['donation_date'];
    } else {
        $message = "Donation date is required.";
    }

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
    } else {
        $message = "User not logged in.";
    }

    if (empty($message)) {
        try {
            $insertQuery = "INSERT INTO donation_dates (username, donation_date) VALUES (:username, :donation_date)";
            $stmt = $conn->prepare($insertQuery);

            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':donation_date', $donationDate, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $message = "Thank you for selecting a donation date! You will be contacted for further details.";
            } else {
                $message = "Error executing statement: " . implode(" ", $stmt->errorInfo());
            }
        } catch (PDOException $e) {
            $message = "Error preparing statement: " . $e->getMessage();
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<main>
    <div class="container">
        <h2>Select Donation Date</h2>
        <?php if (!empty($message)): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form method="POST" action="process_dates.php">
            <label for="donation_date">Donation Date:</label>
            <input type="date" id="donation_date" name="donation_date" required>
            <div class="button-container">
                <button type="submit" class="search-btn">Submit</button>
                <button type="button" class="index-btn" onclick="window.location.href='index.php'">Go To Home</button>
            </div>
        </form>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

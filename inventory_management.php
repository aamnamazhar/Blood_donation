<?php
require 'db.php'; // Include the database connection file

$message = '';

// Pagination
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = 10;
$offset = ($page - 1) * $records_per_page;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $blood_type = $_POST['blood_type'];
    $location = $_POST['location'];

    // Count total donors
    $countSql = "SELECT COUNT(*) AS total FROM users WHERE user_type = 'donor' AND blood_type = :blood_type AND location = :location";
    $stmt = $conn->prepare($countSql);
    $stmt->bindParam(':blood_type', $blood_type, PDO::PARAM_STR);
    $stmt->bindParam(':location', $location, PDO::PARAM_STR);
    $stmt->execute();
    $total_donors = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Fetch donors with pagination
    $sql = "SELECT * FROM users WHERE user_type = 'donor' AND blood_type = :blood_type AND location = :location LIMIT $offset, $records_per_page";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':blood_type', $blood_type, PDO::PARAM_STR);
    $stmt->bindParam(':location', $location, PDO::PARAM_STR);
    $stmt->execute();
    $donors = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($donors) {
        // Display donor information
        $message = 'Donor(s) found:';
        foreach ($donors as $donor) {
            $message .= "<br>Name: {$donor['name']}, Blood Type: {$donor['blood_type']}, Location: {$donor['location']}";
            // Display last donation date if available
            if (!empty($donor['last_donation_date'])) {
                $message .= ", Last Donation Date: {$donor['last_donation_date']}";
            }
        }

        // Pagination links
        $total_pages = ceil($total_donors / $records_per_page);
        $pagination_links = "<div class='pagination'>";
        for ($i = 1; $i <= $total_pages; $i++) {
            $active_class = ($i == $page) ? 'active' : '';
            $pagination_links .= "<a href='inventory_management.php?page=$i' class='$active_class'>$i</a>";
        }
        $pagination_links .= "</div>";
    } else {
        // Display message indicating unavailability of desired blood type
        $message = 'No donors found with the requested blood type and location.';
    }
}
?>

<?php include 'includes/header.php'; ?>

<main>
    <div class="container">
        <h2>Find Donors</h2>
        <form method="POST" action="inventory_management.php">
            <label for="blood-type">Blood Type:</label>
            <select id="blood-type" name="blood_type" required>
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
            <input type="text" id="location" name="location" placeholder="Enter Location" required>
            <button type="submit">Find Donors</button>
        </form>
        <div id="message"><?php echo $message; ?></div>
        <?php echo isset($pagination_links) ? $pagination_links : ''; ?>
        <a href="index.php">Go back to home</a>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

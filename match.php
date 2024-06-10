<?php
require 'db.php'; // Include the database connection file

$results = [];
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_type = $_POST['user_type'];
    $blood_type = $_POST['blood_type'];

    $sql = "SELECT * FROM users WHERE user_type = :user_type AND blood_type = :blood_type";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':user_type', $user_type, PDO::PARAM_STR);
    $stmt->bindParam(':blood_type', $blood_type, PDO::PARAM_STR);

    if ($stmt->execute()) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $message = "Error fetching the data.";
    }
}
?>

<?php include 'includes/header.php'; ?>

<main>
    <div class="container">
        <h2>Find Donors/Patients</h2>
        <form id="search-form" method="POST" action="match.php">
            <label for="user-type">I am looking for a:</label>
            <select id="user-type" name="user_type" required>
                <option value="">Select</option>
                <option value="donor">Donor</option>
                <option value="patient">Patient</option>
            </select>
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
            <div class="button-container">
                <button type="submit" class="search-btn">Search</button>
                <button type="button" class="index-btn" onclick="window.location.href='index.php'">Go To Home</button>
            </div>
        </form>

        <?php if (!empty($results)): ?>
            <h3>Search Results:</h3>
            <div class="results">
                <table class="profile-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Blood Type</th>
                            <th>Location</th>
                            <th>Contact Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $result): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($result['name']); ?></td>
                                <td><?php echo htmlspecialchars($result['blood_type']); ?></td>
                                <td><?php echo htmlspecialchars($result['location']); ?></td>
                                <td><?php echo htmlspecialchars($result['contact_number']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <p>No matches found.</p>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

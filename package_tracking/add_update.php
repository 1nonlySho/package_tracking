<?php
include 'db.php';
$message = "";

if(isset($_POST['package_id'], $_POST['update_status'], $_POST['location'])){
    $package_id = $_POST['package_id'];
    $status = $_POST['update_status'];
    $location = $_POST['location'];

    // Insert tracking update
    $stmt = $conn->prepare("INSERT INTO tracking_updates (package_id, update_status, location) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $package_id, $status, $location);
    if($stmt->execute()){
        // Update current package status
        $conn->query("UPDATE packages SET status='$status' WHERE id=$package_id");
        $message = "Update added successfully!";
    } else {
        $message = "Error adding update.";
    }
}

// Get all packages for selection
$packages = $conn->query("SELECT id, tracking_number FROM packages");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Tracking Update</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        input, select, button { padding: 8px; margin: 5px; }
    </style>
</head>
<body>
    <h2>Add Tracking Update</h2>
    <?php if($message) echo "<p>$message</p>"; ?>
    <form method="POST">
        <select name="package_id" required>
            <option value="">Select Package</option>
            <?php while($p = $packages->fetch_assoc()): ?>
                <option value="<?= $p['id'] ?>"><?= $p['tracking_number'] ?></option>
            <?php endwhile; ?>
        </select><br>
        <input type="text" name="update_status" placeholder="Update Status (e.g., In Transit)" required><br>
        <input type="text" name="location" placeholder="Location" required><br>
        <button type="submit">Add Update</button>
    </form>
</body>
</html>

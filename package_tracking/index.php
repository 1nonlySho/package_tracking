<?php
include 'db.php';
$package = null;
$updates = [];

if(isset($_GET['tracking_number'])){
    $tracking_number = $_GET['tracking_number'];

    // Get package info
    $stmt = $conn->prepare("SELECT * FROM packages WHERE tracking_number = ?");
    $stmt->bind_param("s", $tracking_number);
    $stmt->execute();
    $package = $stmt->get_result()->fetch_assoc();

    if($package){
        $pid = $package['id'];
        // Get tracking updates
        $stmt2 = $conn->prepare("SELECT * FROM tracking_updates WHERE package_id = ? ORDER BY update_time ASC");
        $stmt2->bind_param("i", $pid);
        $stmt2->execute();
        $updates = $stmt2->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Package Tracking</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        input, button { padding: 8px; margin: 5px; }
        table { border-collapse: collapse; width: 60%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>Track Your Package</h2>
    <form method="GET">
        <input type="text" name="tracking_number" placeholder="Enter Tracking Number" required>
        <button type="submit">Search</button>
    </form>

    <?php if($package): ?>
        <h3>Package Info</h3>
        <p><strong>Tracking Number:</strong> <?= $package['tracking_number'] ?></p>
        <p><strong>Sender:</strong> <?= $package['sender_name'] ?></p>
        <p><strong>Receiver:</strong> <?= $package['receiver_name'] ?></p>
        <p><strong>Status:</strong> <?= $package['status'] ?></p>

        <h3>Tracking Updates</h3>
        <table>
            <tr>
                <th>Time</th>
                <th>Status</th>
                <th>Location</th>
            </tr>
            <?php foreach($updates as $u): ?>
            <tr>
                <td><?= $u['update_time'] ?></td>
                <td><?= $u['update_status'] ?></td>
                <td><?= $u['location'] ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php elseif(isset($_GET['tracking_number'])): ?>
        <p>No package found with this tracking number.</p>
    <?php endif; ?>
</body>
</html>

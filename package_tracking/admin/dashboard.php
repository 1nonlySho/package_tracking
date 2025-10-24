<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}

if (isset($_POST['add_package'])) {
  $tracking_id = $_POST['tracking_id'];
  $sender = $_POST['sender_name'];
  $receiver = $_POST['receiver_name'];
  $status = "Picked Up";
  $notes = "Package registered in system";
  $date = date('Y-m-d H:i:s');

  $query = "INSERT INTO packages (tracking_id, sender_name, receiver_name, status, last_update, notes)
            VALUES ('$tracking_id', '$sender', '$receiver', '$status', '$date', '$notes')";
  mysqli_query($conn, $query);
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
</head>
<body>
  <h2>Welcome, <?php echo $_SESSION['admin']; ?> 👋</h2>
  <a href="logout.php">Logout</a>

  <h3>Add New Package</h3>
  <form method="POST">
    <input type="text" name="tracking_id" placeholder="Tracking ID" required><br>
    <input type="text" name="sender_name" placeholder="Sender Name"><br>
    <input type="text" name="receiver_name" placeholder="Receiver Name"><br>
    <button type="submit" name="add_package">Add Package</button>
  </form>

  <h3>All Packages</h3>
  <table border="1" cellpadding="8">
    <tr>
      <th>ID</th>
      <th>Tracking ID</th>
      <th>Status</th>
      <th>Last Update</th>
      <th>Action</th>
    </tr>

    <?php
    $result = mysqli_query($conn, "SELECT * FROM packages ORDER BY id DESC");
    while ($row = mysqli_fetch_assoc($result)) {
      echo "<tr>
              <td>{$row['id']}</td>
              <td>{$row['tracking_id']}</td>
              <td>{$row['status']}</td>
              <td>{$row['last_update']}</td>
              <td><a href='update_status.php?id={$row['id']}'>Update</a></td>
            </tr>";
    }
    ?>
  </table>
</body>
</html>

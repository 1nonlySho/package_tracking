<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM packages WHERE id=$id");
$data = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
  $status = $_POST['status'];
  $notes = $_POST['notes'];
  $date = date('Y-m-d H:i:s');
  $query = "UPDATE packages SET status='$status', notes='$notes', last_update='$date' WHERE id=$id";
  mysqli_query($conn, $query);
  header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Update Status</title>
</head>
<body>
  <h2>Update Package Status</h2>

  <form method="POST">
    <label>Status:</label>
    <select name="status">
      <option value="Picked Up">Picked Up</option>
      <option value="Accepted">Accepted</option>
      <option value="In Transit">In Transit</option>
      <option value="At Destination">At Destination</option>
      <option value="Delivered">Delivered</option>
    </select><br>

    <label>Notes:</label><br>
    <textarea name="notes" rows="4" cols="40"><?php echo $data['notes']; ?></textarea><br>
    <button type="submit" name="update">Update</button>
  </form>
</body>
</html>

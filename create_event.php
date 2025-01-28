<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = htmlspecialchars($_POST['title']);
  $description = htmlspecialchars($_POST['description']);
  $date = $_POST['date'];
  $location = htmlspecialchars($_POST['location']);
  $max_capacity = (int)$_POST['max_capacity'];

  $stmt = $pdo->prepare("INSERT INTO events (user_id, title, description, date, location, max_capacity) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->execute([$_SESSION['user_id'], $title, $description, $date, $location, $max_capacity]);
  header("Location: dashboard.php");
}
?>

<div class="container mt-5">
  <h2>Create Event</h2>
  <form method="post">
    <div class="mb-3">
      <input type="text" class="form-control" name="title" placeholder="Event Title" required>
    </div>
    <div class="mb-3">
      <textarea class="form-control" name="description" placeholder="Description"></textarea>
    </div>
    <div class="mb-3">
      <input type="datetime-local" class="form-control" name="date" required>
    </div>
    <div class="mb-3">
      <input type="text" class="form-control" name="location" placeholder="Location" required>
    </div>
    <div class="mb-3">
      <input type="number" class="form-control" name="max_capacity" placeholder="Max Attendees" required>
    </div>
    <button type="submit" class="btn btn-primary">Create Event</button>
  </form>
</div>

<?php include 'includes/footer.php'; ?>
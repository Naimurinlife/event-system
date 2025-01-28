<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

$event_id = $_GET['event_id'];
$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$event_id]);
$event = $stmt->fetch();

// Check capacity
$attendees_stmt = $pdo->prepare("SELECT COUNT(*) FROM attendees WHERE event_id = ?");
$attendees_stmt->execute([$event_id]);
$attendee_count = $attendees_stmt->fetchColumn();

if ($attendee_count >= $event['max_capacity']) {
  die("<div class='alert alert-danger'>Event is full!</div>");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = htmlspecialchars($_POST['name']);
  $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

  $stmt = $pdo->prepare("INSERT INTO attendees (event_id, name, email) VALUES (?, ?, ?)");
  $stmt->execute([$event_id, $name, $email]);
  header("Location: event.php?id=$event_id");
}
?>

<div class="container mt-5">
  <h2>Register for <?= htmlspecialchars($event['title']) ?></h2>
  <form method="post">
    <div class="mb-3">
      <input type="text" class="form-control" name="name" placeholder="Name" required>
    </div>
    <div class="mb-3">
      <input type="email" class="form-control" name="email" placeholder="Email" required>
    </div>
    <button type="submit" class="btn btn-primary">Register</button>
  </form>
</div>

<?php include 'includes/footer.php'; ?>
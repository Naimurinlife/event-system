<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
}

// Fetch event to edit
$event_id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ? AND user_id = ?");
$stmt->execute([$event_id, $_SESSION['user_id']]);
$event = $stmt->fetch();

// Only allow the event creator to edit
if (!$event) {
  die("You don't have permission to edit this event.");
}
?>

<div class="container mt-5">
  <h2>Edit Event</h2>
  <form method="post" action="update_event.php">
    <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
    <div class="mb-3">
      <label>Title</label>
      <input type="text" class="form-control" name="title" value="<?= htmlspecialchars($event['title']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Description</label>
      <textarea class="form-control" name="description"><?= htmlspecialchars($event['description']) ?></textarea>
    </div>
    <div class="mb-3">
      <label>Date</label>
      <input type="datetime-local" class="form-control" name="date" value="<?= date('Y-m-d\TH:i', strtotime($event['date'])) ?>" required>
    </div>
    <div class="mb-3">
      <label>Location</label>
      <input type="text" class="form-control" name="location" value="<?= htmlspecialchars($event['location']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Max Capacity</label>
      <input type="number" class="form-control" name="max_capacity" value="<?= $event['max_capacity'] ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Update Event</button>
  </form>
</div>

<?php include 'includes/footer.php'; ?>
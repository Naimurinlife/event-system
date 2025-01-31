<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

// Display success/error messages
if (isset($_SESSION['success_message'])) {
  echo "<script>alert('" . $_SESSION['success_message'] . "');</script>";
  unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
  echo "<script>alert('" . $_SESSION['error_message'] . "');</script>";
  unset($_SESSION['error_message']);
}

// Check if event ID is provided
if (!isset($_GET['id'])) {
  die("Event ID not specified!");
}

$event_id = $_GET['id'];

// Fetch event details
$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$event_id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
  die("Event not found!");
}

// Fetch attendees
$attendees_stmt = $pdo->prepare("SELECT * FROM attendees WHERE event_id = ?");
$attendees_stmt->execute([$event_id]);
$attendees = $attendees_stmt->fetchAll();
?>

<div class="container mt-5">
  <!-- Event Details Card -->
  <div class="card mb-4">
    <div class="card-body">
      <h1 class="card-title"><?= htmlspecialchars($event['title']) ?></h1>
      <p class="card-text"><?= htmlspecialchars($event['description']) ?></p>
      <ul class="list-group list-group-flush">
        <li class="list-group-item">
          <strong>Date:</strong> <?= date('F j, Y H:i', strtotime($event['date'])) ?>
        </li>
        <li class="list-group-item">
          <strong>Location:</strong> <?= htmlspecialchars($event['location']) ?>
        </li>
        <li class="list-group-item">
          <strong>Capacity:</strong> <?= $event['max_capacity'] ?> attendees
        </li>
      </ul>

      <!-- Edit/Delete Buttons -->
      <?php if ($_SESSION['user_id'] == $event['user_id'] || $_SESSION['is_admin']): ?>
        <div class="mt-3">
          <a href="edit_event.php?id=<?= $event['id'] ?>" class="btn btn-warning">Edit Event</a>
          <button class="btn btn-danger" onclick="confirmDelete(<?= $event['id'] ?>)">Delete Event</button>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Attendees List -->
  <h3>Attendees (<?= count($attendees) ?>)</h3>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Registration Date</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($attendees as $attendee): ?>
        <tr>
          <td><?= htmlspecialchars($attendee['name']) ?></td>
          <td><?= htmlspecialchars($attendee['email']) ?></td>
          <td><?= date('M j, Y', strtotime($attendee['registered_at'])) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- Registration Button & Report Download -->
  <div class="mt-4">
    <a href="register_attendee.php?event_id=<?= $event_id ?>" class="btn btn-success">Register Attendee</a>
    <?php if ($_SESSION['is_admin']): ?>
      <a href="reports.php?event_id=<?= $event_id ?>" class="btn btn-primary">Download CSV</a>
    <?php endif; ?>
  </div>
</div>

<script>
function confirmDelete(eventId) {
  if (confirm("Are you sure you want to delete this event?")) {
    window.location.href = `delete_event.php?id=${eventId}`;
  }
}
</script>

<?php include 'includes/footer.php'; ?>
<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

// Display messages
if (isset($_SESSION['success_message'])) {
  echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
  unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
  echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
  unset($_SESSION['error_message']);
}

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
}

// Fetch events
$stmt = $pdo->prepare("SELECT * FROM events ORDER BY date DESC");
$stmt->execute();
$events = $stmt->fetchAll();
?>

<div class="container mt-5">
  <h2>Events Dashboard</h2>
  <a href="create_event.php" class="btn btn-success mb-3">Create New Event</a>
  <div class="row">
    <?php foreach ($events as $event): ?>
      <div class="col-md-4 mb-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($event['title']) ?></h5>
            <p class="card-text"><?= htmlspecialchars($event['description']) ?></p>
            <p class="card-text">
              <small class="text-muted">
                <?= date('M j, Y H:i', strtotime($event['date'])) ?>
              </small>
            </p>
            <a href="event.php?id=<?= $event['id'] ?>" class="btn btn-primary">View Event</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
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

// Get search term
$search = isset($_GET['search']) ? "%{$_GET['search']}%" : '%';

// Fetch events with search filter
$stmt = $pdo->prepare("
  SELECT * FROM events 
  WHERE title LIKE :search 
  OR description LIKE :search 
  OR location LIKE :search 
  ORDER BY date DESC
");
$stmt->bindParam(':search', $search, PDO::PARAM_STR);
$stmt->execute();
$events = $stmt->fetchAll();
?>

<div class="container mt-5">
  <h2>Events Dashboard</h2>
  
  <!-- Search Form -->
  <form method="GET" class="mb-4">
    <div class="input-group">
      <input 
        type="text" 
        name="search" 
        class="form-control" 
        placeholder="Search events by title, description, or location..."
        value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"
      >
      <button type="submit" class="btn btn-primary">Search</button>
    </div>
  </form>

  <a href="create_event.php" class="btn btn-success mb-3">Create New Event</a>
  
  <div class="row">
    <?php if (count($events) > 0): ?>
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
    <?php else: ?>
      <div class="col-12">
        <div class="alert alert-info">No events found.</div>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
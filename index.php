<?php
session_start();
include 'includes/header.php';
?>

<div class="container mt-5">
  <div class="jumbotron text-center">
    <h1 class="display-4">Welcome to Event Manager</h1>
    <p class="lead">Create, manage, and track events effortlessly.</p>
    <hr class="my-4">
    <?php if (!isset($_SESSION['user_id'])): ?>
      <p>Get started by logging in or signing up.</p>
      <a class="btn btn-primary btn-lg" href="login.php" role="button">Login</a>
      <a class="btn btn-success btn-lg" href="register.php" role="button">Sign Up</a>
    <?php else: ?>
      <p>Go to your dashboard to manage events.</p>
      <a class="btn btn-dark btn-lg" href="dashboard.php" role="button">Dashboard</a>
    <?php endif; ?>
  </div>

  <!-- Feature Highlights -->
  <div class="row mt-5">
    <div class="col-md-4">
      <h3>Create Events</h3>
      <p>Easily create events with details like date, location, and capacity.</p>
    </div>
    <div class="col-md-4">
      <h3>Track Attendees</h3>
      <p>Manage registrations and download attendee reports as CSV.</p>
    </div>
    <div class="col-md-4">
      <h3>Secure</h3>
      <p>Built with secure authentication and validation.</p>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
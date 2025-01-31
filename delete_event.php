<?php
session_start();
include 'includes/db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

// Check event ID
if (!isset($_GET['id'])) {
  $_SESSION['error_message'] = "Event ID missing!";
  header("Location: dashboard.php");
  exit;
}

$event_id = $_GET['id'];

try {
  // Verify event exists and user permissions
  $stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
  $stmt->execute([$event_id]);
  $event = $stmt->fetch();

  if (!$event) {
    $_SESSION['error_message'] = "Event not found!";
    header("Location: dashboard.php");
    exit;
  }

  // Check if user is owner/admin
  if ($_SESSION['user_id'] != $event['user_id'] && !$_SESSION['is_admin']) {
    $_SESSION['error_message'] = "You don't have permission!";
    header("Location: dashboard.php");
    exit;
  }

  // Delete attendees first
  $pdo->prepare("DELETE FROM attendees WHERE event_id = ?")->execute([$event_id]);

  // Delete event
  $pdo->prepare("DELETE FROM events WHERE id = ?")->execute([$event_id]);

  $_SESSION['success_message'] = "Event deleted successfully!";
  header("Location: dashboard.php");
  exit;

} catch (PDOException $e) {
  $_SESSION['error_message'] = "Error: " . $e->getMessage();
  header("Location: dashboard.php");
  exit;
}
?>
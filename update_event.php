<?php
session_start();
include 'includes/db.php';

// Check authentication
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

// Process form data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $event_id = $_POST['event_id'];
  $title = htmlspecialchars($_POST['title']);
  $description = htmlspecialchars($_POST['description']);
  $date = $_POST['date'];
  $location = htmlspecialchars($_POST['location']);
  $max_capacity = (int)$_POST['max_capacity'];

  // Update event (only if user owns it)
  $stmt = $pdo->prepare("UPDATE events SET title = ?, description = ?, date = ?, location = ?, max_capacity = ? WHERE id = ? AND user_id = ?");
  $stmt->execute([$title, $description, $date, $location, $max_capacity, $event_id, $_SESSION['user_id']]);

  // Set success message in session
  $_SESSION['success_message'] = "Event updated successfully!";

  // Redirect back to the event view page
  header("Location: event.php?id=$event_id");
  exit;
} else {
  // If not a POST request, redirect to dashboard
  header("Location: dashboard.php");
  exit;
}
?>
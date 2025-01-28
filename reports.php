<?php
session_start();
include 'includes/db.php';

// Admin check
if (!$_SESSION['is_admin']) {
  die("Access denied!");
}

$event_id = $_GET['event_id'];
$stmt = $pdo->prepare("SELECT * FROM attendees WHERE event_id = ?");
$stmt->execute([$event_id]);
$attendees = $stmt->fetchAll();

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="attendees.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['Name', 'Email', 'Registration Date']);

foreach ($attendees as $attendee) {
  fputcsv($output, [$attendee['name'], $attendee['email'], $attendee['registered_at']]);
}
fclose($output);
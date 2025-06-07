<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Please login first");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $blood_type = $_POST['blood_type'];
    $location = $_POST['location'];
    $phone = $_POST['phone'];
    $donation_date = $_POST['donation_date'];

    // Check if user is already a donor
    $stmt = $conn->prepare("SELECT donor_id FROM donors WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        die("You are already registered as a donor");
    }

    // Insert new donor
    $stmt = $conn->prepare("INSERT INTO donors (user_id, blood_type, location, phone, last_donation_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_id, $blood_type, $location, $phone, $donation_date);

    if ($stmt->execute()) {
        header("Location: index.php?page=home");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
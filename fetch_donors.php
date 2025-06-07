<?php
require_once 'config.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT u.full_name, d.blood_type, d.location, d.phone, d.last_donation_date 
          FROM donors d
          JOIN users u ON d.user_id = u.user_id
          WHERE d.is_available = TRUE";

if (!empty($search)) {
    $query .= " AND (d.location LIKE '%$search%' OR d.blood_type LIKE '%$search%')";
}

$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="receiver-card">';
        echo '<h3>' . htmlspecialchars($row['full_name']) . '</h3>';
        echo '<p><span class="blood-badge">' . htmlspecialchars($row['blood_type']) . '</span></p>';
        echo '<p><strong>Location:</strong> ' . htmlspecialchars($row['location']) . '</p>';
        echo '<p><strong>Last Donation:</strong> ' . htmlspecialchars($row['last_donation_date']) . '</p>';
        echo '<p><strong>Contact:</strong> ' . htmlspecialchars($row['phone']) . '</p>';
        echo '<a href="#" class="btn" style="margin-top: 10px; display: inline-block;">Request Donation</a>';
        echo '</div>';
    }
} else {
    echo '<p>No donors found</p>';
}

$conn->close();
?>
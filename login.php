<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id, email, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            // close resources before redirecting
            $stmt->close();
            $conn->close();
            
            header("Location: index.php?page=home");
            exit();
        } else {
            // close resources before terminating
            $stmt->close();
            $conn->close();
            die("Invalid password");
        }
    } else {
        // close resources before terminating
        $stmt->close();
        $conn->close();
        die("User not found");
    }
}
?>
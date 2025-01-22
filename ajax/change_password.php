<?php
session_start();
require_once '../includes/db.php'; // Update this path based on your project structure

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];

    // Ensure the user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo 'You are not logged in.';
        exit;
    }

    $userId = $_SESSION['user_id'];

    // Fetch current password from the database
    $query = "SELECT password FROM employees WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($dbPassword);
    $stmt->fetch();

    // Verify current password
    if (!password_verify($currentPassword, $dbPassword)) {
        echo 'Current password is incorrect.';
        exit;
    }

    // Hash the new password
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

    // Update the new password in the database
    $updateQuery = "UPDATE employees SET password = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param('si', $hashedPassword, $userId);

    if ($updateStmt->execute()) {
        echo 'Password updated successfully!';
    } else {
        echo 'Failed to update password.';
    }

    $updateStmt->close();
    $stmt->close();
    $conn->close();
}
?>

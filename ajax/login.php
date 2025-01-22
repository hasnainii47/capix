<?php
include '../includes/db.php';

header('Content-Type: application/json');

$email = $_POST['email'];
$password = $_POST['password'];

// Prepare and execute the SQL query securely
$sql = "SELECT id, name, password, role FROM employees WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $employee = $result->fetch_assoc();
    // Verify the provided password with the hashed password in the database
    if (password_verify($password, $employee['password'])) {
        // Start a session and store user information
        session_start();
        $_SESSION['user_id'] = $employee['id'];
        $_SESSION['name'] = $employee['name'];
        $_SESSION['role'] = $employee['role'];
        
        // Redirect to dashboard.php after login
        echo json_encode(['success' => true, 'message' => 'Login successful.']);

        exit; // Stop further execution after redirection
    } else {
        // Return an error if the password is invalid
        echo json_encode(['success' => false, 'message' => 'Invalid password.']);
    }
} else {
    // Return an error if the user is not found
    echo json_encode(['success' => false, 'message' => 'User not found.']);
}

// Close the prepared statement and connection
$stmt->close();
$conn->close();
?>

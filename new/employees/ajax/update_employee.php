<?php
include '../../../includes/db.php';

// Validate and sanitize inputs
$id = intval($_POST['id']); // Ensure it's an integer
$name = $conn->real_escape_string(trim($_POST['employeeName']));
$email = $conn->real_escape_string(trim($_POST['employeeEmail']));
$phone = $conn->real_escape_string(trim($_POST['employeePhone']));
$department_id = intval($_POST['employeeDepartment']); // Ensure it's an integer

// SQL query with sanitized input
$sql = "UPDATE employees 
        SET name = '$name', email = '$email', phone = '$phone', department_id = $department_id 
        WHERE id = $id";

// Execute the query and check the result
if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => true, "message" => "Employee updated successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Error updating record: " . $conn->error]);
}
?>

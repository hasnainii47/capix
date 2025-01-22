<?php
include '../../../includes/db.php';
$plainPassword = "12345";
$default_password = password_hash($plainPassword, PASSWORD_BCRYPT);
$name = $_POST['employeeName'];
$email = $_POST['employeeEmail'];
$phone = $_POST['employeePhone'];
$department_id = $_POST['employeeDepartment'];

$sql = "INSERT INTO employees (name, email, phone, department_id, password) VALUES ('$name', '$email', '$phone', $department_id, '$default_password')";

if ($conn->query($sql) === TRUE) {
    echo "Employee added successfully.";
} else {
    echo "Error: " . $conn->error;
}
?>

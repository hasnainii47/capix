<?php
include '../../../includes/db.php';

$id = $_POST['id'];
$name = $_POST['employeeName'];
$email = $_POST['employeeEmail'];
$phone = $_POST['employeePhone'];
$department_id = $_POST['employeeDepartment'];

$sql = "UPDATE employees 
        SET name = '$name', email = '$email', phone = '$phone', department_id = $department_id 
        WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "Employee updated successfully.";
} else {
    echo "Error updating record: " . $conn->error;
}
?>

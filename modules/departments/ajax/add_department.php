<?php
include '../../../includes/db.php';

$name = $_POST['departmentName'];
$sql = "INSERT INTO departments (name) VALUES ('$name')";

if ($conn->query($sql) === TRUE) {
    echo "Department added successfully.";
} else {
    echo "Error: " . $conn->error;
}
?>

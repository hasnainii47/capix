<?php
include '../../../includes/db.php';

$id = $_POST['id'];
$name = $_POST['departmentName'];

$sql = "UPDATE departments SET name = '$name' WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "Department updated successfully.";
} else {
    echo "Error updating record: " . $conn->error;
}
?>

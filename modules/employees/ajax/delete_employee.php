<?php
include '../../../includes/db.php';

$id = $_POST['id'];

$sql = "DELETE FROM employees WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "Employee deleted successfully.";
} else {
    echo "Error deleting record: " . $conn->error;
}
?>

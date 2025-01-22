<?php
include '../../../includes/db.php';

$id = $_POST['id'];

$sql = "DELETE FROM departments WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "Department deleted successfully.";
} else {
    echo "Error deleting record: " . $conn->error;
}
?>

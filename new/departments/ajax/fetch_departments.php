<?php
include '../../../includes/db.php';

$sql = "SELECT * FROM departments";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table class="table table-bordered">';
    echo '<thead><tr><th>ID</th><th>Name</th><th>Actions</th></tr></thead>';
    echo '<tbody>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['name'] . '</td>';
        echo '<td>
                <button class="btn btn-sm btn-warning edit-department" data-id="' . $row['id'] . '">Edit</button>
                <button class="btn btn-sm btn-danger delete-department" data-id="' . $row['id'] . '">Delete</button>
              </td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
} else {
    echo 'No departments found.';
}
?>

<?php
include '../../../includes/db.php';

$sql = "SELECT e.id, e.name, e.email, e.phone, d.name AS department_name
        FROM employees e
        LEFT JOIN departments d ON e.department_id = d.id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table class="table table-bordered">';
    echo '<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Department</th><th>Actions</th></tr></thead>';
    echo '<tbody>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['name'] . '</td>';
        echo '<td>' . $row['email'] . '</td>';
        echo '<td>' . $row['phone'] . '</td>';
        echo '<td>' . $row['department_name'] . '</td>';
        echo '<td>
                <button class="btn btn-sm btn-warning edit-employee" data-id="' . $row['id'] . '">Edit</button>
                <button class="btn btn-sm btn-danger delete-employee" data-id="' . $row['id'] . '">Delete</button>
              </td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
} else {
    echo 'No employees found.';
}
?>

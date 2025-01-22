<?php
include '../../../includes/db.php';

$id = $_GET['id'];

$sql = "SELECT * FROM employees WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if ($data) {
    // Fetch departments for dropdown
    $departments = "";
    $deptSql = "SELECT id, name FROM departments";
    $deptResult = $conn->query($deptSql);

    while ($row = $deptResult->fetch_assoc()) {
        $selected = $data['department_id'] == $row['id'] ? 'selected' : '';
        $departments .= "<option value='{$row['id']}' $selected>{$row['name']}</option>";
    }

    $data['departmentsOptions'] = $departments;
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'Employee not found.']);
}
?>

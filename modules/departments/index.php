<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Departments</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container mt-4">
    <h1>Manage Departments</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDepartmentModal">Add Department</button>
    <div id="departmentsTable"></div>
</div>

<!-- Add Department Modal -->
<div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="addDepartmentForm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDepartmentLabel">Add Department</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="departmentName" class="form-label">Department Name</label>
                    <input type="text" class="form-control" id="departmentName" name="departmentName" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function () {
    fetchDepartments();

    $('#addDepartmentForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: 'ajax/add_department.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                $('#addDepartmentModal').modal('hide');
                fetchDepartments();
                alert(response);
            }
        });
    });

    function fetchDepartments() {
        $.ajax({
            url: 'ajax/fetch_departments.php',
            method: 'GET',
            success: function (data) {
                $('#departmentsTable').html(data);
            }
        });
    }
    $(document).on('click', '.edit-department', function () {
    const id = $(this).data('id');
    const departmentName = prompt("Enter new department name:");

    if (departmentName) {
        $.ajax({
            url: 'ajax/update_department.php',
            method: 'POST',
            data: { id: id, departmentName: departmentName },
            success: function (response) {
                alert(response);
                fetchDepartments(); // Refresh the list
            }
        });
    }
});
$(document).on('click', '.delete-department', function () {
    const id = $(this).data('id');

    if (confirm("Are you sure you want to delete this department?")) {
        $.ajax({
            url: 'ajax/delete_department.php',
            method: 'POST',
            data: { id: id },
            success: function (response) {
                alert(response);
                fetchDepartments(); // Refresh the list
            }
        });
    }
});


});
</script>
</body>
</html>

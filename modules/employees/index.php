<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Employees</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container mt-4">
    <h1>Manage Employees</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">Add Employee</button>
    <div id="employeesTable"></div>
</div>

<!-- Add Employee Modal -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="addEmployeeForm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEmployeeLabel">Add Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="employeeName" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="employeeName" name="employeeName" required>
                </div>
                <div class="mb-3">
                    <label for="employeeEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="employeeEmail" name="employeeEmail" required>
                </div>
                <div class="mb-3">
                    <label for="employeePhone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="employeePhone" name="employeePhone" required>
                </div>
                <div class="mb-3">
                    <label for="employeeDepartment" class="form-label">Department</label>
                    <select id="employeeDepartment" name="employeeDepartment" class="form-control">
                        <!-- Options loaded dynamically -->
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </div>
    </form>
  </div>
</div>
<!-- Edit Employee Modal -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="editEmployeeLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editEmployeeForm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEmployeeLabel">Edit Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editEmployeeId" name="id">
                <div class="mb-3">
                    <label for="editEmployeeName" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="editEmployeeName" name="employeeName" required>
                </div>
                <div class="mb-3">
                    <label for="editEmployeeEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="editEmployeeEmail" name="employeeEmail" required>
                </div>
                <div class="mb-3">
                    <label for="editEmployeePhone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="editEmployeePhone" name="employeePhone" required>
                </div>
                <div class="mb-3">
                    <label for="editEmployeeDepartment" class="form-label">Department</label>
                    <select id="editEmployeeDepartment" name="employeeDepartment" class="form-control">
                        <!-- Options will be loaded dynamically -->
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </form>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function () {
    fetchDepartmentsForEmployee();
    fetchEmployees();

    $('#addEmployeeForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: 'ajax/add_employee.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                $('#addEmployeeModal').modal('hide');
                fetchEmployees();
                alert(response);
            }
        });
    });

    function fetchDepartmentsForEmployee() {
        $.ajax({
            url: '../employees/ajax/fetch_departments_dropdown.php',
            method: 'GET',
            success: function (data) {
                $('#employeeDepartment').html(data);
            }
        });
    }

    function fetchEmployees() {
        $.ajax({
            url: 'ajax/fetch_employees.php',
            method: 'GET',
            success: function (data) {
                $('#employeesTable').html(data);
            }
        });
    }
    
    $(document).on('click', '.delete-employee', function () {
    const id = $(this).data('id');

    if (confirm("Are you sure you want to delete this employee?")) {
        $.ajax({
            url: 'ajax/delete_employee.php',
            method: 'POST',
            data: { id: id },
            success: function (response) {
                alert(response);
                fetchEmployees(); // Refresh the list
            }
        });
    }
});

$(document).on('click', '.edit-employee', function () {
    const id = $(this).data('id');

    // Fetch employee details
    $.ajax({
        url: 'ajax/get_employee.php',
        method: 'GET',
        data: { id: id },
        dataType: 'json',
        success: function (data) {
            // Populate modal fields with existing data
            $('#editEmployeeId').val(data.id);
            $('#editEmployeeName').val(data.name);
            $('#editEmployeeEmail').val(data.email);
            $('#editEmployeePhone').val(data.phone);
            $('#editEmployeeDepartment').html(data.departmentsOptions); // Options with selected
            $('#editEmployeeModal').modal('show'); // Show the modal
        },
        error: function () {
            alert('Failed to fetch employee data.');
        }
    });
});

// Handle form submission for editing
$('#editEmployeeForm').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
        url: 'ajax/update_employee.php',
        method: 'POST',
        data: $(this).serialize(),
        success: function (response) {
            $('#editEmployeeModal').modal('hide');
            alert(response);
            fetchEmployees(); // Refresh the list
        },
        error: function () {
            alert('Failed to update employee.');
        }
    });
});

   

});

 
</script>
</body>
</html>

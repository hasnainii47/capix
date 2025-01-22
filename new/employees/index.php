<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            color: #fff;
        }
        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
        }
        .sidebar a:hover {
            color: #fff;
        }
        .active {
            background-color: #495057;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky">
                    <ul class="nav flex-column pt-3">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="bi bi-house-door"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-people"></i> Employees
                            </a>
                        </li>
                        <!-- Add more links as needed -->
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Employees</h1>
                    <button id="addEmployeeBtn" class="btn btn-primary">Add Employee</button>
                </div>

                <!-- Employee Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Department</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="employeeTable">
                            <!-- AJAX Content -->
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <!-- Add/Edit Employee Modal -->
    <div class="modal fade" id="employeeModal" tabindex="-1" aria-labelledby="employeeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="employeeModalLabel">Add Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="employeeForm">
                    <div class="modal-body">
                        <input type="hidden" id="employeeId">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="department" class="form-label">Department</label>
                            <input type="text" class="form-control" id="department" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            function fetchEmployees() {
                $.post('api.php', { action: 'read' }, function (data) {
                    let employees = JSON.parse(data);
                    let rows = '';
                    employees.forEach(employee => {
                        rows += `
                        <tr>
                            <td>${employee.id}</td>
                            <td>${employee.name}</td>
                            <td>${employee.email}</td>
                            <td>${employee.phone}</td>
                            <td>${employee.department}</td>
                            <td>
                                <button class="btn btn-warning btn-sm editEmployee" data-id="${employee.id}" data-name="${employee.name}" data-email="${employee.email}" data-phone="${employee.phone}" data-department="${employee.department}">Edit</button>
                                <button class="btn btn-danger btn-sm deleteEmployee" data-id="${employee.id}">Delete</button>
                            </td>
                        </tr>`;
                    });
                    $('#employeeTable').html(rows);
                });
            }

            fetchEmployees();

            // Open Add Employee Modal
            $('#addEmployeeBtn').click(function () {
                $('#employeeModalLabel').text('Add Employee');
                $('#employeeForm')[0].reset();
                $('#employeeId').val('');
                $('#employeeModal').modal('show');
            });

            // Add/Edit Employee
            $('#employeeForm').submit(function (e) {
                e.preventDefault();
                let action = $('#employeeId').val() ? 'update' : 'create';
                let employeeData = {
                    action: action,
                    id: $('#employeeId').val(),
                    name: $('#name').val(),
                    email: $('#email').val(),
                    phone: $('#phone').val(),
                    department: $('#department').val()
                };
                $.post('api.php', employeeData, function () {
                    $('#employeeModal').modal('hide');
                    fetchEmployees();
                });
            });

            // Edit Employee
            $(document).on('click', '.editEmployee', function () {
                $('#employeeModalLabel').text('Edit Employee');
                $('#employeeId').val($(this).data('id'));
                $('#name').val($(this).data('name'));
                $('#email').val($(this).data('email'));
                $('#phone').val($(this).data('phone'));
                $('#department').val($(this).data('department'));
                $('#employeeModal').modal('show');
            });

            // Delete Employee
            $(document).on('click', '.deleteEmployee', function () {
                if (confirm('Are you sure you want to delete this employee?')) {
                    let employeeId = $(this).data('id');
                    $.post('api.php', { action: 'delete', id: employeeId }, function () {
                        fetchEmployees();
                    });
                }
            });
        });
    </script>
</body>
</html>

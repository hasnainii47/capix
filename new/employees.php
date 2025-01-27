<?php
include "../includes/db.php";
$msg = '';

// Add Employee
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department_id = $_POST['department_id'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $role = $_POST['role'];

    // Prepare the SQL query
    $query = "INSERT INTO employees (name, email, phone, department_id, password, role) VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("sssiss", $name, $email, $phone, $department_id, $password, $role);

        if ($stmt->execute()) {
            $msg = "<div class='alert alert-success'>Employee Has Been Added Successfully.</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Something Went Wrong.</div>" . $stmt->error;
        }

        $stmt->close();
    } else {
        $msg = "<div class='alert alert-danger'>Failed to prepare statement.</div>" . $conn->error;
    }
}

// Edit Employee
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department_id = $_POST['department_id'];
    $role = $_POST['role'];

    $query = "UPDATE employees SET name = ?, email = ?, phone = ?, department_id = ?, role = ? WHERE id = ?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("sssisi", $name, $email, $phone, $department_id, $role, $id);

        if ($stmt->execute()) {
            $msg = "<div class='alert alert-success'>Employee Has Been Updated Successfully.</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Something Went Wrong.</div>" . $stmt->error;
        }

        $stmt->close();
    } else {
        $msg = "<div class='alert alert-danger'>Failed to prepare statement.</div>" . $conn->error;
    }
}

// Delete Employee
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $query = "DELETE FROM employees WHERE id = ?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $msg = "<div class='alert alert-success'>Employee Has Been Deleted Successfully.</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Something Went Wrong.</div>" . $stmt->error;
        }

        $stmt->close();
    } else {
        $msg = "<div class='alert alert-danger'>Failed to prepare statement.</div>" . $conn->error;
    }
}

$mysqli = mysqli_connect('localhost', $user, $pass, $dbname);
$quer = "SELECT * FROM employees ORDER BY id DESC";
$total_pages = $mysqli->query($quer)->num_rows;

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$num_results_on_page = 25;
$que = "SELECT employees.*, departments.name AS department_name FROM employees LEFT JOIN departments ON employees.department_id = departments.id ORDER BY employees.id DESC LIMIT ?, ?";

if ($stmt = $mysqli->prepare($que)) {
    $calc_page = ($page - 1) * $num_results_on_page;
    $stmt->bind_param('ii', $calc_page, $num_results_on_page);
    $stmt->execute();
    $result = $stmt->get_result();
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include "inc/head.php"; ?>
</head>
<body class="inner_page widgets">
<div class="full_container">
    <div class="inner_container">
        <?php include "inc/sidebar.php"; ?>
        <div id="content">
            <?php include "inc/topbar.php"; ?>
            <div class="midde_cont">
                <div class="container-fluid">
                    <div class="row column_title">
                        <div class="col-md-12">
                            <div class="page_title">
                                <h2>Employees List</h2>
                            </div>
                        </div>
                    </div>
                    <button class="btn mb-2 btn-success" data-toggle="modal" data-target="#addemployee">Add New Employee</button>
                    <div class="modal fade" id="addemployee">
                        <div class="modal-dialog modal-lg">
                            <form method="POST">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Add New Employee</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label>Name:</label>
                                                <input class="form-control" name="name" required placeholder="Enter Name">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Email:</label>
                                                <input class="form-control" name="email" required placeholder="Enter Email">
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <label>Phone:</label>
                                                <input class="form-control" name="phone" required placeholder="Enter Phone">
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <label>Department:</label>
                                                <select class="form-control" name="department_id" required>
                                                    <?php
                                                    $dept_result = $conn->query("SELECT * FROM departments");
                                                    while ($row = $dept_result->fetch_assoc()) {
                                                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <label>Password:</label>
                                                <input type="password" class="form-control" name="password" required placeholder="Enter Password">
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <label>Role:</label>
                                                <input class="form-control" name="role" required placeholder="Enter Role">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="add">Save Record</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="white_shd full margin_bottom_30">
                                <?php if (isset($msg)) echo $msg; ?>
                                <div class="table_section padding_infor_info">
                                    <table class="table">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Department</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?php echo $row['id']; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['phone']; ?></td>
                                                <td><?php echo $row['department_name']; ?></td>
                                                <td><?php echo $row['role']; ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editEmployee<?php echo $row['id']; ?>"><i class="fa fa-edit"></i></button>
                                                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteEmployee<?php echo $row['id']; ?>"><i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="editEmployee<?php echo $row['id']; ?>">
                                                <div class="modal-dialog modal-lg">
                                                    <form method="POST">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Edit Employee</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                    <div class="col-md-6">
                                                                        <label>Name:</label>
                                                                        <input class="form-control" name="name" required value="<?php echo $row['name']; ?>">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label>Email:</label>
                                                                        <input class="form-control" name="email" required value="<?php echo $row['email']; ?>">
                                                                    </div>
                                                                    <div class="col-md-6 mt-2">
                                                                        <label>Phone:</label>
                                                                        <input class="form-control" name="phone" required value="<?php echo $row['phone']; ?>">
                                                                    </div>
                                                                    <div class="col-md-6 mt-2">
                                                                        <label>Department:</label>
                                                                        <select class="form-control" name="department_id" required>
                                                                            <?php
                                                                            $dept_result = $conn->query("SELECT * FROM departments");
                                                                            while ($dept_row = $dept_result->fetch_assoc()) {
                                                                                $selected = ($dept_row['id'] == $row['department_id']) ? "selected" : "";
                                                                                echo "<option value='{$dept_row['id']}' $selected>{$dept_row['name']}</option>";
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-6 mt-2">
                                                                        <label>Role:</label>
                                                                        <input class="form-control" name="role" required value="<?php echo $row['role']; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary" name="edit">Save Changes</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteEmployee<?php echo $row['id']; ?>">
                                                <div class="modal-dialog">
                                                    <form method="POST">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Delete Employee</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete this employee?
                                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
                                    <ul class="pagination">
                                        <?php if ($page > 1): ?>
                                            <li><a href="?page=<?php echo $page - 1; ?>">Prev</a></li>
                                        <?php endif; ?>
                                        <?php for ($i = 1; $i <= ceil($total_pages / $num_results_on_page); $i++): ?>
                                            <li><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                        <?php endfor; ?>
                                        <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                                            <li><a href="?page=<?php echo $page + 1; ?>">Next</a></li>
                                        <?php endif; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include "inc/footer.php"; ?>
            </div>
        </div>
    </div>
</div>
<?php include "inc/scripts.php"; ?>
</body>
</html>
<?php
$stmt->close();
}
?>

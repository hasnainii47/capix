<?php
include "../includes/db.php";
$msg = '';
if (isset($_POST['add'])) {
    $name = $_POST['name'];

    // Prepare the SQL query
    $queryy = "INSERT INTO departments (name) VALUES (?)";

    // Initialize the prepared statement
    if ($stmt = $conn->prepare($queryy)) {
        // Bind the parameter
        $stmt->bind_param("s", $name); // "s" indicates the type is a string

        // Execute the query
        if ($stmt->execute()) {
            $msg = "<div class='alert alert-success'>Department Has Been Added Successfully.</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Something Went Wrong.</div>" . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        $msg = "<div class='alert alert-danger'>Failed to prepare statement.</div>" . $conn->error;
    }
}

if (isset($_POST['edit'])) {
    // Get the id and name from the form
    $id = $_POST['id'];
    $name = $_POST['name'];

    // Prepare the SQL query
    $query = "UPDATE departments SET name = ? WHERE id = ?";

    // Initialize the prepared statement
    if ($stmt = $conn->prepare($query)) {
        // Bind the parameters
        $stmt->bind_param("si", $name, $id); // "s" for string, "i" for integer

        // Execute the query
        if ($stmt->execute()) {
            $msg = "<div class='alert alert-success'>Department Has Been Updated Successfully.</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Something Went Wrong.</div>" . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        $msg = "<div class='alert alert-danger'>Failed to prepare statement.</div>" . $conn->error;
    }
}

if (isset($_POST['delete'])) {
    // Get the id from the form
    $id = $_POST['id'];

    // Prepare the SQL query
    $query = "DELETE FROM departments WHERE id = ?";

    // Initialize the prepared statement
    if ($stmt = $conn->prepare($query)) {
        // Bind the parameters
        $stmt->bind_param("i", $id); // "i" for integer (id)

        // Execute the query
        if ($stmt->execute()) {
            $msg = "<div class='alert alert-success'>Department Has Been Deleted Successfully.</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Something Went Wrong.</div>" . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        $msg = "<div class='alert alert-danger'>Failed to prepare statement.</div>" . $conn->error;
    }
}

// Database connection
$mysqli = mysqli_connect('localhost', $user, $pass, $dbname);

// Pagination query for departments
$quer = "SELECT * FROM departments ORDER BY id DESC";
$total_pages = $mysqli->query($quer)->num_rows;

// Check if the page number is specified
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Number of results to show on each page
$num_results_on_page = 25;
$que = "SELECT * FROM departments ORDER BY id DESC LIMIT ?,?";

if ($stmt = $mysqli->prepare($que)) {
    $calc_page = ($page - 1) * $num_results_on_page;
    $stmt->bind_param('ii', $calc_page, $num_results_on_page);
    $stmt->execute();
    $result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<?php include "inc/head.php"; ?>
<body class="inner_page widgets">
    <div class="full_container">
        <div class="inner_container">
            <!-- Sidebar --> <?php include "inc/sidebar.php"; ?><!-- End sidebar -->
            <!-- Right content -->
            <div id="content">
                <!-- Topbar --><?php include "inc/topbar.php"; ?> <!-- End topbar -->
                <!-- Dashboard inner -->
                <div class="midde_cont">
                    <div class="container-fluid">
                        <div class="row column_title">
                            <div class="col-md-12">
                                <div class="page_title">
                                    <h2>Departments List</h2>
                                </div>
                            </div>
                        </div>
                        <button class="btn mb-2 btn-success" data-toggle="modal" data-target="#addDepartment">Add New Department</button>

                        <!-- Add New Department Modal -->
                        <div class="modal fade" id="addDepartment">
                            <div class="modal-dialog modal-lg">
                                <form method="POST">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Add New Department</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-2">
                                                <div class="col-md-12 mt-2">
                                                    <label for="name" class="form-label">Name:</label>
                                                    <input class="form-control" required="required" name="name" type="text" placeholder="Enter department name">
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

                        <!-- Main Content -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <?php if (isset($msg)) { echo $msg; } ?>
                                    <div class="table_section padding_infor_info">
                                        <div class="table-responsive-sm">
                                            <table class="table">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while ($rrow = $result->fetch_assoc()): ?>
                                                    <tr>
                                                        <td><?php echo $rrow['id']; ?></td>
                                                        <td><?php echo $rrow['name']; ?></td>
                                                        <td>
                                                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editDepartment<?php echo $rrow['id']; ?>"><i class="fa fa-edit"></i></button>
                                                            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteDepartment<?php echo $rrow['id']; ?>"><i class="fa fa-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                    <!-- Edit Department Modal -->
                                                    <div class="modal fade" id="editDepartment<?php echo $rrow['id']; ?>">
                                                        <div class="modal-dialog modal-lg">
                                                            <form method="POST">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Update Department</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row mb-2">
                                                                            <div class="col-md-12 mt-2">
                                                                                <label for="name" class="form-label">Name:</label>
                                                                                <input type="hidden" name="id" value="<?php echo $rrow['id']; ?>">
                                                                                <input class="form-control" required="required" name="name" type="text" placeholder="Enter department name" value="<?php echo $rrow['name']; ?>">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary" name="edit">Save Record</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <!-- Delete Department Modal -->
                                                    <div class="modal fade" id="deleteDepartment<?php echo $rrow['id']; ?>">
                                                        <div class="modal-dialog modal-md">
                                                            <form method="POST">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Delete Department</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Are you sure you want to delete this department?</p>
                                                                        <input type="hidden" name="id" value="<?php echo $rrow['id']; ?>">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-danger" name="delete">Yes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <?php endwhile; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- Pagination -->
                                    <?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
                                    <ul class="pagination">
                                        <?php if ($page > 1): ?>
                                        <li><a href="departments_list.php?page=<?php echo $page - 1 ?>">Prev</a></li>
                                        <?php endif; ?>
                                        <?php for ($i = 1; $i <= ceil($total_pages / $num_results_on_page); $i++): ?>
                                        <li><a href="departments_list.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                                        <?php endfor; ?>
                                        <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                                        <li><a href="departments_list.php?page=<?php echo $page + 1 ?>">Next</a></li>
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

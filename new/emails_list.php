<?php
include "../includes/db.php";
$msg='';
if (isset($_POST['add'])) {
    $email = $_POST['email'];

    // Prepare the SQL query
    $queryy = "INSERT INTO lead (email) VALUES (?)";

    // Initialize the prepared statement
    if ($stmt = $conn->prepare($queryy)) {
        // Bind the parameter
        $stmt->bind_param("s", $email); // "s" indicates the type is a string

        // Execute the query
        if ($stmt->execute()) {
            $msg = "<div class='alert alert-success'>Email Has Been Added Successfully.</div>";
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
    // Get the id and email from the form
    $id = $_POST['id'];
    $email = $_POST['email'];

    // Prepare the SQL query
    $query = "UPDATE lead SET email = ? WHERE id = ?";

    // Initialize the prepared statement
    if ($stmt = $conn->prepare($query)) {
        // Bind the parameters
        $stmt->bind_param("si", $email, $id); // "s" for string, "i" for integer

        // Execute the query
        if ($stmt->execute()) {
            $msg = "<div class='alert alert-success'>Email Has Been Updated Successfully.</div>";
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
    $query = "DELETE FROM lead WHERE id = ?";

    // Initialize the prepared statement
    if ($stmt = $conn->prepare($query)) {
        // Bind the parameters
        $stmt->bind_param("i", $id); // "i" for integer (id)

        // Execute the query
        if ($stmt->execute()) {
            $msg = "<div class='alert alert-success'>Email Has Been Deleted Successfully.</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Something Went Wrong.</div>" . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        $msg = "<div class='alert alert-danger'>Failed to prepare statement.</div>" . $conn->error;
    }
}


// Below is optional, remove if you have already connected to your database.
$mysqli = mysqli_connect('localhost', $user,$pass,$dbname);

$quer="SELECT * FROM lead ORDER By id desc"; 

$total_pages = $mysqli->query($quer)->num_rows;

// Check if the page number is specified and check if it's a number, if not return the default page number which is 1.
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Number of results to show on each page.
$num_results_on_page = 25;
 $que="SELECT * FROM lead ORDER BY id DESC LIMIT ?,?";


if ($stmt = $mysqli->prepare($que)) {
   // Calculate the page to get the results we need from our table.
   $calc_page = ($page - 1) * $num_results_on_page;
   $stmt->bind_param('ii', $calc_page, $num_results_on_page);
   $stmt->execute(); 
   // Get the results...
   $result = $stmt->get_result();
   ?>
<!DOCTYPE html>
<html lang="en">
   <?php include "inc/head.php"; ?>
   <body class="inner_page widgets">
      <div class="full_container">
         <div class="inner_container">
            <!-- Sidebar  --> <?php include "inc/sidebar.php"; ?><!-- end sidebar -->
            <!-- right content -->
            <div id="content">
               <!-- topbar --><?php include "inc/topbar.php"; ?> <!-- end topbar -->
               <!-- dashboard inner -->
               <div class="midde_cont">
                  <div class="container-fluid">
                    <div class="row column_title" bis_skin_checked="1">
                        <div class="col-md-12" bis_skin_checked="1">
                           <div class="page_title" bis_skin_checked="1">
                              <h2>Emails List</h2>
                           </div>
                        </div>
                     </div>
                     <button class="btn mb-2 btn-success" data-toggle="modal" data-target="#addemail">Add New Email</button>

                  <!-- Add New Product Modal -->
                    <div class="modal fade" id="addemail">
                      <div class="modal-dialog modal-lg">
                      <form method="POST">
                        <div class="modal-content">
                        
                          <!-- Modal Header -->
                          <div class="modal-header">
                            <h4 class="modal-title">Add New Email</h4>
                          </div>
                          
                          <!-- Modal body -->
                          <div class="modal-body">
                            <div class="row mb-2">
                              <div class="col-md-12 mt-2">
                               <label for="startdate" class="form-label">Email:</label>
                               <input class="form-control" required="required" name="email" type="email" placeholder="Enter your email"> 
                              </div>
                            </div>  
                          </div>
                          
                          <!-- Modal footer -->
                          <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="add">Save Record</button>
                          </div>
                          
                        </div>
                        </form>
                      </div>
                    </div>
                    <!----- Modal ENds Here --->

                     <!------   Main Content Here       -->
                      <div class="row">
                        <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <?php if(isset($msg)){echo $msg;} ?>
                              <div class="table_section padding_infor_info">
                                 <div class="table-responsive-sm">
                                    <table class="table">
                                       <thead class="thead-dark">
                                          <tr>
                                             <th>ID</th>
                                             <th>Email</th>
                                             <th>Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php while ($rrow = $result->fetch_assoc()): ?>
                                          <tr>
                                             <td class="Id"><?php echo $rrow['id']; ?></td>
                                             <td><?php echo $rrow['email']; ?></td>
                                             <td>
                                                 <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editemail<?php echo $rrow['id']; ?>"><i class="fa fa-edit"></i></i></button>
                                                 <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteemail<?php echo $rrow['id']; ?>"><i class="fa fa-trash"></i></button>
                                             </td>
                                          </tr>

                  <!-- Edit New Product Modal -->
                    <div class="modal fade" id="editemail<?php echo $rrow['id']; ?>">
                      <div class="modal-dialog modal-lg">
                      <form method="POST">
                        <div class="modal-content">
                        
                          <!-- Modal Header -->
                          <div class="modal-header">
                            <h4 class="modal-title">Update Email</h4>
                          </div>
                          
                          <!-- Modal body -->
                          <div class="modal-body">
                            <div class="row mb-2">
                              <div class="col-md-12 mt-2">
                               <label for="startdate" class="form-label">Email:</label>
                               <input type="hidden" name="id" value="<?php echo $rrow['id']; ?>">
                               <input class="form-control" required="required" name="email" type="email" placeholder="Enter your email" value="<?php echo $rrow['email']; ?>"> 
                              </div>
                            </div>  
                          </div>
                          
                          <!-- Modal footer -->
                          <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="edit">Save Record</button>
                          </div>
                          
                        </div>
                        </form>
                      </div>
                    </div>
                    <!----- Modal ENds Here --->
                  <!-- Delete New Product Modal -->
                    <div class="modal fade" id="deleteemail<?php echo $rrow['id']; ?>">
                      <div class="modal-dialog modal-md">
                      <form method="POST">
                        <div class="modal-content">
                        
                          <!-- Modal Header -->
                          <div class="modal-header">
                            <h4 class="modal-title">Do you want to delete email?</h4>
                          </div>
                          
                          <!-- Modal body -->
                          <div class="modal-body">
                            <div class="row mb-2">
                              <div class="col-md-12 mt-2">
                               <p style="color: #292929;font-size: 16px;">Data will be deleted permanentaly.</p>
                               <input type="hidden" name="id" value="<?php echo $rrow['id']; ?>">
                               
                            </div>  
                          </div>
                          
                          <!-- Modal footer -->
                          <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger" name="delete">Yes</button>
                          </div>
                          
                        </div>
                        </form>
                      </div>
                    </div>
                    <!----- Modal ENds Here --->



                                          <?php endwhile; ?>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                              <?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
        
         <ul class="news">
            <?php if ($page > 1): ?>
            <li class="prev"><a href="emails_list.php?page=<?php echo $page-1 ?>">Prev</a></li>
            <?php endif; ?>

            <?php if ($page > 3): ?>
            <li class="start"><a href="emails_list.php?page=1">1</a></li>
            <li class="dots">...</li>
            <?php endif; ?>

            <?php if ($page-2 > 0): ?><li class="page"><a href="emails_list.php?page=<?php echo $page-2 ?>"><?php echo $page-2 ?></a></li><?php endif; ?>
            <?php if ($page-1 > 0): ?><li class="page"><a href="emails_list.php?page=<?php echo $page-1 ?>"><?php echo $page-1 ?></a></li><?php endif; ?>

            <li class="currentpage"><a href="emails_list.php?page=<?php echo $page ?>"><?php echo $page ?></a></li>

            <?php if ($page+1 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="emails_list.php?page=<?php echo $page+1 ?>"><?php echo $page+1 ?></a></li><?php endif; ?>
            <?php if ($page+2 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="emails_list.php?page=<?php echo $page+2 ?>"><?php echo $page+2 ?></a></li><?php endif; ?>

            <?php if ($page < ceil($total_pages / $num_results_on_page)-2): ?>
            <li class="dots">...</li>
            <li class="end"><a href="emails_list.php?page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
            <?php endif; ?>

            <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
            <li class="next"><a href="emails_list.php?page=<?php echo $page+1 ?>">Next</a></li>
            <?php endif; ?>
         </ul>
         <?php endif; ?>
                           </div>
                        </div>
                      
                      </div>  
                  </div>
                  <!-- footer -->
                  <?php include "inc/footer.php"; ?>
               </div>
               <!-- end dashboard inner -->
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
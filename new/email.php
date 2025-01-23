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
                              <h2>Email</h2>
                           </div>
                        </div>
                     </div>
                     <!------   Main Content Here       -->
                     <form action="compose_email.php" method="post" enctype="multipart/form-data">
                          <!-- Email Subject -->
                          <div class="mb-3">
                              <label for="subject" class="form-label">Subject</label>
                              <input type="text" class="form-control" id="subject" name="subject" required>
                          </div>

                          <!-- Email Body -->
                          <div class="mb-3">
                              <label for="body" class="form-label">Email Body</label>
                              <textarea class="form-control" id="body" name="body" rows="8"></textarea>
                              <script>
                                  CKEDITOR.replace('body');
                              </script>
                          </div>

                          <!-- Attachments -->
                          <div class="mb-3">
                              <label for="attachments" class="form-label">Attachments</label>
                              <input type="file" class="form-control" id="attachments" name="attachments[]" multiple>
                          </div>

                          <!-- Submit Button -->
                          <button type="submit" class="btn btn-primary">Send Email</button>
                      </form>

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

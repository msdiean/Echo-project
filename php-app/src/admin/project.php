<?php
   session_start();
   
   
   header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
   header("Cache-Control: post-check=0, pre-check=0", false);
   header("Pragma: no-cache");
   header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
   
   
   if(!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])){
       echo "<script>
           alert('Access Denied!');
           window.location.href = 'index.php';
       </script>";
       exit();
   }
   
   include 'db.php';
   $projects = $conn->query("SELECT * FROM projects ORDER BY id DESC");
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>Echo Projects</title>
      <meta content="width=device-width, initial-scale=1.0" name="viewport">
      <meta content="" name="keywords">
      <meta content="" name="description">
      <!-- Favicon -->
      <link href="img/favicon.ico" rel="icon">
      <!-- Google Web Fonts -->
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
      <!-- Icon Font Stylesheet -->
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
      <!-- Libraries Stylesheet -->
      <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
      <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
      <!-- Customized Bootstrap Stylesheet -->
      <link href="css/bootstrap.min.css" rel="stylesheet">
      <!-- Template Stylesheet -->
      <link href="css/style.css" rel="stylesheet">
   </head>
   <body>
      <div class="container-fluid position-relative bg-white d-flex p-0">
         <!-- Spinner Start -->
         <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
               <span class="sr-only">Loading...</span>
            </div>
         </div>
         <!-- Spinner End -->
         <style>
            .active
            {
            background-color: #f49617 !important;
            }
         </style>
         <!-- Sidebar Start -->
         <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
               <a href="#" class="navbar-brand mx-4 mb-3">
                  <h3 class="text-primary">Echo Digital</h3>
               </a>
               <div class="d-flex align-items-center ms-4 mb-4">
                  <div class="position-relative">
                     <img class="rounded-circle" src="../img/logo/Echo Digital Work Logo.png" alt="" style="width: 40px; height: 40px;">
                     <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                  </div>
                  <div class="ms-3">
                     <h6 class="mb-0">Echo Digi Works</h6>
                     <span>Admin</span>
                  </div>
               </div>
               <div class="navbar-nav w-100">
                  <a href="bg_video.php" class="nav-item nav-link"><i class="fa fa-video"></i> BG Video</a>
                  <a href="service.php" class="nav-item nav-link"><i class="fa fa-cogs"></i> Add Services</a>
                  <a href="project.php" class="nav-item nav-link active"><i class="fa fa-tasks"></i><b> Projects</b></a>
                  <a href="testimonial.php" class="nav-item nav-link"><i class="fa fa-quote-right"></i> Testimonial</a>
                  <a href="contact.php" class="nav-item nav-link"><i class="fa fa-id-badge"></i> Contacts</a>
                  <a href="meetings.php" class="nav-item nav-link"><i class="fa fa-calendar-alt"></i> Meetings</a>
                  <a href="newsletter_list.php" class="nav-item nav-link"><i class="fa fa-envelope"></i> Newsletter</a>
                  <a href="logout.php" class="nav-item nav-link"><i class="fa fa-sign-out-alt"></i> Logout</a>
               </div>
            </nav>
         </div>
         <!-- Sidebar End -->
         <!-- Content Start -->
         <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
               <a href="#" class="sidebar-toggler flex-shrink-0">
               <i class="fa fa-bars"></i>
               </a>
               <div class="navbar-nav align-items-center ms-auto">
                  <div class="nav-item dropdown">
                     <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                     <img class="rounded-circle me-lg-2" src="../img/logo/Echo Digital Work Logo.png" alt="" style="width: 40px; height: 40px;">
                     <span class="d-none d-lg-inline-flex"><b>Echo Digital Admin</b></span>
                     </a>
                     <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                        <a href="logout.php" class="dropdown-item">Log Out</a>
                     </div>
                  </div>
               </div>
            </nav>
            <!-- Navbar End -->
            <style>
               .echo-table
               {
               background-color: #0f2576;
               }
               .echo-text
               {
               color: #f49617;
               }
            </style>
            <!-- Bootstrap Modal -->
            <div class="modal fade" id="addProjectModal" tabindex="-1">
               <div class="modal-dialog">
                  <div class="modal-content">
                     <form id="projectForm" enctype="multipart/form-data">
                        <div class="modal-header">
                           <h5 class="modal-title">Add / Edit Project</h5>
                           <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                           <input type="hidden" name="projectId" id="projectId">
                           <input type="hidden" name="existingImage" id="existingImage">
                           <div class="mb-3">
                              <label>Project Image</label>
                              <input type="file" class="form-control" name="projectImage" id="projectImage">
                           </div>
                           <div class="mb-3">
                              <label>Title</label>
                              <input type="text" class="form-control" name="projectTitle" id="projectTitle" required>
                           </div>
                           <div class="mb-3">
                              <label>Tagline</label>
                              <textarea class="form-control" name="projectTagline" id="projectTagline" rows="3" required></textarea>
                           </div>
                           <div class="mb-3">
                              <label>Project Link</label>
                              <input type="url" class="form-control" name="projectLink" id="projectLink" required>
                           </div>
                        </div>
                        <div class="modal-footer">
                           <button class="btn btn-success" type="submit">Save</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <!-- Table Start -->
            <div class="container-fluid pt-4 px-4">
               <div class="row g-4">
                  <div class="col-12">
                     <div class="echo-table rounded h-100 p-4">
                        <h4 class="mb-4 echo-text">Projects</h4>
                        <button type="button" class="btn btn-success btn-md" data-bs-toggle="modal" data-bs-target="#addProjectModal"><b>Add Project</b></button>
                        <br><br>
                        <div class="table-responsive">
                           <table class="table table-bordered" id="projectsTable">
                              <thead class="echo-text">
                                 <tr>
                                    <th>S.No</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Tagline</th>
                                    <th>Link</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody class="text-light">
                                 <?php
                                    $projects = $conn->query("SELECT * FROM projects ORDER BY id DESC");
                                    $sn = 1;
                                    while($row = $projects->fetch_assoc()):
                                    ?>
                                 <tr id="row-<?php echo $row['id']; ?>">
                                    <th scope="row"><?php echo $sn++; ?></th>
                                    <td><img src="project-img/<?php echo $row['image']; ?>" style="width:100px; height:auto;"></td>
                                    <td><?php echo $row['title']; ?></td>
                                    <td><?php echo $row['tagline']; ?></td>
                                    <td><?php echo $row['link']; ?></td>
                                    <td>
                                       <div class="d-flex gap-2">
                                          <button class="btn btn-warning btn-sm editProject"
                                             data-id="<?= $row['id']; ?>"
                                             data-title="<?= htmlspecialchars($row['title']); ?>"
                                             data-tagline="<?= htmlspecialchars($row['tagline']); ?>"
                                             data-link="<?= $row['link']; ?>"
                                             data-image="<?= $row['image']; ?>">
                                          Edit
                                          </button>
                                          <button class="btn btn-danger btn-sm deleteProject" data-id="<?= $row['id']; ?>">Delete</button>
                                       </div>
                                    </td>
                                 </tr>
                                 <?php endwhile; ?>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- Table End -->
         </div>
         <!-- Content End -->
         <!-- Back to Top -->
      </div>
      <!-- JavaScript Libraries -->
      <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
      <script src="lib/chart/chart.min.js"></script>
      <script src="lib/easing/easing.min.js"></script>
      <script src="lib/waypoints/waypoints.min.js"></script>
      <script src="lib/owlcarousel/owl.carousel.min.js"></script>
      <script src="lib/tempusdominus/js/moment.min.js"></script>
      <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
      <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
      <!-- Template Javascript -->
      <script src="js/main.js"></script>
      <script>
         const bootstrapModal = new bootstrap.Modal(document.getElementById('addProjectModal'));
         const projectForm = document.getElementById('projectForm');
         
         
         document.addEventListener('click', function(e){
             const btn = e.target.closest('.editProject');
             if(btn){
                 document.getElementById('projectId').value = btn.dataset.id;
                 document.getElementById('projectTitle').value = btn.dataset.title;
                 document.getElementById('projectTagline').value = btn.dataset.tagline;
                 document.getElementById('existingImage').value = btn.dataset.image;
                 document.getElementById('projectLink').value = btn.dataset.link;
                 bootstrapModal.show();
             }
         });
         
         
         projectForm.addEventListener('submit', function(e){
             e.preventDefault();
             let formData = new FormData(this);
             fetch('update_project.php', { method:'POST', body: formData })
             .then(res => res.text())
             .then(data => {
                 if(data.trim() === 'success'){
                     alert('Project saved successfully!');
                     bootstrapModal.hide();
                     projectForm.reset();
                     location.reload();
                 } else {
                     alert('Error! Please try again.');
                 }
             });
         });
         
         
         document.addEventListener('click', function(e){
             const btn = e.target.closest('.deleteProject');
             if(btn){
                 if(confirm('Are you sure to delete this project?')){
                     fetch('delete_project.php', {
                         method: 'POST',
                         body: JSON.stringify({id: btn.dataset.id}),
                         headers: {'Content-Type':'application/json'}
                     })
                     .then(res => res.json())
                     .then(data => {
                         alert(data.message);
                         if(data.status === 'success') location.reload();
                     });
                 }
             }
         });
      </script>
   </body>
</html>
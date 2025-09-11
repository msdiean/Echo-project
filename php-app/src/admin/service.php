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
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>Echo Services</title>
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
                  <a href="service.php" class="nav-item nav-link active"><i class="fa fa-cogs"></i><b> Add Services</b></a>
                  <a href="project.php" class="nav-item nav-link"><i class="fa fa-tasks"></i> Projects</a>
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
            <!-- Add/Edit Modal -->
            <div class="modal fade" id="addServiceModal" tabindex="-1" aria-hidden="true">
               <div class="modal-dialog">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title text-center w-100">Add Service</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                     </div>
                     <div class="modal-body">
                        <form id="serviceForm" enctype="multipart/form-data">
                           <input type="hidden" name="id" id="serviceId">
                           <input type="hidden" name="existingIcon" id="existingIcon">
                           <input type="hidden" name="existingImage" id="existingImage">
                           <div class="mb-3">
                              <label>Upload Icon</label>
                              <input type="file" class="form-control" id="serviceIcon" name="serviceIcon" accept="image/*" >
                           </div>
                           <div class="mb-3">
                              <label>Service Name</label>
                              <input type="text" class="form-control" id="serviceName" name="serviceName" required>
                           </div>
                           <div class="mb-3">
                              <label>Tagline</label>
                              <textarea class="form-control" id="serviceTagline" name="serviceTagline" rows="3" required></textarea>
                           </div>
                           <div class="mb-3">
                              <label>Upload Service Image</label>
                              <input type="file" class="form-control" id="serviceImage" name="serviceImage" accept="image/*" >
                           </div>
                           <div class="text-center">
                              <button type="submit" class="btn btn-success">Submit</button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            <!-- JS for AJAX Submit -->
            <!-- Services Table -->
            <div class="container-fluid pt-4 px-4">
               <div class="row g-4">
                  <div class="col-12">
                     <div class="echo-table rounded h-100 p-4">
                        <h4 class="mb-4 echo-text">Services</h4>
                        <button type="button" class="btn btn-success btn-md" data-bs-toggle="modal" data-bs-target="#addServiceModal"><b>Add Services</b></button>
                        <br><br>
                        <div class="table-responsive">
                           <table class="table table-bordered" id="servicesTable">
                              <thead class="echo-text">
                                 <tr>
                                    <th>S.No</th>
                                    <th>Icon</th>
                                    <th>Service Name</th>
                                    <th>Tagline</th>
                                    <th>Service Image</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody class="text-light">
                                 <?php
                                    $services = $conn->query("SELECT * FROM services ORDER BY id DESC");
                                    $sn = 1;
                                    while($row = $services->fetch_assoc()):
                                    ?>
                                 <tr id="row-<?php echo $row['id']; ?>">
                                    <th scope="row"><?php echo $sn++; ?></th>
                                    <td><img src="img/service/<?php echo $row['icon']; ?>" style="width:40px;height:40px;"></td>
                                    <td><?php echo $row['service_name']; ?></td>
                                    <td><?php echo $row['tagline']; ?></td>
                                    <td><img src="images/<?php echo $row['service_image']; ?>" style="width:120px;height:auto;"></td>
                                    <td>
                                       <div class="d-flex gap-2">
                                          <button class="btn btn-sm btn-warning editService"
                                             data-id="<?php echo $row['id']; ?>"
                                             data-name="<?php echo htmlspecialchars($row['service_name']); ?>"
                                             data-tagline="<?php echo htmlspecialchars($row['tagline']); ?>"
                                             data-icon="<?php echo $row['icon']; ?>"
                                             data-image="<?php echo $row['service_image']; ?>">
                                          <i class="fa fa-edit"></i> Edit
                                          </button>
                                          <button class="btn btn-sm btn-danger deleteService" data-id="<?php echo $row['id']; ?>">
                                          <i class="fa fa-trash me-1"></i>Delete
                                          </button>
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
         </div>
         <!-- Content End -->
         <!-- JS Libraries -->
         <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
         <!-- Edit + AJAX Submit -->
         <script>
            const bootstrapModal = new bootstrap.Modal(document.getElementById('addServiceModal'));
            const serviceForm = document.getElementById('serviceForm');
            
            
            document.addEventListener('click', function(e){
                const btn = e.target.closest('.editService');
                if(btn){
                    document.getElementById('serviceId').value = btn.dataset.id;
                    document.getElementById('serviceName').value = btn.dataset.name;
                    document.getElementById('serviceTagline').value = btn.dataset.tagline;
                    document.getElementById('existingIcon').value = btn.dataset.icon;
                    document.getElementById('existingImage').value = btn.dataset.image;
            
                    bootstrapModal.show();
                }
            });
            
            
            serviceForm.addEventListener('submit', function(e){
                e.preventDefault();
                let formData = new FormData(this);
            
                fetch('add_service.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    if(data.status === 'success'){
                        bootstrapModal.hide();
                        serviceForm.reset();
                        location.reload(); 
                    }
                })
                .catch(err => console.log(err));
            });
            
            
            document.addEventListener('click', function(e){
            const btn = e.target.closest('.deleteService');
            if(btn){
            if(confirm("Are you sure you want to delete this service?")){
                let id = btn.dataset.id;
                fetch('delete_service.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: 'id=' + id
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    if(data.status === 'success'){
                        const row = document.getElementById('row-' + id);
                        if(row) row.remove();
                    }
                })
                .catch(err => console.log(err));
            }
            }
            });
            
            
         </script>
         <!-- Back to Top -->
         <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
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
   </body>
</html>
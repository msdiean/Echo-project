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
   
   
   
   $msg = "";
   
   
   if(isset($_FILES['videoFile'])){
       $file = $_FILES['videoFile'];
       $fileName = time().'_'.$file['name'];
       $targetDir = "uploads/";
       $targetFile = $targetDir . $fileName;
   
       if(move_uploaded_file($file['tmp_name'], $targetFile)){
         
           $oldStmt = $conn->prepare("SELECT * FROM bg_videos ORDER BY uploaded_at DESC LIMIT 1");
           $oldStmt->execute();
           $oldResult = $oldStmt->get_result();
           if($oldResult->num_rows == 1){
               $oldVideo = $oldResult->fetch_assoc();
               $oldPath = $targetDir . $oldVideo['file_name'];
               if(file_exists($oldPath)) unlink($oldPath);
               $conn->query("DELETE FROM bg_videos WHERE id=".$oldVideo['id']);
           }
   
       
           $stmt = $conn->prepare("INSERT INTO bg_videos (file_name) VALUES (?)");
           $stmt->bind_param("s", $fileName);
           $stmt->execute();
           $msg = "Video uploaded successfully!";
       } else {
           $msg = "Upload failed!";
       }
   }
   
   
   if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])){
       $id = intval($_POST['delete_id']); 
       $delStmt = $conn->prepare("SELECT * FROM bg_videos WHERE id=?");
       $delStmt->bind_param("i", $id);
       $delStmt->execute();
       $delResult = $delStmt->get_result();
       if($delResult->num_rows == 1){
           $video = $delResult->fetch_assoc();
           $path = "uploads/".$video['file_name'];
           if(file_exists($path)) unlink($path); 
           $conn->query("DELETE FROM bg_videos WHERE id=$id"); 
           $msg = "Video deleted successfully!";
       }
   }
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>Echo Video</title>
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
                  <a href="bg_video.php" class="nav-item nav-link active"><i class="fa fa-video"></i><b> BG Video</b></a>
                  <a href="service.php" class="nav-item nav-link"><i class="fa fa-cogs"></i> Add Services</a>
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
               .video-upload-container {
               max-width: 400px;
               width: 100%;
               padding: 20px;
               border-radius: 10px;
               background: #0f2576;
               box-shadow: 0px 4px 25px rgba(0,0,0,0.1);
               text-align: center;
               font-family: Arial, sans-serif;
               margin: auto;
               }
               .video-upload-container h3 {
               margin-bottom: 15px;
               color: #072fc1;
               font-size: 20px;
               }
               .upload-box {
               border: 2px dashed #f49617;
               border-radius: 10px;
               padding: 30px;
               cursor: pointer;
               background: #f49617;
               transition: 0.3s;
               }
               .upload-box:hover {
               background: #f49617;
               }
               .upload-box svg {
               margin-bottom: 10px;
               }
               .upload-box p {
               font-size: 14px;
               }
               .file-info {
               margin-top: 15px;
               padding: 8px 12px;
               background: #f49617;
               border-radius: 6px;
               display: flex;
               justify-content: space-between;
               align-items: center;
               }
               .file-info span {
               font-size: 14px;
               color: #333;
               max-width: 220px;
               overflow: hidden;
               text-overflow: ellipsis;
               white-space: nowrap;
               }
               .file-info button {
               border: none;
               background: none;
               cursor: pointer;
               font-size: 18px;
               }
               .upload-btn {
               margin-top: 15px;
               width: 100%;
               padding: 10px;
               border: none;
               background: #f49617;
               color: white;
               border-radius: 6px;
               font-size: 16px;
               cursor: pointer;
               transition: 0.3s;
               }
               .upload-btn:disabled {
               background: #f49617;
               cursor: not-allowed;
               }
               .upload-btn:hover:not(:disabled) {
               background: #f49617;
               }
               .progress-container {
               width: 100%;
               height: 8px;
               background: #e4e6f0;
               border-radius: 4px;
               margin-top: 15px;
               overflow: hidden;
               }
               .progress-bar {
               width: 0%;
               height: 100%;
               background: #f49617;
               transition: width 0.3s ease;
               }
               @media (max-width: 576px) {
               .video-upload-container {
               padding: 15px;
               max-width: 100%;
               }
               .upload-box {
               padding: 20px;
               }
               .upload-box svg {
               width: 50px;
               height: 50px;
               }
               .upload-box p {
               font-size: 12px;
               }
               .file-info span {
               font-size: 12px;
               max-width: 150px;
               }
               .upload-btn {
               font-size: 14px;
               padding: 8px;
               }
               }
               .echo-table
               {
               background-color: #0f2576;
               }
               .echo-text
               {
               color: #f49617;
               }
            </style>
            <!-- Blank Start -->
            <div class="container-fluid pt-4 px-4">
               <div class="row  rounded align-items-center justify-content-center mx-0">
                  <div class="col-md-6 text-center">
                     <div class="video-upload-container">
                        <h3 style="color: #f49617;">Upload Your Video</h3>
                        <!-- Form start -->
                        <form id="videoForm" method="POST" enctype="multipart/form-data">
                           <div class="upload-box" id="uploadTrigger">
                              <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="#072fc1" viewBox="0 0 24 24">
                                 <path d="M12 16V4M12 4L8 8M12 4L16 8M20 16v4H4v-4M4 16l8-8 8 8"/>
                              </svg>
                              <p class="text-dark"><b>Click here to select a video</b></p>
                              <p class="text-dark"><b>Maximum file size allowed : 40 MB</b></p>
                           </div>
                           <video id="videoPreview" width="100%" style="display:none; margin-top:10px; border-radius:6px;" controls></video>
                           <div class="file-info" id="fileInfo" style="display: none;">
                              <span id="fileName">No file selected</span>
                              <button type="button" id="removeFile" title="Remove file">🗑️</button>
                           </div>
                           <button type="submit" class="upload-btn w-100 mt-3" id="uploadBtn" disabled><b>Upload</b></button>
                           <input type="file" name="videoFile" id="videoFile" accept="video/*" style="display: none;">
                        </form>
                        <!-- Form end -->
                     </div>
                  </div>
               </div>
               <div class="container-fluid pt-4 px-4">
                  <div class="row g-4">
                     <div class="col-12">
                        <div class="echo-table rounded h-100 p-4">
                           <h4 class="mb-4 echo-text">Video</h4>
                           <div class="table-responsive">
                              <table class="table table-bordered">
                                 <thead class="echo-text">
                                    <tr>
                                       <th scope="col">S.No</th>
                                       <th scope="col">Video</th>
                                       <th scope="col">Action</th>
                                    </tr>
                                 </thead>
                                 <tbody class="text-light">
                                    <?php
                                       include 'db.php';
                                       $sn = 1;
                                       $videos = $conn->query("SELECT * FROM bg_videos ORDER BY uploaded_at DESC");
                                       while($row = $videos->fetch_assoc()):
                                       ?>
                                    <tr>
                                       <th scope="row"><?= $sn++ ?></th>
                                       <td>
                                          <video width="200" controls>
                                             <source src="uploads/<?= $row['file_name'] ?>" type="video/mp4">
                                          </video>
                                       </td>
                                       <td>
                                          <form action="bg_video.php" method="POST" onsubmit="return confirm('Are you sure to delete?');">
                                             <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                                             <button type="submit" class="btn btn-sm btn-danger d-flex align-items-center">
                                             <i class="fa fa-trash me-1"></i>Delete
                                             </button>
                                          </form>
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
            <!-- Blank End -->
         </div>
         <!-- Content End -->
         <!-- Back to Top -->
      </div>
      <script>
         const uploadTrigger = document.getElementById("uploadTrigger");
         const videoFile = document.getElementById("videoFile");
         const fileInfo = document.getElementById("fileInfo");
         const fileName = document.getElementById("fileName");
         const removeFile = document.getElementById("removeFile");
         const uploadBtn = document.getElementById("uploadBtn");
         const progressContainer = document.querySelector(".progress-container");
         const progressBar = document.getElementById("progressBar");
         const videoPreview = document.getElementById("videoPreview");
         
         let uploadInterval = null; 
         
         
         uploadTrigger.addEventListener("click", () => {
           videoFile.click();
         });
         
         
         videoFile.addEventListener("change", () => {
           if (videoFile.files.length > 0) {
             const file = videoFile.files[0];
         
           
             if(file.size > 40 * 1024 * 1024){
                 alert("Maximum file size allowed: 40 MB");
                 resetUI(); 
                 return; 
             }
         
             fileName.textContent = file.name;
             fileInfo.style.display = "flex";
             uploadBtn.disabled = false;
         
            
             const fileURL = URL.createObjectURL(file);
             videoPreview.src = fileURL;
             videoPreview.style.display = "block";
           } else {
             resetUI();
           }
         });
         
         
         removeFile.addEventListener("click", () => {
           if (uploadInterval) {
             clearInterval(uploadInterval);
             uploadInterval = null;
             progressBar.style.width = "0%";
             progressContainer.style.display = "none";
             console.log("Upload aborted.");
           }
         
           videoPreview.pause();
           videoPreview.currentTime = 0;
           videoPreview.src = "";
           videoPreview.load();
         
           resetUI();
         });
         
         
         uploadBtn.addEventListener("click", () => {
           if (videoFile.files.length > 0) {
             progressContainer.style.display = "block";
             progressBar.style.width = "0%";
         
             let progress = 0;
             uploadInterval = setInterval(() => {
               if (progress >= 100) {
                 clearInterval(uploadInterval);
                 uploadInterval = null;
                 alert("Upload complete!");
                
               } else {
                 progress += 5;
                 progressBar.style.width = progress + "%";
               }
             }, 200);
           }
         });
         
         
         function resetUI() {
           videoFile.value = "";
           fileInfo.style.display = "none";
           uploadBtn.disabled = true;
           videoPreview.style.display = "none";
         }
      </script>
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
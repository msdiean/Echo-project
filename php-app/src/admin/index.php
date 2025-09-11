<?php
   session_start();
   include 'db.php';
   
   if($_SERVER['REQUEST_METHOD']=="POST"){
       $username = $_POST['username'];
       $password = $_POST['password'];
   
       $stmt = $conn->prepare("SELECT * FROM admins WHERE username=? AND password=?");
       $stmt->bind_param("ss",$username,$password);
       $stmt->execute();
       $result = $stmt->get_result();
   
       if($result->num_rows == 1){
           $row = $result->fetch_assoc();
           $_SESSION['admin_id'] = $row['id'];
           $_SESSION['admin_username'] = $row['username'];
           header("Location: bg_video.php");
           exit;
       } else {
           
           echo "<script>alert('Invalid username or password!'); window.location='index.php';</script>";
           exit;
       }
   }
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>Echo Admin</title>
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
            .echo-bg
            {
            background-color: #0d1b4c;
            }
            .echo-btn
            {
            background-color: #f49617;
            }
         </style>
         <!-- Sign In Start -->
         <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
               <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                  <div class="echo-bg rounded p-4 p-sm-5 my-4 mx-3">
                     <div class="d-flex align-items-center justify-content-center">
                        <img src="../img/logo/Echo Logo.png" style="width:120px; height:60px;">
                     </div>
                     <br>
                     <div class="d-flex align-items-center justify-content-between mb-3">
                        <marquee scrollamount="15">
                           <h3 style="color: #f49617; text-align: center;">welcome to Echo Digital Works Admin</h3>
                        </marquee>
                     </div>
                     <form method="POST" action="">
                        <div class="form-floating mb-3">
                           <input type="text" name="username" class="form-control" id="floatingInput" placeholder="username" required>
                           <label for="floatingInput">Username</label>
                        </div>
                        <div class="form-floating mb-4">
                           <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                           <label for="floatingPassword">Password</label>
                        </div>
                        <button type="submit" class="btn text-light echo-btn py-3 w-100 mb-4"><b>Sign In</b></button>
                     </form>
                     <p class="text-center mb-0"><a style="color: #f49617;" href="forgot_pass.php"><b>Forgot Password ?</b></a></p>
                  </div>
               </div>
            </div>
         </div>
         <!-- Sign In End -->
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
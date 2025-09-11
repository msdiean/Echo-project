<?php
   session_start();
   
   
   use PHPMailer\PHPMailer\PHPMailer;
   use PHPMailer\PHPMailer\Exception;
   
   require 'PHPMailer/PHPMailer.php';
   require 'PHPMailer/SMTP.php';
   require 'PHPMailer/Exception.php';
   
   include 'db.php';
   
   if($_SERVER['REQUEST_METHOD']=="POST"){
       $email = $_POST['email'];
   
       
       $stmt = $conn->prepare("SELECT * FROM admins WHERE email=?");
       $stmt->bind_param("s",$email);
       $stmt->execute();
       $result = $stmt->get_result();
   
       if($result->num_rows == 1){
           $row = $result->fetch_assoc();
           $token = bin2hex(random_bytes(16));
          date_default_timezone_set('Asia/Kolkata');
           $expire = date("Y-m-d H:i:s", strtotime("+5 minutes"));
   
   
       
           $update = $conn->prepare("UPDATE admins SET reset_token=?, token_expire=? WHERE id=?");
           $update->bind_param("ssi",$token,$expire,$row['id']);
           $update->execute();
   
         
           $reset_link = "http://localhost/echo/admin/reset_pass.php?token=".$token;
   
   
           
           $mail = new PHPMailer(true);
   
           try {
               $mail->isSMTP();
               $mail->Host = 'smtp.gmail.com';
               $mail->SMTPAuth = true;
               $mail->Username = 'gowthamjayaram333@gmail.com'; 
               $mail->Password = 'iawwosixhagzijno';
               $mail->SMTPSecure = 'tls';
               $mail->Port = 587;
   
               $mail->setFrom('gowthamjayaram333@gmail.com', 'Echo Digital Works');
               $mail->addAddress($email);
               $mail->Subject = 'Password Reset';
               $mail->isHTML(true); 
   
               
               $mail->Body = '
               <html>
               <body style="margin:0; padding:0;">
                   <div style="font-family:Arial,sans-serif; max-width:600px; margin:auto; border:1px solid #ddd; padding:20px; text-align:center;">
                       <img src="https://yourdomain.com/img/logo/EchoLogo.png" alt="Echo Digital Works" style="width:150px; margin-bottom:20px;">
                       <h2 style="color:#f49617;">Password Reset Request</h2>
                       <p>Hi,</p>
                       <p>We received a request to reset your password. Click the button below to reset it:</p>
                       <a href="'.$reset_link.'" 
                          style="display:inline-block; background-color:#f49617; color:#fff; text-decoration:none; font-weight:bold; padding:12px 25px; border-radius:5px; font-family:Arial,sans-serif;">
                          Reset Password
                       </a>
                       <p>If you did not request this, please ignore this email.</p>
                       <hr>
                       <p style="font-size:12px; color:#777;">Echo Digital Works Admin</p>
                   </div>
               </body>
               </html>
               ';
   
               $mail->send();
               $_SESSION['flash'] = "Reset link sent to your email!";
           } catch (Exception $e) {
               $_SESSION['flash'] = "Mailer Error: ".$mail->ErrorInfo;
           }
       } else {
           $_SESSION['flash'] = "Email not found!";
       }
   
   
       header("Location: forgot_pass.php");
       exit();
   }
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>Echo Forgot Password</title>
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
      <?php
         if(isset($_SESSION['flash'])){
             echo "<script>alert('".$_SESSION['flash']."');</script>";
             unset($_SESSION['flash']); 
         }
         ?>
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
                     <h3 class="text-center mb-3" style="color: #f49617;">Forgot Password</h3>
                     <br>
                     <form method="POST" action="forgot_pass.php">
                        <div class="form-floating mb-3">
                           <input type="email" name="email" class="form-control" id="floatingEmail" placeholder="Enter your email" required>
                           <label for="floatingEmail">Email</label>
                        </div>
                        <button type="submit" class="btn text-light echo-btn py-3 w-100 mb-4"><b>Send Email</b></button>
                     </form>
                     <p class="text-center mb-0"><a style="color: #f49617;" href="index.php"><b>Back to Login</b></a></p>
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
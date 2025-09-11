<?php
   session_start();
   include './admin/db.php';
   
   $stmt = $conn->prepare("SELECT * FROM bg_videos ORDER BY uploaded_at DESC LIMIT 1");
   $stmt->execute();
   $result = $stmt->get_result();
   $video = $result->fetch_assoc();
   $videoSrc = $video ? "admin/uploads/" . $video['file_name'] : "img/my.mp4";
   ?>
<!DOCTYPE html>
<html lang="zxx">
   <head>
      <!-- Meta -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
      <meta name="description" content="Echo Digital Works offers UI / UX Design, Digital Marketing, Mobile App Development, Web Design & Development, Social Media management, Video Creations, Business Consultation & Strategy to help your business grow online.">
      <meta name="keywords" content="Echo Digital Works, web development, digital marketing, app development, branding services, business growth, Business Consultation & Strategy, UI / UX Design, Social Media management, Video Creations">
      <meta name="author" content="Echo Digital Works">
      <!-- Page Title -->
      <title>Echo Digital Works</title>
      <!-- Favicon Icon -->
      <link rel="shortcut icon" type="image/x-icon" href="img/logo/Echo Digital Work Logo.png">
      <!-- Google Fonts Css-->
      <link rel="preconnect" href="https://fonts.googleapis.com/">
      <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&amp;display=swap" rel="stylesheet">
      <!-- Bootstrap Css -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
      <!-- SlickNav Css -->
      <link href="css/slicknav.min.css" rel="stylesheet">
      <!-- Swiper Css -->
      <link rel="stylesheet" href="css/swiper-bundle.min.css">
      <!-- Font Awesome Icon Css-->
      <link href="css/all.min.css" rel="stylesheet" media="screen">
      <!-- Animated Css -->
      <link href="css/animate.css" rel="stylesheet">
      <!-- Magnific Popup Core Css File -->
      <link rel="stylesheet" href="css/magnific-popup.css">
      <!-- Mouse Cursor Css File -->
      <!-- Main Custom Css -->
      <link href="css/custom.css" rel="stylesheet" media="screen">
   </head>
   <body>
      <style>
         [data-cursor="-opaque"] {
         cursor: auto !important;
         }
      </style>
      <!-- Preloader Start -->
      <div class="preloader">
         <div class="loading-container">
            <div class="loading"></div>
            <div id="loading-icon"><img src="img/logo/Echo Digital Work Logo.png" alt=""></div>
         </div>
      </div>
      <!-- Preloader End -->
      <style>
         .navbar {
         background-color: transparent;
         padding: 10px 0;
         transition: background-color 0.3s ease;
         }
         .navbar.scrolled {
         background-color: #0d1b4c;
         }
         @media (max-width: 991px) {
         .navbar {
         background-color: #0d1b4c !important;
         }
         .navbar.scrolled {
         background-color: #0d1b4c !important;
         }
         }
         .navbar-nav .nav-link {
         color: white;
         font-weight: 600;
         margin: 0 10px;
         }
         .navbar-nav .nav-link:hover {
         color: #f7941d;
         }
         .echo-navv {
         background-color: #f7941d;
         border: none;
         }
      </style>
      <!-- Header Start -->
      <header id="echo-home" class="main-header">
         <div class="header-sticky">
            <nav class="navbar navbar-expand-lg fixed-top">
               <div class="container">
                  <!-- Logo -->
                  <a class="navbar-brand" href="#">
                  <img src="img/logo/Echo Logo.png" alt="Logo" style="width:110px; height:50px;">
                  </a>
                  <!-- Mobile toggle button -->
                  <button class="navbar-toggler echo-navv" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                  <span class="navbar-toggler-icon"></span>
                  </button>
                  <!-- Menu -->
                  <div class="collapse navbar-collapse" id="navbarNav">
                     <ul class="navbar-nav mx-auto">
                        <li class="nav-item"><a class="nav-link" href="#echo-home">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#about-sec">About Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="#services-echo">Services</a></li>
                        <li class="nav-item"><a class="nav-link" href="#echo-projects">Projects</a></li>
                        <li class="nav-item"><a class="nav-link" href="#testimonial-echo">Testimonials</a></li>
                        <li class="nav-item"><a class="nav-link" href="#echo-contacts">Contact Us</a></li>
                     </ul>
                     <!-- Right Buttons -->
                     <div class="d-flex align-items-center">
                        <button class="btn btn-meeting btn-sm me-4 openMeetingModal">
                        Schedule Meeting <i class="fa-solid fa-calendar-alt"></i>
                        </button>
                     </div>
                  </div>
               </div>
            </nav>
         </div>
      </header>
      <!-- Header End -->
      <!-- Modal -->
      <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
      <script>
         document.addEventListener('DOMContentLoaded', () => {
             const meetingForm = document.getElementById('meetingForm');
         
             meetingForm.addEventListener('submit', function(e){
                 e.preventDefault(); 
         
                
                 if(!meetingForm.checkValidity()) return;
         
                 const formData = new FormData(this);
         
                 fetch('submit_meeting.php', {
                     method: 'POST',
                     body: formData
                 })
                 .then(res => res.json())
                 .then(data => {
                     if(data.status === 'success'){
                         
                         const modalEl = document.createElement('div');
                         modalEl.innerHTML = `
                         <div class="modal fade" id="successModal" tabindex="-1">
                             <div class="modal-dialog modal-dialog-centered">
                                 <div class="modal-content text-center p-3">
                                     <div class="modal-header border-0">
                                         <h5 class="modal-title w-100">Meeting Scheduled!</h5>
                                         <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                     </div>
                                     <div class="modal-body">
                                         <h6 style="color:#0f2576;">Thanks ${data.name}, your meeting is scheduled on ${data.scheduled_date}!</h6>
                                     </div>
                                 </div>
                             </div>
                         </div>`;
                         document.body.appendChild(modalEl);
         
                         const bsModal = new bootstrap.Modal(modalEl.querySelector('#successModal'));
                         bsModal.show();
         
                         setTimeout(() => {
                             confetti({ particleCount: 200, spread: 90, origin: { y: 0.6 }, zIndex: 9999 });
                         }, 100);
         
                         meetingForm.reset();
         
                      
                         modalEl.querySelector('#successModal').addEventListener('hidden.bs.modal', () => {
                             modalEl.remove();
                         });
                     } else {
                         alert('Something went wrong. Please try again.');
                     }
                 })
                 .catch(err => console.log(err));
             });
         });
      </script>
      <!-- Modal -->
      <div id="meetingModal" class="modal-overlay">
         <div class="modal-container">
            <span class="close-btn" id="closeMeetingModal">&times;</span>
            <h2 class="modal-title">Schedule Meeting</h2>
            <form method="POST" id="meetingForm" class="meeting-form">
               <div class="form-group">
                  <label>Your Name</label>
                  <input type="text" name="name" placeholder="Enter your name" required>
               </div>
               <div class="form-group">
                  <label>Phone Number</label>
                  <input type="number" name="phone" placeholder="Enter your phone number" required>
               </div>
               <div class="form-group">
                  <label>Email Address</label>
                  <input type="email" name="email" placeholder="Enter your email" required>
               </div>
               <div class="form-group">
                  <label>Preferred Date</label>
                  <input type="date" name="date" required>
               </div>
               <div class="form-group">
                  <label>Message (Optional)</label>
                  <textarea name="message" rows="3" placeholder="Write any message"></textarea>
               </div>
               <div class="text-center">
                  <button type="submit" class="btn-submit">Submit</button>
               </div>
            </form>
         </div>
      </div>
      <style>
         .modal-overlay {
         display: none;
         position: fixed;
         z-index: 1000;
         left: 0; top: 0;
         width: 100%; height: 100%;
         background-color: rgba(0,0,0,0.5);
         align-items: center;
         justify-content: center;
         padding: 10px;
         }
         .modal-container {
         background: #fff;
         padding: 25px;
         border-radius: 10px;
         width: 100%;
         max-width: 450px;
         box-shadow: 0 5px 25px rgba(0,0,0,0.3);
         position: relative;
         }
         .close-btn {
         position: absolute;
         top: 15px;
         right: 15px;
         font-size: 25px;
         cursor: pointer;
         color: #333;
         }
         .modal-title {
         text-align: center;
         margin-bottom: 20px;
         color: #f49617;
         }
         .meeting-form .form-group {
         margin-bottom: 15px;
         }
         .meeting-form label {
         display: block;
         font-weight: 600;
         margin-bottom: 5px;
         }
         .meeting-form input,
         .meeting-form textarea {
         width: 100%;
         padding: 10px;
         border-radius: 6px;
         border: 1px solid #ccc;
         outline: none;
         }
         .meeting-form input:focus,
         .meeting-form textarea:focus {
         border-color: #f49617;
         }
         .btn-submit {
         background-color: #f49617;
         color: white;
         padding: 10px 20px;
         border: none;
         border-radius: 6px;
         cursor: pointer;
         font-weight: bold;
         }
         .btn-submit:hover {
         background-color: #e07b00;
         }
         @media (max-width: 576px) {
         .modal-container {
         padding: 20px;
         }
         }
      </style>
      <!-- JavaScript -->
      <!-- JS -->
      <script>
         const modal = document.getElementById('meetingModal');
         const closeBtn = document.getElementById('closeMeetingModal');
         
         document.querySelectorAll('.openMeetingModal').forEach(btn => {
             btn.addEventListener('click', e => {
                 e.preventDefault();
                 modal.style.display = 'flex';
             });
         });
         
         closeBtn.addEventListener('click', () => {
             modal.style.display = 'none';
         });
         
         
         window.addEventListener('click', e => {
             if(e.target === modal) {
                 modal.style.display = 'none';
             }
         });
      </script>
      <style>
         .btn-meeting
         {
         background-color: #f49617;
         color: #0d1b4c;
         font-weight: bolder; 
         }
         .btn-meeting:hover
         {
         background-color: #fff;
         color: #f49617;
         }
      </style>
      </div>
      </div>
      </nav>
      <div class="responsive-menu"></div>
      </div>
      </header>
      <!-- Header End -->
      <!-- Hero Section Start--> 
      <div class="hero">
         <!-- Video Start -->
         <div class="hero-bg-video">
            <!-- Selfhosted Video Start -->
            <video autoplay muted loop id="myVideo">
               <source src="<?= $videoSrc ?>" type="video/mp4">
            </video>
            <!-- Selfhosted Video End -->
         </div>
         <!-- Video End -->
         <div class="container">
            <div class="row align-items-center">
               <div class="col-lg-6">
                  <!-- Hero Content Start -->
                  <div class="hero-content">
                     <!-- Section Title Start -->
                     <div class="section-title">
                        <h3>welcome to Echo Digital Works</h3>
                        <h1 class="text-anime-style-2" data-cursor="-opaque"><span>Designing tomorrow</span> empowering your solutions</h1>
                        <p class="wow fadeInUp text-light">We combine innovation and creativity to craft  solutions that drive success and inspire growth.</p>
                     </div>
                     <!-- Section Title End -->
                     <!-- Hero Content Body Start -->
                     <div class="hero-content-body wow fadeInUp" data-wow-delay="0.2s">
                        <!-- Hero Button Start -->
                        <div class="hero-btn">
                           <a href="#echo-contacts" class="btn-default">Get Started</a>
                        </div>
                        <!-- Hero Button End -->
                     </div>
                     <!-- Hero Content Body End -->
                  </div>
                  <!-- Hero Content End -->
               </div>
            </div>
         </div>
      </div>
      <!-- Hero Section End-->
      <!-- Scrolling Ticker Section Start -->
      <div class="our-scrolling-ticker ">
         <!-- Scrolling Ticker Start -->
         <div class="scrolling-ticker-box ">
            <div class="scrolling-content ">
               <span>SEO Optimization</span>
               <span>Social Media Marketing</span>
               <span>Google Ads</span>
               <span>Facebook Ads</span>
               <span>Instagram Growth</span>
               <span>Content Marketing</span>
               <span>Email Campaigns</span>
               <span>Influencer Marketing</span>
               <span>Website Development</span>
               <span>Branding & Design</span>
               <span>Marketing Strategy</span>
               <span>Lead Generation</span>
            </div>
            <div class="scrolling-content ">
               <span>SEO Optimization</span>
               <span>Social Media Marketing</span>
               <span>Google Ads</span>
               <span>Facebook Ads</span>
               <span>Instagram Growth</span>
               <span>Content Marketing</span>
               <span>Email Campaigns</span>
               <span>Influencer Marketing</span>
               <span>Website Development</span>
               <span>Branding & Design</span>
               <span>Marketing Strategy</span>
               <span>Lead Generation</span>
            </div>
            <style>
               .scrolling-content span {
               font-weight: bold;
               font-size: 18px;
               display: inline-block;
               }
            </style>
         </div>
      </div>
      <!-- Scrolling Ticker Section End -->
      <!-- About Us Section Start -->
      <div class="about-us">
         <div class="container">
            <div class="row align-items-center">
               <div class="col-lg-6">
                  <!-- About Us Images Start -->
                  <div class="about-us-images">
                     <!-- About Founder Content Start -->
                     <div class="about-founder-content">
                        <!-- Satisfy Client Box Start -->
                        <div class="satisfy-client-box">
                           <!-- Satisfy Client Images Start -->
                           <div class="satisfy-client-images">
                              <div class="satisfy-client-image">
                                 <figure class="image-anime reveal">
                                    <img src="img/clients/4.jpg" alt="">
                                 </figure>
                              </div>
                              <div class="satisfy-client-image">
                                 <figure class="image-anime reveal">
                                    <img src="img/clients/2.jpg" alt="">
                                 </figure>
                              </div>
                              <div class="satisfy-client-image">
                                 <figure class="image-anime reveal">
                                    <img src="img/clients/3.jpg" alt="">
                                 </figure>
                              </div>
                              <div class="satisfy-client-image">
                                 <figure class="image-anime reveal">
                                    <img src="img/clients/1.jpg" alt="">
                                 </figure>
                              </div>
                              <div class="satisfy-client-image add-more">
                                 <p><span class="counter">20</span>+</p>
                              </div>
                           </div>
                           <!-- Satisfy Client Images End -->
                           <!-- Satisfy Client Content Start -->
                           <div class="satisfy-client-content text-light">
                              <p><span class="counter">20</span>+ Happy clients</p>
                           </div>
                           <!-- Satisfy Client Content End -->
                        </div>
                        <!-- Satisfy Client Box End -->
                        <!-- About Author Box Start -->
                        <div class="about-author-box">
                           <!-- About Author Image Start -->
                           <div >
                              <figure class="image-anime">
                                 <img src="img/boopathy.jpg" style="border-radius:20px;" alt="">
                              </figure>
                           </div>
                           <!-- About Author Image End -->
                           <br>
                           <!-- About Author Info Start -->
                           <div class="about-author-info wow fadeInUp">
                              <h3 style=text-align:center;>Mr Boopathy</h3>
                              <p style=text-align:center;>CEO & founder</p>
                           </div>
                           <!-- About Author Info End -->
                           <!-- About Author Content Start -->
                           <div class="about-author-content wow fadeInUp" data-wow-delay="0.2s">
                              <p style=text-align:justify;>Our  & Founder leads with passion delivering innovative design services that transform brands into success.</p>
                           </div>
                           <!-- About Author Content End -->
                           <!-- About Author Signature Start -->
                           <div class="about-author-signature wow fadeInUp" data-wow-delay="0.4s">
                              <img src="img/boopathy.png" alt="">
                           </div>
                           <!-- About Author Signature End -->
                        </div>
                        <!-- About Author Box End -->
                     </div>
                     <!-- About Founder Content End -->
                     <!-- About Us Image Start -->
                     <div class="about-us-img">
                        <figure class="image-anime reveal">
                           <img src="img/about-img.svg" alt="">
                        </figure>
                        <!-- About Explore Circle Start -->
                        <div class="about-explore-circle">
                           <a href="#services-echo">
                           <img src="img/svg/explore.svg" alt="">
                           </a>
                        </div>
                        <!-- About Explore Circle End -->
                     </div>
                     <!-- About Us Image End -->
                  </div>
                  <!-- About Us Images End -->
               </div>
               <div id="about-sec" class="col-lg-6">
                  <!-- About Us Content Start -->
                  <div class="about-us-content">
                     <!-- Section Title Start -->
                     <div class="section-title">
                        <h3 class="wow fadeInUp">About us</h3>
                        <h2 class="text-anime-style-2" data-cursor="-opaque">Designing experiences, <span>empowering</span> your brand</h2>
                        <p class="wow fadeInUp text-light" data-wow-delay="0.2s">We specialize in creating innovative designs that captivate audiences  Our mission is to blend creativity with strategy, delivering experiences that inspire and empower your business to thrive.</p>
                     </div>
                     <!-- Section Title End -->
                     <!-- About Us Body Start -->
                     <div class="about-us-body wow fadeInUp" data-wow-delay="0.4s">
                        <h3>“Empowering Your Brand Through Creative Design Crafting Memorable Experiences.”</h3>
                     </div>
                     <!-- About Us Body End -->
                     <!-- About Us List Start -->
                     <div class="about-us-list wow fadeInUp" data-wow-delay="0.6s">
                        <!-- About List Item Start -->
                        <div class="about-list-item">
                           <div class="icon-box">
                              <img src="img/svg/DS.svg" alt="">
                           </div>
                           <div class="about-list-content">
                              <h3>design solutions</h3>
                              <p class="text-light">Crafting unique and creative visual experiences.</p>
                           </div>
                        </div>
                        <!-- About List Item End -->
                        <!-- About List Item Start -->
                        <div class="about-list-item">
                           <div class="icon-box">
                              <img src="img/svg/Collab.svg" alt="">
                           </div>
                           <div class="about-list-content">
                              <h3>collaborative proces</h3>
                              <p class="text-light">Crafting unique and creative visual experiences.</p>
                           </div>
                        </div>
                        <!-- About List Item End -->
                     </div>
                     <!-- About Us List End -->
                     <!-- About Us Button Start -->
                     <div class="about-us-btn wow fadeInUp" data-wow-delay="0.8s">
                        <a href="#services-echo" class="btn-default">more about</a>
                     </div>
                     <!-- About Us Button End -->
                  </div>
                  <!-- About Us Content End -->
               </div>
            </div>
         </div>
      </div>
      <!-- About Us Section End -->
      <style>
         .echotitle
         {
         color: #f49617;
         }
      </style>
      <!-- Services Section Start -->
      <div id="services-echo" class="our-services">
         <div class="container">
            <div class="row section-row">
               <div class="col-lg-12">
                  <div class="section-title">
                     <h3 class="wow fadeInUp">services</h3>
                     <h2 class="text-anime-style-2" data-cursor="-opaque">
                        Innovative design <span>services</span> for every vision
                     </h2>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-lg-12">
                  <?php
                     include 'admin/db.php';
                     $services = $conn->query("SELECT * FROM services ORDER BY id DESC");
                     ?>
                  <div class="services-list wow fadeInUp">
                     <?php while($row = $services->fetch_assoc()): ?>
                     <div class="service-item">
                        <div class="service-body">
                           <div class="icon-box">
                              <img src="admin/img/service/<?php echo $row['icon']; ?>" alt="">
                           </div>
                           <div class="service-content">
                              <h3 class="echotitle"><?php echo $row['service_name']; ?></h3>
                              <p class="text-anime-style-2 text-light"><?php echo $row['tagline']; ?></p>
                           </div>
                        </div>
                        <div class="service-image">
                           <a href="" data-cursor-text="View">
                              <figure class="image-anime">
                                 <img src="admin/images/<?php echo $row['service_image']; ?>" alt="">
                              </figure>
                           </a>
                        </div>
                     </div>
                     <?php endwhile; ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Services Section End -->
      <!-- Projects Section with Swiper -->
      <section id="echo-projects" class="echo-cards-section">
         <div class="row section-row">
            <div class="col-lg-12">
               <!-- Section Title Start -->
               <div class="section-title">
                  <h3 class="wow fadeInUp">Our projects</h3>
                  <h2 class="text-anime-style-2" data-cursor="-opaque">Exploring our creative and impactful <span>projects</span></h2>
               </div>
               <!-- Section Title End -->
            </div>
         </div>
         <div class="echo-grid">
            <?php
               $projects = $conn->query("SELECT * FROM projects ORDER BY id DESC");
               while($p = $projects->fetch_assoc()):
               ?>
            <article class="echo-card project-card" data-reveal>
               <div class="card-image">
                  <img src="./admin/project-img/<?php echo $p['image']; ?>" style="border-radius: 8px;" alt="<?php echo htmlspecialchars($p['title']); ?>">
               </div>
               <br>
               <div class="card-content">
                  <h3 class="echotitle text-center"><?php echo $p['title']; ?></h3>
                  <p class="text-light text-center"><?php echo $p['tagline']; ?></p>
                  <div class="text-center">
                     <a href="<?php echo $p['link']; ?>" target="_blank" class="echo-btn align-items-center">View Project</a>
                  </div>
               </div>
            </article>
            <?php endwhile; ?>
         </div>
      </section>
      <style>
         :root{
         --bg:#070A12;
         --muted:#9aa3b2;
         --text:#E7ECF3;
         --brand1:#6C7CFF;
         --brand2:#22D3EE;
         --shadow:0 10px 30px rgba(0,0,0,.35);
         }
         .echo-cards-section{
         padding:clamp(32px,6vw,72px) 16px;
         color:var(--text);
         }
         .echo-title{
         text-align:center;
         font-size:clamp(24px,3vw,36px);
         margin-bottom:24px;
         }
         .echo-grid{
         display:grid;
         grid-template-columns:repeat(3,minmax(0,1fr));
         gap:22px;
         max-width:1200px;
         margin:0 auto;
         }
         @media(max-width:992px){
         .echo-grid{ grid-template-columns:repeat(2,minmax(0,1fr)); }
         }
         @media(max-width:640px){
         .echo-grid{ grid-template-columns:1fr; }
         }
         .echo-card{
         position:relative;
         background:linear-gradient(135deg,rgba(108,124,255,.18),rgba(34,211,238,.14));
         border:1px solid transparent;
         border-radius:20px;
         padding:20px;
         box-shadow:var(--shadow);
         overflow:hidden;
         transform:translateY(20px) scale(.98);
         opacity:0;
         transition:transform .6s cubic-bezier(.2,.7,.2,1),opacity .6s;
         transition: transform .35s ease, box-shadow .35s ease;
         }
         .echo-card.revealed{
         transform:translateY(0) scale(1);
         opacity:1;
         }
         .echo-card .card-content{
         display:flex;
         flex-direction:column;
         gap:12px;
         }
         .echo-card h3{ margin:0; font-size:20px; }
         .echo-card p{ margin:0; color:var(--muted); font-size:14px; line-height:1.5; }
         .echo-btn{
         align-self:flex-start;
         border:1px solid rgba(255,255,255,.18);
         background:rgba(255,255,255,.06);
         color:var(--text);
         padding:10px 14px;
         border-radius:12px;
         font-size:14px;
         cursor:pointer;
         transition:background .25s ease;
         }
         .echo-btn:hover{ background:rgba(255,255,255,.12); }
         .echo-card .icon{
         width:52px;height:52px;
         border-radius:14px;
         background:rgba(255,255,255,.1);
         display:grid;place-items:center;
         }
         .echo-card .icon img{
         width:28px;height:28px;object-fit:contain;
         }
         @keyframes sheenMove{
         0%,100%{ transform:translateX(-60%) rotate(8deg) }
         50%{ transform:translateX(60%) rotate(8deg) }
         }
         .echo-card:hover {
         transform: translateY(-6px) scale(1.03);
         box-shadow: 0 14px 40px rgba(0,0,0,.45);
         }
         .echo-card:hover .sheen {
         animation-duration: 2s;
         }
      </style>
      <script>
         (function(){
           const els=document.querySelectorAll('[data-reveal]');
           const io=new IntersectionObserver((entries)=>{
             entries.forEach(e=>{
               if(e.isIntersecting){
                 e.target.classList.add('revealed');
                 io.unobserve(e.target);
               }
             });
           },{threshold:.18});
           els.forEach(el=>io.observe(el));
         })();
      </script>
      <!-- Why Choose Us Section Start -->
      <div class="why-choose-us">
         <div class="container">
            <div class="row section-row">
               <div class="col-lg-12">
                  <!-- Section Title Start -->
                  <div class="section-title">
                     <h3 class="wow fadeInUp">why choose us</h3>
                     <h2 class="text-anime-style-2" data-cursor="-opaque">Creative <span>solutions</span> exceptional results, always</h2>
                  </div>
                  <!-- Section Title End -->
               </div>
            </div>
            <div class="row align-items-center">
               <div class="col-lg-3 col-md-6 order-lg-1 order-1">
                  <!-- Why Choose Box List Start -->
                  <div class="why-choose-box-list">
                     <!-- Why Choose Box Start -->
                     <div class="why-choose-box wow fadeInUp">
                        <div class="icon-box">
                           <img src="images/icon-why-choose-1.svg" alt="">
                        </div>
                        <div class="why-choose-box-content">
                           <h3 class="echotitle">Innovate</h3>
                           <p class="text-light">Turning ideas into impactful campaigns that drive real results.</p>
                        </div>
                     </div>
                     <!-- Why Choose Box End -->
                     <!-- Why Choose Box Start -->
                     <div class="why-choose-box wow fadeInUp" data-wow-delay="0.2s">
                        <div class="icon-box">
                           <img src="images/icon-why-choose-2.svg" alt="">
                        </div>
                        <div class="why-choose-box-content">
                           <h3 class="echotitle">Amplify</h3>
                           <p class="text-light">We take your vision and make it heard across the digital world.</p>
                        </div>
                     </div>
                     <!-- Why Choose Box End -->
                  </div>
                  <!-- Why Choose Box List End -->
               </div>
               <div class="col-lg-6 order-lg-2 order-3">
                  <!-- Why Choose Images Start -->
                  <div class="why-choose-images">
                     <div class="why-choose-circle">
                        <img src="img/bg-animation/bg-round.svg" alt="">
                     </div>
                     <div class="why-choose-img">
                        <img src="img/man3d.svg" alt="">
                     </div>
                  </div>
                  <!-- Why Choose Images End -->
               </div>
               <div class="col-lg-3 col-md-6 order-lg-2 order-2">
                  <!-- Why Choose Box List Start -->
                  <div class="why-choose-box-list">
                     <!-- Why Choose Box Start -->
                     <div class="why-choose-box wow fadeInUp">
                        <div class="icon-box">
                           <img src="images/icon-why-choose-3.svg" alt="">
                        </div>
                        <div class="why-choose-box-content">
                           <h3 class="echotitle">Spark</h3>
                           <p class="text-light">Creative thinking meets measurable outcomes.</p>
                        </div>
                     </div>
                     <!-- Why Choose Box End -->
                     <!-- Why Choose Box Start -->
                     <div class="why-choose-box wow fadeInUp" data-wow-delay="0.2s">
                        <div class="icon-box">
                           <img src="images/icon-why-choose-4.svg" alt="">
                        </div>
                        <div class="why-choose-box-content">
                           <h3 class="echotitle">Convert</h3>
                           <p class="text-light">Smart marketing that turns attention into action.</p>
                        </div>
                     </div>
                     <!-- Why Choose Box End -->
                  </div>
                  <!-- Why Choose Box List End -->
               </div>
            </div>
         </div>
      </div>
      <!-- Why Choose Us Section End -->
      <style>
         .text-anime-style-2 {
         pointer-events: none;
         }
         .swiper-wrapper {
         cursor: auto !important;
         }
      </style>
      <!-- Our Testimonials Section Start -->
      <div id="testimonial-echo" class="our-testimonials">
         <div class="container">
            <div class="row section-row">
               <div class="col-lg-12">
                  <!-- Section Title Start -->
                  <div class="section-title">
                     <h3 class="wow fadeInUp">testimonials</h3>
                     <h2 class="text-anime-style-2" data-cursor="-opaque">What our <span>clients say</span> about us</h2>
                  </div>
                  <!-- Section Title End -->
               </div>
            </div>
            <div class="row">
               <div class="col-lg-12">
                  <?php
                     include './admin/db.php';
                     $testimonials = $conn->query("SELECT * FROM testimonials ORDER BY id DESC");
                     ?>
                  <div class="testimonial-slider">
                     <div class="swiper">
                        <div class="swiper-wrapper">
                           <?php while($t = $testimonials->fetch_assoc()): ?>
                           <div class="swiper-slide">
                              <div class="testimonial-item">
                                 <h3 class="echotitle"><?= $t['name'] ?></h3>
                                 <br>
                                 <p style="text-align:justify;" class="text-light"><?= $t['testimonial'] ?></p>
                                 <div class="testimonial-rating">
                                    <?php for($i=0;$i<$t['rating'];$i++): ?>
                                    <i class="fa-solid fa-star"></i>
                                    <?php endfor; ?>
                                 </div>
                              </div>
                           </div>
                           <?php endwhile; ?>
                        </div>
                        <div class="testimonial-btn">
                           <div class="testimonial-button-prev"></div>
                           <div class="testimonial-button-next"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Our Testimonials Section End -->
      <!-- Our Facts Section Start -->
      <div class="our-facts">
         <div class="container">
            <div class="row section-row">
               <div class="col-lg-12">
                  <!-- Section Title Start -->
                  <div class="section-title">
                     <h3 class="wow fadeInUp">Our facts</h3>
                     <h2 class="text-anime-style-2" data-cursor="-opaque">Key milestones that define our <span>journey</span></h2>
                  </div>
                  <!-- Section Title End -->
               </div>
            </div>
            <div class="row align-items-center">
               <div class="col-lg-6">
                  <!-- Facts Details Box Start -->
                  <div class="facts-details-box">
                     <!-- Facts Image Start -->
                     <div class="fact-image">
                        <figure class="image-anime reveal">
                           <img src="img/fact-img.svg" alt="">
                        </figure>
                     </div>
                     <!-- Facts Image End -->
                     <!-- Facts Details Content Start -->
                     <div class="fact-details-content">
                        <div class="fact-circle-image">
                           <a href="#services-echo">
                           <img src="img/svg/explore.svg">
                           </a>
                        </div>
                        <p style="text-align: justify; font-weight: bold;" class="wow fadeInUp text-light">Discover the achievements that showcase our, dedication, and impact. These milestones reflect our commitment to delivering exceptional design solutions.</p>
                     </div>
                     <!-- Facts Details Content End -->
                  </div>
                  <!-- Facts Details Box End -->
               </div>
               <div class="col-lg-6">
                  <!-- Our Fact Box Start -->
                  <div class="our-fact-box">
                     <!-- Fact Counter Item Start -->
                     <div class="fact-counter-item wow fadeInUp">
                        <div class="icon-box">
                           <img src="images/icon-fact-counter-1.svg" alt="">
                        </div>
                        <div class="why-choose-box-content">
                           <h3 class="echotitle">Our Path</h3>
                           <p class="text-light">From humble beginnings to remarkable achievements.</p>
                        </div>
                     </div>
                     <!-- Fact Counter Item End -->
                     <!-- Fact Counter Item Start -->
                     <div class="fact-counter-item wow fadeInUp" data-wow-delay="0.2s">
                        <div class="icon-box">
                           <img src="images/icon-fact-counter-2.svg" alt="">
                        </div>
                        <div class="why-choose-box-content">
                           <h3 class="echotitle">Turning Points</h3>
                           <p class="text-light">A journey marked by passion and progress.</p>
                        </div>
                     </div>
                     <!-- Fact Counter Item End -->
                     <!-- Fact Counter Item Start -->
                     <div class="fact-counter-item wow fadeInUp" data-wow-delay="0.4s">
                        <div class="icon-box">
                           <img src="images/icon-fact-counter-3.svg" alt="">
                        </div>
                        <div class="why-choose-box-content">
                           <h3 class="echotitle">The Journey</h3>
                           <p class="text-light">Celebrating the moments that shaped our success.</p>
                        </div>
                     </div>
                     <!-- Fact Counter Item End -->
                     <!-- Fact Counter Item Start -->
                     <div class="fact-counter-item wow fadeInUp" data-wow-delay="0.6s">
                        <div class="icon-box">
                           <img src="images/icon-fact-counter-4.svg" alt="">
                        </div>
                        <div class="why-choose-box-content">
                           <h3 class="echotitle">Milestones</h3>
                           <p class="text-light">Tracing the steps that built our story.</p>
                        </div>
                     </div>
                     <!-- Fact Counter Item End -->
                  </div>
                  <!-- Our Fact Box End -->
               </div>
            </div>
         </div>
      </div>
      <!-- Our Facts Section End -->
      <!-- Footer Start -->
      <footer id="echo-contacts" class="main-footer">
         <!-- Page Contact Us Start -->
         <div class="page-contact-us">
            <div class="container">
               <div class="row align-items-center">
                  <div class="col-lg-5">
                     <!-- Contact Info Box Start -->
                     <div class="contact-info-box">
                        <!-- Contact info Title Start -->
                        <div class="contact-info-title wow fadeInUp">
                           <h3>we're here to support you always!</h3>
                        </div>
                        <!-- Contact info Title End -->
                        <br>
                        <!-- Contact Info List Start -->
                        <div class="contact-info-list">
                           <!-- Contact Info Item Start -->
                           <div class="contact-info-item wow fadeInUp" data-wow-delay="0.2s">
                              <div class="icon-box">
                                 <img src="images/icon-phone-dark.svg" alt="">
                              </div>
                              <div class="contact-info-content">
                                 <p class="echotitle"><b>Call us</b></p>
                                 <h3><a href="tel:+91 8056597002">+91 80565 97002</a></h3>
                              </div>
                           </div>
                           <!-- Contact Info Item End -->
                           <!-- Contact Info Item Start -->
                           <div class="contact-info-item wow fadeInUp" data-wow-delay="0.4s">
                              <div class="icon-box">
                                 <img src="images/icon-mail-dark.svg" alt="">
                              </div>
                              <div class="contact-info-content">
                                 <p class="echotitle"><b>E Mail</b></p>
                                 <h3><a href="mailto:echodigiworks@gmail.com">echodigiworks@gmail.com</a></h3>
                              </div>
                           </div>
                           <!-- Contact Info Item End -->
                           <!-- Contact Info Item Start -->
                           <div class="contact-info-item wow fadeInUp" data-wow-delay="0.6s">
                              <div class="icon-box">
                                 <img src="images/icon-location-dark.svg" alt="">
                              </div>
                              <div class="contact-info-content">
                                 <p class="echotitle"><b>Location</b></p>
                                 <h5>111, Porur, Chennai, 600028.</h5>
                              </div>
                           </div>
                           <!-- Contact Info Item End -->
                        </div>
                        <!-- Contact Info List End -->
                        <br>
                        <!-- Contact Social List Start -->
                        <div class="contact-social-list wow fadeInUp" data-wow-delay="0.8s">
                           <h3>follow us:</h3>
                           <ul>
                              <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                              <li><a href="#"><i class="fa-brands fa-x-twitter"></i></a></li>
                              <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                              <li><a href="#"><i class="fa-brands fa-pinterest-p"></i></a></li>
                           </ul>
                        </div>
                        <!-- Contact Social List End -->
                     </div>
                     <!-- Contact Info Box End -->
                  </div>
                  <div class="col-lg-7">
                     <!-- Contact Us Content Start -->
                     <div class="contact-us-content contact-info-box">
                        <!-- Section Title Start -->
                        <div class="section-title">
                           <h2 class="text-anime-style-2" data-cursor="-opaque">Get in to <span>touch</span> with us</h2>
                        </div>
                        <!-- Section Title End -->
                        <style>
                           #fname::placeholder {
                           color: #fff;
                           opacity: 1;
                           }
                           #fname {
                           color: #fff;
                           }
                           #lname {
                           color: #fff; 
                           }
                           #phone {
                           color: #fff;
                           }
                           #email {
                           color: #fff; 
                           }
                           #message {
                           color: #fff; 
                           }
                        </style>
                        <!-- Contact Form Start -->
                        <div class="contact-us-form">
                           <form  method="POST" action="submit_contact.php" class="wow fadeInUp" data-wow-delay="0.2s">
                              <div class="row">
                                 <div class="form-group col-md-6 mb-4">
                                    <label class="form-label">Enter First name</label>
                                    <input type="text" name="fname" class="form-control" id="fname" placeholder="" required>
                                    <div class="help-block with-errors"></div>
                                 </div>
                                 <div class="form-group col-md-6 mb-4">
                                    <label class="form-label">last name</label>
                                    <input type="text" name="lname" class="form-control" id="lname" placeholder="" required>
                                    <div class="help-block with-errors"></div>
                                 </div>
                                 <div class="form-group col-md-6 mb-4">
                                    <label class="form-label">mobile number</label>
                                    <input type="number" name="phone" class="form-control" id="phone" placeholder="" required>
                                    <div class="help-block with-errors"></div>
                                 </div>
                                 <div class="form-group col-md-6 mb-4">
                                    <label class="form-label">e-mail address</label>
                                    <input type="email" name ="email" class="form-control" id="email" placeholder="" required>
                                    <div class="help-block with-errors"></div>
                                 </div>
                                 <div class="form-group col-md-12 mb-5">
                                    <label class="form-label">message</label>
                                    <textarea name="message" class="form-control" id="message" rows="4" placeholder=""></textarea>
                                    <div class="help-block with-errors"></div>
                                 </div>
                                 <div class="col-md-12">
                                    <button type="submit" class="btn-default"><span>send message</span></button>
                                    <div id="msgSubmit" class="h3 hidden"></div>
                                 </div>
                              </div>
                           </form>
                        </div>
                        <!-- Contact Form End -->
                     </div>
                     <!-- Contact Us Content End -->
                  </div>
               </div>
            </div>
         </div>
         <!-- Modal HTML -->
         <?php if(isset($_SESSION['contact_success'])): ?>
         <div class="modal fade" id="successModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
               <div class="modal-content">
                  <div class="modal-header border-0 justify-content-center">
                     <h5 class="modal-title echo-m w-100">Message Sent!</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                     <b>
                        <p>Thanks <?= $_SESSION['contact_success']['name'] ?>, your message has been sent successfully!</p>
                     </b>
                  </div>
               </div>
            </div>
         </div>
         <script>
            window.addEventListener('DOMContentLoaded', () => {
                const modalEl = document.getElementById('successModal');
                const bsModal = new bootstrap.Modal(modalEl);
                bsModal.show();
            
                setTimeout(() => {
                    confetti({ particleCount: 200, spread: 90, origin: { y: 0.6 }, zIndex: 9999 });
                }, 100);
            
                modalEl.addEventListener('hidden.bs.modal', () => {
                    modalEl.remove();
                });
            });
         </script>
         <?php unset($_SESSION['contact_success']); endif; ?>
         <!-- Page Contact Us End -->
         <style>
            .modal-backdrop.show {
            opacity: 0.6;
            }
            #successModal .modal-content {
            background: #fff; 
            color: #f49617;
            border-radius: 15px;
            padding: 20px;
            max-width: 400px; 
            margin: auto;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            text-align: center;
            }
            .echo-m
            {
            color: #f49617;
            }
            #successModal .modal-title {
            font-weight: bold;
            font-size: 1.4rem;
            }
            #successModal .modal-body h6 {
            font-size: 1rem;
            margin-top: 10px;
            }
            #successModal .btn-close {
            color: #fff;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            }
         </style>
         <!-- Let's Work Together end -->
         <!-- Google Map Section Start -->
         <div class="google-map">
            <div class="container">
               <div class="row">
                  <div class="col-lg-12">
                     <!-- Google Map IFrame Start -->
                     <div class="google-map-iframe">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d923.7078427693793!2d80.17668699484638!3d13.025158786774746!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a5261d57bdce53b%3A0x809b300b38398912!2sGreens%20Technology!5e1!3m2!1sen!2sin!4v1755106273945!5m2!1sen!2sin" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                     </div>
                     <!-- Google Map IFrame End -->
                  </div>
               </div>
            </div>
         </div>
         <!-- Google Map Section End -->
         <!-- Footer Main Start -->
         <div class="footer-main">
            <div class="container">
               <div class="row">
                  <div class="col-lg-12">
                     <!-- Main Footer Start -->
                     <div class="main-footer-box">
                        <!-- Footer About Start -->
                        <div class="footer-about">
                           <div class="footer-logo">
                              <img src="img/logo/Echo Logo.png" alt="">
                           </div>
                           <div class="about-footer-content">
                              <p style="text-align:justify;" class="text-light">Echo Digital Works creates websites, apps, and digital marketing solutions to help businesses grow online. We deliver smart, user-friendly, and impactful digital experiences.</p>
                           </div>
                        </div>
                        <!-- Footer About End -->
                        <!-- Footer Links List Start -->
                        <div class="footer-links-list">
                           <!-- Footer Links Box Start -->
                           <div class="footer-links-box">
                              <!-- Footer Links Start -->
                              <div class="footer-links">
                                 <h3>services</h3>
                                 <ul class="text-light">
                                    <li><a href="#services-echo">UI / UX Design</a></li>
                                    <li><a href="#services-echo">Mobile App Development</a></li>
                                    <li><a href="#services-echo">Web Design & Development</a></li>
                                    <li><a href="#services-echo">Social Media management</a></li>
                                 </ul>
                              </div>
                              <!-- Footer Links End -->
                              <!-- Footer Newsletter Form Start -->
                              <div class="footer-newsletter-form">
                                 <div class="footer-newsletter-title">
                                    <h3>Subscribe our newsletter:</h3>
                                 </div>
                                 <div class="newsletter-form">
                                    <form id="newsletterForm" method="POST">
                                       <div class="form-group">
                                          <input type="email" name="mail" class="form-control" id="mail" placeholder="Enter Email" required>
                                          <button type="submit" class="btn-highlighted">Subscribe</button>
                                       </div>
                                    </form>
                                    <div id="newsletterMsg" class="mt-2 text-light"></div>
                                 </div>
                                 <!-- Footer Social List Start -->
                                 <div class="contact-social-list wow fadeInUp">
                                    <ul>
                                       <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                                       <li><a href="#"><i class="fa-brands fa-x-twitter"></i></a></li>
                                       <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                                       <li><a href="#"><i class="fa-brands fa-pinterest-p"></i></a></li>
                                    </ul>
                                 </div>
                                 <!-- Footer Social List End -->
                              </div>
                              <!-- Footer Newsletter Form End -->
                           </div>
                           <!-- Footer Links Box End -->
                           <style>
                              #mail::placeholder {
                              color: #fff; 
                              opacity: 1; 
                              }
                              #mail {
                              color: #f49617;
                              }
                           </style>
                           <!-- Include SweetAlert CDN in your footer or head -->
                           <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                           <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
                           <script>
                              $(document).ready(function(){
                                  $('#newsletterForm').submit(function(e){
                                      e.preventDefault();
                                      let formData = $(this).serialize();
                              
                                      $.ajax({
                                          url: 'newsletter_submit.php',
                                          type: 'POST',
                                          data: formData,
                                          success: function(response){
                                            
                                              Swal.fire({
                                                  icon: response.includes('successfully') ? 'success' : 'info',
                                                  title: response,
                                                  showConfirmButton: false,
                                                  timer: 2000
                                              });
                                              $('#newsletterForm')[0].reset();
                                          },
                                          error: function(){
                                              Swal.fire({
                                                  icon: 'error',
                                                  title: 'Something went wrong!',
                                                  showConfirmButton: false,
                                                  timer: 2000
                                              });
                                          }
                                      });
                                  });
                              });
                           </script>
                           <!-- Footer Contact List Start -->
                           <div class="footer-contact-list ">
                              <ul class="text-light">
                                 <li><a href="tel:+123456789">+91 - 123 456 789</a></li>
                                 <li><a href="#">infodomin@gmail.com</a></li>
                                 <li><span>123 Porur, Chennai - 600028</span></li>
                              </ul>
                           </div>
                           <!-- Footer Contact List End -->
                        </div>
                        <!-- Footer Links List End -->
                     </div>
                     <!-- Main Footer End -->
                  </div>
                  <div class="col-lg-12">
                     <!-- Footer Copyright Section Start -->
                     <div class="footer-copyright">
                        <div class="row align-items-center">
                           <div class="col-lg-6 col-md-5">
                              <!-- Footer Copyright Text Start -->
                              <div class="footer-copyright-text text-light">
                                 <p>Copyright © 2025 All Rights Reserved.</p>
                              </div>
                              <!-- Footer Copyright Text End -->
                           </div>
                           <div class="col-lg-6 col-md-7">
                              <!-- Footer Privacy Policy Start -->
                              <div class="footer-privacy-policy text-light">
                                 <ul>
                                    <li><a href="#">help</a></li>
                                    <li><a href="#">Privacy policy</a></li>
                                    <li><a href="#">Term's & condition</a></li>
                                 </ul>
                              </div>
                              <!-- Footer Privacy Policy End -->
                           </div>
                        </div>
                     </div>
                     <!-- Footer Copyright Section End -->
                  </div>
               </div>
            </div>
         </div>
         <!-- Footer Main End -->
      </footer>
      <!-- Footer End -->
      <!-- Jquery Library File -->
      <script>
         window.addEventListener("scroll", function () {
             let navbar = document.querySelector(".navbar");
             if (window.scrollY > 50) {
                 navbar.classList.add("scrolled");
             } else {
                 navbar.classList.remove("scrolled");
             }
         });
      </script>
      <script src="js/jquery-3.7.1.min.js"></script>
      <!-- Bootstrap js file -->
      <!-- Use bundle version -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
      <!-- Validator js file -->
      <script src="js/validator.min.js"></script>
      <!-- SlickNav js file -->
      <script src="js/jquery.slicknav.js"></script>
      <!-- Swiper js file -->
      <script src="js/swiper-bundle.min.js"></script>
      <!-- Counter js file -->
      <script src="js/jquery.waypoints.min.js"></script>
      <script src="js/jquery.counterup.min.js"></script>
      <!-- Isotop js file -->
      <script src="js/isotope.min.js"></script>
      <!-- Magnific js file -->
      <script src="js/jquery.magnific-popup.min.js"></script>
      <!-- SmoothScroll -->
      <script src="js/SmoothScroll.js"></script>
      <!-- Parallax js -->
      <script src="js/parallaxie.js"></script>
      <!-- MagicCursor js file -->
      <script src="js/gsap.min.js"></script>
      <!-- Text Effect js file -->
      <script src="js/SplitText.js"></script>
      <script src="js/ScrollTrigger.min.js"></script>
      <!-- YTPlayer js File -->
      <script src="js/jquery.mb.YTPlayer.min.js"></script>
      <!-- Wow js file -->
      <script src="js/wow.min.js"></script>
      <!-- Main Custom js file -->
      <script src="js/function.js"></script>
   </body>
</html>
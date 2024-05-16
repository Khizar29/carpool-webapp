<?php 
session_start();
include('includes/config.php');
error_reporting(0);

?>

<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="keywords" content="">
<meta name="description" content="">
<title>Carpool Portal</title>
<!--Bootstrap -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="assets/css/style.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
<link href="assets/css/slick.css" rel="stylesheet">
<link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
<link href="assets/css/font-awesome.min.css" rel="stylesheet">
		<link rel="stylesheet" id="switcher-css" type="text/css" href="assets/switcher/css/switcher.css" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/red.css" title="red" media="all" data-default-color="true" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/orange.css" title="orange" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" title="blue" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/pink.css" title="pink" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/green.css" title="green" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/purple.css" title="purple" media="all" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet"> 
</head>
<body>

<!-- Start Switcher -->
<?php include('includes/colorswitcher.php');?>
<!-- /Switcher -->  
        
<!--Header-->
<?php include('includes/header.php');?>
<!-- /Header --> 

<!-- Banners -->
<section id="banner" class="banner-section">
  <div class="container">
    <div class="div_zindex">
      <div class="row">
        <div class="col-md-5 col-md-push-7">
          <div class="banner_content">
            <h1>Find the right car for you.</h1>
            <p>We have more than a thousand cars for you to choose. </p>
            <a href="#" class="btn">Read More <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></a> </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- /Banners --> 
<!--carpool info-->
<section class="main-content">
            <!-- Image on the left -->
            <img src="assets\images\carpoolinfo.jpeg" alt="Carpooling Image">

            <!-- Text and Button on the right -->
            <div class="text-and-button">
                <h3>Why Choose Carpooling?</h3>
                <p>Carpooling is a sustainable and convenient way to commute. Here's why you should choose carpooling for
                    your daily travels:</p>

                <ul>
                    <li>Reduce Carbon Footprint: By sharing rides, you contribute to a greener environment by lowering
                        carbon emissions.</li>
                    <li>Save Money: Carpooling helps you save on fuel costs, parking fees, and reduces the overall
                        maintenance expenses.</li>
                    <li>Socialize and Network: Connect with people in your community, make new friends, and expand your
                        professional network during your daily commute.</li>
                    
                </ul>

            </div>
        </section>
      <style>
body {
  font-family: 'Arial', sans-serif;
  background-color: gray; /* Dark background color */
  color: #5b1472; /* Text color */
  text-align: center;
  padding: 20px;
}


/* Styling for the main content section */
.main-content {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background-color: gray; /* Darker background color */
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  margin-bottom: 20px;
}

/* Styling for the title */
h3 {
  color:#9a0858; /* Title color */
  margin-bottom: 20px;
}

/* Styling for the paragraph */
p {
  font-size: 1.1em;
  line-height: 1.6;
  color: ; /* Paragraph text color */
}


/* Styling for the image */
.main-content img {
  max-width: 100%;
  border-radius: 5px;
  transform: rotateY(20deg) rotateX(-20deg);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
  transition: transform 0.5s;
}

/* Hover effect for the image */
.main-content img:hover {
  transform: rotateY(0deg) rotateX(0deg);
}


        </style>
<!--/carpool info-->

<!-- Resent Cat-->
<section class="section-padding black-bg">
<div class="containerforsafety">
  <div role="presentation" class="content-wrapper">
    <div class="section-large-content">
      <article class="flippable-content-wrapper">
        <div class="flex-container">
          <div class="image-container">
            <img src="https://cdn.blablacar.com/kairos/assets/images/scamDetective-653544b71d88f51797db.svg" alt="" width="200px" height="109px">
          </div>
          <div class="text-wrapper">
            <span class="title">Your safety is our priority</span>
            <p class="description">We're working hard to make our platform as secure as it can be. But when scams do happen, we want you to know exactly how to avoid and report them. Help us keep you safe.</p>
            <div class="button-wrapper">
              <a class="custom-button secondary-button" href="/scam">
                <span class="button-label">Learn more</span>
              </a>
            </div>
          </div>
        </div>
      </article>
    </div>
  </div>
</div>
</section>
<!-- /Resent Cat --> 

<!-- Fun Facts-->

 

<!-- /Fun Facts--> 


<!--Testimonial -->


<!--Footer -->
<?php include('includes/footer.php');?>
<!-- /Footer--> 

<!--Back to top-->
<div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
<!--/Back to top--> 

<!--Login-Form -->
<?php include('includes/login.php');?>
<!--/Login-Form --> 

<!--Register-Form -->
<?php include('includes/registration.php');?>

<!--/Register-Form --> 

<!--Forgot-password-Form -->
<?php include('includes/forgotpassword.php');?>
<!--/Forgot-password-Form --> 

<!-- Scripts --> 
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/interface.js"></script> 
<!--Switcher-->
<script src="assets/switcher/js/switcher.js"></script>
<!--bootstrap-slider-JS--> 
<script src="assets/js/bootstrap-slider.min.js"></script> 
<!--Slider-JS--> 
<script src="assets/js/slick.min.js"></script> 
<script src="assets/js/owl.carousel.min.js"></script>

</body>

<!-- Mirrored from themes.webmasterdriver.net/carforyou/demo/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 16 Jun 2017 07:22:11 GMT -->
</html>

<header>
  <div class="default-header">
    <div class="container">
      <div class="row">
        <div class="col-sm-3 col-md-2">
          <div class="logo"> <a href="index.php"><img src="assets/images/logo3.jpeg" alt="image"/></a> </div>
        </div>
        <div class="col-sm-9 col-md-10">
          <div class="header_info">
            <div class="header_widgets">
              <div class="circle_icon"> <i class="fa fa-envelope" aria-hidden="true"></i> </div>
              <p class="uppercase_text">Mail us : </p>
              <a href="mailto:info@example.com">afkcarpool@edu.pk</a> </div>
            <div class="header_widgets">
              <div class="circle_icon"> <i class="fa fa-phone" aria-hidden="true"></i> </div>
              <p class="uppercase_text">Call Us: </p>
              <a href="tel:61-1234-5678-09">+92-090078601</a> </div>
           
   <?php   if(strlen($_SESSION['login'])==0)
	{
?>
 <div class="login_btn"> <a href="#loginform" class="btn btn-xs uppercase" data-toggle="modal" data-dismiss="modal">Login / Register</a> </div>
<?php }
else{

echo "Welcome To Carpool portal";
 } ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Navigation -->
  <nav id="navigation_bar" class="navbar navbar-default">
    <div class="container">
      <div class="navbar-header">
        <button id="menu_slide" data-target="#navigation" aria-expanded="false" data-toggle="collapse" class="navbar-toggle collapsed" type="button"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      </div>
      <div class="header_wrap">
        <div class="user_login">
          <ul>
            <li class="dropdown"> <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle" aria-hidden="true"></i>
<?php
$email=$_SESSION['login'];
$sql ="SELECT FullName FROM tblusers WHERE EmailId=:email ";
$query= $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
	{

	 echo htmlentities($result->FullName); }}?><i class="fa fa-angle-down" aria-hidden="true"></i></a>
              <ul class="dropdown-menu">
           <?php if($_SESSION['login']){?>
            <li><a href="profile.php">Profile Settings</a></li>
              <li><a href="update-password.php">Update Password</a></li>
            <li><a href="logout.php">Sign Out</a></li>
            <?php } else { ?>
            <li><a href="#loginform"  data-toggle="modal" data-dismiss="modal">Profile Settings</a></li>
              <li><a href="#loginform"  data-toggle="modal" data-dismiss="modal">Update Password</a></li>
            <li><a href="#loginform"  data-toggle="modal" data-dismiss="modal">Sign Out</a></li>
            <?php } ?>
          </ul>
            </li>
          </ul>
        </div>
        <!-- <div class="header_search">
          <div id="search_toggle"><i class="fa fa-search" aria-hidden="true"></i></div>
          <form action="#" method="get" id="header-search-form">
            <input type="text" placeholder="Search..." class="form-control">
            <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
          </form>
        </div> -->
      </div>
     
      <div class="collapse navbar-collapse" id="navigation">
    <ul class="nav navbar-nav">
        <li><a href="index.php">Home</a></li>
        <li><a href="page.php?type=aboutus">About Us</a></li>
        <?php if (isset($_SESSION['login'])) { ?>
            <li><a href="publishride.php">Publish a ride</a></li>
        <?php } else { ?>
            <li><a href="#loginform" data-toggle="modal" data-dismiss="modal">Publish a ride</a></li>
        <?php } ?>
        <?php if (isset($_SESSION['login'])) { ?>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Rides</a>
            <ul class="dropdown-menu">
                <li><a href="myride-driver.php?type=driver">Driver Mode</a></li>
                <li><a href="myride.php?type=passenger">Passenger Mode</a></li>
                
            </ul>
        </li>
        <?php } else { ?>
            <li><a href="#loginform" data-toggle="modal" data-dismiss="modal">My Rides</a></li>
        <?php } ?>
       
        <?php if (isset($_SESSION['login'])) { ?>
          <li><a href="searchride.php">Search Ride</a></li>
        <?php } else { ?>
            <li><a href="#loginform" data-toggle="modal" data-dismiss="modal">Search Ride</a></li>
        <?php } ?>
       
    </ul>
</div>


    </div>
  </nav>
  <!-- Navigation end -->

</header>

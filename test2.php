<?php
session_start();
error_reporting(0);
include('includes/config.php');
?>

<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title>Carpool Portal | Page details</title>
    <!--Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    
    <!--Custome Style -->
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <!--OWL Carousel slider-->
    <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
    <!--slick-slider -->
    <link href="assets/css/slick.css" rel="stylesheet">
    <!--bootstrap-slider -->
    <link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
    <!--FontAwesome Font Style -->
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">

    <!-- SWITCHER -->
    <link rel="stylesheet" id="switcher-css" type="text/css" href="assets/switcher/css/switcher.css" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/red.css" title="red" media="all" data-default-color="true" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/orange.css" title="orange" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" title="blue" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/pink.css" title="pink" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/green.css" title="green" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/purple.css" title="purple" media="all" />

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
</head>

<body>
    <!-- Start Switcher -->
    <?php include('includes/colorswitcher.php'); ?>
    <!-- /Switcher -->

    <!--Header-->
    <?php include('includes/header.php'); ?>

    <?php
    // Establishing a connection to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "carpooldb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handling the search
    if (isset($_POST['search'])) {
        $leaving = $_POST['leaving_from'];
        $going = $_POST['going_to'];
        $seat = $_POST['people'];

        // Using prepared statements to prevent SQL injection
        $sql = "SELECT tblbooking.id, tblbooking.userEmail, tblbooking.message, tblbooking.VehicleId, tblbooking.Status FROM tblbooking WHERE tblbooking.userEmail LIKE ? AND tblbooking.message LIKE ? AND tblbooking.VehicleId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $leavingParam, $goingParam, $seatParam);

        $leavingParam = "%$leaving%";
        $goingParam = "%$going%";
        $seatParam = $seat;

        $stmt->execute();
        $result = $stmt->get_result();

        // Displaying the results in a table
        if ($result->num_rows > 0) {
            echo '<div class="container my-4">
            <table class="table table-dark table-striped" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">Driver Email</th>
                        <th scope="col">Name</th>
                        <th scope="col">Vehicle ID</th>
                        <th scope="col">Status</th>
                        <th scope="col">Book</th>
                    </tr>
                </thead>
                <tbody>';
    $sno = 0;
    while ($row = $result->fetch_assoc()) {
        $sno = $sno + 1;
        echo "<tr>
            <th scope='row'>" . $sno . "</th>
            <td>" . $row['userEmail'] . "</td>
            <td>" . $row['message'] . "</td>
            <td>" . $row['VehicleId'] . "</td>
            <td>" . $row['Status'] . "</td>
            <td><button class='book btn btn-sm btn-primary' id=" . $row['id'] . ">Book</button></td>
        </tr>";
    }
    echo '</tbody>
            </table>
          </div>';
} else {
    echo "No results found";
}

        $stmt->close();
    }

    $conn->close();
    ?>

    <!-- Search form -->
    <!-- New ADDITIONS MAKING SEARCH BOX IN PAGE 2 -->
    <div class="carpool-search-box">
        <form action="test2.php" method="POST">
            <div class="search-input-group location-input">
                <label for="leaving-from"><i class="fas fa-map-marker-alt"></i></label>
                <input type="text" name="leaving_from" id="leaving-from" placeholder="Leaving from" required>
            </div>

            <div class="search-input-group location-input">
                <label for="going-to"><i class="fas fa-map-marker-alt"></i></label>
                <input type="text" name="going_to" id="going-to" placeholder="Going to" required>
            </div>

            <div class="search-input-group people-input">
                <label for="people"><i class="fas fa-user"></i></label>
                <input type="number" name="people" id="people" min="1" placeholder="Number of people" required>
            </div>

            <button type="submit" name="search">Find a ride</button>
        </form>
    </div>

    <!-- /end of search box -->

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>
    <!-- /Footer-->

    <!-- Back to top -->
    <div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
    <!-- /Back to top -->

    <!-- Login-Form -->
    <?php include('includes/login.php'); ?>
    <!-- /Login-Form -->

    <!-- Register-Form -->
    <?php include('includes/registration.php'); ?>

    <!-- /Register-Form -->

    <!-- Forgot-password-Form -->
    <?php include('includes/forgotpassword.php'); ?>
    <!-- /Forgot-password-Form -->

    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/interface.js"></script>

    <!-- Switcher -->
    <script src="assets/switcher/js/switcher.js"></script>
    <!-- bootstrap-slider-JS -->
    <script src="assets/js/bootstrap-slider.min.js"></script>
    <!-- Slider-JS -->
    <script src="assets/js/slick.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>

</body>

</html>

<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('includes/config.php');


$servername = "localhost";
$username = "root";
$password = "";
$database = "carpooldb";


$con = mysqli_connect($servername, $username, $password, $database);

$userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_pooling'])) {
    $poolingIdToDelete = $_POST['pooling_id'];

    // Add validation if needed

    // Perform the deletion
    $deleteQuery = "DELETE FROM tblpooling WHERE poolingid = $poolingIdToDelete";
    $deleteResult = mysqli_query($con, $deleteQuery);

    if ($deleteResult) {
        echo '<div class="alert alert-success" role="alert">
           Pooling cancelled Successfully
        </div>';
    
    } else {
        echo "Error canceling pooling: " . mysqli_error($con);
    }
}



$sql = "SELECT 
        tblpooling.carid,
        tbldrivers.driverid,
        tblcars.carnumber,
        tblcars.company,
        tblcars.carname,
        tblroutes.description,
        tblusers.ContactNo AS DriverPhone,
        tblusers.EmailId,
        tblusers.FullName AS DriverName,
        -- tblbill.billid,
        tblpooling.starttime,
        tblpooling.endtime,
        tblpooling.date,
        tblpooling.poolingid
        FROM tbldrivers
        JOIN tblpooling ON tbldrivers.carid = tblpooling.carid
        JOIN tblcars ON tblpooling.carid = tblcars.carid
        JOIN tblusers ON tblusers.id = tbldrivers.driverid
        -- JOIN tblbill ON tblbill.billid = tblpooling.billid
        JOIN tblroutes ON tblroutes.routeid = tblpooling.routeid
        WHERE tbldrivers.driverid = $userId";

// For debugging purposes, echo the SQL query
// echo "SQL Query: " . $sql;

$result = mysqli_query($con, $sql);

if (!$result) {
    die("Error in SQL query: " . mysqli_error($con));
}


$result = mysqli_query($con, $sql);

if (!$result) {
    die("Error in SQL query: " . mysqli_error($con));
}
?>

<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title>Carpool Portal | Confirm Passengers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">

    <!-- Custom Style -->
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">

    <!-- OWL Carousel slider-->
    <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
    <!-- Slick-slider -->
    <link href="assets/css/slick.css" rel="stylesheet">
    <!-- Bootstrap-slider -->
    <link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
    <!-- FontAwesome Font Style -->
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>

    <!--Page Header-->
    <section class="page-header profile_page">
        <div class="container">
            <div class="page-header_wrap">
                <div class="page-heading">
                    <h1>My Rides</h1>
                </div>
                <ul class="coustom-breadcrumb">
                    <li><a href="index.php">Home</a></li>
                    <!-- <li>Passenger</li> -->
                    <li><a href="myride-driver.php">Published</a></li>
                </ul>
            </div>
        </div>
        <!-- Dark Overlay-->
        <div class="dark-overlay"></div>

    </section>
    <!-- Page Header -->
    <section class="page-header profile_page">
        <!-- Your existing code for the page header -->
    </section>
    <!-- /Page Header -->

    <!-- Ride Details Table -->
    <table class="table table-striped table-dark">
        <thead>
            <tr>
                <th scope="col">Pooling ID</th>
                <th scope="col">Date</th>
                <th scope="col">Start Time</th>
                <th scope="col">Car Details</th>
                <th scope="col">Route Description</th>
                <!-- <th scope="col">Bill ID</th> -->
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['poolingid']}</td>";
            echo "<td>{$row['date']}</td>";
            echo "<td>{$row['starttime']}</td>";
            echo "<td>{$row['carnumber']} | {$row['company']} | {$row['carname']}</td>";
            echo "<td>{$row['description']}</td>";
            // echo "<td>{$row['billid']}</td>";
            echo "<td>";
            $currentDate = date('Y-m-d');
            
            if ($row['date'] > $currentDate) {
                echo "Scheduled";
            } elseif ($row['date'] < $currentDate) {
                echo "Completed";
            } else {
                echo "Schedule Today";
            }
            echo "</td>";
            
            echo "<td>";

            echo '<form method="post">';
            echo '<input type="hidden" name="pooling_id" value="' . $row['poolingid'] . '">';
            echo '<div class="btn-group" role="group" aria-label="Passenger Actions">';
            echo '<a href="confirmpassenger.php?pooling_id=' . $row['poolingid'] . '" class="btn btn-sm btn-info" style="margin-left: 10px; height: 40px; width: 150px;">Requests</a>';

            echo '<button type="submit" name="cancel_pooling" class="btn btn-sm btn-danger" style="margin-left: 10px; height: 40px; width: 130px;">Cancel</button>';
            echo '</div>';
            echo '</form>';

            echo "</td>";
          
            
            echo "</tr>";
        }
        mysqli_free_result($result);
        ?>
        </tbody>
    </table>



    <button type='submit' name='return home'><a href="index.php">Home</a></button>
    

    <script>
        // JavaScript to hide buttons after submission
        // document.addEventListener("DOMContentLoaded", function() {
        //     var buttons = document.querySelectorAll("button[type='submit']");
        //     buttons.forEach(function(button) {
        //         button.addEventListener("click", function() {
        //             this.style.display = "none";
        //         });
        //     });
        // });
    </script>

</body>

</html>
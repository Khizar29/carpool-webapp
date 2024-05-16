<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('includes/config.php');

// Connect to the Database 
$servername = "localhost";
$username = "root";
$password = "";
$database = "carpooldb";


$con = mysqli_connect($servername, $username, $password, $database);


$userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;


if (isset($_POST['cancel_ride'])) {
    $passengerId = $_POST['passenger_id'];
    $poolingId = $_POST['pooling_id'];
    $seatsrequested= $_POST['seats_requested'];
    $status= $_POST['status'];


    if ($status==1)
    {
        $updatesql = "UPDATE tblpooling  join tblpassengers 
        on tblpooling.poolingid = tblpassengers.poolingid 
        SET bookedseats = (bookedseats - $seatsrequested) ,tblpassengers.status=0 
        WHERE tblpassengers.poolingid = $poolingId";
$result = mysqli_query($con, $updatesql);

if (!$result) {
    die("Error updating booked seats: " . mysqli_error($con));
}  
    }
    else{
    // echo "poolingId: $poolingId, passengerId: $passengerId";

    $selectQuery = "SELECT * FROM tblpassengers WHERE poolingid = $poolingId AND pid = $passengerId";
$selectResult = mysqli_query($con, $selectQuery);

if (!$selectResult) {
    die("Error in SELECT query: " . mysqli_error($con));
}

$rowCount = mysqli_num_rows($selectResult);

if ($rowCount > 0) {
    
    $deleteQuery = "DELETE FROM tblpassengers WHERE poolingid = $poolingId AND pid = $passengerId";
    $deleteResult = mysqli_query($con, $deleteQuery);

    if (!$deleteResult) {
        die("Error updating booked seats: " . mysqli_error($con));
    } else {
        
    }
} else {
    echo "No matching row found for deletion.";
}
$deleteResult = mysqli_query($con, $deleteQuery);

if (!$deleteResult) {
    die("Error deleting row: " . mysqli_error($con));
} else {
    if ($deleteResult) {
        echo '<div class="alert alert-dark" role="alert">
        Deletion successful!
        </div>';
    }
   
}
    }
}
$sql = "SELECT 
        tblpassengers.status,tblpassengers.poolingid,
        tblpassengers.pid,
        tblpooling.carid,
        tbldrivers.driverid,
        tblcars.carnumber,
        tblcars.company,
        tblcars.carname,
        tblpooling.date,
        tblpassengers.seatsRequested,
        tblusers.ContactNo AS DriverPhone,
        tblusers.id,
        tblusers.EmailId,
        tblusers.FullName AS DriverName
        from tblpassengers 
        join  tblpooling on tblpooling.poolingid = tblpassengers.poolingid 
        join tbldrivers on tbldrivers.carid = tblpooling.carid
        JOIN tblcars ON tblpooling.carid = tblcars.carid
        JOIN tblusers ON tbldrivers.driverid = tblusers.id
        where tblpassengers.pid=$userId";

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
                <li><a href="myride.php">Passenger</a></li>
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
                <th scope="col">S.NO</th>
                <th scope="col">Date</th>
                <th scope="col">Driver Name</th>
                <th scope="col">Car Details</th>
                <th scope="col">Contact Number</th>
                <th scope="col">Email</th>
                <!-- <th scope="col">Gender</th> -->
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $counter = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                
                echo "<tr>";
                echo "<th scope='row'>$counter</th>";
                echo "<td>{$row['date']}</td>";
                echo "<td>{$row['DriverName']}</td>";
                
                echo "<td>{$row['carnumber']} | {$row['company']} | {$row['carname']}</td>";
                echo "<td>{$row['DriverPhone']}</td>";
                echo "<td>{$row['EmailId']}</td>";

                // Display status based on the value in tblpassengers.status
                echo "<td>";
                if ($row['status'] == 2) {
                    echo "Not Confirmed";
                } elseif ($row['status'] == 1) {
                    echo "Confirmed";
                } elseif ($row['status'] == 0) {
                    echo "Cancelled";
                }
                echo "</td>";
                
                echo "<td>";
                if ($row['status'] == 2 || $row['status'] == 0 ||$row['status'] == 1 ) {
                    echo "<form method='post'>
                          <input type='hidden' name='passenger_id' value='{$row['pid']}'>
                          <input type='hidden' name='pooling_id' value='{$row['poolingid']}'>
                          <input type='hidden' name='seats_requested' value='{$row['seatsRequested']}'>
                          <input type='hidden' name='status' value='{$row['status']}'>
                          <button type='submit' name='cancel_ride'>Cancel</button>
                          
                          </form>";
                }
                
                echo "</tr>";
                $counter++;
            }
            mysqli_free_result($result);
            ?>
        </tbody>
    </table>


<button type='submit' name='return home' ><a href="index.php">Home</a></button>




</body>
</html>
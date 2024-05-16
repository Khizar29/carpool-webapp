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


if (!$con) {
    die("Sorry we failed to connect: " . mysqli_connect_error());
}
if (isset($_POST['confirm_passenger'])) {
    $passengerId = $_POST['passenger_id'];
    $poolingId = $_POST['pooling_id'];

    // Update tblpassengers.status to 1 for confirmation for a specific pooling
    $updateSql = "UPDATE tblpassengers SET status = 1 WHERE pid = $passengerId AND poolingid = $poolingId";
    mysqli_query($con, $updateSql);

    // Fetch seatprice and carid for the specific pooling
    $poolingInfoSql = "SELECT tblpooling.seatprice, tblpooling.carid FROM tblpooling WHERE tblpooling.poolingid = $poolingId";
    $poolingInfoResult = mysqli_query($con, $poolingInfoSql);
    $poolingInfo = mysqli_fetch_assoc($poolingInfoResult);
    $seatPrice = $poolingInfo['seatprice'];
    $carId = $poolingInfo['carid'];

    // Fetch the total booked seats for the specific pooling
    $bookedSeatsSql = "SELECT SUM(seatsRequested) as totalBookedSeats FROM tblpassengers WHERE poolingid = $poolingId AND status = 1";
    $bookedSeatsResult = mysqli_query($con, $bookedSeatsSql);
    $totalBookedSeats = mysqli_fetch_assoc($bookedSeatsResult)['totalBookedSeats'];

    // Update tblpooling bookedseats
    $updatePoolingSql = "UPDATE tblpooling 
                         SET bookedseats = $totalBookedSeats
                         WHERE poolingid = $poolingId";
    mysqli_query($con, $updatePoolingSql);

    // Check if a bill for this car already exists
    $checkBillSql = "SELECT tblbill.billid , tblbill.carid , tblbill.Amount FROM tblbill
     join tblpooling on tblbill.billid = tblpooling.billid 
     WHERE tblpooling.carid = $carId and poolingid = $poolingId";
    $checkBillResult = mysqli_query($con, $checkBillSql);

    if (mysqli_num_rows($checkBillResult) > 0) {
        // If a bill exists, update the amount
        $updateAmountSql = "UPDATE tblbill join tblpooling on  tblbill.billid = tblpooling.billid 
        SET Amount = ($seatPrice * $totalBookedSeats) WHERE tblbill.carid = $carId and poolingid=$poolingId";
        mysqli_query($con, $updateAmountSql);
    } else {
        // If no bill exists, insert a new record
        $insertBillSql = "INSERT INTO tblbill (carid, Amount) VALUES ($carId, $seatPrice * $totalBookedSeats) ";
        mysqli_query($con, $insertBillSql);

        // Get the auto-incremented billid
        $billId = mysqli_insert_id($con);

        // Update tblpooling billid
        $updateBillIdSql = "UPDATE tblpooling 
                            SET billid = $billId
                            WHERE poolingid = $poolingId";
        mysqli_query($con, $updateBillIdSql);
    }
}

       
        elseif (isset($_POST['cancel_passenger'])) {
        $passengerId = $_POST['passenger_id'];
        $poolingId = $_POST['pooling_id'];

        // Update tblpassengers.status to 0 for cancellation for a specific pooling
        $updateSql = "UPDATE tblpassengers SET status = 0 WHERE pid = $passengerId AND poolingid = $poolingId";
        mysqli_query($con, $updateSql);
    }


// Retrieve pooling_id from the URL parameter
$poolingId = isset($_GET['pooling_id']) ? $_GET['pooling_id'] : 0;


$sql = "SELECT 
        tblusers.FullName as Pname,
        tblusers.Gender,
        tblusers.id,
        tblusers.ContactNo,
        tblusers.EmailId,
        tblpassengers.seatsRequested,
        tblpassengers.status,
        tblpooling.poolingid,
        tblbill.Amount  -- Add this line for tblbill
        FROM tblusers
        JOIN tblpassengers ON tblusers.id = tblpassengers.pid
        JOIN tblpooling ON tblpooling.poolingid = tblpassengers.poolingid
        LEFT JOIN tblbill ON tblbill.billid = tblpooling.billid  -- Add this line for tblbill
        WHERE tblpassengers.poolingid = $poolingId";


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
                <h1>Current Ride Details</h1>
            </div>
            <ul class="coustom-breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li><a href="myride-driver.php">See My Rides</a></li>
            </ul>
        </div>
    </div>
    <!-- Dark Overlay-->
    <div class="dark-overlay"></div>

</section>
<!-- /Page Header-->

<!-- Passenger Details Table -->
<table class="table table-striped table-dark">
    <thead>
        <tr>
            <th scope="col">S.NO</th>
            <th scope="col">Name</th>
            <th scope="col">Gender</th>
            <th scope="col">Contact Number</th>
            <th scope="col">Email</th>
            <th scope="col">Requested no.of seats</th>
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
            echo "<td>{$row['Pname']}</td>";
            echo "<td>{$row['Gender']}</td>";
            echo "<td>{$row['ContactNo']}</td>";
            echo "<td>{$row['EmailId']}</td>";
            echo "<td>{$row['seatsRequested']}</td>";

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

            // Display action buttons based on the status
            echo "<td>";
            if ($row['status'] == 2) {
                echo "<form method='post'>
                      <input type='hidden' name='passenger_id' value='{$row['id']}'>
                      <input type='hidden' name='pooling_id' value='{$row['poolingid']}'>
                      <button type='submit' name='confirm_passenger'>Confirm</button>
                      <button type='submit' name='cancel_passenger'>Cancel</button>
                      </form>";
            }
            echo "</td>";

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
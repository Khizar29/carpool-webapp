<?php
session_start();
error_reporting(E_ALL);
include('includes/config.php');

// Check if the user is logged in
if (isset($_SESSION['login'])) {
    // If logged in, process the booking
    if (isset($_POST['book'])) {
        // Ensure $_SESSION['id'] is set
        $pid = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;
        echo "User ID: " . $_SESSION['userid'];
        $poolingid = $_POST['poolingid'];
        echo "Pooling ID: " . $poolingid . "<br>";
        $status = 2; // Assuming 2 is the status for booked rides
        $seatsrequested = $_POST['seats'];
        

        
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "carpooldb";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

       // Check if the user has already booked the same ride
$checkBookingQuery = "SELECT * FROM tblpassengers WHERE pid = ? AND poolingid = ?";
$checkStmt = $conn->prepare($checkBookingQuery);
$checkStmt->bind_param("ii", $pid, $poolingid);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

$poolingInfo = mysqli_fetch_assoc($checkResult);
$seatr = $poolingInfo['seatsRequested'];
if ($checkResult->num_rows > 0) {
    // User has already booked the same ride, update the existing record
    $updateQuery = "UPDATE tblpassengers SET seatsrequested = ?, status = ? WHERE pid = ? AND poolingid = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $seatsrequested = $seatr + $_POST['seats']; // Update seatsrequested with new value
    $updateStmt->bind_param("iiii", $seatsrequested, $status, $pid, $poolingid);

    if ($updateStmt->execute()) {
        echo "Booking updated successfully!";
        header("Location: myride.php");
        exit();
        // Redirect or perform any other action if needed
    } else {
        echo "Booking update failed. Please try again. Error: " . $updateStmt->error;
    }

    $updateStmt->close();
} else {
    // User is booking for the first time, insert a new record
    $insertQuery = "INSERT INTO tblpassengers (pid, poolingid, status, seatsrequested) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("iiii", $pid, $poolingid, $status, $seatsrequested);

    if ($stmt->execute()) {
        echo "Booking successful!";
        // Redirect to a different page
        header("Location: myride.php");
        exit();
    } else {
        echo "Booking failed. Please try again. Error: " . $stmt->error;
    }

    $stmt->close();
}

$checkStmt->close();
        $conn->close();
    }
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
    <title>Carpool Portal | Page details</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">

    <!-- Custom Style -->
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <!-- OWL Carousel slider-->
    <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
    <!-- slick-slider -->
    <link href="assets/css/slick.css" rel="stylesheet">
    <!-- bootstrap-slider -->
    <link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
    <!-- FontAwesome Font Style -->
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

    <!-- Header -->
    <?php include('includes/header.php'); ?>

    <?php
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "carpooldb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST['search'])) {
        $leaving = $_POST['leaving_from'];
        $going = $_POST['going_to'];
        $seat = $_POST['people'];
        $ridedate = $_POST['from_date'];

        $sql = "SELECT
        tblusers.FullName AS DriverName,
        tblusers.ContactNo AS DriverPhone,
        tblusers.Gender,
        tblroutes.description,
        tblcars.carnumber,
        tblcars.company,
        tblcars.carname,
        tblpooling.seating,
        tblpooling.seatprice,
        tblpooling.starttime,
        tblpooling.endtime,
        tblpooling.date,
        tblpooling.poolingid
    FROM
        tblroutes
    JOIN tblpooling ON tblroutes.routeid = tblpooling.routeid
    JOIN tblcars ON tblpooling.carid = tblcars.carid
    JOIN tbldrivers ON tblpooling.carid = tbldrivers.carid
    JOIN tblusers ON tbldrivers.driverid = tblusers.id
    WHERE
        ((description LIKE CONCAT('%', ?, '%', ?, '%') AND LOCATE(?, description) < LOCATE(?, description))
         OR
        (description LIKE CONCAT('%', ?, '%', ?, '%') AND LOCATE(?, description) < LOCATE(?, description)))
        AND LOCATE(?, description) < LOCATE(?, description) -- Added condition for direction
        AND (tblpooling.seating - tblpooling.bookedseats) >= ?
        AND tblpooling.date = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssssss", $leaving, $going, $leaving, $going, $going, $leaving, $going, $leaving, $leaving, $going, $seat, $ridedate);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<div class="container my-4">
            <table class="table table-dark table-striped" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">DriverName</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Description</th>
                        <th scope="col">Car Details</th>
                        <th scope="col">Date</th>
                        <th scope="col">Start Time</th>
                        <th scope="col">End Time</th>
                        <th scope="col">Price</th>
                        <th scope="col">Contact</th>
                        <th scope="col">Book</th>
                    </tr>
                </thead>
                <tbody>';
            $sno = 0;
            while ($row = $result->fetch_assoc()) {
                $sno = $sno + 1;
                echo "<tr>
                    <th scope='row'>" . $sno . "</th>
                    <td>" . $row['DriverName'] . "</td>
                    <td>" . $row['Gender'] . "</td>
                    <td>" . $row['description'] . "</td>
                    <td>" . $row['carnumber'] . " | " . $row['company'] . " | " . $row['carname'] . "</td>
                    <td>" . $row['date'] . "</td>
                    <td>" . $row['starttime'] . "</td>
                    <td>" . $row['endtime'] . "</td>
                    <td>" . $row['seatprice'] . "</td>
                    <td>" . $row['DriverPhone'] . "</td>
                    <td><button class='book btn btn-sm btn-primary' data-poolingid='" . $row['poolingid'] . "' data-seats='" . $seat . "'>Book</button></td>
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

    <!-- New ADDITIONS MAKING SEARCH BOX IN PAGE 2 -->
    <div class="carpool-search-box">
        <form action="searchride.php" method="POST">
            <div class="search-input-group location-input">
                <label for="leaving-from"><i class="fas fa-map-marker-alt"></i></label>
                <input type="text" name="leaving_from" id="leaving-from" placeholder="Leaving from" required>
            </div>

            <div class="search-input-group location-input">
                <label for="going-to"><i class="fas fa-map-marker-alt"></i></label>
                <input type="text" name="going_to" id="going-to" placeholder="Going to" required>
            </div>

            <div class="search-input-group ridedate">
                <input type="date" name="from_date" value="">
            </div>

            <div class="search-input-group people-input">
                <label for="people"><i class="fas fa-user"></i></label>
                <input type="number" name="people" id="people" min="1" placeholder="Number of people" required>
            </div>

            <!-- New hidden fields for storing poolingid and seats -->
            <input type="hidden" name="poolingid" id="poolingid" value="">
            <input type="hidden" name="seats" id="seats" value="">

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

    <!-- Booking Form Modal -->
<div class="modal fade" id="bookModal" tabindex="-1" role="dialog" aria-labelledby="bookModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookModalLabel">Request for Ride</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Request to driver for your ride will be sent</p>
                <p>Please wait for confirmation</p>
            </div>
            <div class="modal-footer">
                <form action="searchride.php" method="post">
                    <!-- Hidden fields for storing poolingid and seats -->
                    <input type="hidden" name="poolingid" id="modal-poolingid" value="">
                    <input type="hidden" name="seats" id="modal-seats" value="">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="book" class="btn btn-primary">Send Request</button>
                </form>
            </div>
        </div>
    </div>
</div>


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

    <script>
       document.addEventListener("DOMContentLoaded", function () {
    var bookButtons = document.querySelectorAll('.book');

    bookButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            // Set the poolingid and seats values
            var poolingid = this.getAttribute('data-poolingid');
            var seats = this.getAttribute('data-seats');

            // Set the values in the modal form
            document.getElementById('modal-poolingid').value = poolingid;
            document.getElementById('modal-seats').value = seats;

            // Show the modal
            $('#bookModal').modal('show');
        });
    });
});

    </script>
</body>

</html>

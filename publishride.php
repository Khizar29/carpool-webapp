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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['publishride'])) {
    $carNumber = mysqli_real_escape_string($con, $_POST['carNumber']);
    $company = mysqli_real_escape_string($con, $_POST['company']);
    $carname = mysqli_real_escape_string($con, $_POST['carname']);
    $routeId = isset($_POST['routeSelection']) ? (int)$_POST['routeSelection'] : null;
    $routeDescription = mysqli_real_escape_string($con, $_POST['routeDescription']);
    $startTime = date('H:i:s', strtotime($_POST['startTime']));
    $endTime = date('H:i:s', strtotime($_POST['endTime']));
    $sharingDate = date('Y-m-d', strtotime($_POST['sharingDate']));
    $seats = mysqli_real_escape_string($con, $_POST['seats']);
    $pricePerSeat = mysqli_real_escape_string($con, $_POST['pricePerSeat']);

    $imageDir = "D:\carpoolimg"; // Specify your desired directory
    $imageName = $_FILES['image']['name'];
    $imageTmpName = $_FILES['image']['tmp_name'];
    $imagePath = $imageDir . DIRECTORY_SEPARATOR . $imageName;

    if (move_uploaded_file($imageTmpName, $imagePath)) {
        mysqli_begin_transaction($con);

        if ($routeId == 0 && !empty($routeDescription)) {
            $insertRouteQuery = "INSERT INTO tblroutes (description) VALUES (?)";
            $stmtRoute = mysqli_prepare($con, $insertRouteQuery);

            if ($stmtRoute) {
                mysqli_stmt_bind_param($stmtRoute, "s", $routeDescription);
                mysqli_stmt_execute($stmtRoute);

                if (mysqli_stmt_error($stmtRoute)) {
                    mysqli_rollback($con);
                    echo "Error in executing route statement: " . mysqli_stmt_error($stmtRoute);
                    exit();
                } else {
                    $routeId = mysqli_insert_id($con);
                }
            } else {
                mysqli_rollback($con);
                echo "Error in preparing route description statement: " . mysqli_error($con);
                exit();
            }
        }

        // Check if the car with the same car number already exists
        $checkCarQuery = "SELECT carid FROM tblcars WHERE carnumber = ?";
        $stmtCheckCar = mysqli_prepare($con, $checkCarQuery);

        if ($stmtCheckCar) {
            mysqli_stmt_bind_param($stmtCheckCar, "s", $carNumber);
            mysqli_stmt_execute($stmtCheckCar);
            mysqli_stmt_store_result($stmtCheckCar);

            if (mysqli_stmt_num_rows($stmtCheckCar) > 0) {
                // Car with the same car number already exists, fetch the car ID
                mysqli_stmt_bind_result($stmtCheckCar, $existingCarId);
                mysqli_stmt_fetch($stmtCheckCar);
                mysqli_stmt_close($stmtCheckCar);

                // Use the existing car ID in subsequent insertions
                $carId = $existingCarId;
            } else {
                // Car with the same car number doesn't exist, insert a new car
                $insertCarQuery = "INSERT INTO tblcars (carnumber, company, carname, image) VALUES (?, ?, ?, ?)";
                $stmtCar = mysqli_prepare($con, $insertCarQuery);

                if ($stmtCar) {
                    mysqli_stmt_bind_param($stmtCar, "ssss", $carNumber, $company, $carname, $imagePath);
                    mysqli_stmt_execute($stmtCar);

                    if (mysqli_stmt_error($stmtCar)) {
                        mysqli_rollback($con);
                        echo "Error in executing car statement: " . mysqli_stmt_error($stmtCar);
                        exit();
                    } else {
                        // Retrieve the newly inserted car ID
                        $carId = mysqli_insert_id($con);
                    }
                } else {
                    mysqli_rollback($con);
                    echo "Error in preparing car statement: " . mysqli_error($con);
                    exit();
                }
            }
        } else {
            mysqli_rollback($con);
            echo "Error in preparing car check statement: " . mysqli_error($con);
            exit();
        }

        $userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;

        if ($userId) {
            // Check if the driver is already associated with the car
            $checkDriverQuery = "SELECT driverid FROM tbldrivers WHERE driverid = ? AND carid = ?";
            $stmtCheckDriver = mysqli_prepare($con, $checkDriverQuery);

            if ($stmtCheckDriver) {
                mysqli_stmt_bind_param($stmtCheckDriver, "ii", $userId, $carId);
                mysqli_stmt_execute($stmtCheckDriver);
                mysqli_stmt_store_result($stmtCheckDriver);

                if (mysqli_stmt_num_rows($stmtCheckDriver) === 0) {
                    // Driver is not associated with the car, insert a new entry
                    $insertDriverQuery = "INSERT INTO tbldrivers (driverid, carid) VALUES (?, ?)";
                    $stmtDriver = mysqli_prepare($con, $insertDriverQuery);

                    if ($stmtDriver) {
                        mysqli_stmt_bind_param($stmtDriver, "ii", $userId, $carId);
                        mysqli_stmt_execute($stmtDriver);

                        if (mysqli_stmt_error($stmtDriver)) {
                            mysqli_rollback($con);
                            echo "Error in executing driver statement: " . mysqli_stmt_error($stmtDriver);
                            exit();
                        }
                    } else {
                        mysqli_rollback($con);
                        echo "Error in preparing driver statement: " . mysqli_error($con);
                        exit();
                    }
                }
                mysqli_stmt_close($stmtCheckDriver);
            } else {
                mysqli_rollback($con);
                echo "Error in preparing driver check statement: " . mysqli_error($con);
                exit();
            }
        } else {
            mysqli_rollback($con);
            echo "User ID not found in the session.";
            exit();
        }

        $insertPoolingQuery = "INSERT INTO tblpooling (carid, routeid, starttime, endtime, date, seatprice, seating) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmtPooling = mysqli_prepare($con, $insertPoolingQuery);

        if ($stmtPooling) {
            // echo "Debug: carId = $carId, routeId = $routeId, startTime = $startTime, endTime = $endTime, sharingDate = $sharingDate, pricePerSeat = $pricePerSeat, seats = $seats <br>";

            if ($routeId !== null) {
                // echo "Debug: Obtained Route ID = $routeId";
                mysqli_stmt_bind_param($stmtPooling, "iisssdi", $carId, $routeId, $startTime, $endTime, $sharingDate, $pricePerSeat, $seats);
                mysqli_stmt_execute($stmtPooling);

                if (mysqli_stmt_error($stmtPooling)) {
                    mysqli_rollback($con);
                    echo "Error in executing pooling statement: " . mysqli_stmt_error($stmtPooling);
                    exit();
                } else {
                    // Retrieve the last inserted pooling_id
                $lastPoolingId = mysqli_insert_id($con);

                // Commit the transaction
                mysqli_commit($con);

                // Redirect to confirmpassenger.php with the lastPoolingId as a parameter
                header("Location: confirmpassenger.php?pooling_id=$lastPoolingId");
                exit();
                                
                }
            } else {
                mysqli_rollback($con);
                echo "Error: Route ID is null. Check the form submission. routeId = $routeId";
                exit();
            }
        } else {
            mysqli_rollback($con);
            echo "Error in preparing pooling statement: " . mysqli_error($con);
            exit();
        }

    } else {
        echo "Error uploading image.";
        exit();
    }
}

$sqlRoutes = "SELECT routeid, description FROM tblroutes";
$resultRoutes = mysqli_query($con, $sqlRoutes);

if (!$resultRoutes) {
    die("Error fetching routes: " . mysqli_error($con));
}

// ... (remaining HTML code remains unchanged)
?>


<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title>Carpool Portal | Publish a Ride</title>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>



    <!-- SWITCHER -->
    <!-- <link rel="stylesheet" id="switcher-css" type="text/css" href="assets/switcher/css/switcher.css" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/red.css" title="red" media="all" data-default-color="true" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/orange.css" title="orange" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" title="blue" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/pink.css" title="pink" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/green.css" title="green" media="all" /> -->
    <!-- <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/purple.css" title="purple" media="all" /> -->
    <!-- <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">  -->

    <style>
    

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    input[type="text"],
    input[type="number"],
    input[type="file"],
    textarea {
        width: 20%; 
        padding: 8px;
        box-sizing: border-box;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
        
        /* Styles for the file input */
        .custom-file {
            margin-left: 20px;
            margin-top: 10px;
        }

        /* Styles for the table */
        .my-table {
            margin-top: 20px;
        }

        .my-table th, .my-table td {
            text-align: center;
        }

        .my-table th {
            background-color: #343a40;
            color: #ffffff;
        }

        .my-table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .my-table tbody tr:hover {
            background-color: #ddd;
        }
        #publishride{
            margin-top: 5px;
            margin-left: 20px;
            margin-bottom: 20px;
        }
    </style>
  
<script>
    function searchRoutes() {
        var input, filter, select, options, i, option, txtValue;
        input = document.getElementById("routeSearch");
        filter = input.value.toUpperCase();
        select = document.getElementById("routeSelection");
        options = select.getElementsByTagName("option");

        // Create a new select element
        var newSelect = document.createElement("select");
        newSelect.id = "routeSelection"; // Make sure to set the same ID

        // If the input is empty, add all options to the new select
        if (filter === "") {
            for (i = 0; i < options.length; i++) {
                newSelect.add(options[i].cloneNode(true));
            }
        } else {
            for (i = 0; i < options.length; i++) {
                option = options[i];
                txtValue = option.textContent || option.innerText;

                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    // Clone the option and append it to the new select
                    newSelect.add(option.cloneNode(true));
                }
            }
        }

        // Replace the original select with the new one
        select.parentNode.replaceChild(newSelect, select);
    }
</script>
    
</head>
<body>

<!-- Start Switcher -->
<?php include('includes/colorswitcher.php');?>
<!-- /Switcher -->  

<!--Header-->
<?php include('includes/header.php');?>
<!-- /Header --> 

<!--Page Header-->
<section class="page-header profile_page">
    <div class="container">
        <div class="page-header_wrap">
            <div class="page-heading">
                <h1>Publish a Ride</h1>
            </div>
            <ul class="coustom-breadcrumb">
                <li><a href="#">Home</a></li>
                <li>Publish a ride</li>
            </ul>
        </div>
    </div>
    <!-- Dark Overlay-->
    <div class="dark-overlay"></div>
</section>
<!-- /Page Header--> 


<!-- ADD A CAR FORM -->
<form id="carpoolForm" method="post" action="publishride.php" enctype="multipart/form-data" onsubmit="return validateRouteSelection()">
    <div class="form-group">
        <label for="carNumber">Car Number:</label>
        <input type="text" name="carNumber" id="carNumber" required>
    </div>

    <div class="form-group">
        <label for="company">Company:</label>
        <input type="text" name="company" id="company" required>
    </div>

    <div class="form-group">
        <label for="carname">Car Name:</label>
        <input type="text" name="carname" id="carname" required>
    </div>

    <div class="form-group">
    <label for="sharingDate">Date:</label>
    <input type="text" name="sharingDate" id="sharingDate" required>
    </div>
    
    <!-- <div class="form-group">
        <label for="routeSearch">Search for Route:</label>
        <input type="text" name="routeSearch" id="routeSearch" oninput="searchRoutes()">
    </div> -->

    <div class="form-group">
        <label for="routeSelection">Select Route:</label>
        <select name="routeSelection" id="routeSelection">
            <?php
            if ($resultRoutes) {
                while ($row = mysqli_fetch_assoc($resultRoutes)) {
                    echo "<option value='" . $row['routeid'] . "'>" . $row['description'] . "</option>";
                }
                mysqli_free_result($resultRoutes);
            } else {
                echo "Error fetching routes: " . mysqli_error($con);
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label id="dscbox" for="routeDescription">Route Description (if not in the list):</label>
        <textarea name="routeDescription" id="routeDescription" rows="4"></textarea>
    </div>

    <div class="form-group">
    <label for="startTime">Start Time:</label>
    <input type="text" name="startTime" id="startTime" required>
    </div>

    <div class="form-group">
        <label for="endTime">End Time:</label>
        <input type="text" name="endTime" id="endTime" required>
    </div>


    <div class="form-group">
        <label for="seats">Number of Seats:</label>
        <input type="number" name="seats" id="seats" min="1" required>
    </div>

    <div class="form-group">
        <label for="pricePerDay">Price per Seat:</label>
        <input type="number" name="pricePerSeat" id="pricePerDay" min="0" step="50" required>
    </div>

    <div class="form-group">
        <label for="image">Image:</label>
        <input type="file" name="image" id="image" accept="image/*" required>
    </div>
    
    <input type="hidden" name="routeId" id="routeId" value="">

    <button  name="publishride" id="publishride" type="submit">Submit</button>

</form>
<!-- End of ADD A CAR FORM -->



<!-- Footer -->
<?php include('includes/footer.php');?>
<!-- /Footer--> 

<!-- Back to top -->
<div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
<!-- /Back to top --> 

<!-- Login-Form -->
<?php include('includes/login.php');?>
<!-- /Login-Form --> 

<!-- Register-Form -->
<?php include('includes/registration.php');?>

<!-- /Register-Form --> 

<!-- Forgot-password-Form -->
<?php include('includes/forgotpassword.php');?>
<!-- /Forgot-password-Form --> 


<script>
    document.getElementById('carpoolForm').addEventListener('submit', function (event) {
    var startTime = document.getElementById('startTime').value;
    var endTime = document.getElementById('endTime').value;

    // Parse time values into Date objects
    var startDate = flatpickr.parseDate(startTime, "h:i K");
    var endDate = flatpickr.parseDate(endTime, "h:i K");

    if (startDate >= endDate) {
        alert('End time must be greater than start time.');
        event.preventDefault();
    }
});

</script> 
<script>
    flatpickr("#startTime", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "h:i K", // Use 12-hour format with AM/PM
});

flatpickr("#endTime", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "h:i K", // Use 12-hour format with AM/PM
});

flatpickr("#sharingDate", {
    enableTime: false,
    dateFormat: "Y-m-d",
});


    function validateRouteSelection() {
    var selectedRoute = document.getElementById("routeSelection").value;
    var routeDescription = document.getElementById("routeDescription").value;

    if (selectedRoute === "0" && routeDescription.trim() === "") {
        alert("Please select a route from the list or enter a route description.");
        return false;
    }

    return true;
}

</script>





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
<?php  ?>
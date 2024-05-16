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
    <title>Carpool Portal | Waiting for the Ride to Start</title>
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

    <style>
        /* Your existing styles */

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

        .custom-file {
            margin-left: 20px;
            margin-top: 10px;
        }

        #countdownContainer {
            position: fixed;
            bottom: 10px;
            left: 10px;
            text-align: center;
            margin-top: 20px;
            width: 15%;
        }

        #timeToStart {
            font-size: 20px;
            text-align: center;
            margin-top: 10px;
            color: #333;
        }

        #countdown {
            font-size: 36px;
            color: #333;
        }

        #homeButton {
            position: fixed;
            bottom: 10px;
            right: 10px;
            width: 20%; /* Adjusted width */
        }
    </style>
</head>
<body>

    <!--Page Header-->
    <section class="page-header profile_page">
        <div class="container">
            <div class="page-header_wrap">
                <div class="page-heading">
                    <h1>Waiting for the Ride to Start</h1>
                </div>
                <ul class="coustom-breadcrumb">
                    <li><a href="#">Publish a Ride</a></li>
                    <li>Waiting for the Ride to Start</li>
                </ul>
            </div>
        </div>
        <!-- Dark Overlay-->
        <div class="dark-overlay"></div>
    </section>
    <!-- /Page Header--> 

    <div id="countdownContainer">
        <div id="timeToStart">Time to Start the Ride</div>
        <div id="countdown"></div>
    </div>

    <div id="homeButton" class="text-center">
        <a href="index.php" class="btn btn-primary btn-lg">Home</a>
    </div>

    <script>
    function updateCountdown(targetTime) {
        var now = new Date();
        var timeDifference = targetTime - now;

        var hours = Math.floor(timeDifference / (1000 * 60 * 60)).toString().padStart(2, '0');
        var minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0');
        var seconds = Math.floor((timeDifference % (1000 * 60)) / 1000).toString().padStart(2, '0');

        var countdownTime = ${hours}:${minutes}:${seconds};

        // Update countdown timer
        document.getElementById('countdown').innerText = countdownTime;

        if (timeDifference <= 0) {
            // Display a message when the time has elapsed
            document.getElementById('countdown').innerText = 'Time has elapsed';
        }
    }

    // Fetch remaining time from the database using PHP
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "carpooldb";
    $poolingid = $_SESSION['alogin'];
    $sql = "SELECT starttime FROM tblpooling WHERE poolingid=:poolingid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':poolingid', $poolingid, PDO::PARAM_STR);
    $query->execute();

    if ($query) {
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $stoppingTime = $row['starttime'];

        // Format the stopping time in a way that JavaScript can understand
        $formattedTime = date("Y-m-d\TH:i:s", strtotime($stoppingTime));

        echo "console.log('Formatted Time:', '$formattedTime');\n";
        echo "var targetTime = new Date('$formattedTime');\n";
        echo "setInterval(function() { updateCountdown(targetTime); }, 1000);\n";
    } else {
        echo "console.error('Error fetching data from the database');\n";
    }
    ?>
    </script>

</body>
</html>
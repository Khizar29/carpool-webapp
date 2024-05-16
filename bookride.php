<?php
session_start();
include('includes/config.php');


$servername = "localhost";
$username = "root";
$password = "";
$database = "carpooldb";


$con = mysqli_connect($servername, $username, $password, $database);

// Die if connection was not successful
if (!$con) {
    die("Sorry we failed to connect: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    

    $userId = $_POST['userId'];
    $poolingId = $_POST['poolingId'];
    $status = $_POST['status'];
    $seatsRequested = $_POST['seatsRequested'];

    // Insert into tblpassengers
    $insertPassenger = $con->prepare("INSERT INTO tblpassengers (pid, poolingid, status, seatsRequested) VALUES (?, ?, ?, ?)");
    $insertPassenger->bind_param("iiii", $userId, $poolingId, $status, $seatsRequested);
    
    if ($insertPassenger->execute()) {
        // Booking successful
        echo json_encode(["success" => true]);
    } else {
        // Booking failed
        echo json_encode(["success" => false, "error" => $con->error]);
    }

    $insertPassenger->close();
    $con->close();
} else {
    // Handle the case where the request method is not POST
    echo json_encode(["success" => false, "error" => "Invalid request method"]);
}
?>

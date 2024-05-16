<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{

    // Connect to the Database 
$servername = "localhost";
$username = "root";
$password = "";
$database = "carpooldb";

// Create a connection
$con = mysqli_connect($servername, $username, $password, $database);

    $sql = "SELECT tblpooling.poolingid, tblpooling.date, 
    tblpooling.starttime, tblpooling.endtime,
    tblpooling.seatprice, tblpooling.bookedseats,
    tblcars.company, tblcars.carnumber, tblcars.carname,
    tblroutes.description,
    tblusers.FullName
      from tblpooling  
      join tblcars on tblpooling.carid = tblcars.carid
      join tbldrivers on tbldrivers.carid = tblcars.carid
      join tblusers on tblusers.id = tbldrivers.driverid
      join tblroutes on tblroutes.routeid = tblpooling.routeid ";

$result = mysqli_query($con, $sql);

if (!$result) {
    die("Error in SQL query: " . mysqli_error($con));
}
 ?>

<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	
	<title>Carpool Portal |Admin View Pooling   </title>

	<!-- Font awesome -->
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- Sandstone Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Bootstrap Datatables -->
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<!-- Bootstrap social button library -->
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<!-- Bootstrap select -->
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<!-- Bootstrap file input -->
	<link rel="stylesheet" href="css/fileinput.min.css">
	<!-- Awesome Bootstrap checkbox -->
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<!-- Admin Stye -->
	<link rel="stylesheet" href="css/style.css">
  <style>
		.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
		</style>

</head>

<body>
	<?php include('includes/header.php');?>

	<div class="ts-main-content">
		<?php include('includes/leftbar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">

						<h2 class="page-title">View Pooling</h2>

						<!-- Zero Configuration Table -->
						<div class="panel panel-default">
							<div class="panel-heading">Pooling History</div>
							<div class="panel-body">
							
								<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
										<th>Pooling Id</th>
											<th>Driver Name</th>
											<th>Car Details</th>
											<th>Route Description</th>
											<th>Date</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Seat Price</th>
                                            <th>Booked Seats</th>
											<!-- <th>Action</th> -->
										</tr>
									</thead>
									<tfoot>
										<tr>
										<th>Pooling Id</th>
											<th>Driver Name</th>
											<th>Car Details</th>
											<th>Route Description</th>
											<th>Date</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Seat Price</th>
                                            <th>Booked Seats</th>
										</tr>
									</tfoot>
									<tbody>
                                    <?php
            
            while ($row = mysqli_fetch_assoc($result)) {
                
                echo "<tr>";
                // echo "<th scope='row'>$counter</th>";
                echo "<td>{$row['poolingid']}</td>";
                echo "<td>{$row['FullName']}</td>";
                
                echo "<td>{$row['carnumber']} | {$row['company']} | {$row['carname']}</td>";
                echo "<td>{$row['description']}</td>";
                echo "<td>{$row['date']}</td>";
                echo "<td>{$row['starttime']}</td>";
                echo "<td>{$row['endtime']}</td>";
                echo "<td>{$row['seatprice']}</td>";
                echo "<td>{$row['bookedseats']}</td>";
                
                echo "</tr>";
                // $counter++;
            }
            mysqli_free_result($result);
            ?>
						
										
                        </tbody>
    </table>

						

							</div>
						</div>

					

					</div>
				</div>

			</div>
		</div>
	</div>

	<!-- Loading Scripts -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>
</body>
</html>
<?php } ?>

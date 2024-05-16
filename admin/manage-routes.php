<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
if(isset($_REQUEST['eid']))
	{
$eid=intval($_GET['eid']);
// $status="2";
$sql = "DELETE from tblroutes  WHERE  routeid=:eid";
$query = $dbh->prepare($sql);

$query-> bindParam(':eid',$eid, PDO::PARAM_STR);
$query -> execute();

$msg="Route Successfully removed";

}
if (isset($_POST['addroute'])) {
	$routeDescription = $_POST['description'];
	$sql = "INSERT INTO tblroutes (description) VALUES (:description)";
	$query = $dbh->prepare($sql);
	$query->bindParam(':description', $routeDescription, PDO::PARAM_STR);
	$query->execute();
	$msg = "Route Successfully added";
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
	
	<title>Carpool Portal |Admin Manage Routes   </title>

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

						<h2 class="page-title">Manage Routes</h2>
			
						<form method="post" action="">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="description" placeholder="Enter Route Description" aria-label="Enter Route Description" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" name="addroute" type="submit">Add Route</button>
                                </div>
                            </div>
                        </form>
						<!-- Zero Configuration Table -->
						<div class="panel panel-default">
						
							<div class="panel-heading">Routes Info</div>
							<div class="panel-body">
							<?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
								<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
										<th>Route ID</th>
											<th>Route Description</th>
											<th>Action</th>
										</tr>
									</thead>
									<tfoot>
									<th>Route ID</th>
											<th>Route Description</th>
											<th>Action</th>
										</tr>
									</tfoot>
									<tbody>

									<?php $sql = "SELECT  routeid , description from  tblroutes  ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
// $cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{				?>	
	<tr>
		
		<td><?php echo htmlentities($result->routeid);?></td>
		<td><?php echo htmlentities($result->description);?></td>
		<td>
		<a href="manage-routes.php?eid=<?php echo htmlentities($result->routeid);?>" onclick="return confirm('Do you really want to remove this route')"> Remove</a>
		</td>
											

		</tr>
		<?php } }?>
		
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

<?php
include('database_connection.php');

$statement = $connect->prepare("
	SELECT * FROM tbl_order
	ORDER BY order_id DESC
	");

$statement->execute();

$all_result = $statement->fetchAll();

$total_rows = $statement->rowCount(); 


?>

<!DOCTYPE html>
<html>
<head>
	<title>INSIDE NOLLYWOOD</title>
	  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300, 400,700" rel="stylesheet">

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">

    <link rel="stylesheet" href="fonts/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker3.css">
    <link rel="stylesheet" href="css/datepicker.css">

    <!-- Theme Style -->
    <link rel="stylesheet" href="css/style.css">


	<style>
		.navbar {
			margin-bottom: 4px;
			border-radius: 0;
		}
		footer {
			padding: 5px 40px;

		}
		.navbar-brand:hover {
			background-color: #ffffff;
		}
	</style>

</head>
<body>
<h3 align="center">Inside Nollywood Invoice</h3><br>
<div id="page-wrapper" style="margin-top: 0px; min-height: 30px;">
        <div class="container-fluid">
			<div class="row">
                <div class="col-lg-12">
          					<h3 class="page-header">
              		               <style type="text/css">
              		                .fa-check {
              		                  color: green;
              		                }
              		               </style>
                             			Hello, <?php //echo $_GET['user']; ?>
          						            <div class="pull-right">
              			                <ol class="breadcrumb">
              			                      <li><a href="admin_home.php">Home</a></li>
              			                    <li class="active">>>>></li>
              			                    <li><a href="logout.php">Logout</a></li>
              			                </ol>
          			                 </div>
          					</h3>
                </div>
            </div>
            <div class="col-lg-12">
            	<div class="alert alert-success fade in flash_message">
            		<strong>Successfully Logged In...</strong><br>
            		<strong>Welcome...</strong>
            	</div>
            </div>
        </div>
    </div>
	<?php
	if (isset($_GET["update"]) && isset($_GET["id"])) {
				$statement = $connect->prepare("
					SELECT * FROM tbl_order WHERE order_id = :order_id LIMIT 1
					");
				$statement->execute(
					array(':order_id' => $_GET["id"])
					);
				$result = $statement->fetchAll();
				foreach ($result as $row) {
				?>
				<script>
				
				</script>
				<div align="right">
			<a href="view_invoice.php" class="btn btn-info  btn-xs">Back</a>
		</div>
				<form method="post" id="invoice_form">
				<div class="table-responsive">
				<table class="table table-bordered">
				<tr>
				<td colspan="2" align="center"><h2 style="margin-top: 10.5px;">VIEW INVOICE</h2></td>
				</tr>
				<tr>
				<td colspan="2">
					<div class="row">
					<div class="col-md-8">
						To, <br>
						<b>RECIEVER (BILL TO)</b> <br>
						<input type="text" name="order_reciever_name" id="order_reciever_name" class="form-control input-sm" 
						value="<?php echo $row["order_reciever_name"]; ?>" readonly/>
						<textarea name="order_reciever_address" id="order_reciever_address" class="form-control" 
						readonly><?php echo $row["order_reciever_address"]; ?>
						</textarea>
					</div>
					<div class="col-md-4">
						REVERSE CHARGE<br>
						<input type="text" name="order_no" id="order_no" class="form-control input-sm" 
					     value="<?php echo $row["order_no"]; ?>" readonly/>
						<input type="text" name="order_date" id="order_date" class="form-control input-sm datepicker" 
						readonly value="<?php echo $row["order_date"]; ?>" readonly/>
					</div>
					</div>
					<table id="invoice-item-table" class="table table-bordered">
					<tr>
						<th>Sr. No</th>
						<th>Item Name</th>
						<th>Quantity</th>
						<th>Price</th>
						<th>Actual Amt.</th>
						<th colspan="2">Tax1 (%)</th>
						<th colspan="2">Tax2 (%)</th>
						<th colspan="2">Tax3 (%)</th>
						<th rowspan="2">Total</th>
						<th rowspan="2"></th>
					</tr>
					<tr>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th>Rate</th>
						<th>Amt.</th>
						<th>Rate</th>
						<th>Amt.</th>
						<th>Rate</th>
						<th>Amt.</th>
					</tr>
					<?php
						$statement = $connect->prepare("
							SELECT * FROM tbl_order_item WHERE order_id = :order_id
							");
						$statement->execute(
							array(':order_id' => $_GET["id"])
							);
						$item_result = $statement->fetchAll();
						$m = 0;
						foreach ($item_result as $sub_row) {
							$m = $m + 1;
						
					?>
					<tr>
						<td><span id="sr_no"><?php echo $m; ?></span></td>
						<td><input type="text" name="item_name[]" id="item_name<?php echo $m; ?>" class="form-control input-sm" value="<?php echo $sub_row["item_name"]; ?>" readonly/></td>
						<td><input type="text" name="order_item_quantity[]" id="order_item_quantity<?php echo $m; ?>" data-srno="<?php echo $m; ?>" class="form-control input-sm order_item_quantity" value="<?php echo $sub_row["order_item_quantity"]; ?>" readonly/></td>
						<td><input type="text" name="order_item_price[]" id="order_item_price<?php echo $m; ?>" data-srno="<?php echo $m; ?>" class="form-control input-sm number_only order_item_price" value="<?php echo $sub_row["order_item_price"]; ?>" readonly/></td>
						<td><input type="text" name="order_item_actual_amount[]" id="order_item_actual_amount<?php echo $m; ?>" data-srno="<?php echo $m; ?>" class="form-control input-sm order_item_actual_amount" value="<?php echo $sub_row["order_item_actual_amount"]; ?>" readonly /></td>
						<td><input type="text" name="order_item_tax1_rate[]" id="order_item_tax1_rate<?php echo $m; ?>" data-srno="<?php echo $m; ?>" class="form-control input-sm number_only order_item_tax1_rate" value="<?php echo $sub_row["order_item_tax1_rate"]; ?>" readonly/></td>
						<td><input type="text" name="order_item_tax1_amount[]" id="order_item_tax1_amount<?php echo $m; ?>" data-srno="<?php echo $m; ?>" value="<?php echo $sub_row["order_item_tax1_amount"]; ?>" readonly class="form-control input-sm order_item_tax1_amount" /></td>
						<td><input type="text" name="order_item_tax2_rate[]" id="order_item_tax2_rate<?php echo $m; ?>" data-srno="<?php echo $m; ?>" class="form-control input-sm number_only order_item_tax2_rate"  value="<?php echo $sub_row["order_item_tax2_rate"]; ?>" readonly/></td>
						<td><input type="text" name="order_item_tax2_amount[]" id="order_item_tax2_amount<?php echo $m; ?>" data-srno="<?php echo $m; ?>" value="<?php echo $sub_row["order_item_tax2_amount"]; ?>" readonly class="form-control input-sm order_item_tax2_amount" /></td>
						<td><input type="text" name="order_item_tax3_rate[]" id="order_item_tax3_rate<?php echo $m; ?>" data-srno="<?php echo $m; ?>" class="form-control input-sm number_only order_item_tax3_rate" value="<?php echo $sub_row["order_item_tax3_rate"]; ?>" readonly/></td>
						<td><input type="text" name="order_item_tax3_amount[]" id="order_item_tax3_amount<?php echo $m; ?>" data-srno="<?php echo $m; ?>" value="<?php echo $sub_row["order_item_tax3_amount"]; ?>" readonly class="form-control input-sm order_item_tax3_amount" /></td>
						<td><input type="text" name="order_item_final_amount[]" id="order_item_final_amount<?php echo $m; ?>" data-srno="<?php echo $m; ?>" value="<?php echo $sub_row["order_item_final_amount"]; ?>" readonly class="form-control input-sm order_item_final_amount" /></td>

					</tr>
					<?php
				}
					?>
					</table>
					<div align="right">
						
					</div>
				</td>
				</tr>
				<tr>
					<td align="right"><b>Total</b></td>
					<td align="right"><b><span id="final_total_amt"><?php echo $row["order_total_after_tax"]; ?></span></b></td>
				</tr>
				<tr>
					<td colspan="2" align="center">
					<input type="hidden" name="total_item" id="total_item" value="<?php echo $m; ?>" />
					<input type="hidden" name="order_id" id="order_id" value="<?php echo $row["order_id"]; ?>" />
					
					</td>
					
				</tr>
				</table>
				</div>
				</form>
				
				<?php
				}
			} else {
			?>
			<?php
			
				?>
		<div align="right">
			<a href="invoice.php?add=1" class="btn btn-info  btn-xs">Create</a>
		</div>
		<br>
	<table id="data-table" class="table table-bordered table-stripped">
		<thead>
			<tr>
				<th>Invoice. No</th>
				<th>Invoice Date</th>  
				<th>Reciever Name</th>
				<th>Invoice. Total</th>
				<th>PDF</th>
				<th>View</th>
				<th>Delete</th>
			</tr>
		</thead>
		<?php
			if ($total_rows > 0) {
				foreach ($all_result as $row) {
					echo '
						<tr>
						   <td>'.$row["order_no"].'</td>
						   <td>'.$row["order_date"].'</td>
						   <td>'.$row["order_reciever_name"].'</td>
						   <td>'.$row["order_total_after_tax"].'</td>
						   <td><a href="print_invoice.php?pdf=1&id='.$row["order_id"].'">PDF</a></td>
						   <td><a href="view_invoice.php?update=1&id='.$row["order_id"].'"><span class="glyphicon glyphicon-edit"></span>
						   </a></td>
						   <td><a href="invoice.php?delete=1&id='.$row["order_id"].'" id="'.$row["order_id"].'" class="delete"><span class="glyphicon glyphicon-remove"></span>
						   </a></td>
						</tr>
					';
				}
			}
		?>
	</table>

	<?php
}
	
	?>
	</div>

	<footer class="container-fluid text-center">
		<p>Footer Text</p>
	</footer>
<script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/jquery-migrate-3.0.0.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/jquery.stellar.min.js"></script>
    <script type="text/javascript"  src="js/jquery.js"></script>
	<script type="text/javascript"  src="js/init.js"></script>
	<script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
    
    <script src="js/main.js"></script>
</body>
</html>
<script type="text/javascript">

	
</script>
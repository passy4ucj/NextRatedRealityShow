<?php
//echo "string";
include('database_connection.php');

$statement = $connect->prepare("
	SELECT * FROM tbl_order
	ORDER BY order_id DESC
	");

$statement->execute();

$all_result = $statement->fetchAll();

$total_rows = $statement->rowCount(); 

if (isset($_POST["create_invoice"])) {
	$order_total_before_tax = 0;
	$order_total_tax1 = 0;
	$order_total_tax2 = 0;
	$order_total_tax3 = 0;
	$order_total_tax = 0;
	$order_total_after_tax = 0;
	$job_done = "NO";

	$statement = $connect->prepare("
		INSERT INTO tbl_order (order_no, order_date, order_reciever_name, order_reciever_address, order_total_before_tax, order_total_tax1, order_total_tax2, order_total_tax3, order_total_tax, order_total_after_tax, order_datetime, job_done)
		VALUES (:order_no, :order_date, :order_reciever_name, :order_reciever_address, :order_total_before_tax, :order_total_tax1, :order_total_tax2, :order_total_tax3, :order_total_tax, :order_total_after_tax, :order_datetime, :job_done)
		");
	$statement->execute(
		array(':order_no' => trim($_POST["order_no"]), ':order_date' => trim($_POST["order_date"]), ':order_reciever_name' => trim($_POST["order_reciever_name"]), ':order_reciever_address' => trim($_POST["order_reciever_address"]), ':order_total_before_tax' => $order_total_before_tax, ':order_total_tax1' => $order_total_tax1, ':order_total_tax2' => $order_total_tax2, ':order_total_tax3' => $order_total_tax3, ':order_total_tax' => $order_total_tax, ':order_total_after_tax' => $order_total_after_tax, ':order_datetime' => date("Y-m-d"), ':job_done' => $job_done  )
		);
	$statement = $connect->query("SELECT LAST_INSERT_ID()");
	$order_id = $statement->fetchColumn();

	for ($count=0; $count < $_POST["total_item"] ; $count++) { 
		$order_total_before_tax = $order_total_before_tax + floatval(trim($_POST["order_item_actual_amount"][$count]));

		$order_total_tax1 = $order_total_tax1 + floatval(trim($_POST["order_item_tax1_amount"][$count]));

		$order_total_tax2 = $order_total_tax2 + floatval(trim($_POST["order_item_tax2_amount"][$count]));

		$order_total_tax3 = $order_total_tax3 + floatval(trim($_POST["order_item_tax3_amount"][$count]));

		$order_total_after_tax = $order_total_after_tax + floatval(trim($_POST["order_item_final_amount"][$count]));

		$statement = $connect->prepare("
			INSERT INTO tbl_order_item (order_id, item_name, order_item_quantity, order_item_price, order_item_actual_amount, order_item_tax1_rate, order_item_tax1_amount, order_item_tax2_rate, order_item_tax2_amount, order_item_tax3_rate, order_item_tax3_amount, order_item_final_amount, job_done)
			VALUES (:order_id, :item_name, :order_item_quantity, :order_item_price, :order_item_actual_amount, :order_item_tax1_rate, :order_item_tax1_amount, :order_item_tax2_rate, :order_item_tax2_amount, :order_item_tax3_rate, :order_item_tax3_amount, :order_item_final_amount, :job_done)
			");
		$statement->execute(
			array(':order_id' => $order_id, ':item_name' => trim($_POST["item_name"][$count]), ':order_item_quantity' => trim($_POST["order_item_quantity"][$count]), ':order_item_price' => trim($_POST["order_item_price"][$count]), ':order_item_actual_amount' => trim($_POST["order_item_actual_amount"][$count]), ':order_item_tax1_rate' => trim($_POST["order_item_tax1_rate"][$count]), ':order_item_tax1_amount' => trim($_POST["order_item_tax1_amount"][$count]), ':order_item_tax2_rate' => trim($_POST["order_item_tax2_rate"][$count]), ':order_item_tax2_amount' => trim($_POST["order_item_tax2_amount"][$count]), ':order_item_tax3_rate' => trim($_POST["order_item_tax3_rate"][$count]), ':order_item_tax3_amount' => trim($_POST["order_item_tax3_amount"][$count]), ':order_item_final_amount' => trim($_POST["order_item_final_amount"][$count]), ':job_done' => $job_done )
			);

	}

	$order_total_tax = $order_total_tax1 + $order_total_tax2 + $order_total_tax3;

	$statement = $connect->prepare("
		UPDATE tbl_order SET order_total_before_tax = :order_total_before_tax, order_total_tax1 = :order_total_tax1, order_total_tax2 = :order_total_tax2, order_total_tax3 = :order_total_tax3, order_total_tax = :order_total_tax, order_total_after_tax = :order_total_after_tax
		WHERE order_id = :order_id
		");
	$statement->execute(
		array(':order_total_before_tax' => $order_total_before_tax, ':order_total_tax1' => $order_total_tax1, ':order_total_tax2' => $order_total_tax2, ':order_total_tax3' => $order_total_tax3, ':order_total_tax' => $order_total_tax, ':order_total_after_tax' => $order_total_after_tax, ':order_id' => $order_id )
		);
	header("location:invoice.php");
}

if (isset($_POST["update_invoice"])) {
	$order_total_before_tax = 0;
	$order_total_tax1 = 0;
	$order_total_tax2 = 0;
	$order_total_tax3 = 0;
	$order_total_tax = 0;
	$order_total_after_tax = 0;
	$order_id = $_POST["order_id"];

	$statement = $connect->prepare("
		DELETE FROM tbl_order_item WHERE order_id = :order_id
		");
	$statement->execute(
		array(':order_id' => $order_id )
		);
	for ($count=0; $count <= $_POST["total_item"]; $count++) { 
		$order_total_before_tax = $order_total_before_tax + floatval(trim($_POST["order_item_actual_amount"][$count]));
		$order_total_tax1 = $order_total_tax1 + floatval(trim($_POST["order_item_tax1_amount"][$count]));
		$order_total_tax2 = $order_total_tax2 + floatval(trim($_POST["order_item_tax2_amount"][$count]));
		$order_total_tax3 = $order_total_tax3 + floatval(trim($_POST["order_item_tax3_amount"][$count]));
		$order_total_after_tax = $order_total_after_tax + floatval(trim($_POST["order_item_final_amount"][$count]));

		$statement = $connect->prepare("
			INSERT INTO tbl_order_item (order_id, item_name, order_item_quantity, order_item_price, order_item_actual_amount, order_item_tax1_rate, order_item_tax1_amount, order_item_tax2_rate, order_item_tax2_amount, order_item_tax3_rate, order_item_tax3_amount, order_item_final_amount)
			VALUES (:order_id, :item_name, :order_item_quantity, :order_item_price, :order_item_actual_amount, :order_item_tax1_rate, :order_item_tax1_amount, :order_item_tax2_rate, :order_item_tax2_amount, :order_item_tax3_rate, :order_item_tax3_amount, :order_item_final_amount)
			");
		$statement->execute(
			array(':order_id' => $order_id, ':item_name' => trim($_POST["item_name"][$count]), ':order_item_quantity' => trim($_POST["order_item_quantity"][$count]), ':order_item_price' => trim($_POST["order_item_price"][$count]), ':order_item_actual_amount' => trim($_POST["order_item_actual_amount"][$count]), ':order_item_tax1_rate' => trim($_POST["order_item_tax1_rate"][$count]), ':order_item_tax1_amount' => trim($_POST["order_item_tax1_amount"][$count]), ':order_item_tax2_rate' => trim($_POST["order_item_tax2_rate"][$count]), ':order_item_tax2_amount' => trim($_POST["order_item_tax2_amount"][$count]), ':order_item_tax3_rate' => trim($_POST["order_item_tax3_rate"][$count]), ':order_item_tax3_amount' => trim($_POST["order_item_tax3_amount"][$count]), ':order_item_final_amount' => trim($_POST["order_item_final_amount"][$count])  )
			);
	}
	$order_total_tax = $order_total_tax1 + $order_total_tax2 + $order_total_tax3;

	$statement = $connect->prepare("
		UPDATE tbl_order SET order_no = :order_no, order_date = :order_date, order_reciever_name = :order_reciever_name, order_reciever_address = :order_reciever_address, order_total_before_tax = :order_total_before_tax, order_total_tax1 = :order_total_tax1, order_total_tax2 = :order_total_tax2, order_total_tax3 = :order_total_tax3, order_total_tax = :order_total_tax, order_total_after_tax = :order_total_after_tax
		WHERE order_id = :order_id
		");
	$statement->execute(
		array(':order_no' => trim($_POST["order_no"]), ':order_date' => trim($_POST["order_date"]), ':order_reciever_name' => trim($_POST["order_reciever_name"]), ':order_reciever_address' => trim($_POST["order_reciever_address"]), ':order_total_before_tax' => $order_total_before_tax, ':order_total_tax1' => $order_total_tax1, ':order_total_tax2' => $order_total_tax2, ':order_total_tax3' => $order_total_tax3, ':order_total_tax' => $order_total_tax, ':order_total_after_tax' => $order_total_after_tax, ':order_id' => $order_id )
		);
	header("location:invoice.php");
}

if (isset($_GET["delete"]) && isset($_GET["id"])) {
	$statement = $connect->prepare("
		DELETE FROM tbl_order WHERE order_id = :id
		");
	$statement->execute(
		array(':id' => $_GET["id"] )
		);

	$statement = $connect->prepare("
		DELETE FROM tbl_order_item WHERE order_id = :id
		");
	$statement->execute(
		array(':id' => $_GET["id"] )
		);
	header("location:invoice.php");
}
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
	<style>
		.box {
			width: 100%;
			max-width: 1390px;
			border-radius: 5px;
			border: 1px solid #ccc;
			padding: 15px;
			margin: 0 auto;
			margin-top: 50px;
			box-sizing: border-box;
		}
	</style>
	<script>
		
	// 	$(document).ready(function() {
	//     $('#order_date').datepicker();
	//     $('#order_date').datepicker('setDate', 'today');
	// });​
	</script>
	<div class="container-fluid">
		<?php
			if (isset($_GET["add"])) {
				?>
				<form method="post" id="invoice_form">
				<div class="table-responsive">
				<table class="table table-bordered">
				<tr>
				<td colspan="2" align="center"><h2 style="margin-top: 10.5px;">CREATE INVOICE</h2></td>
				</tr>
				<tr>
				<td colspan="2">
					<div class="row">
					<div class="col-md-8">
						To, <br>
						<b>RECIEVER (BILL TO)</b> <br>
						<input type="text" name="order_reciever_name" id="order_reciever_name" class="form-control input-sm" 
						placeholder="Enter Reciever Name" />
						<textarea name="order_reciever_address" id="order_reciever_address" class="form-control" 
						placeholder="Enter Billing Address">
						</textarea>
					</div>
					<div class="col-md-4">
						REVERSE CHARGE<br>
						<input type="text" name="order_no" id="order_no" class="form-control input-sm" 
						placeholder="Enter Invoice No." />
						<input type="text" name="order_date" id="order_date" class="form-control input-sm datepicker" 
						readonly placeholder="Enter Select Invoice Date" />
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
					<tr>
						<td><span id="sr_no">1</span></td>
						<td><input type="text" name="item_name[]" id="item_name1" class="form-control input-sm" /></td>
						<td><input type="text" name="order_item_quantity[]" id="order_item_quantity1" data-srno="1" class="form-control input-sm order_item_quantity" /></td>
						<td><input type="text" name="order_item_price[]" id="order_item_price1" data-srno="1" class="form-control input-sm number_only order_item_price" /></td>
						<td><input type="text" name="order_item_actual_amount[]" id="order_item_actual_amount1" data-srno="1" class="form-control input-sm order_item_actual_amount" readonly /></td>
						<td><input type="text" name="order_item_tax1_rate[]" id="order_item_tax1_rate1" data-srno="1" class="form-control input-sm number_only order_item_tax1_rate" /></td>
						<td><input type="text" name="order_item_tax1_amount[]" id="order_item_tax1_amount1" data-srno="1" readonly class="form-control input-sm order_item_tax1_amount" /></td>
						<td><input type="text" name="order_item_tax2_rate[]" id="order_item_tax2_rate1" data-srno="1" class="form-control input-sm number_only order_item_tax2_rate" /></td>
						<td><input type="text" name="order_item_tax2_amount[]" id="order_item_tax2_amount1" data-srno="1" readonly class="form-control input-sm order_item_tax2_amount" /></td>
						<td><input type="text" name="order_item_tax3_rate[]" id="order_item_tax3_rate1" data-srno="1" class="form-control input-sm number_only order_item_tax3_rate" /></td>
						<td><input type="text" name="order_item_tax3_amount[]" id="order_item_tax3_amount1" data-srno="1" readonly class="form-control input-sm order_item_tax3_amount" /></td>
						<td><input type="text" name="order_item_final_amount[]" id="order_item_final_amount1" data-srno="1" readonly class="form-control input-sm order_item_final_amount" /></td>

					</tr>
					</table>
					<div align="right">
						<button type="button" name="add_row" id="add_row" class="btn btn-success btn-xs">+</button>
					</div>
				</td>
				</tr>
				<tr>
					<td align="right"><b>Total</b></td>
					<td align="right"><b><span id="final_total_amt"></span></b></td>
				</tr>
				<tr>
					<td colspan="2" align="center"><input type="hidden" name="total_item" id="total_item" value="1" />
					<input type="submit" name="create_invoice" id="create_invoice" class="btn btn-info" Value="create" />
					</td>
					
				</tr>
				</table>
				</div>
				</form>

				<script type="text/javascript">
				
				</script>
				<?php
			}

			elseif (isset($_GET["update"]) && isset($_GET["id"])) {
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
				<form method="post" id="invoice_form">
				<div class="table-responsive">
				<table class="table table-bordered">
				<tr>
				<td colspan="2" align="center"><h2 style="margin-top: 10.5px;">EDIT INVOICE</h2></td>
				</tr>
				<tr>
				<td colspan="2">
					<div class="row">
					<div class="col-md-8">
						To, <br>
						<b>RECIEVER (BILL TO)</b> <br>
						<input type="text" name="order_reciever_name" id="order_reciever_name" class="form-control input-sm" 
						value="<?php echo $row["order_reciever_name"]; ?>" />
						<textarea name="order_reciever_address" id="order_reciever_address" class="form-control" 
						><?php echo $row["order_reciever_address"]; ?>
						</textarea>
					</div>
					<div class="col-md-4">
						REVERSE CHARGE<br>
						<input type="text" name="order_no" id="order_no" class="form-control input-sm" 
					     value="<?php echo $row["order_no"]; ?>" />
						<input type="text" name="order_date" id="order_date" class="form-control input-sm datepicker" 
						readonly value="<?php echo $row["order_date"]; ?>" />
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
						<td><input type="text" name="item_name[]" id="item_name<?php echo $m; ?>" class="form-control input-sm" value="<?php echo $sub_row["item_name"]; ?>"/></td>
						<td><input type="text" name="order_item_quantity[]" id="order_item_quantity<?php echo $m; ?>" data-srno="<?php echo $m; ?>" class="form-control input-sm order_item_quantity" value="<?php echo $sub_row["order_item_quantity"]; ?>" /></td>
						<td><input type="text" name="order_item_price[]" id="order_item_price<?php echo $m; ?>" data-srno="<?php echo $m; ?>" class="form-control input-sm number_only order_item_price" value="<?php echo $sub_row["order_item_price"]; ?>" /></td>
						<td><input type="text" name="order_item_actual_amount[]" id="order_item_actual_amount<?php echo $m; ?>" data-srno="<?php echo $m; ?>" class="form-control input-sm order_item_actual_amount" value="<?php echo $sub_row["order_item_actual_amount"]; ?>" readonly /></td>
						<td><input type="text" name="order_item_tax1_rate[]" id="order_item_tax1_rate<?php echo $m; ?>" data-srno="<?php echo $m; ?>" class="form-control input-sm number_only order_item_tax1_rate" value="<?php echo $sub_row["order_item_tax1_rate"]; ?>" /></td>
						<td><input type="text" name="order_item_tax1_amount[]" id="order_item_tax1_amount<?php echo $m; ?>" data-srno="<?php echo $m; ?>" value="<?php echo $sub_row["order_item_tax1_amount"]; ?>" readonly class="form-control input-sm order_item_tax1_amount" /></td>
						<td><input type="text" name="order_item_tax2_rate[]" id="order_item_tax2_rate<?php echo $m; ?>" data-srno="<?php echo $m; ?>" class="form-control input-sm number_only order_item_tax2_rate"  value="<?php echo $sub_row["order_item_tax2_rate"]; ?>" /></td>
						<td><input type="text" name="order_item_tax2_amount[]" id="order_item_tax2_amount<?php echo $m; ?>" data-srno="<?php echo $m; ?>" value="<?php echo $sub_row["order_item_tax2_amount"]; ?>" readonly class="form-control input-sm order_item_tax2_amount" /></td>
						<td><input type="text" name="order_item_tax3_rate[]" id="order_item_tax3_rate<?php echo $m; ?>" data-srno="<?php echo $m; ?>" class="form-control input-sm number_only order_item_tax3_rate" value="<?php echo $sub_row["order_item_tax3_rate"]; ?>" /></td>
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
					<input type="submit" name="update_invoice" id="update_invoice" class="btn btn-info" Value="Edit" />
					</td>
					
				</tr>
				</table>
				</div>
				</form>
				
				<?php
				}
			}
			else
			{


		?>
		<h3 align="center">Inside Nollywood Invoice List</h3><br>
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
				<th>Edit</th>
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
						   <td><a href="invoice.php?update=1&id='.$row["order_id"].'"><span class="glyphicon glyphicon-edit"></span>
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
		<p></p>
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
	$(document).ready(function(){
		var table = $('#data-table').DataTable();
	});

	
</script>
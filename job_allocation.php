<?php include('database_connection.php');  //include('cn.php');  $GLOBALS['error_msg'] = ""; $GLOBALS['username']=''; //validate_user(); 

$job_done = "NO";
$statement = $connect->prepare("
  SELECT * FROM tbl_order WHERE job_done = :job_done
  ORDER BY order_id DESC
  ");

$statement->execute(
  array(':job_done' => $job_done )
  );

$all_result = $statement->fetchAll();

$total_rows = $statement->rowCount(); 

if (isset($_POST["job_allocate"])) {
      
      $order_id = $_POST["order_id"];
      $job_status = "Job In Progress";
  for ($count=0; $count <= $_POST["total_item"]; $count++) { 
    //$staff_id = $_POST["staff_id"][$count];
      
         
      
     $statement = $connect->prepare("
      INSERT INTO job_allocation1 (staff_id, order_id, job_type)
      VALUES (:staff_id, :order_id, :job_type)
      ");
    $statement->execute(
      array(':staff_id' => trim($_POST["staff_name"][$count]), ':order_id' => $order_id, ':job_type' => trim($_POST["job_type"][$count]) )
      );
    $work_status = "WORKING";
  $statement = $connect->prepare("
    UPDATE staff_table SET work_status = :work_status
    WHERE staff_id = :staff_id
    ");
  $statement->execute(
    array(':work_status' => $work_status, ':staff_id' => trim($_POST["staff_name"][$count]) )
    );
  
  }
  $job_done = "JOB IN PROGRESS";
  $statement = $connect->prepare("
    UPDATE tbl_order SET job_done = :job_done
    WHERE order_id = :order_id
    ");
  $statement->execute(
    array(':job_done' => $job_done, ':order_id' => $order_id )
    );
  


  header("location:admin_home.php");
}



?>

<!doctype html>
<html lang="en">
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

    <!-- Theme Style -->
    <link rel="stylesheet" href="css/style.css">
  </head>
<body>

<!-- nav bar -->
	<header role="banner">
     

      <div class="container logo-wrap">
        <div class="row pt-5">
          <div class="col-12 text-center">
            
            <!-- <h1 class="site-logo"><a href="index.html"><img src="images/next3.jpg" width="800"></a></h1> -->
           <a href="index.html" class="site-logo" ><h4 width="100%">INSIDE NOLLYWOOD</h4></a>
          </div>
        </div>
      </div>
      
     
    </header>
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
                             			Hello, <?php //echo $_GET['id']; ?>
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
	<!-- Jumbotron -->
	<div class="jumbotron">
  <?php 
  if (isset($_GET["allocate"]) && isset($_GET["id"])) {
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
        <td colspan="2" align="center"><h2 style="margin-top: 10.5px;">JOB ALLOCATION</h2></td>
        </tr>
        <tr>
        <td colspan="2">
          <div class="row">
          <div class="col-md-8">
            To, <br>
            <b>RECIEVER (NAME OF CLIENT)</b> <br>
            <input type="text" name="order_reciever_name" id="order_reciever_name" class="form-control input-sm" readonly
            value="<?php echo $row["order_reciever_name"]; ?>" />
            
          </div>
          <div class="col-md-4">
            DATE<br>
            
            <input type="text" name="order_date" id="order_date" class="form-control input-sm datepicker" 
            readonly value="<?php echo $row["order_date"]; ?>" />
          </div>
          </div>
          <table id="invoice-item-table" class="table table-bordered">
          <tr>
            <th>Sr. No</th>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Job Type</th>
            <th>Workers</th>
            
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
            <td><select name="job_type[]" id="job_type<?php echo $m; ?>" class="form-control">
            
                  <option value="" selected="selected">- JoB Type -</option>
                 
                  <option value="Photo Studio">Photo Studio</option>
                  <option value="Video Editing">Video Editing</option>
                  <option value="Audio Editing">Audio Editing</option>
               
                </select></td>
            <?php
            $work_status = "YES";
            $statement = $connect->prepare("
              SELECT * FROM staff_table WHERE work_status = :work_status
              ");
            $statement->execute(
              array(':work_status' => $work_status)
              );

            $staff_result = $statement->fetchAll();
          
            
            
            ?>
            
            <td>
            <select name="staff_name[]" id="staff_name<?php echo $m; ?>" class="form-control">
            
                  <option value="" selected="selected">- Allocate Job -</option>
                   <?php foreach ($staff_result as $name) {  ?>
                  <option value="<?php echo $name["staff_id"]; ?>"><?php echo $name["first_name"]; ?></option>
                   <?php
      
      }
          ?>
                </select>
           </td>
           <td><input type="hidden" name="total_item" id="total_item"  value="<?php echo $m; ?>" /></td>
           
          

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
          <td colspan="2" align="center">
          
          <input type="hidden" name="order_id" id="order_id" value="<?php echo $row["order_id"]; ?>" />

          <input type="submit" name="job_allocate" id="job_allocate" class="btn btn-info" Value="Allocate" />
          </td>
          
        </tr>
        </table>
        </div>
        </form>
        
        <?php
        }
      } else {
      ?>
		<div class="container text-center">
			<h1>INSIDE NOLLYWOOD ADMIN PAGE</h1>
			<p>JOB ALLOCATION</p>

	<div class="container">
		<div class="row">
			
    <br>
  <table id="data-table" class="table table-bordered table-stripped">
    <thead>
      <tr>
        <th>Invoice. No</th>
        <th>Invoice Date</th>  
        <th>Reciever Name</th>
        <th>Invoice. Total</th>
        <th>Allocate</th>
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
               <td><a href="job_allocation.php?allocate=1&id='.$row["order_id"].'"><span class="glyphicon glyphicon-edit"></span>
               </a></td>
               
            </tr>
          ';
        }
      }
    ?>
  </table>
		</div>
    </div>
    <?php } ?>
		
		<div class="page-header">
			<div class="container">
			
			</div>
		</div>
	 </div>
  </div>
	<?php //include 'footer.php'; ?>
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





<?php
function validate_user(){
$cn = mysqli_connect($GLOBALS['host'], $GLOBALS['user'], $GLOBALS['pwd']);
mysqli_select_db($cn, $GLOBALS['db']);

$email = mysqli_real_escape_string($cn, $_GET['user']);
$key = mysqli_real_escape_string($cn, $_GET['key']);

$sql = "select email, password from admin_access where email='$email' ";

$res = mysqli_query($cn, $sql);
$row = mysqli_fetch_array($res);

if($key == md5($row['password'])) get_num_of_new_default_acct_recs($cn);
else header("Location:admin_login.php");  mysqli_close($cn);}


function get_num_of_new_default_acct_recs($cn){ $num_recs = 0;
$sql = "select count(*) as num_recs from default_account ";

$res = mysqli_query($cn, $sql);
$num_rows = mysqli_num_rows($res);

if($num_rows>0){ 
$row = mysqli_fetch_array($res);
$num_recs = $row['num_recs']; }  $GLOBALS['num_new_recs'] = $num_recs;
}


function show_new_recs(){if($GLOBALS['num_new_recs']>0) echo '(',$GLOBALS['num_new_recs'],')';}?>
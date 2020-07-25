<?php include('database_connection.php');   error_reporting(E_ERROR); //include('cn.php');  $GLOBALS['error_msg'] = ""; $GLOBALS['username']=''; //validate_user(); 


if (isset($_POST["submit_complain"])) {
  //$work_status = "YES";
  $statement = $connect->prepare("
    INSERT INTO suggesstion_table (name, phone_no, email, message, order_date)
    VALUES (:name, :phone_no, :email, :message, :order_date)
    ");
  $statement->execute(
    array(':name' => trim($_POST["name"]), ':phone_no' => trim($_POST["phone_no"]), ':email' => trim($_POST["email"]), ':message' => trim($_POST["message"]), ':order_date' => trim($_POST["order_date"]) )
    );
 
  header("location:staff_dashboard.php");
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
                             			Hello, <?php echo $_GET['user']; ?>
          						            <div class="pull-right">
              			                <ol class="breadcrumb">
              			                      
              			                   
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
		<div class="container text-center">
			<h1>INSIDE NOLLYWOOD STAFF PAGE</h1>
      <?php
         $staff_id = $_GET["staff_id"];
            $statement = $connect->prepare("
              SELECT * FROM job_allocation1 WHERE staff_id = :staff_id
              ");
            $statement->execute(
              array(':staff_id' => $staff_id)
              );

            $staff_result = $statement->fetchAll();
           foreach ($staff_result as $name) { 
            ?>
                  <h3>JOB TYPE</h3>
                  <h4><?php echo $name["job_type"]; ?></h4>
                  <h3>JOB STATUS</h3>
                  <h4><?php echo $name["job_status"]; ?></h4>
                  <div class="btn-group">
                  <a href="admin_home.php?admin_create=1" class="btn btn-lg btn-primary">Transfer Job</a>
                  <!--<a href="" class="btn btn-lg btn-default">visitor</a>-->
                </div>
                <div class="btn-group">
                  <a href="admin_home.php?admin_create=1" class="btn btn-lg btn-primary">Job Done</a>
                  <!--<a href="" class="btn btn-lg btn-default">visitor</a>-->
                </div>
      <?php
      }
        
      ?>
			<p>SUGGESSTION FORM</p>
       <div class="col-md-12 col-lg-8 main-content">
            
            <form method="post" id="submit_complain_form">
                  <div class="row">
                    <div class="col-md-4 form-group">
                      <label for="name">Name</label>
                      <input type="text" id="name" name="name" class="form-control ">
                    </div>
                    <div class="col-md-4 form-group">
                      <label for="phone">Phone</label>
                      <input type="text" id="phone_no" name="phone_no" class="form-control ">
                    </div>
                    <div class="col-md-4 form-group">
                      <label for="email">Email</label>
                      <input type="email" id="email" name="email" class="form-control ">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 form-group">
                      <label for="message">Write Message</label>
                      <textarea name="message" id="message" name="message" class="form-control " cols="30" rows="8"></textarea>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 form-group">
                    <label for="date"> Date</label>
                  <input type="text" name="order_date" id="order_date" class="form-control input-sm datepicker" 
                       readonly placeholder="Enter Select Invoice Date" />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 form-group">
                      <input type="submit" name="submit_complain" id="submit_complain" value="Send Message" class="btn btn-primary">
                    </div>
                  </div>
                </form>
            

          </div>
	</div><!-- end of jumbotron -->
	<div class="container">
		<div class="row">
			<div class="col-lg-3">
				
			</div>
			<div class="col-lg-3">
				
			</div>
			




		</div>
    </div>
		
		<div class="page-header">
			<div class="container">
			
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
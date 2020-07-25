<?php include('database_connection.php');   error_reporting(E_ERROR); //include('cn.php');  $GLOBALS['error_msg'] = ""; $GLOBALS['username']=''; //validate_user(); 



$GLOBALS['num_new_recs'] = ""; 

if (isset($_POST["submit"])) {
  $work_status = "NO";
  $statement = $connect->prepare("
    INSERT INTO staff_table (first_name, last_name, email, password, order_date, job_role, gender, work_status)
    VALUES (:first_name, :last_name, :email, :password, :order_date, :job_role, :gender, :work_status)
    ");
  $statement->execute(
    array(':first_name' => trim($_POST["first_name"]), ':last_name' => trim($_POST["last_name"]), ':email' => trim($_POST["email"]), ':password' => trim($_POST["password"]), ':order_date' => trim($_POST["order_date"]), ':job_role' => trim($_POST["job_role"]), ':gender' => trim($_POST["gender"]), ':work_status' => $work_status )
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
                             			Hello, <?php echo $_GET['user']; ?>
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
		<div class="container text-center">
			<h1>INSIDE NOLLYWOOD ADMIN PAGE</h1>
			<p>ADMIN VIEW</p>
      <?php
      if (isset($_GET["admin_create"])) {
        ?>
        <div class="row">
        <!--<div class="col-lg-2">
          <p>Please fill in your correct info</p>
        </div>-->

        <div class="col-lg-8">
          <form action="" method="post" class="form-horizontal" id="submit_form">
          <?php //if(isset($_POST['submit'])) register_super_account(); ?>
           
            <div class="form-group">
              <label for="first_name" class="col-lg-4 control-label">First Name</label>
              <div class="col-lg-8">
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="peter">
              </div>
            </div>
            <div class="form-group">
              <label for="last_name" class="col-lg-4 control-label">Last Name</label>
              <div class="col-lg-8">
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Good">
              </div>
            </div>
            <div class="form-group">
              <label for="email" class="col-lg-4 control-label">Email</label>
              <div class="col-lg-8">
                <input type="email" class="form-control" id="email" name="email" placeholder="peter@yahoo.com">
              </div>
            </div>
            <div class="form-group">
              <label for="password" class="col-lg-4 control-label">Password</label>
              <div class="col-lg-8">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
              </div>
            </div>
            <div class="form-group">
              <label for="confirm_password" class="col-lg-4 control-label">Confirm Password</label>
              <div class="col-lg-8">
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
              </div>
            </div>
            <div class="form-group">
              <label for="dob" class="col-lg-4 control-label">Date Of Birth</label>
              <div class="col-lg-8">
                <input type="text" name="order_date" id="order_date" class="form-control input-sm datepicker" 
            readonly placeholder="Enter Select Date Of Birth" />
              </div>
            </div>
            <div class="form-group">
              <label for="job_role" class="col-lg-4 control-label">Job Role</label>
              <div class="col-lg-8">
                <select name="job_role" id="job_role" class="form-control">
                  <option value="" selected="selected">- Select -</option>
                  <option value="manager">Manager</option>
                  <option value="secretary">Secretary</option>
                  <option value="video_editor">Video Editor</option>
                  <option value="audio_manager">Audio Manager</option>
                  <option value="photo_manager">Photo Manager</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="gender" class="col-lg-4 control-label">Gender:</label>
              <div class="col-lg-8">
                    <input type="radio" name="gender" id="gender" value="Male" />
                    <label for="option1">Male</label> 
                    <input type="radio" name="gender" id="gender"  value="Female" />
                    <label for="option2">Female</label>
              </div>
            </div>
            
            

            

            
           
            
            <div class="form-group">
              <div class="col-lg-8 col-lg-offset-4">
                <button type="submit" name="submit" id="submit" class="btn btn-primary btn-block">SUBMIT</button><br>
                <!--<button type="submit" class="btn btn-primary">CLEAR</button>-->
                
                <!--<input type="submit" name="submit" value="register" class="btn btn-primary">-->
                
              </div>
              
            </div>
          </form>
        </div>
      </div>
        <?php
      } elseif (isset($_GET["suggesstion"])) {
      ?>
      
      <?php //get_news();
      $statement = $connect->prepare("
              SELECT * FROM suggesstion_table
              ORDER BY order_date DESC LIMIT 3
              ");
      $statement->execute();
      $all_result = $statement->fetchAll();

    $total_rows = $statement->rowCount(); 

if ($total_rows > 0) {
        foreach ($all_result as $row) {
          echo '
          <table>
            <tr>
               <td>'.$row["order_date"].'</td>
               <td>'.$row["message"].'</td>
               <td>'.$row["email"].'</td>
               <td>'.$row["phone_no"].'</td>
               
               
            </tr>
            </table>
          ';
        }
      }


       ?>
      
      
      
      
      
        <?php
      //}
      }else {
        ?>
      
			<div class="btn-group">
				<a href="admin_home.php?admin_create=1" class="btn btn-lg btn-primary">CREATE ACCOUNT..</a>
				<!--<a href="" class="btn btn-lg btn-default">visitor</a>-->
			</div>
      <div class="btn-group">
          <a href="job_allocation.php" class="btn btn-lg btn-primary">ALLOCATE JOB</a>
        </div>
        <div class="btn-group">
          <a href="view_invoice.php" class="btn btn-lg btn-primary">VIEW INVOICE</a>
        </div>
        <div class="btn-group">
          <a href="admin_home.php?suggesstion=1" class="btn btn-lg btn-primary">SUGGESSTION PANEL</a>
        </div>
        
		</div> <!-- end container -->
    <div class="container text-center">
      <div class="btn-group">
          <a href="completed_job.php" class="btn btn-lg btn-primary">VIEW COMPLETED JOBs</a>
        </div>
     
      <?php } ?>  
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
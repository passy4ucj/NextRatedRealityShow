<?php include('database_connection.php');  //include('cn.php');  $GLOBALS['error_msg'] = ""; $GLOBALS['username']=''; //validate_user(); 



$GLOBALS['num_new_recs'] = ""; 
if (isset($_POST["submit"])) {
  //$job_role = "";
  $statement = $connect->prepare("
    SELECT email, password, job_role, staff_id FROM staff_table WHERE email = :email AND password = :password AND job_role = :job_role
    ");
  $statement->execute(
    array(':email' => trim($_POST["email"]), ':password' => trim($_POST["password"]), ':job_role' => trim($_POST["job_role"]) )
    );

  $all_result = $statement->fetchAll();

  $total_rows = $statement->rowCount();
  if ($total_rows > 0) {
        foreach ($all_result as $row) {
         $key = md5($row['password']);
         $email = $row['email'];
         $role = $row['job_role'];
         $staff_id = $row['staff_id'];

        }
        if ($role == "manager") {
        header("location:admin_home.php?user=$email&key=$key&staff_id=$staff_id");
      } elseif ($role == "secretary"){
       header("location:invoice.php?user=$email&key=$key&staff_id=$staff_id");
      }
      else{
       header("location:staff_dashboard.php?user=$email&key=$key&staff_id=$staff_id");
      }
      }
      

 
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
        
	<!-- Jumbotron -->
	<div class="jumbotron">
		<div class="container text-center">
			<h1>INSIDE NOLLYWOOD LOGIN PAGE</h1>
      <div class="container">
    <section>
    <div class="page-header text-center" id="">
      <h3>We Love You</h3>
      <p>Enter your Info correctly</p>
    </div>
      <div class="row">
        <!--<div class="col-lg-2">
          <p>Please fill in your correct info</p>
        </div>-->

        <div class="col-lg-10">
          <form action="" method="post" class="form-horizontal">
          <?php //if(isset($_POST['submit'])) echo $GLOBALS['error_msg']; ?>
            <div class="form-group">
              <label for="email" class="col-lg-4 control-label">Your  Email</label>
              <div class="col-lg-8">
                <input class="form-control" id="email" name="email" placeholder="Peter@gmail.com">
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-8 "></div>
            </div>
            <div class="form-group">
              <label for="password" class="col-lg-4 control-label">Password</label>
              <div class="col-lg-8">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required="">
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
              <div class="col-lg-8 "></div>
            </div>
            <div class="form-group">
              <div class="col-lg-8 "></div>
            </div>
            <div class="form-group">
              <div class="col-lg-8 col-lg-offset-4">
                <button type="submit" name="submit" class="btn btn-primary btn-block">SUBMIT</button><br>
                <p style="text-center"><a href="reset_password.php">forgot your password?</a></p>
              </div>
              
            </div>
          </form>
        </div>
      </div>
    </section>
  </div>
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
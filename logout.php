<?php //require_once("includes/functions.php"); ?>
<?php
  //Four steps to closing a session
  //(i.e logging out )

  //1. find the session
 session_start();

 //2. unset all the session variables
 $_SESSION = array();

 //3. Destroy the session cookie
 if (isset($_COOKIE[session_name()])) {
 	setcookie(session_name(), '', time()-42000, '/');
 }

 //4. Destroy the session
 session_destroy();

 header("Location: index.php?logout=1");
 ?>
<?php
include "db.php";

 header("Content-Type:JSON");
 header('Access-Control-Allow-Origin: *');
 header('Access-Control-Allow-Methods:GET');
 header('Access-Control-Allow-Headers:Access-Control-Allow-Methods');
 session_start();


 if($_SERVER["REQUEST_METHOD"] = "GET"){

 	if (isset($_GET['logout'])) {
	  	session_destroy();
	  	unset($_SESSION['sess_user']);
	  	// header("location: login.php");
	  	echo json_encode(array("message"=>"You are logged out","status"=>true));
  	}else{
  		echo json_encode(array("message"=>"Page not found","status"=>false));
  	}
	
 }


 ?>
<?php
include "db.php";

 header("Content-Type:JSON");
 header('Access-Control-Allow-Origin: *');
 header('Access-Control-Allow-Methods:POST');
 header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,
 Access-Control-Allow-Methods,Authorization,X-Requested-With');

 $data=json_decode(file_get_contents("php://input"),true);


if($_SERVER["REQUEST_METHOD"] = "POST"){
	$email=$data['email'];
	$sql=mysqli_query($con,"select email,pass from registration where email='$email'");
	$row=mysqli_fetch_array($sql);
	if($row>0){
		$email = $row['email'];
		$subject = "Information about your password";
		$password=$row['pass'];
		$message = "Your password is ".$password;
		mail($email, $subject, $message, "From: $email");
		echo json_encode(array("message"=>"Your Password has been sent Successfully","status"=>true));
	}else{
		echo json_encode(array("message"=>"Email not register with us","status"=>false));
	}
}
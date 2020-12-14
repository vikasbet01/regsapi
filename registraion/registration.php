<?php
include "db.php";

 header("Content-Type:JSON");
 header('Access-Control-Allow-Origin: *');
 header('Access-Control-Allow-Methods:POST');
 header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,
 Access-Control-Allow-Methods,Authorization,X-Requested-With');

 $data=json_decode(file_get_contents("php://input"),true);


if($_SERVER["REQUEST_METHOD"] = "POST"){

	$user_name=$data['user_name'];
	$email=$data['email'];
	$mobile=$data['mobile'];
	$pass=md5($data['pass']);
	$confirm_pass=md5($data['confirm_pass']);

	if(empty($data['user_name']) || empty($data['email']) || empty($data['mobile']) || empty($data['pass']) || empty($data['confirm_pass'])){
		echo json_encode(array("message"=>"Please Fill in all Required Fields!","status"=>false));
	}
	

	if(!preg_match ('^[0-9A-Za-z_]+$^', $user_name) or !preg_match ("/^[a-zA-z]*$/", $user_name)){  
	echo json_encode(array("message"=>"Please Enter Valid User Name","status"=>false));
	} 
	//$pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";  
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)){  
	    echo json_encode(array("message"=>"Please Enter Valid Email Address","status"=>false)); 
	} 

	if(strlen($mobile)<10){
		echo json_encode(array("message"=>"Please Enter Valid Mobile No.","status"=>false));
	}
	if($pass!=$confirm_pass){
		echo json_encode(array("message"=>"Please Enter Same Password.","status"=>false));
	}

	$user_check_query = "SELECT * FROM registration WHERE user_name='$user_name' OR email='$email' LIMIT 1";

	$res=mysqli_query($con,$user_check_query);
	if(mysqli_num_rows($res) > 0){
		while($user = mysqli_fetch_assoc($res)){
			if ($user) { // if user exists
			    if ($user['user_name'] == $user_name || $user['email'] == $email) {
			      echo json_encode(array("message"=>"Username/Email Already exists.","status"=>false));
			    }
			    // if ($user['email'] == $email) {
			    //   echo json_encode(array("message"=>"Email Already exists.","status"=>false));
			    // }
		  	}	
		}
	}else{
		$error=false;
		if (!$error) {
			if(mysqli_query($con, "insert into registration(user_name,email,mobile,pass,confirm_pass) values('$user_name','$email','$mobile','$pass','$confirm_pass')")) {
				echo json_encode(array("message"=>"Registration Successful","status"=>true));
			} else {
				echo json_encode(array("message"=>"Registration Fail","status"=>false));
			}
		}
	}
}

?>
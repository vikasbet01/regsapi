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
	$pass=md5($data['pass']);

	if(empty($data['user_name']) || empty($data['email']) || empty($data['pass'])){
		echo json_encode(array("message"=>"Please Fill in all Required Fields!","status"=>false));
	}

	$user_check_query = "SELECT * FROM registration WHERE user_name='$user_name' OR email='$email' LIMIT 1";

	$res=mysqli_query($con,$user_check_query);
	if(mysqli_num_rows($res) > 0){
		while($row = mysqli_fetch_assoc($res)){
			if ($row) {
			    if (($row['user_name'] == $user_name || $row['email'] == $email) && $row['pass']==$pass) {

		    	    session_start();  
				    $_SESSION['sess_user']=$user_name;  

			      	echo json_encode(array("message"=>"Login Successful.","status"=>true));
			      	// header("Location: index.php");
			    }else{
			    	echo json_encode(array("message"=>"Please check Id and password.","status"=>false));
			    }
		  	}	
		}
	}
}

?>
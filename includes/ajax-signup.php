<?php

	header('Content-type: application/json');

	include_once('connection.php');
	
	$response = array();

	if ($_POST) {
		
		$name = trim($_POST['name']);
		$email = trim($_POST['email']);
		//$pass = trim($_POST['cpassword']);
		
		$full_name = strip_tags($name);
		$user_email = strip_tags($email);
		//$user_pass = strip_tags($pass);
		
		// sha256 password hashing
		//$hashed_password = hash('sha256', $user_pass);
		
		$query = $dbh->prepare("INSERT INTO subscribers(fullName, userEmail, subscriber_timestamp) VALUES(?,?,?)");
		$query->bindValue(1,$full_name);
		$query->bindValue(2,$user_email);
		$query->bindValue(3,time());
		
		// check for successfull registration
        if ( $query->execute() ) {
			$response['status'] = 'success';
			$response['message'] = '<span class="glyphicon glyphicon-ok"></span> &nbsp; Thanks for subscribing to our newsletter!';
        } else {
            $response['status'] = 'error'; // could not register
			$response['message'] = '<span class="glyphicon glyphicon-info-sign"></span> &nbsp; Could not register your email, please try again later.';
        }	
	}
	
	echo json_encode($response);
<?php

	include_once('connection.php');

	if ( isset($_REQUEST['email']) && !empty($_REQUEST['email']) ) {
		
		$email = trim($_REQUEST['email']);
		$email = strip_tags($email);
		
		$query = $dbh->prepare( "SELECT userEmail FROM subscribers WHERE userEmail=?");
		$query->bindValue(1, $email);
		$query->execute();
		$num = $query->rowCount();
		
		if ($num == 1) {
			echo 'false'; // email already taken
		} else {
			echo 'true'; 
		}
	}
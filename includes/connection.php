<?php

//insert your database details here
$dsn = 'mysql:dbname=YOUR DB NAME;host=YOUR HOST NAME';
$user = 'YOUR DB USER NAME';
$password = 'YOUR DB PASSWORD';

try {
    $dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage(). '<br>';
    echo "Oops...something went wrong. Please check you have entered the correct details for the database credentials";
}

?>
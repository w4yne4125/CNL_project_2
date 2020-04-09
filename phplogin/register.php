<?php
session_start();
// Change this to your connection info.
$DATABASE_HOST = '127.0.0.1';
$DATABASE_USER = 'root';
$DATABASE_PASS = '123';
$DATABASE_NAME = 'phplogin';
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if ( !isset($_POST['username'], $_POST['password'], $_POST['password_r']) ) {
	// Could not get the data that should have been sent.
	exit('Please fill all the fields!');
}

if($_POST['password'] != $_POST['password_r']){
    $message = "The passwords are not same";
    echo "<script type='text/javascript'>alert('$message'); location.href = 'index.html';</script>";
    exit;
}
else{
    $sql="INSERT INTO accounts (username, password) VALUES (\"$_POST[username]\",\"$_POST[password]\")";
    if ($con->query($sql) === TRUE) {
        $message = "Register Successfully";
        echo "<script type='text/javascript'>alert('$message'); location.href = 'index.html';</script>";
    } else {
        $message = "Register Fail!";
        echo "<script type='text/javascript'>alert('$message'); location.href = 'index.html';</script>";
    }
    $con->close();
    exit;
}


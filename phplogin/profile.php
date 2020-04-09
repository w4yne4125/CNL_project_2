<?php

function flow_computation( $ip, $name){
    $string = ("super iptables -L AUTHORIZED -nvx|grep -E '" .$ip."\\b'");
    exec($string,$flow);
    $d = 0;
	//echo  $string;
	//print_r($flow);
    foreach($flow as $output){
        $output = htmlentities($output);
        $ret = "$output\n";
        if($d==0){
            sscanf($ret,"%d %d",$pkt,$inflow);
            $d=1;
        }
    }	
	return $inflow." ".$outflow;
}


// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
$DATABASE_HOST = '127.0.0.1';
$DATABASE_USER = 'root';
$DATABASE_PASS = '123';
$DATABASE_NAME = 'phplogin';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// We don't have the password or email info stored in sessions so instead we can get the results from the database.
$stmt = $con->prepare('SELECT password FROM accounts WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password);
$stmt->fetch();
$stmt->close();

$page = $_SERVER['PHP_SELF'];
$sec = "3";

$string = ("sudo iptables -L AUTHORIZED -nvx|grep -E '" .$ip."\\b'");
exec($string,$flow);

foreach ($flow as $key) {
    echo "$key\n";  
    // TODO on ubuntu refresh to mysql and do kickoff 
}

$duration = time() - $_SESSION['LoginTime'];

$result = $con->query("UPDATE accounts SET time_used=".$duration." WHERE username='".$_SESSION['name']."'");

// TODO check flow and time , redirect to logout.php

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Profile Page</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Website Title</h1>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<h2>Profile Page</h2>
			<div>
				<p>Your account details are below:</p>
				<table>
					<tr>
						<td>Username:</td>
						<td><?=$_SESSION['name']?></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><?=$password?></td>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>




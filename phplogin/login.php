<?php
session_start();
$DATABASE_HOST = '127.0.0.1';
$DATABASE_USER = 'root';
$DATABASE_PASS = '123';
$DATABASE_NAME = 'phplogin';
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

$ip = $_SERVER['REMOTE_ADDR'];
$_SESSION['LoginTime'] = time();
$_SESSION['ip'] = $ip;

$_SESSION['flow'] = 0 ;


$result = $con->query("UPDATE accounts SET ip='".$ip."', logintime=NOW(), time_used=0, flow=0 WHERE username='".$_SESSION['name']."'");
exec("super iptables -t nat -I PREROUTING -s $ip -j ACCEPT");
exec("super iptables -t nat -I PREROUTING -d $ip -j ACCEPT");
exec("super iptables -I AUTHORIZED -s $ip -j RETURN");
exec("super iptables -I AUTHORIZED -d $ip -j RETURN");

if($_SESSION['name'] == "admin"){
	header('Location: admin.php');
	exit;
} else {
    header('Location: profile.php');
    exit;
}
?>




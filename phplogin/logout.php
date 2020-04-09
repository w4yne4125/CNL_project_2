<?php
session_start();
exec("sudo iptables -t nat -D PREROUTING -s ".$ip." -j ACCEPT");
exec("sudo iptables -t nat -D PREROUTING -d ".$ip." -j ACCEPT");
exec("sudo iptables -D AUTHORIZED -s ".$ip." -j RETURN");
exec("sudo iptables -D AUTHORIZED -d ".$ip." -j RETURN");
session_destroy();
// Redirect to the login page:
header('Location: index.html');
?>

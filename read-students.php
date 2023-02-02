<?php

require "database/config.php";

$conn = mysqli_init();
mysqli_ssl_set($conn,NULL,NULL,$sslcert,NULL,NULL);
if(!mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL))
{
    die('Failed to connect to MySQL: '.mysqli_connect_error());
} 

$sth = $conn->query('SELECT SID,FirstName,LastName FROM Students');
$sth->setFetchMode(PDO::FETCH_ASSOC);

$result = $sth->fetchAll();

if (count($result) > 0)
{
	header('Content-Type: application/json');
	echo json_encode($result);
}

?>


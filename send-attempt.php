<?php

require "database/config.php";

$dbh = mysqli_init();
mysqli_ssl_set($conn,NULL,NULL,$sslcert,NULL,NULL);
if(!mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL))
    die('Failed to connect to MySQL: '.mysqli_connect_error());

$SID = $_POST["SID"];
$FirstName = $_POST["FirstName"];
$ClassSection = $_POST["ClassSection"];

$sql = "INSERT INTO Students (LastName,FirstName,ClassSection) VALUES(?,?,?)";
$sth = $dbh->prepare($sql);
$sth->execute(array($LastName, $FirstName, $ClassSection));
exit();
?>

<?php

require "database/config.php";

try
{
	$dbh = mysqli_init();
    mysqli_ssl_set($conn,NULL,NULL,$sslcert,NULL,NULL);
    if(!mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL)){
        die('Failed to connect to MySQL: '.mysqli_connect_error());
    } 
    SendAttempt($_POST["SID"], $_POST["FirstName"], $_POST["ClassSection"]);
}
catch(Exception $e)
{
	echo '<h1>An error has occurred.</h1><pre>', $e->getMessage()
            ,'</pre>';
}

function SendAttempt($LastName, $FirstName, $ClassSection)
{
	GLOBAL $dbh;
	$sql = "INSERT INTO Students (LastName,FirstName,ClassSection) VALUES(?,?,?)";
	$sth = $dbh->prepare($sql);
	$sth->execute(array($LastName, $FirstName, $ClassSection));
	exit();
}
?>
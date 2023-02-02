<?php

require "database/config.php";

$conn = mysqli_init();
mysqli_ssl_set($conn,NULL,NULL,$sslcert,NULL,NULL);
if(!mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL))
{
    die('Failed to connect to MySQL: '.mysqli_connect_error());
} 

$sth = $conn->prepare('SELECT SID,FirstName,LastName FROM students');
$sth->execute();

$result = $sth->get_result();

if ($result->num_rows > 0)
{
//     header('Content-Type: application/json');
//     $array = array();
//     while ($row = $result->fetch_assoc()) {
//         $array[] = $row;
//     }
// 	echo json_encode($array);
    echo 'killer queen';
}


?>


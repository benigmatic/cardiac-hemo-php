<?php

require "database/config.php";

// Establish the connection
$conn = mysqli_init();
mysqli_ssl_set($conn,NULL,NULL,$sslcert,NULL,NULL);
if(!mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL))
{
    die('Failed to connect to MySQL: '.mysqli_connect_error());
} 

$puzstep = intval($conn->real_escape_string($_POST['PUZSTEPid']));
$hint = intval($conn->real_escape_string($_POST['HintsTaken']));
$time = floatval($conn->real_escape_string($_POST['TimeTaken']));

$stmt = $conn->prepare("UPDATE drhemo_puzzlesteps SET TimeTaken = ?, HintsTaken = ? WHERE PUZSTEPid = ?");
$stmt->bind_param("dii", $time, $hint, $puzstep);

if ($stmt->execute())
{
    echo "Step " . $puzstep . " updated.";
} 
else 
{
    echo "Error: " . $stmt->err . "<br>" . $conn->error;
}




?>

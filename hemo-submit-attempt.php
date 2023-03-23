<?php

require "database/config.php";

// Establish the connection
$conn = mysqli_init();
mysqli_ssl_set($conn,NULL,NULL,$sslcert,NULL,NULL);
if(!mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL))
{
    die('Failed to connect to MySQL: '.mysqli_connect_error());
} 

$gameid = intval($conn->real_escape_string($_POST['GAMEid']));
$completed = (isset($_POST['Completed']) && !empty($_POST['Completed'])) ? $conn->real_escape_string($_POST['Completed']) : 0;
$time = floatval($conn->real_escape_string($_POST['TimeSpent']));

$stmt = $conn->prepare("UPDATE drhemo_attempts SET Completed = ?, TimeSpent = ? WHERE GAMEid = ?");
$completed = "1";
$gameid = "8";
$stmt->bind_param("idi", $completed, $time, $gameid);

if ($stmt->execute())
{
    echo "Run " . $gameid . " submitted.";
} 
else 
{
    echo "Error: " . $stmt->err . "<br>" . $conn->error;
}

?>

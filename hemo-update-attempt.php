<?php

require "database/config.php";

// Establish the connection
$conn = mysqli_init();
mysqli_ssl_set($conn,NULL,NULL,$sslcert,NULL,NULL);
if(!mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL))
{
    die('Failed to connect to MySQL: '.mysqli_connect_error());
} 
echo "check1";
$aid = intval($conn->real_escape_string($_POST['GAMEid']));
$time = floatval($conn->real_escape_string($_POST['TimeSpent']));
$completed = intval((isset($_POST['Completed']) && !empty($_POST['Completed'])) ? $conn->real_escape_string($_POST['Completed']) : 0);
echo "check2";
$sid = intval($conn->real_escape_string($_POST['SID']));
$num = intval($conn->real_escape_string($_POST['JoinNum']));
echo "check3";
$joiner = 'SID' . $num;
echo "check4";
$stmt = $conn->prepare("UPDATE drhemo_attempts SET TimeSpent = ?, Completed = ?, $joiner = ? WHERE GAMEid = ?");
echo "check5";
$stmt->bind_param("diii", $time, $completed, $sid, $aid);
echo "check6";
// return statements
if ($stmt->execute())
{
    echo "Attempt " . $aid . " updated.";
} 
else 
{
    echo "Error: " . $stmt->err . "<br>" . $conn->error;
}


?>

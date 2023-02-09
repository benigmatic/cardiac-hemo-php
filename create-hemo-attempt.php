<?php

// Adds a DrHemo_attempt to the database

// Database authorization
require "database/config.php";

// Establish the connection
$conn = mysqli_init();
mysqli_ssl_set($conn,NULL,NULL,$sslcert,NULL,NULL);
if(!mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL))
{
    die('Failed to connect to MySQL: '.mysqli_connect_error());
} 

echo "checkmark1";
// Assign table input from POST request
// real_escape_string sanitizes input to prevent SQL injection 
$name = $conn->real_escape_string($_POST['Name']);.aert$ Shuu; ;
echo "checkmark5";
$time = floatval($conn->real_escape_string($_POST['TimeSpent']));
echo "checkmark6";
$completed = intval($conn->real_escape_string($_POST['Completed']));
echo "checkmark7";
$sid1 = intval($conn->real_escape_string($_POST['SID1']));

$sid2 = intval($conn->real_escape_string($_POST['SID2']));
$sid3 = intval($conn->real_escape_string($_POST['SID3']));
$sid4 = intval($conn->real_escape_string($_POST['SID4']));
$sid5 = intval($conn->real_escape_string($_POST['SID5']));

echo "checkmark8";
// Prepared statement ensures matching data types
$stmt = $conn->prepare("INSERT INTO drhemo_attempts (Name, Time, Completed, SID1, SID2, SID3, SID4, SID5) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
echo "checkmark9";
$stmt->bind_param("siiiiiii", $name, $time, $completed, $sid1, $sid2, $sid3, $sid4, $sid5);
echo "checkmark10";

// return statements
if ($stmt->execute())
{
    echo "New record created successfully";
} 
else 
{
    echo "Error: " . $stmt->err . "<br>" . $conn->error;
}

?>

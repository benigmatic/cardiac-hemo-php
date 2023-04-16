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

// Assign table input from POST request
// real_escape_string sanitizes input to prevent SQL injection 
$name = $conn->real_escape_string($_POST['TeamName']);
$time = floatval($conn->real_escape_string($_POST['TimeSpent']));
// $completed = intval($conn->real_escape_string($_POST['Completed']));
$completed = (isset($_POST['Completed']) && !empty($_POST['Completed'])) ? $conn->real_escape_string($_POST['Completed']) : 0;
$sid1 = $conn->real_escape_string($_POST['SID1']);
$sid2 = $conn->real_escape_string($_POST['SID2']);
$sid3 = $conn->real_escape_string($_POST['SID3']);
$sid4 = $conn->real_escape_string($_POST['SID4']);
$sid5 = $conn->real_escape_string($_POST['SID5']);

// Prepared statement ensures matching data types
$stmt = $conn->prepare("INSERT INTO drhemo_attempts (TeamName, TimeSpent, Completed, SID1, SID2, SID3, SID4, SID5) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("sdisssss", $name, $time, $completed, $sid1, $sid2, $sid3, $sid4, $sid5);


// return statements
if ($stmt->execute())
{
    $aid = mysqli_insert_id($conn);
    // returning generated code
    echo $aid;
    
} 
else 
{
    echo "Error: " . $stmt->err . "<br>" . $conn->error;
}

?>

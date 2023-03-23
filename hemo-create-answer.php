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

$puzid = intval($conn->real_escape_string($_POST['PUZSTEPid']));
$sid = intval($conn->real_escape_string($_POST['SID']));
$answer = $conn->real_escape_string($_POST['Answer']);

// Prepared statement ensures matching data types
$stmt = $conn->prepare("INSERT INTO drhemo_answers (PUZSTEPid, SID, Answer) VALUES (?, ?, ?)");

$stmt->bind_param("iis", $puzid, $sid, $answer);

// return statements
if ($stmt->execute())
{
    $aid = mysqli_insert_id($conn);
    echo "New record created successfully. The auto-generated ANSID value is: " . $aid;
} 
else 
{
    echo "Error: " . $stmt->err . "<br>" . $conn->error;
}

?>

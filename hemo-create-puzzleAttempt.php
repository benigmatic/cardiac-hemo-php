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

// JSON from Unity
$aid = intval($conn->real_escape_string($_POST['AID']));
$puzzlename = $conn->real_escape_string($_POST['Name']);
$time = intval($conn->real_escape_string($_POST['Time']));
$completed = (isset($_POST['Completed']) && !empty($_POST['Completed'])) ? $conn->real_escape_string($_POST['Completed']) : 0;

$stmt = $conn->prepare("INSERT INTO drhemo_puzzleAttempt (AID, PuzzleName, TimeTakenToFinish, Completed) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isii", $aid, $puzzlename, $time, $completed);

// return statements
if ($stmt->execute())
{
    $aid = mysqli_insert_id($conn);
    echo "New record created successfully. The auto-generated ID value is: " . $aid;
} 
else 
{
    echo "Error: " . $stmt->err . "<br>" . $conn->error;
}

?>

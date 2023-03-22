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

$aid = intval($conn->real_escape_string($_POST['AID']));
$sid = intval($conn->real_escape_string($_POST['SID']));
$puzid = intval($conn->real_escape_string($_POST['PUZID']));
$step = intval($conn->real_escape_string($_POST['StepNo']));
$time = floatval($conn->real_escape_string($_POST['TimeSpent']));
$hint1 = (isset($_POST['Hint1']) && !empty($_POST['Hint1'])) ? $conn->real_escape_string($_POST['Hint1']) : 0;
$hint2 = (isset($_POST['Hint2']) && !empty($_POST['Hint2'])) ? $conn->real_escape_string($_POST['Hint2']) : 0;
$correct = (isset($_POST['correct']) && !empty($_POST['correct'])) ? $conn->real_escape_string($_POST['correct']) : 0;
$answer = $conn->real_escape_string($_POST['Answer']);

// Prepared statement ensures matching data types
$stmt = $conn->prepare("INSERT INTO drhemo_puzzleanswers (AID, SID, PUZID, PuzzleStep, Hint1, Hint2, TimeTaken, Answer, Correct) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("iiiidiisi", $aid, $sid, $puzid, $step, $time, $hint1, $hint2, $answer, $correct);


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

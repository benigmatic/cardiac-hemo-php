<?php

// Adds a Flashcard attempt to the database

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
$sid = $conn->real_escape_string($_POST['SID']);
$cid = intval($conn->real_escape_string($_POST['CID']));
$grade = intval($conn->real_escape_string($_POST['Grade']));
// Would we want to possibly change time tracking to seconds counted instead of using Time type?
// Or use two separate DateTime fields?
$timespent = intval($conn->real_escape_string($_POST['TimeSpent']));
$answer = $conn->real_escape_string($_POST['Answer']);

// Prepared statement ensures matching data types
$stmt = $conn->prepare("INSERT INTO Cardiac_case_attempts (SID, CID, Grade, TimeSpent, Answer) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("siiis", $sid, $cid, $grade, $timespent, $answer);

// return statements
if ($stmt->execute())
{
    echo "New record created successfully";
}
else
{
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
mysqli_close($conn);

?>

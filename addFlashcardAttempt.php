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
$fid = intval($conn->real_escape_string($_POST['FID']));
$sid = $conn->real_escape_string($_POST['SID']);
$grade = intval($conn->real_escape_string($_POST['Grade']));
// Can use string for time object. Need to make sure format is correct
$timespent = $conn->real_escape_string($_POST['TimeSpent']);
$confidence = $conn->real_escape_string($_POST['Confidence']);
$login = intval($conn->real_escape_string($_POST['Login']));
// Prepared statement ensures matching data types
$stmt = $conn->prepare("INSERT INTO Flashcard_attempts (FID, SID, Grade, TimeSpent, Confidence, Login) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isissi", $fid, $sid, $grade, $timespent, $confidence, $login );

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

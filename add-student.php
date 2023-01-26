<?php

// adds a student (name, sid --can be omitted for autogeneration, section, --expandable) to the database

// Sanitizes data received from POST request then inserts it into students table
// Send POST requests with Unity : https://docs.unity3d.com/ScriptReference/Networking.UnityWebRequest.Post.html
// where the WWWForm Fields are the affected columns in the database

// Database authorization
require "database/config.php";

//Establish the connection
$conn = mysqli_init();
mysqli_ssl_set($conn,NULL,NULL,$sslcert,NULL,NULL);
if(!mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL))
{
    die('Failed to connect to MySQL: '.mysqli_connect_error());
} 

// Assign table input from POST request
// real_escape_string sanitizes input to prevent SQL injection 
$name = $conn->real_escape_string($_POST['FirstName']);
$sid = intval($conn->real_escape_string($_POST['SID']));
$section = intval($conn->real_escape_string($_POST['ClassSection']));

// Prepared statement ensures matching data types
$stmt = $conn->prepare("INSERT INTO students (FirstName, SID, ClassSection) VALUES (?, ?, ?)");
$stmt->bind_param("sii", $name, $sid, $section);

// return statements
if ($stmt->execute())
{
    echo "New record created successfully";
} 
else 
{
    echo "Error: " . $sql . "<br>" . $conn->error;
}

?>

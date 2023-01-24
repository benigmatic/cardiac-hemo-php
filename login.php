<?php
/* Receives the login information from Unity,
    runs query to find the user with the same login SID, validates them 
    returns 0 if the user doesn't exist, returns json with Section number (App Settings if needed) 
*/
require "database/config.php";
 //Establish the connection
 $conn = mysqli_init();
 mysqli_ssl_set($conn,NULL,NULL,$sslcert,NULL,NULL);
 if(!mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL)){
     die('Failed to connect to MySQL: '.mysqli_connect_error());
 }

// Get login SID from Unity, 
//$SID = mysql_real_escape_string($_GET['name'], $conn);
$SID = "123@aol.com";
echo $SID;
// Run query to select a student from the database
$query = "SELECT FirstName, ClassSection FROM students WHERE SID='$SID'";
$result = mysql_query($query) or die('Query failed: ' . mysql_error()); 
echo $result;

<?php

require "database/config.php";

// Establish the connection
$conn = mysqli_init();
mysqli_ssl_set($conn,NULL,NULL,$sslcert,NULL,NULL);
if(!mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL))
{
    die('Failed to connect to MySQL: '.mysqli_connect_error());
} 

$aid = intval($conn->real_escape_string($_POST['AID']));
$time = floatval($conn->real_escape_string($_POST['TimeSpent']));
$completed = (isset($_POST['Completed']) && !empty($_POST['Completed'])) ? $conn->real_escape_string($_POST['Completed']) : 0;


$stmt = $conn->prepare("UPDATE drhemo_attempts SET TimeSpent = ?, Completed = ? WHERE AID = ?)");
$stmt->bind_param("dii", $time, $completed, $aid);

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

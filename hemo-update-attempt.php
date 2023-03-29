<?php

require "database/config.php";

// Establish the connection
$conn = mysqli_init();
mysqli_ssl_set($conn,NULL,NULL,$sslcert,NULL,NULL);
if(!mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL))
{
    die('Failed to connect to MySQL: '.mysqli_connect_error());
} 

# typical update stuffs
$aid = intval($conn->real_escape_string($_POST['GAMEid']));
$time = floatval($conn->real_escape_string($_POST['TimeSpent']));
$completed = intval((isset($_POST['Completed']) && !empty($_POST['Completed'])) ? $conn->real_escape_string($_POST['Completed']) : 0);

# new joiner stuff
$sid = intval($conn->real_escape_string($_POST['SID']));
$num = intval($conn->real_escape_string($_POST['JoinNum']));

$joiner = 'SID' . $num;
# prepared statement
$stmt = $conn->prepare("UPDATE drhemo_attempts SET TimeSpent = ?, Completed = ?, $joiner = ? WHERE GAMEid = ?");
# will not go past this line when testing in browser, default value of $joiner goes to SID0 which is not in the table
# assert by setting $num to 2
$stmt->bind_param("diii", $time, $completed, $sid, $aid);
// return statements
if ($stmt->execute())
{
    echo "Attempt " . $aid . " updated.";
} 
else 
{
    echo "Error: " . $stmt->err . "<br>" . $conn->error;
}


?>

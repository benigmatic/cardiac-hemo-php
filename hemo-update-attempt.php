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
echo "updateDebug: 1";
echo "updateDebug: 2";
# new joiner stuff
$sid = intval($conn->real_escape_string($_POST['SID']));
echo "updateDebug: 3";
# find first non duplicate empty space, alternatively remove a number from the attempt if they leave the lobby 
// $stmt = $conn->prepare("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'drhemo_attempts' AND 
// ((SID1 = 0 AND SID1 != ?) OR 
// (SID2 = 0 AND SID2 != ?) OR 
// (SID3 = 0 AND SID3 != ?) OR 
// (SID4 = 0 AND SID4 != ?) OR 
// (SID5 = 0 AND SID5 != ?)) LIMIT 1");
//$stmt->bind_param("sssss", $sid, $sid, $sid, $sid, $sid, $sid);
$stmt = $conn->prepare("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'drhemo_attempts' AND (SID1 = 0 OR SID2 = 0 OR SID3 = 0 OR SID4 = 0 OR SID5 = 0) LIMIT 1");
$stmt->bind_param("sssss", $sid, $sid, $sid, $sid, $sid);

echo "updateDebug: 4";
$stmt->execute();
$stmt->bind_result($column_name);
$stmt->fetch();
echo "updateDebug: 5 - column name:";
echo $column_name;

if ($column_name) {
  $stmt = $conn->prepare("UPDATE dr_hemo_attempts SET $column_name = ? WHERE SID1 = ? AND SID2 = ? AND SID3 = ? AND SID4 = ? AND SID5 = ?");
    echo "updateDebug: 6";
  $stmt->bind_param("iiiiii", $sid, $sid1, $sid2, $sid3, $sid4, $sid5);
  $stmt->execute();
}
echo "updateDebug: 7";
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

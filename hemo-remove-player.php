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
$sid = intval($conn->real_escape_string($_POST['SID']));

echo "updateDebug: 1 ";
echo "updateDebug: 2 ";

$columns = array("SID1", "SID2", "SID3", "SID4", "SID5");
echo "updateDebug: 3 ";
echo "updateDebug: 4 ";

foreach ($columns as $column) {
  // Check if value is 0
  $query = "SELECT $column FROM drhemo_attempts WHERE GAMEid = $aid AND $column = $sid LIMIT 1";
  $result = mysqli_query($conn, $query);

  // If value is 0, update to 1 and break loop
  if (mysqli_num_rows($result) > 0) {
     echo "Found player";
    $update_query = "UPDATE drhemo_attempts SET $column = 0 WHERE $column = $sid AND GAMEid = $aid";
    mysqli_query($conn, $update_query);
    break;
  }
}

$stmt->execute();
$result = $stmt->get_result();

// $stmt->bind_result($column_name);
// $stmt->fetch();

// while ($row = $result->fetch_assoc()) {
//     echo $row['COLUMN_NAME'] . "<br>";
// }
// echo "updateDebug: 4.3 ";

// $results = $column_name->get_result();
    
    
// if ($column_name) {
//   $stmt = $conn->prepare("UPDATE dr_hemo_attempts SET $column_name = ? WHERE SID1 = ? AND SID2 = ? AND SID3 = ? AND SID4 = ? AND SID5 = ?");
//   echo "updateDebug: 6 ";
//   $stmt->bind_param("iiiiii", $sid, $sid1, $sid2, $sid3, $sid4, $sid5);
//   echo "updateDebug: 6.1 ";
//   $stmt->execute();
// }
//$stmt->bind_param("diii", $time, $completed, $sid, $aid);


// return statements
if ($stmt->execute())
{
    echo "Attempt " . $aid . " updated.";
} 
else 
{
    echo "Error: " . $stmt->err . "<br>" . $conn->error;
}

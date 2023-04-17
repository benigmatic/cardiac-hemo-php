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


$stmt = $conn->prepare("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'drhemo_attempts' AND COLUMN_NAME LIKE 'SID%' ");

$stmt->execute();
$result = $stmt->get_result();

// $stmt->bind_result($column_name);
// $stmt->fetch();

echo "updateDebug: 3.9";
$columns = array();
echo "Found rows: ";
while ($row = $result->fetch_assoc()) {
    echo $row['COLUMN_NAME'] . " ";
    $columns[] = $row['COLUMN_NAME'];
}

echo "updateDebug: 4.0 ";
foreach ($columns as $column)
{
    $stmt = $conn->prepare("SELECT VALUE FROM drhemo_attempts WHERE SID = ?");
    $stmt->bind_param("s", $column);
    
echo "updateDebug: 4.1 ";
    $stmt->execute();
    $result = $stmt->get_result();
    
echo "updateDebug: 4.2 ";
    $row = $result->fetch_assoc();
    if ($row['VALUE'] == 0) {
        $new_value = 1; // replace with your desired new value
        $stmt = $conn->prepare("UPDATE drhemo_attempts SET VALUE = ? WHERE SID = ?");
        $stmt->bind_param("ss", $new_value, $column);
        $stmt->execute();

        echo "Updated column " . $column . " with value " . $new_value;
        break;
    }

echo "updateDebug: 4.3 ";

$results = $column_name->get_result();
    
    
if ($column_name) {
  $stmt = $conn->prepare("UPDATE dr_hemo_attempts SET $column_name = ? WHERE SID1 = ? AND SID2 = ? AND SID3 = ? AND SID4 = ? AND SID5 = ?");
  echo "updateDebug: 6 ";
  $stmt->bind_param("iiiiii", $sid, $sid1, $sid2, $sid3, $sid4, $sid5);
  echo "updateDebug: 6.1 ";
  $stmt->execute();
}
echo "updateDebug: 7 ";
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

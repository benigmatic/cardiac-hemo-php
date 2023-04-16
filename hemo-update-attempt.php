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
# $sid = intval($conn->real_escape_string($_POST['SID']));
# $num = intval($conn->real_escape_string($_POST['JoinNum']));
# $joiner = 'SID' . $num;

# prepared statement
# $stmt = $conn->prepare("UPDATE drhemo_attempts SET TimeSpent = ?, Completed = ?, $joiner = ? WHERE GAMEid = ?");

$stmt = $dbh->prepare('SELECT 
        IFNULL(NULLIF(SID1, \'\'), \'SID1\') AS empty_column,
        IFNULL(NULLIF(SID2, \'\'), \'SID2\') AS empty_column,
        IFNULL(NULLIF(SID3, \'\'), \'SID3\') AS empty_column,
        IFNULL(NULLIF(SID4, \'\'), \'SID4\') AS empty_column,
        IFNULL(NULLIF(SID5, \'\'), \'SID5\') AS empty_column
    FROM :table_name
    WHERE \'\' IN (:sid1, :sid2, :sid3, :sid4, :sid5)
    LIMIT 1');

$table_name = 'drhemo_attempts';
$sid1 = 'SID1';
$sid2 = 'SID2';
$sid3 = 'SID3';
$sid4 = 'SID4';
$sid5 = 'SID5';

$stmt->bindParam(':table_name', $table_name);
$stmt->bindParam(':sid1', $sid1);
$stmt->bindParam(':sid2', $sid2);
$stmt->bindParam(':sid3', $sid3);
$stmt->bindParam(':sid4', $sid4);
$stmt->bindParam(':sid5', $sid5);

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

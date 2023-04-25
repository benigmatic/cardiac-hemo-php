<?php

// retrieves top 3 attempts ordered by lowest TimeSpent

// Receives: nothing
// Sends: JSON object

require "database/config.php";

$conn = mysqli_init();
mysqli_ssl_set($conn,NULL,NULL,$sslcert,NULL,NULL);
if(!mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL))
{
    die('Failed to connect to MySQL: '.mysqli_connect_error());
} 

// get info of top 3 fastest completed attempts
$sth = $conn->prepare('SELECT TeamName, TimeSpent, SID1, SID2, SID3, SID4, SID5 FROM drhemo_attempts WHERE Completed = 1 && TimeSpent != 0 ORDER BY TimeSpent ASC LIMIT 3');
$sth->execute();

$result = $sth->get_result();

if ($result->num_rows > 0)
{
    header('Content-Type: application/json');
    $array = array();
    while ($row = $result->fetch_assoc())
    {
        $array[] = $row;
        // I will assume for now that this captures class variables like a Hemo Attempt
    }

    echo json_encode($array);
}

?>

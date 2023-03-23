<?php

// Adds a DrHemo_attempt to the database

// Database authorization
require "database/config.php";

// Establish the connection
$conn = mysqli_init();
mysqli_ssl_set($conn,NULL,NULL,$sslcert,NULL,NULL);
if(!mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL))
{
    die('Failed to connect to MySQL: '.mysqli_connect_error());
} 
echo "check1";
// JSON from Unity
$aid = intval($conn->real_escape_string($_POST['GAMEid']));
$puzzlename = $conn->real_escape_string($_POST['PuzzleName']);
$puzzlestep = intval($conn->real_escape_string($_POST['PuzzleStep']));
$hintstaken = intval($conn->real_escape_string($_POST['HintsTaken']));
$time = floatval($conn->real_escape_string($_POST['TimeTaken']));

// check if these already have an entry in the table
echo "check2";
// Prepare the statement
$stmt = $conn->prepare("SELECT PUZSTEPid FROM drhemo_puzzlesteps WHERE GAMEid = ? AND PuzzleName = ? AND PuzzleStep = ?");
// $puzzlename = 'Library';
$stmt->bind_param("isi", $aid, $puzzlename, $puzzlestep);
echo "check3";
// Execute the statement
$stmt->execute();
$result = $stmt->get_result();
echo "check4";
// Check if the PuzzleStep already exists
if ($result->num_rows == 0)
{
  // If not, create a new PuzzleStep
    echo "check5";
  $stmt = $conn->prepare("INSERT INTO drhemo_puzzlesteps (GAMEid, PuzzleName, PuzzleStep, HintsTaken, TimeTaken) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("isiid", $aid, $puzzlename, $puzzlestep, $hintstaken, $time);
  // $stmt->bind_param("isiid", 1, 'Cafeteria', 1, $hintstaken, $time);
    echo "check6";
  if($stmt->execute())
  {
      // returning PUZid
      echo "check7";
      $ret = mysqli_insert_id($conn);
      echo $ret;
  }
  else
  {
      echo "check8";
      echo "Error: " . $stmt->err . "<br>" . $conn->error;
  }

}
else 
{
    // return the PUZid
    echo "check9";
    echo $result;
}
?>

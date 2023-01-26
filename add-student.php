<?php
/* What it does:
    Receives the login information from Unity,
    runs query to find the user with the same login SID, validates them 
    returns 0 if the user doesn't exist, returns json with Section number (App Settings if needed) 
    URL: https://hemo-cardiac.azurewebsites.net//login.php?var1=SID_value 
        where SID_value is the SID sent from Unity
    Source for PHP for variable parsing: https://stackoverflow.com/questions/44759249/unity-c-sharp-send-variable-to-php-server
*/

require "database/config.php";
//Establish the connection
$conn = mysqli_init();
mysqli_ssl_set($conn,NULL,NULL,$sslcert,NULL,NULL);
if(!mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL)){
    die('Failed to connect to MySQL: '.mysqli_connect_error());
} 


$name = $_POST['FirstName'];
$sid = $_POST['SID'];
$section = $POST['ClassSection'];

$sql = "INSERT INTO students (name, sid, section)";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Check that a new user has been sent
// if (isset($_REQUEST["SID"])) {
//     // $SID = &$_REQUEST["var1"];
//     // Run query to select a student from the database
//     $query = "SELECT FirstName, ClassSection FROM students WHERE SID='$SID'";
//     $res = mysqli_query($conn, $query); 
//     if (mysqli_num_rows($res) <= 0) {
//         echo "No Students found in the table";
//     }
//     else {
//         $row = mysqli_fetch_assoc($res);
//         $Name = &$row["FirstName"];
//         $Section = &$row["ClassSection"];
//         //Creates a json file to return
//         $Login_res = new stdClass();
//         $Login_res->objects = [$SID, $Name,$Section ];
//         echo json_encode($Login_res);
//     }
// } else {
//     http_status_code(400);
// }
echo "I am in a spongebob worrrld";
echo "This, is, Sponge, Bob";
echo $name;

?>

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
 } else{
    echo "Connection secured /n";
 }

// Get login SID from Unity, if there is no SID in the URL, the sript shows 400 error
if (isset($_REQUEST["var1"])) {
    echo "Received ". $_REQUEST["var1"]. " success!";
    
} else {
    http_status_code(400);
    echo "Request Failed";
}
//TODO: Test this: Prevents Injection
/*
$SID = mysql_real_escape_string($_REQUEST["var1"], $conn);
*/
$SID = &$_REQUEST["var1"];
echo ($SID . "/n");

// Run query to select a student from the database
$query = "SELECT FirstName, ClassSection FROM students WHERE SID='$SID'";
$res = mysqli_query($conn, $query); 
if (mysqli_num_rows($res) <= 0) {
    echo "No Students found in the table";
}
else {
    while ($row = mysqli_fetch_assoc($res)) {
        echo $row["FirstName"] . "," . $row["ClassSection"] ."*";
        $Name = &$row["FirstName"];
        echo "   " . $Name;
    }
    
}
//Creates a json file to send to Unity apps
/*
$Name= &$row["FirstName"];
    $Section= &$row("ClassSection");
    echo $Name;
    echo "   Here3   ";
    $Login_res = new stdClass();
    $Login_res->objects = [$SID, $Name,$Section ];
    echo ("Here4");
    echo json_encode($Login_res);
    */
?>
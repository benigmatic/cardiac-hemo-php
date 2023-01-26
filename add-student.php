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
if(!mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL))
{
    die('Failed to connect to MySQL: '.mysqli_connect_error());
} 


$name = $_POST['FirstName'];
$sid = $_POST['SID'];
$section = $POST['ClassSection'];

$sql = "INSERT INTO students (FirstName, SID, ClassSection) VALUES ('$name', '$sid', '$section')";

if(isset($_POST['submit']))
{
    if ($conn->query($sql) === TRUE)
    {
        echo "New record created successfully";
    } 
    else 
    {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>

<?php
/* What it does:
    Receives the login information from Unity,
    runs query to find the user with the same login SID, validates them 
    returns 0 if the user doesn't exist, returns json with Section number (App Settings if needed) 
    URL: https://hemo-cardiac.azurewebsites.net//login.php?var1=SID_value&var2=Password 
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

// Get login SID from Unity, if there is no SID in the URL, the sript shows 400 error
//if (isset($_REQUEST["var1"]) && isset($_REQUEST["var2"])) {
    $SID = &$_REQUEST["var1"];
    $usersPassword = &$_REQUEST["var2"];
    $stmt = $conn->prepare('SELECT Password FROM students WHERE SID = ?');
    $stmt->bind_param('i', $SID);
    $stmt->execute();
    $res = $stmt->get_result();
    if (mysqli_num_rows($res) <= 0) {
        die("No Students found in the table");
    } else {
        $row = $res->fetch_assoc();
        $DBPass = &$row["Password"];
        //Compares the user Password with the DB
    echo $usersPassword . "<br> ";
    echo $DBPass . "<br> ";
        if ($usersPassword == $DBPass) {
            //Log the user in and return the object with values
            $query = "SELECT ClassSection, LoggedIn FROM students WHERE SID='$SID' AND Password='$usersPassword'";
            $res = mysqli_query($conn, $query);
            if (mysqli_num_rows($res) <= 0) {
                die("No Students found in the table");
            } else {
                $row = mysqli_fetch_assoc($res);
            
                $Section = & $row["ClassSection"];
                $LoggedIn = & $row["LoggedIn"]+1;
                echo "Test3 <br>";
                //Updates the LoggedIn value in the database
                $stmt = $conn->prepare("UPDATE students SET LoggedIn = LoggedIn+ 1 WHERE SID= ? AND Password= ? ");
                $stmt->bind_param("is", $sid, $usersPassword);
                if ($stmt->execute())
                {
                    echo "New record created successfully";
                }
                //Creates a json file to return to Unity apps
                $res_array = array(
                    "SID" => $SID,
                    "Section" => $Section,
                    "LoggedIn" => $LoggedIn
                );
                echo json_encode($res_array);
            }
        } else {
            echo("Invalid password");
        }
    }

?>

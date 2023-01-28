<?php
/* What it does:
    Receives the Section Number from Unity,
    Returns a flashcards list for this section
    URL: https://hemo-cardiac.azurewebsites.net//Flashcards.php?var1=Section_number        
*/

require "database/config.php";
//Establish the connection
$conn = mysqli_init();
mysqli_ssl_set($conn,NULL,NULL,$sslcert,NULL,NULL);
if(!mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL)){
    die('Failed to connect to MySQL: '.mysqli_connect_error());
} 

// Get login SID from Unity, if there is no SID in the URL, the sript shows 400 error
if (isset($_REQUEST["var1"])) {

    $Section =(int)$conn->real_escape_string($_REQUEST["var1"]);
    echo "Section: " . $Section . "  \n";
    //$stmt = $conn->prepare("SELECT * from students WHERE Section=?");
    //$stmt->bind_param("i", $Section);
    $query = "SELECT * from students WHERE Section=$Section";
    $res = mysqli_query($conn, $query); 

// return statements
    //$res = $stmt->execute();
    echo $res;

// Close connection
mysqli_close($conn);

    
}
?>
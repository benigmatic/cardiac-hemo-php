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

// Get login Section number from Unity
$Section = &$_REQUEST["var1"];
echo $Section . "<BR>";
$query = "SELECT * FROM students WHERE Section LIKE '$Section'";
echo $query;
$result = mysqli_query($conn, $query);
echo $result;
if ($result = mysqli_query($conn, $query)) {

    $newArr = array();
    /* fetch associative array */
    while ($db_field = mysqli_fetch_assoc($result)) {
        $newArr[] = $db_field;
    }
    echo json_encode($newArr); // get all products in json format.    
} else {
    echo "Error";
}
?>
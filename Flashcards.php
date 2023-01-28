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
if (isset($_REQUEST["var1"])) {

    $Section = &$_REQUEST["var1"];
    $query = "SELECT Prompt, Answer FROM flashcards WHERE Section='$Section'";
    $res = mysqli_query($conn, $query); 
    if (mysqli_num_rows($res) <= 0) {
        echo "No Flashcards found";
    }
    else {
        $res_array = array();
        while ($row = mysqli_fetch_assoc($res)) {
        $Prompt = &$row["Prompt"];
        $Answer = &$row["Answer"];
        //Creates a json file to return
        $object_array = array(
            "Prompt" => $Prompt,
            "Answer" => $Answer
        );
        echo json_encode($object_array);
            $res_array[] = $object_array;
        }
        echo "<BR>";
        echo $res_array;
    }
} else {
    http_status_code(400);
}

?>
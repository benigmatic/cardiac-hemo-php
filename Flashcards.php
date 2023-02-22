<?php
/* What it does:
    Receives the Section Number from Unity,
    Returns a flashcards list for this section
    URL: https://hemo-cardiac.azurewebsites.net/flashcards.php?var1=Section_number
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
    $stmt = $conn->prepare('SELECT FID, Prompt, Answer FROM flashcards WHERE Section = ?');
    $stmt->bind_param('s', $Section);
    $stmt->execute();
    $res = $stmt->get_result();
    if (mysqli_num_rows($res) <= 0) {
        die("No Flashcards found");
    }
    else {
        $res_array = array();
        while ($row = $res->fetch_assoc()) {
        //Creates a json file to return
        $object_array = array(
            "FID" => &$row["FID"],
            "Prompt" =>&$row["Prompt"],
            "Answer" =>&$row["Answer"]
        );
            $res_array[] = $object_array;
        }
        $flashcard_array = array("Flashcards" => $res_array);
        //returns an Array of JSONs
        echo json_encode($flashcard_array);
    }
} else {
    http_status_code(400);
}

?>

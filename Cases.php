<?php
/* What it does:
    Receives the Section Number from Unity app,
    Returns a cases list for this section
    URL: https://hemo-cardiac.azurewebsites.net//cases.php?var1=Section_number
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
    $stmt = $conn->prepare('SELECT Description, Rhythm, AnswerDescription, A,B,C FROM cases WHERE Section = ?');
    $stmt->bind_param('s', $Section);
    $stmt->execute();
    $res = $stmt->get_result();
    if (mysqli_num_rows($res) <= 0) {
        die("No Cases found");
    }
    else {
        $res_array = array();
        while ($row = $res->fetch_assoc()) {
        //Creates a json file to return
        $object_array = array(
            "Description" => &$row["Description"],
            "Rhythm" => &$row["Rhythm"],
            "AnswerDescription" => &$row["AnswerDescription"],
            "A" => &$row["A"],
            "B" => &$row["B"],
            "C" => &$row["C"],
        );
            $res_array[] = $object_array;
        }
        $case_array = array("Cases" => $res_array);
        //returns an Array of JSONs
        echo json_encode($case_array);
    }
} else {
    http_status_code(400);
}

?>

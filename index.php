<?php
require "database/config.php";
 //Establish the connection
 $conn = mysqli_init();
 mysqli_ssl_set($conn,NULL,NULL,$sslcert,NULL,NULL);
 if(!mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL)){
     die('Failed to connect to MySQL: '.mysqli_connect_error());
 }
 //Test if table exists
 $res = mysqli_query($conn, "SHOW TABLES LIKE 'students'");

 if (mysqli_num_rows($res) <= 0) {
     echo "No students in the table";
 } else {
     //Query and print data
     // TODO:Change the echo of values into a json instead
     $res = mysqli_query($conn, 'SELECT * FROM students');

     if (mysqli_num_rows($res) <= 0) {
         echo "No Students found in the table";
     }
     else {
         while ($row = mysqli_fetch_assoc($res)) {
             echo $row["SID"] . "," . $row["Password"] . "," . $row["FirstName"]."*";
         }
         
     }
 }

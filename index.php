<?php
require "database/config.php";
echo "testing login info";
 //Establish the connection
 $conn = mysqli_init();
 mysqli_ssl_set($conn,NULL,NULL,$sslcert,NULL,NULL);
 if(!mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL)){
     die('Failed to connect to MySQL: '.mysqli_connect_error());
 }
 echo "connection established";
 //Test if table exists
 $res = mysqli_query($conn, "SHOW TABLES LIKE 'students'");

 if (mysqli_num_rows($res) <= 0) {
     echo "/n No students";
 } else {
     //Query and print data
     $res = mysqli_query($conn, 'SELECT * FROM Products');

     if (mysqli_num_rows($res) <= 0) {
         echo "No Students found in the table";
     }
     else {
         echo "Data shhown";
         while ($row = mysqli_fetch_assoc($res)) {
             echo "1. ".$row["SID"]." </td>";
             echo "2. ".$row["Lastname"]." </td> </tr>";
             echo "3. ".$row["FirstName"]." </td> </tr>";
         }
         echo "</table>";
     }
 }

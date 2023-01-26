<?php

// adds a student (name, sid --can be omitted for autogeneration, section, --expandable) to the database

// Sanitizes data received from POST request then inserts it into students table
// Send POST requests with Unity : https://docs.unity3d.com/ScriptReference/Networking.UnityWebRequest.Post.html
// where the WWWForm Fields are the affected columns in the database

// Database authorization
require "database/config.php";

//Establish the connection
$conn = mysqli_init();
mysqli_ssl_set($conn,NULL,NULL,$sslcert,NULL,NULL);
if(!mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL))
{
    die('Failed to connect to MySQL: '.mysqli_connect_error());
} 

// Assign table input from POST request
// real_escape_string sanitizes input to prevent SQL injection 
$name = $conn->real_escape_string($_POST['FirstName']);
$sid = intval($conn->real_escape_string($_POST['SID']));
$section = intval($conn->real_escape_string($_POST['ClassSection']));

// Prepared statement ensures matching data types
$stmt = $conn->prepare("INSERT INTO students (FirstName, SID, ClassSection) VALUES (?, ?, ?)");
$stmt->bind_param("sii", $name, $sid, $section);

// return statements
if ($stmt->execute())
{
    echo "New record created successfully";
} 
else 
{
    echo "Error: " . $sql . "<br>" . $conn->error;
}

/////////////////////////////////////////////////////////////////////// Unity Code ////////////////////////////////////////////////////////////////////////////////////
/*
using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.Networking;
using TMPro;

public class AddStudent : MonoBehaviour
{
    public TMP_InputField firstName;
    public TMP_InputField sid;
    public TMP_InputField classSection;
    string url = "https://hemo-cardiac.azurewebsites.net/add-student.php"; // can be public but has to be changed in Unity editor as well as in the code


    public void OnSubmit()
    {
        Debug.Log("Sending data");
        StartCoroutine(SendStudentData());
    }

    IEnumerator SendStudentData()
    {
        WWWForm form = new WWWForm();
        
        form.AddField("FirstName", firstName.text);
        form.AddField("SID", int.Parse(sid.text));
        form.AddField("ClassSection", int.Parse(classSection.text));

        Debug.Log(firstName.text);
        Debug.Log(sid.text);
        Debug.Log(classSection.text);
        using (var send = UnityWebRequest.Post(url, form))
        {
            yield return send.SendWebRequest();

            if(send.result != UnityWebRequest.Result.Success)
            {
                print(send.error);
                Debug.Log("Uh oh, error");
            }
            else
            {
                Debug.Log("Sent request successfully");
                Debug.Log(send.downloadHandler.text);
            }
        }
    }
}
*/

?>

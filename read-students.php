<?php

// alternative retrieval script

// Receives: nothing
// Sends: JSON object with single parameter

require "database/config.php";

$conn = mysqli_init();
mysqli_ssl_set($conn,NULL,NULL,$sslcert,NULL,NULL);
if(!mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL))
{
    die('Failed to connect to MySQL: '.mysqli_connect_error());
} 

$sth = $conn->prepare('SELECT SID,FirstName,LastName FROM students');
$sth->execute();

$result = $sth->get_result();

if ($result->num_rows > 0)
{
    header('Content-Type: application/json');
    $array = array();
    while ($row = $result->fetch_assoc())
    {
        $array[] = $row;
        // I will assume for now that this captures class variables like a Hemo Attempt
    }
    // Wraps the array of objects as a JSON property with name 'items'
    $data = (object) ['items' => $array];
    echo json_encode($array);
}

/////////////////////////////////////////////////////////////////////// Unity Code ////////////////////////////////////////////////////////////////////////////////////
/*
using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.Networking;

public class ReadStudents : MonoBehaviour
{
    public void OnGet()
    {
        StartCoroutine(GetStudents());
    }

    private IEnumerator GetStudents()
    {
        using (UnityWebRequest www = UnityWebRequest.Get("https://hemo-cardiac.azurewebsites.net/read-students.php"))
        {
            yield return www.SendWebRequest();

            if (www.result == UnityWebRequest.Result.ConnectionError || www.result == UnityWebRequest.Result.ProtocolError)
            {
                Debug.LogError(www.error);
            }
            else
            {
                // 'items' must match the property name of the JSON object sent by server
                DataContainer array = JsonUtility.FromJson<DataContainer>("{\"items\":" + www.downloadHandler.text + "}");

                foreach (StudentData entry in array.items)
                {
                    Debug.Log("Name:" + entry.FirstName + " " + entry.LastName + "\nSID:" + entry.SID);
                    
                }
            }
        }
    }
}

[System.Serializable]
public class StudentData
{
    public string SID;
    public string FirstName;
    public string LastName;
    // public Attempt DrHemo_attemptAID; // find way to retrieve nested JSON
}

[System.Serializable]
public class DataContainer
{
    public StudentData[] items;
}
*/

?>


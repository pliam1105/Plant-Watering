<?php 
//Program to write moisture sensor measurements with esp32 via php

$servername = "localhost";

// REPLACE with your Database name
$dbname = "id19492879_pliamdb";
// REPLACE with Database user
$username = "id19492879_pliam";
// REPLACE with Database user password
$password = "Pli@m12112005";

// Keep this API Key value to be compatible with the ESP32 code 
// If you change this value, the ESP32 sketch needs to match
$api_key_value = "tk647vDfs2Kes";

$api_key= $sensor1 = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $api_key = test_input($_GET["api_key"]);
    if($api_key == $api_key_value) {
        $sensor1 = test_input($_GET["sensor1"]);
        $sensor2 = test_input($_GET["sensor2"]);
        $sensor3 = test_input($_GET["sensor3"]);
        $sensor4 = test_input($_GET["sensor4"]);
        $sensor5 = test_input($_GET["sensor5"]);
        $sensor6 = test_input($_GET["sensor6"]);
        $sensor7 = test_input($_GET["sensor7"]);
        $sensor8 = test_input($_GET["sensor8"]);
        $sensor9 = test_input($_GET["sensor9"]);
        $sensor10 = test_input($_GET["sensor10"]);
        $sensor11 = test_input($_GET["sensor11"]);
        $sensor12 = test_input($_GET["sensor12"]);
        $sensor13 = test_input($_GET["sensor13"]);
        $sensor14 = test_input($_GET["sensor14"]);
        $sensor15 = test_input($_GET["sensor15"]);
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        $sql = "INSERT INTO pl_moisture (Sensor1
        ,Sensor2
        ,Sensor3
        ,Sensor4
        ,Sensor5
        ,Sensor6
        ,Sensor7
        ,Sensor8
        ,Sensor9
        ,Sensor10
        ,Sensor11
        ,Sensor12
        ,Sensor13
        ,Sensor14
        ,Sensor15)
        VALUES ('" . $sensor1 . "'
        ,'" . $sensor2 . "'
        ,'" . $sensor3 . "'
        ,'" . $sensor4 . "'
        ,'" . $sensor5 . "'
        ,'" . $sensor6 . "'
        ,'" . $sensor7 . "'
        ,'" . $sensor8 . "'
        ,'" . $sensor9 . "'
        ,'" . $sensor10 . "'
        ,'" . $sensor11 . "'
        ,'" . $sensor12 . "'
        ,'" . $sensor13 . "'
        ,'" . $sensor14 . "'
        ,'" . $sensor15 . "')";
        
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } 
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    
        $conn->close();
    }
    else {
        echo "Wrong API Key provided.";
    }

}
else {
    echo "No data posted with HTTP GET.";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
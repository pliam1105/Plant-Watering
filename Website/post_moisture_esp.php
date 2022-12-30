<?php 
//Program to write moisture sensor measurements with esp32 via php

$servername = "localhost";

$dbname = "id19492879_pliamdb";
$username = "id19492879_pliam";
$password = "Pli@m12112005";;

// Keep this API Key value to be compatible with the ESP32 code 
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

}else if($_SERVER["REQUEST_METHOD"] == "POST"){
    $api_key = test_input($_POST["api_key"]);
    if($api_key == $api_key_value) {
        $sensor1 = test_input($_POST["sensor1"]);
        $sensor2 = test_input($_POST["sensor2"]);
        $sensor3 = test_input($_POST["sensor3"]);
        $sensor4 = test_input($_POST["sensor4"]);
        $sensor5 = test_input($_POST["sensor5"]);
        $sensor6 = test_input($_POST["sensor6"]);
        $sensor7 = test_input($_POST["sensor7"]);
        $sensor8 = test_input($_POST["sensor8"]);
        $sensor9 = test_input($_POST["sensor9"]);
        $sensor10 = test_input($_POST["sensor10"]);
        $sensor11 = test_input($_POST["sensor11"]);
        $sensor12 = test_input($_POST["sensor12"]);
        $sensor13 = test_input($_POST["sensor13"]);
        $sensor14 = test_input($_POST["sensor14"]);
        $sensor15 = test_input($_POST["sensor15"]);
        
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
    echo "No data posted";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
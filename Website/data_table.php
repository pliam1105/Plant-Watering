<!DOCTYPE html>
<html><body>
<?php
//Program to read the moisture sensor data written by esp32 to database 

$servername = "localhost";

// REPLACE with your Database name
$dbname = "id19492879_pliamdb";
// REPLACE with Database user
$username = "id19492879_pliam";
// REPLACE with Database user password
$password = "Pli@m12112005";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT ID, Sensor1,
Sensor1,
Sensor2,
Sensor3,
Sensor4,
Sensor5,
Sensor6,
Sensor7,
Sensor8,
Sensor9,
Sensor10,
Sensor11,
Sensor12,
Sensor13,
Sensor14,
Sensor15,
date_time FROM pl_moisture";

echo '<table cellspacing="5" cellpadding="5">
      <tr> 
        <td>ID</td> 
        <td>Sensor 1</td> 
        <td>Sensor 2</td> 
        <td>Sensor 3</td> 
        <td>Sensor 4</td> 
        <td>Sensor 5</td> 
        <td>Sensor 6</td> 
        <td>Sensor 7</td> 
        <td>Sensor 8</td> 
        <td>Sensor 9</td> 
        <td>Sensor 10</td> 
        <td>Sensor 11</td> 
        <td>Sensor 12</td> 
        <td>Sensor 13</td> 
        <td>Sensor 14</td> 
        <td>Sensor 15</td> 
        <td>Timestamp</td> 
      </tr>';
 
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $row_id = $row["ID"];
        $row_sensor1 = $row["Sensor1"];
        $row_sensor2 = $row["Sensor2"];
        $row_sensor3 = $row["Sensor3"];
        $row_sensor4 = $row["Sensor4"];
        $row_sensor5 = $row["Sensor5"];
        $row_sensor6 = $row["Sensor6"];
        $row_sensor7 = $row["Sensor7"];
        $row_sensor8 = $row["Sensor8"];
        $row_sensor9 = $row["Sensor9"];
        $row_sensor10 = $row["Sensor10"];
        $row_sensor11 = $row["Sensor11"];
        $row_sensor12 = $row["Sensor12"];
        $row_sensor13 = $row["Sensor13"];
        $row_sensor14 = $row["Sensor14"];
        $row_sensor15 = $row["Sensor15"];
        $row_reading_time = $row["date_time"];
      
        // Set timezone to + 3 hours
        $row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time + 3 hours"));
      
        echo '<tr> 
                <td>' . $row_id . '</td> 
                <td>' . $row_sensor1 . '</td> 
                <td>' . $row_sensor2 . '</td> 
                <td>' . $row_sensor3 . '</td> 
                <td>' . $row_sensor4 . '</td> 
                <td>' . $row_sensor5 . '</td> 
                <td>' . $row_sensor6 . '</td> 
                <td>' . $row_sensor7 . '</td> 
                <td>' . $row_sensor8 . '</td> 
                <td>' . $row_sensor9 . '</td> 
                <td>' . $row_sensor10 . '</td> 
                <td>' . $row_sensor11 . '</td> 
                <td>' . $row_sensor12 . '</td> 
                <td>' . $row_sensor13 . '</td> 
                <td>' . $row_sensor14 . '</td> 
                <td>' . $row_sensor15 . '</td> 
                <td>' . $row_reading_time . '</td> 
              </tr>';
    }
    $result->free();
}

$conn->close();
?> 
</table>
</body>
</html>
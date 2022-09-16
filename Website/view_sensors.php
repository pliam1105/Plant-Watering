<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>

/* If the screen size is 601px wide or more */
@media screen and (min-width: 601px) {
  h1 {
    font-size: 32px;
  }
}

/* If the screen size is 600px wide or less */
@media screen and (max-width: 600px) {
  h1 {
    font-size: 25px;
  }
}

.red_dot {
  height: 25px;
  width: 25px;
  background-color: red;
  border-radius: 50%;
  display: inline-block;
}

.orange_dot {
  height: 25px;
  width: 25px;
  background-color: orange;
  border-radius: 50%;
  display: inline-block;
}

.yellow_dot {
  height: 25px;
  width: 25px;
  background-color: yellow;
  border-radius: 50%;
  display: inline-block;
}

.green_dot {
  height: 25px;
  width: 25px;
  background-color: green;
  border-radius: 50%;
  display: inline-block;
}

</style>
</head>
<body><h1 style="font-family: 'Manjari', sans-serif;">
<?php 
$servername = "localhost";

// REPLACE with your Database name
$dbname = "id19492879_pliamdb";
// REPLACE with Database user
$username = "id19492879_pliam";
// REPLACE with Database user password
$password = "Pli@m12112005";;

//connection variable
global $conn;
global $num;

//sensor variables
global $sensor_last;
global $sensor_max;
global $status_water;
global $status_color;


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
    
function sensor ($num, $con){
    global $sql, $result, $row, $sql2, $result2, $row2;
    
    $sql = "SELECT Sensor$num FROM pl_moisture ORDER BY date_time DESC LIMIT 1";
    if ($result = $con->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $sensor_last = $row["Sensor$num"];
    }
    $result->free();
    }
    
    $sql2 = "SELECT MAX(Sensor$num) as sensor FROM pl_moisture WHERE date_time > UNIX_TIMESTAMP(NOW() - INTERVAL 72 HOUR)";
    if ($result2 = $con->query($sql2)) {
    while ($row2 = $result2->fetch_assoc()) {
        $sensor_max = $row2["sensor"];
    }
    $result2->free();
    }
    
    if($sensor_max > 25){
        //watered
        $status_water = "Watered";
    }else{
        //dry
        $status_water = "Dry";
    }
    
    if($sensor_max <= 27){
        //red
        $status_color = 'red';
    }else if($sensor_max > 27 && $sensor_max <= 30){
        //orange
        $status_color = 'orange';
    }else if($sensor_max > 30 && $sensor_max <= 40){
        //yellow
        $status_color = 'yellow';
    }else if($sensor_max > 40){
        //green
        $status_color = 'green';
    }
    
    echo "Sensor $num : $status_water <span class='".$status_color."_dot'></span> $sensor_last%";
    echo "</br>";
}

sensor(1,$conn);
sensor(2,$conn);
sensor(3,$conn);
sensor(4,$conn);
sensor(5,$conn);
sensor(6,$conn);
sensor(7,$conn);
sensor(8,$conn);
sensor(9,$conn);
sensor(10,$conn);
sensor(11,$conn);
sensor(12,$conn);
sensor(13,$conn);
sensor(14,$conn);
sensor(15,$conn);

$conn->close();

?>
</h1>
</body>
</html>
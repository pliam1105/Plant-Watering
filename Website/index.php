<!DOCTYPE html>
<?php 
$servername = "localhost";

// REPLACE with your Database name
$dbname = "id19492879_pliamdb";
// REPLACE with Database user
$username = "id19492879_pliam";
// REPLACE with Database user password
$password = "Pli@m12112005";

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
    
    echo "<h1 style='font-family: 'Manjari', sans-serif;'>Sensor $num : $status_water <span class='".$status_color."_dot'></span> $sensor_last%</h1>";
    echo "</br>";
}

?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.overlay{
    opacity:1;
    background-color:#ffffff;
    position:fixed;
    width:100%;
    height:100%;
    top:0px;
    left:0px;
    z-index:1000;
}

.mapboxgl-popup-content {
  text-align: center;
  font-family: 'Open Sans', sans-serif;
}

.marker {
  background-image: url('leaf.png');
  background-size: cover;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  cursor: pointer;
}

/* If the screen size is 601px wide or more */
@media screen and (min-width: 601px) {
  h1 {
    font-size: 25px;
  }
  .marker {
      width: 50px;
      height: 50px;
  }
}

/* If the screen size is 600px wide or less */
@media screen and (max-width: 600px) {
  h1 {
    font-size: 20px;
  }
  .marker {
      width: 30px;
      height: 30px;
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
<meta charset="UTF-8">
<title>Moisture Control</title>
<script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.3.0/mapbox-gl.js'></script>
<link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.3.0/mapbox-gl.css' rel='stylesheet' />
<style>
body { margin:0; padding:0; }
#map { position:absolute; top:0; bottom:0; width:100%; }
</style>
</head>
<body>

<div id='map'></div>
<script>
mapboxgl.accessToken = 'pk.eyJ1IjoicGxpYW1wYXMiLCJhIjoiY2psbWRiczM5MTNneTNwbmprN2FoaG5jNSJ9.wNg62r6BQDH0TCEGwdPJJw';


if(window.innerHeight > window.innerWidth){
    //rotate
    console.log("Rotate map!");
    var map = new mapboxgl.Map({
container: 'map',
style: 'mapbox://styles/mapbox/satellite-v9',
center: [23.227639, 40.871611],
bearing: -90, // rotation in degrees
zoom: 18
});
}else{
    //ok
    var map = new mapboxgl.Map({
container: 'map',
style: 'mapbox://styles/mapbox/satellite-v9',
center: [23.227639, 40.871611],
zoom: 18
});
}

var geojson = {
  type: 'FeatureCollection',
  features: [{
    type: 'Feature',
    geometry: {
      type: 'Point',
      coordinates: [40.871558207665515,23.22733782983522]
    },
    properties: {
      description: "<?php sensor(1,$conn); ?>"
    }
  },
  {
    type: 'Feature',
    geometry: {
      type: 'Point',
      coordinates: [40.871580568435604,23.227362557866684]
    },
    properties: {
      description: "<?php sensor(2,$conn); ?>"
    }},
  {
    type: 'Feature',
    geometry: {
      type: 'Point',
      coordinates: [40.87157252208837,23.227443349190935]
    },
    properties: {
      description: "<?php sensor(3,$conn); ?>"
    }},
  {
    type: 'Feature',
    geometry: {
      type: 'Point',
      coordinates: [40.87157013798546,23.227541481089133]
    },
    properties: {
      description: "<?php sensor(4,$conn); ?>"
    }},
  {
    type: 'Feature',
    geometry: {
      type: 'Point',
      coordinates: [40.87156954195973,23.227602961316336]
    },
    properties: {
      description: "<?php sensor(5,$conn); ?>"
    }},
  {
    type: 'Feature',
    geometry: {
      type: 'Point',
      coordinates: [40.87156715785673,23.22769596986268]
    },
    properties: {
      description: "<?php sensor(6,$conn); ?>"
    }},
  {
    type: 'Feature',
    geometry: {
      type: 'Point',
      coordinates: [40.871571084355224,23.227777281368674]
    },
    properties: {
      description: "<?php sensor(7,$conn); ?>"
    }},
  {
    type: 'Feature',
    geometry: {
      type: 'Point',
      coordinates: [40.87157337128133,23.227841602398087]
    },
    properties: {
      description: "<?php sensor(8,$conn); ?>"
    }},
  {
    type: 'Feature',
    geometry: {
      type: 'Point',
      coordinates: [40.871604639907105,23.22784955448952]
    },
    properties: {
      description: "<?php sensor(9,$conn); ?>"
    }},
  {
    type: 'Feature',
    geometry: {
      type: 'Point',
      coordinates: [40.87162328081169,23.227863073046564]
    },
    properties: {
      description: "<?php sensor(10,$conn); ?>"
    }},
  {
    type: 'Feature',
    geometry: {
      type: 'Point',
      coordinates: [40.87166116392419,23.227850349698713]
    },
    properties: {
      description: "<?php sensor(11,$conn); ?>"
    }},
  {
    type: 'Feature',
    geometry: {
      type: 'Point',
      coordinates: [40.871632901921686,23.22789488141393]
    },
    properties: {
      description: "<?php sensor(12,$conn); ?>"
    }},
  {
    type: 'Feature',
    geometry: {
      type: 'Point',
      coordinates: [40.871621476853505,23.227914761644115]
    },
    properties: {
      description: "<?php sensor(13,$conn); ?>"
    }},
  {
    type: 'Feature',
    geometry: {
      type: 'Point',
      coordinates: [40.871590809555414,23.22789488141393]
    },
    properties: {
      description: "<?php sensor(14,$conn); ?>"
    }},
  {
    type: 'Feature',
    geometry: {
      type: 'Point',
      coordinates: [40.8716359085181,23.2278121796582]
    },
    properties: {
      description: "<?php sensor(15,$conn); ?>"
    }
  }]
};

var bounds = new Array();

// add markers to map
geojson.features.forEach(function(marker) {

//revese LatLong to LongLat
marker.geometry.coordinates.reverse();    
    
  // create a HTML element for each feature
  el = document.createElement('div');
  el.className = 'marker';

  // make a marker for each feature and add to the map
  new mapboxgl.Marker(el)
    .setLngLat(marker.geometry.coordinates)
    .addTo(map);
    
new mapboxgl.Marker(el)
  .setLngLat(marker.geometry.coordinates)
  .setPopup(new mapboxgl.Popup({ offset: 25 }) // add popups
    .setHTML(marker.properties.description))
  .addTo(map);
 
  bounds.push(marker.geometry.coordinates);
});

var coordinates = bounds;

var bound = coordinates.reduce(function(bounds, coord) {
return bounds.extend(coord);
}, new mapboxgl.LngLatBounds(coordinates[0], coordinates[0]));
 
map.fitBounds(bound, {
padding: 30
});
/*
//finding coordinates
map.on('style.load', function() {
  map.on('click', function(e) {
    var coordinates = e.lngLat;
    new mapboxgl.Popup()
      .setLngLat(coordinates)
      .setHTML('you clicked here: <br/>' + coordinates.lat+","+coordinates.lng)
      .addTo(map);
  });
});
*/
//if(window.innerHeight > window.innerWidth){
    //zoom
    //map.flyTo({center: map.getCenter(), zoom:19});
//}else{
    //ok
//}

</script>
<?php $conn->close(); ?>
</body>
</html>
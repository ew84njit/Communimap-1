<!DOCTYPE html>
<html>	
  <head>
    <link rel = "stylesheet" type="text/css" href= "/MAKESPP/style.css" media="all"/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Pickup</title>
    
    
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>-->
  </head>

  <body>

    <h1 class="TitleText">Map Plotter</h1>

    <br>

    <div id = "Submission">
      <form id = "Form" action="insert.php" method="POST">
        Event Title:<br>
        <input type="text" name="title"/><br>

        Event Description:<br>
        <input type="text" name="about" id="desc"/><br>

        Event Date:<br>
        <input type="datetime-local" name="date" /><br>

        Event Location:<br>
        <input type="text" name="location"/><br>

        Latitude:<br>
        <input type="text" name="lat"/><br>

        Longitude:<br>
        <input type="text" name="long"/><br><br>

        <input type="submit" name = "register_btn" id = "submitBtn"/><br>
        
      </form>

    </div>

    <?php
    
      $lat = array();
      $lon = array();
      $coordinates = array();
		  $link = mysqli_connect("localhost", "root", "", "data");

      if (!$link) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
      }
  
      $sql = "SELECT latitude,longitude,title,about,date,address FROM events ORDER BY ID ASC";
      $result = $link->query($sql);

      if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
          $lat = $row["latitude"];
          $lon = $row["longitude"];
          $name = $row["title"];
          $about = $row["about"];
          $date = $row["date"];
          $loc = $row["address"];

          $coordinates[]=array($lat, $lon, $name, $about, $date, $loc);
        }
        $locations = json_encode($coordinates);
      }
      else {
        echo "0 results";
      }

      $link->close();
    
    ?>

    <div id="map">
      <script type="text/javascript">
        //some variables
        var lat = <?php echo json_encode($lat);?>;
        var lon = <?php echo json_encode($lon);?>;

        //locations as a list
        <?php
          echo "var locations=$locations;\n";
        ?>
        
        //function for map
        
        function initMap() {
          var map;
          map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 38.487995, lng: -99.191275},
            zoom: 4
          });

          var marker,i;
          var markers = new Array();

          
          for (i = 0; i < locations.length; i++) { 
            marker = new google.maps.Marker({
              position: new google.maps.LatLng(locations[i][0], locations[i][1]),
              map: map
            });

            markers.push(marker);

            //initializing the infoWindow
            var infowindow = new google.maps.InfoWindow({
              maxWidth: 500,
              maxHeight: 300
            });

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
              return function() {
                var windowContent = 
                'Name: ' + locations[i][2] + '<br>' + 
                'About: ' + locations[i][3] + '<br>' + 
                'Date and Time: ' + locations[i][4] + '<br>' +
                'Location: ' + locations[i][5];

                infowindow.setContent(windowContent);
                infowindow.open(map, marker);
              } 
            })(marker, i));

          }

          function AutoCenter() {
            var bounds = new google.maps.LatLngBounds();
            $.each(markers, function (index, marker) {
            bounds.extend(marker.position);
            });
            
            map.fitBounds(bounds);
          }
          AutoCenter();
        }

      </script>

    </div>
    
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCFMtt2pb3rmfAaXj3S3-4vWO5ajd5j3So&callback=initMap"></script>

	  <br>
  </body>
</html>

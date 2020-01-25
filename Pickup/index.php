<!DOCTYPE html>
<html>	
<head>
  <link rel = "stylesheet" type="text/css" href = "theme.css" media="all"/>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Pickup</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</head>

<body>

  <div id = "container">


    <!--TOP BAR-->
    <div class = "title">
      <h1 class="TitleText">PICKUP FINDER</h1>
    </div> 

    <div class = "spacer"></div>
    
    <div id = "content">
      <form id = "Form" action="insert.php" method="POST">
        <label class="label">
          Event Title:<br>
          <input type="text" name="title"/><br><br>
        </label>

        <label class="label">
          Event Description:<br>
          <input type="text" name="about" id="desc"/><br><br>
        </label>  

        <label class="label">
          Event Date:<br>
          <input type="datetime-local" name="date" /><br><br>
        </label>

        <label class="label">
          Event Location:<br>
          <input type="text" name="location" id="inputAddress"/><br><br>
        </label>

        <label class="label">
          Latitude:<br>
          <input type="text" name="lat"/><br><br>
        </label>

        <label class="label">
          Longitude:<br>
          <input type="text" name="long"/><br><br>
        </label>

        <input type="submit" name = "register_btn" class = "submitBtn"/><br>
      </form>
    </div>

    <div class = "spacer"></div>
    <p id="testing"></p>
  </div>

  <!--READING FROM THE TABLE-->
  <?php
    $lat = array();
    $lon = array();
    $coordinates = array();
    $link = mysqli_connect("localhost", "root", "root", "data",3306);

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

        $coordinates[]=array($name, $about, $date, $loc);
      }
      $locations = json_encode($coordinates);
    }
    else {
      echo "0 results";
    }

    $link->close();
  ?>

  
  <!--AUTOCOMPLETE + GEOCODING-->





  <!--GOOGLE MAPS MAP CODE-->
  <div id="map">
    <script type="text/javascript">


      //PUTTING ARRAY FROM PHP CODE INTO JAVASCRIPT FORM
      <?php echo "var locations=$locations;\n";?>


      
      //FUNCTION FOR MAP
      function initMap() {

        var map;
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 38.487995, lng: -99.191275},
          zoom: 4
        });

        var iconBase = 'https://developers.google.com/maps/documentation/javascript/examples/full/images/';
        var icons = {
          basketball: {
            icon: iconBase + 'basketball2.png'
          }
        };

        var marker;
        var i;

        var markers = new Array();
        var geocoder = new google.maps.Geocoder();


        for (i = 0; i < locations.length; i++) { //Start of For Loop
          console.log('Before click: ' + i);

          
          geocoder.geocode({'address': locations[i][3]}, function(results,status){ //Geocode function
            //if (status == google.maps.GeocoderStatus.OK){
            map.setCenter(results[0].geometry.location);
            str = String(results[0].geometry.location);
            var comma = str.indexOf(",");

            var lat = str.substr(1,comma -1);
            var lng = str.substr(comma+1, str.length-comma-2);

            marker = new google.maps.Marker({
                position: new google.maps.LatLng(lat, lng),
                map:map
            });

            markers.push(marker);
            var infowindow = new google.maps.InfoWindow({
              maxWidth: 500,
              maxHeight: 400
            });

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
              return function() {
                console.log('After click: ' + i);
                var windowContent =  'Name: ' + locations[i-1][0]; + '<br>' + 'About: ' + locations[i-1][1] + '<br>' + 
                'Date and Time: ' + locations[i-1][2] + '<br>' +
                'Location: ' + locations[i-1][3];
                infowindow.setContent(windowContent);
                infowindow.open(map, marker);
              } 
            }) (marker, i));
              
            //} //End if statement 
        
            //else {
              //alert('Geocoder isnt working right now');
            //}

          });
      
        } //End of For Loop




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



  <div class="footer">
    <p>© 2020 Sky Ventor</p><br>
  </div>
  
</body>
</html>

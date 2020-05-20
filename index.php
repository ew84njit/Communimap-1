<!DOCTYPE html>
<html>	
<head>
  <title>Home - Communimap</title>
  <link rel = "stylesheet" type="text/css" href = "theme.css" media="all"/>
  <link rel = "stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCFMtt2pb3rmfAaXj3S3-4vWO5ajd5j3So&libraries=places"></script>

</head>

<body>

  <div id = "container">

    <!--TOP BAR-->
    <div class = "title">
      <h1 class="TitleText">communimap.</h1>
      <h2 class="slogan">share your events to the world</h2><br>
    </div> 

    <div class="guide">
      <a class="menu" href="index.php" style="text-decoration:none">Home</a>
    </div>
    <div class = "spacer"></div>

    <div id = "content">
      <!--FORM-->
      <form id="Form" action="insert.php" method="POST">
        <div class="form-group">
          <label>Event Title</label><br>
          <input type="text" name="title" placeholder="Enter Title"/><br><br>
        </div>

        <div class="form-group">
          Event Description<br>
          <textarea rows="4" cols="100" name="about"></textarea><br><br>
        </div>

        <label class="label">
          Event Date:<br>
          <input type="datetime-local" name="date"/><br><br>
        </label>

        <div class="form-group">
          <label class="label">Event Location</label><br>
          <input type="text" name="location" placeholder="Enter Address"/><br><br>
        </div>

        <input type="submit" name = "register_btn" class="submitBtn" value="Submit"/><br>
      </form>
      
    </div>
    <div class = "spacer"></div>
  </div>

  <?php
    $lat = array();
    $lon = array();
    $coordinates = array();
    $link = mysqli_connect("localhost", "root", " ", "mapshare");

    if (!$link) {
      echo "Error: Unable to connect to MySQL." . PHP_EOL;
      echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
      echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
      exit;
    }

    $sql = "SELECT title,about,date,address FROM events ORDER BY ID ASC";
    $result = $link->query($sql);

    if($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
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

  <div id="map">
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCFMtt2pb3rmfAaXj3S3-4vWO5ajd5j3So&callback=initMap"></script>
    <script type="text/javascript">

      //locations as a list
      <?php echo "var locations=$locations;\n";?>

      //function for map
      
      function initMap() {
        var map;
        var geocoder = new google.maps.Geocoder();

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

        var marker,i;
        var markers = new Array();
        
        locations.forEach(function(listItem,i) { 
          var latitude;
          var longitude;
          var latLng;
          var address = locations[i][3];

          
          geocoder.geocode({'address': address}, function(results,status){

            var iconURL = "//img.icons8.com/small/32/000000/marker.png"; //Marker icon
            if(status == google.maps.GeocoderStatus.OK){

              <?php echo "var locations=$locations;\n";?>

              console.log("i: " + i);


              latitude = results[0].geometry.location.lat();
              longitude = results[0].geometry.location.lng();
              latLng = new google.maps.LatLng(latitude,longitude);

              marker = new google.maps.Marker({
                position: latLng,
                map:map,
                icon: {
                  url: iconURL
                }
              });
              
              markers.push(marker);

              //initializing the infoWindow
              var infowindow = new google.maps.InfoWindow({
                maxWidth: 500,
                maxHeight: 300
              });

              //Adding in infowindow content
              google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                  var windowContent = 
                  'Name: ' + locations[i][0] + '<br>' + 
                  'About: ' + locations[i][1] + '<br>' + 
                  'Date and Time: ' + locations[i][2] + '<br>' +
                  'Location: ' + locations[i][3];

                  infowindow.setContent(windowContent);
                  infowindow.open(map, marker);
                } 
              })(marker, i));
              AutoCenter();

            }
          });

        });

        function AutoCenter() {
          var bounds = new google.maps.LatLngBounds();
          $.each(markers, function (index, marker) {
            bounds.extend(marker.position);
          });
          
          map.fitBounds(bounds);
        }
        
      }

    </script>
  </div>

  <div class="footer">
    <p>© 2020 Sky Ventor</p><br>
  </div>
  
</body>
</html>

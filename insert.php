<?php
$link = mysqli_connect("localhost", "root", "", "data");

if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

echo "Connection was successful!." . PHP_EOL;
echo "Host information: " . mysqli_get_host_info($link) . PHP_EOL;

$title = $_POST['title'];
$about = $_POST['about'];
$date = $_POST['date'];
$address = $_POST['location'];
$lat = $_POST['lat'];
$lon = $_POST['long'];


$sql = "INSERT INTO events(title,about,date,address,latitude,longitude) VALUES('$title','$about','$date','$address','$lat','$lon')";
//$stmt = $link->prepare($sql);

//$stmt->bind_param("ssssss",$title,$about,$date,$address,$lat,$lon);
//$stmt->execute();

echo'<br>';


if($link->query($sql)){
	echo "New record is inserted";
}
else{
	echo "There is an error. Record not inserted.";
}


mysqli_close($link);

echo'<br>';
echo '<a href="index.php">Click here to return to the Homepage</a>';
?>



<html>
<head>
    <link rel = "stylesheet" type="text/css" href = "theme.css" media="all"/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Thank You - Communimap</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
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
        <br>
        <button onclick="window.location.href = 'index.php';" class="submitBtn">Go Home</button>
        <div class = "spacer"></div>
    </div>

</body>
</html>

<?php
$link = mysqli_connect("localhost", "root", " ", "mapshare");

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

$sql = "INSERT INTO events(`title`,`about`,`date`,`address`) VALUES('$title','$about','$date','$address')";


echo'<br>';
if($link->query($sql)) 
{
	echo "New record is inserted";
}
else
{
	echo "There is an error. Record not inserted.";
}


mysqli_close($link);

echo'<br>';

?>


<html>
<body>
    <div class="footer">
        <p>© 2020 Sky Ventor</p><br>
    </div>
</body>
</html>
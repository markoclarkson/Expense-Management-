<?php
session_start();
$tablename = isset($_SESSION["username"]) ? $_SESSION["username"] : '';
$tablename = $tablename."_table";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Logs</title>
    <link rel="stylesheet" href="css/view_log.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <!-- font fetched from google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Grandstander&display=swap" rel="stylesheet">
    <style type="text/css">
        .button {
    text-decoration: none;
    color: white;
    display: inline-flex;
}

.button:hover {
    background-color: white;
    color: black;
}
li {
    display: inline-flex;
    width: 100%;
}
    </style>
</head>
<body>
    <li><a type="button" class="button" href="home.html">Home</a></li>
    <form>
    <div class="sbt">
        <input type="submit" formaction="export-log.php" value="EXPORT LOG">
        <!-- submit button for exporting logs -->
        <input type="submit" formaction="chart/chart.php" value="GRAPHS">
    </div>
    </form>
</body>
</html>
<?php
echo '<br>';
echo '<br>';
//connection variables
$server= "localhost";
$user= "root";
$pass= "";
$database="ad";
//connection
$con= mysqli_connect($server, $user, $pass, $database);

if(!$con){//shows error if connection is unsuccessful
die("Connection Unsuccessful :: Cause ::" . mysqli_connect_error());
}

if(!isset($_POST['month'])){$month= "%";}
else{$month= $_POST['month'];}

if(!isset($_POST['year'])){$year= "%";}
else{$year= $_POST['year'];}

$mname= ["", "JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE", "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER"];

if($month== "%" && $year== "%"){
    echo '<h1>SHOWING FULL LOG</h1>';
}
elseif ($month== "%" && $year!= "%") {
    echo '<h1>SHOWING LOGS FOR YEAR : ' . $year . '</h1>';
}
elseif ($month!= "%" && $year== "%"){
    echo '<h1>SHOWING LOGS FOR MONTH : ' . $mname[(int)$month] . ' ACROSS ALL YEARS';
}
else{
    echo '<h1>SHOWING LOGS FOR MONTH : ' . $mname[(int)$month] . ' OF YEAR : ' . $year . '</h1>';
}

//query for fetching table from the database


$results = $con->query("SELECT * FROM `ad`.".$tablename." where `date` like '___$month-$year'");
//  ''' NOTE : here both database and table name are used in the query '''

//table tags start

echo '<table border=2 cellspacing=0>';

//all columns
echo '<tr>';
echo '<th>ID</th>';
echo '<th>Amount</th>';
echo '<th>Purpose</th>';
echo '<th>Date</th>';
echo '<th>Time</th>';
echo '</tr>';

//each row is saved as an array from the result variable
while($row = $results->fetch_array()) {
    echo '<tr>';

    for($i =0; $i< 5; $i++){
        //fetches each row as an array
        echo '<td>'.$row[$i].'</td>';
    }

    echo '</tr>';
}   
echo '</table>';//end of table

$con->close();//connection closed
?>


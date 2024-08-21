<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Logs</title>
    <link rel="stylesheet" href="css/transaction.css">
    <style type="text/css">
        .button {
    text-decoration: none;
    color: black;
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
<?php

if(isset($_POST['amt'])){

//connection variables
$server= "localhost";
$user= "root";
$pass= "";

//connection
$tablename = isset($_SESSION["username"]) ? $_SESSION["username"] : '';
$tablename = $tablename."_table";
$con= mysqli_connect($server, $user, $pass);

if(!$con){
die("Connection Unsuccessful :: Cause ::" . mysqli_connect_error());
}
date_default_timezone_set("Asia/Kolkata");

//fields to be entered in database
$tid= "THL_" . date("Ymd") . "_" . date("His");
$amt= $_POST['amt'];
$pur= $_POST['pur'];
$dt= date("d-m-Y");
$tm= date("h:i:s") . " " . strtoupper(date("a"));

//sql query
$sql_query= "insert into `ad`.".$tablename."(`id`, `amount`, `purpose`, `date`, `time`) 
values ('$tid', '$amt', '$pur', '$dt', '$tm')";

if($con->query($sql_query) == true){
    echo "<h1>SUCCESSFULLY INSERTED !</h1><br>";
    echo "<h3><center>TRANSACTION ID : $tid";
    echo "<br>Amount : $amt";
    echo "<br>Purpose : $pur";
    echo "<br>Date : $dt";
    echo "<br>Time : $tm </h3><center>";
}
else{
    echo "ERROR : $sql_query <br> $con->error";
}

$con->close();
}

?>

<form method= "post">
<div class="sbt">
    <input type="submit" formaction="transaction-log.html" value="ENTER TRANSACTION">
    <input type="submit" formaction="export-log.php" value="EXPORT LOG">
    <input type="submit" formaction="select-log.html" value="VIEW LOG">
</div>
</form>
</body>

</html>
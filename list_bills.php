<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bills</title>
    <style type="text/css">
        body {
    background: #594F4F;
    background: -moz-linear-gradient(-45deg, #1d4946  10%, #594F4F 100%);
    background: -webkit-linear-gradient(-45deg, #1d4946  10%, #594F4F    100%);
    background: linear-gradient(200deg, #1d4946  10%, #594F4F 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1d4946 ', endColorstr='594F4F   ', GradientType=1 );
    text-align: center;
    align-content: center;
}
h1 {
    text-align: center;
    font-size: 42px;
    padding: 20px;
}
table{
    border: 5px solid ;
    width: 100%;
    text-align: center;
    font-size: 25px;
    text-transform: capitalize;
    border-radius: 5px;
}
.button {
    text-decoration: none;
    padding: 8px;
    margin: 10px;
    color: white;
    background-color: black;
    display: inline-flex;
}
.button:hover {
    background-color: white;
    color: black;
}
</style>
</head>
<body>
<h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BILLS</h1>
<br>
<?php

    $server= "localhost";
    $user= "root";
    $pass= "";
    $dbname = "ad";

    $con= mysqli_connect($server, $user, $pass, $dbname);

    if(!$con)
    {
        die("Connection Unsuccessful due to ".mysqli_connect_error());
    }

    //query for fetching table from the database
    $tablename = isset($_SESSION["username"]) ? $_SESSION["username"] : '';
    $tablename = $tablename."_bills";
    $results = $con->query("SELECT * FROM ".$tablename);
    echo '<div class="main">';
    //table tags start
    echo '<table border=2 cellspacing=0>';

    //all columns
    echo '<tr>';
    echo '<th>Category</th>';
    echo '<th>Amount</th>';
    echo '<th>Date</th>';
    echo '</tr>';

    //each row is saved as an array from the result variable
    while($row = $results->fetch_array())
    {
        echo '<tr>';

        for($i =0; $i< 3; $i++)
        {
            //fetches each row as an array
            echo '<td>'.$row[$i].'</td>';
        }
        echo '</tr>';
    }   
    echo '</table>';//end of table
    echo '</div>';
    $con->close();//connection closed
?>

<br>
<h2><a class="button" href="bills.php">GO TO BILLS</a></h2>
</body>
</html>

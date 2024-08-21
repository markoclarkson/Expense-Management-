<?php
    session_start();
    $server = "localhost";
    $user = "root";
    $password = "";
    $dbname = "ad";
    $connection = mysqli_connect($server,$user,$password,$dbname);

    if(!$connection)
    {
        die('Connect error due to '.mysqli_connect_error());
    }

    $category = (isset($_POST['Category']) ? $_POST['Category'] : '');
    $amount = (isset($_POST['Amount']) ? $_POST['Amount'] : '');
    $date = (isset($_POST['Date']) ? $_POST['Date'] : '');
    $tablename = isset($_SESSION["username"]) ? $_SESSION["username"] : '';
    $tablename = $tablename."_bills";
    $insert = "INSERT INTO ".$tablename." values(?, ?, ?)";
    $insert = mysqli_prepare($connection, $insert);
    $insert->bind_param("sis", $category, $amount, $date);
    $insert->execute();
   
    $connection->close();
    echo '<div style="font-size:2.25em;">Successfully added !</div>';
    header("location:bills.php");
?>
<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ad";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$tablename = isset($_SESSION["username"]) ? $_SESSION["username"] : '';
$tablename = $tablename."_goals";
$pname=$_POST['goal'];
$pnote=$_POST['comment'];
$pamount=$_POST['amount'];
$sql = "INSERT INTO ".$tablename." VALUES('".$pname."','".$pnote."','".$pamount."')";

if ($conn->query($sql) == TRUE) {
  header("location: goal.php");
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
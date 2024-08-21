<?php
session_start();
$tablename = isset($_SESSION["username"]) ? $_SESSION["username"] : 'root';
$temp = $tablename;
$tablename = $tablename."_table";
$server= "localhost";
$user= "root";
$pass= "";
$database="ad";
//connection
$con= mysqli_connect($server, $user, $pass, $database);
$err = "";
$salary = $totalexpense = $totalbill = $left = $total = 0;
if(!$con)
{ //shows error if connection is unsuccessful
	die("Connection Unsuccessful :: Cause ::" . mysqli_connect_error());
}
if(isset($_POST["salary"]))
	{
		$salary = $_POST["salary"];
		//echo $salary;
	}
else
{
	$err = "Please Enter your salary ";
}
$sql_query = "update `user_login_test` set salary = ".$salary." where username = '".$temp."';";
if($con->query($sql_query) == true){
	header("location:home.html");	
}
else{
    echo "ERROR : $sql_query <br> $con->error";
}
//echo $tablename;
$con->close();

?>
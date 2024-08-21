<?php
session_start();
$salary = $totalexpense = $totalbill = $left = $total = 0;
$tablename = isset($_SESSION["username"]) ? $_SESSION["username"] : '';
$temp = $tablename;
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
?>
<!DOCTYPE html>
<html>
<head>
	<title>Account Information</title>
	<style type="text/css">
		body {
	font-size: 1.4em;
	line-height: 1.6;
	color: black;
	font-family: 'Open Sans', Helvetica, Arial, sans-serif;
	background: #594F4F;
	background: -moz-linear-gradient(-45deg, #1d4946  10%, #594F4F 100%);
	background: -webkit-linear-gradient(-45deg, #1d4946  10%, #594F4F    100%);
	background: linear-gradient(200deg, #1d4946  10%, #594F4F 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1d4946 ', endColorstr='594F4F   ', GradientType=1 );
}

		.button {
    text-decoration: none;
    color: white;
    display: inline-flex;
    font-size: 140%;
    padding: 1%;
    margin-top: auto;
    margin-bottom: auto;
    margin-right: auto;
    margin-left: 2%;
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
	<center><h2>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>.</h2></center>
	<center><h3>Below is a summary of your wallet based on our data.</h3></center>
	<?php
		$result = mysqli_query($con,"select sum(amount) from ".$temp."_bills");
		while($row = $result->fetch_array()){$totalbill = (int)$row[0];}
		//echo "Total of bills paid : ";
		//echo $totalbill;

		$result = mysqli_query($con,"select sum(amount) from ".$temp."_table");
		while($row = $result->fetch_array()){$totalexpense = (int)$row[0];}
		//echo "Total of daily expenses : ";
		//echo $totalexpense;

		$result = mysqli_query($con,"select salary from user_login_test where username = '".$temp."';");
		while($row = $result->fetch_array()){$salary = (int)$row[0];}
		//echo "Salary : ";
		//echo $salary;

	    $sqlbills = "select sum(amount) from ".$temp."_bills";
	    $sqlexpense = "select sum(amount) from ".$temp."_table";
	    if ($con->query($sqlbills) == true) 
	    {
    		if ($con->query($sqlexpense) == true) 
    		{
	    		$total = $totalexpense + $totalbill;		
    		}
    		else
    		{
    			echo "Could not fetch records from table";
    		}
    	}
    	else
    	{
    		echo "Could not fetch records from bills";
    	}
    	if (is_numeric($totalbill) && is_numeric($totalexpense)) 
		{
			$left = $salary - $total;
			//echo "Savings : ";
			//echo $left;
		}
		if ($left > 25000) {
			$msg = "You are a champ on saving";
		} else if ($left > 15000 ){
			$msg = "You are a good at saving";
		} else if ($left > 10000 ){
			$msg = "You can do better at your savings";
		}
		else if($left <= 0){
			$msg = "You seriously need to workout on your savings";
		}
		else{
			$msg = "You are just making the ends match ";
		}
		$sql_query = "update `user_login_test` set savings = ".$left." where username = '".$temp."';";
		if($con->query($sql_query) == true)
		{
			$_SESSION["bills"] = $totalbill;
			$_SESSION["expenses"] = $totalexpense;
			$_SESSION["salary"] = $salary;
			$_SESSION["savings"] = $left;
		}
	?>
	<table>
		<tr>
			<td><h3>Salary</h3></td>
			<td><h3> : </h3></td>
			<td><h3><?php echo $salary; ?></h3></td>
		</tr>
		<tr>
			<td><h3>Total amount spent on bills</h3></td>
			<td><h3> : </h3></td>
			<td><h3><?php echo $totalbill; ?></h3></td>
		</tr>
		<tr>
			<td><h3>Total amount spent on daily expenses</h3></td>
			<td><h3> : </h3></td>
			<td><h3><?php echo $totalexpense; ?></h3></td>
		</tr>
		<tr>
			<td><h3>Total Savings</h3></td>
			<td><h3> : </h3></td>
			<td><h3><?php echo $left; ?></h3></td>
		</tr>
	</table>
	<center><h3><?php echo $msg; ?></h3></center>
</body>
</html>
<?php 
session_start();
$totalexpenses = $totalbill = $salary = $left = 0;
$totalbill = $_SESSION["bills"];
$totalexpenses = $_SESSION["expenses"];
$salary = $_SESSION["salary"];
$left = $_SESSION["savings"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bills</title>
<style>

.banner{
	width: 100%;
	position: relative;
}


/* Make the image responsive */
.banner img {
  width: 100%;
  	opacity: 80%;
}


/* Style the button and place it in the middle of the container/image */
.banner .btn {
	display: inline-flex;
  color: black;
  font-size: 16px;
  padding: 12px 24px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
  font-weight: bold;
}

.banner .btn:hover {
  background-color: white;
  color: black;
}

#menu-outer {
	height: 84px;
	min-height: 120px;
	background: #1d4946 ;
	background: -moz-linear-gradient(-45deg ,#1d4946  0%, #5fc3e4 50%);
	background: -webkit-linear-gradient(-45deg,  #1d4946  0%, #5fc3e4 50%);
	background: linear-gradient(135deg, #1d4946  0%, #5fc3e4 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1d4946', endColorstr='594F4F', GradientType=1 );
	box-sizing: border-box;
	justify-content: center;
	position: relative;
}

.table {
	display: table;   /* Allow the centering to work */
	float: right;
}

ul#horizontal-list {
	list-style: none;
	padding: 40px;
	}
	ul#horizontal-list li {
		display: inline;
	}

.button {
    text-decoration: none;
    padding: 10px 28px;
    color: white;
    display: inline-flex;   
}

.button:hover {
    background-color: white;
    color: black;
}	
.btn {
	font-size: 30px;
}
.right {
	text-align: right;
	margin-right: 5px;
}
.txt {
	margin-top: -350px;
}
body {
	color: white;
	font-family: 'Open Sans', Helvetica, Arial, sans-serif;
	background: #594F4F;
	background: -moz-linear-gradient(-45deg, #1d4946 10%, #594F4F 100%);
	background: -webkit-linear-gradient(-45deg, #1d4946 10%, #594F4F 100%);
	background: linear-gradient(200deg, #1d4946 10%, #594F4F 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1d4946 ', endColorstr='594F4F   ', GradientType=1 );
}
p.solid {
	padding: 10px;
}
.button {
	text-decoration: none;
	padding: 8px;
	margin: 10px;
	color: white;
	display: inline-flex;
}
.button:hover {
	background-color: white;
	color: black;
}

#piechart{
	color: white;
	font-family: 'Open Sans', Helvetica, Arial, sans-serif;
	background: #594F4F;
	background: -moz-linear-gradient(-45deg, #1d4946 10%, #594F4F 100%);
	background: -webkit-linear-gradient(-45deg, #1d4946 10%, #594F4F 100%);
	background: linear-gradient(200deg, #1d4946 10%, #594F4F 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1d4946 ', endColorstr='594F4F   ', GradientType=1 );
}

</style>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['Type', 'Amount'],
  ['Savings', <?php echo $left; ?>],
  ['Salary', <?php echo $salary; ?>],
  ['Bills', <?php echo $totalbill; ?>],
  ['Expense', <?php echo $totalexpenses; ?>]
]);

  // Optional; add a title and set the width and height of the chart
  var options = {'title':'Wallet', 'width':550, 'height':400};

  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
}
</script>
</head>
<body>
<a class="button btn" href="home.html">Home</a>
<br>
<br>
<br>
<table>
	<tr>
  <td><div id="piechart" style="width: 600px; height: 400px;"></div></td><td>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</td>
		<td>
<div class="right">
 <iframe src="https://calendar.google.com/calendar/embed?height=340&amp;wkst=1&amp;bgcolor=%23ffffff&amp;ctz=Asia%2FKolkata&amp;showTabs=1&amp;showCalendars=1&amp;showTitle=1" style="border:solid 1px #777" width="600" height="400" frameborder="0" scrolling="no"></iframe>
</div></td>
</tr>
</table>
<br><br>
  <div class="btn" align="center">
  	   <a href="list_bills.php" class="button">List Bills</a>
  	   <a href="add_bill.html" class="button"> Add A Bill </a>
  </div>
</body>
</html>
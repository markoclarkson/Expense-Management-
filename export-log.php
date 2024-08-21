<?php
session_start();

//connection to the database (variables hard coded)
$conn = new mysqli('localhost', 'root', '','ad');
//variables : server, username, password, database

mysqli_select_db($conn, 'crud');  

if(!$conn){
die("Connection Unsuccessful :: Cause ::" . mysqli_connect_error());
}

//query to be executed
$tablename = isset($_SESSION["username"]) ? $_SESSION["username"] : '';
$name = $tablename;
$tablename = $tablename."_table";
$sql = "SELECT * FROM ".$tablename;  

//query is executed here using php method
$setRec = mysqli_query($conn, $sql);  


if($conn->query($sql) == true){}
else{
  echo "ERROR : $sql <br> $conn->error";
}

$columnHeader = '';  
$columnHeader = "Id" . "\t" . "Amount" . "\t" . "Purpose" . "\t" . "Date" . "\t" . "Time";  

$setData = '';
while ($rec = mysqli_fetch_row($setRec)){
  $rowData = '';  
    foreach ($rec as $value) {
      $value = '"' . $value . '"' . "\t";
      $rowData .= $value;
    }
  $setData .= trim($rowData) . "\n";  
}

//file related information
header("Content-type: application/octet-stream");  
header("Content-Disposition: attachment; filename=".$name."_Expense.xls");  
header("Pragma: no-cache");  
header("Expires: 0");  

echo ucwords($columnHeader) . "\n" . $setData . "\n";  
$conn->close(); //closing of connection
?>
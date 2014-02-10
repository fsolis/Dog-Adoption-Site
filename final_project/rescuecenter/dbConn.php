<?php
$host = "localhost";
$dbName = "soli7352"; 
$username = "soli7352"; 
$pwd = "33d6f3c123d5d46"; 

//creates connection
$dbConn = new PDO("mysql:host=".$host.";dbname=".$dbName, $username, $pwd);

// Sets Error handling to Exception so it shows ALL errors when trying to get data
$dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>

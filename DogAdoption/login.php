<?php
session_start();
include 'dbConn.php';

	echo "here";  //login form has been submitted
 	$sql = "SELECT * FROM final_client " .
              " WHERE username = :username" .
               " AND password = :password";
   	$stmt = $dbConn->prepare($sql);
	$stmt->execute( array (":username"=>$_POST['username'] ,
 	                   ":password"=>hash("sha1", $_POST['password'])));
	$record = $stmt->fetch();
  	if (!empty($record)) { //checks whether record with username and password was found
        $_SESSION['userName'] = $record['userName'];
        $_SESSION['adminName'] = $record['fName'] . " " . $record['lName'];
		$_SESSION['cId']= $record['cId'];
		$_SESSION['fName']= $record['fName'];
		$_SESSION['lName']= $record['lName'];
		$_SESSION['phone']=$record['phone'];
		$_SESSION['fPick'] = $record['fPick'];
		$_SESSION['permission']= "client";
		$_SESSION['email'] = $record['email'];
		
		header("Location: index.php");
		
    } else {
    	
		$sql = "SELECT * FROM final_admin " .
              " WHERE username = :username" .
               " AND password = :password";
   		$stmt = $dbConn->prepare($sql);
		$stmt->execute( array (":username"=>$_POST['username'] ,
 	                   ":password"=>hash("sha1", $_POST['password'])));
		$record = $stmt->fetch();
  		if (!empty($record)) { //checks whether record with username and password was found
        	$_SESSION['userName'] = $record['userName'];
        	$_SESSION['adminName'] = $record['fName'] . " " . $record['lName'];
			$_SESSION['uId']= $record['uId'];
			$_SESSION['fName']= $record['fName'];
			$_SESSION['lName']= $record['lName'];
			$_SESSION['permission']= "admin";
		
		header("Location: admin.php");
    	}else{
    		 $_SESSION['error']="Wrong username or password";  
			 header("Location: index.php");
	}
	} //endIf loginForm was submitted ' OR 1=1 OR '
?>
<?php

	require_once 'dbConn.php';
		
	$sql = "SELECT * FROM final_client WHERE userName = :userName";
	$stmt = $dbConn->prepare($sql);
	$stmt->execute(array(":userName"=>$_GET['username']));
	$record = $stmt->fetch();
	if(empty($record)){
		echo "Available";
	}else{	echo "Exists!";}
//it displays "1" if the username entered already exists in the array
?>

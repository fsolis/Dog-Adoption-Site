<!DOCTYPE html>
<?php
	session_start();
	require_once'dbConn.php';
	if(isset($_SESSION['permission']))
	{
		if($_SESSION['permission']=="client")
		{
			header("Location: index.php");
		}
	}else{
		header("Location: index.php");
	}
	if(isset($_POST['submit'])){
		$sql = "DELETE FROM final_dog WHERE dId=:Id";
	 	$stmt = $dbConn->prepare($sql);
	 	$stmt->execute(array(":Id"=>$_POST['id']));

		$sql = "DELETE FROM final_doginfo WHERE dId=:Id";
	 	$stmt = $dbConn->prepare($sql);
	 	$stmt->execute(array(":Id"=>$_POST['id']));
		$update="happy";
	}

		
	
?>
<html lang="en">
<head>
  <meta charset="utf-8">

  <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame 
       Remove this if you use the .htaccess -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title>Solis Dog Rescue</title>
  <meta name="description" content="">
  <meta name="author" content="Freddy Solis">

  <meta name="viewport" content="width=device-width; initial-scale=1.0">

  <!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
  <div class="header">
      <h1>Solis Dog Rescue Center</h1>
  </div>
  <div class="login">
  		<div id="leftlogin">
  			<!--Error Will Be Displayed-->
  			<a href="admin.php">Home</a>
  			<?php 
              		if (isset($_SESSION['error']))
			  		{
						echo"<p id=\"error\">".$_SESSION['error']."</p>";
						unset($_SESSION['error']);
			 		 }
       		?>
  		</div>
  		<div id="rightlogin">
  			<?php
  				if(isset($_SESSION['fName']))
				{
					echo "<p id=\"hello\"> Hello, ". $_SESSION['fName']. "          <u><a href=\"logoff.php\">Logout</a></u> </p>";				
				}else{
					echo "<form method=\"post\" action=\"login.php\" name=\"loginForm\">";
  					echo "<input type=\"text\" name=\"username\"  placeholder=\"Username\"/>";
  					echo "<input type=\"password\" name=\"password\"  placeholder=\"Password\"/>";
  					echo "<input type=\"submit\" name=\"loginButton\" value=\"Login\"/>";
  					echo "</form>";
				}
  			
  			?>
  			
  		</div>
  </div>
  <div class="body">
  	<div id="leftpane"> <!--Makes left bar --> </div>
  	
  	<div id="content">
  		<h1>Delete</h1>
  		<h4>Sometimes You Just Have to Let Them Go</h4>
  		
  		<div id="updatedisplay">
  			<?php
  				$sql = "SELECT * FROM final_dog";
 				$stmt = $dbConn->prepare($sql);
 				$stmt->execute();
 				$record = $stmt->fetchAll();
				echo"<form method=\"post\" action=\"delete.php\">";
				if(!empty($record))
				{
  					echo"<select name=\"id\">";
					foreach($record as $row)
					{
						echo"<option value=\"".$row['dId']."\">". $row['dName']."</option>";
					}
  					echo"</select>";
					
					echo"<input type=\"submit\" name=\"submit\" value=\"Delete\" />";
				}else{
					echo "No Dog Currently Available";
				}
  				
  				echo"</form>";
				
  			?>
  			
  		</div>
	  
		<h1><?php if(isset($update)){echo "Dog Deleted";} ?></h1>

	  	
  	</div>
  	<div id="rightpane"> <!--Makes right bar --></div>
  </div>
  <div id="footer"> 
  	<h5> Address: 123 Pet Lane, Monterey CA  Phone Number: 831-777-7777</h5>
  </div>
</body>
</html>

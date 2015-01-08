<!DOCTYPE html>
<?php
	session_start();
	if(isset($_POST['submit']))
	{
		if(isset($_POST['cid']))
		{
			if(isset($_POST['did']))
			{
				require_once 'dbConn.php';
				$sql = "SELECT * FROM final_client WHERE cId = :cId";
 				$stmt = $dbConn->prepare($sql);
 				$stmt->execute(array(":cId"=>$_POST['cid']));
 				$clients = $stmt->fetchAll();
				foreach($clients as $client)
				{
					$cl = $client;
				}
				$cName = $cl['fName']." ".$cl['lName'];
				
				$sql = "SELECT * FROM final_dog b JOIN final_doginfo d ON b.dId = d.dId WHERE d.dId=:dId";
 				$stmt = $dbConn->prepare($sql);
 				$stmt->execute(array(":dId"=>$_POST['did']));
 				$dogs = $stmt->fetchAll();
				foreach($dogs as $dog)
				{
					$dg = $dog;
				}
				$sql = "INSERT INTO final_history (cId,dId,cName,dName,breed,pic,notes) 
					VALUES (:cId,:dId,:cName,:dName,:breed,:pic,:notes)";
				$stmt = $dbConn->prepare($sql);
				$stmt->execute( array(":cId"=>$cl['cId'], ":dId"=>$dg['dId'],":cName"=>$cName, ":dName"=>$dg['dName'], ":breed"=>$dg['breed'],":pic"=>$dg['picName'], ":notes"=>$dg['notes']));
				
				$sql = "UPDATE final_dog SET avail=:avail
					WHERE dId = :dId";
				$stmt = $dbConn->prepare($sql);
				$stmt->execute( array(":avail"=>"Adopt", ":dId"=>$_POST['did']));
				
				$sql = "UPDATE final_client SET fPick='0'
					WHERE cId = :cId";
				$stmt = $dbConn->prepare($sql);
				$stmt->execute( array(":cId"=>$cl['cId']));
				$feedback = "Connection Made";
			}else{
				$feedback = "No Dog Selected";
			}
		}else{
			$feedback = "No Client Selected";
		}
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
  		<h1>Connection</h1>
  		<h4>Yes! Let's Make Someone's Family Complete</h4>
  		
  		
	  	<div id="Form">
	  			<?php
				require_once 'dbConn.php';
  				$sql = "SELECT * FROM final_dog";
 				$stmt = $dbConn->prepare($sql);
 				$stmt->execute();
 				$record = $stmt->fetchAll();

				$sql = "SELECT * FROM final_client";
 				$stmt = $dbConn->prepare($sql);
 				$stmt->execute();
 				$record1 = $stmt->fetchAll();
				echo"<form method=\"post\" action=\"connect.php\">";
				if(!empty($record))
				{
					
  					echo"<select name=\"did\">";
					foreach($record as $row)
					{
						if($row['avail'] == "Avail")
						{
						echo"<option value=\"".$row['dId']."\">". $row['dName']."</option>";
						}
					}
  					echo"</select><br/>";
					
					
				}else{
					echo "No Dog Currently Available </br>";
				}
				if(!empty($record1))
				{
  					echo"<select name=\"cid\">";
					foreach($record1 as $row)
					{
						echo"<option value=\"".$row['cId']."\">". $row['fName']." ".$row['lName']."</option>";
					}
  					echo"</select><br/>";
					
					
				}else{
					echo "No Clients Currently Registered </br>";
				}
  				echo"<input type=\"submit\" name=\"submit\" value=\"Connect\" />";
  				echo"</form>";

				if(isset($feedback))
				{
					echo"<h2>".$feedback."</h2>";
					
				}
				
  			?>
	  		<br/>
	  	</div><!--form --> 
		<div>
			<table>
			<tr><th>Client</th><th>Dog</th><tr>
			<?php
				if(!empty($record1))
				{
					foreach($record1 as $client)
					{
						if($client['fPick'] != 0)
						{
							echo"<tr><td>".$client['lName']."</td>";
							foreach($record as $dog)
							{
								if($dog['dId'] == $client['fPick'])
							        {
									echo "<td>".$dog['dName']."</td>";			
								}
							}	
							echo"</tr>";
						}
					}	
				}
			?>
			</table>
		</div>
	  	
  	</div>
  	<div id="rightpane"> <!--Makes right bar --></div>
  </div>
  <div id="footer"> 
  	<h5> Address: 123 Pet Lane, Monterey CA  Phone Number: 831-777-7777</h5>
  </div>
</body>
</html>

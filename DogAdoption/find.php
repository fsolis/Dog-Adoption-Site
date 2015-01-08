<!DOCTYPE html>
<?php
	session_start();
	require_once'dbConn.php';
	$sql = "SELECT * FROM final_dog b
			JOIN final_doginfo d 
			ON b.dId = d.dId";
 	$stmt = $dbConn->prepare($sql);
 	$stmt->execute();
 	$record = $stmt->fetchAll();
	
	$path = "uploadFiles/fsolis";
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
  			<?php
  			
  			if(isset($_SESSION['permission']))
			{
				if($_SESSION['permission'] == "admin"){
				echo"<a href=\"admin.php\">Home</a>";
				}else{
				echo"<a href=\"index.php\">Home</a>";
				}
			}else{
				echo"<a href=\"index.php\">Home</a>";
			}
				
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
  		<h1>Look At All These Wonderful Dogs!</h1>
  		<div id="viewdogs">
  			<?php
  			if(!empty($record)){
	  			echo "<table><tr><th>Name</th><th>Breed</th><th>Gender</th><th>About</th><th>Adoption Fee</th><th>  </th></tr>";
			
				foreach($record as $row)
				{	if($row['avail'] == 'Avail')
					{
						echo"<tr><td>";
						echo $row['dName']. "</td>";
						echo "<td>". $row['breed']."</td>";
						echo "<td>". $row['gender']."</td>";
						echo "<td> ". $row['notes']."</td>";
						echo "<td> $". $row['price']."</td>";
						echo "<td>". "<img src=". $path . "/". $row['picName'] . " />"."</td>";
						echo"</tr>";
					}
					
				}
			}else{
				echo "<h1>Sorry, No Dog Currently Available</h1>";
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

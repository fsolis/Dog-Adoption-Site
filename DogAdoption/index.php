<!DOCTYPE html>
<?php
	session_start(); 
	require_once'dbConn.php';
	if (isset($_SESSION['permission']))
	{
		if($_SESSION['permission'] == "admin")
		{
			header("location:admin.php");
		}
	}
	$sql = "SELECT * FROM AdoptionHistory";
 	$stmt = $dbConn->prepare($sql);
 	$stmt->execute();
 	$record = $stmt->fetchAll();
	
	$path = "uploadFiles/DogMedia";
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
      <h1>Dog Rescue Center</h1>
  </div>
  <div class="login">
  		<div id="leftlogin">
  			<!--Error Will Be Displayed-->
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
  		<h1>Welcome!</h1>
  		
  		<div id="puppyimg"><img src="index.jpg" alt="puppy" height="200" width="300"></div>
  		<div id="aboutstatement"><p>  Hello, we are glad you have chosen to visit our website. Here at the Solis Dog Rescue Center we have dedicated our
  			lives to making sure a pet's transition from our arms to yours is as hassle free as possible. We focus on making sure that you and the friend you choose are compatible with each other. 
  			Feel free to look around at all of our lovely animals,
  			if you see one you like just apply and we'll start the process of connecting you and your bundle of joy as soon as possible.  </p>
  			</div>
  		<div id="buttons">
  			<a href="apply.php"><img src="apply.png"/></a>
  			<a href="find.php"><img src="find.png" /></a>
  		</div><br/>
		<div id="success">
			<h2>Success Stories</h2>
		<?php
			
			
  			if(!empty($record)){
	  			echo "<table><tr><th>Dog</th><th>Adopted By</th<th></th></tr>";
			
				foreach($record as $row)
				{
						echo"<tr><td>";
						echo $row['dName']. "</td>";
						echo "<td>". $row['cName']."</td>";
						echo "<td>". "<img src=". $path . "/". $row['pic'] . " />"."</td>";
						echo"</tr>";

				}
				echo"</table>";
			}else{
				echo "<h3>We Don't Have Any Yet, So How About A Challange?</h3>";
			}
		?>
		</div>
  	</div>
  	<div id="rightpane"> <!--Makes right bar --></div>
  </div>

  <div id="footer"> 
  	<h5> Address: 123 Pet Lane, Monterey CA  Phone Number: 831-777-7777</h5>
  </div>
</body>
</html>

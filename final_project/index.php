<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame 
       Remove this if you use the .htaccess -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title>Solis Pet Rescue</title>
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
      <h1>Solis Pet Rescue Center</h1>
  </div>
  <div class="login">
  		<div id="leftlogin">
  			<!--Error Will Be Displayed-->
  			<?php 
              	if (isset($errorArray))
			  	{	
			  	
					foreach($errorArray as $error)
					{	
						echo "<br/>" . $error . "<br />";
						
					}
			 	 }
       		?>
  			
  		</div>
  		<div id="rightlogin">
  			<form method="post" action="login.php" name="login">
  				<input type="text" name="username"  placeholder="Username"/>
  				<input type="password" name="password"  placeholder="Password"/>
  				<input type="submit" name="loginButton" value="Login"/>
  				<form method="post" action="register.php">
  					<input type="submit" name="registerButton" value="Register"/>
  				</form>
  			</form>
  			
  		</div>
  </div>
  <div class="body">
  	<div id="leftpane"> <!--Makes left bar --> </div>
  	
  	<div id="content">
  		<h1>Welcome!</h1>
  		
  		<div id="puppyimg"><img src="index.jpg" alt="puppy" height="200" width="300"></div>
  		<div id="aboutstatement"><p>Hello, we are glad you have chosen to visit our website. Here at the Solis Pet Rescue Center we have dedicated our
  			lives to making sure a pet's transition from our arms to yours is as hassle free as possible. We focus on making sure that you and the friend you choose are compatible with each other. 
  			Feel free to look around at all of our lovely animals,
  			if you see one you like just apply and we'll start the process of connecting you and your bundle of joy as soon as possible.  </p>
  			</div>
  		<div id="buttons">
  			<a href="signup.php"><img src="apply.png"/></a>
  			<a href="dogs.php"><img src="find.png" /></a>
  		</div>
  	</div>
  	
  	<div id="rightpane"> <!--Makes right bar --></div>
  </div>
  <div id="footer"> </div>
</body>
</html>

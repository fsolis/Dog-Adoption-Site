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
		$sql = "SELECT * FROM final_dog b
				JOIN final_doginfo d 
				ON b.dId = d.dId WHERE b.dId=:Id";
	 	$stmt = $dbConn->prepare($sql);
	 	$stmt->execute(array(":Id"=>$_POST['id']));
	 	$record = $stmt->fetchAll();
		$_SESSION['dId'] = $_POST['id'];
		if(!empty($record))
		{
			$full = "true";
			foreach($record as $row)
			{
				$dog = $row;
			}
		}
	}
	if(isset($_POST['submitForm']))
	{
		require_once 'dbConn.php';
		
		$sql = "UPDATE final_dog SET dName = :dName,breed=:breed,size=:size,gender=:gender,price=:price,avail=:avail
					WHERE dId = :dId";
		$stmt = $dbConn->prepare($sql);
		$stmt->execute( array(":dName"=>$_POST['dName'], ":breed"=>$_POST['breed'], ":size"=>$_POST['size'], ":gender"=>$_POST['gender'],
			":price"=>$_POST['price'], ":avail"=>$_POST['avail'], ":dId"=>$_SESSION['dId']));

		$sql = "UPDATE final_doginfo SET vaccines = :vaccines,arrived=:arrived,notes=:notes
					WHERE dId = :dId";
			$stmt = $dbConn->prepare($sql);
			$stmt->execute( array(":vaccines"=>$_POST['vaccines'], ":arrived"=>$_POST['arrived'], ":notes"=>$_POST['notes'], ":dId"=>$_SESSION['dId']));
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
  		<h1>Update</h1>
  		<h4>Let's See What's Changed</h4>
  		
  		<div id="updatedisplay">
  			<?php
  				$sql = "SELECT * FROM final_dog";
 				$stmt = $dbConn->prepare($sql);
 				$stmt->execute();
 				$record = $stmt->fetchAll();
				echo"<form method=\"post\" action=\"update.php\">";
				if(!empty($record))
				{
  					echo"<select name=\"id\">";
					foreach($record as $row)
					{
						echo"<option value=\"".$row['dId']."\">". $row['dName']."</option>";
					}
  					echo"</select>";
					
					echo"<input type=\"submit\" name=\"submit\" value=\"Update\" />";
				}else{
					echo "No Dog Currently Available";
				}
  				
  				echo"</form>";
				
  			?>
  			
  		</div>
	  	<div id="updateForm">
	  		<form  method="post" action="update.php">
	  			Name: <input type="text" size="25" required name="dName"  <?php if(isset($dog)){echo " Value=\"". $dog['dName']. "\"";}?>/><br/>
	  			Breed: <input type="text" size="25" required name="breed"  <?php if(isset($dog)){echo " Value=\"". $dog['breed']. "\"";}?>/><br/>
	  			Size: <input type="text" size="10" required name="size"  <?php if(isset($dog)){echo " Value=\"". $dog['size']. "\"";}?>/><br/>
	  			Gender: <input type="text" size="25" required name="gender"  <?php if(isset($dog)){echo " Value=\"". $dog['gender']. "\"";}?>/><br/>
	  			Price: <input type="text" size="25" required name="price" <?php if(isset($dog)){echo " Value=\"". $dog['price']. "\"";}?> /> <br/>
	  			Availability: <input type="text" size="25" name="avail" required  <?php if(isset($dog)){echo " Value=\"". $dog['avail']. "\"";}?>/><br/>
	  			Vaccines:<input type="text" size="25" required name="vaccines"  <?php if(isset($dog)){echo " Value=\"". $dog['vaccines']. "\"";}?>/><br/>
	  			Arrived:<input type="text" size="25" required name="arrived"  <?php if(isset($dog)){echo " Value=\"". $dog['arrived']. "\"";}?>/><br/>
	  			Notes:</br><input type="text" size="50" required name="notes"  <?php if(isset($dog)){echo " Value=\"". $dog['notes']. "\"";}?>/><br/>
	  			<input type="submit" name="submitForm" value="Update" />
	  		</form>
	  		<br/>
	  	</div><!--form --> 
		<h1><?php if(isset($update)){echo "Success";} ?></h1>

	  	
  	</div>
  	<div id="rightpane"> <!--Makes right bar --></div>
  </div>
  <div id="footer"> 
  	<h5> Address: 123 Pet Lane, Monterey CA  Phone Number: 831-777-7777</h5>
  </div>
</body>
</html>

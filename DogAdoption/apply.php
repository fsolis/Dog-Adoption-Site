<!DOCTYPE html>
<?php
	session_start();
	if(isset($_POST['submitForm']))
	{
		if(isset($_SESSION['fName']))
		{
			require_once 'dbConn.php';
		
			$sql = "UPDATE final_client SET fName = :fName,lName=:lName,email=:email,userName=:userName,password=:password,fPick=:fPick,phone=:phone
					WHERE cId = :cId";
			$stmt = $dbConn->prepare($sql);
			$stmt->execute( array(":fName"=>$_POST['fName'], ":lName"=>$_POST['lName'], ":email"=>$_POST['email'], ":userName"=>$_POST['userName'],
			":password"=>hash("sha1", $_POST['password']), ":fPick"=>$_POST['fPick'], ":phone"=>$_POST['phone'], ":cId"=>$_SESSION['cId']));
			$feedback="Successfully Updated";
			$_SESSION['fPick']= $_POST['fPick'];
		}else{
			require_once 'dbConn.php';
		
			$sql = "INSERT INTO final_client (fName,lName,email,userName,password,fPick,phone) 
					VALUES (:fName,:lName,:email,:userName,:password,:fPick,:phone)";
			$stmt = $dbConn->prepare($sql);
			$stmt->execute( array(":fName"=>$_POST['fName'], ":lName"=>$_POST['lName'], ":email"=>$_POST['email'], ":userName"=>$_POST['userName'],
			":password"=>hash("sha1", $_POST['password']), ":fPick"=>$_POST['fPick'], ":phone"=>$_POST['phone']));
			$feedback="Successfully Registered";
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

   <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
   <script>
    
    $(document).ready( function() {
       
       $("input[name=userName]").change( function(){
     
           // alert("on change - test"); //testing the change event handler
			var xmlhttp;
			if (window.XMLHttpRequest) {
     			xmlhttp = new XMLHttpRequest();
 			}
           	xmlhttp.open("GET","getUserName.php?username="+$("input[name=userName]").val(),true);
			xmlhttp.send();
            
 			xmlhttp.onreadystatechange=function() {
    		   if (xmlhttp.readyState==4 && xmlhttp.status==200) {
         		  $("#validation").html(xmlhttp.responseText); //displays program output
     		   }
  			}
            
            

       });//end username.change

    });//end document.ready
    </script>
</head>

<body>
  <div class="header">
      <h1>Solis Dog Rescue Center</h1>
  </div>
  <div class="login">
  		<div id="leftlogin">
  			<!--Error Will Be Displayed-->
  			<a href="index.php">Home</a>
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
  		<h1>Application</h1>
  		<h4>We're Glad For Your Interest</h4>
  		
  		
	  	<div id="Form">
	  		<form  method="post" action="apply.php">
	  			First Name: <input type="text" size="25" required name="fName"  <?php if(isset($_SESSION['fName'])){echo " Value=\"". $_SESSION['fName']. "\"";}?>/><br/>
	  			Last Name: <input type="text" size="25" required name="lName"  <?php if(isset($_SESSION['lName'])){echo " Value=\"". $_SESSION['lName']. "\"";}?>/><br/>
	  			Email:   <input type="text" size="25" required name="email"  <?php if(isset($_SESSION['lName'])){echo " Value=\"". $_SESSION['email']. "\"";}?>/><br/>
	  			Username: <input type="text" size="25" required name="userName"  <?php if(isset($_SESSION['fName'])){echo " Value=\"". $_SESSION['userName']. "\"";}?>/><span  id="validation"> </span><br>
	  			Password: <input type="password" size="25" required name="password" /><br/>
	  			Phone Number: <input type="text" size="25" required name="phone" <?php if(isset($_SESSION['phone'])){echo " Value=\"". $_SESSION['phone']. "\"";}?> /><br/>
	  			Chosen Dog ID: <input type="text" size="25" name="fPick" required  <?php if(isset($_SESSION['fName'])){echo " Value=\"". $_SESSION['fPick']. "\"";}else{echo " Value=\"0\"";}?>/><br/>
	  			<input type="submit" name="submitForm" value="Apply" />
	  		</form>
			<h1><?php if(isset($feedback)){echo $feedback;} ?></h1>
	  		<br/>
	  	</div><!--form --> 
	  	<div id="dogsApply">
	  		<?php
	  			include 'dbConn.php';
		
				$sql = "SELECT * FROM final_dog WHERE avail = 'Avail'";
 				$stmt = $dbConn->prepare($sql);
 				$stmt->execute();
 				$record = $stmt->fetchAll();
		
				if(!empty($record))
				{
					echo" <table> <tr> <th> Name </th> <th> ID </th> </tr>";
					foreach($record as $dog)
					{
						echo"<tr> <td> ". $dog['dName'] . "</td> <td> ". $dog['dId'] . "</td> </tr> ";
					}
					echo"</table>";
					
				}else{
					echo "No Dog Currently Available";
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

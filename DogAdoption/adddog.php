<!DOCTYPE html>
<?php
	session_start();
	if(isset($_SESSION['permission']))
	{
		if($_SESSION['permission']=="client")
		{
			header("Location: index.php");
		}
	}else{
		header("Location: index.php");
	}
	
	function createThumbnail(){
		$fileName = time();
   		 $sourcefile = imagecreatefromstring(file_get_contents($_FILES["fileName"]["tmp_name"]));
    	$newx = 150; $newy = 150;  //new size
    	
    	if (imagesx($sourcefile) > imagesy($sourcefile)) {   // landscape orientation
            $newy = round($newx/imagesx($sourcefile) * imagesy($sourcefile));
      	}
     	else {   // portrait orientation 
            $newx = round($newy/imagesy($sourcefile) * imagesx($sourcefile));
      	}
    
    	$thumb = imagecreatetruecolor($newx,$newy);
    	imagecopyresampled($thumb, $sourcefile, 0,0, 0,0, $newx, $newy,     
     	imagesx($sourcefile), imagesy($sourcefile)); 
		$path = "uploadFiles/fsolis";
		if(!file_exists($path))
		{
			mkdir($path);
		}
    	imagejpeg($thumb,$path . "/" .$fileName.".jpg"); //creates jpg image file called "thumb.jpg"
    	$_SESSION['dogPic']= $fileName.".jpg";
		
		//submit form here after image has been made
		require_once 'dbConn.php';
		
			$sql = "INSERT INTO final_dog (dName,breed,size,gender,picName,price) 
					VALUES (:dName,:breed,:size,:gender,:picName,:price)";
			$stmt = $dbConn->prepare($sql);
			$stmt->execute( array (":dName"=>$_POST['dName'], ":breed"=>$_POST['breed'], ":size"=>$_POST['size'],":gender"=>$_POST['gender'],":picName"=>$_SESSION['dogPic'],":price"=>$_POST['price']));
			 //now insert into final_doginfo
			$sql = "SELECT * FROM final_dog WHERE picName = :picName";
			$stmt = $dbConn->prepare($sql);
			$stmt->execute(array(":picName"=>$_SESSION['dogPic']));
			$record = $stmt->fetch();
			foreach ($record as $dog) {
				$dogID=$record['dId'];
			}
			$sql = "INSERT INTO final_doginfo (dId,vaccines,arrived,notes) 
					VALUES (:dId,:vaccines,:arrived,:notes)";
			$stmt = $dbConn->prepare($sql);
			$stmt->execute(array(":dId"=>$dogID, ":vaccines"=>$_POST['vaccines'], ":arrived"=>$_POST['arrived'], ":notes"=>$_POST['notes']));
			$_SESSION['feedback']= "Success";
			

	}


	function filterUploadedFile() {
 		 $allowedTypes = array("text/plain","image/png", "image/jpeg", "image/gif");
  		$allowedExtensions = array("txt", "png", "jpg", "gif", "jpeg");
  		$allowedSize = 1000 * 1024;
  		$filterError = "";
 		if (!in_array($_FILES["fileName"]["type"],  $allowedTypes ) ) {
       		 $_SESSION['error'] = "Invalid type. <br>";
 	    }

   		$fileName = $_FILES["fileName"]["name"];
   		if (!in_array(substr($fileName,strrpos($fileName,".")+1), $allowedExtensions) ) {
       		$_SESSION['error'] = "Invalid extension. <br>"; 
   		 }
   
   		if ($_FILES["fileName"]["size"]  > $allowedSize  ) {
       		 $_SESSION['error'] .= "File size too big. <br>";
    	}
    	return $filterError;

	}

	if (isset($_POST['submitForm'])) {
		$filterError = filterUploadedFile();
    	if (empty($filterError)) {
	    	if ($_FILES["fileName"]["error"] > 0) {
	      		$_SESSION['error'] = "Error: " . $_FILES["fileName"]["error"] . "<br>";
	    	}
	    	else {
	      		//echo "Upload: " . $_FILES["fileName"]["name"] . "<br>";
	      		//echo "Type: " . $_FILES["fileName"]["type"] . "<br>";
	      		//echo "Size: " . ($_FILES["fileName"]["size"] / 1024) . " KB<br>";
	      		//echo "Stored in: " . $_FILES["fileName"]["tmp_name"];
				//echo "<br>";
				createThumbnail();     
	    	}
		} else {
		echo $filterError;
		}
	  
	} //endIf form submission
	
	
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
  		<h1>Add Dog</h1>
  		<h4>Yay! Another Member to the Family</h4>
  		
  		
	  	<div id="Form">
	  		<form  method="post" enctype="multipart/form-data" action="adddog.php">
	  			Name: <input type="text" size="25" required name="dName"  /><br/>
	  			Breed: <input type="text" size="25" required name="breed"  /><br/>
	  			Size: <input type="text" size="25" required name="size"  /><br/>
				Gender: <input type="text" size="25" required name="gender"./><br/>
	  			Price: <input type="text" size="25" required name="price" /><br/>
	  			Vaccines: <input type="text" size="25" required name="vaccines" /><br/>
	  			Arrived: <input type="text" size="25" required name="arrived" /><br/>
	  			Notes:<br> <input type="text" size="50" name="notes" required /><br/>
	  			Picture: <input type="file" name="fileName" /> <br />
	  			<input type="submit" name="submitForm" value="Add Dog" />
	  		</form>
	  		<br/>
	  	</div><!--form --> 
	  	<h1><?php if(isset($_SESSION['feedback'])){echo $_SESSION['feedback'];} ?></h1>
  	</div>
  	<div id="rightpane"> <!--Makes right bar --></div>
  </div>
  <div id="footer"> 
  	<h5> Address: 123 Pet Lane, Monterey CA  Phone Number: 831-777-7777</h5>
  </div>
</body>
</html>

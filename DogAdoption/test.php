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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
   
    <title>Dog Rescue Center</title> 

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
      
    <!-- Custom style sheet -->
    <link href="css/styles.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
        <div class="container-fluid"> 
            
            <div id="headercontent">
                <div id="header" >
                        <h1 id="title" >Dog Rescue Center</h1>
                </div> <!-- header -->
                
                <div id="login">
                    <form class="form-inline">
                      <div class="form-group">
                        <label class="sr-only" for="exampleInputEmail2">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Email">
                      </div>
                      <div class="form-group">
                        <label class="sr-only" for="exampleInputPassword2">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password">
                      </div>
                      <div class="checkbox">
                        <label id="whitetext">
                          <input  type="checkbox"> Remember me
                        </label>
                      </div>
                      <button type="submit" class="btn btn-default">Log in</button>
                    </form>
                </div> <!-- login -->
            </div> <!-- headercontent -->
            
            <div id="heading">
                        <h1> Welcome! </h1>
            </div> <!-- heading -->
            <div class="row">
                <div class="col-xs-1">
                    <!-- This is to help center the content in next col -->
                </div>
                <div class ="col-xs-10">
                   
                    <div class="row">
                        <div class="col-xs-6">
                            <div id="puppyimg"><img src="index.jpg" alt="puppy" height="200" width="300"></div>
                            <br>
                            <div>
  			                   <a href="apply.php"><img src="apply.png"/></a>
  			                   <a href="find.php"><img src="find.png" /></a>
  		                    </div>
                        </div>
                        <div class="col-xs-6">
                            <div id="aboutstatement">
                                <p>  Hello, we are glad you have chosen to visit our website. Here at the Dog Rescue Center, we have dedicated our
                                 lives to making sure a pet's transition from our arms to yours is as hassle free as possible. We focus on making sure that you and the friend you choose are compatible with each other. 
                                 Feel free to look around at all of our lovely animals,
  			                     if you see one you like just apply and we'll start the process of connecting you and your bundle of joy as soon as possible.  
                            </p>
                            </div>
                        </div>
                    </div>
                </div> <!-- center column -->
                <div class="col-xs-1">
                    <!-- This is to help center the content in pervious col -->
                </div> <!-- col -1 -->
            </div> <!-- row -->
            
            
            <div class="row">
                <div class="col-xs-1">
                    <!-- This is to help center the content in next col -->
                </div>
            </div>
            
            <div class="col-xs-1">
                    <!-- This is to help center the content in pervious col -->
            </div>
            
        </div> <!-- container-fluid -->
      

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
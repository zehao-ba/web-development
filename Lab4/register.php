<?php
	ob_start();
	session_start();
	if( isset($_SESSION['UserContactInfo'])!="" ){
		header("Location: home.php");
	}
	include_once 'dbconnect.php';

	$error = false;

	if ( isset($_POST['btn-signup']) ) {

		
		
		// clean user inputs to prevent sql injections
		$name = trim($_POST['Name']);
		$name = strip_tags($name);
		$name = htmlspecialchars($name);
		

		$email = trim($_POST['Email']);
		$email = strip_tags($email);
		$email = htmlspecialchars($email);
		
		$password = trim($_POST['Password']);
		$password = strip_tags($password);
		$password = htmlspecialchars($password);


		// basic name validation
		if (empty($name)) {
			$error = true;
			$nameError = "Please enter your full name.";
		} else if (strlen($name) < 3) {
			$error = true;
			$nameError = "Name must have at least 3 characters.";
		} else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
			$error = true;
			$nameError = "Name must contain alphabets.";
		}
		
		//basic email validation
		if ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
			$error = true;
			$emailError = "Please enter valid email address.";
		} else {
			// check email exist or not
			$query = 'SELECT Email FROM UserContactInfo WHERE Email = ?';
			$result = $conn->prepare($query);
			$result -> execute(array($_POST['Email']));

	//		$query = "SELECT Email FROM UserContactInfo WHERE Email='$email'";
	//		$result = mysqli_query($conn, $query);
			$count = mysqli_num_rows($result);
			if($count!=0){
				$error = true;
				$emailError = "Provided Email is already in use.";
			}
		}
		// password validation
		if (empty($password)){
			$error = true;
			$passError = "Please enter password.";
		} else if(strlen($password) < 6) {
			$error = true;
			$passError = "Password must have atleast 6 characters.";
		}
		
		// password encrypt using SHA256();
		$passwordHash = hash('sha256', $password);
		
		// if there's no error, continue to signup
		if( !$error ) {
			
			$query = "INSERT INTO UserContactInfo(UserName, Email, PassWord) VALUES ('$name', '$email','$passwordHash')";
			$res = mysqli_query($conn, $query);
				
			if ($res) {
				$errTyp = "success";
				$errMSG = "Successfully registered, you may login now";
				unset($name);
				unset($email);
				unset($password);
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";	
			}	
				
		}
		
		
	}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lab4 - Login and Registration System</title>
<!-- <link rel="stylesheet" href="style.css" type="text/css" /> -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="ZeHao Ba" content="This website is designed for prototype of project of CSCI 3172" >
<link href='http://fonts.googleapis.com/css?family=Josefin+Slab%7CCarrois+Gothic' rel='stylesheet' type='text/css'>
<!-- Bootstrap -->
<!-- <link href="css/bootstrap.min.css" rel="stylesheet" media="screen"> -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="style.css" rel="stylesheet" media="screen">
</head>
<body>

<div class="container">
	<div class="header">
        
        <div class="logo"><img src="img/logo4.png" alt="logo"/></div>
        
       		    <ul class="nav nav-pills">
                    <li class="active">
                    <a href=" ">Sign in/Register</a></li>
                  <li><a href=" ">Laptop</a></li>
                <li><a href="">Cellphone</a></li>
                <li><a href="">Television</a></li>
                <li><a href="">About Us</a></li>
                <li><a href=" ">Contact</a></li>
                </ul>        
    </div>

	<div id="login-form">
    <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    
    	<div class="col-md-12">
        
        	<div class="form-group">
            	<h2 class="">Sign Up.</h2>
            </div>
        
        	<div class="form-group">
            	<hr />
            </div>
            
            <?php
			if ( isset($errMSG) ) {
				
				?>
				<div class="form-group">
            	<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
				<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
            	</div>
                <?php
			}
			?>
            
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            	<input type="text" name="Name" class="form-control" placeholder="Enter Name" maxlength="50" value="<?php echo $name ?>" />
                </div>
                <span class="text-danger"><?php echo $nameError; ?></span>
            </div>
            
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
            	<input type="email" name="Email" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php echo $email ?>" />
                </div>
                <span class="text-danger"><?php echo $emailError; ?></span>
            </div>
            
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
            	<input type="password" name="Password" class="form-control" placeholder="Enter Password" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
            </div>
            
            <div class="form-group">
            	<hr />
            </div>
            
            <div class="form-group">
            	<button type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button>
            </div>
            
            <div class="form-group">
            	<hr />
            </div>
            
            <div class="form-group">
            	<a href="index.php">Sign in Here...</a>
            </div>
        
        </div>
   
    </form>
    </div>	
</div>

<div class="footer">

	
    <div class="container top30">
    	<div class="row-fluid">
        	<div class="span3">
            	<div class="f-about">
                	<h2>About Shopify</h2>
                    <p>You have never seen so many options! Change colors of dozens of elements, You have never seen so many options! Change colors of dozens of elements, apply textures, upload background images.</p>
                    <a href="#">Read more..</a>
                </div>
            </div>
        </div>
    </div>    
</div>

</body>
</html>
<?php ob_end_flush(); ?>
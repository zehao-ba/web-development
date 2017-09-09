<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	
	// it will never let you open index(login) page if session is set
	if ( isset($_SESSION['usercontactinfo'])!="" ) {
		header("Location: home.php");
		exit;
	}
	
	$error = false;
	
	if( isset($_POST['btn-login']) ) {	

		

		// prevent sql injections/ clear user invalid inputs
		$Email = trim($_POST['Email']);
		$Email = strip_tags($Email);
		$Email = htmlspecialchars($Email);
		
		$Password = trim($_POST['Password']);
		$Password = strip_tags($Password);
		$Password = htmlspecialchars($Password);

		

		// prevent sql injections / clear user invalid inputs
		
		if(empty($Email)){
			$error = true;
			$emailError = "Please enter your email address.";
		} else if ( !filter_var($Email,FILTER_VALIDATE_EMAIL) ) {
			$error = true;
			$emailError = "Please enter valid email address.";
		}
		
		if(empty($Password)){
			$error = true;
			$passError = "Please enter your password.";
		}
		
		// if there's no error, continue to login
		if (!$error) {
			
			$passwordhash = hash('sha256', $Password); // password hashing using SHA256

/*			$query = 'SELECT userName, PassWord FROM usercontactinfo WHERE Email = ?';
			$res = $conn->prepare($query);
			$res -> execute(array($_POST['Email']));*/
		
			$res=mysqli_query($conn, "SELECT UserName, PassWord FROM usercontactinfo WHERE UserName='${_SESSION["name"]}'");
			$row=mysqli_fetch_array($res);
			$count = mysqli_num_rows($res); // if uname/pass correct it returns must be 1 row
			
			if( $count == 1 && $row['PassWord']==$passwordhash ) {
				$errTyp = "success";
				$errMSG = "Successfully change it";
				$res=mysqli_query($conn, "UPDATE usercontactinfo SET Email='$Email' WHERE UserName ='${_SESSION["name"]}'");
				$_SESSION["email"]=$Email;  
				/*$_SESSION['usercontactinfo'] = $row['UserName'];
				header("Location: home.php");*/
			} 
			else {
				$errTyp = "danger";
				$errMSG = "Incorrect Credentials, Try again...";
			}
				
		}
		
	}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lab5 - Login and Registration </title>
<!-- <link rel="stylesheet" href="style.css" type="text/css" /> -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="ZeHao Ba" content="This website is designed for prototype of project of CSCI 3172" >
<link href='http://fonts.googleapis.com/css?family=Josefin+Slab%7CCarrois+Gothic' rel='stylesheet' type='text/css'>
<!-- Bootstrap -->
<!-- <link href="css/bootstrap.min.css" rel="stylesheet" media="screen"> -->
<link rel="stylesheet" href="public_html/assets/css/bootstrap.min.css" type="text/css"  />
<link href="public_html/assets/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="public_html/style.css" rel="stylesheet" media="screen">


</head>
<body>


<div class="container">
	<div class="header">
        
        <div class="logo"><img src="public_html/img/logo4.png" alt="logo"/></div>
        
       		    <ul class="nav nav-pills">
                <li><a href="index.php">Sign in</a></li>
                <li><a href="register.php">Register</a></li>
<!--                 <li class="active"><a href="edit.php">Edit</a></li> -->
                <li><a href="profile.php">My Profile</a></li>
                <li><a href="">About Us</a></li>
                <li><a href=" ">Contact</a></li>
                </ul>        
    </div>

        
	<div id="login-form">
	<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" autocomplete="off">
	<div class="col-md-12">

	<div class="form-group">
		<h2 class="">Hi <?php echo "${_SESSION["name"]}"; ?>, please change your email address here.</h2>
	</div>

	<div class="form-group">
		<hr />
	</div>

	<?php
	if ( isset($errMSG) ) {
		
		?>
		<div class="form-group">
		<div class="alert alert-success">
		<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
	    </div>
		</div>
	    <?php
	}
	?>

	<div class="form-group">
		<div class="input-group">
	    <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
		<input type="email" name="Email" class="form-control" placeholder="Change your Email here" value="<?php echo $email; ?>" maxlength="40" />
	    </div>
	    <span class="text-danger"><?php echo $emailError; ?></span>
	</div>

	<div class="form-group">
		<div class="input-group">
	    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
		<input type="password" name="Password" class="form-control" placeholder="Your Password" maxlength="15" />
	    </div>
	    <span class="text-danger"><?php echo $passError; ?></span>
	</div>

	<div class="form-group">
		<hr />
	</div>

	<div class="form-group">
		<button type="submit" class="btn btn-block btn-primary" name="btn-login">Submit</button>
	</div>

	<div class="form-group">
		<hr />
	</div>

	<div class="form-group">
	    <a href="exit.php">Log out Here...</a>
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
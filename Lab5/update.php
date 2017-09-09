<?php
    ob_start();
    session_start();
    include_once 'dbconnect.php';

    if( isset($_SESSION['usercontactinfo'])!="" ){
        header("Location: home.php");
    }

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


        // prevent sql injections / clear user invalid inputs
		
		if(empty($email)){
			$error = true;
			$emailError = "Please enter your email address.";
		} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$error = true;
			$emailError = "Please enter valid email address.";
		}
		
		if(empty($password)){
			$error = true;
			$passError = "Please enter your password.";
		}else if(strlen($password) < 6) {
            $error = true;
            $passError = "Password must have atleast 6 characters.";
        }
        
        // password encrypt using SHA256();
 /*       $passwordHash = hash('sha256', $password);*/
        
        // if there's no error, continue to signup
        if( !$error ) {
            
            $res=mysqli_query($conn, "SELECT Email, PassWord FROM usercontactinfo WHERE UserName='${_SESSION["name"]}'");
            $row=mysqli_fetch_array($res);


                
            if ($res) {
                $errTyp = "success";
                $errMSG = "Successfully update";
                $passwordhash = hash('sha256', $password);
                $res=mysqli_query($conn, "UPDATE usercontactinfo SET Email='$email', Password='$passwordhash' WHERE UserName ='${_SESSION["name"]}'");               				
                $_SESSION["name"]=$name;
                $_SESSION["email"]=$email;  
                $_SESSION["password"]=$password; 
               
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
<title>Lab5 - Login and Registration System</title>
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
 <!--                <li><a href="edit.php">Edit</a></li> -->
                <li><a href="profile.php">My Profile</a></li>
                <li><a href="">About Us</a></li>
                <li><a href=" ">Contact</a></li>
                </ul>        
    </div>

    <div id="login-form">
    <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    
        <div class="col-md-12">
        
            <div class="form-group">
                <h2 class="">You can change password or email here</h2>
            </div>

            <div class="form-group">
                <a class="">***Please attention the user name cannot change.</a>
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
                <input readonly ="value" type="text" name="Name" class="form-control" maxlength="50" value="<?php echo "${_SESSION["name"]}" ?>" />
                </div>
                <span class="text-danger"><?php echo $nameError; ?></span>
            </div>
            
            <div class="form-group">
                <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                <input type="email" name="Email" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php echo "${_SESSION["email"]}" ?>" /> 
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
                <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Update</button>
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
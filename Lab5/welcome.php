<!DOCTYPE html>  
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
                <li class="active"><a href=" ">Register</a></li>
                <!-- <li><a href="edit.php">Edit</a></li> -->
                <li><a href="profile.php">My Profile</a></li>
                <li><a href="">About Us</a></li>
                <li><a href=" ">Contact</a></li>
                </ul>        
    </div>

<div class="container">
	<div id="login-form">
		<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" autocomplete="off">
		<div class="col-md-12">
			<div class="form-group">
				<?php  
				session_start();  
				if(isset($_SESSION["code"])){  ?>
				<h1>welcome</h1> 
				<?php echo "${_SESSION["name"]}";  ?>  
				<br>
				<h1>your email address is</h1> <?php echo "${_SESSION["email"]}";  ?>
				<br>

				<div class="form-group">
					<hr />
				</div>

				<div class="form-group">
					<a href="edit.php">Edit your file here...</a>
				</div>

				<div class = "form-group">
					<a href="exit.php">Exit</a>  
				</div>


				
				<?php  
				}
				else{  
				?>  
				<script>  
				alert("Something wrong!");  
				window.location.href="exit.php";  
				</script>  
				<?php  
				}  
				?>  
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



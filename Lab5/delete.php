<?php
	ob_start();
	session_start();
	include_once 'dbconnect.php';

    if( isset($_SESSION['usercontacinfo'])!="" ){
    header("Location: home.php");
    }
	
	$res=mysqli_query($conn, "DELETE FROM usercontactinfo WHERE UserName='${_SESSION["name"]}'");
 		unset($_SESSION['usercontactinfo']);
 		session_unset();
 		session_destroy();
 		header("Location: index.php");

 		//exit;
?>


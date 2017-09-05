<?php

	// this will avoid mysql_connect() deprecation error.
	error_reporting( ~E_DEPRECATED & ~E_NOTICE );
	// but I strongly suggest you to use PDO or MySQLi.
	
//	define('DBHOST', 'localhost');
//	define('DBUSER', 'root');
//	define('DBPASS', '1646');
//	define('DBNAME', 'zba');
	
	$conn = mysqli_connect("db.cs.dal.ca", "zba", "B00732676", "zba");
//	$conn = mysqli_connect("localhost", "root", "1646", "zba");
//	$dbcon = mysql_select_db(DBNAME);
	
	if ( !$conn ) {
		die("Connection failed : " . mysqli_connect_error());
		exit;
	}

	/*if ( !$dbcon ) {
		die("Database Connection failed : " . mysql_error());
	}*/
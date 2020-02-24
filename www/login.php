<?php
	require "..\config\credentials.php";
	if(isset($_POST) && isset($_POST['admin'])) {
		if(password_verify($_POST['admin'], $_GLOBALS['admin_hash'])) {
			$cookie = substr($_GLOBALS['admin_hash'], -8);
			setcookie('admin', $cookie, 0, '/');
			header("location: ./");
		} else {
			setcookie('admin', 'incorrect', 1); //unset cookie
			die("Incorrect password.");
		}
	}
?>

<html>
<head>
<title>pDance: Login</title>
<link rel="stylesheet" type="text/css" href="/pdance/www/style.css" media="screen"/>
</head>
<body>
<h1>pDance: Login</h1>
<form action='login.php' method='post'>
	<p style='text-align: center;'>
		Admin password: 
		<input type='text' name='admin' />
	</p>
</form>
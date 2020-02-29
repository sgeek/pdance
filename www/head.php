<?php
// Exit if not authorised (auth condition: cookie 'admin' set to the last 8 characters of the admin password hash)
if(!isset($_COOKIE['admin']) || $_COOKIE['admin'] !== substr($GLOBALS['admin_hash'], -8)) {
	http_response_code(404);
	die("Page not found.");
}

$title = $title ?? "pDance";
echo "
<html>
<head>
<title>pDance: {$title}</title>
<link rel='stylesheet' type='text/css' href='/pdance/www/style.css' media='screen'/>
<meta http-equiv='Cache-Control' content='no-store' />
</head>
<body>
<a style='display:block; text-align:left; margin-bottom:-1em;' href='/pdance/www'>Admin home</a>
<h1><a href='.'>{$title}</a></h1>
";
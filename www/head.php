<?php
$title = $title ?? "pDance";
echo <<<EOT
<html>
<head>
<title>pDance: {$title}</title>
<link rel="stylesheet" type="text/css" href="/pdance/www/style.css" media="screen"/>
</head>
<body>
<h1>{$title}</h1>


EOT;
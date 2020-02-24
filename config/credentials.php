<?php

// Path
$path = "C:\Bitnami\wampstack-7.3.6-1\apache2\htdocs\pdance";

// Database
$host = '127.0.0.1';
$db   = 'dance';
$user = 'root';
$pass = trim(file_get_contents($path . '\config\db.txt'));
$charset = 'utf8mb4';


// Password hash for pDance admin access
$_GLOBALS['admin_hash'] = trim(file_get_contents($path . '\config\admin.txt'));
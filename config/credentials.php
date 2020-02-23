<?php

// Database
$host = '127.0.0.1';
$db   = 'dance';
$user = 'root';
$pass = trim(file_get_contents('config\db.txt'));
$charset = 'utf8mb4';

// 


// Password hash for pDance admin access
$_GLOBALS['admin_hash'] = trim(file_get_contents('config\admin.txt'));
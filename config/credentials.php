<?php

// Database
$host = '127.0.0.1';
$db   = 'dance';
$user = 'root';
$pass = 'Welcome1';
$charset = 'utf8mb4';

// Password hash for pDance admin access
$_GLOBALS['admin_hash'] = file_get_contents('admin.txt');
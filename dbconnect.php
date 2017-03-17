<?php
	$host = 'us-cdbr-azure-southcentral-f.cloudapp.net';
	$db = 'ucl_database';
	$user = 'b5244e346bc0c1';
	$pass = 'c26f1ca0';
	$charset = 'utf8';
	
	$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
	$options = [PDO::ATTR_ERRMODE  => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES => false
	];
	$pdo = new PDO($dsn, $user, $pass, $options);
?>

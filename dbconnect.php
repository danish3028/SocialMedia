<?php
	$host = 'br-cdbr-azure-south-b.cloudapp.net';
	$db = 'ucl_database';
	$user = 'b94a5738ca9e3b';
	$pass = '02ba1498';
	$charset = 'utf8';
	
	$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
	$options = [PDO::ATTR_ERRMODE  => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES => false
	];
	$pdo = new PDO($dsn, $user, $pass, $options);
?>

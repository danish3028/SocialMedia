<?php

$connectstr_dbhost = '';
$connectstr_dbname = 'ucl_database';
$connectstr_dbusername = '';
$connectstr_dbpassword = '';
 
foreach ($_SERVER as $key => $value) {
    if (strpos($key, "MYSQLCONNSTR_") !== 0) {
        continue;
    }
    
    $connectstr_dbhost = preg_replace("/^.*Data Source=(.+?);.*$/", "\\1", $value);
    $connectstr_dbusername = preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $value);
    $connectstr_dbpassword = preg_replace("/^.*Password=(.+?)$/", "\\1", $value);
}
 
define('DB_NAME', $connectstr_dbname);
define('DB_USER', $connectstr_dbusername);
define('DB_PASSWORD', $connectstr_dbpassword);
define('DB_HOST', $connectstr_dbhost);

$dsn = "mysql:host=DB_HOST;dbname=DB_NAME;"
	$options = [PDO::ATTR_ERRMODE  => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES => false
	];
	$pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $options);

?>

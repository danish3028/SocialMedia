<?php

$host = "localhost";

$username = "root";

$password = "";

$db = "ucl_database";





$conn = mysqli_connect($host, $db, $username, $password);



if (!$conn) {

    die("Connection failed: " . mysqli_connect_error());

}

echo "Connected successfully";

?>


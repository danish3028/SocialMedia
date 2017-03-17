<?php

$host = "br-cdbr-azure-south-b.cloudapp.net";

$username = "b94a5738ca9e3b";

$password = "02ba1498";

$db = "ucl_database";





$conn = mysqli_connect($host, $db, $username, $password);



if (!$conn) {

    die("Connection failed: " . mysqli_connect_error());

}

echo "Connected successfully";

?>


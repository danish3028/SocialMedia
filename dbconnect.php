<?php

$host = "br-cdbr-azure-south-b.cloudapp.net";

$username = "b94a5738ca9e3b";

$password = "02ba1498";





$conn = mysqli_connect($host, $username, $password);



if (!$conn) {

    die("Connection failed: " . mysqli_connect_error());

}

echo "Connected successfully";

?>


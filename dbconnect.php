
<?php
$host = "br-cdbr-azure-south-b.cloudapp.net";
$username = "b94a5738ca9e3b";
$password = "password";
$db = "02ba1498";

// Create connection
$conn = mysqli_connect($host, $username, $password, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
?>


<?php
  $servername = "localhost";
  $username = "azure";
  $password = " ";
  $dbname = "ucl_database";
 
  $conn = new mysqli($servername, $username, $password, $dbname);
  
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
?>

<?php
include_once "dbconnect.php";
include_once "functions.php";
include_once "verifySession.php";

$index = $adminMode ? "indexAdmin.php" : "index.php";
if (!$adminMode) {
     if (isset($_COOKIE[session_name()])) {
       setcookie(session_name(), '', time() - 3600);
     }
    setcookie('id', '', time() - 3600);
    setcookie('key', '', time() - 3600);
  
} else {
// make the database entry invalid
   $stmt = $pdo->prepare('UPDATE admin 
								SET valid_session = :validSession
								WHERE id = :adminID');
$stmt->execute([':validSession'=>0, ':adminID'=>$_SESSION['adminID']]);
}
 $_SESSION = array();
 session_destroy();
redirect("index.php");
?>
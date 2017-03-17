<?php
include_once "dbconnect.php";
include_once "functions.php";
include_once "verifySession.php";

if(!$adminMode) {
    redirect("blog.php");
}
echo '<h3>User accounts</h3>';
$users = getAllUsers();
foreach($users as $row) {
    
    // delete form
    
    // visit blog form
    $blogURL = "blog.php?blogid=";
    
    //just print out to visit blog
    echo '<a href="'.$blogURL.$row['id'].'">'.$row['first_name'].' '.$row['last_name'].'</a>';
    echo '<form action="deleteUser.php" method="POST">'; 
    echo '<input type="hidden" name="userID" value="'.$row['id'].'">';
    echo '<input type="submit" value="Delete user">';
    echo '</form>';
    
    echo '<br>';  
}
echo '<br>';
echo '<br>';
echo '<a href="logout.php"> Logout </a>';







    
    
function getAllUsers() {
    global $pdo;
    try {
        $stm = $pdo->prepare('SELECT * FROM user');
        $stm->execute();
    } catch(PDOException $e) {   
    }
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
?>
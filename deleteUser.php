<?php
    include_once 'functions.php';
	include_once 'dbconnect.php';
	include_once 'verifySession.php';
    
	
	function deleteUser($pdo, $userID){
        try {
        // delete photos from hard disk drive first
        $stmt = $pdo->prepare("SELECT path FROM photo JOIN photo_album ON photo.album_id = photo_album.id WHERE photo_album.user_owner = :userID");
		$stmt->execute([':userID'=>$userID]); 
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row) {
            $path = $row['path'];
            unlink($path);  
        }
        // delete user and all connected database entries (cascade)    
		$stmt = $pdo->prepare("DELETE FROM user
									WHERE id =:userID");
		$stmt->execute([':userID'=>$userID]);
        } catch (PDOExceptin $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
        }
   
	}
	$vars = ['userID'];
	if(!verifyNull($vars)){
		exit("No user ID");
	}
    $adminMode = isset($_SESSION['adminMode']) && (strcmp($_SESSION['adminMode'],"TRUE") === 0);
    if(!$adminMode) {
        echo "not allowed to delete a user";
            redirect("blog.php");
    }
	deleteUser($pdo,$_POST['userID']);
    redirect("adminOverview.php");
?>
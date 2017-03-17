<?php
	function deleteCollection($pdo, $collectionid, $user_id){
        global $adminMode;
        if(!$adminMode) {
		$stmt = $pdo->prepare("SELECT user_owner FROM photo_album WHERE id = :id");
		$stmt->execute(['id'=>$collectionid]);
		if($stmt->rowCount() == 0){
			#NOT YOUR ALBUM. CHEEKY CHEEKY.
			redirect("../photos.php");
		}
		$row = $stmt->fetch();
        }
		if($adminMode || $row['user_owner'] == $user_id){
            
			try{
                // get all photos first
                $stmt = $pdo->prepare("SELECT * FROM photo WHERE album_id=:albumID");
				$stmt->execute([':albumID'=>$collectionid]);	
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($result as $row) {
                // delete this photo from our hard disk drive
                $path = $row['path'];
                unlink('../'.$path);

                }
        
                
                // delete all photos from our database
                $stmt = $pdo->prepare("DELETE FROM photo WHERE album_id=:albumID");
				$stmt->execute([':albumID'=>$collectionid]);
                // delete album
                $stmt = $pdo->prepare("DELETE FROM photo_album WHERE id=:id");
				$stmt->execute(['id'=>$collectionid]);    
			}
			catch(PDOException $e){
				exit($e->getCode());
			}
		}
	}
	
	include '../dbconnect.php';
	include '../functions.php';
	include '../verifySession.php';
	$vars = ['collectionid'];
	if(!verifyNull($vars)){
		exit("NULL");
	}
    // you only need the owner to check permissions
    $owner = $adminMode ? NULL: $_SESSION['id'];
	deleteCollection($pdo, $_POST['collectionid'], $owner);
    $url = $adminMode ? '../photos.php?blogid='.$_POST['blogid']: '../photos.php';
	redirect($url);
?>

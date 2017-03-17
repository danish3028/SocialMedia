<?php
	function deletePhoto($pdo, $photoid, $user_id){
        global $adminMode;
        if (!$adminMode) {
		$stmt = $pdo->prepare("SELECT pa.user_owner 
								FROM photo AS p
								RIGHT JOIN photo_album AS pa
								ON p.album_id = pa.id
								WHERE p.id = :id");
		$stmt->execute(['id'=>$photoid]);
		if($stmt->rowCount() == 0){
			#NOT YOUR ALBUM. CHEEKY CHEEKY.
			redirect("../photos.php");
		}
		$row = $stmt->fetch();
        }
		if($adminMode || $row['user_owner'] == $user_id){
			try{
                $stmt = $pdo->prepare("SELECT path FROM photo WHERE id=:photoID");
				$stmt->execute([':photoID'=>$photoid]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                // delete photo from our hard disk drive
                $path = $result['path'];
                unlink('../'.$path);
                // delete photo
				$stmt = $pdo->prepare("DELETE FROM photo WHERE id=:photoID");
				$stmt->execute([':photoID'=>$photoid]);
			}
			catch(PDOException $e){
				exit($e->getCode());
			}
		}
	}
	
	include '../dbconnect.php';
	include '../functions.php';
	include '../verifySession.php';
	$vars = ['photoid', 'collectionid'];
	if(!verifyNull($vars)){
		exit("NULL");
	}
    
    $owner = $adminMode ? NULL: $_SESSION['id'];
	deletePhoto($pdo, $_POST['photoid'], $owner);
    $baseURL = "../displayPhotos.php?collectionid=".$_POST['collectionid'];
    $finishedURL = $adminMode ? $baseURL.'&blogid='.$_POST['blogid']: $baseURL;
	redirect($finishedURL);
?>
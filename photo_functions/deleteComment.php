<?php
	function deleteComment($pdo, $photoid, $commentid, $user_id){
        global $adminMode;

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
		if($adminMode || $row['user_owner'] == $user_id){
			try{
				$stmt = $pdo->prepare("DELETE FROM photo_comment WHERE id=:id");
				$stmt->execute(['id'=>$commentid]);
			}
			catch(PDOException $e){
				exit($e->getCode());
			}
		}
	}
	
	include '../dbconnect.php';
	include '../functions.php';
	include '../verifySession.php';
	$vars = ['photoid', 'collectionid', 'commentid'];
	if(!verifyNull($vars)){
		exit("NULL");
	}

    $owner = $adminMode ? NULL: $_SESSION['id'];
	deleteComment($pdo, $_POST['photoid'], $_POST['commentid'], $owner);
    $baseURL = "../displayPhotos.php?collectionid=".$_POST['collectionid'];
    $finishedURL = $adminMode ? $baseURL.'&blogid='.$_POST['blogid']: $baseURL;
	redirect($finishedURL);
?>

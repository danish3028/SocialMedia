<?php
	function deleteAnnotation($pdo, $annotationID){
		$stmt = $pdo->prepare("DELETE FROM annotation WHERE id=:annotationID");
		$stmt->execute([':annotationID'=>$annotationID]);
	}
	
	include '../dbconnect.php';
	include '../functions.php';
	include '../verifySession.php';
	$vars = ['annotationID', 'collectionid'];
	if(!verifyNull($vars) || !$adminMode){
		exit("NULL");
	}
	deleteAnnotation($pdo,$_POST['annotationID']);
	redirect("../displayPhotos.php?collectionid=".$_POST['collectionid'].'&blogid='.$_POST['blogid']);
?>

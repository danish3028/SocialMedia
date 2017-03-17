<?php
	function editPost($pdo, $post_id, $user_id, $content){
		//echo $post_id;
        global $adminMode;
        if(!$adminMode) {
		$stmt = $pdo->prepare("SELECT blog_owner_id FROM blog_post WHERE id = :post_id");
		$stmt->execute(['post_id'=>$post_id]);
		if($stmt->rowCount() == 0){
			return;
		}
		$row = $stmt->fetch();
        }
		if($adminMode || $row['blog_owner_id'] == $user_id){
			$stmt = $pdo->prepare("UPDATE blog_post 
									SET content=:content
									WHERE id = :id");
			$stmt->execute(['content'=>$content, 'id'=>$post_id]);
		}
	}
	
	include '../dbconnect.php';
	include '../functions.php';
	include '../verifySession.php';
	$vars = ['update_id'];
	if(!verifyNull($vars)){
		exit("NULL");
	}
    $adminMode = isset($_SESSION["adminMode"]) && (strcmp($_SESSION["adminMode"],"TRUE") === 0);
    $owner = $adminMode ? NULL: $_SESSION['id'];
	editPost($pdo, $_POST['update_id'], $owner, $_POST['content']);
    $baseURL = '../blog.php';
    $finishedURL = $adminMode ? $baseURL.'?blogid='.$_POST['blogid']: $baseURL;
	redirect($finishedURL);
?>
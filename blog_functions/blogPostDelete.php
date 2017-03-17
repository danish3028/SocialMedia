<?php
	function deletePost($pdo, $post_id, $user_id){
       // echo $post_id;
        global $adminMode;
        if(!$adminMode) {
        $stmt = $pdo->prepare("SELECT blog_owner_id FROM blog_post WHERE id = :post_id");
		$stmt->execute(['post_id'=>$post_id]);
		if($stmt->rowCount() == 0){
			#NOT YOUR POST. CHEEKY CHEEKY.
			redirect("http://localhost/blog.php");
		}
		$row = $stmt->fetch();
        }
		if($adminMode ||$row['blog_owner_id'] == $user_id){
			$stmt = $pdo->prepare("DELETE FROM blog_post WHERE id=:post_id");
			$stmt->execute(['post_id'=>$post_id]);
		}
	}
	
	include '../dbconnect.php';
	include '../functions.php';
	include '../verifySession.php';
	$vars = ['delete_id'];
	if(!verifyNull($vars)){
		exit("NULL");
	}
    $adminMode = isset($_SESSION['adminMode']) && (strcmp($_SESSION['adminMode'],"TRUE") === 0);
    // you only need the owner to check permissions
    $owner = $adminMode ? NULL: $_SESSION['id'];
	deletePost($pdo, $_POST['delete_id'], $owner);
    $baseURL = '../blog.php';
    $finishedURL = $adminMode ? $baseURL.'?blogid='.$_POST['blogid']: $baseURL;
	redirect($finishedURL);
?>
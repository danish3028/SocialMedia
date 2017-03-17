<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'/classes/photoCollection.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/classes/user.php';
	

	function displayPhotos($pdo, $collection, $user){
        global $adminMode;
		$photoCollectionContent = new photoCollection($pdo, $collection);
		$photos = $photoCollectionContent->getPhotos();
       if(!$adminMode) {
		$friends = $user->getFriends();}
		$owner = false;
		if($adminMode || $user->getId() == $photoCollectionContent->getOwner()){
			$owner = true;
		}
		foreach($photos as $photo){                 #Display Photo on your collection
			$annotationsIds = array();
			echo '<div class="container-fluid">';
			echo '<div class="row" style="padding: 10px;">';
			      echo '<div class="col-sm-4" style="background-color:#FAEBD7; padding: 10px; width: 70%; border: 3px solid #191970;">';
			echo '<div class="photoWrapper">';
					echo '<div class="photo_main">';
						if($owner){
							echo '<form action="photo_functions/deletePhoto.php" method="POST">';
								echo '<input type="hidden" name="photoid" value="'.$photo->getId().'">';
                                if($adminMode) {
                                echo '<input type="hidden" name="blogid" value="'.$_GET['blogid'].'">';
                                }
								echo '<input type="hidden" name="collectionid" value="'.$collection.'">';
                                
								echo '<input type="submit" value="Delete Photo">';
							echo '</form>';
						}
						echo '<h4>'.$photo->getDescription().'</h4>';
						echo '<img src="'.$photo->getPath().'" class="img-responsive" width="auto" height="auto"/>';
					echo '</div>';
					#Photo Annotations on each Photo
					echo '<div class="col-sm-5" style="padding: 10px;">';
					echo '<div class="photo_annotations">';
						$annotations = $photo->getAnnotations();
						echo '<h4> Annotations</h4>';
						foreach($annotations as $annotation){
							echo '<a href="blog.php?blogid='.$annotation->getUser().'">';
							echo $annotation->getUsername();
							array_push($annotationsIds, $annotation->getUser());
							echo '</a>  ';
                             if($adminMode) {
                                 // only the admin can delete annotations
                            echo '<form action="photo_functions/deleteAnnotation.php" method="POST">';
								echo '<input type="hidden" name="annotationID" value="'.$annotation->getId().'"></input>';
                                echo '<input type="hidden" name="collectionid" value="'.$collection.'">';
								echo '<input type="submit" value="DeleteAnnotation">';
                                 echo '<input type="hidden" name="blogid" value="'.$_GET['blogid'].'">';
							echo '</form>'; }
						}
                        if(!$adminMode) {
						echo '<form action="photo_functions/addAnnotation.php" method="POST">';
							echo '<input type="hidden" name="photoid" value="'.$photo->getId().'">';
							echo '<input type="hidden" name="collectionid" value="'.$collection.'">';
							echo '<select name="userid">';
								foreach($friends as $friend){
									if(!in_array($friend['id'], $annotationsIds)){
										echo '<option value="'.$friend['id'].'">'.$friend['first_name'].' '.$friend['last_name'].'</option>';
									}
								}
							echo '</select>';
							echo '<input type="submit" value="Add Tags">';
						echo '</form>'; }
					echo '</div>';
					echo '</div>';
					#Photo Comments on each photo
					echo '<div class="col-sm-7" style="background-color:orange; opacity: 0.9; padding: 10px; border: 3px solid #191970;">';
					echo '<div class="photo_comments">';
						echo '<h4> Comments </h4>';
						$comments = $photo->getComments();
						echo '<p>';
                        if(!$adminMode) {
						echo '<form action="photo_functions/addComment.php" method="POST">';
							echo '<input type="hidden" name="photoid" value="'.$photo->getId().'">';
							echo '<input type="hidden" name="collectionid" value="'.$collection.'">';
							echo '<input type="text" name="content" class="form-control">';
							echo '<input type="submit" value="Add Comment">';
						echo '</form>'; }
						foreach($comments as $comment){
							echo '<a href="blog.php?blogid='.$comment->getUser().'">';
							echo $comment->getUsername();
							echo '</a>  ';
							echo '<p>'.$comment->getContent().'</p>';
							if($owner){
								echo '<form action="photo_functions/deleteComment.php" method="POST">';
								echo '<input type="hidden" name="photoid" value="'.$photo->getId().'">';
								echo '<input type="hidden" name="commentid" value="'.$comment->getId().'">';
                                if($adminMode) {
                                echo '<input type="hidden" name="blogid" value="'.$_GET['blogid'].'">';
                                }
								echo '<input type="hidden" name="collectionid" value="'.$collection.'">';
								echo '<input type="submit" value="Delete Comment">';
							}
						echo '</form>';
						}
						echo '</p>';
					echo '</div>';
					    echo '</div>';
			echo '</div>';	
			echo '</div>';
			echo '</div>';
			echo '</div>';
		}
	}
?>

<style>
body {	
	background-color: #FAEBD7;
}
</style>


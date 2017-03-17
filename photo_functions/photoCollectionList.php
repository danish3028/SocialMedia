<?php
    include_once $_SERVER['DOCUMENT_ROOT']."/functions.php";
	

	include_once PHOTO_COLLECTION;
	include_once PHOTO;
	include_once PHOTO_COMMENT;
	include_once PHOTO_ANNOTATION;
	include_once 'verifySession.php';
	include_once 'verifyCollectionPermission.php';
	
	function displayPhotoCollections($pdo, $id){
        global $adminMode;
		echo '<div class="photo_collection_wrapper">';
		echo '<h3 style="padding: 10px"> Photos </h3>';
		if(isset($_GET['userid']) && !$adminMode){
			#If user ID is set, we will display other peoples photocollections
			try{
				$stmt = $pdo->prepare("SELECT first_name 
										FROM user
										WHERE id = :id");
				$stmt->execute(['id'=>$_GET['userid']]);
				$name = $stmt->fetch();
				
				$stmt = $pdo->prepare("SELECT id, name, description, (SELECT count(*) FROM photo WHERE album_id = p.id) AS noOfPhotos
										FROM photo_album AS p
										WHERE user_owner = :id
										ORDER BY id DESC");
				$stmt->execute(['id'=>$_GET['userid']]);
				if($stmt->rowCount() == 0){
					echo "No photo collections found.";
					return;
				}
			}
			catch(PDOException $e){
				echo $e->getCode();
			}  																#Photo Collection Of your Friends
			echo '<h1>'.$name['first_name'].'\'s Photo Collections</h1>';
			foreach($stmt as $row){
				if(verifyCollectionPermission($pdo, $_GET['userid'], $row['id'])){
					echo '<a href="displayPhotos.php?collectionid='.$row['id'].'">';
					    echo '<div class="col-sm-2" style="background-color:#98FB98; opacity: 0.8; padding: 10px; border: 3px solid #191970;">';
						echo '<div class="photo_collection">';
							echo $row['name'];
							echo '<br>';
							echo 'Contains '.$row['noOfPhotos'].' photos.';
						echo '</div>';
					echo '</a>';
					echo '</div>';
				}
			}
		}
		else{
			#Users Photo Collection (Add and Delete Albums)
			if(!$adminMode) {
			echo '<form action="photo_functions/addPhotoCollection.php" method="POST">';
		echo '<div class="container-fluid">';
			
			echo '<br>';
			echo '<div class="row" style="padding: 10px;">';
			      echo '<div class="col-sm-4" style="background-color:#191970; opacity: 0.8; padding: 10px;">';
				echo '<label style="color:white;">Album Name: </label><input type="text" name="name"></input>';
				   echo '</div>';
				   echo '<div class="col-sm-4" style="background-color:#191970; opacity: 0.8; padding: 10px;">';
				echo '<label style="color:white;">Description: </label><input type="text" name="desc"></input>';
				   echo '</div>';
				   echo '<div class="col-sm-4" style="background-color: #DC143C; opacity: 0.8; padding: 10px;">';
				echo '<label style="color:white;">Privacy: </label><select name="privacy">';
					echo '<option value="0">Public</option>';
					echo '<option value="1">Friends of Friends</option>';
					echo '<option value="2">Friends</option>';
				echo '</select>';
				echo '</div>';
				echo '<hr>';
				
		    echo '</div>';
				echo '<input type="submit" value="Create Album">';
		echo '</div>';
				
			echo '</form>';
			echo '<hr>';
            }
			
			echo '<h2 style="padding:10px;">Albums </h2>';
			
			try{
				$stmt = $pdo->prepare("SELECT id, name, description, (SELECT count(*) FROM photo WHERE album_id = p.id) AS noOfPhotos
										FROM photo_album AS p
										WHERE user_owner = :id");
				$stmt->execute(['id'=>$id]);
				
				if($stmt->rowCount() == 0){
					echo "No photo collections found.";
					return;
				}
			}
			catch(PDOException $e){
				echo $e->getCode();
			}
			foreach($stmt as $row){
				echo '<div class="container-fluid">';
				
				echo '<div class="row" style="padding: 10px;">';
				
				echo '<div class="col-sm-2" style="background-color:#98FB98; opacity: 0.8; padding: 10px; border: 3px solid #191970;">';
                if($adminMode) {
                    echo '<a href="displayPhotos.php?collectionid='.$row['id'].'&blogid='.$_GET['blogid'].'">';
                } else {
                echo '<a href="displayPhotos.php?collectionid='.$row['id'].'">';

                }
					echo '<div class="photo_collection">';
						echo $row['name'];
						echo '<br>';
						echo 'Contains '.$row['noOfPhotos'].' photos.';
					echo '</div>';
				echo '</a>'; 
				echo '<form action="photo_functions/deletePhotoCollection.php" method="POST">';
					echo '<input type="hidden" name="collectionid" value="'.$row['id'].'">';
                    if($adminMode) {
                    echo '<input type="hidden" name="blogid" value="'.$_GET['blogid'].'">';

                    }
                    
					echo '<br>';
					echo '<input type="submit" value="Delete">';
				echo '</form>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
					
			}
		}
		
	
	
	} 

?>


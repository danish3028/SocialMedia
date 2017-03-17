<?php
	include_once 'dbconnect.php';
	include_once 'functions.php';
	include_once 'verifySession.php';
	include_once 'photo_functions/verifyCollectionPermission.php';
	include_once 'classes/user.php';
	if(!ISSET($_GET['collectionid'])){
		echo "No id";
		exit();
	}
	if(!$adminMode && !verifyCollectionPermission($pdo, $_SESSION['id'], $_GET['collectionid'])){
		echo "No Permission";
		exit();
	}
?>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>
<div id="mainWrapper">
	<?php
		include_once 'navbar.php';
		printNavbar($adminMode);
	?>
	<div id="photosWrapper">
			<?php
            if(!$adminMode) {
			#Check if it's your photo collection
			$yours = 0;
			try{
				$stmt = $pdo->prepare("SELECT id 
										FROM photo_album
										WHERE user_owner = :user
										AND id = :id");
				$stmt->execute(['user'=>$_SESSION['id'], 'id'=>$_GET['collectionid']]);
				if($stmt->rowCount() != 0){
					$yours = 1;
				}
			}
			catch(PDOException $e){
				exit($e->getCode());
			}

			      # Add Photos on your photo collection page
			if($yours){
				echo '<h3 style="padding:10px;"> Add Photos </h3>';
				echo '<form action="photo_functions/addPhoto.php" method="POST" enctype="multipart/form-data">';
			    echo '<div class="container-fluid">';
				echo '<div class="row" style="padding: 10px;">';
				echo '<div class="col-sm-6" style="background-color:#98FB98; opacity: 0.7; padding: 10px; border: 3px solid #191970;">';
					echo '<label>Description: </label><input type="text" name="description" ></input>';
					echo '<br>';
					echo '<br>';
					echo '<label>Upload Photo: </label><input type="file" name="image"></input>';
					echo '<input type="hidden" value="'.$_GET['collectionid'].'" name="collection">';
					
				
					echo '<input type="submit" value="Add Photo">';
					echo '</div>';
					echo '</div>';
					echo '</div>';
				echo '</form>';
				
			
			}
            }
            $user = $adminMode ? NULL: new user($_SESSION['id'], $pdo);
            include_once 'photo_functions/photoCollectionContent.php';
			displayPhotos($pdo, $_GET['collectionid'], $user);;
		?>
	</div>
</div>


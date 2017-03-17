<?php
	include_once 'dbconnect.php';
	include_once 'functions.php';
	include_once 'verifySession.php';
	include_once 'classes/user.php';
?>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
</head>
<div id="mainWrapper">
	<?php
        include_once 'navbar.php';
        printNavbar($adminMode); 
	?>
	<div id="photoWrapper">
		<?php
			include_once 'photo_functions/photoCollectionList.php';
            $userID = $adminMode ? $_GET["blogid"] : $_SESSION['id'];
			displayPhotoCollections($pdo, $userID);
		?>
	</div>
</div>

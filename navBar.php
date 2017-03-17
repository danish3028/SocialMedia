<?php
	include_once 'dbconnect.php';
   function printNavbar($adminMode) {
    global $pdo;
    if($adminMode && !isset($_GET['blogid'])) {
        redirect("adminOverview.php");
    }
    $userID = $adminMode ?$_GET['blogid']: $_SESSION['id'];
	$stmt = $pdo->prepare('SELECT first_name, last_name 
							FROM user 
							WHERE id = :id');
	$stmt->execute(['id'=>$userID]);
	if($stmt->rowCount() == 0){
		exit('Server Error');
	}
	$row  = $stmt->fetch();
    // define urls
    $blogURL = $adminMode ? "blog.php?blogid=".$userID: "blog.php";
    $photosURL = $adminMode ? "photos.php?blogid=".$userID: "photos.php";
    $blogName = $adminMode  ? $row['first_name'].'s Blog': "My Blog";
    $photosName = $adminMode ? $row['first_name'].'s Photos':"My Photos";
	
	#Nav Bar for Pages (Logout button not working at the moment as no function for it)
	echo '<nav class="navbar navbar-inverse">';
		echo '<div class="container-fluid">';
		echo '<div class="navbar-header">';
       if(!$adminMode) {
		echo '<a class="navbar-brand" href="#"> Logged in as: '.$row['first_name'].' '.$row['last_name'].'</a> ';}
		echo '</div>';
		echo '<ul class="nav navbar-nav">';
       if($adminMode) {
           echo '<li>';
				echo '<a href="adminOverview.php"><span class="glyphicon glyphicon-home"></span>AdminOverview</a>';
			echo '</li>'; }
			echo '<li>';
				echo '<a href="'.$blogURL.'"><span class="glyphicon glyphicon-home"></span>'.$blogName.'</a>';
			echo '</li>';
			echo '<li>';
				echo '<a href="'.$photosURL.'"><span class="glyphicon glyphicon-camera"></span>'.$photosName.'</a>';
			echo '</li>';
            if(!$adminMode) {
			echo '<li>';
				echo '<a href="circles.php"><span class="fa fa-users"></span>Circles </a>';
			echo '</li>'; }
		echo '</ul>';
		echo '<ul class="nav navbar-right">';
		echo '<li class="dropdown">';
		echo '<a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span>';
		echo '<span class="caret"></span> My Account</a>';
		echo '<ul class="dropdown-menu">';
        if(!$adminMode) {
		echo '<li><a href="editProfile.php">Edit Profile</a></li>'; }
		echo '<li><a href="logout.php">Log out</a></li>';
		echo '</ul>';
		echo '</li>';
		echo '</ul>';
		echo '</div>';
		echo '</nav>';
     
   }
?>
 
<head> 
 <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link href="bootstrap.css" rel="stylesheet" media="screen">
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>


 <style>
           body {
               background-color:#FAEBD7;
               
           }
           </style>
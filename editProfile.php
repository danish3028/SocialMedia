<?php
	include_once 'dbconnect.php';
	include_once 'functions.php';
	include_once 'verifySession.php';
    include_once 'navBar.php';
    printNavbar(FALSE);
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link href="bootstrap.css" rel="stylesheet" media="screen">
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  
  <script> 
$('#myTab a').click(function (e) {
	 e.preventDefault();
	 $(this).tab('show');
});

$(function () {
$('#myTab a:last').tab('show');
})
</script> 

</head>
    
    



    

<body>

<div id="mainWrapper">
    
    
    
    
<!--Convert button-->
<form method="get" action="toxml.php">
<button type="submit">Convert profile to xml</button>
</form>


<!--Upload button-->
<form action="upload.php" method="post" enctype="multipart/form-data">
    Import XML file
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload File" name="submit">
</form>


    
    
    
    
<?php
	
	try{
		$stmt = $pdo->prepare("SELECT first_name, last_name, country, age, privacy_setting_fk
								FROM user
								WHERE id = :id");
		$stmt->execute(['id'=>$_SESSION['id']]);
		$row  = $stmt->fetch();
	}
	catch(PDOException $e){
		exit($e->getCode());
	}
	
	echo'<h1 style="color:black;">Edit Profile</h1>';
  	echo'<hr>';
	echo'<div class="row">';
	echo'<div class="col-md-9 personal-info">';
        echo'<div class="alert alert-info alert-dismissable">';
          echo'<a class="panel-close close" data-dismiss="alert">×</a>'; 
          echo'<i class="fa fa-pencil"></i>';
          echo'Edit Your <strong>Profile</strong> Here<!-- If details typed incorrectly -->';
        echo'</div>';
        echo'<h3 style="color:black">Personal info</h3>';
		
        
        echo'<form class="form-horizontal" action="updateAccount.php" method="POST">';
          echo'<div class="form-group">';
            echo'<label class="col-lg-3 control-label">First name:</label>';
            echo'<div class="col-lg-8">';
              echo'<input class="form-control" name="firstName" type="text" value="'.$row['first_name'].'">';
            echo'</div>';
          echo'</div>';
		  
          echo'<div class="form-group">';
            echo'<label class="col-lg-3 control-label">Last name:</label>';
            echo'<div class="col-lg-8">';
              echo'<input class="form-control" name="lastName" type="text" value="'.$row['last_name'].'">';
            echo'</div>';
          echo'</div>';
		  
		  echo'<div class="form-group">';
            echo'<label class="col-lg-3 control-label">Location:</label>';
            echo'<div class="col-lg-8">';
              echo'<input class="form-control" name="country" type="text" value="'.$row['country'].'"><br>';
            echo'</div>';
          echo'</div>';
		  
		  echo'<div class="form-group">';
            echo'<label class="col-lg-3 control-label">Age:</label>';
            echo'<div class="col-lg-8">';
              echo'<input class="form-control" name="age" type="number" value="'.$row['age'].'"><br>';
            echo'</div>';
          echo'</div>';
		  
          echo'<div class="form-group">';
            echo'<label class="col-lg-3 control-label">Profile Privacy</label>';
            echo'<div class="col-lg-8">';
              echo'<select name="privacy">';
				echo '<option value="0" ';if($row['privacy_setting_fk'] == 0){ echo "selected";} echo '>Public</option>';
				echo '<option value="1" ';if($row['privacy_setting_fk'] == 1){ echo "selected";} echo '>Friends of Friends</option>';
				echo '<option value="2" ';if($row['privacy_setting_fk'] == 2){ echo "selected";} echo '>Friends</option>';
			  echo '</select>';
            echo'</div>';
          echo'</div>';
	
          echo'<div class="form-group">';
            echo'<label class="col-md-3 control-label"></label>';
            echo'<div class="col-md-8">';
              echo'<input type="submit" class="btn btn-primary" value="Update Profile">';
              echo'<span></span>';
   
            echo'</div>';
          echo'</div>';
        echo'</form>';
      echo'</div>';
	  echo'</div>';
	  

?>
</div>
</body>
</html>


<style>
body{
    background:url('http://www.wallpaperup.com/uploads/wallpapers/2012/10/21/20181/cad2441dd3252cf53f12154412286ba0.jpg');
    
}
div.form-group {
	color: black;
}
</style>
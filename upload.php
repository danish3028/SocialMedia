<?php
	include_once 'dbconnect.php';
	include_once 'functions.php';
	include_once 'verifySession.php';
$target_dir = "xmlupload/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Allow only xml files
if($imageFileType != "xml") {
    echo "Please select an xml file";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} 
$xml = simplexml_load_file($_FILES["fileToUpload"]["tmp_name"]);
$user = $xml->user;


foreach($xml->children() as $child){

	if($child->getName() == "user"){
		$stmt = $pdo->prepare("UPDATE user 
								SET first_name = :first_name, last_name = :last_name, email_address = :email_address, password = :password, privacy_setting_fk = :privacy_setting_fk, initial_registration = :initial_registration,  age = :age, country = :country
								WHERE id=:id");
		$stmt->execute(['first_name'=>$user->first_name, 
						'last_name'=>$user->last_name, 
						'email_address'=>$user->email_address, 
						'password'=>$user->password, 
						'privacy_setting_fk'=>$user->privacy_setting_fk, 
						'initial_registration'=>$user->initial_registration, 
						'age'=>$user->age, 
						'country'=>$user->country,
						'id'=>$_SESSION['id']]);
	}
	else{
		$stmt = $pdo->prepare("INSERT into blog_post 
								(timestamp, blog_owner_id, content) values 
								(:timestamp,:blog_owner_id,:content) on duplicate key UPDATE id = :id");
		$stmt->execute(['timestamp'=>$child->timestamp, 
						'blog_owner_id'=>$child->blog_owner_id, 
						'content'=>$child->content, 
						'id'=>$child->id,]);
	}

}

redirect("http://localhost/editProfile.php");
?>
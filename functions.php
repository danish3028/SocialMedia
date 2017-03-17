<?php
    define("BLOG", "/blog.php");   #UPDATE FIXED .. 
  define("ADMIN_OVERVIEW","/adminOverview.php");
    define ("PHOTOS", "/photos.php");
    define ("PHOTO_COLLECTION", $_SERVER['DOCUMENT_ROOT']."/classes/photoCollection.php");
    define("PHOTO",$_SERVER['DOCUMENT_ROOT']."/classes/photo.php");
  define("PHOTO_COMMENT",$_SERVER['DOCUMENT_ROOT']."/classes/photo_comment.php");
 define("PHOTO_ANNOTATION",$_SERVER['DOCUMENT_ROOT']."/classes/photo_annotation.php");
    

	function verifyNull($array){
		foreach ($array as $var){
			if(isset($_POST[$var])){
				if("" == trim($_POST[$var])){
					return false;
				}
			}
			else{
				return false;
			}
		}
		return true;
	}
	
	function redirect($url){
		header('Location: ' . $url);
		exit();
	}
?>
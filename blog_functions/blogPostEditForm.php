<?php
    include_once "../dbconnect.php";
    include_once "../verifySession.php";
	include_once "../functions.php";
	if(!isset($_POST['content']) || !isset($_POST['id'])){
		exit("Server Error");
	}	
	echo '<form id="update" style="display:inline;" method="post" action="blog_functions/blogPostEdit.php">';
		echo '<input type="text" class="form-control" name="content" value="'.$_POST['content'].'"/>';
		echo '<br>';
		echo '<input type="hidden" name="update_id" value="'.$_POST['id'].'"/>'; 
        if($adminMode) {
            echo '<input type="hidden" name="blogid" value="'.$_POST['blogid'].'"/>';
        }
		echo '<input type="submit" name="update" style="color: black;" value="Update Post!"/>';   
	echo '</form>';
?>
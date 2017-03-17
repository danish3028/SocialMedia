<?php

	function displayPosts($pdo, $user_id, $options){
        global $adminMode;
		$pageNum = 1;
		$postsPerPage = 5;
		
		if(isset($_GET['pageNum'])){
			$pageNum = $_GET['pageNum'];
		}
		$limit = ($pageNum-1)*$postsPerPage;
		$myPostsObj = new blogPosts($user_id, $pdo, $limit, $postsPerPage);
		$posts = $myPostsObj->getBlogPosts();
		if(count($posts) != 0){
			foreach($posts as $post){
				#MAKE THEM LOOK PRETTY IN HERE
				
				echo '<div class="container-fluid" style="padding: 10px;">';
				
				echo '<div class="col-md-4" style="background-color: #191970; opacity:0.8; color: white; border: 3px solid #F5F5F5; padding: 10px; width: 100%;">';
				echo "<div id='post".$post['id']."'>";
					echo $post['id']." - ".$post['timestamp'];
					echo "<br>";
					echo "<p id='post_content_".$post['id']."'>".$post['content']."</p>";
					echo "<br>";
					if(!$options){
						echo '<form id="delete" style="display:inline; color: black;" method="post" action="blog_functions/blogPostDelete.php">';
							echo '<input type="hidden" name="delete_id" value="'.$post['id'].'"/>'; 
                            if($adminMode) {
                                echo '<input type="hidden" name="blogid" value ="'.$_GET['blogid'].'">';
                            }
							echo '<input type="submit" name="delete" value="Delete!"/>';  
                            
						echo '</form>';
                        $blogID = $adminMode ? $_GET["blogid"]:NULL;
						echo '<button type="button" style="display:inline; color: black;" class="edit_button" value="'.$post['id'].'" data-value="'.$blogID.'">Edit</button>';
					}
					echo '<br>';
				echo '</div>';
				
				echo '</div>';
			echo '</div>';
		
				################################
			}
			
			$totalPages = ceil($myPostsObj->getNumberPosts()/$postsPerPage);
			for($i = 1; $i <= $totalPages; $i++){
				#MAKE THEM LOOK PRETTY IN HERE
				if($i == $pageNum){
					
					echo "<p style='display:inline;'>-".$i."-</p>";
				}
				else{
					echo "<a href='blog.php?pageNum=".$i."'style='display:inline;'> -".$i."- </a>";
				}
				################################
			}
			
		}
		else{
			echo '<h5 style="color: black;"> No posts to show </h5>';
		}
	}
?>


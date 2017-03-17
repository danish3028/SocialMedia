<?php
	include_once 'dbconnect.php';
	include_once 'functions.php';
	include_once 'verifySession.php';
	include_once 'classes/blogPosts.php';
	include_once 'classes/user.php';
    if($adminMode) {
        if(!isset($_GET['blogid'])) {
        redirect("adminOverview.php");
        echo 'Please specify a blogID';
        } else {
           $user_id = $_GET['blogid'];
           $user = new user($_GET['blogid'], $pdo);
        }
    } else {
        $user_id = $_SESSION['id'];
        $user = new user($_SESSION['id'], $pdo);
    } 	
	$permissionTrigger = 0;

	if(isset($_GET['blogid']) && !$adminMode){
		include_once  'blog_functions/checkBlogPermission.php';
		if($_GET['blogid'] == $_SESSION['id']){
			redirect("blog.php");
		}
		if(!checkBlogPermission($_SESSION['id'], $_GET['blogid'], $pdo)){
			$permissionTrigger = 1;
		}
		$user_id = $_GET['blogid'];
		$user = new user($_GET['blogid'], $pdo);
		
	}
?>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
</head>


<div id="mainWrapper">
<?php
    
    
    	include_once 'navBar.php';
    printNavbar($adminMode);
		$stmt = $pdo->prepare('SELECT first_name, last_name, email_address, age, country
							FROM user 
							WHERE id = :id');
		$stmt->execute(['id'=>$user_id]);
		if($stmt->rowCount() == 0){
		exit('Server Error');
	}
	$row  = $stmt->fetch();

	if(!ISSET($_GET['blogid'])  || $adminMode){
		#Create a Blog Post My Profile
	echo '<h3 style="padding: 10px; color: black;"> '.$row['first_name'].' '.$row['last_name'].' Profile </h3>';
        echo '<h5 style="padding: 10px; color: black;"> Email Address: '.$row['email_address'].' </h5>';
        echo '<h5 style="padding: 10px; color: black;"> Age: '.$row['age'].' </h5>';
        echo '<h5 style="padding: 10px; color: black;"> Location: '.$row['country'].' </h5>';
        
    
        
    if(!$adminMode) {
	echo '<h3 style="padding: 10px; color: black;">Create a post</h3>';
	echo '<div style="padding: 10px; width: 66%;">';
		
		echo '<form action="blog_functions/blogPostCreate.php" method="POST">';
			echo '<label style="color: black;">Content: </label><input name="content" type="text" class="form-control"><br>';
			echo '<input type="submit" value="Post to my blog."><br>';
		echo '</form>';
		echo '</div>';
    }
		#Displays Blog posts on my Profile
		echo '<h2 style="padding: 10px; color: black;">Blog Posts</h2>';
		include_once 'blog_functions/blogPostDisplay.php';
		include_once 'friendsList.php';
		echo '<div class="col-md-8">';
		displayPosts($pdo, $user_id, 0);        
		echo '</div>';
		echo '<div class="col-md-4">';
        if(!$adminMode) {
		printFriendsInfo($user_id, $pdo, $user, 1);	
        }#Prints Friend List
		echo '</div>';
	}
	else{
		include_once 'blog_functions/checkIfFriends.php';
		$check = checkFriendship($_SESSION['id'], $_GET['blogid'], $pdo);
		if($check == 0){
			echo '<form action="blog_functions/addFriend.php" method="POST" style="padding: 10px;">';
				echo '<input name="friendid" value="'.$_GET['blogid'].'" type="hidden">';
				echo '<input name="submit" value="Send Friend Request" type="submit">';
			echo '</form>';
		}
		elseif($check == 2){ 								#This is the page when you click on any users profile
					echo '<h2 style="color: black; padding: 10px;"> Friend Request Sent </h2>';
		}
					echo '<a href="photos.php?userid='.$_GET['blogid'].'"><i class="fa fa-camera-retro fa-5x" style="float:right; padding: 10px;"></i></a>';
					echo '<br>';
                    try {
                        $stmt = $pdo->prepare('SELECT first_name, last_name FROM user WHERE id =:id');
                        $stmt->execute([':id'=>$_GET['blogid']]);
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                   
                    } catch(PDOException $e) {
                            print "Error!: " . $e->getMessage() . "<br/>";
                        
                    }
                    echo '<h2 style="padding: 10px; color: black;">'.$result["first_name"].' '.$result["last_name"].'\'s Blog</h2>';
					echo '<h2 style="padding: 10px; color: black;" >Blog Posts</h2>';
                    
		include_once 'blog_functions/blogPostDisplay.php';
		if(!$permissionTrigger){
			include_once 'friendsList.php';
			displayPosts($pdo, $user_id, 1);
			printFriendsInfo($user_id, $pdo, $user, 0);
		}
		else{
			echo '<h4 style="color: black; padding: 10px;">No Permission to Access</h4>';
		}
	}
?>
</div>

<script>
	$(".edit_button").click(function(){
		console.log($(this).attr("value"));
		var post_id = parseInt($(this).attr("value"));
        var dataValue = parseInt($(this).attr("data-value"));
        //exit();
		var div_to_change = "#post"+$(this).attr("value");
		var post_content = $("#post_content_"+post_id).text();
		console.log(post_content);
		$.ajax({url: "blog_functions/blogPostEditForm.php", 
				method: "POST",
				data:{"content": post_content,
					"id": post_id,
                     "blogid": dataValue },
				success: function(result){
			$(div_to_change).html(result);
		}});
	});
	
	$("#recs").keyup(function(){
		var currentVal = $("#recs").val();
		console.log("YO YO YO ");
		if(currentVal == ''){
			$("#searchBox").hide();
			$("#friends").show();
		}
		else{
			$("#friends").hide();
			$("#searchBox").show();
			$.ajax({url: "blog_functions/userSearch.php", 
				method: "POST",
				data:{"value": currentVal},
				success: function(result){
			$("#searchBox").html(result);
		}});
		}
	})
</script>
<style>
</style>
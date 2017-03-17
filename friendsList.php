<?php
	function printFriendsInfo($id, $pdo, $user, $pending){
		$friends = $user->getFriends();
		$recommendations = $user->getRecommendations($pdo);
		$circles = $user->getCircles();
		$friendRequests = $user->getPending();
		
		
	echo '<div class="container-fluid" style="padding: 5px; background-color: #191970; opacity:0.8;">';
		echo '<div class="col-md-4" style="padding: 5px; width:100%; background-color: #F5F5F5; opacity:0.8;">'; 
		    echo '<h4 style="color: black;"> Search For Users</h4>';
			echo "<input id='recs' type='text' placeholder='Search...' class='form-control'>";
			echo "<div id='searchBox' style='color: black;'>";
			
			echo "</div>";
		echo "<div id='friends' style='color:black;'>";
			if(count($friendRequests) != 0 && $pending == 1){
				echo "<h3> Pending Friend Requests </h3>";
				foreach($friendRequests as $request){
					echo "<div>";
						echo "<p> ".$request['first_name']." ".$request['last_name']." wants to be your friend!</p>";
						echo '<form action="blog_functions/confirmFriend.php" method="POST">';
							echo '<input name="friendid" value="'.$request['id'].'" type="hidden">';
							echo '<input name="accept" value="1" type="hidden">';
							echo '<input name="submit" value="Accept" type="submit">';
						echo '</form>';
						echo '<form action="blog_functions/confirmFriend.php" method="POST">';
							echo '<input name="friendid" value="'.$request['id'].'" type="hidden">';
							echo '<input name="accept" value="0" type="hidden">';
							echo '<input name="submit" value="Reject" type="submit">';
						echo '</form>';
				}
			} 
			
			echo '<br>';
			
			echo '<div style="padding:10px; border: 3px solid #191970; color: black;">';
			echo '<h3> Friends List </h3>';
			echo '<br>';
			foreach($friends as $friend){
				echo "<a href='blog.php?blogid=".$friend['id']."'>".$friend['first_name']." ".$friend['last_name']."</a>";
				echo '<form action="blog_functions/deleteFriend.php" method="POST">';
					echo '<input name="friendid" value="'.$friend['id'].'" type="hidden">';
					echo '<input name="submit" value="Delete" type="submit" style="color: black;">';
				echo '</form>';
				echo "<br>";
			} echo '</div>';
			
			echo '<div style="padding:10px; border: 3px solid #191970;">';
			echo '<h3> Recommendations (People Near)</h3>';
			foreach($recommendations as $friend){
				echo "<a href='blog.php?blogid=".$friend['id']."'>".$friend['first_name']." ".$friend['last_name']."</a>";
				echo "<br>";
			} echo '</div>';
			
			
			echo '<div style="padding:10px; border: 3px solid #191970;">';
			echo '<h3> Circles </h3>';
			foreach($circles as $circle){
				echo "<a href='circles.php?circleid=".$circle->getId()."'>".$circle->getName().", ".$circle->getDescription()."</a>";
				echo "<br>";
			} 
			echo '</div>';
		echo "</div>";	    
	} 
	    echo '</div>';
		
    echo '</div>';	
?>

		
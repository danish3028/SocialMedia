<?php
	function verifySession($pdo){
		session_start();
		define("LOGINREDIR", "http://localhost:8888/index.php");
		if(isset($_SESSION['key']) && isset($_SESSION['id'])){ 
			$stmt = $pdo->prepare('SELECT session_key, 								
									CASE 
									WHEN timeout > CURRENT_TIMESTAMP
									THEN 1
									ELSE 0
									END
									AS valid 
									FROM session 
									WHERE user_id = :id');
			$stmt->execute(['id'=>$_SESSION['id']]);
			$rowCount = $stmt->rowCount();
			$row = $stmt->fetch();
			if($rowCount == 0 || $row['valid'] == 0){
				echo "Key missing or out of date";
				redirect(LOGINREDIR);
			}
			if($_SESSION['key'] != $row['session_key']){
				echo "Keys don't match";
				redirect(LOGINREDIR); 
			}
			$stmt = $pdo->prepare('UPDATE session 
								SET session_key = :sessionKey,
								timeout = CURRENT_TIMESTAMP + INTERVAL "1" DAY
								WHERE user_id = :id');
			$stmt->execute(['sessionKey'=>$_SESSION['key'], 'id'=>$_SESSION['id']]);
       //     		echo "Valid Session for User <br>";
        }elseif(isset($_SESSION['adminMode']) && (strcmp($_SESSION['adminMode'],"TRUE") === 0) && isset($_SESSION['adminID'])) {
                // check if vaild session for admin
               $stmt = $pdo->prepare('SELECT * FROM admin WHERE id=:id');
               $stmt->execute([':id'=>$_SESSION['adminID']]);
               if($stmt->rowCount() === 0) {
                   echo "Error, wrong admin ID";
         
                   redirect("indexAdmin.php");
               } else {
                   
                   $result = $stmt->fetch(PDO::FETCH_ASSOC);
                   if($result['id'] != $_SESSION['adminID']) {
                       echo "Error, adminID is not matching";
                       redirect("indexAdmin.php");
                   }
                   // make admin session valid
                   $stmt = $pdo->prepare('UPDATE admin 
								SET valid_session = :validSession
								WHERE id = :adminID');
                   $stmt->execute([':validSession'=>1, ':adminID'=>$_SESSION['adminID']]);
                }
            // valid session for admin
            // check if database entry is true for the admin
             
            global $adminMode;
            $adminMode = TRUE;
    //        echo "Valid Session for Admin <br>";
        
        } else{
            
			echo "Session not set";
			redirect(LOGINREDIR);
		}
	}
    $adminMode = FALSE;
	verifySession($pdo);
?>
<?php
	include 'dbconnect.php';
	include 'functions.php';
	
	define("LOCKOUTTHRESH", 5);
	
	function checkPreviousAttempts($pdo, $id){
		$stmt = $pdo->prepare('SELECT * FROM login_attempt 
								WHERE time > CURRENT_TIMESTAMP - INTERVAL "5" MINUTE 
								AND user_id = :id 
								ORDER BY time');
		$stmt->execute(['id'=>$id]);
		$count = 0;
		foreach($stmt as $row){
			$count++;
			if($row['success'] == 1){
				$count = 0;
			}
		}
		if($count > LOCKOUTTHRESH){
			#Locks out of account for 10 minutes
			$stmt = $pdo->prepare('UPDATE user 
									SET lockout_timer = CURRENT_TIMESTAMP + INTERVAL "10" MINUTE 
									WHERE id = :id');
			$stmt->execute(['id'=>$id]);
			exit('Too many incorrect logins. Please try again later');
		}
	}
	
	function initSession($pdo, $id){
		$sessionKey = hash('sha512', $id.date('d/m/Y H:i:s'));
		try{
			$stmt = $pdo->prepare('INSERT INTO session (user_id, session_key, timeout)
									VALUES (:id, :sessionKey, CURRENT_TIMESTAMP + INTERVAL "1" DAY)
									ON DUPLICATE KEY 
									UPDATE user_id=:id_update, session_key=:sessionKey_update, timeout=CURRENT_TIMESTAMP + INTERVAL "1" DAY;');
			$stmt->execute(['id'=>$id, 'sessionKey'=>$sessionKey, 'id_update'=>$id, 'sessionKey_update'=>$sessionKey]);
		}
		catch(PDOException $e){
			echo $e->getCode();
		}
		session_start();
		$_SESSION['key'] = $sessionKey;
		$_SESSION['id'] = $id;
		redirect("blog.php");  #UPDATE: (login redirect
	}
	
	function logAttempt($pdo, $id, $success){
		$stmt = $pdo->prepare('INSERT INTO login_attempt (user_id, ipaddress, success) 
								VALUES (:userID, :ipaddress, :success)');
		$stmt->execute(['userID'=>$id, 
						'ipaddress'=>$_SERVER["REMOTE_ADDR"], 
						'success'=>$success]);
	}
	
	function verifyLogin($pdo, $adminMode){
		$vars = ['emailAddress', 'password'];
		verifyNull($vars);
		if (!$adminMode) {
		$stmt = $pdo->prepare('SELECT id, 
								password, 
								CASE 
									WHEN lockout_timer > CURRENT_TIMESTAMP
									THEN 1
									ELSE 0
									END
								AS locked
								FROM user
								WHERE email_address = :emailAddress');
		$stmt->execute(['emailAddress'=>$_POST['emailAddress']]);
		
		if($stmt->rowCount() == 0){
			logAttempt($pdo, NULL, 0);
			exit("Login Failed: Please check your email and password again.");
		}
		$row = $stmt->fetch();
		$id = $row['id'];
		
		checkPreviousAttempts($pdo, $id);
		
		if($row['locked']){
			logAttempt($pdo, $id, 0);
			exit('Too many incorrect logins. Please try again later');
		}
		
		if(!password_verify($_POST['password'], $row['password'])){
			logAttempt($pdo, $id, 0);
			exit("Login Failed: Please check your email and password again.");
		}
		$stmt = $pdo->prepare('UPDATE user 
							SET last_login = CURRENT_TIMESTAMP
							WHERE email_address = :emailAddress');
		$stmt->execute(['emailAddress'=>$_POST['emailAddress']]);
		logAttempt($pdo, $id, 1);
		
		initSession($pdo, $id); } 
        else {
            // check login for admin
            $stmt = $pdo->prepare('SELECT id,email_address, password FROM admin WHERE email_address=:emailAddress');
            $stmt->execute([':emailAddress'=>$_POST["emailAddress"]]);
            $row = $stmt->fetch();
            if($stmt->rowCount() == 0){
			exit("Login Failed: Please check your email and password again.");
		  } if(!password_verify($_POST['password'], $row['password'])){
			exit("Login Failed: Please check your email and password again.");
          }
            // start a new session
            $stmt = $pdo->prepare('UPDATE admin SET valid_session=:validSession WHERE email_address=:emailAddress');
            $stmt->execute([':emailAddress'=>$_POST["emailAddress"], ':validSession'=>1]);
            
            session_start();
		    $_SESSION['adminMode'] = "TRUE";
            $_SESSION['adminID'] = $row['id'];

        }
		
	//	echo "Login Successful.";
	}
    $adminModeRequest = isset($_POST["adminMode"]) && (strcmp($_POST["adminMode"],"TRUE") === 0);
    $url = $adminModeRequest ? ADMIN_OVERVIEW: BLOG;
	if(!empty($_POST)){
		verifyLogin($pdo, $adminModeRequest);

	}
	redirect($url);
	
?>
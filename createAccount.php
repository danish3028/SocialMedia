<?php
	include 'dbconnect.php';
	include 'functions.php';
	
	function validEmail(){
		$email = $_POST['emailAddress'];
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			exit("Please enter a valid email address.");
		}
	}
	
	function insertNewUser($pdo, $adminMode){
        $password_hash = PASSWORD_HASH($_POST['password'], PASSWORD_DEFAULT);
        $params = [':firstName'=>$_POST['firstName'],':lastName'=>$_POST['lastName'],':emailAddress'=>$_POST['emailAddress'],':password_hash'=>$password_hash];

        if(!$adminMode) {
        $params[':age'] = $_POST['age'];
        $params[':country'] = $_POST['country'];
        $stm = 'INSERT INTO user (first_name, last_name, email_address, password, country, age)
								VALUES (:firstName, :lastName, :emailAddress, :password_hash, :country, :age)';
        } else {
            $stm = 'INSERT INTO admin (first_name, last_name, email_address, password)
                                VALUES (:firstName, :lastName, :emailAddress, :password_hash)';
        }
		$stmt = $pdo->prepare($stm);					
		try{
			$stmt->execute($params);
		}
		catch(PDOException $e){
			#code 23000 is duplicate ID violating the unique email address constraint
			if($e->getCode() == 23000){
				exit('Email Address is already in use, please use a different one.');
			}
			else{
				exit('Unhandled PDO Error with code '.$e->getCode());


			}
		}
	}
	
	if(!empty($_POST)){
        $vars = array('firstName', 'lastName', 'emailAddress', 'password');
        $adminMode = isset($_POST["adminMode"]) && ($_POST["adminMode"] === "TRUE");
        if(!$adminMode) {
          array_push($vars,'country','age');  
        }
		if(!verifyNull($vars)){
			exit("NEIN");
		}
		validEmail();
		if(!$adminMode &&!is_numeric($_POST['age'])){
			exit("NEIN NUMBER");
		}
		
		if(strcmp($_POST['password'], $_POST['password_conf'])){
			exit("NEIN SAME PASS");
		}
		
		insertNewUser($pdo,$adminMode);
        
        $index = $adminMode ? "indexAdmin.php": "index.php";
		redirect($index);
	}
?>
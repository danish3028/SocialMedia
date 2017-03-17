<?php 
include 'functions.php';
include 'dbconnect.php';
include 'verifySession.php';

$user_id = $_SESSION['id'];
$stmt = $pdo->prepare("SELECT * 
						FROM user
						WHERE id = :id");	
$stmt->execute(['id'=>$user_id]);
$user = $stmt->fetch();

$stmt = $pdo->prepare("SELECT * 
						FROM blog_post
						WHERE blog_owner_id = :id");
						
$stmt->execute(['id'=>$user_id]);
$posts = $stmt->fetchAll();

// create a new XML document
$doc = new DomDocument('1.0');

// create root node
$root = $doc->createElement('root');
$root = $doc->appendChild($root);

// process one row at a time
	// add node for each row
	$occ = $doc->createElement("user");
	$occ = $root->appendChild($occ);
	// add a child node for each field
	foreach ($user as $fieldname => $fieldvalue) {
		$child = $doc->createElement($fieldname);
		$child = $occ->appendChild($child);
		$value = $doc->createTextNode($fieldvalue);
		$value = $child->appendChild($value);
		// foreach
	}
	
	
	$counter = 0;
	foreach($posts as $post){
		$occ = $doc->createElement("post");
		$occ = $root->appendChild($occ);	
		foreach($post as $fieldname => $fieldvalue){
			$child = $doc->createElement($fieldname);
			$child = $occ->appendChild($child);
			$value = $doc->createTextNode($fieldvalue);
			$value = $child->appendChild($value);
		}
	}
//Save xml document
$doc->save('xmldownload/'.$user_id.'.xml');
// get completed xml document
//$xml_string = $doc->saveXML();
//echo $xml_string;

header('Content-Type: application/xml');
header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename="'.$user_id.'.xml"');
readfile("xmldownload/".$user_id.".xml");

unlink('xmldownload/'.$user_id.'.xml');


//redirect("http://localhost/editProfile.php");


?> 
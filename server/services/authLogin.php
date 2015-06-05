<?php
	require('queries/userQueries.php');

	$fields=array('email','password');
	$inputs=array();

	//check POST object for variables from front end
	foreach($fields as $postKey){
		if(isset($_POST[$postKey]) && !empty($_POST[$postKey])){
		  $inputs[$postKey]=$_POST[$postKey];
		}else{
			return errorHandler("missing $postKey", 503);			
		}
	}

	//get the user's password
	$stmt = getUserByEmail($DB, $inputs['email']);
	if(!$stmt) return; //authLogin already sent an error.
  if(!$stmt->execute()) return errorHandler("failed to create this list $stmt->errno: $stmt->error");
  $data = array();
  $stmt->bind_result($data['id'],$data['name'],$data['hash']);
  $stmt->fetch();

  if(password_verify($inputs['password'], $data['hash'])){
  	$_SESSION['time'] = time();
  	$_SESSION['userId'] = $data['id'];
  	$_SESSION['userName'] = $data['name'];
  }else{
  	return errorHandler("password failed",503);
  }
?>
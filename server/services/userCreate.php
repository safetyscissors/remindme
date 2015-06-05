<?php
  require('authCheck.php');
  require('queries/userQueries.php');
  $PAGE->id='userCreate';

  $fields=array('email','name','password');
  $inputs=array();

  //check POST object for variables from front end
  foreach($fields as $postKey){
    if(isset($_POST[$postKey]) && !empty($_POST[$postKey])){
      $inputs[$postKey]=$_POST[$postKey];
    }else{
		  return errorHandler("missing $postKey", 503);
    }
  }

  //print debug statement
  if($SERVERDEBUG){
    echo "\r\n inputs:";
    echo json_encode($inputs);
  }

  //create passwordHash for db
	$passwordHash = password_hash($inputs['password'], PASSWORD_BCRYPT, array('cost'=>11));

  //setup for query
  $stmt = createUser($DB, $inputs['email'], $inputs['name'], $passwordHash);
  if(!$stmt) return; // createNewList already send error.
  if(!$stmt->execute()) return errorHandler("failed to create this user $stmt->errno: $stmt->error");
  echo '{"id":"'.$stmt->insert_id.'"}';
  
?>
<?php
  require('authCheck.php');
  require('queries/userQueries.php');
  $PAGE->id='authNewPassword';

  //check PUT object for password from front end
  parse_str(file_get_contents("php://input"),$_PUT);
  if(isset($_PUT['password']) && !empty($_PUT['password'])){
    $newPassword=$_PUT['password'];
  }else{
    return errorHandler("missing password", 503);
  }

  //print debug statement
  if($SERVERDEBUG){
    echo "\r\n inputs:";
    echo json_encode($newPassword);
  }

  //create passwordHash for db
	$passwordHash = password_hash($newPassword, PASSWORD_BCRYPT, array('cost'=>11));

  //setup for query
  $stmt = updateUserPassword($DB, $USER->id, $passwordHash);
  if(!$stmt) return; // createNewList already send error.
  if(!$stmt->execute()) return errorHandler("failed to create this user $stmt->errno: $stmt->error");
  
  if($stmt->affected_rows != 1){
    return errorHandler("Updated $stmt->affected_rows rows", 503);
  }
  
?>
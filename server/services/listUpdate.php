<?php
  require('authCheck.php');
  require('queries/listQueries.php');
  $PAGE->id='listUpdate';

  $fields=array('listid','type','name','description','datecreated','dateupdated');
  $requiredFields=array('listid','type','name');
  $inputs=array();
  parse_str(file_get_contents("php://input"),$_PUT);

  //check POST object for variables from front end
  foreach($fields as $postKey){
    if(isset($_PUT[$postKey])){
      $inputs[$postKey]=$_PUT[$postKey];
    }
  }


  //check inputs for all required fields to create
  foreach($requiredFields as $postKey){
    if(!isset($inputs[$postKey]) || empty($inputs[$postKey])){
      return errorHandler("missing $postKey", 503);
    }
  }
  if(!isset($inputs['description']) || empty($inputs['description'])){
    $inputs['description'] = '';
  }

  //print debug statement
  if($SERVERDEBUG){
    echo "\r\n inputs:";
    echo json_encode($inputs);
  }

  //setup for query
  $stmt = updateList($DB, $USER->id, $inputs['listid'], $inputs['type'], $inputs['name'], $inputs['description']);
  if(!$stmt) return; // createNewList already send error.
  if(!$stmt->execute()) return errorHandler("failed to create this list $stmt->errno: $stmt->error");

  if($stmt->affected_rows != 1){
    return errorHandler("Updated $stmt->affected_rows rows", 503);
  }

?>
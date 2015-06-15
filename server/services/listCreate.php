<?php
  require('authCheck.php');
  require('queries/listQueries.php');
  $PAGE->id='listCreate';

  $fields=array('type','name','description','datecreated','dateupdated');
  $requiredFields=array('type','name');
  $inputs=array();

  //check POST object for variables from front end
  foreach($fields as $postKey){
    if(isset($_POST[$postKey])){
      $inputs[$postKey]=$_POST[$postKey];
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
  $stmt = createNewList($DB, $USER->id, $inputs['type'], $inputs['name'], $inputs['description']);
  if(!$stmt) return; // createNewList already send error.
  if(!$stmt->execute()) return errorHandler("failed to create this list $stmt->errno: $stmt->error");

?>
<?php
  require('authCheck.php');
  require('queries/itemQueries.php');
  $PAGE->id='itemDelete';

  $fields=array('listid','itemid');
  $inputs=array();
  parse_str(file_get_contents("php://input"),$_DELETE);

  //check POST object for variables from front end
  foreach($fields as $postKey){
    if(isset($_DELETE[$postKey])){
      $inputs[$postKey]=$_DELETE[$postKey];
    }else{
      return errorHandler("missing $postKey", 503);
    }
  }

  //print debug statement
  if($SERVERDEBUG){
    echo "\r\n input:";
    echo json_encode($inputs);
  }

  //setup for query
  $stmt = deleteItem($DB, $USER->id, $inputs['listid'], $inputs['itemid']);
  if(!$stmt) return; // getLists already send error.
  if(!$stmt->execute()) return errorHandler("failed to delete this list $stmt->errno: $stmt->error", 503);

  if($stmt->affected_rows != 1){
    return errorHandler("Deleted $stmt->affected_rows rows", 503);
  }

?>
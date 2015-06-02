<?php
  require('queries/listQueries.php');
  $PAGE->id='listDelete';

  //get inputs. requires listId
  $requiredField='listid';
  $input='';
  parse_str(file_get_contents("php://input"),$_DELETE);

  if(isset($_DELETE[$requiredField])){
    $input=$_DELETE[$requiredField];
  }else{
    return errorHandler("missing $requiredField", 503);
  }

  //print debug statement
  if($SERVERDEBUG){
    echo "\r\n input:";
    echo json_encode($input);
  }

  //setup for query
  $stmt = deleteList($DB, $USER->id, $input);
  if(!$stmt) return; // getLists already send error.
  if(!$stmt->execute()) return errorHandler("failed to delete this list $stmt->errno: $stmt->error", 503);

  if($stmt->affected_rows != 1){
    return errorHandler("Deleted $stmt->affected_rows rows", 503);
  }

?>
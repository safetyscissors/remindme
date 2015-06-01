<?php
  require('queries/listQueries.php');
  $PAGE->id='listDelete';

  //get inputs. requires listId
  $requiredField='listid';
  $input='';

  if(isset($_POST[$requiredField])){
    $input=$_POST[$requiredField];
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
  if(!$stmt->execute()) return errorHandler("failed to delete this list $stmt->errno: $stmt->error");


?>
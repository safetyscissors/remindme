<?php
  require('queries/userQueries.php');
  $PAGE->id='userDelete';

  //print debug statement
  if($SERVERDEBUG){
    echo "\r\n input:";
    echo json_encode($USER->id);
  }

  //setup for query
  $stmt = deleteUser($DB, $USER->id);
  if(!$stmt) return; // getLists already send error.
  if(!$stmt->execute()) return errorHandler("failed to delete this list $stmt->errno: $stmt->error", 503);

  if($stmt->affected_rows != 1){
    return errorHandler("Deleted $stmt->affected_rows rows", 503);
  }

?>
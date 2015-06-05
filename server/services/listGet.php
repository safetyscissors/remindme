<?php
  require('authCheck.php');
  require('queries/listQueries.php');
  $PAGE->id='listGet';

  //print debug statement
  if($SERVERDEBUG){
    echo "\r\n no inputs for listGet";
  }

  //setup for query
  $stmt = getLists($DB, $USER->id);
  if(!$stmt) return; // getLists already send error.
  if(!$stmt->execute()) return errorHandler("failed to get this list $stmt->errno: $stmt->error");

  //format results
  $data = array();
  $stmt->bind_result($data['Id'],$data['Userid'],$data['Type'],$data['Name'],$data['Description'],$data['SortOrder'],$data['DateCreated'],$data['DateUpdated']);

  /* fetch values */
  $listResults = array();
  while ($stmt->fetch()) {
    $row = arrayCopy($data);
    array_push($listResults, $row);
  }
  echo json_encode($listResults);



function arrayCopy( array $array ) {
        $result = array();
        foreach( $array as $key => $val ) {
            if( is_array( $val ) ) {
                $result[$key] = arrayCopy( $val );
            } elseif ( is_object( $val ) ) {
                $result[$key] = clone $val;
            } else {
                $result[$key] = $val;
            }
        }
        return $result;
}
?>
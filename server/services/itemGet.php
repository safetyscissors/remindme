<?php
  require('queries/itemQueries.php');
  $PAGE->id='itemGet';

  //get inputs. requires listId
  $requiredField='listid';
  $input='';
  if(isset($_GET[$requiredField])){
    $input=$_GET[$requiredField];
  }else{
    return errorHandler("missing $requiredField", 503);
  }

  //print debug statement
  if($SERVERDEBUG){
    echo "\r\n trying to get list $input";
  }

  //setup for query
  $stmt = getItems($DB, $input, $USER->id);
  if(!$stmt) return; // getLists already send error.
  if(!$stmt->execute()) return errorHandler("failed to get this list $stmt->errno: $stmt->error");

  //format results
  $data = array();
  $stmt->bind_result($data['Id'],$data['ListId'],$data['UserId'],$data['Type'],$data['Name'],$data['Description'],$data['Value'],$data['IsChecked'],$data['Color'],$data['SortOrder'],$data['DateUpdated']);

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
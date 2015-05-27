<?php
  $PAGE->id='createList';
  $fields=array('type','name','description','sortorder','datecreated','dateupdated');
  $requiredFields=array('type','name');
  $list = new stdClass();

  //check POST object for fields
  foreach($fields in $postKey){
    if(isset($_POST[$postKey])){
      $list[]
    }
  }
?>
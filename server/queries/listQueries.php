<?php

  function getLists($DB, $uid){
    $stmt = $DB->prepare("SELECT * FROM remindme.Lists WHERE UserId = ?");
    if(!$stmt->bind_param('i', $uid)){
      return errorHandler("getLists failed to bind parameter", 503);
    }
    return $stmt;
  }

  function createNewList($DB, $uid, $type, $name, $description){
    $stmt = $DB->prepare("INSERT INTO Lists (UserId, Type, Name, Description, DateCreated, DateUpdated) VALUES (?,?,?,?, NOW(), NOW())");

    if(!$stmt->bind_param('isss', $uid, $type, $name, $description)){
      return errorHandler("createNewList failed to bind parameter", 503);
    }
    return $stmt;
  }

  function updateList($DB, $uid, $listId, $type, $name, $description){
    $stmt = $DB->prepare("UPDATE Lists SET Type=?, Name=?, Description=?, DateUpdated=NOW() WHERE Id=? AND UserId=?");

    if(!$stmt->bind_param('sssii', $type, $name, $description, $listId, $uid)){
      return errorHandler("updateList failed to bind parameter", 503);
    }
    return $stmt;
  }

  function deleteList($DB, $uid, $listId){
    $stmt = $DB->prepare("DELETE FROM Lists WHERE Id=? AND UserId=?");
    if(!$stmt->bind_param('ii', $listId, $uid)){
      return errorHandler("deleteList failed to bind parameter", 503);
    }
    return $stmt;

  }
?>
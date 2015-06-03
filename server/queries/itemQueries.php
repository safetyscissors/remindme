<?php

  function getItems($DB, $listId, $uid){
    $stmt = $DB->prepare("SELECT * FROM ListItems WHERE ListId = ? AND UserId = ?");
    if(!$stmt->bind_param('ii', $listId, $uid)){
      return errorHandler("getItems failed to bind parameter", 503);
    }
    return $stmt;
  }

  function createNewItem($DB, $listId, $uid, $type, $name, $description){
    $stmt = $DB->prepare("INSERT INTO ListItems (ListId, UserId, Type, Name, Description, DateUpdated) VALUES (?,?,?,?,?,NOW())");

    if(!$stmt->bind_param('iisss', $listId, $uid, $type, $name, $description)){
      return errorHandler("createNewItem failed to bind parameter", 503);
    }
    return $stmt;
  }

  function updateItem($DB, $uid, $itemId, $listId, $type, $name, $description, $value){
    $stmt = $DB->prepare("UPDATE ListItems SET Type=?, Name=?, Description=?, Value=?, DateUpdated=NOW() WHERE Id=? AND UserId=? AND ListId=?");
    if(!$stmt->bind_param('ssssiii', $type, $name, $description, $value, $itemId, $uid, $listId)){
      return errorHandler("updateItem failed to bind parameter", 503);
    }
    return $stmt;
  }

  function deleteItem($DB, $uid, $listId, $itemId){
    $stmt = $DB->prepare("DELETE FROM ListItems WHERE Id=? AND ListId=? AND UserId=?");
    if(!$stmt->bind_param('iii', $itemId, $listId, $uid)){
      return errorHandler("deleteItem failed to bind parameter", 503);
    }
    return $stmt;

  }
?>
<?php
/* ************************************************************* *\
                    USER SERVICE FUNCTIONS
\* ************************************************************* */

	function getUser($DB, $uid){
    $stmt = $DB->prepare("SELECT Id,UserName,Email,Phone,PasswordHash FROM Users WHERE Id = ?");
    if(!$stmt->bind_param('i', $uid)){
      return errorHandler("getUsers failed to bind parameter", 503);
    }
    return $stmt;
	}

  function createUser($DB, $email, $name, $passwordHash){
    $stmt = $DB->prepare("INSERT INTO Users (UserName,Email,PasswordHash) VALUES (?,?,?)");

    if(!$stmt->bind_param('sss', $name, $email, $passwordHash)){
      return errorHandler("createUser failed to bind parameter", 503);
    }
    return $stmt;
  }

  function updateUser($DB, $uid, $email, $name, $phone){
    $stmt = $DB->prepare("UPDATE Users SET Email=?, UserName=?, Phone=? WHERE Id=?");

    if(!$stmt->bind_param('sssi', $email, $name, $phone, $uid)){
      return errorHandler("updateList failed to bind parameter", 503);
    }
    return $stmt;
  }

  function deleteUser($DB, $uid){
    $stmt = $DB->prepare("DELETE FROM Users WHERE Id=?");
    if(!$stmt->bind_param('i', $uid)){
      return errorHandler("deleteItem failed to bind parameter", 503);
    }
    return $stmt;
  }

/* ************************************************************* *\
                    AUTH SERVICE FUNCTIONS
\* ************************************************************* */

  function getUserByEmail($DB, $email){
    $stmt = $DB->prepare("SELECT Id,UserName,PasswordHash FROM Users WHERE Email = ?");
    if(!$stmt->bind_param('s', $email)){
      return errorHandler("getUsers failed to bind parameter", 503);
    }
    return $stmt;
  }

  function updateUserPassword($DB, $uid, $passwordHash){
    $stmt = $DB->prepare("UPDATE Users SET PasswordHash=? WHERE Id=?");
    
    if(!$stmt->bind_param('si', $passwordHash, $uid)){
      return errorHandler("updateList failed to bind parameter", 503);
    }
    return $stmt;
  }
?>
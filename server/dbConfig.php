<?php
  $DB = new mysqli("localhost", "reminderAdmin", "reminderPassword", "remindme");

  /* check connection */
  if ($DB->connect_errno) {
      printf("Connect failed: %s\n", $DB->connect_error);
      exit();
  }

  return $DB;
?>
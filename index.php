<?php

/* ********************************************************************* *\
        MAIN SERVER
\* ********************************************************************* */

  //setup global object
  $PAGE = new stdClass();

  //get path to a service
  $service = getRoute(getUri());

  //exit with msg if path doesnt exist
  if($service==false) return errorHandler('Invalid Path', 501);

  //if path was valid, load service
  require($service);

  //if debug, dump server response
  if($_GET['debug']=='true') echo json_encode($PAGE); return;

  //load web
  require('web/index.php');

/* ********************************************************************* *\
          HELPER FUNCTIONS
\* ********************************************************************* */

  /*
    Reads a method:path string and returns a path to a service OR false
    param $path string
    returns string || false
  */
  function getRoute($path){
    $serviceDir = "server/services";
    $path=strToLower($path);
    switch($path){
      case "get:":
      case "get:index.php": return "$serviceDir/main.php";
      case "get:healthcheck": return "$serviceDir/healthCheck.php";
    }
    return false;
  }

  /*
    Reads SERVER var requestUri and requestMethod and returns a route string
    returns string [method:path]
  */
  function getUri(){
    $uri=explode("/",$_SERVER[REQUEST_URI]);

    //get rid of extra directory depth
    array_shift($uri);
    array_shift($uri);
    $uri=join("/",$uri);

    //get rid of param string
    $uri=explode("?",$uri);
    $uri=$uri[0];

    $method=$_SERVER['REQUEST_METHOD'];
    return "$method:$uri";
  }

  /*
    Prints a message, sets the response error code
  */
  function errorHandler($message, $code){
    echo $message;
    http_response_code($code);
  }

?>
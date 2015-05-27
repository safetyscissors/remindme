<?php

/* ********************************************************************* *\
        MAIN SERVER
\* ********************************************************************* */

  //setup global object
  $USER = new stdClass();
  $PAGE = new stdClass();

  //until login is working,
  $USER->id=1;
  $USER->name='andrew';

  //get path to a service
  $service = getRoute(getUri());

  //exit with msg if path doesnt exist
  if($service==false) return errorHandler('Invalid Path', 501);

  //if path was valid, load service
  require($service);

  //if debug, dump server response
  echo json_encode($PAGE); return;


/* ********************************************************************* *\
          HELPER FUNCTIONS
\* ********************************************************************* */

  /*
    Reads a method:path string and returns a path to a service OR false
    param $path string
    returns string || false
  */
  function getRoute($path){
    $serviceDir = "services";
    $path=strToLower($path);
    switch($path){
      case "get:":
      case "get:index.php": return "$serviceDir/main.php";
      case "get:healthcheck": return "$serviceDir/healthCheck.php";
      case "post:createlist": return "$serviceDir/createList.php";
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
    array_shift($uri);
    $uri=join("/",$uri);

    //get rid of param string
    $uri=explode("?",$uri);
    $params=$uri[1];
    $uri=$uri[0];

    //get GET params
    $params=split("&",$params);
    foreach($params as $param){
      $param=split("=",$param);
      $_GET[$param[0]]=$param[1];
    }

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
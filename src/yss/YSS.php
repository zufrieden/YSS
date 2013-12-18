<?php

function getBetween($content,$start,$end){
  $into = array();
  $startingArray = explode($start, $content);
  if (isset($startingArray[1])){
    foreach ($startingArray as $key => $value) {
      $endingArray = explode($end, $startingArray[$key]);
      array_push($into, $endingArray[0]);
    }
  }
  return $into;
}

function printStyleguide($src){
  $cssRaw = file_get_contents($src);
  $cssComment = getBetween($cssRaw,'/*','*/');

  foreach ($cssComment as $key => $content) {
    $content = str_replace("\n  #", "\n#", $content);
    $code = explode('````', $content);

    if(isset($code[1])){
      foreach ($code as $keyCode => $codeContent) {
        if($keyCode&1){
          // snippet preview
          echo $codeContent;

          $result = Parsedown::instance()->parse('````'.$codeContent.'````');
          echo $result;
        }else {
          $result = Parsedown::instance()->parse($codeContent);
          if(strlen($result) > 10){
            echo $result;
          }
        }
      }
    }else{
      $result = Parsedown::instance()->parse($content);
      if(strlen($result) > 15){
        echo $result;
      }
    }
  }
}

?>


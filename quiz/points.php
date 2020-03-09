<?php
     session_name("mindthecode");
     session_start();

     $points = array("points" => 0);

     // if points already exist on current session, get them
     if (isset($_SESSION['points'])) {
          foreach ($_SESSION['points'] as $key => $value) {
               $points['points'] += intval($value);
          }
     }

     echo json_encode($points);
     die();
?>

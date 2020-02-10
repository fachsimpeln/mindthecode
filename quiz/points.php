<?php
     session_name("mindthecode");
     session_start();

     $points = array("points" => 0);
     if (isset($_SESSION['points'])) {
          $points["points"] = intval($_SESSION['points']);
     }

     echo json_encode($points);
     die();
?>

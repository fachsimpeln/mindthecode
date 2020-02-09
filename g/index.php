<?php
     session_name("mindthecode");
     session_start();

     if (isset($_REQUEST['c'])) {

          $code = $_REQUEST['c'];
          // remove /mindthecode/g/
          $code = ltrim($code, '/mindthecode/g/');

          $_SESSION['code'] = $code;
          if (!isset($_SESSION['question'])) {
               $_SESSION['question'] = array();
          }
          $_SESSION['question'][$code] = array();

          header('Location: ../');
          die();
     }

     include("../inc/codeform.inc.php");
?>

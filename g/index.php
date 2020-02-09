<?php
     session_name("mindthecode");
     session_start();

     if (isset($_REQUEST['c'])) {

          $code = $_REQUEST['c'];
          // remove /mindthecode/g/
          $code = ltrim($code, '/mindthecode/g/');

          $_SESSION['code'] = $code;

          header('Location: ../');
          die();
     }

     include("../inc/codeform.inc.php");
?>

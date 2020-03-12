<?php

     require_once 'hilite-api.php';

     $hl = new HightlightCode();


     print $hl->GetHighlightedCode($_REQUEST['code'], true);
     die();

?>

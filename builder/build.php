<?php

     if (!isset($_POST['submit'])) {
          die();
     }

     $title = $_POST['title'];
     $description = $_POST['description'];
     $instruction = $_POST['instruction'];

     $code = $_POST['code'];

     $answers = array();

     // Get all questions with their answers
     foreach ($_POST as $key => $value) {
          if (startsWith($key, 'answer')) {
               $question_id = explode('_', $key)[1];
               $question_id = ltrim($question_id, 'q');

               $answer_id = explode('_', $key)[0];
               $answer_id = ltrim($answer_id, 'answer');
               $answer_id = intval($answer_id);

               $answers[$question_id][$answer_id] = $value;
          }
     }

     foreach ($answers as $question_id => $value) {
          $answers[$question_id] = array_values($answers[$question_id]);
     }


     // Generate new id
     $length = 16;
     do {
          $file = bin2hex(openssl_random_pseudo_bytes($length));
          $filename = '../data/code/' . $file . '.html';
          $length += 4;
     } while (file_exists($filename));


     // Generate JSON
     $json = array();
     $json['title'] = $title;
     $json['description'] = $description;
     $json['instruction'] = $instruction;
     $json['code'] = $file . '.html';
     $json['quiz'] = $answers;

     $json = json_encode($json, JSON_PRETTY_PRINT);

     // Save everything to file system
     file_put_contents($filename, $code); // Code

     file_put_contents('../data/' . $file . '.json', $json);


     // Show link and code

     print '<h1>' . $file . '</h1>';

     $current_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

     $current_link = preg_replace('/\/builder\/build.php$/', '', $current_link);

     print '<h2>' . $current_link . '/g/' . urlencode($file) . '</h2>';


     function startsWith ($string, $startString)
     {
         $len = strlen($startString);
         return (substr($string, 0, $len) === $startString);
     }
?>

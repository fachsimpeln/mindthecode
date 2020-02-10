<?php
     session_name("mindthecode");
     session_start();

     if (isset($_SESSION['code'])) {
          $quizcode = $_SESSION['code'];
          $quizpath = './data/' . urlencode($_SESSION['code']) . '.json';
          if (!file_exists($quizpath)) {
               header('Location: ./g');
               die();
          }
          $quizfile = json_decode(file_get_contents($quizpath), true);

          $quiz_questions_ordered = $quizfile['quiz'];
          foreach ($quiz_questions_ordered as $key => $value) {
               shuffle($quiz_questions_ordered[$key]);
          }

          $quiz_questions = str_replace("'", "\'" , json_encode($quiz_questions_ordered));

          $quiz_code = file_get_contents('./data/code/' . $quizfile['code']);

          $points = 0;
          if (isset($_SESSION['points'])) {
               $points = intval($_SESSION['points']);
          }

     } else {
          header('Location: ./g');
          die();
     }


     function PreventXSS($text)
     {
          return htmlspecialchars($text, ENT_QUOTES);
     }

?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
     <head>
          <meta charset="utf-8">
          <title>mindthecode.</title>

          <meta name="author" content="fachsimpeln">
          <meta name="publisher" content="fachsimpeln">
          <meta name="description" content="">

          <meta name="page-topic" content="Medien">
          <meta name="page-type" content="Produktinfo">
          <meta name="audience" content="Alle">
          <meta http-equiv="content-language" content="de">
          <meta name="robots" content="index, nofollow">


          <link rel="stylesheet" href="./css/master.css">

          <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

          <script type="text/javascript">
               // BASIC SETTINGS
               let answerServer = "./quiz/answer.php";

               let question_id = 1;
               let quiz_id = '<?php echo PreventXSS($quizcode); ?>';
               let answers = JSON.parse('<?php echo $quiz_questions; ?>');
          </script>

          <script src="./js/quiz.js" charset="utf-8"></script>
     </head>
     <body>

          <div class="navbar">
               <ul>
                    <li>
                         <img src="./assets/img/mindthecode-logo.png" alt="MindTheCode-Logo">
                    </li>
                    <li>
                         mindthecode.
                    </li>
                    <li>
                         <img src="./assets/icons/add_box-24px.svg" alt="">
                         ERSTELLEN
                    </li>
                    <li>
                         <img src="./assets/icons/turned_in-24px.svg" alt="">
                         <span id="quiz_id"></span>
                    </li>
                    <li>
                         <img src="./assets/icons/iconfinder-bag-christmas-gift.svg" alt="">
                         <span id="points"><?php echo PreventXSS($points) ?> Punkt(e)</span>
                    </li>
               </ul>
          </div>

          <div class="code">
               <p>Vervollständige den hier angezeigten Code:</p>
               <div>
                    <?php echo $quiz_code; ?>
               </div>
          </div>

          <div id="answerdiv" style="display: none;" class="answers">
               <div id="a1" onclick="sendAnswer(this)">
                    <span>A</span>
                    <br>
                    <h3></h3>
               </div>
               <div id="a2" onclick="sendAnswer(this)">
                    <span>B</span>
                    <br>
                    <h3></h3>
               </div>
               <div id="a3" onclick="sendAnswer(this)">
                    <span>C</span>
                    <br>
                    <h3></h3>
               </div>
               <div id="a4" onclick="sendAnswer(this)">
                    <span>D</span>
                    <br>
                    <h3></h3>
               </div>
          </div>

          <footer>
               <ul>
                    <li>copyright fachsimpeln <?php echo date("Y"); ?></li>
                    <li>Impressum</li>
                    <li>Datenschutz</li>
               </ul>
          </footer>
     </body>
</html>

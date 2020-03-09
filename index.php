<?php
     // start the session
     session_name("mindthecode");
     session_start();

     // check if quiz id is set
     if (isset($_SESSION['code'])) {
          // get quiz code
          $quizcode = $_SESSION['code'];

          // get filename for quiz id and urlencode it for security
          $quizpath = './data/' . urlencode($_SESSION['code']) . '.json';

          // check if quiz id actually exists (file)
          if (!file_exists($quizpath)) {
               // if it doesn't exist, redirect and die
               header('Location: ./g');
               die();
          }
          // if it exists, decode and load the data in $quizfile
          $quizfile = json_decode(file_get_contents($quizpath), true);

          // get all questions from the array and shuffle them (otherwise 1st would always be the correct answer)
          $quiz_questions_ordered = $quizfile['quiz'];
          foreach ($quiz_questions_ordered as $key => $value) {
               shuffle($quiz_questions_ordered[$key]);
          }

          // replace all ' to \' to escape for javascript string
          $quiz_questions = str_replace("'", "\'" , json_encode($quiz_questions_ordered));

          // get the code for the current quiz and load it in $quiz_code_file
          $quiz_code_file = file_get_contents('./data/code/' . $quizfile['code']);

          // start points with zero
          $points = 0;
          // if points already exist on current session, get them
          if (isset($_SESSION['points'])) {
               foreach ($_SESSION['points'] as $key => $value) {
                    $points += intval($value);
               }
          }

          // get quiz metadata (title, desc. and instructions)
          $quiz_title = $quizfile['title'];
          $quiz_description = $quizfile['description'];
          $quiz_instruction = $quizfile['instruction'];

     } else {
          // if quiz id is not set, redirect and die
          header('Location: ./g');
          die();
     }


     function PreventXSS($text)
     {
          // remove all html special chars to prevent XSS attack vector
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
          <style>
               table:first-child tr:first-child td:first-child {
                    color: #333;
               }
          </style>

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
               <h2><?php echo PreventXSS($quiz_title); ?></h2>
               <h4><?php echo PreventXSS($quiz_description); ?></h4>
               <p><?php echo PreventXSS($quiz_instruction); ?></p>
               <div>
                    <?php echo $quiz_code_file; ?>
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

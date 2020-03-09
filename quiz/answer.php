<?php
     // start the session
     session_name("mindthecode");
     session_start();

     // check if all params are set
     if (!(isset($_REQUEST['i']) && isset($_REQUEST['i']) && isset($_REQUEST['i']))) {
          // if not all params are set, show error and die
          mtc_showerror('params_missing');
     }

     // get quiz-id, answer, quest.-id from client
     $quiz = $_REQUEST['i'];
     $answer = $_REQUEST['a'];
     $question = $_REQUEST['q'];

     // check if requested question id is already played
     if (in_array($question, $_SESSION['question'][$quiz])) {
          // if requested question id is already played, show error and die
          mtc_showerror('already_played');
     }

     // get path to file (to prevent local file inclusion, urlencode is used)
     $path = '../data/' . urlencode($quiz) . '.json';
     // check if quiz id actually exists (file)
     if (!file_exists($path)) {
          // if it doesn't exist, show error and die
          mtc_showerror('wrong_quiz_id');
     }
     // if it exists, decode and load the data in $quizfile
     $quizfile = json_decode(file_get_contents($path), true);

     // add question id to array of already played questions
     $_SESSION['question'][$quiz][] = $question;

     // get correct answer (correct answer is at position 0)
     $correct_answer =  $quizfile['quiz'][$question][0];
     if ($correct_answer !== $answer) {
          // if answer is incorrect, return 'wrong', the actual correct answer and then die
          mtc_return('incorrect', $correct_answer);
     }

     // if the session has already a points variable, increment it
     if (isset($_SESSION['points'])) {
          $_SESSION['points'][$quiz] += 1;
     } else {
          // if it doesn't have one, create it and set it to 1
          $_SESSION['points'][$quiz] = 1;
     }
     // answer is correct, so return 'correct', the correct answer again and then die
     mtc_return('correct', $correct_answer);

     /* shows an error */
     function mtc_showerror($errormessage)
     {
          $response = array();
          // set status to error
          $response['status'] = 'error';
          // set error message to $errormessage
          $response['message'] = $errormessage;
          // encode the error array to json, output it and die
          die(json_encode($response));
     }

     /* shows correct/incorrect */
     function mtc_return($status, $correct)
     {
          $response = array();
          // set status to correct/incorrect
          $response['status'] = $status;
          // set actual correct answer
          $response['correct'] = $correct;
          // encode the array to json, output it and die
          die(json_encode($response));
     }
?>

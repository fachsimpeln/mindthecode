<?php
     session_name("mindthecode");
     session_start();

     if (!(isset($_REQUEST['i']) && isset($_REQUEST['i']) && isset($_REQUEST['i']))) {
          mtc_showerror('params_missing');
     }

     // get quiz-id, answer, quest.-id from client
     $quiz = $_REQUEST['i'];
     $answer = $_REQUEST['a'];
     $question = $_REQUEST['q'];

     // check if requested question id is already played
     if (in_array($question, $_SESSION['question'][$quiz])) {
          mtc_showerror('already_played');
     }

     // get path to file (to prevent local file inclusion, urlencode is used)
     $path = '../data/' . urlencode($quiz) . '.json';
     if (!file_exists($path)) {
          mtc_showerror('wrong_quiz_id');
     }
     $quizfile = json_decode(file_get_contents($path), true);

     // add question id to array of already played questions
     $_SESSION['question'][$quiz][] = $question;

     // correct answer is at position 0
     if ($quizfile['quiz'][0] !== $answer) {
          mtc_return('wrong', $quizfile['quiz'][0]);
     }

     if (isset($_SESSION['points'][$quiz])) {
          $_SESSION['points'][$quiz] += 1;
     } else {
          $_SESSION['points'][$quiz] = 1;
     }

     mtc_return('correct', $quizfile['quiz'][0]);


     function mtc_showerror($errormessage)
     {
          $response = array();
          $response['status'] = 'error';
          $response['message'] = $errormessage;
          die(json_encode($response));
     }

     function mtc_return($status, $correct)
     {
          $response = array();
          $response['status'] = $status;
          $response['correct'] = $correct;
          die(json_encode($response));
     }
?>

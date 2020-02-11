
// INITIAL SETUP
window.onload = function() {
     document.getElementById('quiz_id').innerHTML = quiz_id;
};


function question(n) {
     // SET ANSWERS TO VALUE FROM ARRAY ACCORDING TO QUESTION ID
     document.getElementById('a1').children[2].innerHTML = answers[n][0];
     document.getElementById('a2').children[2].innerHTML = answers[n][1];
     document.getElementById('a3').children[2].innerHTML = answers[n][2];
     document.getElementById('a4').children[2].innerHTML = answers[n][3];

     // show answer panel
     document.getElementById('answerdiv').style.display = "block";

     question_id = n;
}

function sendAnswer(answerblock) {
     let answer = answerblock.children[2].innerHTML;

     let params = "i=" + encodeURIComponent(quiz_id) + "&q=" + encodeURIComponent(question_id) + "&a=" + encodeURIComponent(answer);

     sendRequest(params, answerServer,
          function parseAnswer(json) {
               // Check for an error
               if (json == null) {
                    console.error('[mindthecode] Error in server-client communcation!');
                    return;
               }

               // Parse response
               let status = json.status;

               // Message correct/incorrect
               if (status == 'correct') {
                    // Message correct
                    console.log("[mindthecode] The answer was correct: " + json.correct);
               } else if (status == 'incorrect') {
                    // Message incorrect
                    console.warn("[mindthecode] The answer was incorrect. The correct answer would've been " + json.correct);
               }

               // Error handling
               if (status == 'error') {
                    let error_msg = json.message;
                    if (error_msg == 'wrong_quiz_id') {
                         // Invalid quiz id
                         console.error('[mindthecode] Invalid quiz-id');
                    } else if (error_msg == 'already_played') {
                         // Question already played
                         console.error('[mindthecode] Question was already played in this session');
                    } else if (error_msg == 'params_missing') {
                         // Missing params
                         console.error('[mindthecode] Missing parameters');
                    } else {
                         // Internal error
                         console.error("[mindthecode] Internal error")
                    }
               }

               //console.log(json);
          }
     );
}


function sendRequest(params, server, returnFunction) {
     let xhr = new XMLHttpRequest();

     xhr.open('POST', server);
     xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
     xhr.responseType = 'json';

     xhr.send(params);

     xhr.onload = function() {
          if (xhr.status == 200) {
               returnFunction(xhr.response);
          } else {
               returnFunction(null);
          }
     };
     return;
}

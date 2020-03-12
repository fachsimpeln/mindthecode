<!DOCTYPE html>
<html lang="de" dir="ltr">
     <head>
          <meta charset="utf-8">
          <title>MindTheCode - Builder</title>

          <style>
               .iframe-container {
                    overflow: hidden;
                    padding-top: 56.25%;
                    position: relative;
               }

               .iframe-container iframe {
                    border: 0;
                    height: 100%;
                    left: 0;
                    position: absolute;
                    top: 0;
                    width: 100%;
               }
          </style>


     </head>
     <body>

          <div>
               <form id="mainform" action="build.php" method="post">
                    <input type="text" name="title" placeholder="Titel" value="">

                    <br><br>

                    <input type="text" name="description" placeholder="Beschreibung" value="Ein kleiner Test ;)">

                    <br><br>

                    <input type="text" name="instruction" placeholder="Anweisung" value="Vervollständigen Sie den hier angezeigten Code:">

                    <br><br>

                    <textarea style="width: calc(100% - 8px); height: 50%" onchange="reloadIframe()" id="codebox" name="code" rows="8" cols="80"></textarea>
                    <br><br>

                    <input type="submit" name="submit" value="Hinzufügen">

                    <br><br>

               </form>

               <br>
               <br>

               <button type="button" onclick="highlight()" name="highlight">Highlight Code!</button>
               <button type="button" onclick="insertAtCursor();" name="insert">Neue Frage einfügen</button>
          </div>

          <div class="iframe-container">
               <iframe id="codepreview" frameborder="0" allowfullscreen scrolling="no"></iframe>
          </div>


          <script type="text/javascript">
               var codebox = document.getElementById('codebox');
               var codepreview = document.getElementById('codepreview');

               var form = document.getElementById('mainform');

               function highlight() {
                    var code = codebox.value;

                    fetch('./highlight.php?code=' + encodeURIComponent(code))
                    .then((response) => {
                         response.text().then(function(text) {
                              codebox.value = text;
                              reloadIframe();
                         });
                    });
               }

               function reloadIframe() {
                    codepreview.src = "data:text/html;charset=utf-8," + "<style>table:first-child tr:first-child td:first-child {color: rgb(20, 20, 20);}</style>" + escape(codebox.value);
               }
          </script>

          <script type="text/javascript">
               var question_counter = 1;

               function insertAtCursor() {

                    var br = document.createElement('br');



                    var ansdiv = document.createElement('div');
                    ansdiv.id = "answerdiv_" + question_counter;
                    form.appendChild(ansdiv);

                    var span = document.createElement('span');
                    span.innerHTML = "Frage "  + question_counter + ":          ";
                    ansdiv.appendChild(span);

                    var textbox = document.createElement('input');
                    textbox.type = 'text';
                    textbox.placeholder = "Antwort 1 (richtig)";
                    textbox.name = "answer1_q" + question_counter;
                    ansdiv.appendChild(textbox);

                    var textbox = document.createElement('input');
                    textbox.type = 'text';
                    textbox.placeholder = "Antwort 2";
                    textbox.name = "answer2_q" + question_counter;
                    ansdiv.appendChild(textbox);

                    var textbox = document.createElement('input');
                    textbox.type = 'text';
                    textbox.placeholder = "Antwort 3";
                    textbox.name = "answer3_q" + question_counter;
                    ansdiv.appendChild(textbox);

                    var textbox = document.createElement('input');
                    textbox.type = 'text';
                    textbox.placeholder = "Antwort 4";
                    textbox.name = "answer4_q" + question_counter;
                    ansdiv.appendChild(textbox);

                    ansdiv.appendChild(br);
                    form.appendChild(br);


                    var myValue = '<span style="padding-left: 70px; background-color: white; border-radius: 3px" id="q' + question_counter + '" onclick="question(' + question_counter + ');" class="q_empty"></span>';

                    //IE support
                    if (document.selection) {
                         codebox.focus();
                         sel = document.selection.createRange();
                         sel.text = myValue;
                    }
                    //MOZILLA and others
                    else if (codebox.selectionStart || codebox.selectionStart == '0') {
                         var startPos = codebox.selectionStart;
                         var endPos = codebox.selectionEnd;
                         codebox.value = codebox.value.substring(0, startPos)
                         + myValue
                         + codebox.value.substring(endPos, codebox.value.length);
                    } else {
                         codebox.value += myValue;
                    }

                    question_counter += 1;
                    reloadIframe();
               }
          </script>


     </body>
</html>

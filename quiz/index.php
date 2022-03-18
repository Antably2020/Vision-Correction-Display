<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Yusei+Magic&display=swap" rel="stylesheet">
    <link href="layout/css/test.css" rel="stylesheet">
    <meta name="og:image" content="https://www.campaignersmiu.com/quiz/layout/png/Campaigners_school_quiz.jpg">
    <meta name="og:title" content="Take the Quiz Now!">
    <meta name="og:description" content="color blindness test">
    <title>color blindness test</title>
  
</head>
<body>
    <div class="wrapper" id="main-app" data-question="1">
        <div class="name-entering" id="name">
            <div class="flex al-c j-c f-wrap ">
              <input id="name-input" class="main-input mr-10" type="text" name="name" placeholder="Enter your name">
             <div class="xbutton" id="name-continue">Continue <img src="layout/svg/right-arrow.svg" alt=""></div>
            </div>
        </div>
        <div id="loading" class="loading">
            <img src="layout/svg/loading.svg" width="100px">
            Loading...
        </div>
        <div class="main-boy" id="main-body">
            <h1 class="title">
                Question <span id="question-number">1</span>:

            </h1>
            <div class="question-body" id="question-body">
                Loading...
            </div>
            <div class="answers" id="answers-container">
                
            </div>
            <div class="xbutton" id="nextButton" onclick="nextQuestion(this);">Next <img src="layout/svg/right-arrow.svg" alt=""></div>
        </div>
        <div id="result-body">
            <img id="result-image" src="">
            <div class="congrats">
                <span id="username"></span>, Your character is
            </div>
            <h1 id="result-name"></h1>
            <p id="result-description"></p>
<br>
            <a href="reset.php" style="text-decoration:none;"><div class="xbutton" style="font-size:20px;float:inherit;margin:0 auto;margin-top:10px;">Try Again</div></a>
            <a href="https://www.instagram.com/campaignersmiu/" class="" ><div class="xbutton" style="font-size:20px;float:inherit;margin:0 auto;margin-top:10px;">instagram</div></a>
            
            <a id="facebook_sharer" href="https://www.facebook.com/sharer/sharer.php?u=example.org" target="_blank">
            <div class="xbutton" style="font-size:20px;float:inherit;margin:0 auto;margin-top:10px;">Facebook</div>
            </a>
            
            
            <div class="logo">
                <img src="layout/png/logo.png">
            </div>
        </div>
    </div>
    <div id="footer">
      
    </div>
    <script src="layout/js/all.js"></script>
</body>
</html>
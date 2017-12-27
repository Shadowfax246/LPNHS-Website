<!DOCTYPE HTML>
<?php 
    session_start();
    include "database.php";
?>
<html>
<head>
    <title>NHS Test - Home</title>
    
    <!--TODO: Icon-->
    
    
    <!--Style Sheets-->
    <link rel="stylesheet" href="baseCSS.css">
    
    <!--Scripts-->
    <!--jQuery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="headerJQuery.js"></script>
</head>

<!--Included via PHP-->
<header id = "header"><?php include "header.php"; ?></header>

<body>
    <!--Fixed Img in Background-->
    <img id = "fixedBGImg" src = "https://www.nhs.us/assets/images/nhs/NHS_header_logo.png">
    
    <!--Home Page Main Img Card-->
    <div id = "frontImg" class = "card" style = "width: 50%;">
	   <img src = "https://www.lphs.org/cms/lib/IL01904769/Centricity/Domain/70/NHS%202017.jpg" style = "width: 100%;">
        <p>Promoting appropriate recognition of students who reflect outstanding accomplishments in the areas of scholarship, leadership, character, and service.</p>
    </div>
    
    <!--Home Page Panels-->
    <div id = "importantInfo" class = "urgent panel">
        <p class = "urgentText">Attention:</p>
        <p class = "urgentText">*IMPORTANT INFO HERE*</p>
    </div>

    <div id = "aboutUs" class = "classic panel">
        <p>About Us...</p>
        <p>*CONTENT*</p>
    </div>
    
    <!--Firebase-->
    <script src="https://www.gstatic.com/firebasejs/4.1.3/firebase.js"></script>
    <script>
        // Initialize Firebase
        var config = {
            apiKey: "AIzaSyByQW8Cyp9yAIMm5xCrNZqF-5kqJ-w6g-4",
            authDomain: "nhs-project-test.firebaseapp.com",
            databaseURL: "https://nhs-project-test.firebaseio.com",
            projectId: "nhs-project-test",
            storageBucket: "nhs-project-test.appspot.com",
            messagingSenderId: "239221174231"
        };
        firebase.initializeApp(config);
    </script>
</body>

<!--Included via PHP-->
<footer id = "footer"><?php include "footer.php"; ?></footer>
</html>
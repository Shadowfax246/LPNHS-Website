<!DOCTYPE HTML>
<?php 
    session_start();
    include "database.php";
?>
<html>
<head>
    <title>NHS Test - My Profile</title>
    
    <!--TODO: Icon-->
    
    
    <!--Style Sheets-->
    <link rel="stylesheet" href="baseCSS.css">
    <style>
        #ProfileDataDiv p{
            text-align: left;
            display: inline-block;
        }
        
        #ProfileDataDiv input{
            text-align: center;
        }
        
        #ProfileDataDiv button{
            margin: 10px;
        }
    </style>
    
    <!--Scripts-->
    <!--jQuery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="headerJQuery.js"></script>
    <script>
        $(document).ready(function(){
            $("#myProfileLink").addClass("active");
        });
    </script>
    <header id = "header"><?php include "header.php"; ?></header>
</head>

<!--Included via JQuery-->
<header id = "header"></header>
    
<body>
    <!--Fixed Img in Background-->
    <img id = "fixedBGImg" src = "https://www.nhs.us/assets/images/nhs/NHS_header_logo.png">
    
    <div class = "classic panel">
        <p>My Information</p>
        <div id = "ProfileDataDiv">
            <!--View only data-->
            <p>Name: </p><p id = "fullName">-</p>
            <br/>
            <p>Hours Worked: </p><p id = "hoursWorked">-</p>
            <br/>
            <p>Vice President: </p><p id = "vicePresident">-</p>
            
            <hr>
            
            <!--Editable Data-->
            <p>Displayed Name:</p>
            <input id = "displayName" placeholder = "e.g. John">
            <br/>
            <button id = "submitChanges" class = "classicColor" type = "button">Submit Changes</button>
            <p id = "status" class = "hidden">-</p>
        </div>
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
    <script src = "updateProfileDataScript.js"></script>
</body>
    
<!--Included via JQuery-->
<footer id = "footer"></footer>
</html>
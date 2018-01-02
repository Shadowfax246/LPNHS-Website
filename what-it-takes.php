<!DOCTYPE HTML>
<?php
	session_start();
    include "database.php";
?>
<html>
<head>
    <title>NHS Test - What It Takes</title>
    
    <!--TODO: Icon-->
    
    
    <!--Style Sheets-->
    <link rel="stylesheet" href="baseCSS.css">
    <style>
        #article{
            margin: 10px auto;
            padding: 10px;
            width: 60%;
        }
        #article p{
            text-align: left;
        }
        #frontImg{
            width: 60%;
            margin: 10px;
            float: right;
        }
        #frontImg p{
            text-align: center;
        }
        #frontImg img{
            width: 100%;
        }
        #applicationRequirements{
            padding: 10px;
            border-left: solid 10px #005da3;
            background-color: white;
            margin: 5px auto;
            width: 90%;
        }
        ul{
            font-family: Bookman, sans-serif;
            font-size: 20px;
        }
        ul li{
            margin: 10px;
        }
    </style>
    
    <!--Scripts-->
    <!--jQuery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="headerJQuery.js"></script>
    <script>
       $(document).ready(function() {
			//specify nav-bar active link
			$("#whatItTakesLink").addClass("active");            
       }); 
    </script>
</head>
    
<!--Included via PHP-->
<header id = "header"><?php include "header.php"; ?></header>

<body>
    <div id = "footerPusher">
        <!--Included via JQuery-->
        <header id = "header"></header>

        <!--Fixed Img in Background-->
        <img id = "fixedBGImg" src = "https://www.nhs.us/assets/images/nhs/NHS_header_logo.png">

        <div id = "article" class = "classic card">
            <h1 style = "color: #005da3">What It Takes to Be a Member</h1>
            <hr style = "width: 90%;">
            <div id = "frontImg" class = "card">
                <img src = "http://www.ispi.org/images/volunteer.png">
                <p>Image Caption</p>
            </div>
            <p>Article here ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</p>
            <div id = "applicationRequirements" class = "classic">
                <h2 style = "color: #005da3">Application Requirements</h2>
                <ul>
                    <li>Req 1</li>
                    <li>Req 2</li>
                </ul>
            </div>
            <p>Finish Article-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</p>
        </div>
    </div>
    <!--Included via JQuery-->
    <footer id = "footer"><?php include 'footer.php';?></footer>
</body>
</html>
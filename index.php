<!DOCTYPE HTML>
<?php 
    session_start();
    include "database.php";

    // Pulling data from "sitecontent" for the About Us and Attention sections

        $sql = "SELECT * FROM sitecontent WHERE ID=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(["id" => 1]);
        $sc = $stmt->fetch(PDO::FETCH_OBJ);
        $aboutus = $sc->aboutUs;
        $attention = $sc->attention;
        $frontImgCaption = $sc->frontImgCaption;

        

?>
<html>

<meta name="HandheldFriendly" content="true" />
<meta name="MobileOptimized" content="320" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, width=device-width, user-scalable=no" />
    <head>
        <title>LPNHS - Home</title>

        <link rel="icon" type="image/png" href="img/nhs_logo.png">
        <link rel="stylesheet" type="text/css" href="baseCSS.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="headerJQuery.js"></script>
        <script>
            $(document).ready(function(){
                $("#homeLink").addClass("active");
            });
        </script>
        <?php
        // Form Submission Confirmation

            if(isset($_GET['formSubmitConfirm']) && $_GET['formSubmitConfirm']==="true"):
            ?>
                <script>
                $(document).ready(function(){
                    $("#banner").animate({backgroundColor: '#00CC00'});
                    $("#banner").animate({backgroundColor: '#fff'});
                });
                </script>
            <?php
                endif;
        ?>
    </head>

    <header id = "header"><?php include "header.php"; ?></header>

    <body>
        
        <img id = "fixedBGImg" src = "img/NHS_logo.png"><!--Fixed Image in Background-->
        
        <div id = "footerPusher">

            <!--Home Page Main Image Card-->

            <div id = "frontImg" class = "card">
                <img src = "img/frontImg.jpg" style = "width: 100%;"><!--NHS picture of students-->
                <p style = "font-style: italic; font-size: 16px;"><?php echo $frontImgCaption; ?></p>
            </div>
        
            <!--Home Page Panels-->

            <?php if(trim($attention)!==""): ?> <!--Checking if Attention is empty, if so then don't display-->
                <div id = "importantInfo" class = "urgent panel">
                    <p class = "urgentText">Attention:</p>
                    <p class = "urgentText"><?php echo $attention; ?></p>
                </div>
            <?php else: endif; ?>
                <div id = "aboutUs" class = "classic panel">
                    <p>About Us...</p>
                    <p><?php echo $aboutus; ?></p>
                </div>
        </div>
    </body>

    <footer id = "footer"><?php include "footer.php"; ?></footer>

</html>
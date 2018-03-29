<!DOCTYPE HTML>
<?php 
    session_start();
	include "database.php";
	
	// Checking if manage is currently in effect

		if(isset($_GET["manage"]) && $_GET["manage"]==="true"){
			include "adminCheck.php";
		}
?>
<html>
	<head>

		<title>LPNHS - Members</title>
		
		<link rel="stylesheet" href="baseCSS.css">
		<link rel="icon" type="image/png" href="img/nhs_logo.png">
		<style>
			table{
				width: 100%;
				font-family: Bookman, sans-serif;
				text-align: center;
			}
			table td{
				padding: 5px 0;
				margin: 0;
			}
			table tr:nth-child(even){background-color: #e8cfa4;}
			#addUserTable th, td{width: 12.5%;}
			input{max-width: 130px;}
		</style>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="headerJQuery.js"></script>
		<script>
		$(document).ready(function() {                 
				//specify nav-bar active link
				$("#membersLink").addClass("active");         
		}); 
		</script>

		<script src="http://code.jquery.com/color/jquery.color.plus-names-2.1.2.min.js"	integrity="sha256-Wp3wC/dKYQ/dCOUD7VUXXp4neLI5t0uUEF1pg0dFnAE="	crossorigin="anonymous"></script>
		<?php

            // Form Submission Confirmation

                if(isset($_GET['formSubmitConfirm'])):
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
		<div id = "footerPusher">

			<img id = "fixedBGImg" src = "img/NHS_logo.png"><!--Fixed Image in Background-->
			
			<div class = "classic panel">
				<p>Leadership</p>
				<div class = "scrollable">
						<?php 
							if(isset($_GET["manage"]) && htmlspecialchars($_GET["manage"])==="true"):
							echo '<form id = "manageLeadersForm" method = "post" action = "updateLeaders.php">';
							endif;
						?>
					<table id = "leadership" class = "listing">
						<?php 
							if(isset($_GET["manage"]) && htmlspecialchars($_GET["manage"])==="true"):
								echo '<script>
									$(document).ready(function(){
										$("#leadership").load("getLeaders.php?manage=true");
									});
									</script>';
							else:
								echo '<script>
									$(document).ready(function(){
										$("#leadership").load("getLeaders.php");
									});
									</script>';
							endif;
						?>
					</table>
						<?php 
							if(isset($_GET["manage"]) && htmlspecialchars($_GET["manage"])==="true"):
							echo '</form>';
							endif;
						?>
				</div>
			</div>
			<div class = "classic panel">
				<p>Students</p>
				<div class = "scrollable">
						<?php 
							if(isset($_GET["manage"]) && htmlspecialchars($_GET["manage"])==="true"):
							echo '<form id = "manageMembersForm" method = "post" action = "updateMembers.php">';
							endif;
						?>
					<table id = "students" class = "listing">
						<?php 
							if(isset($_GET["manage"]) && htmlspecialchars($_GET["manage"])==="true"):
								echo '<script>
									$(document).ready(function(){
										$("#students").load("getMembers.php?manage=true");
									});
									</script>';
							else:
								echo '<script>
									$(document).ready(function(){
										$("#students").load("getMembers.php");
									});
									</script>';
							endif;
						?>
					</table>
						<?php 
							if(isset($_GET["manage"]) && htmlspecialchars($_GET["manage"])==="true"):
							echo '</form>';
							endif;
						?>
				</div>
			</div>
		</div>		
	</body>

	<footer id = "footer"><?php include 'footer.php';?></footer>

</html>
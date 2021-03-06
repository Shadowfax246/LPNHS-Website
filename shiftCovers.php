<!DOCTYPE HTML>
<?php 
    session_start();
    include "database.php";
    include "loginCheck.php";
	include "adminCheck.php";
?>
<html>
<meta name="HandheldFriendly" content="true" />
<meta name="MobileOptimized" content="320" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, width=device-width, user-scalable=no" />
    <head>

        <title>LP NHS - Shift Cover Requests</title>

        <link rel="stylesheet" href="baseCSS.css">
        <link rel="icon" type="image/png" href="img/nhs_logo.png">
        <style>
            table tr:nth-child(even){background-color: #e8cfa4;}
            #shiftCoverRequestsPanel div{
                border-top-left-radius: 15px;
                border-top-right-radius: 15px;
            }
            #informationContainer{padding: 10px;}
            #informationContainer div table{width: 100%;}
            @media only screen and (min-width: 629px){
                #informationContainer form table  th, td{
                    padding: 5px;
                    font-family: Bookman, sans-serif;
                    font-size: 18px;
                    text-align: center;
                    
                }
                #shiftCoverRequestsPanel{padding: 0;overflow-y: auto;}
            }
            @media only screen and (max-width: 630px) {
                #informationContainer form table  th, td{
                    font-family: Bookman, sans-serif;
                    font-size: 2.5vmin;
                    text-align: center;
                }
                #shiftCoverRequestsPanel{padding: 0;margin: 4.5vmin;overflow-y: auto;}
            }
        </style>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="headerJQuery.js"></script>

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

    <header id = "header"><?php include 'header.php'; ?></header>
        
    <body>
        <div id = "footerPusher">

        <img id = "fixedBGImg" src = "img/NHS_logo.png"><!--Fixed Image in Background-->

            <div id = "shiftCoverRequestsPanel" class = "classic panel">
                <div id = "informationContainer">
                    <!--Content loaded through PHP-->
                    <p>Shift Cover Requests</p>
                    <div id = "shiftCoverRequests">
                        <form method = "post" action = "coverShifts.php">
                            <table id = "shiftCoverRequestsTable">
                                <?php
                                    $sql = "SELECT * FROM shiftcovers WHERE Agreed=1";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute();
                                    $count = $stmt->rowCount();
                                    $data = $stmt->fetch(PDO::FETCH_OBJ);
                                    
                                    echo '<tr>
                                        <th>Event Name</th>
                                        <th>Students\' Names</th>
                                        <th>Shift Date</th>
                                        <th>Shift Time</th>
                                        <th>Accept</th>
                                        </tr>';

                                    if($count===0){
                                        echo '<tr><td colspan = "5"><p>No shift cover requests found</p></td></tr>';
                                    }
                                    
                                    for($i=0; $i<$count; $i++){
                                        //Find Event Name
                                        $sql = "SELECT * FROM eventshift WHERE ShiftID=:shiftID";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute(['shiftID'=>$data->ShiftID]);
                                        $event = $stmt->fetch(PDO::FETCH_OBJ);

                                        $sql = "SELECT * FROM events WHERE EventID=:eventID";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute(['eventID'=>$event->EventID]);
                                        $eventData = $stmt->fetch(PDO::FETCH_OBJ);

                                        //Find Students' Names
                                        $sql = "SELECT * FROM students WHERE StudentID=:studentID";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute(['studentID'=>$data->CovererID]);
                                        $covererData = $stmt->fetch(PDO::FETCH_OBJ);

                                        $sql = "SELECT * FROM students WHERE StudentID=:studentID";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute(['studentID'=>$data->RequesterID]);
                                        $requesterData = $stmt->fetch(PDO::FETCH_OBJ);

                                        //Find Shift Data
                                        $sql = "SELECT * FROM shifts WHERE ShiftID=:shiftID";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute(['shiftID'=>$data->ShiftID]);
                                        $shiftData = $stmt->fetch(PDO::FETCH_OBJ);

                                        echo '<tr>';

                                        //Send hidden data to be used in coverShift.php
                                        echo '<input type = "hidden" name = "requesterID[',$i,']" value = "', $data->RequesterID, '">';
                                        echo '<input type = "hidden" name = "covererID[',$i,']" value = "', $data->CovererID, '">';
                                        echo '<input type = "hidden" name = "shiftID[',$i,']" value = "', $data->ShiftID, '">';
                                        echo '<input type = "hidden" name = "eventID[',$i,']" value = "', $eventData->EventID, '">';

                                        echo '<td>', $eventData->Name, '</td>';
                                        echo '<td>', $covererData->FirstName, ' ', $covererData->LastName, ' covering for ', $requesterData->FirstName, ' ', $requesterData->LastName, '</td>';
                                        echo '<td>', date('m/d/Y', strtotime($shiftData->Date)), '</td>';
                                        echo '<td>', $shiftData->StartTime, ' to ', $shiftData->EndTime, '</td>';
                                        echo '<td><input name = "submit[', $i,']" type = "image" src = "img/greenCheckMark.png" height = "30px" width = "30px" style = "margin-top: 5px;"></td>';
                                        echo '</tr>';
                                    }
                                ?>
                            </table>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </body>

    <footer id = "footer"><?php include "footer.php"; ?></footer>

</html>
<!DOCTYPE HTML>
<?php
    session_start();
    require "database.php";
    require "adminCheck.php";
?>
<html>

<meta name="HandheldFriendly" content="true" />
<meta name="MobileOptimized" content="320" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, width=device-width, user-scalable=no" />
    <head>

        <title>LPNHS - Edit Event</title>
        
        <link rel="stylesheet" href="baseCSS.css">
        <link rel="icon" type="image/png" href="img/nhs_logo.png">
        <style>
            table tr:nth-child(even){background-color: #e8cfa4;}
            #eventsPanel div{
                border-top-left-radius: 15px;
                border-top-right-radius: 15px;
            }
            #tabs{background-color: #e8cfa4; /*darkened moccasin*/}
            #tabs div{
                display: inline-block;
                margin: 0;
                width: calc(50% - 2px);
                background-color: #ffebcd; /*blanched almond*/
            }
            #tableheader{font-size: 20px;}
            @media only screen and (min-width: 629px){
                #mainPanel table th, td{
                    padding: 5px;
                    font-family: Bookman, sans-serif;
                    font-size: 18px;
                    text-align: center;
                    
                }
                #eventsPanel{padding: 0;overflow-y: auto;}
            }
            @media only screen and (max-width: 630px) {
                #mainPanel table th, td{
                    font-family: Bookman, sans-serif;
                    font-size: 2.5vmin;
                    text-align: center;
                }
                #eventsPanel{padding: 0;margin: 4.5vmin;overflow-y: auto;}
            }
        </style>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
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

            <img id = "fixedBGImg" src = "img/NHS_logo.png"> <!--Fixed image in background-->
            
            <div id = "mainPanel" class = "classic panel">
                <p style = "text-align: center;">Edit Event</p>
                <hr>
                <form method = "post" action = "edit-eventpg1.php">
                    <table id = "upcomingEventsTable" style="width:100%;">
                    
                            <?php 

                                // Pulling data from database

                                    $sql = "SELECT * FROM events";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute();
                                
                                    $eventCount = $stmt->rowCount();
                                    $eventIDs = array();
                                    array_push($eventIDs, $stmt->fetchAll(PDO::FETCH_COLUMN, 0));

                                // Putting data into HTML elements - Tables Upcoming Events and Event History

                                    echo '<p colspan="3" id = "tableheader">Upcoming Events</p>';
                                    echo '<tr>
                                        <th>Event Name</th>
                                        <th>Date</th>
                                        <th>Location</th>
                                        <th>Edit</th>
                                        <th>Remove</th>
                                        </tr>';

                                    // Looping for every event inside Upcoming Events

                                        for($i = 0; $i<$eventCount; $i++){

                                            // Pulling data from database for every event

                                                $sql = "SELECT * FROM events WHERE EventID=:eventID AND EndDate >= NOW()";
                                                $stmt = $pdo->prepare($sql);
                                                $stmt->execute(["eventID" => $eventIDs[0][$i]]);
                                                $data = array();
                                                $data = $stmt->fetchAll();
                                
                                            // If data was pulled, Putting data into HTML elements

                                                
                                                if(count($data)>0){
                                                    $formatted_startDate = date('m/d/Y', strtotime($data[0][3]));
                                                $formatted_endDate = date('m/d/Y', strtotime($data[0][4]));
                                                    echo '<tr>';
                                                    echo '<input name = "eventID[', $i,']" type = "hidden" value = "', $data[0][0],'">';
                                                    echo '<td title ="', $data[0][2] ,'">', $data[0][1], '</td>';
                                                    if($data[0][3]===$data[0][4]){echo '<td>', $formatted_startDate, '</td>';}
                                                    else{echo '<td>', $formatted_startDate, ' to ', $formatted_endDate, '</td>';}
                                                    echo '<td><a href="https://www.maps.google.com/maps/search/?api=1&query=', str_replace(" ", "+", $data[0][5]),'+IL" target = "_blank">', $data[0][5], '</a></td>';
                                                    echo '<td><input name = "edit[', $i,']" value = "Edit" class = "classicColor" type = "submit"></td>';
                                                    echo '<td><input name = "remove[', $i,']" value = "Remove" class = "classicColor" type = "submit" onclick="return confirm(\'Are you sure?\')" style = "margin-right: 0px; background-color:red"></td>';
                                                    echo '</tr>';
                                                }
                                        } 
                                        
                                    echo '</table>
                                          <p colspan="3" id = "tableheader">Event History</p>
                                          <table  id = "upcomingEventsTable" style="width:100%;">';
                                    echo '<tr>
                                          <th>Event Name</th>
                                          <th>Date</th>
                                          <th>Location</th>
                                          <th>Edit</th>
                                          <th>Remove</th>
                                          </tr>';

                                    // Looping for every event inside Event History

                                        for($i = 0; $i<$eventCount; $i++){

                                            // Pulling data from database for every event

                                                $sql = "SELECT * FROM events WHERE EventID=:eventID AND EndDate < NOW()";
                                                $stmt = $pdo->prepare($sql);
                                                $stmt->execute(["eventID" => $eventIDs[0][$i]]);
                                                $data = array();
                                                $data = $stmt->fetchAll();
                                
                                            // If data was pulled, Putting data into HTML elements

                                                
                                                if(count($data)>0){
                                                    $formatted_startDate = date('m/d/Y', strtotime($data[0][3]));
                                                $formatted_endDate = date('m/d/Y', strtotime($data[0][4]));
                                                    echo '<tr>';
                                                    echo '<input name = "eventID[', $i,']" type = "hidden" value = "', $data[0][0],'">';
                                                    echo '<td title ="', $data[0][2] ,'">', $data[0][1], '</td>';
                                                    if($data[0][3]===$data[0][4]){echo '<td>', $formatted_startDate, '</td>';}
                                                    else{echo '<td>', $formatted_startDate, ' to ', $formatted_endDate, '</td>';}
                                                    echo '<td><a href="https://www.maps.google.com/maps/search/?api=1&query=', str_replace(" ", "+", $data[0][5]),'+IL" target = "_blank">', $data[0][5], '</a></td>';
                                                    echo '<td><input name = "edit[', $i,']" value = "Edit" class = "classicColor" type = "submit"></td>';
                                                    echo '<td><input name = "remove[', $i,']" value = "Remove" class = "classicColor" type = "submit" onclick="return confirm(\'Are you sure?\')" style = "margin-right: 0px; background-color:red"></td>';
                                                    echo '</tr>';
                                                }
                                        }
                            ?>
                        </table>
                    </form>
            </div>

        </div>
    </body>

    <footer id = "footer"><?php include 'footer.php';?></footer>

</html>
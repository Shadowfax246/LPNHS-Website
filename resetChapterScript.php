<?php
    session_start();
    require 'database.php';
    require 'adminCheck.php';
    
    include 'loading.html'; // Display loading screen

    // Random string generator for passwords
    function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $keyspace = str_shuffle($keyspace);
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

    // Send out mail
    function mailIntro($email, $password){
        $message = '<!DOCTYPE HTML>
        <html>
            <head>

            </head>
            <body style="margin: 0; padding: 0;">
                <div id="banner" style="height: 150px; width: 100%; background-color: #333; position: absolute; top: 0;">
                    <img src="http://34.223.226.43/lpnhs/img/NHS-LOGO-TM.png" height = "130" style = "margin: 10px 5px; float: left;">
                    <h1 style="font-family: Bookman, sans-serif; font-size: 40px; color: #fff; margin: 55px auto; text-align: center;">Lake Park National Honor Society</h1>
                </div>
                <div id="content" style="height: 500px; width: 100%; background-color: #005da3; position: absolute; top: 150px; padding: 0 20px;">
                    <p style="font-family: Bookman, sans-serif; font-size: 28px; color: #fff; text-align: center;">Welcome to the Lake Park National Honor Society!</p>
                    <p style="font-family: Bookman, sans-serif; font-size: 18px; color: #fff;">An account has already been created for you with the following login:</p>
                    <ul>
                        <li style="font-family: Bookman, sans-serif; font-size: 18px; color: #fff;">Username: '.$email.'</li>
                        <li style="font-family: Bookman, sans-serif; font-size: 18px; color: #fff;">Password: '.$password.'</li>
                    </ul>
                    <p style="font-family: Bookman, sans-serif; font-size: 18px; color: #fff;">Please log in at <a href="http://34.223.226.43/lpnhs/login.php" style="color: #fff;">34.223.226.43/lpnhs/login</a>. You may change your password at any time by accessing the profile page.</p>
                </div>
            </body>
        </html>';
        $headers = array(
            'From'=>'no-reply@34.223.226.43'
        );
        
        //mail($email, 'Welcome to LPNHS', $message, $headers);
    }

    if(isset($_POST["submit"])){
        $errors= array();
        $file_name = $_FILES['studentInfoCSV']['name'];
        $file_size =$_FILES['studentInfoCSV']['size'];
        $file_tmp =$_FILES['studentInfoCSV']['tmp_name'];
        $file_type=$_FILES['studentInfoCSV']['type'];
        $split = explode('.', $_FILES['studentInfoCSV']['name']);
        $file_ext=strtolower(end($split));
        
        $extensions= array("csv");
        
        if(in_array($file_ext,$extensions)=== false){
            $errors[]="Extension not allowed, please ensure the file is a .csv.";
        }
        
        if($file_size > 2097152){
            $errors[]='File size must be less than 2 MB';
        }
        
        if(empty($errors)==true){
            move_uploaded_file($file_tmp, "data/studentInfoCSV.csv");
        }else{
            print_r($errors);
        }

        //Reset Chapter
        $studentSQL = '';
        if (($handle = fopen("data/studentInfoCSV.csv", "r")) !== FALSE) {
            $iteration = 0;
            $columnTitles = array();
            // Creates Query

            //List of acceptable names for each field (in lower case)
            $studentIDColumnNames = array("student id", "id", "studentid");
            $firstNameColumnNames = array("first name", "firstname", "first");
            $lastNameColumnNames = array("last name", "lastname", "last");
            $emailColumnNames = array("email", "email address", "emailaddress");
            while (($data = fgetcsv($handle, ",")) !== FALSE) {
                if($iteration!==0){ //Doesn't read the first line (which contains the column headings)
                    $email = "";
                    $password = random_str(10);
                    //append student data to query
                    $num = count($data);
                    $studentSQL.="(";
                    for ($i=0; $i < $num; $i++) {
                        $studentSQL.=$data[$i];
                        $studentSQL.=", ";

                        if(in_array(trim(strtolower($columnTitles[$i])), $emailColumnNames)){
                            $email = $data[$i];
                        }
                    }
                    $studentSQL.=password_hash($password, PASSWORD_DEFAULT)."), ";
                    mailIntro($email, $password);
                }
                else{
                    $columnTitles = $data;
                }
                $iteration++;
            }
            //Identifies order of information in the CSV file
            $sqlColumns = "";
            for($i = 0; $i<count($columnTitles); $i++){
                if(in_array(trim(strtolower($columnTitles[$i])), $studentIDColumnNames)){
                    $sqlColumns.="StudentID, ";
                }
                else if(in_array(trim(strtolower($columnTitles[$i])), $firstNameColumnNames)){
                    $sqlColumns.="FirstName, ";
                }
                else if(in_array(trim(strtolower($columnTitles[$i])), $lastNameColumnNames)){
                    $sqlColumns.="LastName, ";
                }
                else if(in_array(trim(strtolower($columnTitles[$i])), $emailColumnNames)){
                    $sqlColumns.="Email, ";
                }
            }
            $sqlColumns.="PasswordHash"; 
            $studentSQL = "INSERT INTO students (".$sqlColumns.") VALUES ".$studentSQL;
            $studentSQL = substr($studentSQL, 0, -2); //Gets rid of last ', ' from $studentSQL
            fclose($handle);
        }
        
        //TESTING:
        $studentSQL = 'INSERT INTO students (StudentID, LastName, FirstName, Email, PasswordHash) VALUES (555555, Query, Test, test@students.lphs.org, $2y$10$mcli8tyeZclGxoSYe3CBhuqfZoNMdrNJWRkr0k.Hgtoor6MhG5F3i)';
        $stmt = $pdo->prepare($studentSQL);
        if($stmt->execute()){
            echo 'success';
        }
        else{
            echo 'failure';
        }
    }
?>
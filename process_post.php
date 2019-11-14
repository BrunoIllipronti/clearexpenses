<?php
    session_start();
    print_r($_POST);
    unset($_SESSION["Error"]);

    //================================================== LOG IN VALIDATIONS ==================================================
	if (!empty($_POST["login"]) && !empty($_POST["pw"])){

	    //  Validate Login action
        if ( $_POST["command"] == "Login" ) {

            // User id / pw sanitization
            $login   = filter_input(INPUT_POST, 'login',   FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $pw      = filter_input(INPUT_POST, 'pw', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            try{
                require 'connect.php';
                $query = "SELECT userid, name, visualizationsetting, imagepath FROM users WHERE UserName = '$login' AND Password = '$pw'";
                $statement = $db->prepare($query); // Returns a PDOStatement object.
                $statement->execute(); // The query is now executed.

                $user = $statement->fetch();

                // If There are results, set User session
                if (is_array($user) == 1) {
                    $_SESSION["User"] = $user;
                }
                else {    // If User doesnt exist...
                    $_SESSION["User"] = "UserError";
                }

                header('Location: index.php');
            }
            catch (PDOException $e) {
                print "Error: " . $e->getMessage();
                die(); // Force execution to stop on errors.
            }
        }

	}

	// Logoff command - Clean session
    if ($_POST["command"] == "Logoff" || $_POST["command"] == "Try Again"){
        unset ($_SESSION["User"]);
        header('Location: index.php');
    }

    //================================================== ACCOUNT VALIDATIONS ==================================================
    if ( $_POST["command"] == "Edit Account" || $_POST["command"] == "Create Account" ){

        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $lastname  = filter_input(INPUT_POST, 'lastname',  FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $jobtitle  = filter_input(INPUT_POST, 'jobtitle',  FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email     = filter_input(INPUT_POST, 'email',  FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $user      = filter_input(INPUT_POST, 'user',   FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pw        = filter_input(INPUT_POST, 'pw',     FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $validation_array = [];

        ##### If first name has numbers or it is null #####
        if( preg_match('#[\d]#', $firstname) || is_numeric($firstname[0]) || $firstname == "" ){
            array_push($validation_array, 0);
        } else {
            array_push($validation_array, 1);
        }

        ##### If last name has numbers or it is null #####
        if( preg_match('~[\d]~', $lastname) || is_numeric($lastname[0]) || $lastname == "" ){
            array_push($validation_array, 0);
        } else {
            array_push($validation_array, 1);
        }

        ##### Invalid email address #####
        if ( !filter_var($email, FILTER_VALIDATE_EMAIL) || $email == "" ) {
            array_push($validation_array, 0);
        } else {
            array_push($validation_array, 1);
        }

        ##### If user starts with number or it is null #####
        if( $user == "" || strpos($user, ' ') !== false || is_numeric($user[0]) ){
            array_push($validation_array, 0);
        } else {
            array_push($validation_array, 1);
        }

        ##### If Password has spaces or it is null #####
        if( $pw == "" || strpos($pw, ' ') !== false ){
            array_push($validation_array, 0);
        } else {
            array_push($validation_array, 1);
        }

        print_r($validation_array);

        // Check if any error happened
        foreach ($validation_array as &$value) {
            echo "Iteration: ".$value;
            if ($value == 0){
                $_SESSION["Error"] = $validation_array;
                break;
            }
        }

        print_r($_SESSION["Error"]);

        header('Location: account.php');

    }


    //================================================== ACCOUNT VALIDATIONS ==================================================
    if ( $_POST["command"] == "Edit Account" || $_POST["command"] == "Create Account" ) {

        //Import PHPMailer classes into the global namespace
        /*
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        require_once 'vendor/autoload.php';
        */

        require 'vendor/phpmailer/phpmailer/srcPHPMailerAutoload.php';

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';  //mailtrap SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = '33b113d3b5d5b8';   //username
            $mail->Password = 'f69ac72b579588';   //password
            $mail->Port = 465;                    //smtp port

            $mail->setFrom('noreply@artisansweb.net', 'Artisans Web');
            $mail->addAddress('sajid@artisansweb.net', 'Sajid');

            $mail->isHTML(true);

            $mail->Subject = 'Mailtrap Email';
            $mail->Body = 'Hello User, <p>This is a test mail sent through Mailtrap SMTP</p><br>Thanks';

            if (!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo 'Message has been sent';
            }
        } catch (Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>ClearExpenses - Process Post</title>
        <link rel="stylesheet" href="style.css" type="text/css">
    </head>
    <body>
        <h1>Post Page</h1>
    </body>
</html>
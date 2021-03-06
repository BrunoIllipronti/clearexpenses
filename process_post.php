<?php
    //***** Composer - PHPMailer *****
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'vendor/autoload.php';
    $email = new PHPMailer(TRUE);
    //*******************************//

    session_start();
    print_r($_POST);
    echo '<br/>';
    echo '<br/>';
    //print_r($_SESSION["User"]);
    echo '<br/>';
    echo '<br/>';
    print_r($_GET);
    $command = filter_input(INPUT_GET, 'command', FILTER_SANITIZE_URL);
    $firstname = filter_input(INPUT_GET, 'firstname', FILTER_SANITIZE_URL);
    echo $command;
    echo $firstname;
    echo '<br/>';
    echo '<br/>';

    //================================================== LOG IN VALIDATIONS ==================================================
	if (!empty($_POST["login"]) && !empty($_POST["pw"])){

	    //  Validate Login action
        if ( $_POST["command"] == "Login" ) {

            // User id / pw sanitization
            $login   = filter_input(INPUT_POST, 'login',   FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $pw      = filter_input(INPUT_POST, 'pw', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            try{
                require 'connect.php';
                $query = "SELECT userid, firstname, jobtitle, email, lastname, visualizationsetting, imagepath FROM users WHERE UserName = '$login' AND Password = '$pw'";
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

    //================================================== ACCOUNT VALIDATIONS (PASSWORD CHANGE) ==================================================

    if ($_POST["command"] == "Change Password"){

        $pw        = filter_input(INPUT_POST, 'pw',     FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pw2       = filter_input(INPUT_POST, 'pw2',     FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $validation_array = [];

        ##### If Password has spaces or it is null #####
        if($pw == $pw2){
            if( $pw == "" || strpos($pw, ' ') !== false ){
                array_push($validation_array, 0);
            } else {
                array_push($validation_array, 1);
            }
        }
        else {
            array_push($validation_array, 2);
        }

        print_r($validation_array);

        // Check if any error happened
        foreach ($validation_array as &$value) {
            echo "Iteration: ".$value;
            if ($value == 0 || $value == 2){
                $_SESSION["ErrorPw"] = $validation_array;
                break;
            }
        }

        if ( !isset($_SESSION["ErrorPw"]) && $_POST["command"] == "Change Password" ){

            try{
                require 'connect.php';

                $userid = $_SESSION["User"]["userid"];

                $query = "UPDATE users SET Password=:pw WHERE UserId = :userid";
                $statement = $db->prepare($query); // Returns a PDOStatement object.
                $statement->bindValue(':pw', $pw);
                $statement->bindValue(':userid', $userid, PDO::PARAM_INT);

                // The query is now executed.
                $statement->execute();
                $_SESSION["Success"] = "<script type='text/javascript'>alert('Password Updated with Success!');</script>";
            }
            catch (PDOException $e) {
                $_SESSION["Success"] = "<script type='text/javascript'>alert('Error when updating the Password: \" . $e->getMessage()');</script>";
            }
        }

        header('Location: account.php');

    }

    //================================================== ACCOUNT VALIDATIONS (OTHERS) ==================================================
    if ( $_POST["command"] == "Edit Account" || $_POST["command"] == "Create Account" ){

        if ( $_POST["command"] == "Create Account" ) {
            $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $lastname  = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $jobtitle  = filter_input(INPUT_POST, 'jobtitle', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email     = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $user      = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $pw        = filter_input(INPUT_POST, 'pw', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $pw2       = filter_input(INPUT_POST, 'pw2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $validation_array = [];

            ##### If first name has numbers or it is null #####
            if (preg_match('#[\d]#', $firstname) || is_numeric($firstname[0]) || $firstname == "") {
                array_push($validation_array, 0);
            } else {
                array_push($validation_array, 1);
            }

            ##### If last name has numbers or it is null #####
            if (preg_match('~[\d]~', $lastname) || is_numeric($lastname[0]) || $lastname == "") {
                array_push($validation_array, 0);
            } else {
                array_push($validation_array, 1);
            }

            ##### Invalid email address #####
            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $email == "") {
                array_push($validation_array, 0);
            } else {
                array_push($validation_array, 1);
            }

            ##### If user starts with number or it is null #####
            if ($user == "" || strpos($user, ' ') !== false || is_numeric($user[0])) {
                array_push($validation_array, 0);
            } else {
                array_push($validation_array, 1);
            }

            ##### If Password has spaces or it is null #####
            if ($pw == $pw2) {
                if ($pw == "" || strpos($pw, ' ') !== false) {
                    array_push($validation_array, 0);
                } else {
                    array_push($validation_array, 1);
                }
            } else {
                array_push($validation_array, 2);
            }


            print_r($validation_array);

            // Check if any error happened
            foreach ($validation_array as &$value) {
                echo "Iteration: " . $value;
                if ($value == 0 || $value == 2) {
                    $_SESSION["Error"] = $validation_array;
                    break;
                }
            }
        }
        elseif ($_POST["command"] == "Edit Account") {

            $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $lastname  = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $jobtitle  = filter_input(INPUT_POST, 'jobtitle', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email     = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $validation_array = [];

            ##### If first name has numbers or it is null #####
            if (preg_match('#[\d]#', $firstname) || is_numeric($firstname[0]) || $firstname == "") {
                array_push($validation_array, 0);
            } else {
                array_push($validation_array, 1);
            }

            ##### If last name has numbers or it is null #####
            if (preg_match('~[\d]~', $lastname) || is_numeric($lastname[0]) || $lastname == "") {
                array_push($validation_array, 0);
            } else {
                array_push($validation_array, 1);
            }

            ##### Invalid email address #####
            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $email == "") {
                array_push($validation_array, 0);
            } else {
                array_push($validation_array, 1);
            }

            print_r($validation_array);

            // Check if any error happened
            foreach ($validation_array as &$value) {
                echo "Iteration: " . $value;
                if ($value == 0 || $value == 2) {
                    $_SESSION["Error"] = $validation_array;
                    break;
                }
            }
        }


        //********************************** PDO Operations **********************************************//

        // If there is no error with User info... Create User
        if ( !isset($_SESSION["Error"]) && $_POST["command"] == "Create Account" ){

            try{
                require 'connect.php';
                $query = "INSERT INTO users (FirstName, LastName, JobTitle, Email, UserName, Password) VALUES ( :firstname, :lastname, :jobtitle, :email, :user, :pw )";

                $statement = $db->prepare($query); // Returns a PDOStatement object.
                $statement->bindValue(':firstname', $firstname);
                $statement->bindValue(':lastname', $lastname);
                $statement->bindValue(':jobtitle', $jobtitle);
                $statement->bindValue(':email', $email);
                $statement->bindValue(':user', $user);
                $statement->bindValue(':pw', $pw);

                // The query is now executed.
                $statement->execute();

                $_SESSION["Success"] = "<script type='text/javascript'>alert('User Created with Success!');</script>";
                //header('Location: account.php');
            }
            catch (PDOException $e) {
                $_SESSION["Success"] = "<script type='text/javascript'>alert('Error when creating the user: \" . $e->getMessage()');</script>";
            }

        }
        elseif ( !isset($_SESSION["Error"]) && $_POST["command"] == "Edit Account" ) {

            try{
                require 'connect.php';

                $userid = $_SESSION["User"]["userid"];

                $query = "UPDATE users SET FirstName=:firstname,LastName=:lastname,JobTitle=:jobtitle,Email=:email WHERE UserId = :userid";
                $statement = $db->prepare($query); // Returns a PDOStatement object.
                $statement->bindValue(':firstname', $firstname);
                $statement->bindValue(':lastname', $lastname);
                $statement->bindValue(':jobtitle', $jobtitle);
                $statement->bindValue(':email', $email);
                $statement->bindValue(':userid', $userid, PDO::PARAM_INT);

                // The query is now executed.
                $statement->execute();
                $_SESSION["Success"] = "<script type='text/javascript'>alert('User Updated with Success!');</script>";
            }
            catch (PDOException $e) {
                $_SESSION["Success"] = "<script type='text/javascript'>alert('Error when updating the User: \" . $e->getMessage()');</script>";
            }

        }

        header('Location: account.php');
    }


    //================================================== ACCOUNT VALIDATIONS ==================================================
    if ( $_POST["command"] == "Contact") {

        $name   = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $tel    = filter_input(INPUT_POST, 'tel',  FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email  = filter_input(INPUT_POST, 'email',  FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $needs  = filter_input(INPUT_POST, 'needs',  FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        echo getcwd().'/vendor/phpmailer/phpmailer/src/PHPMailerAutoload.php';

        // create a new object
        $mail = new PHPMailer();
        // configure an SMTP
        $mail->isSMTP();

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';  //mailtrap SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = '33b113d3b5d5b8';   // mailtrap.io username
            $mail->Password = 'f69ac72b579588';   // mailtrap.io password
            $mail->Port = 465;                    // smtp port

            $mail->setFrom($email, $name); // from
            $mail->addAddress('admin@clearexpenses.net', 'Bruno Illipronti'); // to

            $mail->isHTML(true);

            $mail->Subject = 'Support - Contact Request';
            $mail->Body = '===== Clear Expenses ===== <p>'.$needs.'</p><br>Thank you '.$name." / ".$tel;

            if (!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
                $_SESSION["Error"] = 'Message could not be sent - Mailer Error: '.$mail->ErrorInfo;
                header('Location: contact.php');
            } else {
                echo 'Message has been sent';
                $_SESSION["Error"] = 'Message has been sent';
                header('Location: contact.php');
            }
        } catch (Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            $_SESSION["Error"] = 'Message could not be sent - Mailer Error: '.$mail->ErrorInfo;
            header('Location: contact.php');
        }
    }

    //================================================== POST MESSAGE VALIDATIONS ==================================================
    if ( $_POST["command"] == "Send >") {

        $comment   = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $postid    = filter_input(INPUT_POST, 'postid', FILTER_SANITIZE_NUMBER_INT);
        $userid = $_SESSION["User"]["userid"];

        if (empty($comment)){
            $_SESSION["Error"] = 'Message can not be null';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        else {

            try{
                require 'connect.php';
                $query = "INSERT INTO postmessages (PostId, UserId, MessageDate, MessageContent) VALUES ( :postid, :userid, now(), :comment )";

                $statement = $db->prepare($query); // Returns a PDOStatement object.
                $statement->bindValue(':postid', $postid);
                $statement->bindValue(':userid', $userid, PDO::PARAM_INT);
                $statement->bindValue(':comment', $comment);

                // The query is now executed.
                $statement->execute();
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
            catch (PDOException $e) {
                $_SESSION["Error"] = "<script type='text/javascript'>alert('Error when creating the comment: \" . $e->getMessage()');</script>";
            }

        }
    }

    if ( $_POST["command"] == "Delete Comment") {

        $commentid    = filter_input(INPUT_POST, 'messageid', FILTER_SANITIZE_NUMBER_INT);

        try{
            require 'connect.php';
            $query = "DELETE FROM postmessages WHERE MessageId = :commentid";
            $statement = $db->prepare($query); // Returns a PDOStatement object.
            $statement->bindValue(':commentid', $commentid, PDO::PARAM_INT);

            // The query is now executed.
            $statement->execute();
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        catch (PDOException $e) {
            $_SESSION["Error"] = "<script type='text/javascript'>alert('Error when deleting the comment: \" . $e->getMessage()');</script>";
        }
    }
    //================================================== POST VALIDATIONS ==================================================

    if ( $_POST["command"] == "Update Post") {

        $title    = filter_input(INPUT_POST, 'title',   FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $content  = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $postid   = filter_input(INPUT_POST, 'postid',  FILTER_SANITIZE_NUMBER_INT);

        try{
            require 'connect.php';

            $query = "UPDATE posts SET Title=:title, PostContent=:content WHERE PostId = :postid";
            $statement = $db->prepare($query); // Returns a PDOStatement object.
            $statement->bindValue(':title', $title);
            $statement->bindValue(':content', $content);
            $statement->bindValue(':postid', $postid);

            // The query is now executed.
            $statement->execute();
            $_SESSION["Error"] = "<script type='text/javascript'>alert('Post Updated with Success!');</script>";
            header('Location: show.php?id='.$postid);
        }
        catch (PDOException $e) {
            $_SESSION["Error"] = "<script type='text/javascript'>alert('Error when updating the Password: \" . $e->getMessage()');</script>";
            header('Location: show.php?id='.$postid);
        }

    }

    if ( $_POST["command"] == "Delete Post") {

        $postid   = filter_input(INPUT_POST, 'postid',  FILTER_SANITIZE_NUMBER_INT);

        try{
            require 'connect.php';
            $query = "DELETE FROM posts WHERE PostId = :postid";
            $statement = $db->prepare($query); // Returns a PDOStatement object.
            $statement->bindValue(':postid', $postid, PDO::PARAM_INT);

            // The query is now executed.
            $statement->execute();
            header('Location: index.php');
        }
        catch (PDOException $e) {
            header('Location: index.php');
        }

    }

    if ( $_POST["command"] == "Create Post") {

        $title   = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $content   = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $userid = $_SESSION["User"]["userid"];

        // If Title and Post Content are filled
        if (!empty($content) && !empty($title)){

            try{
                require 'connect.php';
                $query = "INSERT INTO posts (UserId, Title, PostDate, PostContent) VALUES ( :userid, :title, now(), :content )";

                $statement = $db->prepare($query); // Returns a PDOStatement object.
                $statement->bindValue(':userid',  $userid, PDO::PARAM_INT);
                $statement->bindValue(':title',   $title);
                $statement->bindValue(':content', $content);

                // The query is now executed.
                $statement->execute();
                header('Location: index.php');
            }
            catch (PDOException $e) {
                header('Location: index.php');
            }
        }
        else {
            $_SESSION["Error"] = 'Post Title or Content can not be null';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
    //================================================== ACCOUNT USER TABLE VALIDATIONS ==================================================
    if ( $command == "TableUserUpdate") {

        $userid    = filter_input(INPUT_GET, 'userid', FILTER_SANITIZE_NUMBER_INT);
        $firstname = filter_input(INPUT_GET, 'firstname', FILTER_SANITIZE_URL);
        $lastname  = filter_input(INPUT_GET, 'lastname', FILTER_SANITIZE_URL);
        $jobtitle  = filter_input(INPUT_GET, 'jobtitle', FILTER_SANITIZE_URL);
        $email     = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_URL);
        $username  = filter_input(INPUT_GET, 'usern', FILTER_SANITIZE_URL);
        $pw        = filter_input(INPUT_GET, 'pwd', FILTER_SANITIZE_URL);

        echo $userid.$firstname.$lastname.$jobtitle.$email.$username.$pw;

        try{
            require 'connect.php';

            $query = "UPDATE users SET FirstName=:firstname, LastName=:lastname, JobTitle=:jobtitle, Email=:email, UserName=:username, Password=:pw WHERE UserId = :userid";
            $statement = $db->prepare($query); // Returns a PDOStatement object.
            $statement->bindValue(':firstname', $firstname);
            $statement->bindValue(':lastname', $lastname);
            $statement->bindValue(':jobtitle', $jobtitle);
            $statement->bindValue(':email', $email);
            $statement->bindValue(':username', $username);
            $statement->bindValue(':pw', $pw);
            $statement->bindValue(':userid', $userid, PDO::PARAM_INT);

            // The query is now executed.
            $statement->execute();
            $_SESSION["Message"] = "<script type='text/javascript'>alert('User Updated with Success!');</script>";
            //header('Location: account.php');
        }
        catch (PDOException $e) {
            $_SESSION["Message"] = "<script type='text/javascript'>alert('Error when updating the User: \" . $e->getMessage()');</script>";
            header('Location: account.php');
        }

    }

    if ( $command == "TableUserDelete") {

        $userid   = filter_input(INPUT_GET, 'userid',  FILTER_SANITIZE_NUMBER_INT);

        echo "The user ID is: ".$userid;

        try{
            require 'connect.php';
            $query = "DELETE FROM users WHERE UserId = :userid";
            $statement = $db->prepare($query); // Returns a PDOStatement object.
            $statement->bindValue(':userid', $userid, PDO::PARAM_INT);

            // The query is now executed.
            $statement->execute();
            header('Location: account.php');
        }
        catch (PDOException $e) {
            header('Location: account.php');
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
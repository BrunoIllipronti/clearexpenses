<?php
    session_start();
    print_r($_POST);

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
        if(1 === preg_match('~[0-9]~', $firstname) || is_null($firstname) ){
            array_push($validation_array, 0);
        } else {
            array_push($validation_array, 1);
        }

        ##### If last name has numbers or it is null #####
        if(1 === preg_match('~[0-9]~', $lastname) || is_null($lastname) ){
            array_push($validation_array, 0);
        } else {
            array_push($validation_array, 1);
        }

        ##### Invalid email address #####
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || is_null($email) ) {
            array_push($validation_array, 0);
        } else {
            array_push($validation_array, 1);
        }


        ##### If user starts with number or it is null #####
        if(is_numeric($user[1]) || is_null($user) ){
            array_push($validation_array, 0);
        } else {
            array_push($validation_array, 1);
        }

        print_r($validation_array);
        //header('Location: index.php');

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
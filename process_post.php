<?php
    session_start();
    print_r($_POST);

    // Validate User
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
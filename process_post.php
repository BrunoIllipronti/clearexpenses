<?php
    session_start();
    print_r($_POST);

	if (!empty($_POST["login"]) && !empty($_POST["pw"])){



        if ( $_POST["command"] == "Login" ) {

            $login   = filter_input(INPUT_POST, 'login',   FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $pw      = filter_input(INPUT_POST, 'pw', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            try{
                echo $login."   ".$pw;

                require 'connect.php';
                $query = "SELECT userid, name, visualizationsetting, imagepath FROM users WHERE UserName = '$login' AND Password = '$pw'";
                $statement = $db->prepare($query); // Returns a PDOStatement object.
                $statement->execute(); // The query is now executed.

                $user = $statement->fetch();
                $_SESSION["User"] = $user;

                print_r($_SESSION["User"]["name"]);

                header('Location: index.php');
                //exit;
            }
            catch (PDOException $e) {
                print "Error: " . $e->getMessage();
                die(); // Force execution to stop on errors.
            }

        }

	}

    if ($_POST["command"] == "Logoff"){
        echo "CAIU AQUI MANO";
        unset ($_SESSION["User"]);
        //$_SESSION["User"] = [];
        header('Location: index.php');
    }
?>




<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>ClearExpenses - Process Post</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php"></a></h1>
        </div> <!-- END div id="header" -->

<h1>An error occured while processing your post.</h1>
  <p>
    Both the title and content must be at least one character.  </p>
<a href="index.php">Return Home</a>

        <div id="footer">
            Copywrong 2019 - No Rights Reserved
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>
</html>
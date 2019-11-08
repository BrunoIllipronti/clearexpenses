<?php

    //session_start();
    //$_SESSION["User"] = [];

    if (isset($_SESSION["User"])){
        $img = $_SESSION["User"]["imagepath"];
    }
    else {
        $img = "imgs/user.png";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>ClearExpenses - Project</title>
        <link rel="stylesheet" href="style.css" type="text/css">
    </head>

    <body>
        <?php include 'header.php';?>

        <div class="container">
            <div class="row justify-content-between">
                <div class="col-4">

                    <h3>My Account</h3>

                    <img src="<?php echo $img;?>"alt="user" width="170" height="170"><br>

                    <form action="mailto:billipronti@academic.rrc.com" method="GET">
                        <fieldset>
                            <legend>Main Info:</legend>
                            <label for="name">Full Name:</label>
                            <input type="text" id="name" class="fields" placeholder="Enter your name here..." />
                            <p id="name_error">Name is null / or invalid (number). Fix it!</p>
                            <br>

                            <label for="phone">Phone:</label>
                            <input type="number" id="phone" class="fields" placeholder="Cel number..."/>
                            <p id="phone_error">Phone is null. Fix it !</p>
                            <br>

                            <label for="email">Email: </label>
                            <input type="email" id="email" class="fields" placeholder="Enter your email here..."/>
                            <p id="email_error">Email is null. Fix it!</p>
                            <br>

                            <label for="needs">Tell us your needs:</label>
                            <textarea placeholder="Enter your individual / company needs..." rows="4" cols="25" id="needs" ></textarea>
                        </fieldset>
                        <input type="submit" id="sendinfo" value="Send"/>
                        <input type="reset"  id="reset"    value="Reset"/>
                    </form>
                </div>

                <div class="col-4">
                    <form action="mailto:billipronti@academic.rrc.com" method="GET">
                        <fieldset>
                            <legend>Main Info:</legend>
                            <label for="name">Full Name:</label>
                            <input type="text" id="name" class="fields" placeholder="Enter your name here..." />
                            <p id="name_error">Name is null / or invalid (number). Fix it!</p>
                            <br>

                            <label for="phone">Phone:</label>
                            <input type="number" id="phone" class="fields" placeholder="Cel number..."/>
                            <p id="phone_error">Phone is null. Fix it !</p>
                            <br>

                            <label for="email">Email: </label>
                            <input type="email" id="email" class="fields" placeholder="Enter your email here..."/>
                            <p id="email_error">Email is null. Fix it!</p>
                            <br>

                            <label for="needs">Tell us your needs:</label>
                            <textarea placeholder="Enter your individual / company needs..." rows="4" cols="25" id="needs" ></textarea>
                        </fieldset>
                        <input type="submit" id="sendinfo" value="Send"/>
                        <input type="reset"  id="reset"    value="Reset"/>
                    </form>
                </div>


            </div>
        </div>

        <?php include 'footer.php';?>
    </body>
</html>

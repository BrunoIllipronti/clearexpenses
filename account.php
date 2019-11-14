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
                <div class="col-6">

                    <h3>My Account</h3>
                    <img src="<?php echo $img;?>"alt="user" width="170" height="170"><br>

                    <form action="process_post.php" method="post">
                        <fieldset>
                            <legend>Main Info:</legend>

                            <label for="name">First Name:</label>
                            <input type="text" id="name" name="name" class="fields" placeholder="First Name..." />
                            <p style="color:red;">First Name is null / or invalid (only letters). Fix it!</p>
                            <br>

                            <label for="lastname">Last Name:</label>
                            <input type="text" id="lastname" name="lastname" class="fields" placeholder="Last Name..." />
                            <p style="color:red;">Last Name is null / or invalid (only letters). Fix it!</p>
                            <br>

                            <label for="title">Job Title: </label>
                            <input type="text" id="title" name="title" class="fields" placeholder="Job Title..."/>
                            <br><br>

                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email"  class="fields" placeholder="Email..." />
                            <p style="color:red;">Email is null / or invalid. Fix it!</p>
                            <br>

                            <label for="user">User:</label>
                            <input type="text" id="user" name="user" class="fields" placeholder="User..." />
                            <p style="color:red;">User is null / or invalid (It should start with a letter). Fix it!</p>
                            <br>

                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" class="fields" placeholder="Password..." />
                            <p style="color:red;">Password is null. Fix it!</p>

                            <!--
                            <label for="phone">Phone:</label>
                            <input type="number" id="phone" class="fields" placeholder="Cel number..."/>
                            <p id="phone_error">Phone is null. Fix it !</p>
                            <br>
                            -->
                        </fieldset>

                        <!-- If User is Logged -->
                        <?php if (isset($_SESSION["User"]) && $_SESSION["User"] != "UserError" ){
                            ?>
                            <input type="submit" id="editbtn"   name="command" value="Edit Account"/>
                            <input type="submit" id="deletebtn" name="command" value="Delete Account"/><?php
                        //-- If User is not logged
                        } else { ?>
                            <input type="submit" id="createbtn" name="command" value="Create Account"/>
                        <?php
                        }
                        ?>


                        <br><br>
                    </form>
                </div>

                <div class="col-4">

                </div>


            </div>
        </div>

        <?php include 'footer.php';?>
    </body>
</html>

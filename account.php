<?php

/*
    if (isset($_SESSION["User"])){
        if( empty($_SESSION["User"]["imagepath"]) ){
            $img = "imgs/user.png";
        }
        else {
            $img = $_SESSION["User"]["imagepath"];
        }
    }
    else {
        $img = "imgs/user.png";
    }

    print_r($_SESSION["User"]);
*/


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

                    <form action="process_post.php" method="post">
                        <fieldset>
                            <legend>Main Info:</legend>

                            <label for="name">First Name:</label>
                            <input type="text" id="firstname" name="firstname" class="fields" placeholder="First Name..." />
                            <?php if ( isset($_SESSION["Error"]) ) {
                                    if ($_SESSION["Error"][0] == 0){
                                        ?><p style="color:red;">First Name is null / or invalid (only letters). Fix it!</p><br><?php
                                    } else { ?><br><br><br><?php }
                            } else { ?><br><br><br><?php } ?>


                            <label for="lastname">Last Name:</label>
                            <input type="text" id="lastname" name="lastname" class="fields" placeholder="Last Name..." />
                            <?php if ( isset($_SESSION["Error"]) ) {
                                if ($_SESSION["Error"][1] == 0){
                                    ?><p style="color:red;">Last Name is null / or invalid (only letters). Fix it!</p><br><?php
                                } else { ?><br><br><br><?php }
                            } else { ?><br><br><br><?php } ?>


                            <label for="title">Job Title: </label>
                            <input type="text" id="jobtitle" name="jobtitle" class="fields" placeholder="Job Title..."/>
                            <br><br><br>


                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email"  class="fields" placeholder="Email..." />
                            <?php if ( isset($_SESSION["Error"]) ) {
                                if ($_SESSION["Error"][2] == 0){
                                    ?><p style="color:red;">Email is null / or invalid. Fix it!</p><br><?php
                                } else { ?><br><br><br><br><?php }
                            } else { ?><br><br><br><br><?php } ?>

                            <!-- If User is logged, it shouldnt see LOGIN and PASSWORD -->
                            <?php if (!isset($_SESSION["User"]) || $_SESSION["User"] == "UserError" ) { ?>

                                    <label for="user">User:</label>
                                    <input type="text" id="user" name="user" class="fields" placeholder="User..."/>
                                    <?php if (isset($_SESSION["Error"])) {
                                        if ($_SESSION["Error"][3] == 0) {
                                            ?><p style="color:red;">User is null / or invalid (It should start with a
                                                letter). Fix it!</p><br><?php
                                        } else { ?><br><br><br><br><?php }
                                    } else { ?><br><br><br><br><?php } ?>


                                    <label for="password">Password:</label>
                                    <input type="password" id="pw" name="pw" class="fields" placeholder="Password..."/><br><br>


                                    <label for="password">Confirm Password:</label>
                                    <input type="password" id="pw2" name="pw2" class="fields" placeholder="Password..."/>
                                    <?php if (isset($_SESSION["Error"])) {
                                        if ($_SESSION["Error"][4] == 0) {
                                            ?><p style="color:red;">One of the Passwords is null / or it has spaces. Fix it!</p>
                                            <br><?php
                                        } elseif ($_SESSION["Error"][4] == 2) {
                                            ?><p style="color:red;">Both Passwords don't match - Type them equally!</p>
                                            <br><?php
                                        } else { ?><br><br><br><br><?php }
                                    } else { ?><br><br><br><br><?php }

                            } ?>

                        </fieldset>

                        <!-- If User is Logged -->
                        <?php if (isset($_SESSION["User"]) && $_SESSION["User"] != "UserError" ){
                            ?>
                            <input type="submit" id="editbtn"   name="command" value="Edit Account"/>
                            <!-- <input type="submit" id="deletebtn" name="command" value="Delete Account"/> -->
                            <?php
                        //-- If User is not logged
                        } else { ?>
                            <input type="submit" id="createbtn" name="command" value="Create Account"/>
                        <?php
                        }
                        ?>


                        <br><br>
                    </form>
                </div>

                <div class="col-6">

                    <?php if(isset($_SESSION["User"])){  ?>

                        <form action="process_post.php" method="post">
                            <fieldset>
                                <legend>Password Change:</legend>

                                <label for="password">Password:</label>
                                <input type="password" id="pw" name="pw" class="fields" placeholder="Password..."/><br><br>


                                <label for="password">Confirm Password:</label>
                                <input type="password" id="pw2" name="pw2" class="fields" placeholder="Password..."/>
                                <?php if (isset($_SESSION["ErrorPw"])) {
                                if ($_SESSION["ErrorPw"][0] == 0) {
                                ?><p style="color:red;">One of the Passwords is null / or it has spaces. Fix it!</p>
                                <br><?php
                                } elseif ($_SESSION["ErrorPw"][0] == 2) {
                                ?><p style="color:red;">Both Passwords don't match - Type them equally!</p>
                                <br><?php
                                } else { ?><br><br><?php }
                                } else { ?><br><br><?php } ?>

                            </fieldset>
                            <input type="submit" id="changepw" name="command" value="Change Password"/>
                        </form>

                    <?php } ?>
                </div>

            </div>
        </div>

        <?php include 'footer.php';
        // When leaving the page... Clean the Error session for Account form
        unset($_SESSION["Error"]);
        unset($_SESSION["ErrorPw"]);
        unset($_SESSION["Success"]);
        ?>
    </body>
</html>

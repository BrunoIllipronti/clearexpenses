<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>ClearExpenses - Project</title>
        <link rel="stylesheet" href="style.css" type="text/css">
    </head>

    <body>
        <?php include 'header.php';?>

        <?php
            function file_upload_path($original_filename, $upload_subfolder_name = 'imgs') {
                $current_folder = dirname(__FILE__);
                $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];

                // Extract extension from uploaded file
                $upload_extension = substr(strrchr($original_filename, "."), 1);
                $allowed_file_extensions = ['jpg', 'png', 'gif', 'jpeg'];
                $validator = null;

                // Check the file extension list and validate with the upload file extension
                for($i = 0; $i < count($allowed_file_extensions); $i++){
                    if($upload_extension != $allowed_file_extensions[$i]){
                        $validator++;
                    }
                    if($validator == 4):
                        echo "<p style=\"color:red;\">"."File Extension not Valid."."</p>";
                        return;
                    endif;
                }

                // Return the path with filename (if validated correctly)
                return join(DIRECTORY_SEPARATOR, $path_segments);
            }

            $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);

            if ($image_upload_detected) {
                $image_filename       = $_FILES['image']['name'];
                $temporary_image_path = $_FILES['image']['tmp_name'];
                $new_image_path       = file_upload_path($image_filename);


                // If destination folder with file does not exist
                if(!file_exists($new_image_path)){
                    // If there is no uploads folder... Create it
                    if(!is_dir('imgs')){
                        mkdir('imgs');
                    }
                    // Move file from temporary to destination path
                    if(isset($new_image_path)){

                        // Save Original Copy
                        move_uploaded_file($temporary_image_path, $new_image_path);

                        try{
                            require 'connect.php';

                            $path = str_replace(getcwd(), '', $new_image_path);
                            $path = ltrim( $path, $path[0] );

                            $userid = $_SESSION["User"]["userid"];

                            echo "Testing: ".$userid." and - ".$path;

                            $query = "UPDATE users SET ImagePath = :path WHERE UserId = :userid";
                            $statement = $db->prepare($query); // Returns a PDOStatement object.
                            $statement->bindValue(':path',   $path,   PDO::PARAM_STR);
                            $statement->bindValue(':userid', $userid, PDO::PARAM_INT);

                            // The query is now executed.
                            $statement->execute();
                        }
                        catch (PDOException $e) {
                            $_SESSION["Success"] = "<script type='text/javascript'>alert('Error when updating the Password: \" . $e->getMessage()');</script>";
                        }

                        $_SESSION["User"]["imagepath"] = $path;

                        // Refresh page after upload and DB file path update
                        header("Refresh:0");

                        echo "<p style=\"color:green;\">"."SUCCESS - Upload complete"."</p>";
                    }
                }
                else {
                    echo "<p style=\"color:red;\">"."File already exists"."</p>";
                }
            }
        ?>

        <div class="container">
            <div class="row justify-content-between">
                <div class="col-4">

                    <h3>My Account</h3>
                    <img src="<?php echo $img;?>" alt="user" style="border-radius: 5%; border: 2px solid black;" width="170" height="170"><br>

                    <!-- File Upload -->
                    <?php if (isset($_SESSION["User"])){ ?>
                        <form method='post' enctype='multipart/form-data'>
                            <input type='file' name='image' id='image'>
                            <input type='submit' class="button" name='submit' value='Upload Image'>
                            <br>
                        </form>
                    <?php } ?>


                    <form action="process_post.php" method="post">
                        <fieldset>
                            <legend>Main Info:</legend>

                            <label for="name">First Name:</label>
                            <input type="text" id="firstname" name="firstname" class="fields" placeholder="First Name..." <?php if (isset($_SESSION["User"])){ ?>value="<?php echo $_SESSION["User"]["firstname"]; } ?>"  />
                            <?php if ( isset($_SESSION["Error"]) ) {
                                    if ($_SESSION["Error"][0] == 0){
                                        ?><p style="color:red;">First Name is null / or invalid (only letters). Fix it!</p><br><?php
                                    } else { ?><br><br><br><?php }
                            } else { ?><br><br><br><?php } ?>


                            <label for="lastname">Last Name:</label>
                            <input type="text" id="lastname" name="lastname" class="fields" placeholder="Last Name..." <?php if (isset($_SESSION["User"])){ ?>value="<?php echo $_SESSION["User"]["lastname"]; } ?>"  />
                            <?php if ( isset($_SESSION["Error"]) ) {
                                if ($_SESSION["Error"][1] == 0){
                                    ?><p style="color:red;">Last Name is null / or invalid (only letters). Fix it!</p><br><?php
                                } else { ?><br><br><br><?php }
                            } else { ?><br><br><br><?php } ?>


                            <label for="title">Job Title: </label>
                            <input type="text" id="jobtitle" name="jobtitle" class="fields" placeholder="Job Title..." <?php if (isset($_SESSION["User"])){ ?>value="<?php echo $_SESSION["User"]["jobtitle"]; } ?>"  />
                            <br><br><br>


                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email"  class="fields" placeholder="Email..." <?php if (isset($_SESSION["User"])){ ?>value="<?php echo $_SESSION["User"]["email"]; } ?>"  />
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

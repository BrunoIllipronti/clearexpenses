<?php
    //require 'authenticate.php';
	require 'connect.php'; 
	
	// Sanitize $_GET['id'] to ensure it's a number.
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT u.firstname, u.lastname, u.imagepath, u.userid, p.postid, p.userid, p.title, p.postdate, p.postcontent FROM posts p 
              INNER JOIN users u ON p.UserId = u.UserId  WHERE postid = :id ORDER BY p.postdate DESC";
	$statement = $db->prepare($query); // Returns a PDOStatement object.
	$statement->bindValue(':id', $id, PDO::PARAM_INT);
	$statement->execute(); // The query is now executed.

	// Get select results (it will be 1 row based on id)
	$row = $statement->fetch();

    // Get messages
    $message_query = "SELECT u.firstname, u.lastname, u.imagepath, u.userid, p.postid, m.messageid, m.messagedate, m.messagecontent FROM postmessages m 
                      INNER JOIN users u ON m.UserId = u.UserId 
                      INNER JOIN posts p ON p.PostId = m.PostId
                      WHERE m.postid = :id ORDER BY m.messagedate DESC";
    $statement2 = $db->prepare($message_query); // Returns a PDOStatement object.
    $statement2->bindValue(':id', $id, PDO::PARAM_INT);
    $statement2->execute(); // The query is now executed.
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>ClearExpenses - Project</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>
<?php include 'header.php'; ?>

    <div class="container">

        <!-- Post information -->
        <div class="row contactpage_row">
            <div class="col-lg-10 contact_form">

                <ul class="list-inline list-pipe">
                    <li><a href="index.php">Home</a></li>

                    <!-- Enable Delete option if it is Admin or the respective User for that comment -->
                    <?php if (isset($_SESSION["User"])){ if($_SESSION["User"]["userid"] == "1" || $_SESSION["User"]["userid"] == $row["userid"]){  ?>
                        <li><a href="edit.php?id=<?php echo $row["postid"]?>">Edit Post</a></li>
                    <?php }} ?>

                    <?php if (isset($_SESSION["User"])){ ?>
                        <li><a href="create.php" >New Post</a></li>
                    <?php } ?>
                </ul>

                <div class="showpost">
                    <h1><?php echo $row["title"] ?></h1>
                        <p>
                            <small>
                                <?php echo "Published on: ".$row["postdate"]." | Posted By: "?> <b><?php echo $row["firstname"]." ".$row["lastname"] ?> </b>
                            </small>
                            <img src="<?php echo $row["imagepath"];?>" style="border-radius: 50%;" lt="user" width="45" height="45">
                        </p>
                        <div class='postcontent'>
                            <?php echo $row["postcontent"] ?>
                        </div>
                </div>
            </div>

        </div>


        <!-- Comment Section -->
        <div class="row contactpage_row">
            <div class="col-lg-10 contact_form">

                <div class="showpost">
                    <h4>Comment Section</h4>


                    <?php
                    if ($statement2->rowCount() > 0){
                        while ($messagerow = $statement2->fetch()):  ?>
                            <small>
                                <p>
                                    <form action="process_post.php" method="post">

                                            <img src="<?php echo $messagerow["imagepath"];?>" style="border-radius: 50%;" alt="user" width="35" height="35">

                                            <b><?php echo $messagerow["firstname"]." ".$messagerow["lastname"];?></b>
                                            <?php echo "(".$messagerow["messagedate"]."): " ?>
                                            <?php echo $messagerow["messagecontent"]; ?>

                                            <!-- Enable Delete option if it is Admin or the respective User for that comment -->
                                            <?php if (isset($_SESSION["User"])){ if($_SESSION["User"]["userid"] == "1" || $_SESSION["User"]["userid"] == $messagerow["userid"]){  ?>
                                                <input type="hidden" name="messageid" value="<?php echo $messagerow["messageid"] ?>"/>
                                                <input type="submit" style="border-radius: 4px; font-size: 10px;" name="command" value="Delete Comment"/>
                                            <?php }} ?>

                                    </form>
                                </p>
                            </small>
                        <?php
                        endwhile;
                    } ?>

                    <?php if(isset($_SESSION["User"])){  ?>

                        <form action="process_post.php" method="post">
                            <fieldset>
                                    <textarea name="content" rows="1" cols="60" id="content" placeholder="Place your comment..."></textarea>
                                    <br>
                                    <input type="hidden" name="postid" value="<?php echo $row["postid"] ?>"/>
                                    <input type="submit" class="button" name="command" value="Send >" required/>
                            </fieldset>
                        </form>

                        <!-- If message is null -->
                        <?php if (isset($_SESSION["Error"])){ ?>
                        <p style="color:red;"> <?php echo $_SESSION["Error"]; }?> </p>

                    <?php } ?>


                    <!-- End of Message Section -->
                    </div>
            </div>
        </div>

    </div>
    <?php unset($_SESSION["Error"]);
    include 'footer.php'; ?>
</body>
</html>






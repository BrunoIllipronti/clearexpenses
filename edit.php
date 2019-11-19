<?php
    //require 'authenticate.php';
    require 'connect.php';

    // Sanitize $_GET['id'] to ensure it's a number.
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT u.firstname, u.lastname, u.imagepath, p.postid, p.userid, p.title, p.postdate, p.postcontent FROM posts p 
                  INNER JOIN users u ON p.UserId = u.UserId  WHERE postid = :id ORDER BY p.postdate DESC";
    $statement = $db->prepare($query); // Returns a PDOStatement object.
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute(); // The query is now executed.

    // Get select results (it will be 1 row based on id)
    $row = $statement->fetch();

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
        <div class="row contactpage_row">
            <div class="col-lg-10 contact_form">

                <ul class="list-inline list-pipe">
                    <li><a href="index.php" >Home</a></li>
                    <li><a href="create.php" >New Post</a></li>
                    <li><a href="edit.php?id=<?php echo $row["postid"]?>">Edit Post</a></li>
                </ul>

                <div class="showpost">
                    <form action="process_post.php" method="post">
                        <fieldset>
                            <p>
                                <label for="title"><h1>Title</h1></label>
                                <input name="title" id="title" value="<?php echo $row["title"] ?>" />
                            </p>

                                <label for="content"><h1>Content</h1></label>
                                <div class='postcontent'>
                                    <textarea name="content" rows="14" cols="90" id="content"><?php echo $row["postcontent"] ?></textarea>
                                </div>

                            <p>
                                <input type="hidden" name="id" value="<?php echo $row["postid"] ?>"/>
                                <input type="submit" name="command" value="Update Post" />
                                <input type="submit" name="command" value="Delete Post" onclick="return confirm('Are you sure you wish to delete this post?')" />
                            </p>
                        </fieldset>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <?php include 'footer.php';    ?>
</body>
</html>
<?php
	//require 'authenticate.php';
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
                            <legend>New Post</legend>
                            <p>
                                <label for="title"><h1>Title</h1></label>
                                <input name="title" id="title" />
                            </p>

                            <label for="content"><h1>Content</h1></label>
                            <div class='postcontent'>
                                <textarea name="content" rows="14" cols="90" id="content"></textarea>
                            </div>

                            <p>
                                <input type="submit" name="command" value="Create Post" />
                            </p>
                        </fieldset>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>

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
                    <li><a href="index.php">Home</a></li>
                </ul>

                <div class="showpost">
                    <form action="process_post.php" method="post">
                        <fieldset>
                            <p>
                                <label for="title"><h1>Title</h1></label>
                                <input name="title" id="title" />
                            </p>

                            <label for="content"><h1>Content</h1></label>
                            <div class='postcontent'>
                                <textarea name="content" rows="14" cols="88" id="content"></textarea>
                            </div>

                            <p>
                                <input type="submit" class="button" name="command" value="Create Post" />
                            </p>
                        </fieldset>
                    </form>

                    <!-- If post title or content are null -->
                    <?php if (isset($_SESSION["Error"])){ ?>
                    <p style="color:red;"> <?php echo $_SESSION["Error"]; }?> </p>

                </div>

            </div>
        </div>
    </div>
    <?php unset($_SESSION["Error"]);
    include 'footer.php'; ?>
</body>
</html>

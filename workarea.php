<?php
    require 'connect.php';
	$query = "SELECT u.firstname, u.lastname, p.postid, p.userid, p.title, p.postdate, p.postcontent FROM posts p 
              INNER JOIN users u ON p.UserId = u.UserId ORDER BY p.postdate DESC";
	$statement = $db->prepare($query); // Returns a PDOStatement object.
	$statement->execute(); // The query is now executed.
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>ClearExpenses - Project</title>
        <link rel="stylesheet" href="style.css" type="text/css">
    </head>

    <body>
        <?php include 'header.php';?>

        <div class="container">
            <div class="row content_block justify-content-between">
                <div class="col-7 product_description">
                    <h3>Main Page</h3>

                </div>

                <div class="col-4 posts">
                    <?php
                    if ($statement->rowCount() > 0){
                        $i = 0;
                        while ($row = $statement->fetch()):

                            if($i < 5){?>
                                <h2 class="decoration">
                                    <a href="show.php?id=<?php echo $row["postid"]?>"><?php echo $row["title"]?></a>
                                </h2>

                                <p>
                                    <small>
                                        <?php echo $row["postdate"]?>
                                        <a href="edit.php?id=<?php echo $row["postid"]?>">edit</a>
                                    </small>
                                </p>

                                <div class='blog_content'>
                                    <?php if (strlen($row["postcontent"]) > 200){
                                        echo substr($row["postcontent"],1,200);
                                        ?>
                                        <p>...
                                            <a href="show.php?id=<?php echo $row["postid"]?>">Read more</a>
                                        </p>
                                        <?php
                                    } else {
                                        echo $row["postcontent"];
                                    }?>
                                </div>
                                <?php
                            }
                            $i++;
                            ?>

                        <?php
                        endwhile;
                    }   ?>

                    <a href="create.php" >New Post</a>
                </div>
            </div>
        </div>

        <?php include 'footer.php';?>

    </body>
</html>

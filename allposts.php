<?php
    require 'connect.php';
    $query = "SELECT u.firstname, u.lastname, u.imagepath, p.postid, p.userid, p.title, p.postdate, p.postcontent FROM posts p 
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
            <div class="row content_block justify-content-between" style="border: 1px solid; margin: auto;">

                    <?php
                    if ($statement->rowCount() > 0){
                        $i = 0;
                        while ($row = $statement->fetch()): ?>
                            <div class="row content_block justify-content-between" style="background-color:#EDEDED; border-bottom: 1px solid; margin: auto;">
                                <h2 class="decoration">
                                    <a href="show.php?id=<?php echo $row["postid"]?>"><?php echo $row["title"]?></a>
                                </h2>

                                <p>
                                    <small>

                                        <b><?php echo $row["postdate"]?></b><br>
                                        <img src="<?php echo $row["imagepath"];?>" style="border-radius: 50%;" lt="user" width="30" height="30">
                                        <?php echo "Posted By: "?><b><?php echo $row["firstname"]." ".$row["lastname"] ?></b>

                                        <?php if (isset($_SESSION["User"])){ if($_SESSION["User"]["userid"] == "1" || $_SESSION["User"]["userid"] == $row["userid"]){  ?>
                                            <a href="edit.php?id=<?php echo $row["postid"]?>">edit</a>
                                        <?php }} ?>
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
                            $i++;
                            ?>
                            </div>
                        <?php
                        endwhile;
                    }   ?>




            </div>
        </div>

        <?php include 'footer.php';?>

    </body>
</html>

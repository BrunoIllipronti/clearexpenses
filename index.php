<?php
	require 'connect.php'; 
	
	$query = "SELECT postid, userid, title, postdate, postcontent FROM posts ORDER BY postdate DESC";
	$statement = $db->prepare($query); // Returns a PDOStatement object.
	$statement->execute(); // The query is now executed.
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
            <div class="row content_block justify-content-between">
                <div class="col-7 product_description">
                    <h3>Main Page</h3>
                    <img src="imgs/bills.png" alt="bills">
                    <p>Go paperless with an integrated solution with all your expenses achieving transparency with real-time reporting.</p>
                    <p>ClearExpenses reduces processing time and boost efficiency.</p>
                    <p>Track and monitor your expenses anywhere with our online data storage.</p>
                    <p>Export Expense data to any other platforms and file formats you want.</p>
                    <p>Customize your solution for yourself or your company, meeting the exact needs of your organization</p>

                    <table class="table">
                        <tr>
                            <th>Services</th>
                        </tr>
                        <tr>
                            <td>Financial Consultancy</td>
                            <td>We have partnerships and we can offer support for financial issues, investments and much more.</td>
                        </tr>
                        <tr>
                            <td>Tax Return Assistance</td>
                            <td>Based on your expenses, you can ask for our support for 2020 Tax Return.</td>
                        </tr>
                        <tr>
                            <td>Customized Reports</td>
                            <td>Customized reports for organization / individuals.</td>
                        </tr>
                        <tr>
                            <td>Data Integration</td>
                            <td>ClearExpenses can integrate your expense report with your ERP system.</td>
                        </tr>
                    </table>

                    <h3>Recent News</h3>
                    <ul>
                        <li>11/16/2019 - We are LIVE! Login section open!</li>
                        <li>11/07/2019 - Almost Ready! Content being added to support your organization needs.</li>
                        <li>10/25/2019 - We are glad to partner up with @IlliprontiDesign for our website layout.</li>
                        <li>10/23/2019 - Database implementation using MySQL.</li>
                    </ul>
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

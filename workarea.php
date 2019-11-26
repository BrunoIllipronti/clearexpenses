<?php
    require 'connect.php';
	$query = "SELECT e.ExpenseId, e.Amount, e.Description, e.ExpenseDate, e.Month, e.Year, u.ImagePath, u.UserId, c.CategoryName
                FROM expenses e 
                INNER JOIN expensecategories c ON e.CategoryId = c.CategoryId
                INNER JOIN users u 			   ON e.UserId = u.UserId;";
    $st = $db->prepare($query); // Returns a PDOStatement object.
    $st->execute(); // The query is now executed.
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
                    <?php
                    if ($st->rowCount() > 0){
                    $i = 0; ?>

                    <div style="padding-top:30px; padding-bottom:30px;">
                        <table class="worktab">
                            <thead>
                            <tr>
                                <th colspan="8">User Management</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            while ($row = $st->fetch()): ?>

                                <tr>
                                    <td>
                                        <input type="hidden"   id=<?php echo $row["ExpenseId"]; ?> value=<?php echo $row["ExpenseId"]; ?> />
                                        <input type="text"     id=<?php echo $row["Description"]; ?> value=<?php echo $row["Description"]; ?> />
                                    </td>
                                    <td><input type="text"     id=<?php echo $row["Amount"]; ?> value=<?php echo $row["Amount"]; ?> /></td>
                                    <td><input type="text"     id=<?php echo $row["CategoryName"]; ?> value=<?php echo $row["CategoryName"]; ?> /></td>
                                    <td><input type="text"     id=<?php echo $row["ExpenseDate"]; ?>    value=<?php echo $row["ExpenseDate"]; ?> />   </td>
                                    <td><input type="text"     id=<?php echo $row["ImagePath"]; ?> value=<?php echo $row["ImagePath"]; ?> /></td>
                                    <td>
                                        <a href='' onclick="this.href='process_post.php?' +
                                                'expenseid='+document.getElementById('<?php echo $row["ExpenseId"]; ?>').value+
                                                '&command=ExpenseUpdate' +
                                                '&description='+document.getElementById('<?php echo $row["Description"]; ?>').value+
                                                '&amount='+document.getElementById('<?php echo $row["Amount"]; ?>').value+
                                                '&category='+document.getElementById('<?php echo $row["CategoryName"]; ?>').value+
                                                '&date='+document.getElementById('<?php echo $row["ExpenseDate"]; ?>').value+
                                                '&img='+document.getElementById('<?php echo $row["ImagePath"]; ?>').value
                                                ">Update</a>
                                    </td>
                                    <td>
                                        <a href='' onclick="this.href='process_post.php?expenseid='+document.getElementById('<?php echo $row["ExpenseId"]; ?>').value+'&command=ExpenseDelete'">Delete</a>
                                    </td>
                                </tr>

                                <?php
                                $i++;
                            endwhile;
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                    // If message is null
                    if (isset($_SESSION["Message"])){ ?>
                    <p style="color:red;"> <?php echo $_SESSION["Message"]; ?></p><?php
                    }
                    } ?>

                </div>



                <div class="col-6 posts">



                </div>




            </div>
        </div>

        <?php include 'footer.php';?>

    </body>
</html>

<script>
    $(document).ready(function(){
    $('#editable_table').Tabledit({
    url:'action.php',
    columns:{
    identifier:[0, "userid"],
    editable:[[1, 'firstname'], [2, 'lastname']]
    },
    restoreButton:false,
    onSuccess:function(data, textStatus, jqXHR)
    {
    if(data.action == 'delete')
    {
    $('#'+data.id).remove();
    }
    }
    });

    });
</script>
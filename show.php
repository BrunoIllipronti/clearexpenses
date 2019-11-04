<?php
	require 'connect.php'; 
	
	// Sanitize $_GET['id'] to ensure it's a number.
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
	
	$query = "SELECT postid, title, content, postdate FROM blogposts WHERE postid = :id";
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
    <title>Stung Eye - Chop like a fruit? Wootly Grins</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>
    <div id="wrapper">
	
        <div id="header">
            <h1><a href="index.php">Stung Eye - Chop like a fruit?</a></h1>
        </div> <!-- END div id="header" -->
		
		<ul id="menu">
			<li><a href="index.php" >Home</a></li>
			<li><a href="create.php" >New Post</a></li>
		</ul> <!-- END div id="menu" -->
		
		<div id="all_blogs">
			<div class="blog_post">
			    <h2><?php echo $row["title"] ?></a></h2><br>
			    <p>
				    <small>
				    <?php echo $row["postdate"]?>
				    <a href="edit.php?id=<?php echo $row["postid"]?>">edit</a>
				    </small>
			    </p>
			    <div class='blog_content'>
					<?php echo $row["content"] ?>      
			    </div>
			</div>
		</div>
		
        <div id="footer">
            Copywrong 2019 - No Rights Reserved
        </div> <!-- END div id="footer" -->
		
    </div> <!-- END div id="wrapper" -->
</body>

</html>






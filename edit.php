<?php
	require 'authenticate.php';
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
    <title>Stung Eye - Edit Post Wootly Grins</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>
    <div id="wrapper">
	
        <div id="header">
            <h1><a href="index.php">Stung Eye - Edit Post</a></h1>
        </div> <!-- END div id="header" -->
		
		<ul id="menu">
			<li><a href="index.php" >Home</a></li>
			<li><a href="create.php" >New Post</a></li>
		</ul> <!-- END div id="menu" -->
		
		<div id="all_blogs">
		  <form action="process_post.php" method="post">
			<fieldset>
			  <legend>Edit Blog Post</legend>
			  
			  <p>
				<label for="title">Title</label>
				<input name="title" id="title" value="<?php echo $row["title"] ?>" />
			  </p>
			  
			  <p>
				<label for="content">Content</label>
				<textarea name="content" id="content"><?php echo $row["content"] ?></textarea>
			  </p>
			  
			  <p>
				<input type="hidden" name="id" value="<?php echo $row["postid"] ?>"/>
				<input type="submit" name="command" value="Update" />
				<input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this post?')" />
			  </p>
			</fieldset>
		  </form>
		</div>
		
		<div id="footer">
			Copywrong 2019 - No Rights Reserved
		</div> <!-- END div id="footer" -->
		
    </div> <!-- END div id="wrapper" -->
</body>
</html>

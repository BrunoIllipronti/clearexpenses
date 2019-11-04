<?php
	
	if (!empty($_POST["title"]) && !empty($_POST["content"])){
		// Defining timezone (it could also be set on php.ini)
		date_default_timezone_set('US/Central');
		$today = date("Y-m-d H:i:s");
		
		require 'connect.php';
		
		// Sanitizing values
		$id      = filter_input(INPUT_POST, 'id',      FILTER_SANITIZE_NUMBER_INT);
		$title   = filter_input(INPUT_POST, 'title',   FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);		


		if ( $_POST["command"] == "Create" ){	

			$query = "INSERT INTO blogposts (title, content, postdate) 
									 values ( :title, :content, :postdate )";
			$statement = $db->prepare($query);
			$statement->bindValue(':title',   $title,   PDO::PARAM_STR);
			$statement->bindValue(':content', $content, PDO::PARAM_STR);
			$statement->bindValue(':postdate', $today );	
			
			$statement->execute();
			
			header('Location: index.php');
			exit;
			
		} elseif ( $_POST["command"] == "Update" ) {
			
			$query = "UPDATE blogposts SET title=:title, content=:content
									   WHERE postid = :id";
									   
			$statement = $db->prepare($query);
			$statement->bindValue(':title',   $title,   PDO::PARAM_STR);
			$statement->bindValue(':content', $content, PDO::PARAM_STR);
			$statement->bindValue(':id',      $id, 	    PDO::PARAM_INT);	
			
			$statement->execute();
			
			header('Location: index.php');
			exit;
			
		} elseif ( $_POST["command"] == "Delete" ) {
			
			$query = "DELETE FROM blogposts WHERE postid = :id";							   
			$statement = $db->prepare($query);
			$statement->bindValue(':id',      $id, 	    PDO::PARAM_INT);	
			
			$statement->execute();
			
			header('Location: index.php');
			exit;	
		}	
	}	
?>




<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title> Wootly Grins</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php"></a></h1>
        </div> <!-- END div id="header" -->

<h1>An error occured while processing your post.</h1>
  <p>
    Both the title and content must be at least one character.  </p>
<a href="index.php">Return Home</a>

        <div id="footer">
            Copywrong 2019 - No Rights Reserved
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>
</html>
<?php
    define('DB_DSN','mysql:host=localhost;dbname=clearexpenses');
    define('DB_USER','serveruser');
    define('DB_PASS','webdev123');     
    
    try {
        $db = new PDO(DB_DSN, DB_USER, DB_PASS);
		//echo "<p>Connected to the Database!</p>";
    } catch (PDOException $e) {
        print "Error: " . $e->getMessage();
        die(); // Force execution to stop on errors.
    }
?>
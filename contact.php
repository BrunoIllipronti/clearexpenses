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
    <div class="row contactpage_row">
        <div class="col-lg-4 contact_form">
                    <h3>Contact Page</h3>
                    <form action="mailto:billipronti@academic.rrc.com" method="GET">
                        <fieldset>
                            <legend>Main Info:</legend>
                            <label for="name">Full Name:</label>
                            <input type="text" id="name" class="fields" placeholder="Enter your name here..." />
                            <p id="name_error">Name is null / or invalid (number). Fix it!</p>
                            <br>

                            <label for="phone">Phone:</label>
                            <input type="number" id="phone" class="fields" placeholder="Cel number..."/>
                            <p id="phone_error">Phone is null. Fix it !</p>
                            <br>

                            <label for="email">Email: </label>
                            <input type="email" id="email" class="fields" placeholder="Enter your email here..."/>
                            <p id="email_error">Email is null. Fix it!</p>
                            <br>

                            <label for="needs">Tell us your needs:</label>
                            <textarea placeholder="Enter your individual / company needs..." rows="4" cols="25" id="needs" ></textarea>
                        </fieldset>
                        <input type="submit" id="sendinfo" value="Send"/>
                        <input type="reset"  id="reset"    value="Reset"/>
                    </form>

        </div>
        <div class="col-4 map">
                    <form action="mailto:billipronti@academic.rrc.com" method="GET">

                        <h3><a href="https://www.linkedin.com/in/brunoillipronti/">Illipronti, Bruno</a></h3>
                        <h3>Red River College @ 160 Princess St, Winnipeg, MB</h3>

                        <!-- Google Maps iframe -->
                        <div class="mapouter">
                            <div class="gmap_canvas">
                                <iframe width="600" height="400" id="gmap_canvas" src="https://maps.google.com/maps?q=red%20river%20college%20princess&t=&z=13&ie=UTF8&iwloc=&output=embed" ></iframe>
                            </div>
                        </div>

                    </form>

        </div>
    </div>
</div>

<?php include 'footer.php';?>
</body>
</html>

<?php

    //session_start();
    //$_SESSION["User"] = [];

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
            <div class="col-lg-4 contact_form">
                <h3>Contact Page</h3>
                <form action="process_post.php" method="post">
                    <fieldset>

                        <legend>Main Info:</legend>
                        <label for="name">Full Name:</label>
                        <input type="text" id="name" name="name" class="fields" placeholder="Enter your name here..." />
                        <br><br>

                        <label for="phone">Phone:</label>
                        <input type='tel' id="tel" name="tel" class="fields" pattern='[\(]\d{3}[\)]\d{3}[\-]\d{4}' title='Phone Number (Format: (999)999-9999)' placeholder="Tel Ex: (999)999-9999...">
                        <br><br>

                        <label for="email">Email: </label>
                        <input type="email" id="email" name="email" class="fields" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                        <br><br>

                        <label for="needs">Tell us how we can help:</label>
                        <textarea placeholder="Enter your individual / company needs..." rows="4" cols="25" id="needs" name="needs" ></textarea>

                    </fieldset>
                    <input type="reset"  id="reset"    value="Reset"/>
                    <input type="submit" id="contact" name="command" value="Contact"/>
                </form>

            </div>
            <div class="col-4 map">
                <form action="mailto:billipronti@academic.rrc.com" method="GET">

                    <h3><a href="https://www.linkedin.com/in/brunoillipronti/">Illipronti, Bruno</a></h3>
                    <h3>Red River College @ 160 Princess St, Winnipeg, MB</h3>

                    <!-- Google Maps iframe -->
                    <div class="mapouter">
                        <div class="gmap_canvas">
                            <iframe width="600" height="400" id="gmap_canvas" src="https://maps.google.com/maps?q=red%20river%20college%20princess&t=&z=13&ie=UTF8&iwloc=&output=embed"></iframe>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include 'footer.php';?>
</body>
</html>

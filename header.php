<?php

    session_start();

    if (isset($_SESSION["User"])){
        $img = $_SESSION["User"]["imagepath"];
    }
    else {
        $img = "imgs/user.png";
    }

    //print_r($_SESSION["User"] );
    //print_r( $_SESSION["Error"] );

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8"/>
		<link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

		<title>ClearExpense Project - Main Page</title>
	</head>

	<body>
        <div class="container">
            <div class="row header align-items-center">

                <!-- Logo column -->
                <div class="col-4">
                    <a href="index.php">
                        <img src="imgs/logo.png" alt="logo">
                    </a>
                </div>

                <!-- Form column -->
                <div class="col justify-content-end">
                    <form name ="login" id="loginform" action="process_post.php" method="post">

                         <?php  // If User is Set
                         if (isset($_SESSION["User"])){

                             // But it has a login error...
                             if($_SESSION["User"] == "UserError"){
                                 $img = "imgs/user.png";
                                 ?>
                                 <p style="color:red;">User or password incorrect!
                                 <input type="submit" id="loginbtn" name="command" value="Try Again"/></p>
                             <?php
                             } else {
                                // If User is Valid !  ?>
                                <p>Welcome <b><?= $_SESSION["User"]["name"]  ?></b> !
                                <?php $img = $_SESSION["User"]["imagepath"]; ?>

                                <input type="submit" id="loginbtn" name="command" value="Logoff"/></p>
                              <?php
                             }
                         }
                         else{
                             $img = "imgs/user.png";  ?>
                             <label for="login">Login: </label>
                             <input type="text" name="login" id="login" placeholder="Your user..."/>
                             <label for="pw">Password: </label>
                             <input type="password" name="pw" id="pw"   placeholder="Password..."/>

                             <input type="submit" id="loginbtn" name="command" value="Login"/>
                             <?php
                         }
                         ?>
                    </form>
                </div>

                <!-- Form column -->
                <div class="col-1 align-self-end">
                    <a href="account.php">
                        <img src="<?php echo $img;?>" alt="user" width="45" height="45">
                    </a>
                </div>


            </div>

        </div>

		<!-- Nav part -->
        <div class="container">
            <div class="row menu justify-content-center">
                <a class="header_link" href="index.php">MAIN PAGE</a>
                <a class="header_link" href="workarea.php">WORK AREA</a>
                <a class="header_link" href="contact.php">CONTACT US</a>
            </div>
        </div>
		
	</body>
</html>	
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
            <div class="row header justify-content-center">
                <div class="col-lg">
                    <a id="link" href="index.php">
                        <img src="imgs/logo.png" alt="logo">
                    </a>
                </div>

                <div class="col-lg">
                    <form name ="login" id="loginform" action="#">
                        <label for="login">Login: </label>
                        <input type="text" name="login" id="login" placeholder="Your user..."/>
                        <label for="pw">Password: </label>
                        <input type="password" name="pw" id="pw"   placeholder="Password..."/>

                        <input type="button" id="loginbtn" value="Login"/>
                        <!--
                        <p id="line"><p id="usererror">User or password incorrect!</p>
                        <a id="forgot" href="contact.html">Forgot your password?</a><p>  -->
                        <a id="link" href="index.php">
                            <img src="imgs/user.png" alt="user">
                        </a>
                    </form>
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
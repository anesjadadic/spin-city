<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="includes/style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script> 
    $(function(){
        $("#header").load("header.php"); 
    });
    </script> 
    <div id="header"></div>
</head>
<body>
    <div class="m-5 text-center">
        <h1 class="text-primary text-weight-bold">User Sign Up</h1>
        <div class="login-signup-form">
            <form action="includes/add-customer.inc.php" method="POST">
                <input class="search-bar" type="text" name="username" placeholder="Username..." required/><br>
                <input class="search-bar" type="password" name="password" placeholder="Password..." required/><br>
                <input class="search-bar" type="password" name="confirmPassword" placeholder="Confirm Password..." required/><br>
                <input class="submit-button" type="submit" name="submit"/>
            </form>
            <a href="customerLogin.php">Already have an account? Log in here!</a><br>
        </div>
        <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "emptyinput") {
                echo "<p>Please fill in all fields.</p>";
            } 
            else if ($_GET["error"] == "invalidusername") {
                echo "<p>That username contains invalid characters, please try a different one.</p>";
            }
            else if ($_GET["error"] == "usernametaken") {
                echo "<p>That username is already in use, please try a different one.</p>";
            }
            else if ($_GET["error"] == "passwordsdontmatch") {
                echo "<p>You entered two different password inputs.</p>";
            }
            else if ($_GET["error"] == "none") {
                echo "<p>Account successfully created!</p>";
            }
        }
        ?>
    </div>
</body>
</html>
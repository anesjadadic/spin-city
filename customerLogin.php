<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
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
        <h1 class="text-primary text-weight-bold">User Log In</h1>
        <div class="login-signup-form">
            <form action="includes/login-customer.inc.php" method="POST">
                <input class="search-bar" type="text" name="username" placeholder="Username..." required/><br>
                <input class="search-bar" type="password" name="password" placeholder="Password..." required/><br>
                <input class="submit-button" type="submit" name="submit"/>
            </form>
            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "usernamenotfound") {
                    echo "<p class='text-danger'>There is no account under that username.</p>";
                }
                else if ($_GET["error"] == "wrongpassword") {
                    echo "<p class='text-danger'>Wrong password.</p>";
                }
            }
            ?>
            <a href="customerSignUp.php">Don't have an account? Sign up here!</a><br>
            <a class="fixed-bottom m-5" href="employeeLogin.php">Employee Login</a>
        </div>
    </div>
</body>
</html>
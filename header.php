<?php
session_start();
require_once 'includes/connect.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <!-- This should be it's own file !!!!!-->
    <a class="navbar-brand" href="<?php echo $url?>" style="font-size: 2rem;">
        <span class="text-primary ml-4 font-weight-light">spin</span>.<span class="font-weight-bold">CITY</span>
    </a>
    
    <ul class="navbar-nav ml-auto" style="font-size: 1.5rem;">
        <li class="nav-item">
        <a class="nav-link" href="<?php echo $url?>">HOME</a>
        </li>
        <?php 
        if (isset($_SESSION["role"])) {
            echo 
            "<li class='nav-item'>
            <a class='nav-link' href='./employeePage.php'>EMPLOYEE PAGE</a>
            </li>";
        }
        if (isset($_SESSION["username"])) {
            echo 
            "<li class='nav-item'>
            <a class='nav-link' href='./includes/logout.inc.php'>LOG OUT</a>
            </li>";
        } else { 
            echo
            "<li class='nav-item'>
            <a class='nav-link' href='./customerLogin.php'>LOG IN</a>
            </li>";
        } 
        ?>
    </ul>
    </nav>
</body>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>
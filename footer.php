<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <!-- This should be it's own file !!!!!-->
    <a class="navbar-brand" href="#" style="font-size: 2rem;">SPIN CITY</a>
    
    <ul class="navbar-nav ml-auto" style="font-size: 1.5rem;">
        <li class="nav-item">
        </li>
        <?php if (isset($_SESSION["username"])) {
            echo 
            "<li class='nav-item'>
            <a class='nav-link' href='./includes/logout.inc.php'>log out</a>
            </li>";
        } else { 
            echo
            "<li class='nav-item'>
            <a class='nav-link' href='./employeeLogin.php'>employee log in</a>
            </li>";
        } ?>
    </ul>
    </nav>
</body>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>
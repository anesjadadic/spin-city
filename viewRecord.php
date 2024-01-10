<?php
session_start();
$genres = $_SESSION["genres"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="includes/style.css">
    <title>Spin City</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <div id="header"></div>
</head>
<body>
<br><a href="javascript:history.go(-1)" class='back-button'> << back </a><br>
<?php
require_once 'includes/connect.inc.php';

$id = $_GET['id'];
$sql = "SELECT rName, rArtist, rGenre, rYearReleased, rVinylQuantity, rCDquantity, rVinylPrice, rCDprice, rAlbumCover FROM Record WHERE rID='$id'";
$result = $conn->query($sql) or die ('Could not run query: ' . $conn->error);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo
        "<script> 
        $(function(){
            $('#header').load('header.php');" 
            // If there are no vinyls available, select the CD option. Otherwise, select the vinyl option
            .($row['rVinylQuantity'] == 0 ? "$('#cd').trigger('click');" : "$('#vinyl').trigger('click');"). 
        "});
        </script> 
        <div class='m-5 d-flex'>
            <div class='d-flex ml-5 col-md-7'>
                <img id='record-cover' width='600px' height='600px' src='./images/".$row['rAlbumCover']."'/>
                <img id='cover-decoration' height='600px' src=''/>
            </div>
            <div class='view-record-container col-md-5'>
                <h1 class='text-primary font-weight-bold'>".$row['rName']."</h1>
                <h2>".$row['rArtist']."</h2>
                <h3 class='text-secondary'>".$row["rYearReleased"]." &#x2022; ".$row["rGenre"]."</h3><br>
                <label class='media-button'".($row['rVinylQuantity'] == 0 ? " disabled" : "").">
                    <input 
                    class='d-none' 
                    type='radio' 
                    id='vinyl'" 
                    .($row['rVinylQuantity'] == 0 ? " disabled" : ""). 
                    "/> VINYL
                </label>
                <label class='media-button'".($row['rCDquantity'] == 0 ? " disabled" : "").">
                    <input 
                    class='d-none' 
                    type='radio' 
                    id='cd'" 
                    .($row['rCDquantity'] == 0 ? " disabled" : ""). 
                    "/> CD
                </label>
                <h5 class='text-success' id='amount'></h5>
                <br>
                <h1 id='price'></h1>
                <br>
                <button class='submit-button'>Add To Cart</button>
                <script>
                // jQuery click event handler for radio buttons
                $('#vinyl').on('click', function() {
                    document.getElementById('amount').innerText = ".$row["rVinylQuantity"]." + ' vinyl in stock';
                    document.getElementById('price').innerText = '$' + ".$row["rVinylPrice"].";
                    $('#cover-decoration').attr('src', './images/Vinyl.png');
                });
                $('#cd').on('click', function() {
                    document.getElementById('amount').innerText = ".$row["rCDquantity"]." + ' CDs in stock';
                    document.getElementById('price').innerText = '$' + ".$row["rCDprice"].";
                    $('#cover-decoration').attr('src', './images/CD.png');
                });
                </script>
            </div>
        </div>";
    }
}
?>
</body>
</html>
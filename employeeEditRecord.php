<?php
session_start();

if (!isset($_SESSION["role"])) 
{
    // User is not logged in
    header("location: ./employeeLogin.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Record</title>
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
<br><a href="javascript:history.go(-1)" class='back-button ml-3'> << back </a><br>
<?php
require_once 'includes/connect.inc.php';

$id = $_GET['id'];
$sql = "SELECT rName, rArtist, rGenre, rYearReleased, rVinylQuantity, rCDquantity, rVinylPrice, rCDprice, rAlbumCover FROM Record WHERE rID='$id'";
$result = $conn->query($sql) or die ('Could not run query: ' . $conn->error);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<br><h2 class='text-primary ml-5 mt-2'>You are currently editing: ";
        echo "<h3 class='text-secondary ml-5 mb-3'>Record #".$id." - ".$row["rName"]." by ".$row["rArtist"]."</h3>";
        echo
        "<form action='includes/edit-record.inc.php' method='POST' enctype='multipart/form-data'>
            <div class='record-edit-container ml-3 d-flex justify-content-center'>
                <div class='record-edit-text col-md-7 ml-5'>
                    <input type='hidden' name='currentAlbumCover' value='".$row['rAlbumCover']."'/>
                    <input type='hidden' name='recordID' value='".$id."'/>
                    <input class='search-bar' type='text' name='recordName' autocomplete='off' placeholder='name...' value='".$row["rName"]."' required/><br>
                    <input class='search-bar' type='text' name='artist' autocomplete='off' placeholder='artist...' value='".$row["rArtist"]."' required/><br>
                    <select class='search-bar' id='genre' name='genre' autocomplete='off' required>
                        <option value='Rock'".($row["rGenre"] == "Rock" ? "selected" : "").">Rock</option>
                        <option value='Rap'".($row["rGenre"] == "Rap" ? "selected" : "").">Rap</option>
                        <option value='Electronic'".($row["rGenre"] == "Electronic" ? "selected" : "").">Electronic</option>
                        <option value='Metal'".($row["rGenre"] == "Metal" ? "selected" : "").">Metal</option>
                        <option value='Pop'".($row["rGenre"] == "Pop" ? "selected" : "").">Pop</option>
                        <option value='Jazz'".($row["rGenre"] == "Jazz" ? "selected" : "").">Jazz</option>
                    </select><br>
                    <input class='search-bar' type='text' name='yearReleased' autocomplete='off' placeholder='year released...' value='".$row["rYearReleased"]."' required/><br>
                    <input class='search-bar' type='text' name='vinylQuantity' autocomplete='off' placeholder='vinyls on hand...' value='".$row["rVinylQuantity"]."' required/><br>
                    <input class='search-bar' type='text' name='cdQuantity' autocomplete='off' placeholder='CDs on hand...' value='".$row["rCDquantity"]."' required/><br>
                    <input class='search-bar' type='text' name='vinylPrice' autocomplete='off' placeholder='vinyl price...' value='".$row["rVinylPrice"]."' required/><br>
                    <input class='search-bar' type='text' name='cdPrice' autocomplete='off' placeholder='CD price...' value='".$row["rCDprice"]."' required/><br>
                    <input class='submit-button' type='submit' name='submitEdition' value='Confirm Changes'/>
                </div>
                <div class='record-edit-cover col-md-5'>
                    <img width='530' src='./images/{$row['rAlbumCover']}'><br>
                    <input class='mt-2' type='file' name='uploadfile' value=''/><br>
                </div>
            </div>
        </form>";
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "invalid-characters") {
                echo "<p>Error: Please limit inputs to alphabetic characters and numbers only.</p>";
            }
            else if ($_GET["error"] == "not-numeric") {
                echo "<p>Error: Only numeric characters are allowed in the last 5 fields.</p>";
            }
            else if ($_GET["error"] == "addition-success") {
                echo "<p>Record successfully added!</p>";
            }
            else if ($_GET["error"] == "edition-success") {
                echo "<p>Record successfully updated!</p>";
            }
        } 
    }
} else {
        echo "0 results.";
}
$conn->close();
?>
</body>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>
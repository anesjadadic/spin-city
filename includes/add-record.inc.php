<?php
// Check if the user accessed this page by submitting info and not some other way
if (isset($_POST["submitAddition"])) 
{
    $recordName = $_POST["recordName"];
    $artist = $_POST["artist"];
    $genre = $_POST["genre"];
    $yearReleased = $_POST["yearReleased"];
    $vinylQuantity = $_POST["vinylQuantity"];
    $cdQuantity = $_POST["cdQuantity"];
    $vinylPrice = $_POST["vinylPrice"];
    $cdPrice = $_POST["cdPrice"];

    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "../images/" . $filename;

    // Check for file upload success before proceeding
    if (move_uploaded_file($tempname, $folder)) 
    {
        echo "<h3>Image uploaded successfully!</h3>";

        require_once 'connect.inc.php';
        require_once 'functions.inc.php';

        // Check for invalid characters (anything that isn't a letter, number, or whitespace)
        if (invalidCharacters($recordName) !== false ||
            invalidCharacters($artist) !== false) 
        {
            header("location: ../employeePage.php?error=invalidentry");
            exit();
        }

        // Check for non-numeric characters in the numeric-only fields
        if (notNumeric($yearReleased) !== false || 
            notNumeric($vinylQuantity) !== false || 
            notNumeric($cdQuantity) !== false ||
            notNumeric($vinylPrice) !== false || 
            notNumeric($cdPrice) !== false) 
        {
            header("location: ../employeePage.php?error=invalidentry");
            exit();
        }

        // Create the SQL statement (in the prepared format)
        $sql = "INSERT INTO Record (rName, rArtist, rGenre, rYearReleased, rVinylQuantity, rCDquantity, rVinylPrice, rCDprice, rAlbumCover) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";

        // Prepare the statement and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssiiidds", $recordName, $artist, $genre, $yearReleased, $vinylQuantity, $cdQuantity, $vinylPrice, $cdPrice, $filename);

        // Execute the statement and then close it
        if ($stmt->execute() === TRUE) {
            echo "Record updated";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();

        // Redirect the user back to the employeePage with a success message
        header("location: ../employeePage.php?error=creation-success");
        exit();
    } 
    else {
        echo "<h3>Failed to upload image!</h3>";
    }
}
else {
    // The user does not have correct access, send them back to the login page
    header("location: ../userLogin.php");
}
?>

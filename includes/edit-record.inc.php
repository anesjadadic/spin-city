<?php
// Check if the user accessed this page by submitting info and not some other way
if (isset($_POST["submitEdition"])) 
{
    $id = $_POST["recordID"];
    $recordName = $_POST["recordName"];
    $artist = $_POST["artist"];
    $genre = $_POST["genre"];
    $yearReleased = $_POST["yearReleased"];
    $vinylQuantity = $_POST["vinylQuantity"];
    $cdQuantity = $_POST["cdQuantity"];
    $vinylPrice = $_POST["vinylPrice"];
    $cdPrice = $_POST["cdPrice"];
    $currentAlbumCover = $_POST["currentAlbumCover"];

    // Check if a new album cover is being uploaded before proceding
    if (!empty($_FILES["uploadfile"]["name"])) 
    {
        $filename = $_FILES["uploadfile"]["name"];
        $tempname = $_FILES["uploadfile"]["tmp_name"];
        $folder = "../images/" . $filename;
        move_uploaded_file($tempname, $folder);
    }
    else { $filename = $currentAlbumCover; }

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
    $sql = "UPDATE Record SET rName=?, rArtist=?, rGenre=?, rYearReleased=?, rVinylQuantity=?, rCDquantity=?, rVinylPrice=?, rCDprice=?, rAlbumCover=? WHERE rID=?;";

    // Prepare the statement and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssiiiddsi", $recordName, $artist, $genre, $yearReleased, $vinylQuantity, $cdQuantity, $vinylPrice, $cdPrice, $filename, $id);

    // Execute the statement and then close it
    if ($stmt->execute() === TRUE) {
        echo "Record updated";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();

    // Redirect the user back to the employeePage with a success message
    header("location: ../employeePage.php?error=edition-success");
    exit();
}
else {
    // The user does not have correct access, send them back to the login page
    header("location: ../userLogin.php");
}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<?php
require_once 'connect.inc.php';

if(isset($_REQUEST["term"]))
{
    $sql = "SELECT * FROM Record WHERE rName LIKE ?;";
    if($stmt = mysqli_prepare($conn, $sql)) 
    {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_term);
        
        // Set parameters
        $param_term = $_REQUEST["term"] . '%';
        
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt))
        {
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result) > 0) 
            {
                echo "<table class='table''>";
                echo "<tr>
                    <th>Cover</th>
                    <th>Name</th>
                    <th>Artist</th>
                    <th>Genre</th>
                    <th>Year Released</th>
                    <th>Vinyls In Stock</th>
                    <th>CDs In Stock</th>
                    <th>Vinyl Price</th>
                    <th>CD Price</th>
                    </tr>";
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
                {
                    echo 
                    "<tr>
                        <td><img width='40' src='./images/{$row['rAlbumCover']}'><br></td>
                        <td>" . $row["rName"] . "</td>
                        <td>" . $row["rArtist"] . "</td>
                        <td>" . $row["rGenre"] . "</td>
                        <td>" . $row["rYearReleased"] . "</td>
                        <td>" . $row["rVinylQuantity"] . "</td>
                        <td>" . $row["rCDquantity"] . "</td>
                        <td>$" . $row["rVinylPrice"] . "</td>
                        <td>$" . $row["rCDprice"] . "</td>
                        <td>
                            <a
                            href='../employeeEditRecord.php?id=".$row['rID']."'>Edit
                            </a>
                        </td>
                        <td>
                            <a
                            onClick=\"javascript: return confirm('Are you sure you want to remove this record from the database?');\" 
                            href='includes/delete-record.inc.php?id=".$row['rID']."'>Delete
                            </a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<p>No matches found</p>";
            }
        } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }
    }
    mysqli_stmt_close($stmt);
}
?>
</html>
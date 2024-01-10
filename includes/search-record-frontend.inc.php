<?php
require_once 'connect.inc.php';
require_once 'filter-data.inc.php';
?>

<div class="row row-cols-1 row-cols-md-5">
<?php
if(isset($_REQUEST["term"]))
{
    $sql = "SELECT * FROM Record WHERE rName LIKE ?";
    if($stmt = mysqli_prepare($conn, $sql)) 
    {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_term);
        
        // Set parameters
        $param_term = $_REQUEST["term"] . '%';

        // If there are no genres, make the arrays holding the genres empty instead of null
        if (isset($_REQUEST["genres"])) {
            $genres = $_REQUEST["genres"];
        } else {
            $genres = ['Rap', 'Rock', 'Pop'];
        }
        
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt))
        {
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result) > 0) 
            {
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
                {
                    if (in_array($row["rGenre"], $genres)) {
                        echo 
                        "<div class='card text-center'>
                            <img class='card-img-top' src='images/".$row["rAlbumCover"]."' alt='Card image cap'>
                            <div class='card-body'>
                                <h6 class='card-subtitle mb-1 text-muted font-weight-light'>".$row['rGenre']."</h6>
                                <h5 class='card-title'>".$row['rName']."</h5>
                                <h6 class='card-subtitle mb-2 text-muted'>".$row['rArtist']." &#x2022; ".$row["rYearReleased"]."</h6>
                                <div class='centered-list'>
                                    <ul class='nav nav-pills card-header-pills' style='font-size: 1.3rem;'>
                                        <li class='nav-item mt-0 mr-3 p-0'>
                                            <h5 ".($row["rCDquantity"] == 0 ? "class='text-muted'" : "class='text-primary font-weight-bold'").">CD</h5>
                                        </li>
                                        <li class='nav-item m-0 p-0'>
                                            <h5 ".($row["rVinylQuantity"] == 0 ? "class='text-muted'" : "class='text-primary font-weight-bold'").">VINYL</h5>
                                        </li>
                                    </ul>
                                </div>
                                <h4 class='card-subtitle mt-1 mb-3'>" . 
                                (($row['rCDquantity'] > 0 && $row["rVinylQuantity"] == 0) ? '$'.$row['rCDprice'] : '') .
                                (($row['rCDquantity'] == 0 && $row["rVinylQuantity"] > 0) ? '$'.$row['rVinylPrice'] : '') .
                                (($row['rCDquantity'] > 0 && $row["rVinylQuantity"] > 0) ? '$'.$row['rCDprice']." &#x2022; $".$row["rVinylPrice"] : '') .
                                "</h4>
                                <a class='view-record-button' href='../viewRecord.php?id=".$row['rID']."'>View Record</a>
                            </div>
                        </div>";
                    }
                }
            }
        } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }
    }
    mysqli_stmt_close($stmt);
}
?>
</div>
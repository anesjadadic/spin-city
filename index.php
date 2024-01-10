<?php
session_start();
include("includes/connect.inc.php");
include("includes/filter-data.inc.php");
include("includes/functions.inc.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="includes/style.css">
  <title>Spin City</title>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script> 
  $(function(){
    $("#header").load("header.php"); 
  });
  </script> 
  <script>
    $(document).ready(function() {
      // Select All checkbox click event handler
      $('#selectAll').click(function() {
        // Check or uncheck all checkboxes based on the Select All checkbox
        $('input[name="genre[]"]').prop('checked', $(this).prop('checked'));
      });
    });
  </script>
</head>

<body>
<div id="header"></div>

<div class="w-100 d-flex min-vh-100">
    <div class="filter-section col-md-2">
        <form method="GET">
            <?php
            $getGenres = getGenre();
            ?>
            <!-- Select All checkbox -->
            <div class="checkbox-filter">
                <input type="checkbox" class="checkbox-input" id="selectAll"><label class="font-weight-light" for="selectAll">Select All</label><br>
            </div>
            <?php
            foreach ($getGenres as $genre) 
            {
                // Set $checked to "checked" to make all checkboxes checked by default
                $checked = 'checked';
                if(isset($_GET['genre']) && !in_array($genre['rGenre'], $_GET['genre'])) {
                    // If a specific genre is not in $_GET['genre'], remove the "checked" attribute
                    $checked = '';
                }
            ?>
            <div class="checkbox-filter">
                <input 
                    type="checkbox" 
                    class="checkbox-input" 
                    value="<?php echo $genre['rGenre']; ?>" 
                    id="<?php echo $genre['rGenre']; ?>" 
                    name="genre[]" 
                    <?php echo $checked; ?>
                >
                <label class="font-weight-light text-uppercase" for="<?php echo $genre['rGenre']; ?>">
                    <?php echo $genre['rGenre']; ?>
                </label><br>
            </div>
            <?php 
            } 
            ?>
            <input class="submit-button" type="submit" name="filter" value='Apply'><br>
        </form>

        <?php 
        // Get all the genres selected from the URL
        if (isset($_GET["genre"])) {
            $genres = $_GET['genre'];
            $genresJS = json_encode($genres);
            $_SESSION['genres'] = $genres;
        } else {
            $genres = [];
            $genresJS = json_encode($genres);
            $_SESSION['genres'] = $genres;
        }
        ?>
    </div>

    <script>
    // AJAX function that passes the search bar content and selected genres to filter the displayed records asynchronously
    $(document).ready(function() {
        var genres = <?php echo $genresJS ?>;
        function performRecordSearch(recordInputVal) {
            var recordResults = $('.record-cards input[type="text"]').siblings(".recordResult");

            if (recordInputVal.length > 0) {
                // Search bar has content
                $.get("includes/search-record-frontend.inc.php", { term: recordInputVal, genres: genres }).done(function(data) {
                    recordResults.html(data);
                });
            } else {
                // Search bar is empty
                $.get("includes/search-record-frontend.inc.php", { term: '', genres: genres }).done(function(data) {
                    recordResults.html(data);
                });
            }
        }
        // Handle input events on the search bar
        $('.record-cards input[type="text"]').on("keyup input", function() {
            // Get input value on change
            var recordInputVal = $(this).val();
            // Perform the search and display results
            performRecordSearch(recordInputVal);
        });
    });
    </script>

    <div class="record-cards col-md-10 mt-4">
        <input class="search-bar" type="text" autocomplete="off" placeholder="Search record name..." />
        <div class="recordResult">
            <div class="row row-cols-1 row-cols-md-5">
            <?php
            if(!empty($filterDataByGenre)) {
                foreach ($filterDataByGenre as $filterData) {
                    if (in_array($filterData["rGenre"], $genres)) {
                        echo 
                        "<div class='card text-center'>
                            <img class='card-img-top' src='images/".$filterData["rAlbumCover"]."' alt='Card image cap'>
                            <div class='card-body'>
                                <h6 class='card-subtitle mb-1 text-muted font-weight-light'>".$filterData['rGenre']."</h6>
                                <h5 class='card-title'>".$filterData['rName']."</h5>
                                <h6 class='card-subtitle mb-2 text-muted'>".$filterData['rArtist']." &#x2022; ".$filterData["rYearReleased"]."</h6>
                                <div class='centered-list'>
                                    <ul class='nav nav-pills card-header-pills' style='font-size: 1.3rem;'>
                                        <li class='nav-item mt-0 mr-3 p-0'>
                                            <h5 ".($filterData["rCDquantity"] == 0 ? "class='text-muted'" : "class='text-primary font-weight-bold'").">CD</h5>
                                        </li>
                                        <li class='nav-item m-0 p-0'>
                                            <h5 ".($filterData["rVinylQuantity"] == 0 ? "class='text-muted'" : "class='text-primary font-weight-bold'").">VINYL</h5>
                                        </li>
                                    </ul>
                                </div>
                                <h4 class='card-subtitle mt-1 mb-3'>" . 
                                (($filterData['rCDquantity'] > 0 && $filterData["rVinylQuantity"] == 0) ? '$'.$filterData['rCDprice'] : '') .
                                (($filterData['rCDquantity'] == 0 && $filterData["rVinylQuantity"] > 0) ? '$'.$filterData['rVinylPrice'] : '') .
                                (($filterData['rCDquantity'] > 0 && $filterData["rVinylQuantity"] > 0) ? '$'.$filterData['rCDprice']." &#x2022; $".$filterData["rVinylPrice"] : '') .
                                "</h4>
                                <a class='view-record-button' href='../viewRecord.php?id=".$filterData['rID']."'>View Record</a>
                            </div>
                        </div>";
                    }
                }
            }
            ?>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
<?php
if(isset($_GET['filter'])) {
    $filterDataByGenre = filterDataByGenre();
}
function filterDataByGenre() {
    $filterByGenre = isset($_GET['genre']) ? $_GET['genre'] : [];
    $genres = "'".implode("', '", $filterByGenre)."'";
    
    global $conn;
    
    $data =[];
    if (!empty($filterByGenre))
    {
        $query = "SELECT * FROM Record WHERE rGenre IN ($genres)";
     
        $result = $conn->query($query);
        
        if($result->num_rows > 0) {
          $data = $result->fetch_all(MYSQLI_ASSOC);
        } 
   } 
   return $data;
}
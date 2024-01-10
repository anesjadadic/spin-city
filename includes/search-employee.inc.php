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
    $sql = "SELECT * FROM Employee WHERE eUsername LIKE ? AND eRole='Employee';";
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
                echo "<table class='table'>";
                echo 
                "<tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                </tr>";
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
                {
                    echo 
                    "<tr>
                        <td>" . $row["eID"] . "</td>
                        <td>" . $row["eFirstName"] . "</td>
                        <td>" . $row["eLastName"] . "</td>
                        <td>" . $row["eUsername"] . "</td>
                        <td>
                            <a
                            onClick=\"javascript: return confirm('Are you sure you want to remove this employee from the database?');\" 
                            href='includes/delete-employee.inc.php?id=".$row['eID']."'>Delete
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
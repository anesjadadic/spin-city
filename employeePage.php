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
    <title>Employee Page</title>
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
<!-- This section (Add/View/Delete employees) is only displayed to admins -->
<?php
if ($_SESSION["role"] === "Admin") {
?>
    <script>
    $(document).ready(function() {
        function performEmployeeSearch(inputVal) {
            var employeeResults = $('.employee-search-box input[type="text"]').siblings(".employeeResult");

            if (inputVal.length > 0) {
                $.get("includes/search-employee.inc.php", { term: inputVal }).done(function(data) {
                    employeeResults.html(data);
                });
            } else {
                $.get("includes/search-employee.inc.php", { term: '' }).done(function(data) {
                    employeeResults.html(data);
                });
            }
        }
        // Handle keyup and input events on the search input
        $('.employee-search-box input[type="text"]').on("keyup input", function() {
            // Get input value on change
            var employeeInputVal = $(this).val();
            // Perform the search and display results
            performEmployeeSearch(employeeInputVal);
        });
        // Trigger the initial search on page load
        performEmployeeSearch('');
    });
    </script>
    <h1 class="text-primary ml-5 mr-5 mt-4 mb-4">Employees</h1>
    <div id="employee-section">
        <div class="add-employee">
            <h2>Add An Employee</h2>
            <form class="employee-form" action="includes/add-employee.inc.php" method="POST">
                <input class="search-bar" type="text" name="first-name" autocomplete="off" placeholder="first name..." required/><br>
                <input class="search-bar" type="text" name="last-name" autocomplete="off" placeholder="last name..." required/><br>
                <input class="search-bar" type="text" name="username" autocomplete="off" placeholder="username..." required/><br>
                <input class="search-bar" type="password" name="password" autocomplete="off" placeholder="password..." required/><br>
                <input class="search-bar" type="password" name="confirm-password" autocomplete="off" placeholder="confirm password..." required/><br>
                <input class="submit-button" type="submit" name="submitEmployeeAddition" value="Add Employee"/>
            </form>
            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput") {
                    echo "<p class='text-success'>Error: Please fill in all fields.</p>";
                } 
                else if ($_GET["error"] == "invalidentry") {
                    echo "<p class='text-success'>Error: You have entered invalid characters.<br>";
                }
                else if ($_GET["error"] == "usernametaken") {
                    echo "<p class='text-success'>Error: Employee with that username already exists.<p>";
                }
                else if ($_GET["error"] == "passwordsdontmatch") {
                    echo "<p class='text-success'>Error: Passwords do not match.</p>";
                }
                else if ($_GET["error"] == "deletion-success") {
                    echo "<p class='text-success'>Employee removed successfully.</p>";
                }
                else if ($_GET["error"] == "no-employee-error") {
                    echo "<p class='text-success'>Employee added successfully.</p>";
                }
            }
            ?>
        </div>
        <div class="employee-search-box">
            <h2>All Employees</h2>
            <input class="search-bar" type="text" autocomplete="off" placeholder="Search employee username..." />
            <div class="employeeResult"></div>
        </div>
    </div>
<?php
}
?>

<!-- This section (Add/View/Edit/Delete records is displayed to both employees and admins -->
<script>
$(document).ready(function() {
    function performRecordSearch(recordInputVal) {
        var recordResults = $('.record-search-box input[type="text"]').siblings(".recordResult");

        if (recordInputVal.length > 0) {
            $.get("includes/search-record.inc.php", { term: recordInputVal }).done(function(data) {
                recordResults.html(data);
            });
        } else {
            $.get("includes/search-record.inc.php", { term: '' }).done(function(data) {
                recordResults.html(data);
            });
        }
    }
    // Handle keyup and input events on the search input
    $('.record-search-box input[type="text"]').on("keyup input", function() {
        // Get input value on change
        var recordInputVal = $(this).val();
        // Perform the search and display results
        performRecordSearch(recordInputVal);
    });
    // Trigger the initial search on page load
    performRecordSearch('');
});
</script>
    <h1 class="text-primary ml-5 mr-5 mt-4 mb-4">Records</h1>
    <div id="record-section">
        <div class="add-record">
            <h2>Add A Record</h2>
            <form class="record-form" action="includes/add-record.inc.php" method="POST" enctype="multipart/form-data">
                <input class="search-bar" type="text" name="recordName" autocomplete="off" placeholder="name..." required/><br>
                <input class="search-bar" type="text" name="artist" autocomplete="off" placeholder="artist..." required/><br>
                <select class="search-bar" id="genre" name="genre" required>
                    <option value="Rock">Rock</option>
                    <option value="Rap">Rap</option>
                    <option value="Electronic">Electronic</option>
                    <option value="Metal">Metal</option>
                    <option value="Pop">Pop</option>
                    <option value="Jazz">Jazz</option>
                </select><br>
                <input class="search-bar" type="text" name="yearReleased" autocomplete="off" placeholder="year released..." required/><br>
                <input class="search-bar" type="text" name="vinylQuantity" autocomplete="off" placeholder="vinyls on hand..." required/><br>
                <input class="search-bar" type="text" name="cdQuantity" autocomplete="off" placeholder="CDs on hand..." required/><br>
                <input class="search-bar" type="text" name="vinylPrice" autocomplete="off" placeholder="vinyl price..." required/><br>
                <input class="search-bar" type="text" name="cdPrice" autocomplete="off" placeholder="CD price..." required/><br><br>
                <input type="file" name="uploadfile" value="" required/><br><br>
                <input class="submit-button" type="submit" name="submitAddition" value="Add Record"/>
            </form>
            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput") {
                    echo "<p>Please fill in all fields.</p>";
                } 
                else if ($_GET["error"] == "invalidentry") {
                    echo "<p>You have entered invalid characters.<br>
                    Remember <b>not</b> to insert a dollar sign under the price section, it is done automatically.</p>";
                }
                else if ($_GET["error"] == "none") {
                    echo "Record added successfully.";
                }
            }
            ?>
        </div>
        <div class="record-search-box">
            <h2>All Records</h2>
            <input class="search-bar" type="text" autocomplete="off" placeholder="Search record name..." /><br>
            <a class='mb-5' href='./includes/generate-pdf.inc.php'>Get Records PDF</a>
            <div class="recordResult p-0 ml-0 mt-3"></div>
        </div>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>
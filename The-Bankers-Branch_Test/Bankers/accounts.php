<?php
include "header.html";
include "include/functions.php";
include "include/connection.php";
include "navbar.php";

if($_SESSION["userName"] != ""){ // Checks if the user is logged in, so they can access this page.

} else{
    header("location: login.php"); // Redirect to login page if they aren't logged in making them unable to access the sendMoney page
    exit();
}

$accountNumber = $_SESSION["accountNumber"];

$row = displayAccountDetails($conn, $accountNumber);
?>
<div class="account">
    <?php
        echo "Balance: " . $row['balance'];
        echo "<br>";
        echo "Account Number: " . $row['accountNumber'];
        echo "<br>";
        echo "Sort Code: " . $row['sortCode'];
        echo "<br>";
        echo "Account Type: " . $row['accountType'];
    ?>
</div>

<?php
include "footer.html";

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

$balance = $row['balance'];
$accNumber = $row['accountNumber'];
$sortCode = $row['sortCode'];

/* $row = displayAccountDetails($conn, $accountNumber);
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
*/
?>

<body id="accounts">
    <div class="accounts_class">
        <?php
        echo "<div class='balance'><li>Balance:</li></div>";
        echo "<div class='accNumber'><li>$accNumber</li></div>";
        echo "<div class='sortCode'><li>$sortCode</li></div>";
        ?>
    </div>


</body>

<?php
include "footer.html";
?>
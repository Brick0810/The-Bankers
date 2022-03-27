<?php
include "header.html";
include "include/functions.php";
include "include/connection.php";
include "navbar.php";

if($_SESSION["userName"] != ""){ // Checks if the user is logged in, so they can access this page.

    $account = displayAccountDetails($conn, $_SESSION["accountNumber"]);

    $balance = $account['balance'];
    $accNumber = $account['accountNumber'];
    $sortCode = $account['sortCode'];
    $accountType = $account['accountType'];
    $amount = number_format($account['balance'],2);

} else{
    header("location: login.php"); // Redirect to login page if they aren't logged in making them unable to access the sendMoney page
    exit();
}

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
        echo "<div class='amount'><li>£$amount</li></div>";
        echo "<div class='accNumber'><li>$accNumber</li></div>";
        echo "<div class='sortCode'><li>$sortCode</li></div>";
        echo "<div class='accountType'><li>$accountType</li></div>";
        echo "<div class='sendMoney'><a href='sendMoney.php'>Send Money</a></div>";
        echo "<div class='viewAccount'><li><a href='transfers.php'>View my account</a></li></div>";
        ?>
    </div>


</body>

<?php
include "footer.html";
?>
<?php
include "header.html";
include "include/functions.php";
include "include/connection.php";

include "transfersView.html";
if($_SESSION["userName"] != ""){ // Checks if the user is logged in, so they can access this page.
    $accountNumber = $_SESSION["accountNumber"];

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
        ?>
    </div>

    <div class="transfers">
        <table>
            <thead>
                <tr>
                    <th class="id">ID</th>
                    <th class="date">Date</th>
                    <th class="amount">Amount</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    $transactionList = displayTransfers($conn, $accountNumber);
                    foreach ($transactionList as $value){
                        echo "<tr>";
                        $transactionID = $value['transactionID'];
                        $transactionDate = $value['transactionDate'];
                        $transactionAmount = $value['amount'];
                        if($value['accountNumberFrom'] == $accountNumber){
                            $transactionAmount = "IN: £" . number_format($transactionAmount, 2);
                            $colour = "#dea0a0";
                        } else{
                            $transactionAmount = "OUT: £" . number_format($transactionAmount, 2);
                            $colour = "#013220";
                        }
                        echo "<td style='background-color: $colour'>$transactionID</td>";
                        echo "<td class='date' style='background-color: $colour'>$transactionDate</td>";
                        echo "<td class='amount' style='background-color: $colour'>$transactionAmount</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>


<?php
include "footer.html";
?>



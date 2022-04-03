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
        echo "<div class='viewAccount'><li><a href='accounts.php'>Go back to accounts</a></li></div>"
        ?>
    </div>

    <div class="transfers">
        <table>
            <thead>
            <tr>
                <th class="id">ID</th>
                <th class="date">DATE</th>
                <th class="amount">AMOUNT</th>
            </tr>
            </thead>

            <tbody>
            <?php
            $transactionList = displayTransfers($conn, $accountNumber);
            foreach ($transactionList as $value){
                $transactionID = $value['transactionID'];
                $transactionAmount = $value['amount'];
                $transactionDate = $value['transactionDate'];
                $reference = $value['reference'];
                $accountNumberFrom = $value['accountNumberFrom'];
                $accountNumberTo = $value['accountNumberTo'];
                echo "<tr onclick='displayTransaction()'>";
                if($value['accountNumberFrom'] == $accountNumber){
                    $transactionAmount = "<div style='font-family: Oswold, sans-serif'> OUT: £" . number_format($transactionAmount, 2);
                    $colour = "#B03624";
                } else{
                    $transactionAmount = "<div style='font-family: Oswold, sans-serif'> IN: £" . number_format($transactionAmount, 2);
                    $colour = "#3DCC5D";
                }
                echo "<td style='background-color:$colour'>$transactionID</td>";
                echo "<td class='date' style='background-color:$colour'>$transactionDate</td>";
                echo "<td class='amount' style='background-color: $colour'>$transactionAmount</td>";
                echo "</tr>";
                $transactionAmount = number_format($value['amount'], 2);
                echo "<div class='transactionBox_class' id='transactionBox'>
                                <div class='wrapper'>
                                    <h2>Transaction Details</h2>
                                        <div class='content'>
                                            <div class='container'>
                                                <form>         
                                                    <label>Transaction ID:</label>
                                                    <p>$transactionID</p>
                                                    <label>Amount:</label>
                                                    <p>$transactionAmount</p>
                                                    <label>Date:</label>
                                                    <p>$transactionDate</p>
                                                    <label>Reference:</label>
                                                    <p>$reference</p>
                                                    <label>Account Number From:</label>
                                                    <p>$accountNumberFrom</p>
                                                    <label>Account Number To:</label>
                                                    <p>$accountNumberTo</p>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
            }

            ?>

            </tbody>
        </table>
    </div>
    </body>

    <script>
        function displayTransaction() {
            var x = document.getElementById("transactionBox");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
    </script>

<?php


?>

<?php


?>

<?php
include "footer.html";
?>
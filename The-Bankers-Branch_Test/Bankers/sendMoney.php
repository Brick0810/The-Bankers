<?php
include "header.html";
include "include/functions.php";
include "navbar.php";

if($_SESSION["userName"] != ""){ // Checks if the user is logged in, so they can access this page.

} else{
    header("location: login.php"); // Redirect to login page if they aren't logged in making them unable to access the sendMoney page
    exit();
}
?>

<body id="signup">
    <div class="signup">
        <h1>Send Money</h1>
        <form action="include/sendMoney-include.php" method="post">
            <div class="text">
                <li><p>Account Number:</p></li>
                <input type="text" name="accountNumber">
                <li><p>Sort Code:</p></li>
                <input type="text" name="sortCode">
                <li><p>Amount:</p></li>
                <input type="text" name="amount">
                <li><p>Reference:</p></li>
                <select name="choiceBox">
                    <li><option value="Friend">Paying a friend</option></li>
                    <li><option value="Family">Paying family</option></li>
                    <li><option value="Bills">Bills</option></li>
                    <li><option value="Goods">Buying goods</option></li>
                    <li><option value="Own Account">Transfer to own account</option></li>
                </select>
                <li><button type="submit" name="submit">Send</button></li>
            </div>
            <?php
            if(isset($_GET['error'])){ // checks against the URL to see if the text error exists in the URL
                echo "<div class ='error'>";
                if($_GET["error"] == "emptyInput"){
                    echo "<p>Please fill in all the boxes!</p>";
                }
                else if ($_GET["error"] == "accountNumberIncorrect"){
                    echo "<p>The account number you have provided does not exist!</p>";
                }
                else if ($_GET["error"] == "sortCodeIncorrect"){
                    echo "<p>The sort code you provided is wrong and does not match with the account number!</p>";
                }
                else if ($_GET["error"] == "notEnoughBalance"){
                    echo "<p>You do not have enough balance to send this amount!</p>";
                }
                else if ($_GET["error"] == "amountWrong"){
                    echo "<p>Please enter a valid amount</p>";
                }
                else if ($_GET["stmtFailed"] == "stmtFailed"){
                    echo "<p>Something went wrong, we are sorry. Please try again!</p>";
                }
                else if ($_GET["error"] == "none") {
                    echo "<script>alert('The transactions has completed successfully!');</script>";
                }
                echo "</div>";
            }
            ?>
        </form>
    </div>
</body>

<?php
include "footer.html";
?>


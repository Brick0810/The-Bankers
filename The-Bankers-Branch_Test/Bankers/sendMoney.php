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

<div class="signup">
    <form action="include/sendMoney-include.php" method="post">
        <ul>
            <li><p>To:</p></li>
            <li><input type="text" name="firstName" placeholder="First Name..."></li>
            <li><p>Surname:</p></li>
            <li><input type="text" name="surname" placeholder="Surname..."></li>
            <li><p>Account Number:</p></li>
            <li><input type="text" name="accountNumber" placeholder="Account Number..."></li>
            <li><p>Sort Code:</p></li>
            <li><input type="text" name="sortCode" placeholder="Sort Code..."></li>
            <li><p>Amount:</p></li>
            <li><input type="text" name="amount" placeholder="Amount..."></li>
            <li><p>Ref:</p></li>
            <select name="choiceBox">
            <li><option value="friend">Sending to a friend</option>
            <li><option value="family">Sending to a family member</option>
            <li><option value="bills">Bills</option>
            </select>
            <li><button type="submit" name="submit">Send</button></li>
        </ul>
    </form>

    <?php
    if(isset($_GET['error'])){ // checks against the URL to see if the text error exists in the URL
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
    }
    ?>
</div>
</section>

<?php
include "footer.html";
?>


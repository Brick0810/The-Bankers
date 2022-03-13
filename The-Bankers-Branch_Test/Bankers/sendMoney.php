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
    <form action="include/sendmoney-include.php" method="post">
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


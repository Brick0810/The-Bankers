<?php
include "header.html";
include "include/functions.php";
include "include/connection.php";

include "transfersView.html";

if($_SESSION["userName"] != ""){ // Checks if the user is logged in, so they can access this page.

} else{
    header("location: login.php"); // Redirect to login page if they aren't logged in making them unable to access the sendMoney page
    exit();
}

$accountNumber = $_SESSION["accountNumber"];
echo "THIS IS A PLACEHOLDER, DESIGN NEEDS TO BE COMPLETELY CHANGED";
echo "<table border = 1>
    <tr>
       <th>Transaction ID</th>
        <th>Account Number</th>
        <th>Sort Code</th>
        <th>Amount</th>
        <th>Transaction Date</th>
        <th>Reference</th>
    </tr>";
displayTransfers($conn, $accountNumber);


include "footer.html";




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

// echo $row['userName'];

/* echo "<h1> Account </h1>";
foreach ($ as $) {
    echo "<li>";
    echo "Name: ";
    echo "{$["name"]}</a>"; */



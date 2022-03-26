<?php

session_start();

if(isset($_POST["submit"])) {
    $accountNumber = $_POST["accountNumber"];
    $sortCode = $_POST["sortCode"];
    $amount = $_POST["amount"];
    $reference = $_POST["choiceBox"];
    $accountNumberFrom = $_SESSION["accountNumber"];

    require_once "connection.php";
    require_once "functions.php";

    if (sendMoneyEmptyInput($accountNumber, $sortCode, $amount) !== false) {
        header("location: ../sendMoney.php?error=emptyInput");
        exit();
    }
    if (accountNumberExists($conn, $accountNumber) !== false) { // Calls function from function.php to check if any of the boxes are blank
        header("location: ../sendMoney.php?error=accountNumberIncorrect");
        exit();
    }
    if (sortCodeExists($conn, $sortCode, $accountNumber) !== false) {
        header("location: ../sendMoney.php?error=sortCodeIncorrect");
        exit();
    }
    if (balanceExists($conn, $accountNumberFrom, $amount) !== false) {
        header("location: ../sendMoney.php?error=notEnoughBalance");
        exit();
    }
    if ($amount < 0) { // Need to add a check to only allow numbers
        header("location: ../sendMoney.php?error=amountWrong");
        exit();
    }

    sendMoney($conn, $accountNumberFrom, $accountNumber, $sortCode, $amount, $reference);
} 
else{
    header("location: ../sendMoney.php");
    exit();
}
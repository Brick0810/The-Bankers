<?php

function signUpEmptyInput($firstName, $surname, $email, $userId, $password, $passwordRepeat): bool
{
    if (empty($firstName) || empty($surname) || empty($email) || empty($userId) || empty($password) || empty($passwordRepeat)){
        $result = true;
    } else{
        $result = false;
    }
    return $result;
}

function sendMoneyEmptyInput($accountNumber, $sortCode, $amount){
    if (empty($firstName) || empty($surname) || empty($accountNumber) || empty($sortCode) || empty($amount)){
        $result = true;
    } else{
        $result = false;
    }
    return $result;
}

function invalidUserID($userId): bool
{
    if (!preg_match("/^[a-zA-Z0-9]*$/", $userId)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function invalidEmail($email): bool
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){ // builtin function to take a parameter and check if it's a valid email type
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function passwordMatch($password, $passwordRepeat): bool
{
    if ($password !== $passwordRepeat){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function userIdExist($conn, $userName, $email){
    $sql = "SELECT * FROM users WHERE userName = ? OR usersEmail = ?;";
    $stmt = mysqli_stmt_init($conn); // initializing a connection to the database
    if(!mysqli_stmt_prepare($stmt, $sql)){ // Checks if the statement we want to run against the database is actually possible
        header("location: ../signup.php?error=stmt");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $userName, $email); // Binds the data from the user to the actual statement
    mysqli_stmt_execute($stmt); // executes the statement

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    } else{
        return false;
    }

    mysqli_stmt_close($stmt); // closes connection to database
}

function createUser($conn, $firstName, $surname, $email, $userName, $password)
{
    $sql = "INSERT INTO users(usersFirstName, UsersSurname, usersEmail, userName, usersPass) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn); // initializing a connection to the database
    if (!mysqli_stmt_prepare($stmt, $sql)) { // Checks if the statement we want to run against the database is actually possible
        header("location: ../signup.php?error=stmtFailed");
        exit();
    }

    $hashedPass = password_hash($password, PASSWORD_DEFAULT); // Hashes(encrypts) the password so its secure and a hacker can't see it

    mysqli_stmt_bind_param($stmt, "sssss", $firstName, $surname, $email, $userName, $hashedPass); // Binds the data from the user to the actual statement
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    createAccountDetails($conn, $userName);
}

function loginEmptyInput($userName, $password): bool
{
    if (empty($userName) || empty($password)){
        $result = true;
    } else{
        $result = false;
    }
    return $result;
}

function loginUser($conn, $userName, $password){
    $userIdExists = userIdExist($conn, $userName, $userName);

    if($userIdExists === false){
        header("location: ../login.php?error=loginIncorrect");
        exit();
    }

    $hashedPass = $userIdExists["usersPass"];
    $checkPass = password_verify($password, $hashedPass);

    if($checkPass === false){
        header("location: ../login.php?error=loginIncorrect");
        exit();
    }
    else if($checkPass === true){
        session_start();
        $_SESSION["accountNumber"] = getAccountNumber($conn, $userIdExists["userName"]);
        $_SESSION["userName"] = $userIdExists["userName"];
        header("location: ../index.php");
        exit();
    }
}

function generateAccountNumber($conn)
{

    $accountNumber = mt_rand(1000000, 9999999);
    if(accountNumberExists($conn, $accountNumber) !== false) // Checks if the account number it generated already exists
    {
        return $accountNumber;
    } else{
        generateAccountNumber($conn); // If an account number already exists, generate another one
    }
}

function accountNumberExists($conn, $accountNumber)
{
    $sql = "SELECT * FROM accounts WHERE accountNumber = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../sendMoney.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $accountNumber); // Binds the data from the user to the actual statement
    mysqli_stmt_execute($stmt); // executes the statement

    $resultData = mysqli_stmt_get_result($stmt);

    if (mysqli_fetch_assoc($resultData) > 0) {
        return false;
    } else {
        return true;
    }
}

function generateSortCode($conn, $accountNumber)
{
    $firstSection = mt_rand(100, 999);
    $secondSection = mt_rand(100, 999);
    $thirdSection = mt_rand(100, 999);
    $sortCode = $firstSection . "-" . $secondSection . "-" . $thirdSection;
    if(sortCodeExists($conn, $sortCode, $accountNumber) !== false) // Checks if the sort code it generated already exists
    {
        return $sortCode;
    } else{
        generateSortCode($conn);
    }
}

function sortCodeExists($conn, $sortCode, $accountNumber){
    $sql = "SELECT sortCode, accountNumber FROM accounts WHERE sortCode = ? AND accountNumber = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../sendMoney.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss",$sortCode, $accountNumber); // Binds the data from the user to the actual statement
    mysqli_stmt_execute($stmt); // executes the statement

    $resultData = mysqli_stmt_get_result($stmt);

    if (mysqli_fetch_assoc($resultData) > 0) {
        return false;
    } else {
        return true;
    }
}


function createAccountDetails($conn, $userName){
    $accountNumber = generateAccountNumber($conn);
    $accountType = "Personal";
    $sortCode = generateSortCode($conn, $accountNumber);
    $balance = 0;
    $sql = "INSERT INTO accounts(userName, accountNumber, balance, accountType, sortCode) VALUES (?, ?, ?, ?, ?);";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "siiss", $userName, $accountNumber, $balance, $accountType, $sortCode);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../signup.php?error=none");
    exit();
}

function getAccountNumber($conn, $userName)
{
    $sql = "SELECT accountNumber FROM accounts WHERE userName = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $userName); // Binds the data from the user to the actual statement
    mysqli_stmt_execute($stmt); // executes the statement

    $resultData = mysqli_stmt_get_result($stmt);

    if ($resultData > 0) {
        if ($row = mysqli_fetch_assoc($resultData)) {
            return $row["accountNumber"];
        }
    }
}

function displayAccountDetails($conn, $accountNumber)
{
    $sql = "SELECT userName, accountNumber, balance, sortCode, accountType FROM accounts WHERE accountNumber = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $accountNumber); // Binds the data from the user to the actual statement
    mysqli_stmt_execute($stmt); // executes the statement

    $resultData = mysqli_stmt_get_result($stmt);

    if ($resultData > 0) {
        if ($row = mysqli_fetch_assoc($resultData)) {
            return $row;
        }
    }
}

function balanceExists($conn, $accountNumberFrom, $amount){
    $sql = "SELECT balance FROM accounts WHERE accountNumber = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../sendMoney.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $accountNumberFrom); // Binds the data from the user to the actual statement
    mysqli_stmt_execute($stmt); // executes the statement

    $resultData = mysqli_stmt_get_result($stmt);

    if ($resultData > 0) {
        if ($row = mysqli_fetch_assoc($resultData)) {
            if(($row["balance"] - $amount) > 0){
                return false;
            } else{
                return true;
            }
        }
    }
}

function generateTransactionID($conn){
    $transactionID = mt_rand(0, 9999);
    if(transactionIdExists($conn, $transactionID) !== false)
    {
        return $transactionID;
    } else{
        generateTransactionID($conn);
    }
}

function transactionIdExists($conn, $transactionID): bool
{
    $sql = "SELECT * FROM transactions WHERE transactionID = $transactionID";
    $stmt = mysqli_query($conn, $sql);
    $resultData = mysqli_stmt_get_result($stmt);
    if ($resultData > 0)
    {
        return false;
    } else{
        return true;
    }
}

function displayTransfers($conn, $accountNumber)
{
    $sql = "SELECT * FROM transactions WHERE accountNumberFrom = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../sendMoney.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $accountNumber); // Binds the data from the user to the actual statement
    mysqli_stmt_execute($stmt); // executes the statement

    $resultData = mysqli_stmt_get_result($stmt);
    if ($resultData > 0)
    {
        while ($row = mysqli_fetch_assoc($resultData)) {
            echo "<tr><td>" . $row["transactionID"]. "</td><td>" . $row["accountNumberTo"] ."</td><td>" . $row["sortCodeTo"] .  "</td><td>" . $row["amount"] . "</td><td>" . $row["transactionDate"] . "</td><td>" . $row["reference"] . "</td></tr>";
        }
    } else{
        return true;
    }

}


function sendMoney($conn, $accountNumberFrom, $accountNumberTo, $sortCodeTo, $amount, $reference)
{
    $amount = intval($amount); // Changes amount from a string to an int to perform calculations
    $date = date_create()->format('Y-m-d H:i:s'); // Gets current date to store
    $transactionID = generateTransactionID($conn);

    $accountInfoFrom = displayAccountDetails($conn, $accountNumberFrom);
    $accountFromBalance = intval($accountInfoFrom["balance"]);

    $accountInfoTo = displayAccountDetails($conn, $accountNumberTo);
    $accountToBalance = intval($accountInfoTo["balance"]);

    $accountFromBalance = $accountFromBalance - $amount;
    $accountToBalance = $accountToBalance + $amount;

    $sql = "INSERT INTO transactions(transactionID, accountNumberFrom, accountNumberTo, sortCodeTo, amount, transactionDate, reference) VALUES ('$transactionID', '$accountNumberFrom', '$accountNumberTo', '$sortCodeTo','$amount','$date', '$reference')"; // Inserts transactions details to transactions table in data base
    mysqli_query($conn, $sql);

    $sql = "UPDATE accounts SET balance = '$accountFromBalance' WHERE accountNumber = '$accountNumberFrom' "; // Updates the balance of the account that's sent the amount
    mysqli_query($conn, $sql);

    $sql = "UPDATE accounts SET balance = '$accountToBalance' WHERE accountNumber = '$accountNumberTo' "; // Updates the balance of the account that's receiving the amount
    mysqli_query($conn, $sql);
    header("location: ../sendMoney.php?error=none");
    exit();
}








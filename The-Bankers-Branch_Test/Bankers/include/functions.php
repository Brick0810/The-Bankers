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

function sendMoneyEmptyInput($firstName, $surname, $accountNumber, $sortCode, $amount){
    if (empty($firstName) || empty($surname) || empty($accountNumber) || empty($sortCode) || empty($amount)){
        $result = true;
    } else{
        $result = false;
    }
    return $result;
}

function invalidUserID($userId): bool
{
    $result;
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
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){ // builtin function to take a parameter and check if it's an email
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
    $result;
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
        $_SESSION["userId"] = $userIdExists["usersId"];
        $_SESSION["userName"] = $userIdExists["userName"];
        header("location: ../index.php");
        exit();
    }
}

function generateAccountNumber(): int
{

    return mt_rand(1000000, 9999999);
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

function generateSortCode(): string
{
    $firstSection = mt_rand(100, 999);
    $secondSection = mt_rand(100, 999);
    $thirdSection = mt_rand(100, 999);
    $sortCode = $firstSection . "-" . $secondSection . "-" . $thirdSection;
    return $sortCode;
    /* if(!sortCodeExists($sortCode))
    {
        return $sortCode;
    } else{
        generateSortCode();
    } */
}

function sortCodeExists($conn, $accountNumber, $sortCode){
    $sql = "SELECT * FROM accounts WHERE accountNumber = ? AND sortCode = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../sendMoney.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "is", $accountNumber, $sortCode); // Binds the data from the user to the actual statement
    mysqli_stmt_execute($stmt); // executes the statement

    $resultData = mysqli_stmt_get_result($stmt);

    if (mysqli_fetch_assoc($resultData) > 0) {
        return false;
    } else {
        return true;
    }
}


function createAccountDetails($conn, $userName){
    $accountNumber = generateAccountNumber();
    $accountType = "Personal";
    $sortCode = generateSortCode();
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

function displayAccountDetails($conn, $userName)
{
    $sql = "SELECT userName, accountNumber FROM accounts WHERE userName = ?;";
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
            return $row;
        }
    }
}

function balanceExists($conn, $userName, $amount){
    $sql = "SELECT balance FROM accounts WHERE userName = ?;";
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
            if(($row["balance"] - $amount) > 0){
                return false;
            } else{
                return true;
            }
        }
    }
}







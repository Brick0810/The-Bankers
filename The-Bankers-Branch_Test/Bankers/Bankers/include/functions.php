<?php

function signUpEmptyInput($firstName, $surname, $email, $userId, $password, $passwordRepeat){
    $result;
    if (empty($firstName) || empty($surname) || empty($email) || empty($userId) || empty($password) || empty($passwordRepeat)){
        $result = true;
    } else{
        $result = false;
    }
    return $result;
}

function invalidUserID($userId){
    $result;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $userId)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function invalidEmail($email){
    $result;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){ // builtin function to take a parameter and check if it's an email
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function passwordMatch($password, $passwordRepeat){
    $result;
    if ($password !== $passwordRepeat){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function userIdExist($conn, $userId, $email){
    $sql = "SELECT * FROM users WHERE usersId = ? OR usersEmail = ?;";
    $stmt = mysqli_stmt_init($conn); // initializing a connection to the database
    if(!mysqli_stmt_prepare($stmt, $sql)){ // Checks if the statement we want to run against the database is actually possible
        header("location: ../signup.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $userId, $email); // Binds the data from the user to the actual statement
    mysqli_stmt_execute($stmt); // executes the statement

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        return $row;

    } else{
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt); // closes connection to database
}

function createUser($conn, $firstName, $surname, $email, $userName, $password)
{
    $sql = "INSERT INTO users(usersFirstName, UsersSurname, usersEmail, userName, usersPass) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn); // initializing a connection to the database
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtFailed");
        exit();
    }

    $hashedPass = password_hash($password, PASSWORD_DEFAULT); // Hashes(encrypts) the password so its secure and a hacker can't see it

    mysqli_stmt_bind_param($stmt, "sssss", $firstName, $surname, $email, $userName, $hashedPass);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../signup.php?error=none");
    exit();
}

function loginEmptyInput($userName, $password){
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
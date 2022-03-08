<?php

if(isset($_POST["submit"])) {
    $firstName = $_POST["firstName"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $userName = $_POST["userName"];
    $password = $_POST["password"];
    $passwordRepeat = $_POST["passwordRepeat"];

    require_once 'connection.php';
    $conn = mysqli_connect(DB_DATA_SOURCE,DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    require_once 'functions.php';

    if(signUpEmptyInput($firstName, $surname, $email, $userName, $password, passwordrepeat) !== false){ // Calls function from function.php to check if any of the boxes are blank
        header("location: ../signup.php?error=emptyInput");
        exit();
    }

    if(invalidUserID($userName) !== false){
        header("location: ../signup.php?error=invalidID");
        exit();
    }

    if (invalidEmail($email) !== false){
        header("location: ../signup.php?error=invalidEmail");
        exit();
    }

    if(passwordMatch($password, $passwordRepeat) !== false){
        header("location: ../signup.php?error=invalidPasswordMatch");
        exit();
    }

    if (userIdExist($conn, $userName, $email) !== false){
        header("location: ../signup.php?error=userIdExists");
        exit();
    }

    createUser($conn, $firstName, $surname, $email, $userName, $password);
}

else {
    header("location: ../signup.php");
    exit();
}
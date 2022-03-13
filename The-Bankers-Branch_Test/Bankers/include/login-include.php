<?php

if(isset($_POST["submit"])) {

    $userName = $_POST["name"];
    $password = $_POST["password"];

    require_once 'connection.php';
    require_once 'functions.php';

    if(loginEmptyInput($userName, $password) !== false){ // Calls function from function.php to check if any of the boxes are blank
        header("location: ../login.php?error=emptyInput");
        echo "Username: " . $userName . "Password: " . $password;
        exit();
    }

    loginuser($conn, $userName, $password);
} 
else{
    header("location: ../login.php");
    exit();
}
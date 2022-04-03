<?php
$dbServerName = "localhost";
$dbUserName = "u2066800";
$dbPassword = "DM02aug02dm";
$dbName = "u2066800";

$conn = mysqli_connect($dbServerName, $dbUserName, $dbPassword, $dbName);

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}

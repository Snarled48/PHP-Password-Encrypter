<?php
require 'Encryption.php';
var_dump($_POST);
$password = $_POST['Pass'];
$ID = $_POST['ID'];
$User = $_POST['user'];



$con = mysqli_connect('localhost', 'root', '', 'ENCRYPTIONDB');

// Cryptage de donner 
$keyword = "Kryptos"; // Secret keyword for encryption
$result = kryptosEncrypt($password, $keyword);
$encryptedPassword = $result['encrypted'];
$salt = $result['salt'];

$stmt = mysqli_prepare($con, "INSERT INTO USERS (id, username, pass, salt) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "ssss", $ID, $User, $encryptedPassword, $salt);
$res = mysqli_stmt_execute($stmt);

if ($res) {
    echo "User Created Successfully";
} else {
    echo "Error: " . mysqli_stmt_error($stmt);
}

mysqli_stmt_close($stmt);
mysqli_close($con);

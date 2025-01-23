<?php
$host = "localhost";
//$user = "sajibgpo_tr"; // Your DB username
//$pass = "Capix@2024"; // Your DB password

$user = "root"; // Your DB username
$pass = ""; // Your DB password

$dbname = "sajibgpo_transaction_reports";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

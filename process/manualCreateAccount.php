<?php
$password = "letM3inN0w";
$hashed_password = password_hash($password, PASSWORD_BCRYPT);
echo $hashed_password;
?>
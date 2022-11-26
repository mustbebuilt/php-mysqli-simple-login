<?php
// Registration Logic Here
require('/includes/sessions.inc.php');
require('/includes/conn.inc.php');
$regLogin = filter_var($_POST['userLogin'], FILTER_VALIDATE_EMAIL);
$regPassword = $_POST['password'];
$regPasswordConfirm = $_POST['passwordConfirm'];
// invalid email
if(!$regLogin){ 
    $_SESSION['regError'] = 1; 
    $referer = "register.php"; 
    header("Location: ../".$referer);
    exit;
}
// password match
if($regPassword != $regPasswordConfirm || $regPassword == ""){
    $_SESSION['regError'] = 2;
    $referer = "register.php";
    header("Location: ../".$referer);
    exit;
}else{ 
    // Password is valid 
    // Code to Check if the user has already registered
    $sql= "SELECT * FROM users WHERE userLogin = ?";
    $stmt = $mysqli->prepare($sql);
	$stmt->bind_param('s', $regLogin);
    $stmt->execute();
    $result = $stmt->get_result();
	$numUsers = $result->num_rows;
    if($numUsers == 1){
        $_SESSION['regError'] = 3;
        $referer = "register.php";
    }else{
        // store their details
        $sql= "INSERT INTO users(userLogin, userPassword) 
        VALUES (?, ?)";
        $stmt = $mysqli->prepare($sql);
        $hashedPw = password_hash($regPassword, PASSWORD_BCRYPT);
        $stmt->bind_param('ss', $regLogin, $hashedPw);
        $stmt->execute();
        if(isset($_SESSION['regError'])){ 
            unset($_SESSION['regError']);
        }
        $referer = "login.php";
    }
}
header("Location: ../".$referer);
exit;
?>
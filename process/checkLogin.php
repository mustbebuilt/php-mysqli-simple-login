<?php
// check login logic here
require('/includes/sessions.inc.php');
require('/includes/conn.inc.php');
$userLogin = filter_var($_POST['userLogin'], FILTER_VALIDATE_EMAIL);
$userpassword = $_POST['password'];
if($userLogin){ 
    // email good 
    // check if in database next
    $sql= "SELECT * FROM users WHERE userLogin = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('s', $userLogin);
    $stmt->execute();
    $result = $stmt->get_result();
	$numUsers = $result->num_rows;
    if($numUsers == 0){
        // email not in database error
        $_SESSION['loginError'] = 1;
        $referer = "login.php";
    }else{
        // check password next
        $obj = $result->fetch_object();
        $dbPasswordHash = $obj->userPassword;
        if(password_verify($userpassword, $dbPasswordHash)) {
            unset($_SESSION['loginError']);
            $_SESSION['login'] = 1;
            $referer = "index.php";
        }else{
            // database does not match error
            $_SESSION['loginError'] = 1;
            $referer = "login.php";
        }
    }
    
}else{ 
    // not valid email error 
    $_SESSION['loginError'] = 1;
    $referer = "login.php";
}
header("Location: ../".$referer);
?>
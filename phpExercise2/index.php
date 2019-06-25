<?php
session_start();
include_once 'class.user.php';
$user = new User();
if (!empty($_SESSION['message'])) {
    echo '<p>'.$_SESSION['message'].'</p>';
    unset($_SESSION['message']);
}
$blockIpData = json_decode(@file_get_contents("blockedip.json"),true);
if(count($blockIpData)>0) {
    foreach($blockIpData as $key=>$blockedIp){
        if($_SERVER['REMOTE_ADDR']==$blockedIp['ip_address']){
            if($blockedIp['timeout']>date("Y-m-d H:i:s")){
                @header("location:blocked.html");
                exit;
            } else {
                unset($blockIpData[$key]);
                $_SESSION['num_login_fail'] = 0;
                @header("location:index.php");
                file_put_contents("blockedip.json",json_encode($blockIpData));
            }
            break;
        }
    }
}
if(isset($_SESSION['num_login_fail']))
{

    if($_SESSION['num_login_fail'] >= 3)
    {
        $blockIpData = json_decode(@file_get_contents("blockedip.json"),true);
        $blockIpData[] = array(
            "ip_address"=>$_SERVER['REMOTE_ADDR'],
            "timeout"=>date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")."+ 1 Minutes"))
        );
        file_put_contents("blockedip.json",json_encode($blockIpData));

    }
}
if (isset($_POST['submit'])) {
    extract($_POST);
    $login = $user->checkLogin($emailusername, $password);
    if ($login) {
        $_SESSION['num_login_fail'] = 0;
        header("location:home.php");
    } else {
        $_SESSION['num_login_fail'] ++;
        echo "<script>console.log(".$_SESSION['num_login_fail'].")</script>";
        //$_SESSION['last_login_time'] = time();
        echo 'Wrong username or password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Blog Poster</title>
    <meta charset="utf-8">
    <title>Home</title>
    <!-- <link rel="stylesheet" href="assets/css/bootstrap.min.css" /> -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>

<body style="background-color:#d9d9d9">
<nav class="navbar navbar-expand-sm bg-secondary navbar-dark justify-content-center">
    <ul class="navbar-nav">
        <li class="nav-item active">
            <a class="nav-link" href="index.php"><h2>Blog Poster</h2></a>
        </li>
    </ul>
</nav>
<div id="container" class="container text-center w-75">
    <h3 class="mt-3 mb-3">Login Here</h3>
    <form action="" method="post" name="login">
        <div class="form-group ">
            <label for="emailusername">Email or Username</label>
            <input type="text" class="form-control text-center" name="emailusername" id="emailusername" placeholder="Enter or Username..." required>
        </div>
        <div class="form-group ">
            <label for="InputPassword">Password</label>
            <input type="password" class="form-control text-center" id="InputPassword" name="password" placeholder="Password..." required>
        </div>
        <input class="btn bg-dark text-white mb-2 " type="submit" name="submit" value="Login" onclick="submitlogin();"><br>
        <a class="mt-2" href="registration.php">Register new user</a>

    </form>
</div>
<script>
    function submitlogin() {
        var form = document.login;
        if (form.emailusername.value == "") {
            alert("Enter email or username.");
            return false;
        } else if (form.password.value == "") {
            alert("Enter password.");
            return false;
        }
    }
</script>
</body>

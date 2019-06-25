<?php
include_once 'class.user.php';
$user = new User();

if (isset($_POST['submit'])){
    extract($_POST);
    if (!filter_var($uemail, FILTER_VALIDATE_EMAIL)){
        echo "<div style='text-align:center'>Invalid Email.</div>";
    } else {
        $register = $user->regUser($firstName, $lastName, $uname, $upass, $uemail);
        if ($register) {
            echo "<div style='text-align:center'>Registration successful <a href='index.php'>Click here</a> to login</div>";
        } else {
            echo "<div style='text-align:center'>Registration failed. Email or Username already exits please try again.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Registration</title>
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
    <h3 class="mt-3 mb-3">Register Here</h3>
    <form action="" method="post" name="regForm">
        <div class="form-group ">
            <label for="name">First Name</label>
            <input type="text" class="form-control text-center" name="firstName" id="name" placeholder="First Name..." required>
        </div>
        <div class="form-group ">
            <label for="last">Last Name</label>
            <input type="text" class="form-control text-center" name="lastName" id="last" placeholder="Last Name..." required>
        </div>
        <div class="form-group ">
            <label for="user">Username</label>
            <input type="text" class="form-control text-center" name="uname" id="user" placeholder="Username..." required>
        </div>
        <div class="form-group ">
            <label for="email">Email</label>
            <input type="email" class="form-control text-center" name="uemail" id="email" placeholder="Email..." required>
        </div>
        <div class="form-group ">
            <label for="Pass">Password</label>
            <input type="password" class="form-control text-center" id="Pass" name="upass" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="Password..." required>
            <p>Password requirements:<br> Must be 8 characters long<br>Must have  capitol letter<br>Must have at least one number</p>
        </div>
            <input class="btn bg-dark text-white" type="submit" name="submit" value="Register" onclick="submitReg()"><br>
            <a href="index.php">Already registered? Click Here!</a>
    </form>
</div>

<script>
    function submitReg() {
        var form = document.regForm;
        if (form.firstName.value == "") {
            alert("Enter name.");
            return false;
        } else if (form.lastName.value == "") {
            alert("Enter username.");
            return false;
        }else if (form.uname.value == "") {
            alert("Enter username.");
            return false;
        } else if (form.upass.value == "") {
            alert("Enter password.");
            return false;
        } else if (form.uemail.value == "") {
            alert("Enter email.");
            return false;
        }
    }
</script>
</body>

</html>

<?php
include_once 'class.user.php';
$user = new User();

if (isset($_POST['id'])) {
    extract($_POST);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo false;
    } else {
        $user->updateUser($firstName, $lastName, $userName, $email, $id);
        echo true;
    }
}
if (isset($_POST['postId'])) {
    extract($_POST);
    if ($user->deletePost($postId)) {
        echo true;
    } else {
        echo false;
    }
}
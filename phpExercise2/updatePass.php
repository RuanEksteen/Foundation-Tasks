<?php
include_once 'class.user.php';
$user = new User();

if (isset($_POST['id'])) {
    extract($_POST);
    if ($user->changePassword($id, $oldPass, $newPass)) {
        echo true;
    } else {
        echo false;
    }
}

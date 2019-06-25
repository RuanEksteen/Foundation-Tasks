<?php
include_once 'class.user.php';
$user = new User();

if (isset($_POST['postStr'])) {
    extract($_POST);
    $postResultBool = $user->createPost( $id , $postStr );
    if (!$postResultBool) {
        // update table here
        echo "Something went Wrong";
    }
}
if (isset($_POST['numPost'])) {
    $user->displayMorePosts($_POST['numPost']);
} else {
    echo "nay";
}
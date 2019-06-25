<?php
session_start();
include_once 'class.user.php';
$user = new User();
$id = $_SESSION['id'];
if (!$user->getSession()){
    $_SESSION['message'] = 'You are not logged in Please log in';
    header("location:index.php");
}
if (isset($_GET['q'])){
    $user->userLogout();
    header("location:index.php");
}
if (isset($_POST['create'])) {
    extract($_POST);
    $create = $user->createPost($id, $postText);
    if (!$create) {
        echo "<div style='text-align:center'>Post Creation failed.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Home</title>
   <!-- <link rel="stylesheet" href="assets/css/bootstrap.min.css" /> -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>

<body style="background-color:#d9d9d9" >
<nav class="navbar navbar-expand-sm bg-secondary navbar-dark justify-content-center">
    <ul class="navbar-nav">
        <li class="nav-item active">
            <a class="nav-link" href="home.php">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="profile.php">Profile</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="home.php?q=logout">Logout</a>
        </li>
    </ul>
</nav>
<br>
<div id="container" class="container">
    <div id="header" class="jumbotron text-center pt-3 pb-3">
        <h3>
            Hello <?php echo $user->getUsername($id); ?>
        </h3>
        <p>Below you can see posts from all users.<br> You can add your own posts! Give it a try.</p>
    </div>

    <div id="main-body">
        <div class="container text-center">
            <!-- Button to Open the Modal -->
            <h3 class="text-center">Posts</h3><br>
            <button type="button" class="btn bg-dark text-white mb-3" data-toggle="modal" data-target="#myModal">
                Create Post
            </button>
            <br>
            <!-- The Modal -->
            <div class="modal" id="myModal">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Post Creation</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <form action="" method="post" name="create" id="createForm">
                                <div class="form-group">
                                    <label for="email">What is on your mind...</label><br>
                                    <textarea name="postText" form="createForm" placeholder="Enter Text Here..." rows="5" cols="50" ></textarea>
                                </div>

                            </form>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <input class="btn btn-primary" type="submit" name="create" value="Create" onclick="createPost();">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="footer" >
        <?php $user->displayPosts(); ?>
    </div>
    <div class="container  pt-3 pb-3 mb-3 text-center">
    <input class="btn bg-dark text-white mb-3" type="button" name="show" value="Show more" onclick="showMore();">
    </div>
</div>
<script>
    function createPost() {
        let form = document.create;
        let postStr = form.postText.value;
        let id = <?php echo $id ?>;
        if (form.postText.value == "") {
            alert("Blank posts not allowed.");
            return false;
        } else {
            $.post( "updatePost.php", {id : id, postStr : postStr}, function(  ) {
                $("#myModal").modal('toggle');
                location.reload(true);
            });
        }
    }
    let numPost = 5;
    function showMore(){
        $.post( "updatePost.php", {numPost : numPost}, function (data) {
           $('#footer').append(data);
           numPost = numPost + 5;
        });
    }

</script>
</body>

</html>

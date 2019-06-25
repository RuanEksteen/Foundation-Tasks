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
    <title>Profile</title>
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
        <li class="nav-item ">
            <a class="nav-link" href="home.php">Home</a>
        </li>
        <li class="nav-item active">
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
            <?php echo $user->getUsername($id); ?> <br> Profile page
        </h3>

    </div>

    <div id="main-body">
        <div class="container text-center">
            <button type="button" class="btn bg-dark text-white mr-1 mb-1" data-toggle="modal" data-target="#myProfileModal">
                Edit Profile
            </button>
            <button type="button" class="btn bg-dark text-white mr-1 mb-1" data-toggle="modal" data-target="#myPassModal">
                Change Password
            </button>

            <h3 class="text-center mt-3">Your Posts</h3>
            <!-- Button to Open the Modal -->
            <button type="button" class="btn bg-dark text-white mr-1 mb-3" data-toggle="modal" data-target="#myModal">
                Create Post
            </button>
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
                                    <textarea name="postText" form="createForm" placeholder="Enter Text Here..." rows="5" cols="40" ></textarea>
                                </div>

                            </form>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <input class="btn bg-dark text-white" type="submit" name="create" value="Create" onclick="createPost();"></button>
                            <button type="button" class="btn bg-dark text-white" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- The second Modal for profile edits -->
            <div class="modal" id="myProfileModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Update Profile</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <form action="" method="post" name="profile" id="profileForm">
                                <div class="form-group">

                                    <?php echo $user->getUserProfile($id); ?>
                                </div>

                            </form>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <input class="btn bg-dark text-white" type="submit" name="create" value="Update" onclick="editProfile();">
                            <button type="button" class="btn bg-dark text-white" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- The third Modal for password edits -->
            <div class="modal" id="myPassModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Change Password</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <form action="" method="post" name="pass" id="passForm">
                                <div class="form-group">
                                    <label for="oldPass">Enter Old Password:</label>
                                    <input type='password' class="form-control text-center" id='oldPass'>
                                </div>
                                <div class="form-group">
                                    <label for="newPass">Enter New Password:</label>
                                    <input type='password' class="form-control text-center" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" id='newPass'>
                                </div>
                                <div class="form-group">
                                    <label for="confirmPass">Confirm New Password:</label>
                                    <input type='password' class="form-control text-center" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" id='confirmPass'>
                                    <p>Password requirements:<br> Must be 8 characters long<br>Must have  capitol letter<br>Must have at least one number</p>
                                </div>
                        </div>
                            <div class="modal-footer form-group">
                                <input class="btn bg-dark text-white" type="submit" name="create" value="Update" onclick="editPass();">
                                <button type="button" class="btn bg-dark text-white" data-dismiss="modal">Close</button>
                            </div>
                            </form>
                    </div>
                        <!-- Modal footer -->
                    </div>
                </div>
            </div>

    </div>

    <div id="footer">
        <?php $user->displayUserPosts($id); ?>
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

    function editProfile() {
        let form = document.profile;
        let firstName = form.firstName.value;
        let lastName = form.lastName.value;
        let userName = form.userName.value;
        let email = form.email.value;
        let id = <?php echo $id ?>;
        if (form.firstName.value == "") {
            alert("Enter name.");
            return false;
        } else if (form.lastName.value == "") {
            alert("Enter username.");
            return false;
        } else if (form.userName.value == "") {
            alert("Enter username.");
            return false;
        } else if (form.email.value == "") {
            alert("Enter email.");
            return false;
        }
        else {
            $.post( "updateProfile.php", {id : id, firstName : firstName, lastName : lastName, userName : userName, email : email}, function( data ) {
                if (checkBool(data) == true) {
                    alert("Success");
                    location.reload(true);
                } else {
                    alert ("Invalid email");

                }
            });
        }
    }
    function editPass() {
        let form = document.pass;
        let oldPass = form.oldPass.value;
        let newPass = form.newPass.value;
        let confirmPass = form.confirmPass.value;
        let id = <?php echo $id ?>;
        if (newPass == confirmPass) {
            $.post("updatePass.php", {id: id, oldPass: oldPass, newPass: newPass}, function (data) {
               if (checkBool(data) == true) {
                   alert("Password changed");
                   location.reload(true);
               } else {
                   alert ("Incorrect Password entered");
                   $('#passForm')[0].reset();
               }
            });
        } else {
            alert("Passwords Do Not Match!");
            $('#passForm')[0].reset();
        }
    }
    function deletePost () {
        let postId = $('div[name=divName]').attr('id');
        $.post("updateProfile.php", {postId: postId}, function (data) {
            if (checkBool(data) == true) {
            alert("Deleted");
            location.reload(true);
            } else {
                alert ("Delete failed");
            }
        });

    }
    function checkBool(data) {
        if (data == false) {
            return false;
        } else {
            return true;
        }
    }

</script>
</body>

</html>


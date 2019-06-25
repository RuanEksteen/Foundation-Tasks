<?php
include "db_config.php";
class User{
    protected $db;
    public function __construct(){
        $this->db = new DB_con();
        $this->dbObj = $this->db->retObj();
    }


    public function regUser($firstName,$lastName,$userName,$password,$email){
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->dbObj->prepare("SELECT * FROM users WHERE Username = ? OR EmailAddress = ?");
        $stmt->bind_param("ss", $userName,$email);
        $stmt->execute();
        $resultSql = $stmt->get_result();
        $stmt->close();
        $countRow = $resultSql->num_rows;
        if($countRow == 0){
            $stmt = $this->dbObj->prepare("INSERT INTO users SET Username = ?, Password = ?, FirstName = ?, LastName = ?,EmailAddress = ?");
            $stmt->bind_param("sssss", $userName,$password, $firstName, $lastName, $email);
            if($stmt->execute()){
                $stmt->close();
                $this->db->closeDb();
                return true;
            } else {
                $this->db->closeDb();
                return false;
            }
        } else {
            $this->db->closeDb();
            return false;
        }

    }
//lazy loading
    public function createPost($id,$post) {
        $post = strip_tags($post);
        $stmt = $this->dbObj->prepare("INSERT INTO posts SET PostText = ? , userId = ?");
        $stmt->bind_param("si", $post,$id);
        $stmt->execute();
        $resultSql = $stmt->get_result();
        $stmt->close();
        if ($resultSql) {
            $this->db->closeDb();
            return true;
        } else {
            $this->db->closeDb();
            return false;
        }
    }

    public function displayPosts() {
        $stmt = $this->dbObj->prepare("SELECT * FROM posts ORDER BY PostTimeStamp DESC LIMIT 0,5");
        $stmt->execute();
        $resultSql = $stmt->get_result();
        while ($rowArr = $resultSql->fetch_assoc()) {
            echo "<div class='container  pt-3 pb-3 mb-3' style='word-wrap:break-word; background-color: #e9ecef ' id = ".$rowArr['id'].">";
            echo "<h4>".$this->getUsername($rowArr['userId'])."</h4>";
            echo "<h6>".$rowArr['PostText']."</h6>";
            echo "<p class='text-right'> Posted on ".$rowArr['PostTimeStamp']."</p>";
            echo "</div>";
        }
    }
    public function displayMorePosts($postNum) {
        $stmt = $this->dbObj->prepare("SELECT * FROM posts ORDER BY PostTimeStamp DESC LIMIT ".$postNum.",5");
        $stmt->execute();
        $resultSql = $stmt->get_result();
        if ($resultSql->num_rows > 0) {
            while ($rowArr = $resultSql->fetch_assoc()) {
                echo "<div class='container  pt-3 pb-3 mb-3' style='word-wrap:break-word; background-color: #e9ecef ' id = ".$rowArr['id'].">";
                echo "<h4>".$this->getUsername($rowArr['userId'])."</h4>";
                echo "<h6>".$rowArr['PostText']."</h6>";
                echo "<p class='text-right'> Posted on ".$rowArr['PostTimeStamp']."</p>";
                echo "</div>";
            }
        } else {
            echo "<script>alert('No More Results Left');</script>";
        }
    }
    public function displayUserPosts($id) {
        $stmt = $this->dbObj->prepare("SELECT * FROM posts WHERE UserId = ? ORDER BY PostTimeStamp DESC ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultSql = $stmt->get_result();
        while ($rowArr = $resultSql->fetch_assoc()) {
            echo "<div class='container  pt-3 pb-3 mb-3' style='word-wrap: break-word; background-color: #e9ecef' name='divName' id = ".$rowArr['id']." >";
            echo "<h4>".$this->getUsername($rowArr['userId'])."</h4>";
            echo "<h6>".$rowArr['PostText']."</h6>";
            echo "<p class='text-right'> Posted on ".$rowArr['PostTimeStamp']."</p>";
            echo "<input class='btn bg-dark text-white btn-sm ' type='submit' name='delete' value='Delete Post' onclick='deletePost();'>";
            echo "</div>";
        }

    }
    public function updateUser( $firstName,$lastName,$userName,$email, $id ) {
        strip_tags($firstName);
        strip_tags($lastName);
        strip_tags($userName);
        strip_tags($email);
        $stmt = $this->dbObj->prepare("UPDATE users SET FirstName = ?, LastName = ?, Username = ?, EmailAddress = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $firstName,$lastName, $userName, $email , $id);
        if ($stmt->execute()) {
            $stmt->close();
            $this->db->closeDb();
            return true;
        } else {
            $stmt->close();
            $this->db->closeDb();
            return false;
        }

    }

    public function getUserProfile($id) {
        $stmt = $this->dbObj->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultSql = $stmt->get_result();
        while ($rowArr = $resultSql->fetch_assoc()) {
            echo "<div class=\"form-group \">";
            echo "<label for=\"firstName\">First Name</label>";
            echo "<input type='text' class=\"form-control text-center\" id='firstName' value='".$rowArr['FirstName']."'>";
            echo "</div>";
            echo "<div class=\"form-group \">";
            echo "<label for=\"lastName\">Last Name</label>";
            echo "<input type='text' class=\"form-control text-center\" id='lastName' value='".$rowArr['LastName']."'>";
            echo "</div>";
            echo "<div class=\"form-group \">";
            echo "<label for=\"email\">Email</label>";
            echo "<input type='test' class=\"form-control text-center\" id='email' value='".$rowArr['EmailAddress']."'>";
            echo "</div>";
            echo "<div class=\"form-group \">";
            echo "<label for=\"userName\">Username</label>";
            echo "<input type='text' class=\"form-control text-center\" id='userName' value='".$rowArr['Username']."'>";
            echo "</div>";
        }
       //$this->db->closeDb();
    }
    public function changePassword($id, $oldPass, $newPass) {
        strip_tags($oldPass);
        strip_tags($newPass);
        $stmt = $this->dbObj->prepare("SELECT Password FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultSql = $stmt->get_result();
        $userPass = $resultSql->fetch_assoc();
        $stmt->close();
        if (password_verify($oldPass , $userPass['Password'])) {
            $newPass = password_hash($newPass, PASSWORD_DEFAULT);
            $stmt = $this->dbObj->prepare("UPDATE users SET Password = ? WHERE id = ?");
            $stmt->bind_param("si", $newPass , $id);
            if ($stmt->execute()) {
                $stmt->close();
                $this->db->closeDb();
                return true;
            } else {
                $stmt->close();
                $this->db->closeDb();
                return false;
            }
        } else {
            $this->db->closeDb();
            return false;
        }
    }

    public function checkLogin($emailUsername, $password){
        $stmt = $this->dbObj->prepare("SELECT id, Password FROM users WHERE Username = ? OR EmailAddress = ?");
        $stmt->bind_param("ss", $emailUsername,$emailUsername);
        $stmt->execute();
        $resultSql = $stmt->get_result();
        $userData = $resultSql->fetch_assoc();
        $stmt->close();
        $countRow = $resultSql->num_rows;
        if ($countRow == 1 && password_verify($password, $userData['Password'])) {
            $_SESSION['login'] = true;
            $_SESSION['id'] = $userData['id'];
            $stmt->execute();
            $this->db->closeDb();
            return true;
        }
        else {
            $this->db->closeDb();
            return false;
        }
    }


    public function getUsername($id){
        $stmt = $this->dbObj->prepare("SELECT Username FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultSql = $stmt->get_result();
        $userData = $resultSql->fetch_assoc();
        $stmt->close();
        return $userData['Username'];
    }

    public function deletePost($postId) {
        $stmt = $this->dbObj->prepare("DELETE FROM posts WHERE id = ?");
        $stmt->bind_param("i", $postId);
        if ($stmt->execute()) {
            $stmt->close();
            $this->db->closeDb();
            return true;
        } else {
            $stmt->close();
            $this->db->closeDb();
            return false;
        }
    }

    public function getSession(){
        return $_SESSION['login'];
    }

    public function userLogout() {
        $_SESSION['login'] = FALSE;
        unset($_SESSION);
        session_destroy();
    }
}

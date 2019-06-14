<?php
include 'person.class.php';
$personClassObj = new person();
$connObj = $personClassObj->OpenCon();
if($_POST['btnId']== 1) {
    $id = $_POST['id'];
    $personClassObj->loadPerson($connObj, $id);
} elseif ($_POST['btnId']== 2) {
    $id = $_POST['id'];
    $personClassObj->deletePerson($connObj, $id);
} elseif ($_POST['btnId']== 3) {
    if (!empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['DateOfBirth']) && !empty($_POST['email'])/*&& !empty($_POST['age'])*/) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $DateOfBirth = $_POST['DateOfBirth'];
        $Email = $_POST['email'];
        $Age = floor((time() - strtotime($DateOfBirth)) / 31556926);
        if (!preg_match("/^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/",$DateOfBirth)) {
            exit("Please enter correct date format dd/mm/yyyy");
        }
        if (!filter_var($Email, FILTER_VALIDATE_EMAIL)){
            exit("Invalid email") ;
        }
        if ($Age < 0) {
            exit ("You are not born yet... Please try again with Valid dates");
        } elseif ($Age > 110) {
            exit("Holy crap you are old...Please try again with Valid dates");
        }
        $personClassObj->savePerson($id, $name, $surname, $DateOfBirth, $Email, $Age, $connObj);
    } else {
        echo "Please ensure that all fields are filled in";
    }
} elseif ($_POST['btnId']== 4) {
    $personClassObj->addRandomTen($connObj);
} elseif ($_POST['btnId']== 5) {
    $personClassObj->deleteAllPeople($connObj);
}elseif ($_POST['btnId']== 6) {
    $id = null;
    $personClassObj->loadPerson($connObj,$id);
} else {
    echo "Something went Wrong";
}
<?php
class person
{
    public function OpenCon() {
        $dbhostStr = "localhost";
        $dbuserStr = "root";
        $dbpassStr = "123";
        $dbStr = "persons_db";
        $connObj = new mysqli($dbhostStr, $dbuserStr, $dbpassStr,$dbStr) or die("Connect failed: %s\n". $connObj->error);
        return $connObj;
    }
    public function CloseCon($connObj) {
        $connObj->close();
    }
    public function addRandomTen($connObj) {
        $randomArr = array(
            array("Name"=>"Eugenia","Surname"=>"Valenzuela","DateOfBirth"=>"11/26/1947","EmailAddress"=>"dapibus.rutrum.justo@cursusvestibulumMauris.com","Age"=>44),
            array("Name"=>"Nigel","Surname"=>"Schroeder","DateOfBirth"=>"03/03/1967","EmailAddress"=>"Mauris@Curabitur.org","Age"=>2),
            array("Name"=>"Veronica","Surname"=>"Reilly","DateOfBirth"=>"11/22/1956","EmailAddress"=>"mauris.sit.amet@sapienmolestie.edu","Age"=>97),
            array("Name"=>"Merrill","Surname"=>"Madden","DateOfBirth"=>"01/29/1937","EmailAddress"=>"vitae.semper.egestas@Morbiaccumsan.co.uk","Age"=>83),
            array("Name"=>"Hillary","Surname"=>"Benton","DateOfBirth"=>"01/09/1945","EmailAddress"=>"sit.amet.massa@felis.org","Age"=>40),
            array("Name"=>"Nero","Surname"=>"Church","DateOfBirth"=>"05/14/2005","EmailAddress"=>"eleifend.nunc.risus@eros.com","Age"=>82),
            array("Name"=>"Eliana","Surname"=>"Cole","DateOfBirth"=>"06/11/1972","EmailAddress"=>"ligula.tortor@congueIn.edu","Age"=>22),
            array("Name"=>"Barclay","Surname"=>"Lawrence","DateOfBirth"=>"11/19/1979","EmailAddress"=>"lorem.lorem.luctus@mi.net","Age"=>58),
            array("Name"=>"Donna","Surname"=>"Anthony","DateOfBirth"=>"09/08/1914","EmailAddress"=>"accumsan.neque.et@ornareFuscemollis.ca","Age"=>28),
            array("Name"=>"Tallulah","Surname"=>"Bates","DateOfBirth"=>"10/25/1998","EmailAddress"=>"ullamcorper@ut.net","Age"=>89)
        );
        $sqlStr = "INSERT INTO person (Name, Surname, DateOfBirth, EmailAddress, Age) VALUES ";
        foreach ($randomArr as $subArr) {
            $sqlStr .= " ('".$subArr['Name']."', '".$subArr['Surname']."', '".$subArr['DateOfBirth']."', '".$subArr['EmailAddress']."', '".$subArr['Age']."'),";
        }
        if ($connObj->query(rtrim($sqlStr,",")) === TRUE) {
            echo "Success, please refresh to see changes";
        } else {
            echo "<br>"."Error: " . $sqlStr . "<br>" . $connObj->error;
        }
    }
    public function loadAllPeople($connObj) {
        $sqlStr = "SELECT * FROM person";
        $resultStr = $connObj->query($sqlStr);

        echo "<table id='customers'>";
        echo "<tr><th>Name</th><th>Surname</th><th>Date Of Birth</th><th>Email</th><th>Age</th><th>Action</th></tr>";
        while ($rowArr = mysqli_fetch_array($resultStr)) {
            echo "<tr id=" . $rowArr['id'] ."><td>" . $rowArr['Name'] . "</td><td>" . $rowArr['Surname'] . "</td><td>" . $rowArr['DateOfBirth'] . "</td><td>"
                . $rowArr['EmailAddress']. "</td><td>" . $rowArr['Age'] . "</td><td><button type='button' class='updBtn'>Update</button>
                <button type='button' class='dltBtn' >Delete</button></td></tr>";
        }
        echo "</table>";
    }
    public function createPerson() {
        $sqlStr = "INSERT INTO person (Name, Surname, DateOfBirth, EmailAddress, Age) VALUES ";
        return $sqlStr;
    }
    public function loadPerson($connObj,$id) {
        echo "<form action='update.php' method='post' id='updForm'>";
        if ($id == null) {
            echo "Please fill in all fields: <br>";
            echo "<form action='update.php' method='post' id='updForm'>";
            echo "<input type='hidden' id='id' value=" . $id ." ><br>";
            echo "Name: " . "<input type='text' id='firstname' ><br>";
            echo "Surname: " . "<input type='text' id='lastname' ><br>";
            echo "Date of Birth: " . "<input type='text' id='DateOfBirth' placeholder='dd/mm/yyyy' ><br>";
            echo "Email: " . "<input type='email' id='Email' ><br>";
        } else {
            $sqlStr = "SELECT * FROM person WHERE id = $id";
            $resultStr = $connObj->query($sqlStr);
            echo "Selected entry to update: <br>";
            while ($rowArr = mysqli_fetch_array($resultStr)) {
                echo "<input type='hidden' id='id' value=" . $rowArr['id'] ."><br>";
                echo "Name: " . "<input type='text' id='firstname' value=" . $rowArr['Name'] ." ><br>";
                echo "Surname: " . "<input type='text' id='lastname' value=" . $rowArr['Surname'] ." ><br>";
                echo "Date of Birth: " . "<input type='text' id='DateOfBirth' value=" . $rowArr['DateOfBirth'] ." ><br>";
                echo "Email: " . "<input type='email' id='Email' value=" . $rowArr['EmailAddress'] ." ><br>";
            }
        }
        echo "<button class='submitBtn' type='button'>Save</button>";
        echo "</form>";
    }
    public function savePerson($id,$name,$surname,$DateOfBirth,$Email,$age,$connObj) {
        if ($id==null){
            $sqlStr = $this->createPerson();
            $sqlStr .= " ('".$name."', '".$surname."', '".$DateOfBirth."', '".$Email."', '".$age."')";
            if ($connObj->query($sqlStr) === TRUE) {
                echo "Success, please refresh to see changes";
            } else {
                echo "Why are you trying to break me :( please enter the correct values next time ";
            }
        } else {
            $sqlStr = "UPDATE person SET `Name` = '" . $name . "', `Surname` = '" . $surname . "', `DateOfBirth` = '" . $DateOfBirth . "',
                `EmailAddress` = '" . $Email . "', `Age` = '" . $age . "' WHERE `person`.`id` = " . $id . ";";
            if ($connObj->query($sqlStr) === TRUE) {
                echo "Success, please refresh to see changes";
            } else {
                echo "Why are you trying to break me :( please enter the correct values next time ";
            }
        }
    }
    public function deletePerson($connObj,$id) {
        $sqlStr = "DELETE FROM person WHERE person.id = $id";
        if($connObj->query($sqlStr)) {
            echo "Entry deleted Successfully";
        }
    }
    public function deleteAllPeople($connObj) {
        $sqlStr = "truncate table person";
        if($connObj->query($sqlStr)) {
            echo "All deleted Successfully, please refresh page";
        }
    }
}
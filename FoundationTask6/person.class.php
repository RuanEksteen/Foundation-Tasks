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
            array("Name"=>"Eugenia","Surname"=>"Valenzuela","DateOfBirth"=>"11/26/47","EmailAddress"=>"dapibus.rutrum.justo@cursusvestibulumMauris.com","Age"=>44),
            array("Name"=>"Nigel","Surname"=>"Schroeder","DateOfBirth"=>"03/03/67","EmailAddress"=>"Mauris@Curabitur.org","Age"=>2),
            array("Name"=>"Veronica","Surname"=>"Reilly","DateOfBirth"=>"11/22/56","EmailAddress"=>"mauris.sit.amet@sapienmolestie.edu","Age"=>97),
            array("Name"=>"Merrill","Surname"=>"Madden","DateOfBirth"=>"01/29/37","EmailAddress"=>"vitae.semper.egestas@Morbiaccumsan.co.uk","Age"=>83),
            array("Name"=>"Hillary","Surname"=>"Benton","DateOfBirth"=>"01/09/45","EmailAddress"=>"sit.amet.massa@felis.org","Age"=>40),
            array("Name"=>"Nero","Surname"=>"Church","DateOfBirth"=>"05/14/05","EmailAddress"=>"eleifend.nunc.risus@eros.com","Age"=>82),
            array("Name"=>"Eliana","Surname"=>"Cole","DateOfBirth"=>"06/11/72","EmailAddress"=>"ligula.tortor@congueIn.edu","Age"=>22),
            array("Name"=>"Barclay","Surname"=>"Lawrence","DateOfBirth"=>"11/19/79","EmailAddress"=>"lorem.lorem.luctus@mi.net","Age"=>58),
            array("Name"=>"Donna","Surname"=>"Anthony","DateOfBirth"=>"09/08/14","EmailAddress"=>"accumsan.neque.et@ornareFuscemollis.ca","Age"=>28),
            array("Name"=>"Tallulah","Surname"=>"Bates","DateOfBirth"=>"10/25/98","EmailAddress"=>"ullamcorper@ut.net","Age"=>89)
        );
        $sqlStr = "INSERT INTO person (Name, Surname, DateOfBirth, EmailAddress, Age) VALUES ";
        foreach ($randomArr as $subArr) {
            $sqlStr .= " ('".$subArr['Name']."', '".$subArr['Surname']."', '".$subArr['DateOfBirth']."', '".$subArr['EmailAddress']."', '".$subArr['Age']."'),";
        }
        if ($connObj->query(rtrim($sqlStr,",")) === TRUE) {
            echo "Success";
        } else {
            echo "<br>"."Error: " . $sqlStr . "<br>" . $connObj->error;
        }
    }
    public function loadAll($connObj) {
        $sqlStr = "SELECT * FROM person";
        $resultStr = $connObj->query($sqlStr);
        echo "<table border='1'>";
        echo "<tr><th>Name</th><th>Surname</th><th>Date Of Birth</th><th>Email</th><th>Age</th></tr>";
        while ($rowArr = mysqli_fetch_array($resultStr)) {
            echo "<tr><td>" . $rowArr['Name'] . "</td><td>" . $rowArr['Surname'] . "</td><td>" . $rowArr['DateOfBirth'] . "</td><td>"
                . $rowArr['EmailAddress']. "</td><td>" . $rowArr['Age'] . "</td></tr>";
        }
        echo "</table>";
    }
    public function createPerson()
    {

    }

    public function loadPerson()
    {

    }

    public function savePerson()
    {

    }

    public function deletePerson()
    {

    }

    public function loadAllPeople()
    {

    }

    public function deleteAllPeople()
    {

    }
}
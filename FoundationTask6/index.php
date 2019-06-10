<?php
include 'person.class.php';
$personClassObj = new person();
$startTime = microtime(true);
$connObj = $personClassObj->OpenCon();
echo "Connected Successfully"."<br>";
$personClassObj->addRandomTen($connObj);
$personClassObj->loadAll ($connObj);
$personClassObj->CloseCon($connObj);
$endTime = microtime(true);
$executionTime = ($endTime - $startTime);
echo "Execution time of script = ".$executionTime." sec ";

<?php
function getFibonacci ($intIteration) {
    if ($intIteration == 0) {
        return 0;
    }
    elseif ($intIteration == 1) {
        return 1;
    }
    else {
        return (getFibonacci($intIteration - 1) +
            getFibonacci($intIteration - 2));
    }
}
$intIteration = $_POST["fiboName"];
if (is_numeric($intIteration)) {
    for ($x = 0; $x < $intIteration; $x++) {
        echo getFibonacci($x), ' ';
    }
    }else {
        echo "You gotta enter a number bra";
    }


<?php

function getFibonacci($i){

    if ($i == 0) {
        return 0;
    }
    else if ($i == 1) {
        return 1;
    }

    else {
        return (getFibonacci($i - 1) +
            getFibonacci($i - 2));
    }
}

$i = 10;
for ($x = 0; $x < $i; $x++){
    echo getFibonacci($x),' ';
}
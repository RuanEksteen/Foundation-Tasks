<?php

function getFibonacci($i){
    if ($i == 0) {
        return 0;
    }
    elseif ($i == 1) {
        return 1;
    }
    else {
        return (getFibonacci($i - 1) +
            getFibonacci($i - 2));
    }
}

$i = 11;
for ($x = 0; $x < $i; $x++){
    echo getFibonacci($x),' ';
}
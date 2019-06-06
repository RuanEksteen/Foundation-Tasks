<?php
function addAll($Array) {
    $Sum = array_sum($Array);

        while(count($Array) > 0){
            array_shift($Array);
            return $Sum + addAll($Array);
        }
}
$Array = [1,1,1,1,1]; //5+4+3+2+1=15
echo addAll($Array);
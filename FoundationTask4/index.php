<?php
class ItemOwners {
    public static function groupByOwners($arrItems) {
        $arrResult = array ();
        foreach ($arrItems as $k => $v) {
                $arrResult[$v][]=$k;
        }
        return $arrResult;
    }
}

$arrItems = array (
    "Baseball Bat" => "John",
    "Golf ball" => "Stan",
    "Tennis Racket" => "John"
);
echo json_encode ( ItemOwners::groupByOwners ( $arrItems ) );
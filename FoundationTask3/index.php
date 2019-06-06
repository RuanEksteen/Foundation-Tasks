<?php
class Palindrome {
    public static function isPalindrome($word) {
//TODO: Implement this
        $noSpace = str_replace(' ', '', $word);
        $reversed = strrev($noSpace);
        if(strcasecmp($noSpace, $reversed) == 0){
            return true;
        }else {
            return false;
        }
    }
}

if (Palindrome::isPalindrome('Never Odd Or Even'))
    echo 'Palindrome';
else
    echo 'Not palindrome';
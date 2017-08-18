<?php

namespace App;

class ChangeString
{
    public function build($parameter)
    {
        $solution="";
        foreach (str_split($parameter) as $letter) {
            $next_letter = (preg_match("/[0-9]/", $letter)) ? $letter : (++$letter)[0];
            $solution.=$next_letter;
        }
        return $solution;
    }
}

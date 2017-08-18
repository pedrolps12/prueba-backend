<?php

namespace App;

class ClearPar
{
    public function build($parameter)
    {
        $solution = "";
        for ($i=1; $i < strlen($parameter); $i++) {
            if (str_split($parameter)[$i-1]=="(" && str_split($parameter)[$i] == ")") {
                $solution .= "()";
                $i++;
            }
        }
        return $solution;
    }
}

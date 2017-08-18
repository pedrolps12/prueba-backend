<?php

namespace App;

class CompleteRange
{
    public function build($parameter)
    {
        if (is_array($parameter)) {
            $solution=[];
            for ($i=$parameter[0]; $i <= end($parameter); $i++) {
                array_push($solution, $i);
            }
            return $solution;
        }
    }
}

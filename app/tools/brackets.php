<?php
/*
 * recursion function for bracket filling
 * filling the array in the *right to left* direction (from finals to round1)
 */

class Brackets {
    static function single(&$arr, $row, $col) {
        $offset = 1<<($col/2-1);
        if($col<0) {
            return;
        }
        elseif($col==0) {
            $arr[$row][$col] = 'fplr';
        }
        else {
            $arr[$row][$col] = 'plr';
            $arr[$row][$col-1] = 'con-mid';
            for($i=1; $i<$offset; $i++) {
                $arr[$row+$i][$col-1] = 'con-vert';
                $arr[$row-$i][$col-1] = 'con-vert';
            }
            $arr[$row+$offset][$col-1] = 'con-bot';
            $arr[$row-$offset][$col-1] = 'con-top';
        }
        Brackets::single($arr, $row-$offset, $col-2);
        Brackets::single($arr, $row+$offset, $col-2);
    }

    static function duble(&$arry, $row, $col) {
        
    }
}


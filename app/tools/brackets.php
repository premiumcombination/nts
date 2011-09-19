<?php
/**
 * @author bulb 2011
 * @package New Tournament System (NTS)
 * 
 * @name Brackets
 * recursion function for bracket filling
 * filling the array in the *right to left* direction (from finals to round1)
 */

class Brackets {
    
    /**
     * generate single elimination tournament brackets
     * @param type $arr - address of $arr (array put in the parameter is changed)
     * @param type $row - current row
     * @param type $col - current column
     */
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

    /**
     * generate double elimination tournament brackets
     * @param type $arr - address of $arr (array put in the parameter is changed)
     * @param type $row - current row
     * @param type $col - current column
     */
    static function double(&$arry, $row, $col) {
        
    }
}
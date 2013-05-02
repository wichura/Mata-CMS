<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Date
 *
 * @author wichura
 */
class Date {
    
    
    public static function standardDateFormat($date) {
        
        if (is_numeric($date) == false)
            $date = strtotime($date);
        
        if ($date < 0)
            return "";
        
        return date('dS F Y \a\t H:i', $date);
    }
}

?>

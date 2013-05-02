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
        
        return date('j\<\s\p\a\n\ \c\l\a\s\s\=\"\d\a\t\e\-\s\u\f\f\i\x\"\>S\<\/\s\p\a\n\> F Y \a\t H:i', $date);
    }
}

?>

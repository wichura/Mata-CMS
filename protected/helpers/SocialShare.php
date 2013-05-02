<?php

/**
 * Description of SocialShare
 *
 * @author marcinwiatr
 */
class SocialShare {

    public static function facebook($linkText = 'Facebook', $text = '', $url = null) {
        if ($url == null)
            $url = (empty($_SERVER['HTTPS']) == false ? "https://" : "http://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        return '<a target="_blank" href="http://www.facebook.com/sharer.php?u=' . urlencode($url) . '">' . $linkText . '</a>';
    }
    
    public static function twitter($linkText = 'Twitter', $text = '', $url = null) {
        if ($url == null)
            $url = (empty($_SERVER['HTTPS']) == false ? "https://" : "http://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        return '<a target="_blank" href="https://twitter.com/intent/tweet?url=' . urlencode($url) . '%2F&text=' . urlencode($text) . '">' . $linkText . '</a>';
    }

    
     public static function linkedIn($linkText = 'LinkedIn', $title = '', $text = '', $url = null) {
        if ($url == null)
            $url = (empty($_SERVER['HTTPS']) == false ? "https://" : "http://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        
        return '<a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url=' . $url . '%2F&title=' . urlencode($title) . '&summary=' . urlencode($text) . '">' . $linkText . '</a>';
    }
    
    
    
    
    
    
    
}

?>

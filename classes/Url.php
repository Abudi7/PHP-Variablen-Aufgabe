<?php
/**
 * URL
 * 
 * Response methods
 */
class Url {
    /**
     * Redirect to anthoer URL on the same file
     * 
     * @param string $path The path to redirect to 
     * 
     * @return void
     */
    public static function redirect($path)
    {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
            $protocol = 'https';
        } else {
            $protocol = 'http';
        }
        header("Location: $protocol://" . $_SERVER['HTTP_HOST'] . $path);
        exit;
    }

}
?>
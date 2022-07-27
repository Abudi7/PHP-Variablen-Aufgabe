<?php
/**
 * Authentication 
 * 
 * Login and logout
 */
class Auth {
    /**
     * Return the user authentication status 
     * @return boolean true if a user logged in, false otherweise 
     */
    public static function isLoggedIn() {
        return isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'];  
    }
    /**
     * Require the user to be logged in, stopping with an unauthorised message if not
     * 
     * @return void
     */
    public static function requireLogin() {
        if (! static::isLoggedIn()) {
            die("unauthorised");
        }
    }
    /**
     * login in using the session
     * 
     * @return void
     */
    public static function login() {
        session_regenerate_id(true);
        
        $_SESSION['is_logged_in'] = true;
    }
    /**
     * log out the session 
     * 
     * @return void
     */
    public static function logout() {
        session_start();
        // this func doing : delete all data in the file register when the condition false  

        $_SESSION = array();
        //this code for the delete session cookies data 
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }
        session_destroy();
    }
}
?>
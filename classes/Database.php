<?php
/**
 * Database
 * 
 * A connection to the database
 */
class Database {
    /**
     * Get the database connction
     * 
     * @return PDO object Connection to the database server 
     */
    public function getConn() {
        $db_host = "localhost";
        $db_name = "cms";
        $db_user = "web";
        $db_pass = "webapplication";
        
        $dsn = 'mysql:host=' . $db_host .';dbname=' . $db_name . ';charset=utf8';
        try {
        $db =  new PDO($dsn,$db_user,$db_pass);
        //This method to avoid me from the error stmt code 
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;

        } catch (PDOException $e){
            echo $e->getMessage();
            exit;
        }
    }

}

?>
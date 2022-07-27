<?php
/**
 * User
 * 
 * A persio
 */
class user {
    /**
     * Unique identifier
     * @var integer
     */
    public $id;
    /**
     * Unique username
     * @var string
     */
    public $username;
     /**
     * Unique password
     * @var string
     */
    public $password;
    /**
     * Authenticate a user by username and password
     * 
     * @param string $username Username
     * @param string $password Password
     * 
     * @return boolean true if the credentials are correct, null otherwise
     */
    public static function authenticate($conn,$username, $password) {
        $sql = "SELECT * FROM user WHERE username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS,'User');
        $stmt->execute();
        $user = $stmt->fetch();
        if ($user) {
            if (password_verify($password , $user->password)) {
                return true;
                /**
                 * i can write in one line without if stmt like that 
                 * return $user->password == $password;
                 */
            }
        }
    }
}
?>
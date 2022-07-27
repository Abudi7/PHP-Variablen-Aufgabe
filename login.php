<?php
//Autoloader
require 'includes/autoloader.inc.php';
$conn = require 'includes/db.inc.php';

//Session variables type array to check if is true or false 
//$_SESSION['is_logged_in'] = true; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //if ($_POST['username'] == 'root' && $_POST['password'] == 'root') {
    //i put the method from classes user.php to check the login user 
    if (User::authenticate($conn, $_POST['username'], $_POST['password'])) {
        Auth::login();
        Url::redirect("/Udemy-CMS/index.php");
        
    } else {
        
        $error = "login incorrect";
    }
}
?>
<?php
require "includes/header.inc.php";
?>
<h2>LOG IN</h2>
<?php
if (!empty($error)):
?>
   <p><?= $error ?></p>
    <?php
endif;
?>
<form method="post">
    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username " class="form-control">
    </div>

    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" class="form-control">
    </div>
    <br>
    <button class="btn btn-primary">Log in</button>

</form>

<?php
require "includes/footer.inc.php";
?>
<?php
//Autoloader
require 'includes/autoloader.inc.php';
$conn = require 'includes/db.inc.php';

if (isset($_GET['id'])) {
    
    $article = Article::getByID($conn, $_GET['id']);
    
    if (!$article) {
        die("article not found");
    }
    
} else {
    die("id not supplied, article not found");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    if ($article->delete($conn)) {
        Url::redirect("/Udemy-CMS/index.php?id=($article->id)");
    } 
}
//require 'includes/deleteScriptArticle.inc.php';


?>
<?php
require "includes/header.inc.php";
?>
<h2><a class="nav-link" href="http://localhost/Udemy-CMS/index.php" target="_blank">Delete Data Bank</a></h2>
<p>Are you sure?</p>
<?php
require "includes/articleForm.inc.php";
?>
<form method="post" class="form-group">
    <button class="btn btn-primary"> Delete Articl </button>
    <button class="btn btn-primary"> <a class="nav-link" href="http://localhost/Udemy-CMS/index.php?id=<?= $article->id; ?>"> Cansel</a></button>
</form>
<?php
require "includes/footer.inc.php";
?>
<?php
//Autoloader
require '../includes/autoloader.inc.php';
Auth::requireLogin();
$conn = require '../includes/db.inc.php';

//here i ask with the article choosen 
if (isset($_GET['id'])) {
    
    // i call the static method from class Articl : Get the article record based on the ID
    $article = Article::getByID($conn, $_GET['id']);
    
    if (!$article) {
        die("article not found");
    }
    
} else {
    die("id not supplied, article not found");
}
//this function array_column — Return the values from a single column in the input array
// i assigend the id from the category to a new varible that i can use it in Form html -
$categoryID = array_column($article->getCategories($conn),'id');
//This class to show me only the categories from the tabel category in array 
$categories = Category::getAll($conn);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $article->title        = $_POST['title'];
    $article->content      = $_POST['content'];
    $article->published_at = $_POST['published_at'];

    $categoryID = $_POST['category'] ?? [];
    
    
    if ($article->update($conn)) {
        
        $article->setCategories($conn,$categoryID);
        
        Url::redirect("/Udemy-CMS/admin/article.php?id=$article->id");
        
    }
}
?>

<?php require "../includes/header.inc.php"; ?>

<h2><a  class="nav-link" href="http://localhost/Udemy-CMS/admin/index.php" target="_blank">Show Update Data Bank</a></h2>

<?php require "../admin/includes/articleForm.inc.php"; ?>

<?php require "../includes/footer.inc.php";?>
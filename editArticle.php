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
//this function array_column — Return the values from a single column in the input array
// i assigend the id from the category to a new varible that i can use it in Form html -
$categoryID = array_column($article->getCategories($conn),'id');
//This class to show me only the categories from the tabel category in array 
$categories = Category::getAll($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $article->title        = $_POST['title'];
    $article->content      = $_POST['content'];
    $article->published_at = $_POST['published_at'];
    
    
    if ($article->update($conn)) {
        
        $article->setCategories($conn,$categoryID);
        
        Url::redirect("/Udemy-CMS/index.php?id=($article->id)");
        
    }
    /*else {
    
    echo mysqli_stmt_error($stmt);
    
    }*/
    
    
}

/*
if (isset($_GET['id'])) {

$article = Article::getByID($conn, $_GET['id']);

if ($article) {


} else {
die("article not found");
}

} else {
die("id not supplied, article not found");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

$title = $_POST['title'];
$content = $_POST['content'];
$published_at = $_POST['published_at'];

$errors = validateArticle($title, $content, $published_at);

if (empty($errors)) {

$sql = "UPDATE `article`
SET `title` = '" . $_POST['title'] . "',
`content` = '" . $_POST['title'] . "',
`published_at` = '" . $_POST['title'] . "'";

$stmt = mysqli_prepare($conn, $sql);

if ($stmt === false) {

echo mysqli_error($conn);

} else {

if ($published_at == '') {
$published_at = null;
}

mysqli_stmt_bind_param($stmt, "sssi", $title, $content, $published_a,$id);

if (mysqli_stmt_execute($stmt)) {

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
$protocol = 'https';
} else {
$protocol = 'http';
}
header("Location: $protocol://" . $_SERVER['HTTP_HOST'] . "includes/getarticle.inc.php?id=$id");
exit;

} else {

echo mysqli_stmt_error($stmt);

}
}
}
}*/
?>
<?php
require "includes/header.inc.php";
?>
<h2><a href="http://localhost/Udemy-CMS/index.php" target="_blank">Show Update Data Bank</a></h2>
<?php
require "includes/articleForm.inc.php";
?>
<?php
require "includes/footer.inc.php";
?>
<?php
//Autoloader
require '../includes/autoloader.inc.php';
Auth::requireLogin();
$conn = require '../includes/db.inc.php';

if (isset($_GET['id'])) {
    
    $article = Article::getByID($conn, $_GET['id']);
    
    if (!$article) {
        die("article not found");
    }
    
} else {
    die("id not supplied, article not found");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $previousImage = $article->image_file;
            
            if ($article->setImageFile($conn,null)) {

                // i aske if the true to upload another file it must to delete the previous image 
                if ($previousImage) {

                    //The unlink function in php is used to delete a file from the file system.
                    unlink("../uploads/$previousImage");
                }

                Url::redirect("/Udemy-CMS/admin/editArticleImage.php?id={$article->id}");
            } 
} 
?>

<?php require "../includes/header.inc.php"; ?>

<h2> Delete article image</h2>

            <?php if ($article->image_file) : ?>
                <img src="http://localhost/Udemy-CMS/uploads/<?= $article->image_file;?>">
            <?php endif;?>

<form method="post" >
    <p>Are you sure?</p>
    
    <button>Delete</button>
    <a href="/Udemy-CMS/admin/editArticleImage.php?id=<?= $article->id; ?>">Cansel</a>
</form>
<?php require "../includes/footer.inc.php";?>
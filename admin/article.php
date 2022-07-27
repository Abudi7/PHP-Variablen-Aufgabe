<?php
//Autoloader
require '../includes/autoloader.inc.php';
Auth::requireLogin();
$conn = require '../includes/db.inc.php';


if (isset($_GET['id'])) {
    
    $article = Article::getWithCategories($conn, $_GET['id']);
   
    
} else {
    $article = null;
}

$sql = "SELECT * FROM `article` WHERE id = " . $_GET['id'];
?>
<?php require "../includes/header.inc.php"; ?>


    <a href="http://localhost/Udemy-CMS/admin/index.php">Back</a>


<!--<label style='font-size:20px;'>SQL code: &#10145; <?php //var_dump($sql);  ?></label>-->

    
    <a href="http://localhost/Udemy-CMS/admin/newArticle.php"> New Article</a>


    
    <a href="http://localhost/Udemy-CMS/admin/editArticle.php?id=<?= $article[0]['id']; ?>"> Edit Article</a>

    <a class="delete" id="deleteArticle" href="http://localhost/Udemy-CMS/admin/deleteArticle.php?id=<?= $article[0]['id']; ?>"> Delete Article</a>

    <a href="http://localhost/Udemy-CMS/admin/editArticleImage.php?id=<?= $article[0]['id']; ?>"> Edit Image</a>




    <?php if ($article): ?>
       <article>
        <!--the $article varible is an array 2D when i need only the record i write $var[0]['name_colum'] -->
            <h2><?= htmlspecialchars($article[0]['title']); ?></h2>
            <?php if ($article[0]['published_at']) : ?>            
                     <time>  <?= $article[0]['published_at'] ?></time>
                  <?php else : ?>
                     Unpublished
                  <?php endif; ?>  

            <?php if ($article[0]['category_name']) : ?>
                <p>Categories: 
                    <?php foreach ($article as $a) : ?>
                        <?= htmlspecialchars($a['category_name']); ?>
                    <?php endforeach; ?>
                
                </p>
            <?php endif;?>

            <?php if ($article[0]['image_file']) : ?>
                <img src="http://localhost/Udemy-CMS/uploads/<?= $article[0]['image_file'];?>">
            <?php endif;?>
            <p> <?= htmlspecialchars($article[0]['content']); ?></p>
            <p> <?= htmlspecialchars($article[0]['published_at']); ?></p>
        </article>

        <?php else: ?>

       <p>Article not found.</p> 

      <?php endif; ?>
<?php require "../includes/footer.inc.php"; ?>


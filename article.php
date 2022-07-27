<?php
//Autoloader
require 'includes/autoloader.inc.php';
$conn = require 'includes/db.inc.php';


if (isset($_GET['id'])) {
    
    $article = Article::getWithCategories($conn, $_GET['id'],true);
    
} else {
    $article = null;
}

//$sql = "SELECT * FROM `article` WHERE id = " . $_GET['id'];
/*$result = mysqli_query($conn,$sql);

if($result === false){
echo mysqli_error($conn);
}else{
//This function mysqli_fetch_assoc to get the output only for the row selected by the user
$article = mysqli_fetch_assoc($result);
//var_dump($article);
}*/
?>
<?php require "includes/header.inc.php";?>

<button>
    <a href="http://localhost/Udemy-CMS/index.php">Back</a>
</button>

<label style='font-size:20px;'>SQL code: &#10145; <?php //var_dump($sql); 
?></label>

<button>    
    <a href="http://localhost/Udemy-CMS/admin/newArticle.php"> New Article</a>
</button>

<button>
    <a href="http://localhost/Udemy-CMS/editArticle.php?id=<?= $article->id; ?>"> Edit Article</a>
</button>
<button>
    <a href="http://localhost/Udemy-CMS/deleteArticle.php?id=<?= $article->id; ?>"> Delete Article</a>
</button>



    <?php if ($article):?>

        <article>
        <!--the $article varible is an array 2D when i need only the record i write $var[0]['name_colum'] -->
            <h2><?= htmlspecialchars($article[0]['title']); ?></h2>
            <time datetime="<?= $article[0]['published_at']; ?>">
              <?php $dateTime = new DateTime($article[0]['published_at']);
                echo $dateTime->format("j F, Y"); ?> 
              
              <!--After that i use format method to get a format for the  date Time, The format is a string containing letters that represent different parts of the date.  -->
              
              </time>
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
<?php
require "includes/footer.inc.php";
?>


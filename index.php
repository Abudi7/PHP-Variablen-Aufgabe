<?php
//Autoloader
require 'includes/autoloader.inc.php';
//Auth::requireLogin();
$conn = require 'includes/db.inc.php';
//Another conditional operator is the "?:" (or ternary) operator.
//Creat a new object from the class Paginator
$paginator = new Paginator(isset($_GET['page']) ? $_GET['page']: 0,4, Article::getTotal($conn , true));
//otherway to write a short code $paginator = new Paginator($_GET['page'] ?? 1,2);
//The method is static class name :: method
$articles = Article::getPage($conn,$paginator->limit,$paginator->offset, true);
?>
<?php require "includes/header.inc.php"; ?>

<?php if (empty($articles)): ?>

<p>No articles found.</p>

<?php else: ?>

<ul id="index">
    <?php foreach ($articles as $article): ?>
     <li>
        <article>

            <!--Here each element has been linked with right ID-->
            <h2><a class="title" href="/Udemy-CMS/article.php?id=<?= $article['id']; ?>"><?= $article['title']; ?></a></h2>
                <!--The DateTime class constructor accepts the mysql or mariadb, datetime format as a valid DateTime string.-->
                <!-- The Time elment it have a attrbuit datetime -->
              <time datetime="<?= $article['published_at']; ?>">
              <?php $dateTime = new DateTime($article['published_at']);
                echo $dateTime->format("j F, Y"); ?> 
              
              <!--After that i use format method to get a format for the  date Time, The format is a string containing letters that represent different parts of the date.  -->
              
              </time>
              <p><?php if ($article['category_names'] ) : ?>     
                  <b>Category: </b> 
                  
                    <?php foreach ($article['category_names']  as $name) : ?>
                      <?= htmlspecialchars($name); ?>
                    <?php endforeach; ?>
              
                 <?php endif;  ?>
           
              </p>  
           
            <p> <?= $article['content']; ?></p>
            
        </article>
      </li>
    <?php endforeach; ?>
</ul>
<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php if ($paginator->previous) : ?>
      <li class="page-item"><a class="page-link" href="/Udemy-CMS/index.php?page=<?= $paginator->previous; ?>">Previous</a></li>
      <?php else: ?>
      Previous
      <?php endif; ?>
      <?php if ($paginator->next) : ?>
      <li class="page-item"><a class="page-link" href="/Udemy-CMS/index.php?page=<?= $paginator->next; ?>">Next</a></li>
      <?php else : ?>
      Next 
      <?php endif; ?>
    </ul>
</nav>
<?php
endif;
?>
<?php
require "includes/footer.inc.php";
?>
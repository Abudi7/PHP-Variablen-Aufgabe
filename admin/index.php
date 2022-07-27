<?php
   //Autoloader
   require '../includes/autoloader.inc.php';
   $conn = require '../includes/db.inc.php';
   //Auth::requireLogin();
   //The method is static class name :: method
   //Another conditional operator is the "?:" (or ternary) operator.
   //Creat a new object from the class Paginator
   $paginator = new Paginator(isset($_GET['page']) ? $_GET['page']: 0,5, Article::getTotal($conn));
   //otherway to write a short code $paginator = new Paginator($_GET['page'] ?? 1,2);
   //The method is static class name :: method //i pass true to the three argument 
   $articles = Article::getPage($conn,$paginator->limit,$paginator->offset);
   ?>
<?php
   require "../includes/header.inc.php";
   ?>
<?php if (empty($articles)): ?>

<p>No articles found.</p>

<?php else:?>
<h2>Administration</h2>
<a href="http://localhost/Udemy-CMS/admin/newArticle.php"> New Article</a>

<!--==================== Disply all the record in a Table ================ -->
<table class="table">
   <thead>
      <tr> 
         <th>Title</th>
         <th>Published</th>
      </tr>
   </thead>
   
   <tbody>
      <?php foreach ($articles as $article): ?>
      <tr scope="row">
         <td>
            <!--Here each element has been linked with right ID-->
            <a class="title" href="/Udemy-CMS/admin/article.php?id=<?= $article['id']; ?>">
               <?= $article['title']; ?>
            </a>
         </td>
         <td>
                  <?php if ($article['published_at']) : ?>            
                     <time>  <?= $article['published_at'] ?></time>
                  <?php else : ?>
                     Unpublished
                     <!-- i make a requset button to publish using Ajax js -->
                     <button class="publish" data-id="<?= $article["id"];?>">publish</button>
                  <?php endif; ?>   
         </td>
      </tr>
      <?php endforeach;?>

   </tbody>
</table>
<!--==================== Next link and Previous ================ -->
<nav>
   <ul>
      <?php if ($paginator->previous) : ?>
         <li><a href="/Udemy-CMS/admin/index.php?page=<?= $paginator->previous; ?>">Previous</a></li>
      <?php else: ?>
         Previous
      <?php endif; ?>
      <?php if ($paginator->next) : ?>
         <li><a href="/Udemy-CMS/admin/index.php?page=<?= $paginator->next; ?>">Next</a></li>
      <?php else : ?>
         Next
      <?php endif; ?>
   </ul>
</nav>

<?php endif; ?>

<?php require "../includes/footer.inc.php"; ?>
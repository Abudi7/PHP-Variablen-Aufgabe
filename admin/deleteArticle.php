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
$categoryID = array_column($article->getCategories($conn),'id');
//This class to show me only the categories from the tabel category in array 
$categories = Category::getAll($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    if ($article->delete($conn)) {
        Url::redirect("/Udemy-CMS/admin/index.php?id=$article->id");
    } 
}


?>
<?php require "../includes/header.inc.php"; ?>

    <h2><a class="nav-link" href="http://localhost/Udemy-CMS/index.php" target="_blank">Delete Data Bank</a></h2>

    <p>Are you sure?</p>

    <form method="post">

        <div class="form-group">
            <label for="title">Title</label>
            <input  class="form-control" name="title" id="title" placeholder="Article title" value="<?= htmlspecialchars($article->title); ?>">
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <textarea  class="form-control" name="content" rows="4" cols="40" id="content" placeholder="Article content"><?= htmlspecialchars($article->content); ?></textarea>
        </div>

        <div class="form-group">
            <label for="published_at">Publication date and time</label>
            <input  class="form-control" type="datetime-local" name="published_at" id="published_at" value="<?= htmlspecialchars($article->published_at); ?>">
        </div>

        <fieldset>
            <legend>Categories</legend>
                <?php foreach ($categories as $category) : ?>
                    <div class="form-group">
                        <!--in this form i let the user to choose the right category with ID-->
                        <input type="checkbox" class="form-check-input" name="category[]" value="<?= $category['id'] ?>" id="category<?= $category['id']; ?>"
                        <?php if (in_array($category['id'], $categoryID)): ?> checked <?php endif; ?>>
                        <label class="form-check-label" for="category<?= $category['id']; ?>"><?= htmlspecialchars($category['name']); ?></label>
                    </div>
                <?php endforeach; ?>    
        </fieldset>
        <br>
        <button class="btn btn-primary">Delete Article</button>
        <button class="btn btn-primary">  <a class="nav-link" href="http://localhost/Udemy-CMS/admin/index.php?id=<?= $article->id; ?>"> Cansel</a></button>    
    </form>

<?php require "../includes/footer.inc.php"; ?>
<?php
//Autoloader
require 'includes/autoloader.inc.php';
$conn = require 'includes/db.inc.php';

Auth::requireLogin();

$article = new Article();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $article->title        = $_POST['title'];
    $article->content      = $_POST['content'];
    $article->published_at = $_POST['published_at'];
    
    
    if ($article->create($conn)) {
        
        Url::redirect("/Udemy-CMS/index.php?id=($article->id)");
        
    }
}
?>
<?php
require "includes/header.inc.php";
?>
<h2><a href="http://localhost/Udemy-CMS/index.php" target="_blank">Show Data Bank</a></h2>
<?php
if (!empty($errors)):
?>
  <ul>
        <?php
    foreach ($errors as $error):
?>
          <li><?= $error ?></li>    
        <?php
    endforeach;
?>
  </ul>
<?php
endif;
?>

<form method="post">

    <div class="form-group">
        <label for="title">Title</label>
        <input  class="form-control" name="title" id="title" placeholder="Article title" value="<?= htmlspecialchars($article->title); ?>">
    </div>

    <div class="form-group">
        <label for="content">Content</label>
        <textarea class="form-control" name="content" rows="4" cols="40" id="content" placeholder="Article content"><?= htmlspecialchars($article->content); ?></textarea>
    </div>

    <div class="form-group">
        <label for="published_at">Publication date and time</label>
        <input  class="form-control" type="datetime-local" name="published_at" id="published_at" value="<?= htmlspecialchars($article->published_at); ?>">
    </div>
    <br>
    <button class="btn btn-primary">Add</button>

</form>
<?php
require "includes/footer.inc.php";
?>
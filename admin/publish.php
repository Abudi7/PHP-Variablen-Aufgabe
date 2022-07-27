<?php
//Autoloader
require '../includes/autoloader.inc.php';
Auth::requireLogin();
$conn = require '../includes/db.inc.php';

$article = Article::getByID($conn , $_POST['id']);

$published_at = $article->publish($conn);

?>

<time> <?= $published_at ?> </time>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <!--<link rel="stylesheet" href="./css/outputDBArticle.css">
    <link rel="stylesheet" href="./css/tableStyle.css">
    <link rel="stylesheet" href="/Udemy-CMS/css/outputSingleArticle.css">
    <link rel="stylesheet" href="/Udemy-CMS/css/newArticleStyle.css">-->
    <title>My Blog</title>
</head>
<body>
    <div class="container">
        <header>
            <h1>My Blog</h1>
        </header>

        <nav>
        <ul class="nav">
            <li class="nav-item"><a class="nav-link active" href="/Udemy-CMS/index.php">Home</a></li>
                <?php if (Auth::isLoggedIn()): ?>
                    <li class="nav-item"><a class="nav-link active" href="/Udemy-CMS/admin/">Admin</a></li>
                    <li class="nav-item"><a class="nav-link active" href="/Udemy-CMS/logout.php">Log out</a></li> 
            </ul>
                    <?php else:?>
                        <li class="nav-item"><a  class="nav-link active"href="/Udemy-CMS/login.php">Log in</a></li>
                    <?php endif;?>
                    <li class="nav-item"><a  class="nav-link active"href="/Udemy-CMS/contact.php">Contact</a></li>
        </nav>
        <div>
            <main>
            
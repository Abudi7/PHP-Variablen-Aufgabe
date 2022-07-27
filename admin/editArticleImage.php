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

    //var_dump($_FILES);

    try {

        if (empty($_FILES)) {
            throw new Exception('Invalid upload');
        }

        switch ($_FILES['file']['error']) {
            case UPLOAD_ERR_OK:
                break;

            case UPLOAD_ERR_NO_FILE:
                throw new Exception('No file uploaded');
                break;

            case UPLOAD_ERR_INI_SIZE:
                throw new Exception('File is too large (from the server settings)');
                break;

            default:
                throw new Exception('An error occurred');
        }
        //just this type will be accepted 
        $mimeTypes = ['image/gif','image/png','image/jpeg','image/jpg'];

        // here to know the file type 
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo,$_FILES['file']['tmp_name']);
        //var_dump($mimeType);
        
        // here to check about image mimeTypes  
        if (! in_array($mimeType,$mimeTypes)) {
            throw new Exception('Invalid file type.' );
        }
        // here to check about the image size
        if ($_FILES['file']['size'] > 7000000) {
            throw new Exception('File is too large'); 
        }
        // here i move the image file from the temp location server to stay in upload file 
        // i call this function to accept the correct file name image and this func return an array
        $pathinfo = pathinfo($_FILES['file']['name']);
        //the base name of the file which is the file name without the extension
        $base = $pathinfo['filename'];
        //use the preg replace function the parameter is regx to replace any characters we don't want to allow with another one.
        $base = preg_replace('/[^a-zA-Z0-9_-]/','_',$base);
        // this func to get a part of the string from the start
        $base = mb_substr($base ,0, 200);
        // here i can creat a file name 
        $filename = $base.".".$pathinfo['extension'];

        $destination = "../uploads/$filename";
        /**
         * if i uploaded 2 file withe same name it must uploaded 2 element 
         * not to change only date and one element to do that ask the file
         * with file_exists() 
         */ 
        $i = 1;
        while (file_exists($destination)) {

            $filename = $base . "-$i." . $pathinfo['extension'];
            $destination = "../uploads/$filename";
            $i++;
        }

        //call the func move_uploaded_file and this function return boolean true or false 
        if (move_uploaded_file($_FILES['file']['tmp_name'],$destination)) {

            $previousImage = $article->image_file;
            var_dump($previousImage);

            if ($article->setImageFile($conn,$filename)) {

                // i aske if the true to upload another file it must to delete the previous image 
                if ($previousImage) {

                    //The unlink function in php is used to delete a file from the file system.
                    unlink("../uploads/$previousImage");
                }

                Url::redirect("/Udemy-CMS/admin/editArticleImage.php?id={$article->id}");
            } 

            //echo "File uploaded successfully";
        } else {
            throw new Exception("Unable to move uploaded file");
            
        }


    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<?php require "../includes/header.inc.php"; ?>

<h2> Edit article image</h2>

            <?php if ($article->image_file) : ?>
                <img src="http://localhost/Udemy-CMS/uploads/<?= $article->image_file;?>">
                <a class ="delete" href="http://localhost/Udemy-CMS/admin/deleteArticleImage.php?id=<?= $article->id; ?>">Delete</a>
            <?php endif;?>
<?php if (isset($error)) : ?>
<p><?= $error ?></p>
<?php endif;?>

<form method="post" enctype="multipart/form-data">
    <div>
        <label for="file">Image File</label>
        <input type="file" name="file" id="file">
    </div>
    <button> Upload</button>
</form>
<?php require "../includes/footer.inc.php";?>
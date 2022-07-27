<?php
//Autoloader
require 'includes/autoloader.inc.php';
require "classes/Url.php";
Auth::logout();
//$_SESSION['is_logged_in'] = false; 
Url::redirect("/Udemy-CMS/index.php");
?>
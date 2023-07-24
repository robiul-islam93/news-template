<?php
include "config.php";

// from file setup start

if(isset($_FILES['fileToUpload'])){

    $errors = array();
    $file_name = $_FILES['fileToUpload']['name'];
    $file_size = $_FILES['fileToUpload']['size'];
    $file_tmp = $_FILES['fileToUpload']['tmp_name'];
    $file_type = $_FILES['fileToUpload']['type'];
    $file_ext = strtolower(end( explode('.', $file_name)));
    $extensions = array("jpeg","jpg","png");

    if(in_array($file_ext, $extensions)=== false){
        $errors[] = "This extension file not allowed, please choose a JPG or PNG file";
    }

    if($font_size > 2097152){
        $errors[] = "File size be 2 mb or lower.";
    }

    if(empty($errors) == true){
        move_uploaded_file($file_tmp, "upload/" .$file_name);
    }else{
        print_r($errors);
        die();
    }
}
// from file setup end

// add-post-file get data in save-post.php file start
session_start();
  $title = mysqli_real_escape_string($connection, $_POST['post_title']);
  $description = mysqli_real_escape_string($connection, $_POST['postdesc']);
  $category = mysqli_real_escape_string($connection, $_POST['category']);
  $date = date("d M. Y");  
  $author = $_SESSION['user_id'];
  
// add-post-file get data in save-post.php file end

// add post file setu start in php 

$sql = "INSERT INTO post(title,description,category,post_date,author,post_img)
 VALUES('{$title}','{$description}', {$category} ,'{$date}',{$author}, '{$file_name}');";


$sql .= "UPDATE category SET post = post + 1 WHERE category_id = {$category}";

if(mysqli_multi_query($connection,$sql)){
    header("Location: http://localhost/php-practise/news-template/admin/post.php");
}else{
    echo "<div class='alert alert-danger'>Query Failed</div>";
}
// add post file setu end in php 

?>

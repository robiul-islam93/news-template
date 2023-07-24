<?php

if($_SESSION ["user_role"]== '0'){
    header("Location: http://localhost/php-practise/news-template/admin/post.php");
} 

// table user data delete function

include "config.php";

$userid = $_GET['id'];

$sql = " DELETE FROM user WHERE user_id ={$userid}";

if (mysqli_query($connection,$sql)){
    header("Location: http://localhost/php-practise/news-template/admin/users.php");
}else{
    echo "can't Delet the user record";
}
// table user data delete function
mysqli_close($connection);


?>
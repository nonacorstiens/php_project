<?php
require_once 'bootstrap.php';
session_start();
$id = $_GET['id'];
$post = Post::getPostById($id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detailpage</title>
</head>
<body>
    <h1 class="postDescription"><?php echo $post['imageDescription']; ?></h1>
    <img class="postImage" src="<?php echo $post['imageName']; ?>" width="350px">

    <form method="post" action="">
         <div class="post_form">
                <a>Like</a>
                <br>
                <input type="text" placeholder="Say something about this picture" class="postComment" name="postComment" />
                <input type="submit" class="btnSubmit" name="postComment" value="Comment" data-input=".postComment" />

                <ul class="post_comment_updates">
                    
                </ul>
        </div>
    </form>
    
</body>
</html>
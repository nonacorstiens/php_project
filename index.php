<?php
require_once("bootstrap.php");
session_start();
if (isset( $_SESSION['userid'])){
   $posts = Post::getAll();

} else {
  header("Location: login.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
    <h1>Welcome</h1>
    <a href="uploadpage.php">Upload picture</a>
    <nav>

        <a href="logout.php">logout</a>

    </nav>

    <div class="picture_grid">
            <?php foreach($posts as $p):?>
            <div class="post">
            <form method="post" action="">
                <div class="post_form">
                    <p class="postDescription"><?php echo $p->getImageDescription();?></p>
                    <img class="postImage" src="<?php echo $p->getImageCrop();?>" width="350px">
                    <br>
                    <input type="text" placeholder="Say something about this picture" id="postComment" name="postComment" />
                    <input id="btnSubmit" type="submit" value="Comment" />

                    <ul id="post_comment_updates">

                    </ul>
                </div>

            </form>
            </div>
            <?php endforeach;?>  
    </div>
    

</body>
</html>
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
            <?php for($i = 0; $i <=19; $i++){?>
            <div class="post">
            <form method="post" action="">
                <div class="post_form">
                    <p class="postDescription"><?php echo $posts[$i]->getImageDescription();?></p>
                    <img class="postImage" src="<?php echo $posts[$i]->getImageCrop();?>" width="350px">
                    <br>
                    <a>Like</a>
                    <br>
                    <input type="text" placeholder="Say something about this picture" id="postComment" name="postComment" />
                    <br>
                    <input id="btnSubmit" type="submit" value="Comment" />

                    <ul id="post_comment_updates">

                    </ul>
                </div>

            </form>
            </div>
            <?php }; ?>
    </div>
</body>
</html>
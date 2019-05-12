<?php
require_once 'bootstrap.php';
session_start();

    $searchResults = Post::searchTags($_SESSION['searchReq']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search</title>
</head>
<body>
    <a href="index.php">BACK</a>
    <h1>Posts that match your search...</h1>
    <div class="picture_grid">
            <?php foreach ($searchResults as $result): ?>
            <div class="post">
            <form method="post" action="">
                <div class="post_form">
                    <p class="postDescription"><?php echo $result->getImageDescription(); ?></p>
                    <img class="postImage" src="<?php echo $result->getImageCrop(); ?>" width="350px">
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
            <?php endforeach; ?>
    </div>
</body>
</html>
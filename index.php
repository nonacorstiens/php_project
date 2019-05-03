<?php
require_once 'bootstrap.php';
session_start();

if (isset($_SESSION['userid'])) {
    $posts = Post::getAll();
    if (isset($_POST['search'])) {
        $_SESSION['searchReq'] = $_POST['searchReq'];
        header('Location: search.php');
    }
} else {
    header('Location: login.php');
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
        <form action="" method="post">
            <input type='text' name='searchReq'>
            <input type='submit' name="search" value="Search...">
        </form>
        <a href="logout.php">logout</a>

    </nav>

    <div class="picture_grid">
            <?php foreach (array_slice($posts, 0, 20) as $post => $item):
    ?>
            <div class="post">
            <a class="post_link" href="detailpage.php?id=<?php echo $item['id']; ?>">
                <img class="postImage" src="<?php echo $item['imageCrop']; ?>" width="350px">
            </a>
            <p class="postDescription"><?php echo $item['imageDescription']; ?></p>
            <form method="post" action="">
                <div class="post_form">
                    <a>Like</a>
                    <br>
                    <input type="text" placeholder="Say something about this picture" class="postComment" name="postComment" />
                    <input type="submit" class="btnSubmit" name="postComment" value="Comment" data-input=".postComment" />
                    <?php
                    $comments = Comment::getAll($item['id']);
                    ?>
                    <ul class="post_comment_updates">
                    <?php foreach ($comments as $comment):?>
                    <li><?php echo $comment['comment']; ?></li>
<?php endforeach; ?>   
                    </ul>
                </div>

            </form>
            </div>
            <?php
endforeach; ?>
    </div>
    
</body>
</html>
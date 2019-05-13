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
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <title>Search</title>
</head>
<body>
<div class="index-container">
    <nav class="nav">
            <a class="nav-logo"><h2>GRAFFITIC</h2></a>
            <div class="profile-link">
                 <p class="profile-name"><?php echo 'Hi, '.$_SESSION['username']; ?></p>
                 <a href="profile.php" class="profile-icon"><span class="glyphicon glyphicon-user"></span></a>  
            </div>
            <form action="" method="post" class="form-search">
            <div class="form-search-container">  
                <input type='text' name='searchReq' class="form-search-control" placeholder="Look for locations, tags,...">
                <input type='submit' name="search"  class="btn-default btn-sm" value= "Search">
            </div>
        </form>
            <a href="logout.php" class="logout-link">logout</a>
    </nav>
    <div class="upload-link">
             <a href="uploadpage.php"><span class="glyphicon glyphicon-camera"></span></a>
    </div>
    <div class="bar-down"></div>
    <div class="picture-grid">
            <a href="index.php">BACK</a>
            <h2>Posts that match your search...</h2>

            <?php foreach ($searchResults as $result): ?>
            <div class="picture-row">
                <div class="post-div">
                <a class="post_link" href="detailpage.php?id=<?php echo $result['id']; ?>">
                    <img class="postImage" src="<?php echo $result['imageCrop']; ?>" width="350px">
                </a>
                <div class="like-link">
                                <a><span class="glyphicon glyphicon-heart"></span></a>
                </div>
                <div class="post-info">
                    <form method="post" action="">
                        <div class="post_form">
                            <h3 class="postDescription"><?php echo $result['imageDescription']; ?></h3>
                            <?php
                            $comments = Comment::getAll($result['id']);
                            ?>
                            <ul id="post_comment_updates<?php echo $result['id']; ?>" class="post-comments-list">
                            <?php foreach ($comments as $comment):?>
                            <li><?php echo $comment['comment']; ?></li>
        <?php endforeach; ?>   
                            </ul>
                            <div class="comment-box">
                                <input type="text" class="comment-input" placeholder="Say something about this picture" id="postComment<?php echo $result['id']; ?>" name="postComment" />
                                <input type="submit" class= "btn btn-default btn-sm" id="btnSubmit<?php echo $result['id']; ?>" name="postComment" value="Comment" />
                            </div>
                            <a class="inappropriateLink btn btn-default btn-xs btn-block" id="inappropriateLink<?php echo $result['id']; ?>" href="">Mark as inappropriate</a>
                        </div>

                    </form>
                </div>

                </div>
            </div>
            <?php endforeach; ?>
    </div>
</div>
</body>
</html>
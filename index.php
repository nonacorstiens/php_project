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
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
</head>
<body>
    <div class="index-container"> 
        <nav class="nav">
            <a class="nav-logo"><h2>GRAFFITIC</h2></a>
            <div class="profile-link">
                 <p class="profile-name"><?php echo 'Hi, '.$_SESSION['username']; ?></p>
                 <a href="profile.php" class="profile-icon"><span class="glyphicon glyphicon-user"></span></a>  
            </div>
            <a href="logout.php" class="logout-link">logout</a>
    
        </nav>
        <form action="" method="post" class="form-search">
            <div class="form-search-container">  
                <input type='text' name='searchReq' id="searchReq" class="form-search-control" placeholder="Look for locations, tags,...">
                <input type='submit' name="search" id="search-button" class="btn-default btn-sm" value= "Search">
            </div>
        </form>
        <div class="upload-link">
             <a href="uploadpage.php"><span class="glyphicon glyphicon-camera"></span></a>
        </div>
        <div class="bar-down"></div>
        <div class="space">
        </div>
        <div class="picture-grid">
                <?php foreach (array_slice($posts, 0, 20) as $post => $item):
        ?>
            <div class="picture-row">
                <div class="post-div">
                    <a class="post_link" href="detailpage.php?id=<?php echo $item['id']; ?>">
                        <img class="postImage" src="<?php echo $item['imageCrop']; ?>" width="350px">
                    </a>
                    <div class="like-link">
                                    <a><span class="glyphicon glyphicon-heart"></span></a>
                    </div>
                    <div class="post-info">
                        <form method="post" action="">
                            <div class="post-form">
                                <h3 class="postDescription"><?php echo $item['imageDescription']; ?></h3>
                                <?php
                                $comments = Comment::getAll($item['id']);
                                ?>
                                <ul id="post_comment_updates<?php echo $item['id']; ?>" class="post-comments-list">
                                <?php foreach ($comments as $comment):?>
                                <li><?php echo $comment['comment']; ?></li>
            <?php endforeach; ?>   
                                </ul>
                                <div class="comment-box">
                                    <input type="text" class="comment-input" placeholder="Say something about this picture" id="postComment<?php echo $item['id']; ?>" name="postComment" />
                                    <input type="submit" class= "btn btn-default btn-sm" id="btnSubmit<?php echo $item['id']; ?>" name="postComment" value="Comment" />
                                </div>
                                <div class="inappropriate-form">
                                    <a class="inappropriateLink btn btn-default btn-xs" id="inappropriateLink<?php echo $result['id']; ?>" href="">Mark as inappropriate</a>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
        <script>
                $("#btnSubmit<?php echo $item['id']; ?>").on("click", function(e){
                var text = $("#postComment<?php echo $item['id']; ?>").val();
                var id = '<?php echo $item['id']; ?>';
                
                $.ajax({
                        method: "POST",
                        url: "ajax/postcomment.php",
                        data: { text: text, id: id },
                        dataType: "json" // belangrijk!
                        })
                        .done(function( response ) { // dit is de json die je hebt teruggestuurd (success of error)
                            if(response.status == 'success'){
                                var li = "<li>" + text + "</li>";
                                $("#post_comment_updates<?php echo $item['id']; ?>").append(li); 
                                $("#postComment<?php echo $item['id']; ?>").val("").focus();
                                $("#post_comment_updates<?php echo $item['id']; ?> li").last().slideDown();
                            }
                        });
                e.preventDefault();
        });

                $("#inappropriateLink<?php echo $item['id']; ?>").on("click", function(e){
                var imageId = '<?php echo $item['id']; ?>';            
                    $.ajax({
                        method: "POST",
                        url: "ajax/reportpost.php",
                        data: {imageId: imageId},
                        dataType: "json"
                    })
                    .done(function(response){
                        if(response.status == "success"){
                            $("#inappropriateLink<?php echo $item['id']; ?>").html("<p class='inappropriateLink btn-xs'><span class='glyphicon glyphicon-ok'></span>  Marked as inappropriate</p>");
                            $(".glyphicon-ok").css("color", "green");
                        }
                        if(response.status == "fail"){
                            $("#inappropriateLink<?php echo $item['id']; ?>").css("color", "red");
                            $("#inappropriateLink<?php echo $item['id']; ?>").html("<p class='alert alert-danger'>You already marked this post as inappropriate</p>").css("text-decoration", "none");
                        }
                        if(response.status == "delete"){
                            $("#inappropriateLink<?php echo $item['id']; ?>").css("color", "red");
                            $("#inappropriateLink<?php echo $item['id']; ?>").html("<p>This post will be deleted because it was marked as inappropriate by 3 users</p>").css("text-decoration", "none");
                        }
                    });
                    e.preventDefault();
                });
            
        </script>
                    <?php
    endforeach; ?>
        </div>
    </div>
</body>
</html>
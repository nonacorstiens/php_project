<?php
require_once 'bootstrap.php';
session_start();
$id = $_GET['id'];
$post = Post::getPostById($id);
$comments = Comment::getAll($id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=yes">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <title>Detailpage</title>
</head>
<body>
    <nav class="nav">
            <a href="index.php" class="nav-logo"><h2>GRAFFITIC</h2></a>
            <div class="profile-link">
                 <p class="profile-name"><?php echo 'Hi, '.$_SESSION['username']; ?></p>
                 <a href="profile.php" class="profile-icon"><span class="glyphicon glyphicon-user"></span></a>  
            </div>
            <a href="logout.php" class="logout-link">logout</a>
            <form action="" method="post" class="form-search">
                <div class="form-search-container"> 
                    <div class="back-link">
                        <a href="index.php"><span class="glyphicon glyphicon-arrow-left"></span></a> 
                    </div>
                </div>
             </form>
    </nav>
    <div class="detail-grid">
        <img id="post-image" class="postImage" src="<?php echo $post['imageName']; ?>">
        <div class="post-info" id="detail-post-info">
            <div class="action-form">
                <a id="like-heart"><span class="glyphicon glyphicon-heart"></span></a>
                <div class="inappropriate-form">
                    <a class="inappropriateLink" id="inappropriateLink<?php echo $post['id']; ?>" href="">Mark as inappropriate</a>
                </div>
            </div>
            <form class="detail-post-form" method="post" action="">
                <div class="post-form">
                    <h3 class="postDescription"><?php echo $post['imageDescription']; ?></h3>
                    <?php
                    $comments = Comment::getAll($post['id']);
                    ?>
                    <ul id="post_comment_updates<?php echo $post['id']; ?>" class="post-comments-list">
                    <?php foreach ($comments as $comment):?>
                    <li><?php echo $comment['comment']; ?></li>
                <?php endforeach; ?>   
                    </ul>
                    <div class="comment-box">
                        <input type="text" class="comment-input" placeholder="Say something about this picture" id="postComment<?php echo $post['id']; ?>" name="postComment" />
                        <input type="submit" class= "btn btn-default btn-sm" id="btnSubmit<?php echo $post['id']; ?>" name="postComment" value="Comment" />
                    </div>
                </div>

            </form>
        </div>
    </div>
    <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
        <script>
                $("#btnSubmit<?php echo $post['id']; ?>").on("click", function(e){
                var text = $("#postComment<?php echo $post['id']; ?>").val();
                var id = '<?php echo $post['id']; ?>';
                
                $.ajax({
                        method: "POST",
                        url: "ajax/postcomment.php",
                        data: { text: text, id: id },
                        dataType: "json" // belangrijk!
                        })
                        .done(function( response ) { // dit is de json die je hebt teruggestuurd (success of error)
                            if(response.status == 'success'){
                                var li = "<li>" + text + "</li>";
                                $("#post_comment_updates<?php echo $post['id']; ?>").append(li); 
                                $("#postComment<?php echo $post['id']; ?>").val("").focus();
                                $("#post_comment_updates<?php echo $post['id']; ?> li").last().slideDown();
                            }
                        });
                e.preventDefault();
        });

                $("#inappropriateLink<?php echo $post['id']; ?>").on("click", function(e){
                var imageId = '<?php echo $post['id']; ?>';            
                    $.ajax({
                        method: "POST",
                        url: "ajax/reportpost.php",
                        data: {imageId: imageId},
                        dataType: "json"
                    })
                    .done(function(response){
                        if(response.status == "success"){
                            $("#inappropriateLink<?php echo $post['id']; ?>").html("<p class='inappropriateLink'><span class='glyphicon glyphicon-ok'></span>  Marked as inappropriate</p>");
                            $(".glyphicon-ok").css("color", "green");
                        }
                        if(response.status == "fail"){
                            $("#inappropriateLink<?php echo $post['id']; ?>").css("color", "red");
                            $("#inappropriateLink<?php echo $post['id']; ?>").html("<p>You already marked this post as inappropriate</p>").css("text-decoration", "none");
                        }
                        if(response.status == "delete"){
                            $("#inappropriateLink<?php echo $post['id']; ?>").css("color", "red");
                            $("#inappropriateLink<?php echo $post['id']; ?>").html("<p>This post will be deleted because it was marked as inappropriate by 3 users</p>").css("text-decoration", "none");
                        }
                    });
                    e.preventDefault();
                });
            
        </script>
    
</body>
</html>
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
                    <div class="back-link">
                        <a href="index.php"><span class="glyphicon glyphicon-arrow-left"></span></a> 
                    </div>
                    <input type='text' name='searchReq' id="searchReq-detail" class="form-search-control" placeholder="<?php echo $_SESSION['searchReq']; ?>">
                    <input type='submit' name="search" id="search-button" class="btn-default btn-sm" value= "Search">
                </div>
             </form>
            <a href="logout.php" class="logout-link">logout</a>
    </nav>
    <div class="upload-link">
             <a href="uploadpage.php"><span class="glyphicon glyphicon-camera"></span></a>
    </div>
    <div class="bar-down"></div>
    <h2 id=title-search>Posts that match your search...</h2>
    <div class="picture-grid">
            <?php foreach ($searchResults as $result): ?>
            <div class="picture-row">
                <div class="post-div">
                <a class="post_link" href="detailpage.php?id=<?php echo $result['id']; ?>">
                    <img class="postImage" src="<?php echo $result['imageCrop']; ?>" width="350px">
                </a>
                <div class="action-form">
                <div class="like-link">
                        <?php
                        //if Like::check->isLiked()
                        $userId = $_SESSION['userid'];
                        $postId = $result['id'];
                        if (Like::liked($postId, $userId) == 'yes') {
                            $bool = true;
                        } else {
                            $bool = false;
                        }

                        ?>
                        <a href="" id="likeButton<?php echo $result['id']; ?>"><span class='glyphicon glyphicon-heart' style="color:<?php
                            if ($bool == true) {
                                echo 'red';
                            } else {
                                echo 'white';
                            }?>">
                        </a>
                    </div>
                    <div class="inappropriate-form">
                        <a class="inappropriateLink" id="inappropriateLink<?php echo $result['id']; ?>" href="">Mark as inappropriate</a>
                    </div>
                </div>
                <div class="post-info">
                    <form method="post" action="">
                        <div class="post-form">
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
                $("#btnSubmit<?php echo $result['id']; ?>").on("click", function(e){
                var text = $("#postComment<?php echo $result['id']; ?>").val();
                var id = '<?php echo $result['id']; ?>';
                
                $.ajax({
                        method: "POST",
                        url: "ajax/postcomment.php",
                        data: { text: text, id: id },
                        dataType: "json" // belangrijk!
                        })
                        .done(function( response ) { // dit is de json die je hebt teruggestuurd (success of error)
                            if(response.status == 'success'){
                                var li = "<li>" + text + "</li>";
                                $("#post_comment_updates<?php echo $result['id']; ?>").append(li); 
                                $("#postComment<?php echo $result['id']; ?>").val("").focus();
                                $("#post_comment_updates<?php echo $result['id']; ?> li").last().slideDown();
                            }
                        });
                e.preventDefault();
        });

                $("#inappropriateLink<?php echo $result['id']; ?>").on("click", function(e){
                var imageId = '<?php echo $result['id']; ?>';         
                    $.ajax({
                        method: "POST",
                        url: "ajax/reportpost.php",
                        data: {imageId: imageId},
                        dataType: "json"
                    })
                    .done(function(response){
                        console.log(response);
                        if(response.status == "success"){
                            $("#inappropriateLink<?php echo $result['id']; ?>").html("<p class='inappropriateLink'><span class='glyphicon glyphicon-ok'></span> Marked as inappropriate</p>");
                            $(".glyphicon-ok").css("color", "green");
                        }
                        if(response.status == "fail"){
                            $("#inappropriateLink<?php echo $result['id']; ?>").css("color", "red");
                            $("#inappropriateLink<?php echo $result['id']; ?>").html("<p>You already marked this post as inappropriate</p>").css("text-decoration", "none");
                        }
                        if(response.status == "delete"){
                            $("#inappropriateLink<?php echo $result['id']; ?>").css("color", "red");
                            $("#inappropriateLink<?php echo $result['id']; ?>").html("<p>This post will be deleted because it was marked as inappropriate by 3 users</p>").css("text-decoration", "none");
                        }
                    });
                    e.preventDefault();
                });

                $("#likeButton<?php echo $result['id']; ?>").on("click", function(e){
            var postId = '<?php echo $result['id']; ?>';
            var button = $(this);
            var heart = ''

            //AJAX call maken adhv POST request naar bestand in ajax map
                $.ajax({
                    method: "POST", // HOE
                    url: "ajax/likepost.php", // NAAR WAAR
                    data: {postId: postId}, // WAT -> geen user-id -> wordt uit session gehaald -> gevaarlijk om in client side code te steken
                    dataType: "json"
                })
                .done(function( res ){
                    if(res.status === "like"){
                        
                        $("#likeButton<?php echo $result['id']; ?>").html("<span class='glyphicon glyphicon-heart' style="+'"'+'color:red'+'"'+"></span>");
                        
                } else if(res.status="unlike"){
                    $("#likeButton<?php echo $result['id']; ?>").html("<span class='glyphicon glyphicon-heart' ></span>");
                       
                }

                
                
                });
                e.preventDefault();
            });

            
        </script>
            <?php endforeach; ?>
    </div>
</div>
</body>
</html>
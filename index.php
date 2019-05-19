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
    <link rel="stylesheet" href="https://cssgram-cssgram.netdna-ssl.com/cssgram.min.css">
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
            <?php foreach (array_slice($posts, 0, 20) as $post => $item):?>
        <div class="picture-row">
            <div class="post-div">
                <h5><?php
                    $timestamp = strtotime($item['uploadDate']);
                    Post::time_ago($timestamp);
                ?></h5>
                <a class="post_link" href="detailpage.php?id=<?php echo $item['id']; ?>">
                <div class="<?php echo $item['filter']; ?>">
                    <img class="postImage" src="<?php echo $item['imageCrop']; ?>" width="350px">
                    </div>
                </a>
                <div class="action-form">
                    <div class="like-link">
                        <?php
                        //if Like::check->isLiked()
                        $userId = $_SESSION['userid'];
                        $postId = $item['id'];
                        if (Like::liked($postId, $userId) == 'yes') {
                            $bool = true;
                        } else {
                            $bool = false;
                        }

                        ?>
                        <a href="" id="likeButton<?php echo $item['id']; ?>"><span class='glyphicon glyphicon-heart' style="color:<?php
                            if ($bool == true) {
                                echo 'red';
                            } else {
                                echo 'white';
                            }?>">
                        </a>
                    </div>
                    <div class="inappropriate-form">
                         <a class="inappropriateLink" id="inappropriateLink<?php echo $item['id']; ?>" href="">Mark as inappropriate</a>
                    </div>
                
                </div>
                <div class="post-info">
                     <form method="post" action="">
                        <div class="post-form">
                            <p class="locationName"><?php echo $item['location']; ?></p>
                            <h3 class="postDescription"><?php echo htmlspecialchars($item['imageDescription']); ?></h3>                
                            <?php
                                $comments = Comment::getAll($item['id']);
                            ?>
                            <ul id="post_comment_updates<?php echo $item['id']; ?>" class="post-comments-list">
                                <?php foreach ($comments as $comment):?>
                                    <li><?php echo htmlspecialchars($comment['comment']); ?></li>
                                <?php endforeach; ?>   
                            </ul>
                            <div class="comment-box">
                                <input type="text" class="comment-input" placeholder="Say something about this picture" id="postComment<?php echo $item['id']; ?>" name="postComment" />
                                <input type="submit" class= "btn btn-default btn-sm" id="btnSubmit<?php echo $item['id']; ?>" name="postComment" value="Comment" />
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
                        console.log(response);
                        if(response.status == "success"){
                            $("#inappropriateLink<?php echo $item['id']; ?>").html("<p class='inappropriateLink'><span class='glyphicon glyphicon-ok'></span> Marked as inappropriate</p>");
                            $(".glyphicon-ok").css("color", "green");
                        }
                        if(response.status == "fail"){
                            $("#inappropriateLink<?php echo $item['id']; ?>").css("color", "red");
                            $("#inappropriateLink<?php echo $item['id']; ?>").html("<p>You already marked this post as inappropriate</p>").css("text-decoration", "none");
                        }
                        if(response.status == "delete"){
                            $("#inappropriateLink<?php echo $item['id']; ?>").css("color", "red");
                            $("#inappropriateLink<?php echo $item['id']; ?>").html("<p>This post will be deleted because it was marked as inappropriate by 3 users</p>").css("text-decoration", "none");
                        }
                    });
                    e.preventDefault();
                });

                $("#likeButton<?php echo $item['id']; ?>").on("click", function(e){
            var postId = '<?php echo $item['id']; ?>';
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
                        
                        $("#likeButton<?php echo $item['id']; ?>").html("<span class='glyphicon glyphicon-heart' style="+'"'+'color:red'+'"'+"></span>");
                        
                } else if(res.status="unlike"){
                    $("#likeButton<?php echo $item['id']; ?>").html("<span class='glyphicon glyphicon-heart' ></span>");
                       
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
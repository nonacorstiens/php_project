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
                 <a href="profile.php">profile</a>  
            </div>
    
        </nav>

        <form action="" method="post" class="form-search">
            <div class="form-search-container">
                <span class="glyphicon glyphicon-search"></span>   
                <input type='text' name='searchReq' class="form-search-control">
                <input type='submit' name="search"  class="btn-default btn-sm" value="Search...">
            </div>
        </form>

        <h6>Welcome <?php echo $_SESSION['firstname']; ?></h6>
        <a href="uploadpage.php">Upload picture</a>
        <a href="logout.php">logout</a>


    <div class="picture-grid">
            <?php foreach (array_slice($posts, 0, 20) as $post => $item):
    ?>
        <div class="picture-row">
            <div class="post-div">
                <a class="post_link" href="detailpage.php?id=<?php echo $item['id']; ?>">
                    <img class="postImage" src="<?php echo $item['imageCrop']; ?>" width="350px">
                </a>
                <p class="postDescription"><?php echo $item['imageDescription']; ?></p>
                <form method="post" action="">
                    <div class="post_form">
                        <a>Like</a>
                        <br>
                        <a id="inappropriateLink<?php echo $item['id']; ?>" href="">Mark as inappropriate</a>
                        <br>
                        <input type="text" placeholder="Say something about this picture" id="postComment<?php echo $item['id']; ?>" name="postComment" />
                        <input type="submit" id="btnSubmit<?php echo $item['id']; ?>" name="postComment" value="Comment" />
                        <?php
                        $comments = Comment::getAll($item['id']);
                        ?>
                        <ul id="post_comment_updates<?php echo $item['id']; ?>">
                        <?php foreach ($comments as $comment):?>
                        <li><?php echo $comment['comment']; ?></li>
    <?php endforeach; ?>   
                        </ul>
                    </div>

                </form>
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
							$("#comment").val("").focus();
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
                .done(function(){
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
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
    <h1>Welcome <?php echo $_SESSION['firstname']; ?></h1>
    <a href="uploadpage.php">Upload picture</a>
    <nav>
        <form action="" method="post">
            <input type='text' name='searchReq'>
            <input type='submit' name="search" value="Search...">
        </form>
        <a href="logout.php">logout</a>
        <a href="profile.php">profile</a>

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
    
</body>
</html>
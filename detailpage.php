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
    <title>Detailpage</title>
</head>
<body>
    <h1 class="postDescription"><?php echo $post['imageDescription']; ?></h1>
    <img class="postImage" src="<?php echo $post['imageName']; ?>" width="350px">

    <form method="post" action="">
         <div class="post_form">
                <a>Like</a>
                <br>
                <input type="text" id="postComment" name="postComment" placeholder="Say something about this picture"  />
                <input type="submit" id="btnSubmit" name="postComment" value="Comment" />

                <ul id="post_comment_updates">
                    <?php foreach ($comments as $comment):?>
                    <li><?php echo $comment['comment']; ?></li>
<?php endforeach; ?>   
                </ul>
        </div>
    </form>

    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
    <script>
        	$("#btnSubmit").on("click", function(e){
		  	var text = $("#postComment").val();
            var id = '<?php echo $id; ?>';
			
			  $.ajax({
					method: "POST",
					url: "ajax/postcomment.php",
					data: { text: text, id: id },
					dataType: "json" // belangrijk!
					})
					.done(function( response ) { // dit is de json die je hebt teruggestuurd (success of error)
						if(response.status == 'success'){
							var li = "<li>" + text + "</li>";
							$("#post_comment_updates").append(li); 
							$("#comment").val("").focus();
							$("#post_comment_updates li").last().slideDown();
						}
					});
			e.preventDefault();
	  });
        
    </script>
    
</body>
</html>
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
            <?php for ($i = 0; $i <= 19; ++$i) {
    ?>
            <div class="post">
            <form method="post" action="">
                <div class="post_form">
                    <p class="postDescription"><?php echo $posts[$i]->getImageDescription(); ?></p>
                    <img class="postImage" src="<?php echo $posts[$i]->getImageCrop(); ?>" width="350px">
                    <br>
                    <a>Like</a>
                    <br>
                    <input type="text" placeholder="Say something about this picture" class="postComment" name="postComment" />
                    <input type="submit" class="btnSubmit" name="postComment" value="Comment" data-input=".postComment" />

                    <ul class="post_comment_updates">
              
                    </ul>
                </div>

            </form>
            </div>
            <?php
} ?>
    </div>
    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
    <script>
        $(".btnSubmit").on('click', function(e){
            var comment = $(this).prev().val();
            console.log(comment);
            $.ajax({
					method: "POST",
					url: "ajax/postcomment.php",
					data: { comment: comment},
					dataType: "json" // belangrijk!
					})
                    .done(function( response ) { // dit is de json die je hebt teruggestuurd (success of error)
						if(response.status == 'success'){
							var li = "<li>" + comment + "</li>";
                            console.log(li);
							$(".post_comment_updates").append(li); 
							//$(".postComment").val("").focus();
							$(".post_comment_updates li").last().slideDown();
						}
					});

            e.preventDefault();
        });
        
    </script>
</body>
</html>
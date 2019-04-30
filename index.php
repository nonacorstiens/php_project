<?php
session_start();
if (isset( $_SESSION['userid'])){
} else {
  header("Location: login.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Welcome</h1>
    <nav>
        <a href="logout.php">logout</a>
    </nav>

    <div class="picture_grid">
    
        <form method="post" action="">
            <div class="post">
                <p class="postDescription">KIDS</p>
                <img class="postImage" src="uploads/cropped/5cc87a1cc3a460.02144669.jpeg">
                <br>
                <input type="text" placeholder="Say something about this picture" id="postComment" name="postComment" />
                <input id="btnSubmit" type="submit" value="Comment" />

                <ul id="post_comment_updates">

                </ul>
                

            </div>

        </form>

    </div>
    

</body>
</html>
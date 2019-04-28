<?php
 require_once("bootstrap.php");

if(isset($_POST['submit'])){
    $post = new Post();
    $post->setImageDescription($_POST['imageDescription']);
    $im = $post->uploadImage($_FILES['image']);
    $post->setImage($im);
    $post->uploadDB();
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
    <form action="" method="POST" enctype="multipart/form-data" id="uploadForm">
        <p id ="errorUpload" class="hidden">Please select an image</p>
        <input type="file" name="image" id="upload">
        <br/>
        <p id ="errorDescription" class="hidden">Please write a description</p>
        <input type="text" cols='40' name="imageDescription" id="uploadDescription" placeholder="Say something about this image">
        <br/>
        <input type="submit" name="submit" id="submit" value="upload">
    </form>



    <script
    src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>
	<script>
        
    </script>
</body>
</html>

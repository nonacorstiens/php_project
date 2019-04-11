<?php
    require_once("bootstrap.php");

    
    $errorDescription="0";
    $errorUpload="0";

    if(isset($_POST['submit'])){
        $post = new Post();
        $post->setUploadDescription($_POST['uploadDescription']);
        $post->setUpload(addslashes(file_get_contents($_FILES['upload']['tmp_name'])));
        $post->uploadFile();
        $errorUpload=addslashes(file_get_contents($_FILES['upload']['tmp_name']));
        $errorDescription = $_POST['uploadDescription'];
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
        <p id ="errorUpload" class=<?php
            if($errorUpload != ""){
                echo "errorMessage hidden";
            }
            else{
                echo "errorMessage";
            }
        ?>>Please select an image</p>
        <input type="file" name="upload" id="upload">
        <br/>
        <p id ="errorDescription" class=<?php
            if($errorDescription != ""){
                echo "errorMessage hidden";
            }
            else{
                echo "errorMessage";
            }
        ?>>Please write a description</p>
        <input type="text" name="uploadDescription" id="uploadDescription" placeholder="What is this photo about?">
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

<?php
 require_once("bootstrap.php");
 $result = "";
 session_start();

    if(isset($_POST['submit'])){
        if(!empty($_FILES['image']) && !empty($_POST['imageDescription'])){
            $post = new Post();
            $post->setImageDescription($_POST['imageDescription']);
            $im = $post->uploadImage($_FILES['image']);
            $post->setImage($im); 
            if(is_string($im)){
                $result = $im;
                $croppedImage = $post->cropImage($result);
                $post->setImageCrop($croppedImage);
                $post->uploadDB();  
                header('Location: index.php');
            }
            else{
            $result = $im->getMessage();
            }
            
        }
        else{
            $result = "OOPS, make sure you choose a picture and don't forget to write a description";
        }
    }
   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <title>Upload page</title>
</head>
<body>
    <h1>Upload your picture here</h1>
    <form action="" method="POST" enctype="multipart/form-data" id="uploadForm">
        <p id ="errorUpload" class="errorMessage"><?php echo $result; ?></p>
        <img src="" id="imagePreview" width="400px">
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
        function readURL(input){ 
            var reader = new FileReader();

            reader.onload = function(e){
                $('#imagePreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
        $("#upload").change(function(){
            readURL(this); // functie aanroepen wanneer uploadform wijzigt
        });
    </script>
</body>
</html>

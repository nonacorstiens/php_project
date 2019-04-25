<?php
    require_once("bootstrap.php");
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT imageName FROM post");
        $result = $statement->execute(); 
        $image = $statement->fetch(PDO::FETCH_ASSOC);

    
    $errorDescription="0";
    $errorUpload="0";

    if(isset($_POST['submit'])){ // wanneer de submit button ingedrukt is
        $target_dir = "uploads/"; // de directory waar de file wordt geplaats
        $target_file = $target_dir . basename($_FILES['image']["name"]); // path of the file

        $post = new Post();
        $post->setImageDescription($_POST['imageDescription']);
        $post->setImage($_FILES['image']['name']);
        $post->uploadImage();
        $im = imagecreatefromjpeg($_FILES['image']['tmp_name']);
        $imageCrop = imagecrop($im, ['x' => 0, 'y' => 0, "width"=>150, "height" =>150]);
        move_uploaded_file($_FILES['image']['tmp_name'],$target_file);
        $errorUpload= $post->getImage();
        $errorDescription = $post->getImageDescription();
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
        <input type="file" name="image" id="upload">
        <br/>
        <p id ="errorDescription" class=<?php
            if($errorDescription != ""){
                echo "errorMessage hidden";
            }
            else{
                echo "errorMessage";
            }
        ?>>Please write a description</p>
        <input type="text" cols='40' name="imageDescription" id="uploadDescription" placeholder="Say something about this image">
        <br/>
        <input type="submit" name="submit" id="submit" value="upload">
    </form>

    <img src="<?php echo "uploads/" . $image["imageName"];?>">



    <script
    src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>
	<script>
        
    </script>
</body>
</html>

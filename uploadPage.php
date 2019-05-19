<?php
 require_once 'bootstrap.php';
 $result = '';
 session_start();

if (isset($_SESSION['userid'])) {
    if (isset($_POST['submit'])) {
        if (!empty($_FILES['image']) && !empty($_POST['imageDescription'])) {
            $post = new Post();
            $post->setImageDescription($_POST['imageDescription']);
            $post->setLocation($_POST['location']);
            $post->setFilter($_POST['filters']);
            $im = $post->uploadImage($_FILES['image']);
            $post->setImage($im);
            $post->setUserId($_SESSION['userid']);
            if (is_string($im)) {
                $result = $im;
                $croppedImage = $post->cropImage($result);
                $post->setImageCrop($croppedImage);
                $post->uploadDB();
                header('Location: index.php');
            } else {
                $result = $im->getMessage();
            }
        } else {
            $result = "OOPS, make sure you choose a picture and don't forget to write a description";
        }
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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Upload page</title>
</head>
<body class="upload-container">
    <div>
        <nav class="nav">
                <a class="nav-logo" href="index.php"><h2>GRAFFITIC</h2></a>
                <div class="profile-link">
                    <p class="profile-name"><?php echo 'Hi, '.$_SESSION['username']; ?></p>
                    <a href="profile.php" class="profile-icon"><span class="glyphicon glyphicon-user"></span></a>  
                </div>
                <a href="logout.php" class="logout-link">logout</a>
        
        </nav>
        <div class="upload-content">
            <form action="" method="POST" enctype="multipart/form-data" id="uploadForm">
                <h3>Upload your picture here</h3>
                <?php if ($result != '') {
    echo "<h5 class='alert alert-danger'> $result</h5>";
}?>
                <div class="image-preview">
                    <img src="" id="imagePreview">
                </div>
                <div class="location">
                    <label class="hidden" for="location"></label>
                    <input type="text" name="location" id="location-field" class="form-control hidden">
                </div>
                <div class="form-group">
                    <label for="image"></label>
                    <input type="file" name="image" id="exampleInputFile" class="form-control">
                </div>
                <div>
                    <select name="filters">
                    <?php
                                $filters = Post::getAllFilters();
                            ?>
                        <?php foreach ($filters as $filter):?>
                                    <option value="<?php echo $filter['name']; ?>"><?php echo $filter['displayName']; ?></option>
                                <?php endforeach; ?> 
                    </select>
                </div>
                <label for="imageDescription"></label>
                <textarea type="text" class="form-control" rows="5" name="imageDescription" id="uploadDescription" placeholder="Say something about this image"></textarea>

                <input type="submit" class="btn btn-primary" name="submit" id="submit" value="upload">
            </form>
        </div> 
    </div>
    <script
    src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script>

        $(document).ready(function(){
            getGeoLocation();
        });

        function readURL(input){ 
            var reader = new FileReader();

            reader.onload = function(e){
                $('#imagePreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
        $("#exampleInputFile").change(function(){
            readURL(this); // functie aanroepen wanneer uploadform wijzigt
        });

        function getGeoLocation(){
            var key = "AIzaSyAHWDWDVsOf_f1LbFRy78tYQQvjRwBbATg";
            if ("geolocation" in navigator){ //check geolocation available 
            //try to get user current location using getCurrentPosition() method
            navigator.geolocation.getCurrentPosition(function(position){ 
                    var latitude = position.coords.latitude;
                    var longitude = position.coords.longitude;
                    console.log(latitude);
                    console.log(longitude);
                    var position = latitude + "%2C%" + longitude;
                    console.log(position);
                    var location = geocode(latitude, longitude);
                    
                });
            }else{
                console.log("Browser doesn't support geolocation!");
            }
        }

        function geocode(latitude, longitude){
                $.ajax({
                    url: 'https://api.opencagedata.com/geocode/v1/json',
                    method: 'GET',
                    data: {
                    'key': '81203b85fb1549d19912e9dcadf4ac3e',
                    'q': '51.0225751,4.487703'
                    },
                    dataType: 'json',
                    statusCode: {
                    200: function(response){  // success
                        var locationName = response.results[0].components['city_district'];
                        console.log(locationName);
                        $("#location-field").val(locationName);
                    },
                    402: function(){
                        console.log('hit free-trial daily limit');
                        console.log('become a customer: https://opencagedata.com/pricing');
                    }
                    }
                });
        }
    </script>
</body>
</html>

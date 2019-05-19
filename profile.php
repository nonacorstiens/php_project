<?php

include_once 'bootstrap.php';

session_start();

if (!isset($_SESSION['userid'])) {
    header('Location: login.php');
} else {
}

$db = Db::getInstance();
$user = new User($db);
$user->setId($_SESSION['userid']);

$userInfo = $user->getValues();

if (!empty($_POST['description'])) {
    unset($_SESSION['errors']);
    $user = new User(); // userklasse aanspreken
    $user->setDescription($_POST['description']); //variabele email naar userklasse doorgeven
    $user->setId($_SESSION['userid']); //id via session id doorgeven aan userklasse
    $user->changeDescription(); // functie aanroepen die zich in userklasse bevindt
    $userInfo = $user->getValues();
}

if (!empty($_POST['email'])) {
    unset($_SESSION['errors']);
    $user = new User(); // userklasse aanspreken
    $user->setEmail($_POST['email']); //variabele email naar userklasse doorgeven
    $user->setId($_SESSION['userid']); //id via session id doorgeven aan userklasse
    $user->changeEmail(); // functie aanroepen die zich in userklasse bevindt
    $userInfo = $user->getValues();
}

if (!empty($_POST['passwordOld']) && !empty($_POST['passwordNew']) && !empty($_POST['passwordConfirmation'])) {
    unset($_SESSION['errors']);
    $user = new User(); // userklasse aanspreken
    $user->setPassword($_POST['passwordNew']); //variabele email naar userklasse doorgeven
    $user->setPasswordConfirmation($_POST['passwordConfirmation']);
    $user->setPasswordOld($_POST['passwordOld']);
    $user->setId($_SESSION['userid']); //id via session id doorgeven aan userklasse
    $user->changePassword(); // functie aanroepen die zich in userklasse bevindt
} else {
    $errorMsg = 'All fields must be filled in';
}

$result = '';

if (isset($_POST['btnProfilePicture'])) {
    if (!empty($_FILES['image'])) {
        unset($_SESSION['errors']);
        $post = new User();
        $user->setId($_SESSION['userid']);
        $im = $post->uploadImageImg($_FILES['image']);
        $post->setImage($im);
        if (is_string($im)) {
            $result = $im;
            $croppedImage = $post->cropImageImg($result);
            $post->setImageCrop($croppedImage);
            $post->uploadDBImg($_SESSION['userid']);
            header('Location: profile.php');
        } else {
            $result = $im->getMessage();
        }
    } else {
        $result = 'OOPS, make sure you choose a picture';
    }
}

?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>PHPotato</title>
</head>
<body class="hero_container">


    <main class="main form-container">
    <h1 class="h2">Profiel bewerken <?php echo htmlspecialchars($userInfo['firstName']); ?></h1>
        <div class="profile">

        <?php if (!empty($_SESSION['errors'])) {
    foreach ($_SESSION['errors'] as $key => $value) {
        // and print out the values
        echo '<h5 class="alert alert-danger">Error: '.$value.' <br /></h5>';

        if (isset($errorMsg)) {
            echo '<h5 class="alert alert-danger">Error: '.$errorMsg.'</h5>';
        }
    }
}?>
            <div class="form-group">
                <h3>Profile Picture</h3>
                <img src="<?php echo $userInfo['profileImage']; ?>" alt="Profile Picture" >
                <form class="" action="" method="POST" enctype="multipart/form-data">
        <p class="errorMessage"><?php echo $result; ?></p>
        <input type="file" name="image" >
        <br/>
        
        <input type="submit" name="btnProfilePicture"  value="upload" class="btn btn-default">
    </form>

                
            </div>

            <div class="form-group">

                <h3>Description</h3>
                <p ><?php echo htmlspecialchars($userInfo['description']); ?></p>
                
                <div >
                    <form class="" method="post" name="description" enctype="multipart/form-data">
                    <textarea type="text" class="form-control" rows="5" name="description" id="uploadDescription" placeholder="Say something about yourself"></textarea>
                       
                        <input class="btn btn-default" type="submit" name="btnDescription" value="Wijzig">

                    </form>
                </div>
                
            </div>
            
            <div class="form-group">
            <h3>Email</h3>
                <p ><?php echo htmlspecialchars($userInfo['email']); ?></p>
                

                <div id="formEditEmail" >
                    <form method="post" name="emailChange">
                        <input class="form-control" type="text" name="email" value="<?php echo $userInfo['email']; ?>"><br>
                        <input class="btn btn-default" type="submit" name="btnEmail" value="Wijzig">

                    </form>
                </div>
                
            </div>

            <div>
            <h3>Wachtwoord</h3>
                
                <div class="form-group">
                    <form method="post" name="passwordChange">
                        <label for="password" >Huidig wachtwoord</label><br>
                        <input class="form-control" type="password" name="passwordOld"><br>

                        <label for="password" >Nieuw wachtwoord</label><br>
                        <input class="form-control" type="password" name="passwordNew"><br>

                        <label for="password" >Bevestig nieuw wachtwoord</label><br>
                        <input class="form-control" type="password" name="passwordConfirmation" ><br>
                        <input class="btn-default btn" type="submit" name="btnPassword" value="Wijzig">
                    </form>
                </div>
                
            </div>

        </div>
    </main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="script/editProfile.js"></script>
</body>
</html>
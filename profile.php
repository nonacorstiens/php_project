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

if (!empty($_POST['email'])) {
    $user = new User(); // userklasse aanspreken
    $user->setEmail($_POST['email']); //variabele email naar userklasse doorgeven
    $user->setId($_SESSION['userid']); //id via session id doorgeven aan userklasse
    $user->changeEmail(); // functie aanroepen die zich in userklasse bevindt
}

if (!empty($_POST['contact-submit'])) {
    //do something here;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>PHPotato</title>
</head>
<body>


    <main class="main">
    <h2 class="h2">Profiel bewerken <?php echo $userInfo['firstName']; ?></h2>
        <div class="profile">
        <?php if (isset($error)): ?>
            <?php echo $error; ?>
        <?php endif; ?>
            <div>
                <h3>Profielfoto</h3>
                <div id="posted_image" style='background-image:url("user_images/ <?php echo $userInfo['userName']; ?>")'></div>
                
                <div id="formEditPic" >
                    <form method="post" enctype="multipart/form-data" name="imageUpload">
                        <label for="post_image" class="file_upload">Upload an image</label>
                        <input type="file" name="post_image" id="post_image"><br>

                        <input class="profile__form button" type="submit" name="btnprofilePicture" value="Wijzig">

                        
                    </form>
                
            </div>
            
            <div>
                <h3>Email</h3>
                <p ><?php echo $userInfo['email']; ?></p>
                
                <div id="formEditEmail" >
                    <form method="post" name="emailChange">
                        <input class="profile__form inputfield" type="text" name="email" value="<?php echo $userInfo['email']; ?>"><br>
                        <input class="profile__form button" type="submit" name="btnEmail" value="Wijzig">
                    </form>
                </div>
                
            </div>

            <div>
            <h3>Wachtwoord</h3>
                
                <div id="formEditPassword">
                    <form method="post" name="passwordChange">
                        <label for="passord" class="formEdit__label">Huidig wachtwoord</label><br>
                        <input class="profile__form inputfield" type="password" name="password"><br>

                        <label for="passord" class="formEdit__label">Nieuw wachtwoord</label><br>
                        <input class="profile__form inputfield" type="password" name="password"><br>

                        <label for="passord" class="formEdit__label">Bevestig nieuw wachtwoord</label><br>
                        <input class="profile__form inputfield" type="password" name="password" ><br>
                        <input class="profile__form button" type="submit" name="btnPassword" value="Wijzig">
                    </form>
                </div>
                
            </div>

        </div>
    </main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="script/editProfile.js"></script>
</body>
</html>
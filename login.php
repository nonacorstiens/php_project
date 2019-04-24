<?php
include_once("classes/Db.class.php");
include_once("classes/User.class.php");
include_once("helpers/Security.class.php");
    


if ( !empty($_POST) ) {
    $db = Db::getInstance();
    $user = new User($db);
    $user->setUsername($_POST['username'] );
    
    try{
        $user->canIlogin($_POST['password']);
        $user->login();
    } catch(Exception $e){
        $error = $e->getMessage();
    }
    
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>PHPotato</title>
</head>
<body>
    <img src="img/logo2.png" alt="logo" id="logo">
    <?php if(isset($error) ): ?>
        <?php echo $error ?>
    <?php endif; ?>
    <form action="" method="post" class="formlogin">
        <label class="label" for="username">Username</label><br>
        <input class="inputfield" type="text" name="username"><br>
        <label class="label" for="password">Password</label><br>
        <input class="inputfield" type="password" name="password"><br>
        <input class="button" type="submit" value="Login">
    </form>

    <a href="register.php" id="registerlink">Dont have an account yet? Sign up here.</a>

</body>
</html>
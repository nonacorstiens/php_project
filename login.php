<?php
    require_once 'bootstrap.php';
    $message = '';
    session_start();

    if (!empty($_POST)) {
        $user = new User();
        $user->setUserName($_POST['userName']);
        $user->setPassword($_POST['password']);
        $user->login();
        if ($user->login() != true) {
            $message = 'You entered a wrong username or password';
        } else {
            $id = $user->getId();
            $name = $user->getFirstName();
            $_SESSION['userid'] = $id;
            $_SESSION['firstname'] = $name;
            header('Location: index.php');
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">

</head>
<body class="hero_container">
    <div class="form-container">
        <h1>Log in to your account</h1>
        <form action="" method="post" class=form-inputs>
                        
                        <?php if ($message != '') {
    echo "<h5 class='alert alert-danger'> $message</h5>";
}?>
                        <div class="form-group">
                            <label for="userName">User Name</label>
                            <input type="text" id="userName" class="form-control" name="userName">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" class="form-control" name="password">
                        </div>
        
                        <div class="form-group">
                            <input type="submit" value="Log in" class="btn btn-primary"> 
                        </div>
        </form>
        <div class="form-switch">
            <p>No account yet?</p>
            <a class ="btn btn-default btn-sm" href="register.php">Register here</a>
        </div>
    </div>   
</body>
</html>
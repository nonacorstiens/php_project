<?php

require_once 'bootstrap.php';

session_start();

if (!empty($_POST)) {
    $user = new User();

    $user->setFirstName($_POST['firstName']);
    $user->setLastName($_POST['lastName']);
    $user->setUserName($_POST['userName']);
    $user->setEmail($_POST['email']);
    $user->setPassword($_POST['password']);
    $user->setPasswordConfirmation($_POST['passwordConfirmation']);

    if ($user->register()) {
        $_SESSION['user'] = $user->getEmail();
        header('location: index.php');
    } else {
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
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <title>Registration</title>

</head>
<body class="hero_container">
    <div class="form-container">
    <h1 form__title>Sign up for an account</h1>
    <form action="" method="post" class="form-inputs">
                    <?php if (!empty($_SESSION['errors'])) {
    foreach ($_SESSION['errors'] as $key => $value) {
        // and print out the values
        echo '<h5 class="alert alert-danger">Error: '.$value.' <br /></h5>';
    }
}?>
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" class="form-control" name="firstName">
                </div>
                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" class="form-control"  name="lastName">
                </div>
                <div class="form-group">
                    <label for="userName">User Name</label>
                    <input type="text" id="userName" class="form-control" name="userName">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" class="form-control" name="email">
                    
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" class="form-control" name="password">
                    <span id="helpBlock" class="help-block">Your password needs to contain minimum 1 number and 1 capital.</span>
                </div>
 
                <div class="form-group">
                    <label for="passwordConfirmation">Confirm your password</label>
                    <input type="password" id="passwordConfirmation" class="form-control" name="passwordConfirmation">
                    <span id="helpBlock" class="help-block">Make sure your passwords match.</span>
                </div>
 
                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="Sign me up!"> 
                </div>
            </form>
            <div class="form-switch">
                <p>Already have an account?</p>
                <a class ="btn btn-default btn-sm" href="login.php">Register here</a>
            </div>
    </div>
</body>
</html>
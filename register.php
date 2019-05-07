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
    <title>Registration</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>
<form action="" method="post">
                <h2 form__title>Sign up for an account</h2>
 
                
                    
                      <?php if (!empty($_SESSION['errors'])) {
    foreach ($_SESSION['errors'] as $key => $value) {
        // and print out the values
        echo '<h5 class="alert alert-danger">Error: '.$value.' <br /></h5>';
    }
}?>
                    
                
                <div class="form__field">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="firstName">
                </div>
                <div class="form__field">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="lastName">
                </div>
                <div class="form__field">
                    <label for="userName">User Name</label>
                    <input type="text" id="userName" name="userName">
                </div>
                <div class="form__field">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email">
                </div>
                <div class="form__field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
                </div>
 
                <div class="form__field">
                    <label for="passwordConfirmation">Confirm your password</label>
                    <input type="password" id="passwordConfirmation" name="passwordConfirmation">
                </div>
 
                <div class="form__field">
                    <input type="submit" value="Sign me up!"> 
                </div>
            </form>

    
    
</body>
</html>
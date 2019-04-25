<?php
    require_once("bootstrap.php");


    if(!empty($_POST)){
        $user = new User();
        $user->setUserName($_POST['userName']);
        $user->setPassword($_POST['password']);
        $user->login();
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>
<form action="" method="post">
                <h2 form__title>Log in to your account</h2>
 
                <div class="form__error hidden">
                    <p>
                        Some error here
                    </p>
                </div>
                <div class="form__field">
                    <label for="userName">User Name</label>
                    <input type="text" id="userName" name="userName">
                </div>
                <div class="form__field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
                </div>
 
                <div class="form__field">
                    <input type="submit" value="Log in"> 
                </div>
            </form>

    
    
</body>
</html>
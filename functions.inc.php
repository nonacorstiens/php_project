<?php

function validate($str)
{
    return trim(htmlspecialchars($str));
}

function isPasswordStrongEnough($password)
{
    if (strlen($password) < 8) {
        return false;
    }

    return true;
}

function isEqual($item1, $item2)
{
    if ($item1 != $item2) {
        return false;
    }

    return true;
}

function valid_email($str)
{
    return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? false : true;
}

function valid_name($name)
{
    if (!preg_match('/^[a-zA-Z0-9\s]+$/', $name)) {
        return false;
    }

    return true;
}

function canChangePassword($password1, $password2)
{
    $ok = true;
    $errorMessages = array();

    if (!isEqual($password1, $password2)) {
        array_push($errorMessages, 'Passwords are not matching');
        $ok = false;
    }

    if (!isPasswordStrongEnough($password1)) {
        array_push($errorMessages, 'Password is not strong enough');
        $ok = false;
    }

    $_SESSION['errors'] = $errorMessages;

    if ($ok === true) {
        return true;
    }
}

?>


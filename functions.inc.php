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

function canRegister($firstName, $lastName, $userName, $email, $password1, $password2)
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

    if (empty($email) || empty($firstName) || empty($lastName) || empty($userName) || empty($password1) || empty($password2)) {
        array_push($errorMessages, 'All fields must be filled in');
        $ok = false;
    }

    if (!valid_email($email)) {
        array_push($errorMessages, 'Not a valid email');
        $ok = false;
    }

    if (!valid_name($firstName)) {
        array_push($errorMessages, 'First name can only contain letters, numbers and white spaces');
    }

    if (!valid_name($lastName)) {
        array_push($errorMessages, 'Last name can only contain letters, numbers and white spaces');
    }

    if (!valid_name($userName)) {
        array_push($errorMessages, 'User name can only contain letters, numbers and white spaces');
    }

    $_SESSION['errors'] = $errorMessages;

    if ($ok === true) {
        return true;
    }
}

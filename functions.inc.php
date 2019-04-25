<?php 

session_start();

function isPasswordStrongEnough($password){
    if(strlen($password) < 8) {
        return false;
    }

    return true;
}

function isEqual($item1, $item2){
    if($item1 != $item2){
        return false;
    }

    return true;
}

function valid_email($str) {
    return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
    }

function canRegister($email, $password1, $password2){
    if (!isEqual($password1, $password2)){
        return false;
    }

    if( !isPasswordStrongEnough($password1)){
        return false;
    }

    if(empty($email)){
        return false;
    }

    if( !valid_email($email)){
        return false;
    }


    return true;
}


?>
<?php
session_start();
require 'functions.php';

['email' => $email, 'password' => $password] = $_POST;

$user = get_user_by_email($email);

if (!empty($user)) {
    set_flash_message('danger', 'Пользователь с таким email уже существует!');
    redirect_to('/register.php');
}

add_user($email, $password);

set_flash_message('success', 'Регистрация успешна');
redirect_to('/login.php');
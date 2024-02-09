<?php
session_start();
require 'functions.php';

['email' => $email, 'password' => $password] = $_POST;

$isLogin = login($email, $password);

if (!$isLogin) {
    set_flash_message('danger', 'Не верный логин или пароль!');
    redirect_to('/login.php');
}

redirect_to('/users.php');
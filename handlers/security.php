<?php
session_start();
require 'functions.php';

[
    'userId' => $userId,
    'email' => $email,
    'password' => $password
] = $_POST;

$findUserByEmail = get_user_by_email($email);

if (isset($findUserByEmail['id']) && $findUserByEmail['id'] != $userId) {
    set_flash_message('danger', 'Такой email уже занят!');
    redirect_to('/security.php?id=' . $userId);
}

edit_credentials($userId, $email, $password);

set_flash_message('success', 'Профиль успешно обновлен');
redirect_to('/profile.php?id=' . $userId);
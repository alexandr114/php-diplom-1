<?php
session_start();
require 'functions.php';

[
    'email' => $email,
    'password' => $password,
    'username' => $username,
    'job' => $job,
    'phone' => $phone,
    'address' => $address,
    'status' => $status,
    'vk' => $vk,
    'telegram' => $telegram,
    'instagram' => $instagram,
] = $_POST;
$image = $_FILES['image'];

$user = get_user_by_email($email);

if (!empty($user)) {
    set_flash_message('danger', 'Пользователь с таким email уже существует!');
    redirect_to('/create.php');
}

$userId = add_user($email, $password);
edit_user($userId, $username, $job, $phone, $address);
set_status($userId, $status);
add_social_link($userId, $vk, $telegram, $instagram);
upload_avatar($userId, $image);

set_flash_message('success', 'Пользователь успешно добавлен');
redirect_to('/users.php');
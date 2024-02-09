<?php
session_start();
require 'functions.php';

[
    'userId' => $userId,
    'username' => $username,
    'job' => $job,
    'phone' => $phone,
    'address' => $address,
] = $_POST;

edit_user($userId, $username, $job, $phone, $address);

set_flash_message('success', 'Профиль успешно обновлен');
redirect_to('/profile.php?id=' . $userId);
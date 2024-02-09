<?php
session_start();
require 'functions.php';

[
    'userId' => $userId,
] = $_POST;
$image = $_FILES['image'];

upload_avatar($userId, $image);

set_flash_message('success', 'Профиль успешно обновлен');
redirect_to('/profile.php?id=' . $userId);
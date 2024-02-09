<?php
session_start();
require 'functions.php';

[
    'userId' => $userId,
    'status' => $status,
] = $_POST;

set_status($userId, $status);

set_flash_message('success', 'Профиль успешно обновлен');
redirect_to('/profile.php?id=' . $userId);
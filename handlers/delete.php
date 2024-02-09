<?php
session_start();
require 'functions.php';

$edit_user_id = $_GET['id'];
$user = get_user_by_id($edit_user_id);
$user_curr = get_curr_user();

check_edit_info($edit_user_id);
delete_user($edit_user_id);
delete_image($user['image']);

if ($user_curr['id'] == $edit_user_id) {
    logout();
    redirect_to('login.php');
}

set_flash_message('success', 'Пользователь успешно удален!');
redirect_to('users.php');

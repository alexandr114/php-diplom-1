<?php
function connect_db()
{
    return new PDO("mysql:host=mysql;dbname=app;", 'user', 'secret');
}

function get_user_by_email($email)
{
    $pdo = connect_db();
    $sql = "SELECT * FROM users WHERE email=:email";
    $statement = $pdo->prepare($sql);
    $statement->execute(['email' => $email]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function get_user_by_id($id)
{
    $pdo = connect_db();
    $sql = "SELECT * FROM users WHERE id=:id";
    $statement = $pdo->prepare($sql);
    $statement->execute(['id' => $id]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function add_user($email, $password)
{
    $pdo = connect_db();
    $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
    $statement = $pdo->prepare($sql);
    $statement->execute(['email' => $email, 'password' => password_hash($password, PASSWORD_DEFAULT)]);
    return $pdo->lastInsertId();
}

function edit_user($userId, $username, $job, $phone, $address)
{
    $pdo = connect_db();
    $sql = "UPDATE users SET username=?, job=?, phone=?, address=? WHERE id=?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$username, $job, $phone, $address, $userId]);
}

function delete_user($userId)
{
    $pdo = connect_db();
    $sql = "DELETE FROM users WHERE id=?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$userId]);
}

function edit_credentials($userId, $email, $password)
{
    $pdo = connect_db();
    $sql = "UPDATE users SET email=:email, password=:password WHERE id=:id";
    $statement = $pdo->prepare($sql);
    $statement->execute([
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'id' => $userId
    ]);
}

function status_user()
{
    return [
        'online' => [
            'class' => 'success',
            'name' => 'Онлайн'
        ],
        'leave' => [
            'class' => 'warning',
            'name' => 'Отошел'
        ],
        'not_disturb' => [
            'class' => 'danger',
            'name' => 'Не беспокоить'
        ],
    ];
}

function get_status_class($user)
{
    $status = status_user();
    return $status[$user['status']]['class'];
}

function set_status($userId, $status)
{
    $pdo = connect_db();
    $sql = "UPDATE users SET status=? WHERE id=?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$status, $userId]);
}

function delete_image($image)
{
    if ($image && file_exists($_SERVER["DOCUMENT_ROOT"] . $image)) {
        unlink($_SERVER["DOCUMENT_ROOT"] . $image);
    }
}

function upload_avatar($userId, $image)
{
    if (empty($image['tmp_name'])) {
        return;
    }

    $pdo = connect_db();
    $user = get_user_by_id($userId);
    delete_image($user['image']);

    $imagePath = $image['full_path'];
    $imageTemp = $image['tmp_name'];

    $filePathInfo = pathinfo($imagePath);
    $fileExtension = $filePathInfo['extension'];
    $imagePath = "/uploads/avatars/" . uniqid() . "." . $fileExtension;

    if (is_uploaded_file($imageTemp)) {
        move_uploaded_file($imageTemp, $_SERVER["DOCUMENT_ROOT"] . $imagePath);
        $sql = "UPDATE users SET image=? WHERE id=?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$imagePath, $userId]);
    }
}

function add_social_link($userId, $vk, $telegram, $instagram)
{
    $pdo = connect_db();
    $sql = "UPDATE users SET vk=?, telegram=?, instagram=? WHERE id=?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$vk, $telegram, $instagram, $userId]);
}

function login($email, $password)
{
    $user = get_user_by_email($email);
    if (empty($user) || !password_verify($password, $user['password'])) {
        return false;
    }

    $_SESSION['user'] = $user;
    return true;
}

function get_users()
{
    $pdo = connect_db();
    $sql = "SELECT * FROM users";
    $statement = $pdo->prepare($sql);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function get_curr_user()
{
    return $_SESSION['user'] ?? [];
}

function is_logged()
{
    return isset($_SESSION['user']);
}

function logout()
{
    unset($_SESSION['user']);
}

function is_admin($user)
{
    if (!is_logged()) {
        return false;
    }
    return $user['role'] === 'admin';
}

function is_author($curr_user_id, $edit_user_id)
{
    return $curr_user_id == $edit_user_id;
}

function is_can_edit($edit_user_id)
{
    $user_curr = get_curr_user();
    return is_admin($user_curr) || is_author($user_curr['id'], $edit_user_id);
}

function check_edit_info($edit_user_id)
{
    if (!is_logged()) {
        redirect_to('login.php');
    }

    if (!is_can_edit($edit_user_id)) {
        set_flash_message('danger', 'Можно редактировать только свой профиль!');
        redirect_to('users.php');
    }
}

function set_flash_message($name, $message)
{
    $_SESSION[$name] = $message;
}

function display_flash_message($name)
{
    if (!isset($_SESSION[$name])) {
        return;
    }
    echo "<div class=\"alert alert-{$name} text-dark\" role=\"alert\">{$_SESSION[$name]}</div>";
    unset($_SESSION[$name]);
}

function redirect_to($path)
{
    header("Location: {$path}");
    exit;
}
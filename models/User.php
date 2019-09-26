<?php

class User
{
    #Проверка Email
    public static function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    #Проверка пароля
    public static function checkPassword($password)
    {
        if (strlen($password) >= 4 && strlen($password) <= 50) {
            return true;
        }
        return false;
    }

    #Проверка пользователя на существование
    public static function checkUserData($email, $password)
    {
        $db = Db::getConnection();

        $sql_user = "SELECT id FROM users WHERE user_email = :email and user_password = :password";
        $result = $db->prepare($sql_user);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        $result->execute();

        $user = $result->fetch();
        if ($user) {
            return $user['id'];
        }
        return false;
    }

    #Успешная авторизация пользователя
    public static function userAuth($userId)
    {
        session_start();
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
        session_write_close();
    }

    #Проверка авторизации пользователя
    public static function checkLogged()
    {
        session_start();
        if (isset($_SESSION['user_id']) && ($_SESSION['user_ip'] == $_SERVER['REMOTE_ADDR'])) {
            $userId = $_SESSION['user_id'];
            session_write_close();
            return $userId;
        }
        session_write_close();
        header("Location: /");
    }

    #Выход пользователя
    public static function userLogout()
    {
        session_start();
        unset($_SESSION['user_id']);
        unset($_SESSION['user_ip']);
        session_unset();
        session_destroy();
        session_write_close();
    }

    public static function safeRequest($request)
    {
        $request = trim($request);
        $request = htmlspecialchars($request);
        $request = addslashes($request);
        return $request;
    }
}

?>
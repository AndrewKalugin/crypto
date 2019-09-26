<?php

class IndexController
{

    #Главная страница с авторизацией
    public function actionIndex()
    {
        $email = '';
        $password = '';
        require_once(ROOT . '/models/User.php');

        #Проверка авторизации
        if (isset($_POST['user_submit'])) {
            $email = $_POST['user_email'];
            $email = User::safeRequest($email);
            $password = $_POST['user_password'];
            $password = User::safeRequest($password);
            $password = '6X14'.md5($password).'91jiA';
            $errors = false;

            #Валидация данных
            if (!User::checkEmail($email)) {
                $errors[] = 'Email isn\'t written according to the rules';
            }
            if (!User::checkPassword($password)) {
                $errors[] = 'Password must be more than 4 and less than 50 characters';
            }

            #Проверка на существования пользователя
            $userId = User::checkUserData($email, $password);
            if ($userId) {
                User::userAuth($userId);
                header("Location: /profile/");
            } else {
                $errors[] = 'Login error. Check your login details';
            }

        }

        require_once(ROOT . '/views/index/index.php');
        return true;
    }

    #Выход авторизванного пользователя
    public function actionLogout()
    {
        User::userLogout();
        header("Location: /");
    }
}

?>
<?php

include_once ROOT . '/models/Profile.php';

class ProfileController
{
    #Просмотр своего профиля
    public function actionIndex()
    {
        User::checkLogged();
        $showProfile = array();
        $showProfile = Profile::getUserInfo($_SESSION['user_id']);

        #Проверка снятие со счета
        if (isset($_POST['withdraw'])) {
            $money_count = $_POST['money_count'];
            $money_count = User::safeRequest($money_count);

            if (is_numeric($money_count)) {
                if ($money_count <= $showProfile['balance']) {
                    #Баланс больше или равен запрашиваемой сумме и запрос правильно составлен
                    $errors = false;

                    $db = Db::getConnection();
                    $query_balance = "SELECT balance FROM `users` WHERE id = '$showProfile[id]' FOR UPDATE;";
                    $result_balance = $db->query($query_balance);
                    $row_balance = $result_balance->fetch();
                    $old_balance = $row_balance['balance'];
                    $new_balance = $old_balance - $money_count;

                    $query_make_request = "INSERT into `users_payment` (`user_id`, `user_balance`, `money_amount`, `payment_status`, `payment_task`) VALUES ($showProfile[id], $old_balance, $money_count, 'request','withdraw')";
                    $db->query($query_make_request);

                    $db->beginTransaction();
                    #Изменение баланса
                    $query_change_balance = "UPDATE `users` SET `balance`='$new_balance' WHERE id = '$showProfile[id]'";
                    $db->query($query_change_balance);

                    #Имитация ответа от функционала вывода денег
                    $withdraw_answer = 1;
                    if ($withdraw_answer){
                        $db->commit();

                        #Запись в журнал оплаты об удаче
                        $query_request_done = "INSERT into `users_payment` (`user_id`, `user_balance`, `money_amount`, `payment_status`, `payment_task`) VALUES ($showProfile[id], $new_balance, $money_count, 'done','withdraw')";
                        $db->query($query_request_done);

                        header("Location: /profile/");
                    } else {
                        $db->rollBack();

                        #Запись в журнал оплаты о неудаче
                        $query_request_cancel = "INSERT into `users_payment` (`user_id`, `user_balance`, `money_amount`, `payment_status`, `payment_task`) VALUES ($showProfile[id], $old_balance, $money_count, 'cancel','withdraw')";
                        $db->query($query_request_cancel);
                        $errors[] = 'Failed to withdraw money';
                    }

                } else {
                    $errors[] = 'Your balance less than you wanna take';
                }
            } else {
                $errors[] = 'Please enter a number';
            }
        }
        require_once(ROOT . '/views/profile/index.php');
        return true;
    }

}

?>
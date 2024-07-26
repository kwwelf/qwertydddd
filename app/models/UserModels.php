<?php

namespace app\models;

use app\core\BaseModel;

class UserModels extends BaseModel
{
    public function addNewUser($username, $login, $password)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);

        return $this->insert(
            "INSERT INTO users (username, login, password) VALUES (:username, :login, :password)",
            [
                'username' => $username,
                'login' => $login,
                'password' => $password,
            ]
        );
    }

    public function authByLogin($login, $password)
    {
        $result = false;
        $error_message = '';

        if (empty($login)) {
            $error_message .= "Enter your login!<br>";
        }
        if (empty($password)) {
            $error_message .= "Enter your password!<br>";
        }
        if (empty($error_message)) {
            $users = $this->select('select * from users where login = :login', [
                'login' => $login
            ]);

            if (!empty($users[0])) {
                $passwordCorrect = password_verify($password, $users[0] ['password']);

                if ($passwordCorrect) {
                    $_SESSION['user']['id'] = $users[0]['id'];
                    $_SESSION['user']['username'] = $users[0]['username'];
                    $_SESSION['user']['login'] = $users[0]['login'];
                    $_SESSION['user']['is_admin'] = $users[0]['is_admin'] == '1';

                    $result = true;
                } else {
                    $error_message .= "error<br>";
                }
            } else {
                $error_message .= "error<br>";
            }
        }

        return [
            'result' => $result,
            'error_message' => $error_message
        ];
    }
    public function changePasswordByCurrentPassword($current_password, $new_password, $confirm_new_password)
    {
        $result = false;
        $error_message = '';

        if (empty($current_password)) {
            $error_message .= "Введите текущий пароль!<br>";
        }
        if (empty($new_password)) {
            $error_message .= "Введите новый пароль!<br>";
        }
        if (empty($confirm_new_password)) {
            $error_message .= "Пароль не совпадает!<br>";
        }
        if ($new_password != $confirm_new_password){
            $error_message .= "Пароли не совпадают!<br>";
        }
        if (empty($error_message)) {
            $users = $this->select('select * from users where login = :login', [
                'login' => $_SESSION['user']['login']
            ]);

            if (!empty($users[0])) {
                $passwordCorrect = password_verify($current_password, $users[0]['password']);

                if ($passwordCorrect) {
                    $new_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $updatePassword = $this->update('update users set password = :password where login = :login',[
                        'login' => $_SESSION['user']['login'],
                    'password' => $new_password
                    ]);
                    $result = $updatePassword;
                } else {
                    $error_message .= "Неверный пароль<br>";
                }
            } else {
                $error_message .= " Произошла ошибка при смене пароля <br>";
            }
        }

        return [
            'result' => $result,
            'error_message' => $error_message
        ];
    }
    public function getListUsers()
    {
        $result = null;

        $users = $this->select('select id, username, login, is_admin from users');
        if (!empty($users)) {
            $result = $users;
        }
        return $result;
    }
}

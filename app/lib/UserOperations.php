<?php

namespace app\lib;

class UserOperations
{
    const RoleGuest ='guest';
    const RoleAdmin = 'admin';
    const RoleUser = 'user';
    public static function getRoleUser()
    {
        $result = 'guest';
        if (isset($_SESSION['user']['id']) && isset($_SESSION['user']['is_admin'])) {
            $result =self::RoleAdmin;
        } elseif (isset($_SESSION['user']['id'])) {
            $result = self::RoleUser;
        }
        return $result;
    }
    public static function getMenuLinks()
    {
        $role = self::getRoleUser();
        $list[] = [
            'title' => ' My profile',
            'link' => '/user/profile'
        ];

        $list[] = [
            'title' => 'News',
            'link' => '/news/list'
        ];
        if ($role === self::RoleAdmin) {
            $list[] = [
              'title' => 'User',
              'link'=>'/user/users'
            ];

        }
        $list[] = [
            'title' => 'Exit',
            'link' => '/user/logout'
        ];
        return $list;
    }
}

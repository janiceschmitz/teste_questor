<?php

namespace Application\models;

use Application\models\database\Users as modelUser;


class Users
{

    public static function isLogged()
    {
        if(isset($_SESSION['users'])){
            return $_SESSION['users'];
        }
        return false;
    }

}
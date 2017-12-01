<?php

/**
 * Created by PhpStorm.
 * User: Xaalera
 * Date: 11/30/2017
 * Time: 10:44 PM
 */
class AccountInfo extends Auth
{
    private $url;

    public function __construct(Auth $auth)
    {
        parent::__construct($auth->userLogin, $auth->userHash, $auth->subDomain);
        $this->url = 'https://' . $this->subDomain . '.amocrm.ru/private/api/v2/json/accounts/current';
    }

    public function GetInfo()
    {
        $link = $this->url;
        $result = parent::GetCorn($link);
        return $result;
    }

}
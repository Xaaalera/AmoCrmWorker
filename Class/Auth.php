<?php


class Auth extends ClassWorker

{


    public function __construct($userLogin = '', $userHash = '', $subDomain = '')
    {
        parent::__construct($userLogin, $userHash, $subDomain);
    }

    public function getAuth()
    {
        #https://test.amocrmru/private/api/auth.php?type=json
        $link = "https://{$this->subDomain}.amocrm.ru/private/api/auth.php?type=json";
        $userArrayToCurl = array(
            'USER_LOGIN' => $this->userLogin, #Ваш логин (электронная почта)
            'USER_HASH' => $this->userHash,
        ); #Хэш для доступа к API (смотрите в профиле пользователя))
        $result = parent::GetCornPostFile($link, $userArrayToCurl);
        return $result;
    }


}
<?php

//TODO в дальшнейнем можно  изменить  функции preparePhone() и prepareMail() либо сделать 1 функции принимающую ENUM, значение и код, или  связать с классом INFO  и  тягать оттуда уникальные коды , вопрос нужно ли оно ?
class Contact extends Auth
{
    public $nameContact;
    public $mailContact;
    public $telContact;
    private $url;

    public function __construct(Auth $auth, $nameContact, $telContact, $mailContact)
    {
        parent::__construct($auth->userLogin, $auth->userHash, $auth->subDomain);
        $this->nameContact = $nameContact;
        $this->mailContact = $mailContact;
        $this->telContact = $telContact;
        $this->url = 'https://' . $this->subDomain . '.amocrm.ru/private/api/v2/json/contacts/';

    }

    public function getContacts()
    {
        $link = $this->url . 'list';
        $result = parent::GetCorn($link);
        return $result;
    }


    public function addContacts()
    {
        $result = $this->moronProtection();
        if (empty($result)) {
            $link = $this->url . 'set';
            $result = parent::GetCornPostFile($link, $this->prepareArrayToAdd());
        }
        else{
            $result= $result['contacts'][0];
        }
        return $result;

    }

    //TODO защита пока  слабенькая  только по мылу, но  в процессе её можно доработать и отслеживать по всем параметрам  и если 1 из параметров отличается то делать update  вместо добавления нового пользователя
    //TODO вариантов много, нужно просто  определится нужно это или нет
    private function moronProtection()
    {
        $link = $this->url . 'list?query[email]=' . $this->mailContact.'?limit_rows=1';
        $result = parent::GetCorn($link);
        return $result;
    }


    static function GetIdContacts($Contact)
    {
        $id = $Contact['contacts']['add'][0]['id'];
        return $id;
    }

    private function prepareArrayToAdd()
    {
        $values[] = $this->preparePhone();
        $values[] = $this->prepareMail();
        $contacts = $this->finalArray($values);
        return $contacts;

    }

    private function preparePhone()
    {
        $values = [
            'code' => 'PHONE',
            'values' => [
                'value' => [
                    'value' => $this->telContact,
                    'enum' => 'MOB'
                ]
            ]
        ]; //Mobile Phone
        return $values;
    }

    private function prepareMail()
    {
        $values = [
            'code' => 'EMAIL',
            'values' => [
                'value' => [
                    'value' => $this->mailContact,
                    'enum' => 'WORK'
                ]
            ]
        ]; //mail
        return $values;
    }

    private function finalArray($values)
    {
        $contacts['request']['contacts']['add'] = [
            [
                'name' => $this->nameContact,
                'custom_fields' => $values
            ]
        ];
        return $contacts;
    }
}
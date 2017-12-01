<?php

class Leads extends Auth
{
    private $url;
    public $price;
    private $contact;

    public function __construct(Auth $auth, $price, $contact)
    {
        parent::__construct($auth->userLogin, $auth->userHash, $auth->subDomain);
        $this->url = 'https://' . $this->subDomain . '.amocrm.ru/private/api/v2/json/leads/';
        $this->price = $price;
        $this->contact = $contact;
    }

    public function getLids()
    {
        $link = $this->url . 'list';
        $result = parent::GetCorn($link);
        return $result;
    }

//TODO думаю можно тоже сделать протектор от дублей, но нужно подумать как реализовать пока что голова не собо варит, но сделаки создаются с  тегом Первичный контакт  :)

    public function addLeads(string $title)
    {
        $link = $this->url . 'set';
        $result = parent::GetCornPostFile($link, $this->prepareArrayToAdd($title));
        return $result;
    }

    private function prepareArrayToAdd(string $title)
    {
        $leads['request']['leads']['add'] = [
            [
                'name' => $title,
                'date_create' => time(),
                'last_modified' => time(),
                'status_id' => 2747198,
                'price' => $this->price,
                'responsible_user_id' => Contact::GetIdContacts($this->contact)
            ]
        ];
        return $leads;
    }


}
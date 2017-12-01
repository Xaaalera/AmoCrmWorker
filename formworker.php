<?php
spl_autoload_register(function ($class_name) {
    require_once 'Class/' . $class_name . '.php';
});
$AmoCrmGetter = new Auth('celestialbot@yandex.ru', '72d00f2756202f76d08fb1d5b7ef4421', 'new5a20595bc8622'); //создание экземпляра класса Аутентификации
$AmoCrmGetter->getAuth(); //проходим авторизацию
$Contacts = new Contact($AmoCrmGetter, $_POST['name'], $_POST['phone'], $_POST['email']); //Создание Экземпляра класса Контакта
$Contact=$Contacts->addContacts(); //cоздаём и возвращаем конакт
$Leads = new Leads($AmoCrmGetter,$_POST['price'],$Contact); //создание экземпляра класса Сделки
$leds_result=$Leads->addLeads('Покупка MacBook'); //Создание сделки не знаю или нет но мы будем передавать ешё и Заголовок  :)
print_r(json_encode($leds_result));





//print_r($Contacts->getContacts());    //получить список контактов
//$AccountInfo=new AccountInfo($AmoCrmGetter);
//print_r($AccountInfo->GetInfo()); //получить инфомацию о контакте там лежат все коды и теги
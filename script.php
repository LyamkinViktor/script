<?php

/**
 * Данные от пользователя
 */
$name = $_POST['Name'];

$email = $_POST['Email'];

$phone = $_POST['Phone'];

$tickets = $_POST['Number'];


/**
 * Добавляем сделку
 */
$queryUrl = 'https://b24-jce50c.bitrix24.ru/rest/1/7twwtj56r6p1vp53/crm.deal.add.json';


$queryData = [
    'fields' => [
        'TITLE' => $name,
        'CATEGORY_ID' => '1',
        'UF_CRM_1550868159539' => $tickets,
    ],
];

$queryData = http_build_query($queryData);

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_SSL_VERIFYHOST => FALSE,
    CURLOPT_POST => 1,
    CURLOPT_HEADER => 0,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $queryUrl,
    CURLOPT_POSTFIELDS => $queryData,
));

if(!$result = curl_exec($curl))
{
    $result = curl_error($curl);
}
curl_close($curl);

$result = json_decode($result, true);
$dealID = $result["result"];
var_dump($result);


/**Добавляем контакт*/
$queryUrl = 'https://b24-jce50c.bitrix24.ru/rest/1/7twwtj56r6p1vp53/crm.contact.add.json';
$queryData = [
    'fields' => [
        'NAME' => $name,
        'EMAIL' => [['VALUE' => $email, 'VALUE_TYPE' => 'WORK']],
        'PHONE' => [['VALUE' => $phone, 'VALUE_TYPE' => 'WORK']],
        'OPENED' => 'Y',
        'ASSIGNED_BY_ID' => 1,
        'TYPE_ID' => 'CLIENT',
        'SOURCE_ID' => 'SELF',
    ],
];

$queryData = http_build_query($queryData);

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_SSL_VERIFYHOST => FALSE,
    CURLOPT_POST => 1,
    CURLOPT_HEADER => 0,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $queryUrl,
    CURLOPT_POSTFIELDS => $queryData,
));

if(!$result = curl_exec($curl))
{
    $result = curl_error($curl);
}
curl_close($curl);

$result = json_decode($result, true);
$contactId = $result["result"];
var_dump($result);

/**Добавляем контакт к указанной сделке*/
$queryUrl = 'https://b24-jce50c.bitrix24.ru/rest/1/7twwtj56r6p1vp53/crm.deal.contact.add.json';
$queryData = [
    'id' => $dealID,
    'fields' => [],
];
$queryData['fields']['CONTACT_ID'] = $contactId; //Идентификатор контакта (обязательное поле)

$queryData = http_build_query($queryData);

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_SSL_VERIFYHOST => FALSE,
    CURLOPT_POST => 1,
    CURLOPT_HEADER => 0,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $queryUrl,
    CURLOPT_POSTFIELDS => $queryData,
));

if(!$result = curl_exec($curl))
{
    $result = curl_error($curl);
}
curl_close($curl);

$result = json_decode($result, true);
var_dump($result);
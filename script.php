<?php

/**
 * Данные от пользователя
 */
$name = $_POST['name'];

$email = $_POST['email'];;

$phone = $_POST['phone'];;

$tickets = 42;

/**Добавляем сделку*/
$queryUrl = 'https://b24-q5twwr.bitrix24.ru/rest/1/v4oc1tc9opd8gnri/crm.deal.add.json';

$queryData = [
    'fields' => [
        'TITLE' => $name,
        'CATEGORY_ID' => '1',
        'UF_CRM_1550570607047' => $tickets,
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
$queryUrl = 'https://b24-q5twwr.bitrix24.ru/rest/1/v4oc1tc9opd8gnri/crm.contact.add.json';
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
$queryUrl = 'https://b24-q5twwr.bitrix24.ru/rest/1/v4oc1tc9opd8gnri/crm.deal.contact.add.json';
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


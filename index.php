<!doctype html>
<html lang="ru">
<head>
<meta charset="UTF-8">
             <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                         <meta http-equiv="X-UA-Compatible" content="ie=edge">
             <title>Document</title>
</head>
<body>

    <form method="post" action="/script.php">
        <div> Имя:
            <input type="text" name="name">
        </div><br>
        <div> Телефон:
            <input type="number" name="phone">
        </div><br>
        <div> Почта:
            <input type="email" name="email">
        </div><br>
        <button type="submit">Отправить</button>


</body>
</html>

/**
* Добавляем сделку
*/
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




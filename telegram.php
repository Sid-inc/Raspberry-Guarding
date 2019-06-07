<?php

function telegram($to_do, $message)
{

    // Токен бота и идентификатор чата
    $token=''; // Сюда ввести полученный токен
    $chat_id=''; // Сюда ввести полученный чат ид
     
    // Текст сообщения
    $text = $message;
 
    // Отправить сообщение
    $ch=curl_init();

    if($to_do == 'send'){
        curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot'.$token.'/sendMessage');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'chat_id='.$chat_id.'&text='.urlencode($text));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    }else if($to_do == 'get'){
	curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot'.$token.'/getUpdates');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
    }

    // Настройки прокси, если это необходимо
    $proxy='46.182.84.58:8080';
    //$auth='login:password';
    curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
    curl_setopt($ch, CURLOPT_PROXY, $proxy);
    //curl_setopt($ch, CURLOPT_PROXYUSERPWD, $auth);
 
    // Запуск curl
    $result=curl_exec($ch);
    if($to_do == 'get'){file_put_contents('get.json', $result);}
//    file_put_contents('get.json', $result);
    curl_close($ch);
}

?>
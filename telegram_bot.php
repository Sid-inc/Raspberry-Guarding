<?php
$dir = __DIR__;
if (file_exists($dir.'/lock')) die();
file_put_contents('lock', 'LOCKED');
require_once $dir.'/telegram.php';

telegram('get','1');

$guard_state = '';

$json = file_get_contents($dir.'/get.json');

$chat = json_decode($json);

if (count($chat->{result}) <> 0 ){ //Если есть сообщения
    $last_msg = $chat->{result}[count($chat->{result})-1]->{message}->{text}; //Записываем последнее сообщение в чате
    $guard_state = file_get_contents($dir.'/guard_state'); //Читаем из файла последнее состояние охраны
    if ($guard_state <> $last_msg){ //сравниваем последнее сообщение с состоянием охраны, если не совпадает продолжаем
	if ($last_msg == 'guard on'){
	    file_put_contents($dir.'/guard_state', 'guard on');
	    telegram('send', 'guard started'.hex2bin('F09F91AE'));
	    //Запуск скрипта монторинга сигнализации
	    exec('/home/pi/scripts/php/guarding.sh > /dev/null &');
	}else if($last_msg == 'guard off'){
	    file_put_contents($dir.'/guard_state', 'guard off');
	    telegram('send', 'guard stopped'.hex2bin('F09F98AA'));
	    //Остановка скрипта монторинга сигнализации
	    exec('sudo pkill guarding.sh');
	}
    }
    
}

unlink($dir.'/lock');
unlink($dir.'/get.json');

?>

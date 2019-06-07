<?php

require_once '/home/pi/scripts/php/telegram.php';

telegram('send','Door is open!'.hex2bin('F09F98B1'));

?>
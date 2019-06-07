#! /bin/bash

cd /home/pi/scripts/php

for (( count=1; count<8; count++ ))
do
    php -f /home/pi/scripts/php/telegram_bot.php
    sleep 3
done

#! /bin/bash

echo "4" > /sys/class/gpio/export
echo "in" > /sys/class/gpio/gpio4/direction

let state=$(</sys/class/gpio/gpio4/value)

while ( true )
do
    if [ $(</sys/class/gpio/gpio4/value) -ne $state ]
    then
        if [ $(</sys/class/gpio/gpio4/value) == 1 ]
        then
            echo "Door is open!"
	    let state=$(</sys/class/gpio/gpio4/value)
	    php -f /home/pi/scripts/php/messages/door_open.php
        fi
	if [ $(</sys/class/gpio/gpio4/value) == 0 ]
        then
            echo "Door is close"
	    let state=$(</sys/class/gpio/gpio4/value)
	    php -f /home/pi/scripts/php/messages/door_close.php
        fi
    fi
    sleep 1
    echo $state
done

echo "4" > /sys/class/gpio/unexport

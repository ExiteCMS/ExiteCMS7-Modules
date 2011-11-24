#!/bin/sh

while true; do
	php -f m2f_pop3.php 1>> logs/M2F_POP3.output.log 2>> logs/M2F_POP3.error.log
	if [ "$?" -ne "99" ]; then
		break
	fi
done

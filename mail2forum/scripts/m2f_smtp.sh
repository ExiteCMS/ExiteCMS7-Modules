#!/bin/sh

while true; do
	php -f m2f_smtp.php 1>> logs/M2F_SMTP.output.log 2>> logs/M2F_SMTP.error.log
	if [ "$?" -ne "99" ]; then
		break
	fi
done

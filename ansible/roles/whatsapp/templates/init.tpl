#!/bin/bash
#
# handles the WhatsApp daemon at /vagrant/php/whatsapp/Daemon/run.php
#
# chkconfig: - 85 15
# description: start, stop, restart whatsapp-daemon
#

RETVAL=0

case "$1" in
    start)
      php /vagrant/php/whatsapp/Daemon/run.php -d -p /var/run/whatsapp-daemon.pid > /dev/null
      RETVAL=$?
  ;;
    stop)
      kill `cat /var/run/whatsapp-daemon.pid`
      RETVAL=$?
  ;;
    restart)
      kill `cat /var/run/whatsapp-daemon.pid`
      php /vagrant/php/whatsapp/Daemon/run.php -d -p /var/run/whatsapp-daemon.pid > /dev/null
      RETVAL=$?
  ;;
    status)
      RETVAL=$?
  ;;
    *)
      echo "Usage: whatsapp-daemon {start|stop|restart}"
      exit 1
  ;;
esac

exit $RETVAL
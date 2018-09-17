#!/bin/bash
/usr/local/php/bin/php /data/www/df5gcn/artisan schedule:run >> /dev/null
#for((i=1;i<=50;i++));do
#sleep 3
#done
# 运行laravel 定时任务 三秒一次脚本
# /usr/local/php/bin/php /data/www/df5gcn/artisan schedule:run >> /data/www/df5gcn/cron.log
# crotabl 每分钟 运行laravel shell 脚本
# * * * * * /data/www/df5gcn/three-seconds.sh
# * * * * *  /data/www/df5gcn/three-seconds.sh
# * * * * * sleep 3 &&  /data/www/df5gcn/three-seconds.sh
# * * * * * sleep 6 &&  /data/www/df5gcn/three-seconds.sh
# * * * * * sleep 9 &&  /data/www/df5gcn/three-seconds.sh
# * * * * * sleep 12 &&  /data/www/df5gcn/three-seconds.sh
# * * * * * sleep 15 &&  /data/www/df5gcn/three-seconds.sh
# * * * * * sleep 18 &&  /data/www/df5gcn/three-seconds.sh
# * * * * * sleep 21 &&  /data/www/df5gcn/three-seconds.sh
# * * * * * sleep 24 &&  /data/www/df5gcn/three-seconds.sh
# * * * * * sleep 27 &&  /data/www/df5gcn/three-seconds.sh
# * * * * * sleep 30 &&  /data/www/df5gcn/three-seconds.sh
# * * * * * sleep 33 &&  /data/www/df5gcn/three-seconds.sh
# * * * * * sleep 36 &&  /data/www/df5gcn/three-seconds.sh
# * * * * * sleep 39 &&  /data/www/df5gcn/three-seconds.sh
# * * * * * sleep 42 &&  /data/www/df5gcn/three-seconds.sh
# * * * * * sleep 45 &&  /data/www/df5gcn/three-seconds.sh
# * * * * * sleep 48 &&  /data/www/df5gcn/three-seconds.sh
# * * * * * sleep 51 &&  /data/www/df5gcn/three-seconds.sh
# * * * * * sleep 54 &&  /data/www/df5gcn/three-seconds.sh
# * * * * * sleep 57 &&  /data/www/df5gcn/three-seconds.sh

* * * * * /data/www/mobile/three-seconds.sh
* * * * * sleep 3 &&  /data/www/mobile/three-seconds.sh
* * * * * sleep 6 &&  /data/www/mobile/three-seconds.sh
* * * * * sleep 9 &&  /data/www/mobile/three-seconds.sh
* * * * * sleep 12 &&  /data/www/mobile/three-seconds.sh
* * * * * sleep 15 &&  /data/www/mobile/three-seconds.sh
* * * * * sleep 18 &&  /data/www/mobile/three-seconds.sh
* * * * * sleep 21 &&  /data/www/mobile/three-seconds.sh
* * * * * sleep 24 &&  /data/www/mobile/three-seconds.sh
* * * * * sleep 27 &&  /data/www/mobile/three-seconds.sh
* * * * * sleep 30 &&  /data/www/mobile/three-seconds.sh
* * * * * sleep 33 &&  /data/www/mobile/three-seconds.sh
* * * * * sleep 36 &&  /data/www/mobile/three-seconds.sh
* * * * * sleep 39 &&  /data/www/mobile/three-seconds.sh
* * * * * sleep 42 &&  /data/www/mobile/three-seconds.sh
* * * * * sleep 45 &&  /data/www/mobile/three-seconds.sh
* * * * * sleep 48 &&  /data/www/mobile/three-seconds.sh
* * * * * sleep 51 &&  /data/www/mobile/three-seconds.sh
* * * * * sleep 54 &&  /data/www/mobile/three-seconds.sh
* * * * * sleep 57 &&  /data/www/mobile/three-seconds.sh
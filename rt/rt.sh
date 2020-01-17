#!/bin/bash
clear
data=`date +%d-%m-%Y_%H-%M-%S`;
curl -o log/log_$data.html "http://localhost/reservas/rt/index.php?dia=25&mes=5&ano=2019";
curl "http://localhost/reservas/rt/mail.php?arq=log/log_$data.html";
echo -e "\n**** OK ****\n";
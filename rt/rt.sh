#!/bin/bash
clear
#
# Script para ser chamado pelo cron;
# gera o arquivo de log em html, que será enviado pelo e-mail.
# Alterar a variável $domínio
# ==> Para testar o script use 'rt.sh dia mes ano' ; 
# se executar somente 'rt.sh' então será feito com a data de hoje.
#
#
dominio="http://localhost/reservas";
#
data=`date +%d-%m-%Y_%H-%M-%S`;
if [[ $1 && $2 && $3 ]];then
teste="?dia=$1&mes=$2&ano=$3";
else
teste="";
fi
curl -o log/log_$data.html "$dominio/rt/index.php$teste";
curl "$dominio/rt/mail.php?arq=log/log_$data.html";
echo -e "\n**** OK ****\n";
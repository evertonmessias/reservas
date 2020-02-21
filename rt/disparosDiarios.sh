#!/bin/bash
clear
#
# Script para ser chamado pelo cron TODOS OS DIAS;
#
# ==> A variável $domínio está no arquivo config.inc.php
#
# ==> Para testar o script use 'disparosDiarios.sh dia mes ano' ; 
#
#
dominio=`cat ../config.inc.php |grep '$dominio'|sed -e 's/";//'|sed -e 's/$dominio="//'`
#
if [[ $1 && $2 && $3 ]];then
teste="?dia=$1&mes=$2&ano=$3";
else
teste="";
fi
curl "$dominio/rt/sys/rt_suporte1dia.php$teste";
curl "$dominio/rt/sys/rt_clientes1dia.php";
curl "$dominio/rt/sys/rt_clientes7dias.php";


#!/bin/bash
clear
#
# Script para ser chamado pelo cron TODOS OS DIAS;
# .. gera log em html

# ==> Alterar a variável $domínio

# ==> Para testar o script use 'suporte.sh dia mes ano' ; 
# se executar somente 'suporte.sh' então será feito com a data de hoje.
#
#
dominio="http://localhost/reservas";
#
if [[ $1 && $2 && $3 ]];then
teste="?dia=$1&mes=$2&ano=$3";
else
teste="";
fi
curl "$dominio/rt/sys/rt_suporte1dia.php$teste";
curl "$dominio/rt/sys/rt_clientes1dia.php";
curl "$dominio/rt/sys/rt_clientes7dias.php";


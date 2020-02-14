#!/bin/bash
clear
#
# Script para ser chamado pelo cron A CADA 1 DIA;
# gera o arquivo de log em html, que será enviado pelo e-mail.

# ==> Alterar a variável $domínio

# ==> Para testar o script use 'clientes.sh dia mes ano' ; 
# se executar somente 'clientes.sh' então será feito com a data de hoje.
#
#
dominio="http://localhost/reservas";
#
if [[ $1 && $2 && $3 ]];then
teste="?dia=$1&mes=$2&ano=$3";
else
teste="";
fi
curl "$dominio/rt/rt_clientes.php$teste";


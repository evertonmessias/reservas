#!/bin/bash
dominio=`cat ../config.inc.php |grep '$dominio'|sed -e 's/";//'|sed -e 's/$dominio="//'`
echo $dominio


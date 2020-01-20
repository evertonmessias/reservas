<?php
$arq = @$_GET['arq'];

function lerArquivo($pathArquivo){
    $html = fopen($pathArquivo,'r');
    $conteudo = '';
    while(!feof($html)) {
        $conteudo = $conteudo . fgets($html);
    }
    fclose($html);
    return $conteudo;
}

$msg = lerArquivo($arq);

$cabecalho = 'MIME-Version: 1.0' . "\r\n";
$cabecalho .= 'Content-type: text/html; charset=iso-8859-1;' . "\r\n";

$destino = 'everton.messias@gmail.com';
$assunto = 'RESERVAS IC - Tarefas da Semana';

$enviar = mail($destino, $assunto, $msg, $cabecalho);

if($enviar){echo "Mensagem ENVIADA";}
else{echo "Erro - Mensagem não Enviada !";}

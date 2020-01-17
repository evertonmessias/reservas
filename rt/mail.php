<?php

$arq = @$_GET['arq'];

function lerArquivo($pathArquivo){
    $ponteiro = fopen($pathArquivo,'r');

    if ($ponteiro == false) 
        die('Não foi possível criar o arquivo.');
    else 
        return $ponteiro;
}

function retornaConteudoArquivo($ponteiro){
    $conteudo = '';
    while(!feof($ponteiro)) {
        $conteudo = $conteudo . fgets($ponteiro);
    }
    fclose($ponteiro);
    return $conteudo;
}

$pont = lerArquivo($arq);
$msg = retornaConteudoArquivo($pont);

$cabecalho = 'MIME-Version: 1.0' . "\r\n";
$cabecalho .= 'Content-type: text/html; charset=iso-8859-1;' . "\r\n";

$destino = 'everton.messias@gmail.com';
$assunto = 'RESERVAS IC - Tarefas da Semana';

$enviar = mail($destino, $assunto, $msg, $cabecalho);

if($enviar){echo "Mensagem Enviada !";}
else{echo "Erro - Mensagem não Enviada !";}









?>
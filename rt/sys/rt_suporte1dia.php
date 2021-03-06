<?php

include './config.inc';

// EMAILS DE TAREFAS PARA O SUPORTE A CADA 1 DIA

if (@$_GET['dia'] && @$_GET['mes'] && @$_GET['ano']) {
  $hoje = @$_GET['ano'] . "-" . @$_GET['mes'] . "-" . @$_GET['dia'];
} else {
  $hoje = 'now';
}

$in = new DateTime($hoje, new DateTimeZone('America/Recife'));
$inicio = $in->getTimestamp();
$f = $in->add(new DateInterval('P1D')); // add 1 dias
$fim = $f->getTimestamp();

$dia = date("d");
$mes = date("m");
$ano = date("Y");
$hora = date("H");
$min = date("i");
$data = $dia . "-" . $mes . "-" . $ano . "_" . $hora . ":" . $min;
$path = './log/' . $data . '.html';
$arquivo = fopen($path, 'w');


$conexao =  mysqli_connect($server, $user, $password, $table);


function consultar($conexao, $inicio, $fim)
{
  //************************** TAB 1 **************************** */

  $sql = "SELECT 
    mrbs_entry.start_time, 
    mrbs_entry.end_time, 
    mrbs_room.room_name, 
    mrbs_entry.create_by, 
    mrbs_entry.name,
    mrbs_entry.mail,
    mrbs_entry.type, 
    mrbs_entry.important 
    FROM mrbs_entry 
    LEFT JOIN mrbs_room 
    ON mrbs_entry.room_id = mrbs_room.id 
    WHERE (mrbs_entry.start_time BETWEEN $inicio and $fim) 
    and (mrbs_entry.type = 'D' or mrbs_entry.type = 'J')";

  $lista = mysqli_query($conexao, $sql);
  $cab_tabela = "
  <span class='inftab'>Tabela de Tese/Dissertações e EQ</span>
  <table>
    <tr class='titulo'>
    <td>Inicio</td>
    <td>Fim</td>
    <td>Sala</td>
    <td>Criado por</td>
    <td>Título</td>
    <td>E-Mail</td>
    <td>Tipo</td>
    <td>Videoconf ?</td>  
    </tr>";

  $corpo_tabela = "";
  $vetor = array();
  while ($vetor = mysqli_fetch_array($lista)) {
    $corpo_tabela = $corpo_tabela . "<tr><td>" . conv2data($vetor[0]) . "</td><td>" . conv2data($vetor[1]) . "</td><td>" . $vetor[2] . "</td><td>" . $vetor[3] . "</td><td>" . utf8_encode($vetor[4]) . "</td><td>" . $vetor[5] . "</td><td style='background-color:#ff0;'>" . conv2type($vetor[6]) . "</td><td style='background-color:".conv2respVC($vetor[7])[1]."'>" . conv2respVC($vetor[7])[0] . "</td></tr>";
  }

  //************************ TAB 2  ***************************

  $sql2 = "SELECT 
    mrbs_entry.start_time, 
    mrbs_entry.end_time, 
    mrbs_room.room_name, 
    mrbs_entry.create_by, 
    mrbs_entry.name,
    mrbs_entry.mail,
    mrbs_entry.type, 
    mrbs_entry.important 
    FROM mrbs_entry 
    LEFT JOIN mrbs_room 
    ON mrbs_entry.room_id = mrbs_room.id 
    WHERE (mrbs_entry.start_time BETWEEN $inicio and $fim) 
    and (mrbs_entry.important = '1' or mrbs_entry.important = '4' or mrbs_entry.important = '5')";

  $lista2 = mysqli_query($conexao, $sql2);
  $cab_tabela2 = "<br><br>
  <span class='inftab'>Tabela de Video Conferêcias</span>
  <table>
    <tr class='titulo'>
    <td>Inicio</td>
    <td>Fim</td>
    <td>Sala</td>
    <td>Criado por</td>
    <td>Título</td>
    <td>E-Mail</td>
    <td>Tipo</td>
    <td>Videoconf ?</td>  
    </tr>";

  $corpo_tabela2 = "";
  $vetor2 = array();
  while ($vetor2 = mysqli_fetch_array($lista2)) {
    $corpo_tabela2 = $corpo_tabela2 . "<tr><td>" . conv2data($vetor2[0]) . "</td><td>" . conv2data($vetor2[1]) . "</td><td>" . $vetor2[2] . "</td><td>" . $vetor2[3] . "</td><td>" . utf8_encode($vetor2[4]) . "</td><td>" . $vetor2[5] . "</td><td style='background-color:#ff0;'>" . conv2type($vetor2[6]) . "</td><td style='background-color:".conv2respVC($vetor2[7])[1]."'>" . conv2respVC($vetor2[7])[0] . "</td></tr>";
  }

  // ****************************************

  $cab_html = '<!DOCTYPE html><html lang="pt-br"><head><title>RT - Registros de Trabalho</title><meta charset="UTF-8" /><style>
  h2 {text-align: left;}table,h2 {width: 1250px;border-spacing: 0px;display: block;position: relative;
    margin: 0 auto;}td {border: 1px solid #000;padding: 4px;}tr.titulo {text-align: center;
    font-weight: bold;background-color: #ddd;font-size: 17px;}
    span.inftab{margin-left:400px;font-weight:bold;}
    </style></head><body>';

  $titulo = "<br><h2>RESERVAS IC - Tarefas Diárias (" . conv2data($inicio) . " a " . conv2data($fim) . ")</h2><br>";


  $pretab = $cab_html . $titulo . $cab_tabela  . $corpo_tabela . "</table>" . $cab_tabela2 . $corpo_tabela2 . "</table>";
  return $pretab;
}
$toda_tabela = consultar($conexao, $inicio, $fim);

$html = $toda_tabela . "</body></html>";

fwrite($arquivo, $html);
fclose($arquivo);

$cabecalho = 'MIME-Version: 1.0' . "\r\n";
$cabecalho .= 'Content-type: text/html; charset=UTF-8;' . "\r\n";

$destino = $mail_suport;
$assunto = 'RESERVAS IC - Tarefas do Dia';

mail($destino, $assunto, $html, $cabecalho);

?>
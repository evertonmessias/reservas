<?php

include './config.inc';

// GERA E-MAIL PARA NOVA RESERVA 

$titulo = $_POST['name'];
$email = $_POST['mail'];
$importante = ($_POST['important']);
$area = $_POST['area'];
$salas = ($_POST['rooms']);
$tipo = ($_POST['type']);
$data = ($_POST['data']);
$hora = ($_POST['hora']);

$cab_html = '<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8" />
<style>
li{font-size:18px;}
span{font-size:22px;font-weight:bold;}
</style>
</head><body>';

$topo = "Prezado(a) Usuário(a), confirmamos sua Reserva de Sala conforme os dados descritos abaixo:<br>";

$lista =
  "<ul><li><strong>Inicio: </strong>" . $data . ", " . horaInicio($hora) . "h" .
  "</li><li><strong>Sala: </strong>" . listaSalas($salas) .
  "</li><li><strong>Tipo: </strong>" . nomeTipo($tipo) .
  "</li><li><strong>Título: </strong>" . $titulo .
  "</li><li><strong>Acessórios: </strong>" . nomeImportante($importante) .
  "</li></ul>";

$lembrete = "<br>Obs.:Chegar com pelo menos 30 min de antecedência<br>
Dúvidas envie um e-mail para: <b>suporte@ic.unicamp.br</b> ou ligue: <b>35215915</b><br></body></html>";

$mensagem = $cab_html . $topo . $lista . $lembrete;

function enviar($destino, $mens)
{
  $cabecalho = 'MIME-Version: 1.0' . "\r\n";
  $cabecalho .= 'Content-type: text/html; charset=iso-8859-1;' . "\r\n";
  $assunto = 'RESERVAS IC - Aviso';
  return mail($destino, $assunto, $mens, $cabecalho);
}

if ($email && ($tipo == 'J' || $tipo == 'D' || $importante == 1|| $importante == 4|| $importante == 5)) {
  $ok = enviar($email, $mensagem);
  if ($ok) {
    echo "Reserva criada: Um e-mail foi enviado para você !";
  } else {
    echo "MENSAGEM NÃO ENVIADA! ==> Título: $titulo, Data: $data, Hora de Inicio: " . horaInicio($hora) . ",
  Sala: " . listaSalas($salas) . ", Tipo: " . nomeTipo($tipo) . ", Email $email, Importante: " . nomeImportante($importante);
  }
} else {
  echo "Reserva criada:Título: $titulo, Data: $data, Hora de Inicio: " . horaInicio($hora) . ",
 Sala: " . listaSalas($salas) . ", Tipo: " . nomeTipo($tipo) . ", Email $email, Importante: " . nomeImportante($importante);
}

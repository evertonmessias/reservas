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
#texto{padding: 30px;font-family:Arial;
display:block;position:relative;margin: 0 auto;
width:600px;border: 1px solid #ccc;text-align:justify;
}
</style>
</head><body>';

$texto ="<h3>Prezado(a) Professor(a),</h3>
<p>Você irá participar de uma Videoconferência em um(a) <b>".nomeTipo($tipo)."</b> no  Instituto
  de  Computação, que será no dia " . $data . " as " . horaInicio($hora) . "h ("
   . listaSalas($salas) ."). Utilizamos os softwares Skype ou Hangout (Google) para realizar 
   a videoconferência, caso tenha  preferencia de  um outro software, por favor contatar via e-mail suporte@ic.unicamp.br assim que possível.</p>
<p>Se necessitar agendar um teste antes da data prevista ou suporte com algum eventual
 problema, estamos a disposição para ajudar, basta enviar um e-mail para suporte@ic.unicamp.br.</p>
<p>** Garanta que seu sistema de áudio (microfone e saída de som) e webcam, estejam
 funcionando no dia. Recomendados a utilização de um headset para uma melhor qualidade 
 no áudio.</p>
 <p><b>Nosso Usuário Skype:</b> ic.unicamp<br>
 <b>Nosso Usuário Hangout:</b> icunicamp9 :</p>
<p>Obs.: Entrar em contato por um dos serviços acima pelo menos <b>15min</b> antes!</p>
<p>Estamos a disposição desde já.</p>
<p><b>Atenciosamente,</b><br>
Equipe de TI do Instituto de Computação - Unicamp</p>
</div>
</body>
</html>";

$mensagem = $cab_html . $texto;

function enviar($destino, $mens)
{
  $cabecalho = 'MIME-Version: 1.0' . "\r\n";
  $cabecalho .= 'Content-type: text/html; charset=UTF-8;' . "\r\n";
  $assunto = 'Participação em Videoconferência, IC/Unicamp ';
  return mail($destino, $assunto, $mens, $cabecalho);
}

if (($tipo == 'J' || $tipo == 'D' ) && ($importante == 1|| $importante == 4|| $importante == 5)) {
  $ok = enviar($email, $mensagem);
  if ($ok) {
    echo "Reserva criada; Um e-mail foi enviado!";
  } else {
    echo "MENSAGEM NÃO ENVIADA! ==> Título: $titulo, Data: $data, Hora de Inicio: " . horaInicio($hora) . ",
  Sala: " . listaSalas($salas) . ", Tipo: " . nomeTipo($tipo) . ", Email $email, Importante: " . nomeImportante($importante);
  }
} else {
  echo "Reserva criada:Título: $titulo, Data: $data, Hora de Inicio: " . horaInicio($hora) . ",
 Sala: " . listaSalas($salas) . ", Tipo: " . nomeTipo($tipo) . ", Email $email, Importante: " . nomeImportante($importante);
}
<?php

include './config.inc';

// EMAILS DE AVISOS PARA OS CLIENTES ( LEMBRETE 1 SEMANA )

if (@$_GET['dia'] && @$_GET['mes'] && @$_GET['ano']) {
  $hoje = @$_GET['ano'] . "-" . @$_GET['mes'] . "-" . @$_GET['dia'];
} else {
  $hoje = 'now';
}

$novadata = new DateTime($hoje, new DateTimeZone('America/Recife'));

$i = $novadata->add(new DateInterval('P6D')); // add 6 dias
$inicio = $i->getTimestamp();

$f = $novadata->add(new DateInterval('P7D')); // add 7 dias
$fim = $f->getTimestamp();

$conexao =  mysqli_connect($server, $user, $password, $table);

function consultar($conexao, $inicio, $fim)
{

  $cab_html = '<!DOCTYPE html>
              <html lang="pt-br">
              <head><meta charset="UTF-8" />
              <style>
              li{font-size:18px;}
              span{font-size:22px;font-weight:bold;}
              </style>
              </head><body>';

    $sql = "SELECT 
    mrbs_entry.start_time, 
    mrbs_entry.end_time, 
    mrbs_room.room_name, 
    mrbs_entry.create_by, 
    mrbs_entry.name,
    mrbs_entry.mail, 
    mrbs_entry.important
    FROM mrbs_entry 
    LEFT JOIN mrbs_room 
    ON mrbs_entry.room_id = mrbs_room.id 
    WHERE (mrbs_entry.start_time BETWEEN $inicio and $fim) 
    and (mrbs_entry.important = '1' or mrbs_entry.important = '4' or mrbs_entry.important = '5')";

  $lista = mysqli_query($conexao, $sql);
  $qtd = 0;
  $emails = array();
  $mensagem = array();
  while ($vetor = mysqli_fetch_array($lista)) {
    $list = 
    "<ul><li><strong>Inicio: </strong>".conv2data($vetor[0]).
    "</li><li><strong>Fim: </strong>".conv2data($vetor[1]).
    "</li><li><strong>Sala: </strong>".$vetor[2].
    "</li><li><strong>Titulo: </strong>" . $vetor[3].
    "</li><li><strong>Descrição: </strong>".utf8_encode($vetor[4]).
    "</li><li><strong>E-Mail: </strong>".$vetor[5].
    "</li><li><strong>Video Conferência: </strong>".conv2resp($vetor[6]).
    "</li></ul>";

    $topo = "Prezado(a) Usuário(a),<br>Alertamos sobre sua Reserva de Sala conforme os dados descritos abaixo:";
    $lembrete = "<br>Obs.:Chegar no dia com pelo menos 30 min de antecedência<br>
    Dúvidas envie um e-mail para: <b>suporte@ic.unicamp.br</b> ou ligue: <b>35215915</b>";

    $qtd++;
    $emails[] = $vetor[5];    
    $mensagem[] = $cab_html . $topo . $list . $lembrete . "</body></html>";
  }

  $saida = array();
  $saida[] = $qtd;
  $saida[] = $emails;
  $saida[] = $mensagem;

  return $saida;
}

$avisos = consultar($conexao, $inicio, $fim);

function enviar($destino, $mensagem)
{
  $cabecalho = 'MIME-Version: 1.0' . "\r\n";
  $cabecalho .= 'Content-type: text/html; charset=UTF-8;' . "\r\n";
  $assunto = 'RESERVAS IC - Aviso';
  mail($destino, $assunto, $mensagem, $cabecalho);
}

for ($i = 0; $i < $avisos[0]; $i++) {
  enviar($avisos[1][$i], $avisos[2][$i]);
}

?>
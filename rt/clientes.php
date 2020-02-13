<?php

// EMAILS DE AVISOS PARA OS CLIENTES

if (@$_GET['dia'] && @$_GET['mes'] && @$_GET['ano']) {
  $hoje = @$_GET['ano'] . "-" . @$_GET['mes'] . "-" . @$_GET['dia'];
} else {
  $hoje = 'now';
}

$in = new DateTime($hoje, new DateTimeZone('America/Recife'));
$inicio = $in->getTimestamp();
$f = $in->add(new DateInterval('P1D')); // add 1 dias
$fim = $f->getTimestamp();

function conexao()
{
  return mysqli_connect("localhost", "root", "efc2505xx", "mrbsic_dev");
}


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
  
  function conv2data($x)
  {
    $formato = 'd/m/Y H:i';
    $data = new DateTime('NOW', new DateTimeZone('America/Recife'));
    $data->setTimestamp($x);
    return $data->format($formato);
  }
  function conv2resp($x)
  {
    if ($x == 0) {
      return "Não";
    } else {
      return "<b>Sim</b>";
    }
  }

    $sql = "SELECT 
    mrbs_entry.start_time, 
    mrbs_entry.end_time, 
    mrbs_room.room_name, 
    mrbs_entry.create_by, 
    mrbs_entry.name,
    mrbs_entry.mail, 
    mrbs_entry.hasVideoConf, 
    mrbs_entry.hasRecording, 
    mrbs_entry.hasLaptop 
    FROM mrbs_entry 
    LEFT JOIN mrbs_room 
    ON mrbs_entry.room_id = mrbs_room.id 
    WHERE (mrbs_entry.start_time BETWEEN $inicio and $fim) 
    and (mrbs_entry.hasVideoConf = 1 or mrbs_entry.hasRecording = 1 or mrbs_entry.hasLaptop = 1)";

  $lista = mysqli_query($conexao, $sql);
  $qtd = 0;
  $emails = array();
  $mensagem = array();
  while ($vetor = mysqli_fetch_array($lista)) {
    $list = 
    "<ul><li><strong>Inicio: </strong>".conv2data($vetor[0]).
    "</li><li><strong>Fim: </strong>".conv2data($vetor[1]).
    "</li><li><strong>Sala: </strong>".$vetor[2].
    "</li><li><strong>Nome: </strong>" . $vetor[3].
    "</li><li><strong>Descrição: </strong>".utf8_encode($vetor[4]).
    "</li><li><strong>E-Mail: </strong>".$vetor[5].
    "</li><li><strong>Video Conferência: </strong>".conv2resp($vetor[6]).
    "</li><li><strong>Gravação: </strong>".conv2resp($vetor[7]).
    "</li><li><strong>Laptop: </strong>".conv2resp($vetor[8]).
    "</li></ul>";

    $topo = "Prezado(a) Usuário(a): <span>".$vetor[3]."</span>,<br>confirmamos sua Reserva de Sala conforme os dados descritos abaixo:";
    $lembrete = "<br>Obs.:Chegar com pelo menos 30 min de antecedência<br>
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

$avisos = consultar(conexao(), $inicio, $fim);

function enviar($destino, $mensagem)
{
  $cabecalho = 'MIME-Version: 1.0' . "\r\n";
  $cabecalho .= 'Content-type: text/html; charset=iso-8859-1;' . "\r\n";
  $assunto = 'RESERVAS IC - Aviso';
  mail($destino, $assunto, $mensagem, $cabecalho);
}

for ($i = 0; $i < $avisos[0]; $i++) {
  enviar($avisos[1][$i], $avisos[2][$i]);
}

?>
</body>

</html>
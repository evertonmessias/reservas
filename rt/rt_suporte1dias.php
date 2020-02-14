<?php

// EMAILS DE TAREFAS PARA O SUPORTE

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

function conexao()
{
  return mysqli_connect("localhost", "root", "efc2505xx", "mrbsic_dev");
}

function consultar($conexao, $inicio, $fim)
{

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

  function conv2respVC($x)  
  {
    $saida = array();
    if ($x == 0) {
      $saida[0] = "Não";
      $saida[1] = "#fff";
      return $saida;
    } else {
      $saida[0] = "<b>Sim</b>";
      $saida[1] = "rgba(255,0,0,0.5)";
      return $saida;
    }
  }

  function conv2type($x){
    switch($x){
      case 'J':return "EQ";break;
      case 'D':return "Tese/Dissertação";break;
      case 'I':return "Interno";break;
      case 'E':return "Externo";break;
      case 'A':return "Aula";break;
      case 'B':return "Palestra";break;
      case 'C':return "Reunião";break;
      case 'F':return "Congregação";break;
      case 'G':return "Concurso";break;
      case 'H':return "Feriado";break;
    }
  }

  //************************** TAB 1 **************************** */

  $sql = "SELECT 
    mrbs_entry.start_time, 
    mrbs_entry.end_time, 
    mrbs_room.room_name, 
    mrbs_entry.create_by, 
    mrbs_entry.name,
    mrbs_entry.mail,
    mrbs_entry.type, 
    mrbs_entry.hasVideoConf, 
    mrbs_entry.hasRecording, 
    mrbs_entry.hasLaptop 
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
    <td>Gravação ?</td>
    <td>Laptop ?</td>   
    </tr>";

  $corpo_tabela = "";
  $vetor = array();
  while ($vetor = mysqli_fetch_array($lista)) {
    $corpo_tabela = $corpo_tabela . "<tr><td>" . conv2data($vetor[0]) . "</td><td>" . conv2data($vetor[1]) . "</td><td>" . $vetor[2] . "</td><td>" . $vetor[3] . "</td><td>" . utf8_encode($vetor[4]) . "</td><td>" . $vetor[5] . "</td><td style='background-color:#ff0;'>" . conv2type($vetor[6]) . "</td><td style='background-color:".conv2respVC($vetor[7])[1]."'>" . conv2respVC($vetor[7])[0] . "</td><td>" . conv2resp($vetor[8]) . "</td><td>" . conv2resp($vetor[9]) . "</td></tr>";
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
    mrbs_entry.hasVideoConf, 
    mrbs_entry.hasRecording, 
    mrbs_entry.hasLaptop 
    FROM mrbs_entry 
    LEFT JOIN mrbs_room 
    ON mrbs_entry.room_id = mrbs_room.id 
    WHERE (mrbs_entry.start_time BETWEEN $inicio and $fim) 
    and (mrbs_entry.hasVideoConf = '1')";

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
    <td>Gravação ?</td>
    <td>Laptop ?</td>   
    </tr>";

  $corpo_tabela2 = "";
  $vetor2 = array();
  while ($vetor2 = mysqli_fetch_array($lista2)) {
    $corpo_tabela2 = $corpo_tabela2 . "<tr><td>" . conv2data($vetor2[0]) . "</td><td>" . conv2data($vetor2[1]) . "</td><td>" . $vetor2[2] . "</td><td>" . $vetor2[3] . "</td><td>" . utf8_encode($vetor2[4]) . "</td><td>" . $vetor2[5] . "</td><td>" . conv2type($vetor2[6]) . "</td><td>" . conv2respVC($vetor2[7])[0] . "</td><td>" . conv2resp($vetor2[8]) . "</td><td>" . conv2resp($vetor2[9]) . "</td></tr>";
  }

  // ****************************************

  $cab_html = '<!DOCTYPE html><html lang="pt-br"><head><title>RT - Registros de Trabalho</title><meta charset="UTF-8" /><style>
  h2 {text-align: left;}table,h2 {width: 1250px;border-spacing: 0px;display: block;position: relative;
    margin: 0 auto;}td {border: 1px solid #000;padding: 4px;}tr.titulo {text-align: center;
    font-weight: bold;background-color: #ddd;font-size: 17px;}
    span.inftab{margin-left:400px;font-weight:bold;}
    </style></head><body>';

  $titulo = "<br><h2>RESERVAS IC - Tarefas de " . conv2data($inicio) . " a " . conv2data($fim) . "</h2><br>";


  $pretab = $cab_html . $titulo . $cab_tabela  . $corpo_tabela . "</table>" . $cab_tabela2 . $corpo_tabela2 . "</table>";
  return $pretab;
}
$toda_tabela = consultar(conexao(), $inicio, $fim);

$html = $toda_tabela . "</body></html>";

fwrite($arquivo, $html);
fclose($arquivo);

$cabecalho = 'MIME-Version: 1.0' . "\r\n";
$cabecalho .= 'Content-type: text/html; charset=iso-8859-1;' . "\r\n";

$destino = 'everton.messias@gmail.com';
$assunto = 'RESERVAS IC - Tarefas da Semana';

mail($destino, $assunto, $html, $cabecalho);

?>
</body>

</html>
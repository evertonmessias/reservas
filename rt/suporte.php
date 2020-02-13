<?php

// EMAILS DE TAREFAS PARA O SUPORTE

$cab_html = '<!DOCTYPE html><html lang="pt-br"><head><title>RT - Registros de Trabalho</title><meta charset="UTF-8" /><style>
      h2 {text-align: center;}table,h2 {width: 1250px;border-spacing: 0px;display: block;position: relative;
        margin: 0 auto;}td {border: 1px solid #000;padding: 4px;}tr.titulo {text-align: center;
        font-weight: bold;background-color: #ddd;font-size: 17px;}</style></head><body>';

if (@$_GET['dia'] && @$_GET['mes'] && @$_GET['ano']) {
  $hoje = @$_GET['ano'] . "-" . @$_GET['mes'] . "-" . @$_GET['dia'];
} else {
  $hoje = 'now';
}

$in = new DateTime($hoje, new DateTimeZone('America/Recife'));
$inicio = $in->getTimestamp();
$f = $in->add(new DateInterval('P7D')); // add 7 dias
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

  $titulo = "<h2>RESERVAS IC - Tarefas de " . conv2data($inicio) . " a " . conv2data($fim) . "</h2>";

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
  $cab_tabela = "<table>
    <tr class='titulo'>
    <td>Inicio</td>
    <td>Fim</td>
    <td>Sala</td>
    <td>Criado por</td>
    <td>Nome</td>
    <td>E-Mail</td>
    <td>Videoconf ?</td>
    <td>Gravação ?</td>
    <td>Laptop ?</td>   
    </tr>";

  $corpo_tabela = "";
  while ($vetor = mysqli_fetch_array($lista)) {
    $corpo_tabela = $corpo_tabela . "<tr><td>" . conv2data($vetor[0]) . "</td><td>" . conv2data($vetor[1]) . "</td><td>" . $vetor[2] . "</td><td>" . $vetor[3] . "</td><td>" . utf8_encode($vetor[4]) . "</td><td>" . $vetor[5] . "</td><td>" . conv2resp($vetor[6]) . "</td><td>" . conv2resp($vetor[7]) . "</td><td>" . conv2resp($vetor[8]) . "</td></tr>";
  }
  $toda_tabela = $titulo . $cab_tabela . $corpo_tabela . "</table>";
  return $toda_tabela;
}
$toda_tabela = consultar(conexao(), $inicio, $fim);


$html = $cab_html . $toda_tabela . "</body></html>";

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
<?php

// GERA E-MAIL PARA NOVA RESERVA 

$titulo = $_POST['name'];
$email = $_POST['f_mail'];
$vc = $_POST['hasVideoConf'];
$area = $_POST['area'];
$salas = ($_POST['rooms']);
$tipo = ($_POST['type']);
$data = ($_POST['data']);
$hora = ($_POST['hora']);

function int2text($n)
{
  if ($n == 1) {
    return "Sim";
  } else {
    return "Não";
  }
}

function nomeArea($id_areas_ic)
{
  switch ($id_areas_ic) {
    case 1:
      return "IC-1e2";
      break;
    case 2:
      return "Laboratórios - IC-3";
      break;
    case 3:
      return "Salas de Aula - IC-3";
      break;
    case 4:
      return "Equipamentos";
      break;
    case 5:
      return "Auditório";
      break;
    case 7:
      return "NovaArea";
      break;
  }
}

function listaSalas($vetorSala)
{
  function nomeSala($id_sala)
  {
    switch ($id_sala) {
      case 1:
        return "Sala 53";
        break;
      case 2:
        return "Sala 85";
        break;
      case 5:
        return "Sala 300";
        break;
      case 6:
        return "Sala 303";
        break;
      case 7:
        return "Sala 304";
        break;
      case 8:
        return "Sala 305";
        break;
      case 12:
        return "Sala 322";
        break;
      case 15:
        return "Sala 351";
        break;
      case 16:
        return "Sala 352";
        break;
      case 17:
        return "Sala 353";
        break;
      case 21:
        return "Projetor OPTOMA";
        break;
      case 22:
        return "Projetor SONY";
        break;
      case 26:
        return "Auditório Completo";
        break;
      case 27:
        return "Auditório 1";
        break;
      case 28:
        return "Auditório 2";
        break;
      case 29:
        return "Câmera filmadora";
        break;
      case 30:
        return "Câmera VC";
        break;
      case 31:
        return "Webcam1";
        break;
      case 32:
        return "Sala 55";
        break;
      case 33:
        return "Sala 57";
        break;
    }
  }
  $qtd_salas = count($vetorSala);
  $lista_salas = "";
  for ($i = 0; $i < $qtd_salas; $i++) {
    if ($i == ($qtd_salas - 1)) {
      $lista_salas .= nomeSala($vetorSala[$i]) . ".";
    } else {
      $lista_salas .= nomeSala($vetorSala[$i]) . ", ";
    }
  }
  return $lista_salas;
}

function nomeTipo($id_tipo)
{
  switch ($id_tipo) {
    case "E":
      return "Externo";
      break;
    case "I":
      return "Interno";
      break;
    case "A":
      return "Aula";
      break;
    case "B":
      return "Palestra";
      break;
    case "C":
      return "Reunião";
      break;
    case "D":
      return "Tese/Dissertação";
      break;
    case "F":
      return "Congregação";
      break;
    case "G":
      return "Concurso";
      break;
    case "H":
      return "Feriado";
      break;
    case "J":
      return "EQ";
      break;
  }
}

function horaInicio($id_hora)
{
    switch ($id_hora) {
      case "32400":
        return "09:00";
        break;
      case "34200":
        return "09:30";
        break;
      case "36000":
        return "10:00";
        break;
      case "37800":
        return "10:30";
        break;
      case "39600":
        return "11:00";
        break;
      case "41400":
        return "11:30";
        break;
      case "43200":
        return "12:00";
        break;
      case "45000":
        return "12:30";
        break;
      case "46800":
        return "13:00";
        break;
      case "48600":
        return "13:30";
        break;
      case "50400":
        return "14:00";
        break;
      case "52200":
        return "14:30";
        break;
      case "54000":
        return "15:00";
        break;
      case "55800":
        return "15:30";
        break;
      case "57600":
        return "16:00";
        break;
      case "59400":
        return "16:30";
        break;
      case "61200":
        return "17:00";
        break;
      case "63000":
        return "17:30";
        break;
      case "64800":
        return "18:00";
        break;
      case "66600":
        return "18:30";
        break;
      case "68400":
        return "19:00";
        break;
      case "70200":
        return "19:30";
        break;
      case "72000":
        return "20:00";
        break;
      case "73800":
        return "20:30";
        break;
      case "75600":
        return "21:00";
        break;
      case "77400":
        return "21:30";
        break;
    }  
}

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
"<ul><li><strong>Inicio: </strong>".$data.", ".horaInicio($hora)."h".
"</li><li><strong>Sala: </strong>".listaSalas($salas).
"</li><li><strong>Título: </strong>" . $titulo.
"</li><li><strong>Video Conferência: </strong>".int2text($vc).
"</li></ul>";

$lembrete = "<br>Obs.:Chegar com pelo menos 30 min de antecedência<br>
Dúvidas envie um e-mail para: <b>suporte@ic.unicamp.br</b> ou ligue: <b>35215915</b><br></body></html>";

$mensagem = $cab_html.$topo.$lista.$lembrete;

function enviar($destino, $mens)
{
  $cabecalho = 'MIME-Version: 1.0' . "\r\n";
  $cabecalho .= 'Content-type: text/html; charset=iso-8859-1;' . "\r\n";
  $assunto = 'RESERVAS IC - Aviso';
  mail($destino, $assunto, $mens, $cabecalho);
}

if($email && ($tipo == 'J' || $tipo == 'D' || $vc == 1)){
enviar($email,$mensagem);
}

//Alert 
echo "TemVC? ".$vc;

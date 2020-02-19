<?php

// variáveis da API RT **********************************

$server = "localhost";
$user = "root";
$password = "efc2505xx";
$table = "mrbsic_dev";
$mail_suport = "everton.messias@gmail.com";

// funções ***********************************************

function int2text($n)
{
  if ($n == 1) {
    return "Sim";
  } else {
    return "Não";
  }
}

function nomeImportante($importante)
{
  switch ($importante) {
    case 0:
      return "Nenhum";
      break;
    case 1:
      return "Video Conferência";
      break;
    case 2:
      return "Gravação";
      break;
    case 3:
      return "Laptop";
      break;
    case 4:
      return "Video Conferência e Gravação";
      break;
    case 5:
      return "Video Conferência e Laptop";
      break;
    case 6:
      return "Gravação e Laptop";
      break;
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
function listaSalas($vetorSalas)
{
  $qtd_salas = count($vetorSalas);
  $lista_salas = "";
  for ($i = 0; $i < $qtd_salas; $i++) {
    if ($i == ($qtd_salas - 1)) {
      $lista_salas .= nomeSala($vetorSalas[$i]) . ".";
    } else {
      $lista_salas .= nomeSala($vetorSalas[$i]) . ", ";
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
      return "Exame Qualificação";
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

function conv2data($x)
  {
    $formato = 'd/m/Y H:i';
    $data = new DateTime('NOW', new DateTimeZone('America/Recife'));
    $data->setTimestamp($x);
    return $data->format($formato);
  }
  function conv2resp($x)
  {
    if ($x == 1 || $x == 4 || $x == 5) {
      return "<b>Sim</b>";
    } else {
      return "Não";
    }
  }

  function conv2respVC($x)  
  {
    $saida = array();
    if ($x == 1 || $x == 4 || $x == 5) {
      $saida[0] = "<b>Sim</b>";
      $saida[1] = "rgba(255,0,0,0.5)";
    } else {
      $saida[0] = "Não";
      $saida[1] = "#fff";
    }
    return $saida;
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

?>
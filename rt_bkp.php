<html>

<head>
  <title>RT - Registros de Trabalho</title>
  <meta charset="UTF-8" />
  <style>
    table {
      border-spacing: 0px;
      display: block;
      position: relative;
      margin: 0 auto;
    }
    table,
    td {
      border: 1px solid #000;
    }
  </style>
</head>

<body>
  <?php

  echo "<h1>EQ/DEFESAS</h1>";

  $tab = "mrbs_entry";

  if (@$_GET['dia'] && @$_GET['mes'] && @$_GET['ano']) {
    $hoje = @$_GET['ano'] . "-" . @$_GET['mes'] . "-" . @$_GET['dia'];
  } else {
    $hoje = 'now';
  }

  $formato = 'd/m/Y H:i:s';

  $in = new DateTime($hoje, new DateTimeZone('America/Recife'));
  $inicio = $in->getTimestamp();
  $f = $in->add(new DateInterval('P7D')); // add 7 dias
  $fim = $f->getTimestamp();


  function conexao()
  {
    return mysqli_connect("localhost", "root", "efc2505xx", "mrbsic_dev");
  }

  function consultar($tabela, $conexao, $formato, $inicio, $fim)
  {
    $data = new DateTime('NOW', new DateTimeZone('America/Recife'));

    //$sql = "SELECT * FROM $tabela WHERE id=125324";
    $sql = "SELECT * FROM $tabela WHERE (start_time BETWEEN $inicio and $fim) and (hasVideoConf = 1 or hasRecording = 1 or hasLaptop = 1)";

    $lista = mysqli_query($conexao, $sql);
    print "<table>
    <tr>
    <td><h4>id</h4></td>
    <td><h4>start_time</h4></td>
    <td><h4>end_time</h4></td>
    <td><h4>entry_type</h4></td>
    <td><h4>repeat_id</h4></td>
    <td><h4>room_id</h4></td>
    <td><h4>timestamp</h4></td>
    <td><h4>create_by</h4></td>
    <td><h4>modified_by</h4></td>
    <td><h4>name</h4></td>
    <td><h4>type</h4></td>
    <td><h4>description</h4></td>
    <td><h4>status</h4></td>
    <td><h4>reminded</h4></td>
    <td><h4>info_time</h4></td>
    <td><h4>info_user</h4></td>
    <td><h4>info_text</h4></td>
    <td><h4>ical_uid</h4></td>
    <td><h4>ical_sequence</h4></td>
    <td><h4>ical_recur_id</h4></td>
    <td><h4>hasVideoConf</h4></td>
    <td><h4>hasRecording</h4></td>
    <td><h4>hasLaptop</h4></td>    
    </tr>";
    while ($vetor = mysqli_fetch_array($lista)) {
      print "<tr>";
      for ($i = 0; $i < 23; $i++) {
        if ($i == 1 || $i == 2) {
          $data->setTimestamp($vetor[$i]);
          print "<td>" . $data->format($formato) . "</td>";
        } else {
          print "<td>" . $vetor[$i] . "</td>";
        }
      }
      print "</tr>";
    }
    print "</table>";
  }

  consultar($tab, conexao(), $formato, $inicio, $fim);

  ?>
</body>

</html>
<?php
	require_once 'PHPExcel.php';
	require_once 'PHPExcel/IOFactory.php';
  //require 'partes.php';
	//$objPHPExcel = PHPExcel_IOFactory::load("data/eldeportivo.xlsx");

	$dirHtmlDestino = "campeonato2016";

	$equipos = array ('AudaxItaliano' => 'Audax Italiano', 'Cobresal' => 'Cobresal', 'ColoColo' => 'Colo Colo',
										'DeportesAntofagasta' => 'Deportes Antofagasta', 'DeportesIquique' => 'Deportes Iquique',
										'DeportesTemuco' => 'Deportes Temuco', 'Everton' => 'Everton', 'Huachipato' => 'Huachipato',
										'Ohiggins' => 'O&#39;Higgins', 'Palestino' => 'Palestino', 'SanLuis' => 'San Luis',
										'SantiagoWanderers' => 'Santiago Wanderers', 'UConcepcion' => 'U. de Concepci&oacute;n',
										'UnionEspanola' => 'Union Espa&#241ola', 'UCatolica' => 'Universidad Cat&oacute;lica',
										'UdeChile' => 'Universiad de Chile'
										);



		$objPHPExcel = PHPExcel_IOFactory::load("data/eldeportivo.xlsx");
    $test = $objPHPExcel->getActiveSheet()->getCell('A5')->getValue();
    $cont = 0;
    $html = "";

		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
      $html = "";
      $html = '<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Equipos campeonato nacional</title>
     <link rel="stylesheet" href="css/estilo.css">
  </head>
  <body>
    <section class="equipos_torneo">
  ';
        //if($cont > 0) { exit(); }
		    $worksheetTitle     = $worksheet->getTitle();
		    $highestRow         = $worksheet->getHighestRow(); // e.g. 10
		    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
		    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
		    $nrColumns = ord($highestColumn) - 64;
		    //echo "<br><span style='color:red;'>The worksheet ".$worksheetTitle." </span>has ";
		    //echo $nrColumns . ' columns (A-' . $highestColumn . ') ';
		    //echo ' and ' . $highestRow . ' row.';
		    //echo '<br>Data: <table border="1"><tr>';

        if (array_key_exists($worksheetTitle, $equipos)) {
            $equipo = $equipos[$worksheetTitle];
        }
$partes = explode(".", $objPHPExcel->setActiveSheetIndex($cont)->getCell('A5')->getValue());
$html .= '
<section class="cabecera '.$worksheetTitle.'">
  <h2>'.$equipo.'</h2>
</section>
<section class="escudo '.$worksheetTitle.'">
  <div class="escudo_equipo '.$worksheetTitle.'"></div>
</section>
<section class="info_equipo">
  <div class="descripcion '.$worksheetTitle.'">
    <p>'.htmlentities($objPHPExcel->setActiveSheetIndex($cont)->getCell('A6')->getValue()).'</p>
  </div>
  <div class="camisetas '.$worksheetTitle.'"></div>
  <div class="clear"></div>
</section>
<section class="escudo solo '.$worksheetTitle.'">
</section>
<section class="info_equipos '.$worksheetTitle.'">
    <h3>'.htmlentities($partes[0]).'</h3>
    <p>'.htmlentities($partes[1]).'</p>
    <p>'.htmlentities($partes[2]).'</p>
</section>
<section class="caja_estrella '.$worksheetTitle.'">
  <div class="img_estrella '.$worksheetTitle.'"></div>
  <h3>'.htmlentities($objPHPExcel->setActiveSheetIndex($cont)->getCell('A7')->getValue()).'</h3>
  <p>'.htmlentities($objPHPExcel->setActiveSheetIndex($cont)->getCell('A8')->getValue()).'</p>
</section>
<section class="plantel">
  <h3>plantel</h3>
  <div class="caja_plantel" style="overflow-x:auto;">
    <table>
      <tr class="tit_tabla">
        <th class="numero">Nº</th>
        <th class="jugador">Jugador</th>
        <th class="pos">Posici&oacute;n</th>
        <th class="pos">Nac.</th>
        <th class="nacimiento">Lugar de Nacimiento</th>
        <th class="fnac">Fecha Nac.</th>
        <th class="min-wd">Altura</th>
        <th class="min-wd">Peso</th>
        <th class="proce">Procedencia</th>
        <th class="min-wd">A&#241o</th>
      </tr>
';

		    for ($row = 10; $row <= $highestRow; ++ $row) {
		        $html .= '<tr>';
		        for ($col = 0; $col < $highestColumnIndex; ++ $col) {
		            $cell = $worksheet->getCellByColumnAndRow($col, $row);
		            $val = $cell->getValue();
		            $dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
		            $html .= '<td>' . $val . '</td>';
		        }
		        $html .= '</tr>';
		    }
		    //echo '</table>';
        $html .='
        </table>
      </div>
    </section>
    <section class="formacion_equipo">
      <div class="formacion">
        <h3>Formaci&oacute;n</h3>
        <div class="img_formacion '.$worksheetTitle.'"></div>
      </div>
    </section>
    <section class="caja_dt_estrella">
        <div class="dt">
          <div class="foto_dt '.$worksheetTitle.'"></div>
          <h3>'.htmlentities($objPHPExcel->setActiveSheetIndex($cont)->getCell('A1')->getValue()).'</h3>
          <p>'.htmlentities($objPHPExcel->setActiveSheetIndex($cont)->getCell('A2')->getValue()).'</p>
        </div>
    </section>
  </section>
  </body>
  </html>
        ';
        $cont++;
        if ($cont > 0) {
          //break;
        }
        $archivo = fopen("templateHtml/".$worksheetTitle.'.html', "w") or die("no abre");
        fwrite($archivo, $html);
        fclose($archivo);
        //echo $html;
		}
    //echo $html;
?>

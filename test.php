<?php
	require_once 'PHPExcel.php';
	require_once 'PHPExcel/IOFactory.php';
	$objPHPExcel = PHPExcel_IOFactory::load("data/eldeportivo.xlsx");

	$dirHtmlDestino = "campeonato2016";

	$equipos = array ('AudaxItaliano' => 'Audax Italiano', 'Cobresal' => 'Cobresal', 'ColoColo' => 'Colo Colo',
										'DeportesAntofagasta' => 'Deportes Antofagasta', 'DeportesIquique' => 'Deportes Iquique',
										'DeportesTemuco' => 'Deportes Temuco', 'Everton' => 'Everton', 'Huachipato' => 'Huachipato',
										'Ohiggins' => 'O&#39;Higgins', 'Palestino' => 'Palestino', 'San Luis' => 'San Luis',
										'SantiagoWanderers' => 'Santiago Wanderers', 'UConcepcion' => 'U. de Concepci&oacute;n',
										'UnionEspanola' => 'Union Espa&#241ola', 'UCatolica' => 'Universidad Cat&oacute;lica',
										'UdeChile' => 'Universiad de Chile'
										);

	function leerXls() {
		$objPHPExcel = PHPExcel_IOFactory::load("data/eldeportivo.xlsx");
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
		    $worksheetTitle     = $worksheet->getTitle();
		    $highestRow         = $worksheet->getHighestRow(); // e.g. 10
		    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
		    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
		    $nrColumns = ord($highestColumn) - 64;
		    echo "<br><span style='color:red;'>The worksheet ".$worksheetTitle." </span>has ";
		    echo $nrColumns . ' columns (A-' . $highestColumn . ') ';
		    echo ' and ' . $highestRow . ' row.';
		    echo '<br>Data: <table border="1"><tr>';
		    for ($row = 1; $row <= $highestRow; ++ $row) {
		        echo '<tr>';
		        for ($col = 0; $col < $highestColumnIndex; ++ $col) {
		            $cell = $worksheet->getCellByColumnAndRow($col, $row);
		            $val = $cell->getValue();
		            $dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
		            echo '<td>' . $val . '<br>(Typ ' . $dataType . ')</td>';
		        }
		        echo '</tr>';
		    }
		    echo '</table>';
		}
	}

	//leerXls();
?>

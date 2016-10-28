<?php
require_once 'PHPExcel.php';
require_once 'PHPExcel/IOFactory.php';

if(isset($_FILES["FileInput"]) && $_FILES["FileInput"]["error"]== UPLOAD_ERR_OK)
{
	############ Edit settings ##############
	$UploadDirectory	= 'tmp/'; //specify upload directory ends with / (slash)
	##########################################

	/*
	Note : You will run into errors or blank page if "memory_limit" or "upload_max_filesize" is set to low in "php.ini".
	Open "php.ini" file, and search for "memory_limit" or "upload_max_filesize" limit
	and set them adequately, also check "post_max_size".
	*/

	//check if this is an ajax request
	if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
		die();
	}


	//Is file size is less than allowed size.
	if ($_FILES["FileInput"]["size"] > 5242880) {
		die("File size is too big!");
	}

	//allowed file type Server side check
	switch(strtolower($_FILES['FileInput']['type']))
		{
			//allowed file types
			/*
      case 'image/png':
			case 'image/gif':
			case 'image/jpeg':
			case 'image/pjpeg':
			case 'text/plain':
			case 'text/html': //html file
			case 'application/x-zip-compressed':
			case 'application/pdf':
			case 'application/msword':
			*/
			case 'application/vnd.ms-excel':
			case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
				break;
			default:
				die('Archivo no soportado!'); //output error
	}
	$tempName = "datosnegocios";
	$File_Name          = strtolower($_FILES['FileInput']['name']);
	$File_Ext           = substr($File_Name, strrpos($File_Name, '.')); //get file extention
	$Random_Number      = rand(0, 9999999999); //Random number to be added to name.
	//$NewFileName 		= $Random_Number.$File_Ext; //new file name
	$NewFileName 		= $tempName.$File_Ext; //new file name
	if(move_uploaded_file($_FILES['FileInput']['tmp_name'], $UploadDirectory.$NewFileName ))
	   {
		$objPHPExcel = PHPExcel_IOFactory::load($UploadDirectory.$NewFileName);
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
		die('Archivo subido exitosamente');
	}else{
		die('Error al subir archivo');
	}

}
else
{
	die('Algo ha ocurrido mal inesperadamente');
}

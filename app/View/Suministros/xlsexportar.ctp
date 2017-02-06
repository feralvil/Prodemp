<?php
$nsuministros = count($suministros);

// Importamos la clase para generar el PDF
App::import('Vendor', 'Classes/PHPExcel');

//Creamos el Excel
date_default_timezone_set('Europe/Madrid');
$objPHPExcel = new PHPExcel();
$locale = 'Es';
$validLocale = PHPExcel_Settings::setLocale($locale);

// Set properties
$objPHPExcel->getProperties()->setCreator("Servici de Telecomunicacions");
$objPHPExcel->getProperties()->setLastModifiedBy("Servici de Telecomunicacions");
$objPHPExcel->getProperties()->setTitle(__("Suministros de Emplazamientos de la Comunitat"));
$objPHPExcel->getProperties()->setSubject(__("Suministros de Emplazamientos de la Comunitat"));
$objPHPExcel->getProperties()->setDescription(__("Suministros de Emplazamientos de la Comunitat"));
$objPHPExcel->getProperties()->setKeywords(__("Suministros de Emplazamientos Comunitat"));
$objPHPExcel->getProperties()->setCategory(__("Suministros de Emplazamientos de la ComunitatA"));

// Creamos la primera hoja como hoja activa la primera y fijamos el título:
//$objPHPExcel->createSheet();
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle('Suminsitros');

// Fijamos los estilos generales de la hoja:
$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);

// Estilos para la hoja:
$estiloTitulo = array(
    'font' => array('bold' => true, 'size' => 12),
    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
);
$estiloRelleno = array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('argb' => 'FFEFEFEF'),
    )
);
$estiloCelda = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    ),
);
$estiloTh = array(
    'font' => array('bold' => true, 'size' => 10),
    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
);
$estiloCentro = array(
    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
);

// Título de la Hoja:
$objPHPExcel->getActiveSheet()->setCellValue('A1', __('Suministros de Emplazamientos de Telecomunicaciones de la Comunitat Valenciana'));
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($estiloTitulo);
$objPHPExcel->getActiveSheet()->mergeCells('A1:M1');

// Número de registros:
$objPHPExcel->getActiveSheet()->setCellValue('A3', __('Total de Suministros' . ': ' . $nsuministros));
$objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($estiloTh);
$objPHPExcel->getActiveSheet()->mergeCells('A3:B3');

// Fila de títulos:
$objPHPExcel->getActiveSheet()->setCellValue("A5", __('ID'));
$objPHPExcel->getActiveSheet()->setCellValue("B5", __('Emplazamiento'));
$objPHPExcel->getActiveSheet()->setCellValue("C5", __('Titular'));
$objPHPExcel->getActiveSheet()->setCellValue("D5", __('Proveedor'));
$objPHPExcel->getActiveSheet()->setCellValue("E5", __('CUPS'));
$objPHPExcel->getActiveSheet()->setCellValue("F5", __('Póliza/ Nº contrato'));
$objPHPExcel->getActiveSheet()->setCellValue("G5", __('Dirección de Suministro'));
$objPHPExcel->getActiveSheet()->setCellValue("H5", __('Tarifa de Acceso'));
$objPHPExcel->getActiveSheet()->setCellValue("I5", __('Pot. Punta'));
$objPHPExcel->getActiveSheet()->setCellValue("J5", __('Pot. Acceso'));
$objPHPExcel->getActiveSheet()->setCellValue("K5", __('Pot. Valle'));
$objPHPExcel->getActiveSheet()->setCellValue("L5", __('Pot. Llano'));
$objPHPExcel->getActiveSheet()->setCellValue("M5", __('Nº Expediente'));
$objPHPExcel->getActiveSheet()->getStyle('A5:M5')->applyFromArray($estiloTh);

// Imprimimos los registros:
$relleno = FALSE;
$fila = 5;
foreach ($suministros as $suministro) {
    $fila++;
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $suministro['Suministro']['id']);
    $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $suministro['Emplazamiento']['centro']);
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $suministro['TitSuministro']['nombre']);
    $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $suministro['ProvSuministro']['nombre']);
    $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $suministro['Suministro']['cups']);
    $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $suministro['Suministro']['nreferencia']);
    $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $suministro['Suministro']['dirsuministro']);
    $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $suministro['Suministro']['taracceso']);
    $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $suministro['Suministro']['potpunta']);
    $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, $suministro['Suministro']['potacceso']);
    $objPHPExcel->getActiveSheet()->setCellValue('K' . $fila, $suministro['Suministro']['potvalle']);
    $objPHPExcel->getActiveSheet()->setCellValue('L' . $fila, $suministro['Suministro']['potllano']);
    $objPHPExcel->getActiveSheet()->setCellValue('M' . $fila, $suministro['Suministro']['expediente']);
    if ($relleno){
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':'.'M'.$fila)->applyFromArray($estiloRelleno);
    }
    $relleno = !($relleno);
}

// Bordes de Celda
$objPHPExcel->getActiveSheet()->getStyle('A5:M'.$fila)->applyFromArray($estiloCelda);
//$objPHPExcel->getActiveSheet()->getStyle('I6:K'.$fila)->applyFromArray($estiloCentro);

// Ajustamos ancho
$columnas = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M');
foreach ($columnas as $columna) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setAutoSize(true);
}

// Generamos el fichero:
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="SuministroEmplazamientos.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>

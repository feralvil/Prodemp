<?php
$nentidades = count($entidades);

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
$objPHPExcel->getProperties()->setTitle(__("Entidades de Emplazamientos de la Comunitat"));
$objPHPExcel->getProperties()->setSubject(__("Entidades de Emplazamientos de la Comunitat"));
$objPHPExcel->getProperties()->setDescription(__("Entidades de Emplazamientos de la Comunitat"));
$objPHPExcel->getProperties()->setKeywords(__("Entidades de Emplazamientos Comunitat"));
$objPHPExcel->getProperties()->setCategory(__("Entidades de Emplazamientos de la ComunitatA"));

// Creamos la primera hoja como hoja activa la primera y fijamos el título:
//$objPHPExcel->createSheet();
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle('Entidades');

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

//ini_set('memory_limit', '256M');

// Título de la Hoja:
$objPHPExcel->getActiveSheet()->setCellValue('A1', __('Entidades de Emplazamientos de la Comunitat Valenciana'));
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($estiloTitulo);
$objPHPExcel->getActiveSheet()->mergeCells('A1:M1');

// Número de registros:
$objPHPExcel->getActiveSheet()->setCellValue('A3', __('Total de Entidades' . ': ' . $nentidades));
$objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($estiloTh);
$objPHPExcel->getActiveSheet()->mergeCells('A3:C3');

// Fila de títulos:
$objPHPExcel->getActiveSheet()->setCellValue("A5", __('ID'));
$objPHPExcel->getActiveSheet()->setCellValue("B5", __('CIF'));
$objPHPExcel->getActiveSheet()->setCellValue("C5", __('Nombre'));
$objPHPExcel->getActiveSheet()->setCellValue("D5", __('Acrónimo'));
$objPHPExcel->getActiveSheet()->setCellValue("E5", __('Tipo de Entidad'));
$objPHPExcel->getActiveSheet()->setCellValue("F5", __('Dirección'));
$objPHPExcel->getActiveSheet()->setCellValue("G5", __('C.P.'));
$objPHPExcel->getActiveSheet()->setCellValue("H5", __('Municipio'));
$objPHPExcel->getActiveSheet()->setCellValue("I5", __('Provincia'));
$objPHPExcel->getActiveSheet()->setCellValue("J5", __('Web'));
$objPHPExcel->getActiveSheet()->setCellValue("K5", __('Mail'));
$objPHPExcel->getActiveSheet()->setCellValue("L5", __('Teléfono'));
$objPHPExcel->getActiveSheet()->setCellValue("M5", __('Fax'));
$objPHPExcel->getActiveSheet()->getStyle('A5:M5')->applyFromArray($estiloTh);

// Imprimimos los registros:
$relleno = FALSE;
$fila = 5;
/*for ($i = 0; $i < 5; $i++){
    $entidad = $entidades[$i];*/
foreach ($entidades as $entidad) {
    $fila++;
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $entidad['Entidad']['id']);
    $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $entidad['Entidad']['cif']);
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $entidad['Entidad']['nombre']);
    $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $entidad['Entidad']['acronimo']);
    $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $entidad['Enttipo']['tipo']);
    $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $entidad['Entidad']['domicilio']);
    $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $entidad['Entidad']['codpostal']);
    $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $entidad['Municipio']['nombre']);
    $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $entidad['Municipio']['provincia']);
    $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, $entidad['Entidad']['web']);
    $objPHPExcel->getActiveSheet()->setCellValue('K' . $fila, $entidad['Entidad']['mail']);
    $objPHPExcel->getActiveSheet()->setCellValue('L' . $fila, $entidad['Entidad']['telefono']);
    $objPHPExcel->getActiveSheet()->setCellValue('M' . $fila, $entidad['Entidad']['fax']);    
    if ($relleno){
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':'.'M'.$fila)->applyFromArray($estiloRelleno);
    }
    $relleno = !($relleno);
}

// Bordes de Celda
$objPHPExcel->getActiveSheet()->getStyle('A5:M'.$fila)->applyFromArray($estiloCelda);

// Ajustamos ancho
$columnas = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M');
foreach ($columnas as $columna) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setAutoSize(true);
}


// Generamos el fichero:
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Entidades.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>

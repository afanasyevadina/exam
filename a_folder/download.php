<?php
require_once('../connect.php');
require_once('../vendor/autoload.php');

$objPHPExcel = new PHPExcel(); 
$objPHPExcel->setActiveSheetIndex(0); 

$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Номер');
$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Фамилия');
$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Имя');
$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Школа');
$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Предмет');
$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Результат');
$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Дата');
if($_GET['school']) {
	$res=$pdo->prepare("SELECT * FROM `results` INNER JOIN `schools` ON `results`.`school_id`=`schools`.`school_id` INNER JOIN `subjects` ON `subjects`.`subject_id`=`results`.`subject_id` WHERE `results`.`subject_id`=? AND `results`.`school_id`=? ORDER BY `results`.`result` DESC");
	$res->execute(array($_GET['subject'], $_GET['school']));
} else {
	$res=$pdo->prepare("SELECT * FROM `results` INNER JOIN `schools` ON `results`.`school_id`=`schools`.`school_id` INNER JOIN `subjects` ON `subjects`.`subject_id`=`results`.`subject_id` WHERE `results`.`subject_id`=? ORDER BY `results`.`result` DESC");
	$res->execute(array($_GET['subject']));
}
$num=0;
$rowCount = 1; 
while ($line=$res->fetch()) { 
	$rowCount++;
	$num++;
	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $num);
	$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $line['surname']);
	$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $line['name']);
	$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $line['school_name']);
	$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $line['subject_name']);
	$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $line['result']);
	$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $line['date']);
} 
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getStyle('A1:G'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

$styleArray = array(
     'borders' => array(
      'allborders' => array(
       'style' => PHPExcel_Style_Border::BORDER_THIN 
     ) 
    ),
    'font'  => array(
        'bold'  => false,
        'color' => array('rgb' => '000'),
        'size'  => 12,
        'name'  => 'Times New Roman'
    ));
$objPHPExcel->getActiveSheet()->getStyle('A1:G'.$rowCount)->applyFromArray($styleArray);

$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
$file='Results.xls';
$objWriter->save($file);
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    // читаем файл и отправляем его пользователю
    readfile($file);
unlink($file);
header('Location: /admin');

?>
<?php

    $marr[1] = "January";
    $marr[2] = "February";
    $marr[3] = "March";
    $marr[4] = "April";
    $marr[5] = "May";
    $marr[6] = "June";
    $marr[7] = "July";
    $marr[8] = "August";
    $marr[9] = "September";
    $marr[10] = "October";
    $marr[11] = "November";
    $marr[12] = "December";
    

$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Poobate Khunthong")
                             ->setLastModifiedBy("Poobate Khunthong")
                             ->setTitle("Office 2007 XLSX ")
                             ->setSubject("Office 2007 XLSX ")
                             ->setDescription("document for Office 2007 XLSX")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("result file");


$Column[1]='นำข้อมูลเข้ารอฟ้อง';
$Column[2]='ลูกหนี้ ชั้นฟ้อง';
$Column[3]='ลูกหนี้ ชั้นสืบพยาน';
$Column[4]='ลูกหนี้ ชั้นส่งคำบังคับ';
$Column[5]='ลูกหนี้ ชั้นตรวจผลหมาย';
$Column[6]='ลูกหนี้ ชั้นตั้งเจ้าพนักงาน';
$Column[7]='ลูกหนี้ ชั้นตรวจผลหมายตั้ง';

$Column[8]='คัดหนังสือรับรองคดีถึงที่สุด';
$Column[9]='สืบทรัพย์(บังคับคดี)';
$Column[10]='คัดโฉนด/ถ่ายภาพ/ประเมิณ';
$Column[11]='ตั้งเรื่องยึดทรัพย์';
$Column[12]='ประกาศขายทอดตลาด';

$head[]= 'ยอด';
$head[]= 'จำนวน';

$origin =  date_create($datefrom);
$target = date_create($dateto);
$interval = $origin->diff($target);
$date_diff =$interval->format('%m');
$date_start = explode('-',$datefrom);

 $m1 = date_format($origin,"n");
 $m2 = date_format($origin,"m");

$objPHPExcel->setActiveSheetIndex(0);

 $c_column = (($date_diff+1)*2);

 

$row = 3;
$c1 = 2;
$m=0;
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((2),$row,"สถานะ");  
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((2),($row+1),$Column[1]);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((2),($row+2),$Column[2]);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((2),($row+3),$Column[3]);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((2),($row+4),$Column[4]);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((2),($row+5),$Column[5]);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((2),($row+6),$Column[6]);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((2),($row+7),$Column[7]);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((2),($row+8),$Column[8]);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((2),($row+9),$Column[9]);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((2),($row+10),$Column[10]);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((2),($row+11),$Column[11]);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((2),($row+12),$Column[12]);
//$objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow(($i-3),2,($i-1),2);

        for($i=3;$i<($c_column+2);$i++){
            
                $month_year = $marr[($m1+$m)].'-'.$date_start[0];
                $y_m = $date_start[0].'-'.sprintf("%02d",($m1+$m));

            for($h=0;$h<count($head);$h++){

                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($i),$row,$head[$h]);    
                    $i++;
                }
                $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow(($i-2),2,($i-1),2);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($i-2),2,$month_year);

          /**นำข้อมูลเข้ารอฟ้อง**/
          $countWaiting = DB::select("SELECT COUNT(Contract_legis) as Waiting , SUM(CAST(Sumperiod_legis AS NUMERIC(19,2))) as amount  from legislations where FORMAT(CONVERT(date, Date_legis),'yyyy-MM') = '". $y_m."'");
          /**ลูกหนี้ ชั้นฟ้อง**/
          $countlegis = DB::select("SELECT count(a.Contract_legis) as legis , SUM(CAST(a.Sumperiod_legis AS NUMERIC(19,2))) as capital_all  FROM legislations a
          left join legiscourts b on a.id = b.legislation_id where FORMAT(CONVERT(date, fillingdate_court),'yyyy-MM') = '". $y_m."'");
          /**ลูกหนี้ ชั้นสืบพยาน**/
          $countExamine = DB::select("SELECT count(a.Contract_legis) as Examine , SUM(CAST( a.Sumperiod_legis AS  NUMERIC(19,2))) as adjudicate_all  FROM legislations a
                          left join legiscourts b on a.id = b.legislation_id where FORMAT(CONVERT(date, examiday_court),'yyyy-MM') = '". $y_m."'");
          /**ลูกหนี้ ชั้นส่งคำบังคับ**/
          $countOrder = DB::select("SELECT count(a.Contract_legis) as Orderall , SUM(CAST( a.Sumperiod_legis AS  NUMERIC(19,2))) as OrderallAM FROM legislations a
                          left join legiscourts b on a.id = b.legislation_id where FORMAT(CONVERT(date, orderday_court),'yyyy-MM') = '". $y_m."'");
          /**ลูกหนี้ ชั้นตรวจผลหมาย**/
          $countCheckSend = DB::select("SELECT count(a.Contract_legis) as CheckSend , SUM(CAST( a.Sumperiod_legis AS  NUMERIC(19,2))) as CheckSendAM FROM legislations a
                          left join legiscourts b on a.id = b.legislation_id where FORMAT(CONVERT(date, checkday_court),'yyyy-MM') = '". $y_m."'");
          /**ลูกหนี้ ชั้นตั้งเจ้าพนักงาน**/
          $countSetOffice = DB::select("SELECT count(a.Contract_legis) as SetOffice , SUM(CAST( a.Sumperiod_legis AS  NUMERIC(19,2))) as SetOfficeAM FROM legislations a
                          left join legiscourts b on a.id = b.legislation_id where FORMAT(CONVERT(date, setoffice_court),'yyyy-MM') = '". $y_m."'");
          /**ลูกหนี้ ชั้นตรวจผลหมายตั้ง**/
          $countCheckOffice = DB::select("SELECT count(a.Contract_legis) as CheckOffice  , SUM(CAST( a.Sumperiod_legis AS  NUMERIC(19,2))) as CheckOfficeAM FROM legislations a
                          left join legiscourts b on a.id = b.legislation_id where FORMAT(CONVERT(date, checkresults_court),'yyyy-MM') = '". $y_m."'");
                 
          /** คัดหนังสือรับรองคดีถึงที่สุด**/
          $countCertificate = DB::select("SELECT count(a.Contract_legis) as Certi  , SUM(CAST( a.Sumperiod_legis AS  NUMERIC(19,2))) as CertiAM FROM legislations a
                          left join legiscourtcases b on a.id = b.legislation_id where FORMAT(CONVERT(date, b.dateCertificate_case),'yyyy-MM') = '". $y_m."'");
           /** สืบทรัพย์(บังคับคดี)**/
           $countAsset = DB::select("SELECT count(a.Contract_legis) as Asset  , SUM(CAST( a.Sumperiod_legis AS  NUMERIC(19,2))) as AssetAM FROM legislations a
                          left join legisassets b on a.id = b.legislation_id where FORMAT(CONVERT(date, b.Date_asset),'yyyy-MM') = '". $y_m."'");      
            /** คัดโฉนด/ถ่ายภาพ**/
          $countPrepare = DB::select("SELECT count(a.Contract_legis) as Prepare  , SUM(CAST( a.Sumperiod_legis AS  NUMERIC(19,2))) as PrepareAM FROM legislations a
                          left join legiscourtcases b on a.id = b.legislation_id where FORMAT(CONVERT(date, b.datepreparedoc_case),'yyyy-MM') = '". $y_m."'");     
          
            /** ตั้งเรื่องยึดทรัพย์ **/
            $countSequester = DB::select("SELECT count(a.Contract_legis) as Sequester  , SUM(CAST( a.Sumperiod_legis AS  NUMERIC(19,2))) as SequesterAM FROM legislations a
                          left join legiscourtcases b on a.id = b.legislation_id where FORMAT(CONVERT(date, b.dateSequester_case),'yyyy-MM') = '". $y_m."'"); 
            
             /** ประกาศขายทอดตลลาด **/
             $countSell = DB::select("SELECT count(a.Contract_legis) as Sell  , SUM(CAST( a.Sumperiod_legis AS  NUMERIC(19,2))) as SellAM FROM legislations a
                          left join legis_publishsells b on a.id = b.legislation_id where FORMAT(CONVERT(date, b.Dateset_publish),'yyyy-MM') = '". $y_m."' ");

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-2)),($row+1),$countWaiting[0]->amount);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-1)),($row+1),$countWaiting[0]->Waiting);

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-2)),($row+2),$countlegis[0]->capital_all);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-1)),($row+2),$countlegis[0]->legis);

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-2)),($row+3),$countExamine[0]->adjudicate_all);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-1)),($row+3),$countExamine[0]->Examine);

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-2)),($row+4),$countOrder[0]->OrderallAM);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-1)),($row+4),$countOrder[0]->Orderall);

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-2)),($row+5),$countCheckSend[0]->CheckSendAM);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-1)),($row+5),$countCheckSend[0]->CheckSend);

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-2)),($row+6),$countSetOffice[0]->SetOfficeAM);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-1)),($row+6),$countSetOffice[0]->SetOffice);

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-2)),($row+7),$countCheckOffice[0]->CheckOfficeAM);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-1)),($row+7),$countCheckOffice[0]->CheckOffice);
        
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-2)),($row+8),$countCertificate[0]->CertiAM);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-1)),($row+8),$countCertificate[0]->Certi);

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-2)),($row+9),$countAsset[0]->AssetAM);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-1)),($row+9),$countAsset[0]->Asset);

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-2)),($row+10),$countPrepare[0]->PrepareAM);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-1)),($row+10),$countPrepare[0]->Prepare);

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-2)),($row+11),$countSequester[0]->SequesterAM);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-1)),($row+11),$countSequester[0]->Sequester);

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-2)),($row+12),$countSell[0]->SellAM);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-1)),($row+12),$countSell[0]->Sell);
                          
        $i=$i-1;
        $m++;
                      
         } 


$default_style = array(
    'font' => array(
        'name' => 'Verdana',
        'color' => array('rgb' => '000000'),
        'size' => 11
    ),
    'alignment' => array(
        'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER
    ),
    'borders' => array(
        'allborders' => array(
            'style' => \PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '000000')
        )
    )
);

// Apply default style to whole sheet
//$objPHPExcel->getActiveSheet()->getDefaultStyle()->applyFromArray($default_style);

$last_col = $objPHPExcel->getActiveSheet()->getHighestColumn(); // Get last column, as a letter
$objPHPExcel->getActiveSheet()->getStyle('C2:'.$last_col.'3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C2:'.$last_col.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C3:'.$last_col.'3')->getAlignment()->setWrapText(true);
// Apply title style to titles

$objPHPExcel->getActiveSheet()->getStyle('C2:'.$last_col.'16')->applyFromArray(
        array(
            
            'borders' => array(
                'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            )
        );  

                
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BInvoice&RPrinted on &D');
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

// Set page orientation and size
//echo date('H:i:s') . " Set page orientation and size\n";
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.75); // กำหนดระยะขอบ บน
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.25); // กำหนดระยะขอบ ขวา
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.25); // กำหนดระยะขอบ ซ้าย
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.75); // กำหนดระยะขอบ ล่าง
// Rename sheet
//echo date('H:i:s') . " Rename sheet\n";
$objPHPExcel->getActiveSheet()->setTitle('Month');



$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BInvoice&RPrinted on &D');
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

// Set page orientation and size
//echo date('H:i:s') . " Set page orientation and size\n";
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.75); // กำหนดระยะขอบ บน
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.25); // กำหนดระยะขอบ ขวา
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.25); // กำหนดระยะขอบ ซ้าย
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.75); // กำหนดระยะขอบ ล่าง
// Rename sheet
//echo date('H:i:s') . " Rename sheet\n";
$objPHPExcel->getActiveSheet()->setTitle('Month');   
$fname = "tmp/legislation.xlsx";
$nameFile = "legislation.xlsx";

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($fname);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="legislation.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
			exit;

?>
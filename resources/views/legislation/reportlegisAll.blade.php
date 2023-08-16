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
$Flag  = array('W' =>'ลูกหนี้ก่อนฟ้อง' ,'Y'=>'ลูกหนี้ส่งฟ้อง','C'=>'ลูกหนี้หลุดขายฝาก' );
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

 

$row = 4;
$c1 = 2;
$m=0;
$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
$objPHPExcel->getActiveSheet()->setCellValue('A1',"รายงานสถานะลูกหนี้ฟ้อง");  

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
    'fill' => array(
                    'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
                    'rotation'   => 90,
                    'startcolor' => array(
                        'argb' => 'FFCC000'
                    ),
                    'endcolor'   => array(
                        'argb' => 'FFFFFFFF'
                    )
                )
);

        /**นำข้อมูลเข้ารอฟ้อง**/
       // $countWaiting = DB::select("SELECT COUNT(Contract_legis) as Waiting , SUM(CAST(Sumperiod_legis AS NUMERIC(19,2))) as amount  from legislations where FORMAT(CONVERT(date, Date_legis),'yyyy-MM') = '". $y_m."'");
          /**ลูกหนี้ ชั้นฟ้อง**/
          $countlegis = DB::select("select a.Date_legis,a.Contract_legis,a.Name_legis,b.bnumber_court,b.rnumber_court,b.orderdatecourt,b.fillingdate_court from legislations a
                        left join legiscourts b on b.legislation_id = a.id
                        where a.Flag = 'Y' and a.Status_legis is null and a.Flag_Class = 'สถานะส่งฟ้อง'");
            $objPHPExcel->getActiveSheet()->setCellValue('A3',$Column[2]);  

            $objPHPExcel->getActiveSheet()->setCellValue('B4','เลขที่สัญญา');  
            $objPHPExcel->getActiveSheet()->setCellValue('C4','ชื่อ-สกุล');  
            $objPHPExcel->getActiveSheet()->setCellValue('D4','เลขคดีดำ');  
            $objPHPExcel->getActiveSheet()->setCellValue('E4','เลขคดีแดง');  
            $objPHPExcel->getActiveSheet()->setCellValue('F4','กำหนดวันฟ้อง');  
            $objPHPExcel->getActiveSheet()->setCellValue('G4','วันที่ฟ้อง');  
            $objPHPExcel->getActiveSheet()->setCellValue('H4','เกินกำหนด'); 

            $objPHPExcel->getActiveSheet()->getStyle('B4:H4')->applyFromArray($default_style);
            foreach ($countlegis as  $value) {
                $orderdatecourt = date('Y-m-d', strtotime(' +45 days', strtotime($value->Date_legis)));
      
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),@$value->bnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->rnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),@$value->orderdatecourt==NULL?$orderdatecourt:@$value->orderdatecourt);  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),@$value->fillingdate_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),'=IF(G'.($row+1).'-F'.($row+1).'<0,"เกินกำหนด","")'); 
                $row++;
            }        
            $objPHPExcel->getActiveSheet()->getStyle('B4:H'.($row))->applyFromArray(
                array(
                    
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                );  
          /**ลูกหนี้ ชั้นสืบพยาน**/
          $countExamine = DB::select("select a.Date_legis,a.Contract_legis,a.Name_legis,b.bnumber_court,b.rnumber_court,b.orderexamiday,b.examiday_court from legislations a
                        left join legiscourts b on b.legislation_id = a.id
                        where a.Flag = 'Y' and a.Status_legis is null and a.Flag_Class = 'สถานะส่งสืบพยาน'");
          
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),$Column[3]);  
            
            $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+2),'เลขที่สัญญา');  
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+2),'ชื่อ-สกุล');  
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+2),'เลขคดีดำ');  
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+2),'เลขคดีแดง');  
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+2),'วันที่สืบพยาน');  
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+2),'วันที่ฟ้อง');  
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'เกินกำหนด');
            $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':H'.($row+2))->applyFromArray($default_style);
            $sB = 'B'.($row+2);
            $row = $row+2;
            foreach ($countExamine as  $value) {
                $orderexamiday  = date('Y-m-d', strtotime(' +75 days', strtotime($value->Date_legis)));
        
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),@$value->bnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->rnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),@$value->orderexamiday==NULL?$orderexamiday:@$value->orderexamiday);  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),@$value->examiday_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),'=IF(G'.($row+1).'-F'.($row+1).'<0,"เกินกำหนด","")'); 
                $row++;
            }
            $objPHPExcel->getActiveSheet()->getStyle( $sB.':H'.($row))->applyFromArray(
                array(
                    
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                );          
          /**ลูกหนี้ ชั้นส่งคำบังคับ**/
          $countOrder = DB::select("select a.Date_legis,a.Contract_legis,a.Name_legis,b.bnumber_court,b.rnumber_court,b.orderday_court,b.ordersend_court from legislations a
                        left join legiscourts b on b.legislation_id = a.id
                        where a.Flag = 'Y' and a.Status_legis is null and a.Flag_Class = 'สถานะส่งคำบังคับ'");
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),$Column[4]);  

            $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+2),'เลขที่สัญญา');  
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+2),'ชื่อ-สกุล');  
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+2),'เลขคดีดำ');  
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+2),'เลขคดีแดง');  
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+2),'กำหนดวันส่งคำบังคับ');  
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+2),'วันที่ส่งคำบังคับ');  
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'เกินกำหนด'); 
            $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':H'.($row+2))->applyFromArray($default_style);
            $sB = 'B'.($row+2);
            $row = $row+2;
            foreach ($countOrder as  $value) {
                $orderdaycourt  = date('Y-m-d', strtotime(' +120 days', strtotime($value->Date_legis)));
       
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),@$value->bnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->rnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),@$value->orderday_court==NULL?$orderdaycourt:@$value->orderday_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),@$value->ordersend_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),'=IF(G'.($row+1).'-F'.($row+1).'<0,"เกินกำหนด","")'); 
                $row++;
            } 
            $objPHPExcel->getActiveSheet()->getStyle( $sB.':H'.($row))->applyFromArray(
                array(
                    
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                );       
          /**ลูกหนี้ ชั้นตรวจผลหมาย**/
          $countCheckSend = DB::select("select a.Date_legis,a.Contract_legis,a.Name_legis,b.bnumber_court,b.rnumber_court,b.checkday_court,b.checksend_court from legislations a
                        left join legiscourts b on b.legislation_id = a.id
                        where a.Flag = 'Y' and a.Status_legis is null and a.Flag_Class = 'สถานะส่งตรวจผลหมาย'");
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),$Column[5]);  

            $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+2),'เลขที่สัญญา');  
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+2),'ชื่อ-สกุล');  
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+2),'เลขคดีดำ');  
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+2),'เลขคดีแดง');  
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+2),'กำหนดวันตรวจผลหมาย');  
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+2),'วันที่ตรวจผลหมาย');  
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'เกินกำหนด'); 
            $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':H'.($row+2))->applyFromArray($default_style);
            $sB = 'B'.($row+2);
            $row = $row+2;
            foreach ($countCheckSend as  $value) {
                $checkdaycourt  = date('Y-m-d', strtotime(' +165 days', strtotime($value->Date_legis)));
       
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),@$value->bnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->rnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),@$value->checkday_court==NULL?$checkdaycour:@$value->checkday_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),@$value->checksend_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),'=IF(G'.($row+1).'-F'.($row+1).'<0,"เกินกำหนด","")'); 
                $row++;
            }  
            $objPHPExcel->getActiveSheet()->getStyle( $sB.':H'.($row))->applyFromArray(
                array(
                    
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                );      
          /**ลูกหนี้ ชั้นตั้งเจ้าพนักงาน**/
          $countSetOffice =  DB::select("select a.Date_legis,a.Contract_legis,a.Name_legis,b.bnumber_court,b.rnumber_court,b.setoffice_court,b.sendoffice_court 
                        from legislations a left join legiscourts b on b.legislation_id = a.id
                        where a.Flag = 'Y' and a.Status_legis is null and a.Flag_Class = 'สถานะส่งตั้งเจ้าพนักงาน'");
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),$Column[6]);  

            $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+2),'เลขที่สัญญา');  
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+2),'ชื่อ-สกุล');  
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+2),'เลขคดีดำ');  
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+2),'เลขคดีแดง');  
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+2),'กำหนดวันตั้งเจ้าพนักงาน');  
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+2),'วันที่ตั้งเจ้าพนักงาน');  
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'เกินกำหนด'); 
            $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':H'.($row+2))->applyFromArray($default_style);
            $sB = 'B'.($row+2);
            $row = $row+2;
            foreach ($countSetOffice as  $value) {
                $setofficecourt  = date('Y-m-d', strtotime(' +220 days', strtotime($value->Date_legis)));
        
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),@$value->bnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->rnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),@$value->setoffice_court==NULL?$setofficecourt:@$value->setoffice_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),@$value->sendoffice_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),'=IF(G'.($row+1).'-F'.($row+1).'<0,"เกินกำหนด","")'); 
                $row++;
            } 
            $objPHPExcel->getActiveSheet()->getStyle( $sB.':H'.($row))->applyFromArray(
                array(
                    
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                );   
          /**ลูกหนี้ ชั้นตรวจผลหมายตั้ง**/
          $countCheckOffice =  DB::select("select a.Date_legis,a.Contract_legis,a.Name_legis,b.bnumber_court,b.rnumber_court,b.checkresults_court,b.sendcheckresults_court 
                        from legislations a left join legiscourts b on b.legislation_id = a.id
                        where a.Flag = 'Y' and a.Status_legis is null and a.Flag_Class = 'สถานะส่งตรวจผลหมายตั้ง'");
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),$Column[7]);  

            $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+2),'เลขที่สัญญา');  
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+2),'ชื่อ-สกุล');  
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+2),'เลขคดีดำ');  
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+2),'เลขคดีแดง');  
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+2),'กำหนดวันตรวจผลหมายตั้ง');  
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+2),'วันที่ตรวจผลหมายตั้ง');  
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'เกินกำหนด'); 
            $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':H'.($row+2))->applyFromArray($default_style);
            $sB = 'B'.($row+2);
            $row = $row+2;
            foreach ($countCheckOffice as  $value) {
                $checkresultscourt  = date('Y-m-d', strtotime(' +265 days', strtotime($value->Date_legis)));

                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),@$value->bnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->rnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),@$value->checkresults_court==NULL?$checkresultscourt:@$value->checkresults_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),@$value->sendcheckresults_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),'=IF(G'.($row+1).'-F'.($row+1).'<0,"เกินกำหนด","")'); 
                $row++;
            } 
            $objPHPExcel->getActiveSheet()->getStyle( $sB.':H'.($row))->applyFromArray(
                array(
                    
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                );   
          /** คัดหนังสือรับรองคดีถึงที่สุด**/
          $countCertificate = DB::select("select a.Date_legis,a.Contract_legis,a.Name_legis,b.bnumber_court,b.rnumber_court,c.orderDateCer,c.dateCertificate_case from legislations a
                            left join legiscourts b on b.legislation_id = a.id
                            left join legiscourtcases c on c.legislation_id = a.id
                            where a.Flag = 'Y' and a.Status_legis is null and a.Flag_Class = 'สถานะคัดหนังสือรับรองคดี'");

            $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),$Column[8]);  

            $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+2),'เลขที่สัญญา');  
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+2),'ชื่อ-สกุล');  
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+2),'เลขคดีดำ');  
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+2),'เลขคดีแดง');  
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+2),'กำหนดวันคดีถึงที่สุด');  
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+2),'วันที่ได้รับคดีถึงที่สุด');  
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'เกินกำหนด'); 
            $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':H'.($row+2))->applyFromArray($default_style);
            $sB = 'B'.($row+2);
            $row = $row+2;
            foreach ($countCertificate as  $value) {
                $DateCer  = date('Y-m-d', strtotime(' +295 days', strtotime($value->Date_legis)));
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),@$value->bnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->rnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),@$value->orderDateCer==NULL? $DateCer:@$value->orderDateCer);  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),@$value->dateCertificate_case);  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),'=IF(G'.($row+1).'-F'.($row+1).'<0,"เกินกำหนด","")'); 
                $row++;
            } 
            $objPHPExcel->getActiveSheet()->getStyle( $sB.':H'.($row))->applyFromArray(
                array(
                    
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                );   
           /** สืบทรัพย์(บังคับคดี)**/
                $countAsset = DB::select("select a.Date_legis,a.Contract_legis,a.Name_legis,b.bnumber_court,b.rnumber_court,c.id,c.sequester_asset,c.sendsequester_asset from legislations a
                                left join legiscourts b on b.legislation_id = a.id
                                left join legisassets c on c.id= (select max(id) from legisassets where legislation_id = a.id)
                                where a.Flag = 'Y' and a.Status_legis is null and c.sequester_asset is not null");
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),'รายงานสืบทรัพย์');  

            $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),'เลขที่สัญญา');  
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),'ชื่อ-สกุล');  
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),'เลขคดีดำ');  
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),'เลขคดีแดง');  
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),'วันที่สืบทรัพย์ล่าสุด');  
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),'สถานะทรัพย์');  
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),'เกินกำหนด'); 
            $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':H'.($row+2))->applyFromArray($default_style);
            $sB = 'B'.($row+2);
            $row = $row+2;
            foreach ($countAsset as  $value) {
                
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),@$value->bnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->rnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),@$value->sequester_asset);  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),@$value->sendsequester_asset);  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),""); 
                $row++;
            } 
            $objPHPExcel->getActiveSheet()->getStyle( $sB.':H'.($row))->applyFromArray(
                array(
                    
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                );         
            /** คัดโฉนด/ถ่ายภาพ**/
        //   $countPrepare = DB::select("SELECT count(a.Contract_legis) as Prepare  , SUM(CAST( a.Sumperiod_legis AS  NUMERIC(19,2))) as PrepareAM FROM legislations a
        //                   left join legiscourtcases b on a.id = b.legislation_id where FORMAT(CONVERT(date, b.datepreparedoc_case),'yyyy-MM') = '". $y_m."'");     
            // $objPHPExcel->getActiveSheet()->setCellValue('A3',$Column[2]);  

            // $objPHPExcel->getActiveSheet()->setCellValue('B4','เลขที่สัญญา');  
            // $objPHPExcel->getActiveSheet()->setCellValue('C4','ชื่อ-สกุล');  
            // $objPHPExcel->getActiveSheet()->setCellValue('D4','เลขคดีดำ');  
            // $objPHPExcel->getActiveSheet()->setCellValue('E4','เลขคดีแดง');  
            // $objPHPExcel->getActiveSheet()->setCellValue('F4','กำหนดวันฟ้อง');  
            // $objPHPExcel->getActiveSheet()->setCellValue('G4','วันที่ฟ้อง');  
            // $objPHPExcel->getActiveSheet()->setCellValue('H4','เกินกำหนด');
            /** ตั้งเรื่องยึดทรัพย์ **/
            // $countSequester = DB::select("SELECT count(a.Contract_legis) as Sequester  , SUM(CAST( a.Sumperiod_legis AS  NUMERIC(19,2))) as SequesterAM FROM legislations a
            //               left join legiscourtcases b on a.id = b.legislation_id where FORMAT(CONVERT(date, b.dateSequester_case),'yyyy-MM') = '". $y_m."'"); 
            
            // $objPHPExcel->getActiveSheet()->setCellValue('A3',$Column[2]);  

            // $objPHPExcel->getActiveSheet()->setCellValue('B4','เลขที่สัญญา');  
            // $objPHPExcel->getActiveSheet()->setCellValue('C4','ชื่อ-สกุล');  
            // $objPHPExcel->getActiveSheet()->setCellValue('D4','เลขคดีดำ');  
            // $objPHPExcel->getActiveSheet()->setCellValue('E4','เลขคดีแดง');  
            // $objPHPExcel->getActiveSheet()->setCellValue('F4','กำหนดวันฟ้อง');  
            // $objPHPExcel->getActiveSheet()->setCellValue('G4','วันที่ฟ้อง');  
            // $objPHPExcel->getActiveSheet()->setCellValue('H4','เกินกำหนด');
             /** ประกาศขายทอดตลลาด **/
            //  $countSell = DB::select("SELECT count(a.Contract_legis) as Sell  , SUM(CAST( a.Sumperiod_legis AS  NUMERIC(19,2))) as SellAM FROM legislations a
            //               left join legis_publishsells b on a.id = b.legislation_id where FORMAT(CONVERT(date, b.Dateset_publish),'yyyy-MM') = '". $y_m."' ");


      

         
       




// Apply default style to whole sheet
//$objPHPExcel->getActiveSheet()->getDefaultStyle()->applyFromArray($default_style);

// $last_col = $objPHPExcel->getActiveSheet()->getHighestColumn(); // Get last column, as a letter
// $objPHPExcel->getActiveSheet()->getStyle('C2:'.$last_col.'3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// $objPHPExcel->getActiveSheet()->getStyle('C2:'.$last_col.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// $objPHPExcel->getActiveSheet()->getStyle('C3:'.$last_col.'3')->getAlignment()->setWrapText(true);
// Apply title style to titles



                
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
$objPHPExcel->getActiveSheet()->setTitle('ลูกหนี้ฟ้อง');


$objPHPExcel->createSheet();    
$objPHPExcel->setActiveSheetIndex(1);
$row = 4;
$c1 = 2;
$m=0;
$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
$objPHPExcel->getActiveSheet()->setCellValue('A1',"รายงานลูกหนี้ประนอมหนี้");  

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
    'fill' => array(
                    'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
                    'rotation'   => 90,
                    'startcolor' => array(
                        'argb' => 'FFCC000'
                    ),
                    'endcolor'   => array(
                        'argb' => 'FFFFFFFF'
                    )
                )
);
$dataNormal = DB::select("select *,DATEDIFF(month,  DateDue_Payment ,CONVERT (Date, GETDATE())) as monthdiff
                                ,Type_Promise,Sum_FirstPromise,Sum_DuePayPromise,Total_Promise
                                from legislations a
                                left join legispayments b on b.legislation_id = a.id
                                left join legiscompromises c on c.legislation_id = a.id
                                where a.Status_legis is null and b.Flag_Payment = 'Y' and Flag_Promise = 'Active'");
          

          $Count1 = 0;
          $Count1_1 = 0;
          $Count1_2 = 0;
          $Count1_3 = 0;
          $Count1_4 = 0;
          $CountNullData = 0;
          $data1 = [];
          $data1_1 = [];
          $data1_2 = [];
          $data1_3 = [];
          $data1_4 = []; 
          $NullData = [];  
$numDue = 0;

          for($j= 0; $j < count($dataNormal); $j++){
        
                $d1 = date_create(@$dataNormal[$j]->DateDue_Payment );
                $d2 = date_create(date('Y-m-d'));
               
                $interval = date_diff($d1,$d2);
              
                $numMonth = $interval->format('%m');
                $numYear = $interval->format('%y');
                
              $numDue = @$dataNormal[$j]->monthdiff;
                if ($dataNormal[$j] != NULL) {  
                  
                  if($numDue>3) {
                    $Count1_4 += 1;
                    $data1_4[] = $dataNormal[$j];                    
                  }elseif($numDue>2){  
                    $Count1_3 += 1;
                    $data1_3[] = $dataNormal[$j];
                    
                  }elseif($numDue>1){
                    $Count1_2 += 1;
                    $data1_2[] = $dataNormal[$j];
                  }elseif($numDue>0){
                  $Count1_1 += 1;
                    $data1_1[] = $dataNormal[$j];
                  }else{
                    $Count1 += 1;
                    $data1[] = $dataNormal[$j];
                  }
                } else {
                  $CountNullData += 1;
                  $NullData[] = $dataNormal[$j];
                }
            
          }

$objPHPExcel->getActiveSheet()->setCellValue('A3','ลูกหนี้ปกติ');  

            $objPHPExcel->getActiveSheet()->setCellValue('B4','เลขที่สัญญา');  
            $objPHPExcel->getActiveSheet()->setCellValue('C4','ชื่อ-สกุล');  
            $objPHPExcel->getActiveSheet()->setCellValue('D4','สถานะประนอม');  
            $objPHPExcel->getActiveSheet()->setCellValue('E4','ประเภทการประนอม');  
            $objPHPExcel->getActiveSheet()->setCellValue('F4','NON');  
            $objPHPExcel->getActiveSheet()->setCellValue('G4','ยอดจ่ายมาแล้ว');  
            $objPHPExcel->getActiveSheet()->setCellValue('H4','ยอดคงเหลือ'); 
            $objPHPExcel->getActiveSheet()->getStyle('B4:H4')->applyFromArray($default_style);
            foreach ($data1 as  $value) {      
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),$Flag[@$value->Flag]);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->Type_Promise);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),'');  
                $sumpay = floatval(@$value->Sum_FirstPromise) + floatval(@$value->Sum_DuePayPromise);
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1), number_format($sumpay,2));  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),number_format( floatval((@$value->Total_Promise)-$sumpay),2)); 
                $row++;
            } 
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),'ลูกหนี้ค้าง 1 งวด');  

            $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+2),'เลขที่สัญญา');  
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+2),'ชื่อ-สกุล');  
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+2),'สถานะประนอม');  
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+2),'ประเภทการประนอม');  
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+2),'NON');  
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+2),'ยอดจ่ายมาแล้ว');  
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'ยอดคงเหลือ'); 
            $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':H'.($row+2))->applyFromArray($default_style);
            $sB = 'B'.($row+2);
            $row = $row+2;
            foreach ($data1_1 as  $value) {
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),$Flag[@$value->Flag]);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->Type_Promise);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),'');  
                $sumpay = floatval(@$value->Sum_FirstPromise) + floatval(@$value->Sum_DuePayPromise);
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1), number_format($sumpay,2));  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),number_format( floatval((@$value->Total_Promise)-$sumpay),2)); 
                $row++;
            } 
            $objPHPExcel->getActiveSheet()->getStyle( $sB.':H'.($row))->applyFromArray(
                array(
                    
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                );   
                $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),'ลูกหนี้ค้าง 2 งวด');  

                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+2),'เลขที่สัญญา');  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+2),'ชื่อ-สกุล');  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+2),'สถานะประนอม');  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+2),'ประเภทการประนอม');  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+2),'NON');  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+2),'ยอดจ่ายมาแล้ว');  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'ยอดคงเหลือ'); 
                $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':H'.($row+2))->applyFromArray($default_style);
                $sB = 'B'.($row+2);
                $row = $row+2;
                foreach ($data1_2 as  $value) {
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),$Flag[@$value->Flag]);  
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->Type_Promise);  
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),'');  
                    $sumpay = floatval(@$value->Sum_FirstPromise) + floatval(@$value->Sum_DuePayPromise);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1), number_format($sumpay,2));  
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),number_format( floatval((@$value->Total_Promise)-$sumpay),2)); 
                    $row++;
                } 
                $objPHPExcel->getActiveSheet()->getStyle( $sB.':H'.($row))->applyFromArray(
                    array(
                        
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                                )
                            )
                        )
                    );   
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),'ลูกหนี้ค้าง 3 งวด');  

                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+2),'เลขที่สัญญา');  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+2),'ชื่อ-สกุล');  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+2),'สถานะประนอม');  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+2),'ประเภทการประนอม');  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+2),'NON');  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+2),'ยอดจ่ายมาแล้ว');  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'ยอดคงเหลือ'); 
                $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':H'.($row+2))->applyFromArray($default_style);
                $sB = 'B'.($row+2);
                $row = $row+2;
                foreach ($data1_3 as  $value) {
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),$Flag[@$value->Flag]);  
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->Type_Promise);  
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),'');  
                    $sumpay = floatval(@$value->Sum_FirstPromise) + floatval(@$value->Sum_DuePayPromise);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1), number_format($sumpay,2));  
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),number_format( floatval((@$value->Total_Promise)-$sumpay),2)); 
                    $row++;
                } 
                $objPHPExcel->getActiveSheet()->getStyle( $sB.':H'.($row))->applyFromArray(
                    array(
                        
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                                )
                            )
                        )
                    );   
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),'ลูกหนี้ค้าง 3 งวดขึ้นไป');  

                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+2),'เลขที่สัญญา');  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+2),'ชื่อ-สกุล');  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+2),'สถานะประนอม');  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+2),'ประเภทการประนอม');  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+2),'NON');  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+2),'ยอดจ่ายมาแล้ว');  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'ยอดคงเหลือ'); 
                $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':H'.($row+2))->applyFromArray($default_style);
                $sB = 'B'.($row+2);
                $row = $row+2;
                foreach ($data1_4 as  $value) {
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),$Flag[@$value->Flag]);  
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->Type_Promise);  
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),'');  
                    $sumpay = floatval(@$value->Sum_FirstPromise) + floatval(@$value->Sum_DuePayPromise);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1), number_format($sumpay,2));  
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),number_format( floatval((@$value->Total_Promise)-$sumpay),2)); 
                    $row++;
                } 
                $objPHPExcel->getActiveSheet()->getStyle( $sB.':H'.($row))->applyFromArray(
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
$objPHPExcel->getActiveSheet()->setTitle('ลูกหนี้ประนอม');   
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
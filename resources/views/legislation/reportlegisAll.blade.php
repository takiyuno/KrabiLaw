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
$y_m = substr($datefrom,0,7);
 $m1 = date_format($origin,"n");
 $m2 = date_format($origin,"m");

 function ParsetoDate($Date_con){
            $data = '';
          if($Date_con!=''){
            $data =  \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(strtotime($Date_con));
          }
             return $data;
           
         } 
$objPHPExcel->setActiveSheetIndex(0);

 $c_column = (($date_diff+1)*2);

 $objPHPExcel->getActiveSheet()->getStyle('F:G') ->getNumberFormat()
                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY); 

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
                        where a.Flag = 'Y' and a.Status_legis is null and a.Flag_Class = 'สถานะส่งฟ้อง' and  FORMAT(cast(b.fillingdate_court as date),'yyyy-MM')   = '". $y_m."'");
            $objPHPExcel->getActiveSheet()->setCellValue('A3',$Column[2]);  

            $objPHPExcel->getActiveSheet()->setCellValue('B4','เลขที่สัญญา');  
            $objPHPExcel->getActiveSheet()->setCellValue('C4','ชื่อ-สกุล');  
            $objPHPExcel->getActiveSheet()->setCellValue('D4','เลขคดีดำ');  
            $objPHPExcel->getActiveSheet()->setCellValue('E4','เลขคดีแดง');  
            $objPHPExcel->getActiveSheet()->setCellValue('F4','กำหนดวันฟ้อง');  
            $objPHPExcel->getActiveSheet()->setCellValue('G4','วันที่ฟ้อง');  
            $objPHPExcel->getActiveSheet()->setCellValue('H4','สถานะ'); 

            $objPHPExcel->getActiveSheet()->getStyle('B4:H4')->applyFromArray($default_style);
            foreach ($countlegis as  $value) {
                      $DateFixcourt =  (@$value->orderdatecourt == NULL ? date('Y-m-d', strtotime(' +45 days', strtotime($value->Date_legis))) : @$value->orderdatecourt );
                         $fillingdate_court = @$row->fillingdate_court == NULL ? date('Y-m-d') : @$value->fillingdate_court;
                          $due = @$value->fillingdate_court == NULL ? $DateFixcourt : @$value->fillingdate_court;
                         if($due >= date('Y-m-d')  ) {
                            $DateDue = date_create($due);
                            $NowDate = date_create(date('Y-m-d'));
                            $DateDiff = date_diff($NowDate,$DateDue);
                            if($DateDiff->d <= 7){
                              $Tag = 'Active';
                              $DateShow = "กำหนดการ ".$DateDiff->format("%a วัน");
                            }else{
                              $DateShow = 'รอดำเนินการ';
                            }
                          }else{
                            $DateShow = 'เลยกำหนดการ';
                          }
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),@$value->bnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->rnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),ParsetoDate($DateFixcourt));  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),ParsetoDate(@$value->fillingdate_court));  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1), $DateShow); 
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
                        where a.Flag = 'Y' and a.Status_legis is null and a.Flag_Class = 'สถานะส่งสืบพยาน' and  FORMAT(cast(b.examiday_court as date),'yyyy-MM') = '". $y_m."'  ");
          
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),$Column[3]);  
            
            $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+2),'เลขที่สัญญา');  
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+2),'ชื่อ-สกุล');  
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+2),'เลขคดีดำ');  
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+2),'เลขคดีแดง');  
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+2),'กำหนดวันที่สืบพยาน');  
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+2),'วันที่สืบพยาน');  
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'สถานะ');
            $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':H'.($row+2))->applyFromArray($default_style);
            $sB = 'B'.($row+2);
            $row = $row+2;
            foreach ($countExamine as  $value) {
                    $orderexamiday =  (@$value->orderexamiday == NULL ? date('Y-m-d', strtotime(' +75 days', strtotime($value->Date_legis))) : @$value->orderexamiday );
                    
                    
                        $SetDate = $value->examiday_court==NULL?date('Y-m-d'):$value->examiday_court;
                        
                        $due = $value->examiday_court==NULL?$orderexamiday:$value->examiday_court;
                        if($due >= date('Y-m-d')) {
                        $DateDue = date_create($due);
                        $NowDate = date_create(date('Y-m-d'));
                        $DateDiff = date_diff($NowDate,$DateDue);
                        // $dd = $DateDiff->d ;
                        if($DateDiff->d <= 7){
                            $Tag = 'Active';
                            $DateShow = 'กำหนดการ '.$DateDiff->format("%a วัน");
                        }else{
                            $Tag = NULL;
                            $DateShow = 'รอดำเนินการ';
                        }
                        }else{
                        $Tag = 'Closest';
                        $DateShow = 'เลยกำหนดการ';
                        }
                
        
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),@$value->bnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->rnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),ParsetoDate(@$orderexamiday));  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),ParsetoDate(@$value->examiday_court));  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),$DateShow ); 
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
                        where a.Flag = 'Y' and a.Status_legis is null and a.Flag_Class = 'สถานะส่งคำบังคับ' and  FORMAT(cast(b.ordersend_court as date),'yyyy-MM') = '". $y_m."' ");
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),$Column[4]);  

            $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+2),'เลขที่สัญญา');  
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+2),'ชื่อ-สกุล');  
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+2),'เลขคดีดำ');  
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+2),'เลขคดีแดง');  
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+2),'กำหนดวันส่งคำบังคับ');  
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+2),'วันที่ส่งคำบังคับ');  
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'สถานะ'); 
            $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':H'.($row+2))->applyFromArray($default_style);
            $sB = 'B'.($row+2);
            $row = $row+2;
            foreach ($countOrder as  $value) {
                $orderday_court =  (@$value->orderday_court == NULL ? date('Y-m-d', strtotime(' +120 days', strtotime($value->Date_legis))) : @$value->orderday_court );

                            $SetDate = $value->ordersend_court==NULL?date('Y-m-d'):$value->ordersend_court;
                          $due = $value->ordersend_court==NULL?$orderday_court:$value->ordersend_court;

                          if($due >= date('Y-m-d')) {
                            $DateDue = date_create($due);
                            $NowDate = date_create(date('Y-m-d'));
                            $DateDiff = date_diff($NowDate,$DateDue);
                            if($DateDiff->d <= 7){
                              $Tag = 'Active';
                              $DateShow = 'กำหนดการ '.$DateDiff->format("%a วัน");
                            }else{
                              $Tag = NULL;
                              $DateShow = 'รอดำเนินการ';
                            }
                          }else{
                            $Tag = 'Closest';
                            $DateShow = 'เลยกำหนดการ';
                          }
       
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),@$value->bnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->rnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),ParsetoDate(@$orderday_court));  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),ParsetoDate(@$value->ordersend_court));  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),$DateShow); 
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
                        where a.Flag = 'Y' and a.Status_legis is null and a.Flag_Class = 'สถานะส่งตรวจผลหมาย' and  FORMAT(cast(b.checksend_court  as date),'yyyy-MM') = '". $y_m."' ");
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),$Column[5]);  

            $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+2),'เลขที่สัญญา');  
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+2),'ชื่อ-สกุล');  
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+2),'เลขคดีดำ');  
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+2),'เลขคดีแดง');  
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+2),'กำหนดวันตรวจผลหมาย');  
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+2),'วันที่ตรวจผลหมาย');  
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'สถานะ'); 
            $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':H'.($row+2))->applyFromArray($default_style);
            $sB = 'B'.($row+2);
            $row = $row+2;
            foreach ($countCheckSend as  $value) {
                $checkday_court =  (@$value->checkday_court == NULL ? date('Y-m-d', strtotime(' +165 days', strtotime($value->Date_legis))) : @$value->checkday_court );
                        $SetDate = $value->checksend_court==NULL?date('Y-m-d'):$value->checksend_court;
                          $due = $value->checksend_court==NULL? $checkday_court:$value->checksend_court;
                          if($due >= date('Y-m-d')) {
                            $DateDue = date_create($due);
                            $NowDate = date_create(date('Y-m-d'));
                            $DateDiff = date_diff($NowDate,$DateDue);
                            if($DateDiff->d <= 7){
                              $Tag = 'Active';
                              $DateShow = 'กำหนดการ '.$DateDiff->format("%a วัน");
                            }else{
                              $Tag = NULL;
                              $DateShow = 'รอดำเนินการ';
                            }
                          }else{
                            $Tag = 'Closest';
                            $DateShow = 'เลยกำหนดการ';
                          }
       
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),@$value->bnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->rnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),ParsetoDate(@$checkday_court));  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),ParsetoDate(@$value->checksend_court));  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1), $DateShow ); 
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
                        where a.Flag = 'Y' and a.Status_legis is null and a.Flag_Class = 'สถานะส่งตั้งเจ้าพนักงาน' and  FORMAT(cast(b.sendoffice_court  as date),'yyyy-MM') = '". $y_m."' ");
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),$Column[6]);  

            $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+2),'เลขที่สัญญา');  
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+2),'ชื่อ-สกุล');  
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+2),'เลขคดีดำ');  
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+2),'เลขคดีแดง');  
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+2),'กำหนดวันตั้งเจ้าพนักงาน');  
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+2),'วันที่ตั้งเจ้าพนักงาน');  
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'สถานะ'); 
            $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':H'.($row+2))->applyFromArray($default_style);
            $sB = 'B'.($row+2);
            $row = $row+2;
            foreach ($countSetOffice as  $value) {
                $setoffice_court =  (@$value->setoffice_court == NULL ? date('Y-m-d', strtotime(' +220 days', strtotime($value->Date_legis))) : @$value->setoffice_court );
                    $SetDate = @$value->sendoffice_court==NULL?date('Y-m-d'):@$value->sendoffice_court;
                    $due = @$value->sendoffice_court==NULL?$setoffice_court:@$value->sendoffice_court;
                    if($due >= date('Y-m-d')) {
                    $DateDue = date_create($due);
                    $NowDate = date_create( date('Y-m-d'));
                    $DateDiff = date_diff($NowDate,$DateDue);
                    if($DateDiff->d <= 7){
                        $Tag = 'Active';
                        $DateShow = 'กำหนดการ '.$DateDiff->format("%a วัน");
                    }else{
                        $Tag = NULL;
                        $DateShow = 'รอดำเนินการ';
                    }
                    }else{
                    $Tag = 'Closest';
                    $DateShow = 'เลยกำหนดการ';
                    }
        
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),@$value->bnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->rnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),ParsetoDate(@$setoffice_court));  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),ParsetoDate(@$value->sendoffice_court));  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1), $DateShow); 
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
                        where a.Flag = 'Y' and a.Status_legis is null and a.Flag_Class = 'สถานะส่งตรวจผลหมายตั้ง' and  FORMAT(cast(b.sendcheckresults_court  as date),'yyyy-MM') = '". $y_m."' ");
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),$Column[7]);  

            $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+2),'เลขที่สัญญา');  
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+2),'ชื่อ-สกุล');  
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+2),'เลขคดีดำ');  
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+2),'เลขคดีแดง');  
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+2),'กำหนดวันตรวจผลหมายตั้ง');  
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+2),'วันที่ตรวจผลหมายตั้ง');  
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'สถานะ'); 
            $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':H'.($row+2))->applyFromArray($default_style);
            $sB = 'B'.($row+2);
            $row = $row+2;
            foreach ($countCheckOffice as  $value) {
                $checkresults_court =  (@$value->checkresults_court == NULL ? date('Y-m-d', strtotime(' +265 days', strtotime($value->Date_legis))) : @$value->checkresults_court );
                        $SetDate = $value->sendcheckresults_court==NULL?date('Y-m-d'):$value->sendcheckresults_court;
                         
                          $due = $value->sendcheckresults_court==NULL?$checkresults_court:$value->sendcheckresults_court;
                          if($due >= date('Y-m-d')) {
                            $DateDue = date_create($due);
                            $NowDate = date_create(date('Y-m-d'));
                            $DateDiff = date_diff($NowDate,$DateDue);
                            if($DateDiff->d <= 7){
                              $Tag = 'Active';
                              $DateShow = 'กำหนดการ '.$DateDiff->format("%a วัน");
                            }else{
                              $Tag = NULL;
                              $DateShow = 'รอดำเนินการ';
                            }
                          }else{
                            $Tag = 'Closest';
                            $DateShow = 'เลยกำหนดการ';
                          }

                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),@$value->bnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->rnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),ParsetoDate(@$checkresults_court));  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),ParsetoDate(@$value->sendcheckresults_court));  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1), $DateShow); 
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
                            where a.Flag = 'Y' and a.Status_legis is null and a.Flag_Class = 'สถานะคัดหนังสือรับรองคดี' and  FORMAT(cast(c.dateCertificate_case  as date),'yyyy-MM') = '". $y_m."'  ");

            $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),$Column[8]);  

            $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+2),'เลขที่สัญญา');  
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+2),'ชื่อ-สกุล');  
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+2),'เลขคดีดำ');  
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+2),'เลขคดีแดง');  
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+2),'กำหนดวันคดีถึงที่สุด');  
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+2),'วันที่ได้รับคดีถึงที่สุด');  
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'สถานะ'); 
            $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':H'.($row+2))->applyFromArray($default_style);
            $sB = 'B'.($row+2);
            $row = $row+2;
            foreach ($countCertificate as  $value) {
                $orderDateCer =  (@$value->orderDateCer == NULL ? date('Y-m-d', strtotime(' +310 days', strtotime($value->Date_legis))) : @$value->orderDateCer );

                    $SetDate = @$value->dateCertificate_case == NULL ?  date('Y-m-d') : @$value->dateCertificate_case ;
                    $due = @$value->dateCertificate_case == NULL ?  $orderDateCer: @$value->dateCertificate_case ;
                    if(@$due >= date('Y-m-d')) {
                    $DateDue = date_create(@$due);
                    $NowDate = date_create( date('Y-m-d'));
                    $DateDiff = date_diff($NowDate,$DateDue);
                    if($DateDiff->d <= 7){
                        $Tag = 'Active';
                        $DateShow = 'กำหนดการ '.$DateDiff->format("%a วัน");
                    }else{
                        $Tag = NULL;
                        $DateShow = 'รอดำเนินการ';
                    }
                    }
                    else if(@$row->legiscourtCase->dateCertificate_case == NULL){
                    $Tag = 'Unknow';
                    $DateShow = 'ไม่พบข้อมูล';
                    }
                    else{
                    $Tag = 'Closest';
                    $DateShow = 'เลยกำหนดการ';
                    }
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),@$value->bnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->rnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),ParsetoDate(@$orderDateCer));  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),ParsetoDate(@$value->dateCertificate_case));  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),$DateShow); 
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
                                where a.Flag = 'Y' and a.Status_legis is null  and a.Flag_Class='สถานะสืบทรัพย์บังคับคดี'  and  FORMAT(cast(c.sequester_asset  as date),'yyyy-MM') = '". $y_m."' ");
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),'รายงานสืบทรัพย์');  

            $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+2),'เลขที่สัญญา');  
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+2),'ชื่อ-สกุล');  
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+2),'เลขคดีดำ');  
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+2),'เลขคดีแดง');  
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+2),'วันที่สืบทรัพย์ล่าสุด');  
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+2),'สถานะทรัพย์');  
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'สถานะ'); 
            $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':H'.($row+2))->applyFromArray($default_style);
            $sB = 'B'.($row+2);
            $row = $row+2;
            foreach ($countAsset as  $value) {
                
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),@$value->bnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->rnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),ParsetoDate(@$value->sequester_asset));  
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
          $countPrepare = DB::select(" select a.Date_legis,a.Contract_legis,a.Name_legis,b.bnumber_court,b.rnumber_court,c.id,
            d.sequester_asset,c.orderDatepreparedoc,c.datepreparedoc_case,b.adjudicate_price
           from legislations a
           left join legiscourts b on b.legislation_id = a.id
           left join legiscourtcases c on c.legislation_id = a.id
           left join legisassets d on d.id = (select id from legisassets where sendsequester_asset = 'สืบทรัพย์เจอ' and legislation_id = a.id)
           where a.Flag = 'Y' and a.Status_legis is null and a.Flag_Class = 'สถานะคัดโฉนด'  and  FORMAT(cast(c.datenextsequester_case  as date),'yyyy-MM') = '". $y_m."' ");     
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),'คัดโฉนด/ถ่ายภาพ');  

            $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+2),'เลขที่สัญญา');  
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+2),'ชื่อ-สกุล');  
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+2),'เลขคดีดำ');  
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+2),'เลขคดีแดง');  
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+2),'กำหนดวันคัดโฉนด');  
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+2),'วันที่คัดโฉนด');  
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'สถานะ');
            $objPHPExcel->getActiveSheet()->setCellValue('I'.($row+2),'ศาลสั่งจ่าย');
            $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':H'.($row+2))->applyFromArray($default_style);
            $sB = 'B'.($row+2);
            $row = $row+2;
            foreach ($countPrepare as  $value) {
                $datepreparedoc =  (@$value->orderDatepreparedoc == NULL ? date('Y-m-d', strtotime(' +30 days', strtotime($value->sequester_asset))) : @$value->orderDatepreparedoc );

                $SetDate = @$value->datepreparedoc_case == NULL ?  date('Y-m-d') : @$value->datepreparedoc_case ;
                $due = @$value->datepreparedoc_case == NULL ?  $datepreparedoc: @$value->datepreparedoc_case ;
                if(@$due >= date('Y-m-d')) {
                $DateDue = date_create(@$due);
                $NowDate = date_create( date('Y-m-d'));
                $DateDiff = date_diff($NowDate,$DateDue);
                if($DateDiff->d <= 7){
                    $Tag = 'Active';
                    $DateShow = 'กำหนดการ '.$DateDiff->format("%a วัน");
                }else{
                    $Tag = NULL;
                    $DateShow = 'รอดำเนินการ';
                }
                }
                else{
                $Tag = 'Closest';
                $DateShow = 'เลยกำหนดการ';
                }
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),@$value->bnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->rnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),ParsetoDate(@$datepreparedoc));  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),ParsetoDate(@$value->datepreparedoc_case));  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),$DateShow ); 
                $objPHPExcel->getActiveSheet()->setCellValue('I'.($row+1),@$value->adjudicate_price ); 
                $row++;
            } 
            $objPHPExcel->getActiveSheet()->getStyle( $sB.':I'.($row))->applyFromArray(
                array(
                    
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                );         

            /** ตั้งเรื่องยึดทรัพย์ **/
            $countPrepare = DB::select("  select a.Date_legis,a.Contract_legis,a.Name_legis,b.bnumber_court,b.rnumber_court,c.id,
            d.sequester_asset,c.ordeDateSequester,c.dateSequester_case
           from legislations a
           left join legiscourts b on b.legislation_id = a.id
           left join legiscourtcases c on c.legislation_id = a.id
           left join legisassets d on d.id = (select id from legisassets where sendsequester_asset = 'สืบทรัพย์เจอ' and legislation_id = a.id) 
           where a.Flag = 'Y' and a.Status_legis is null and a.Flag_Class = 'สถานะตั้งยึดทรัพย์' and  FORMAT(cast(c.dateSequester_case  as date),'yyyy-MM') = '". $y_m."'");     
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),'ตั้งเรื่องยึดทรัพย์');  

            $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+2),'เลขที่สัญญา');  
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+2),'ชื่อ-สกุล');  
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+2),'เลขคดีดำ');  
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+2),'เลขคดีแดง');  
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+2),'กำหนดวันยึดทรัพย์');  
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+2),'วันที่ยึดทรัพย์');  
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'สถานะ');
            $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':H'.($row+2))->applyFromArray($default_style);
            $sB = 'B'.($row+2);
            $row = $row+2;
            foreach ($countPrepare as  $value) {
                $dateSequester=  (@$value->ordeDateSequester == NULL ? date('Y-m-d', strtotime(' +45 days', strtotime($value->sequester_asset))) : @$value->ordeDateSequester );

                $SetDate = @$value->dateSequester_case == NULL ?  date('Y-m-d') : @$value->dateSequester_case ;
                $due = @$value->dateSequester_case == NULL ?  $datepreparedoc: @$value->dateSequester_case ;
                if(@$due >= date('Y-m-d')) {
                $DateDue = date_create(@$due);
                $NowDate = date_create( date('Y-m-d'));
                $DateDiff = date_diff($NowDate,$DateDue);
                if($DateDiff->d <= 7){
                    $Tag = 'Active';
                    $DateShow = 'กำหนดการ '.$DateDiff->format("%a วัน");
                }else{
                    $Tag = NULL;
                    $DateShow = 'รอดำเนินการ';
                }
                }
               
                else{
                $Tag = 'Closest';
                $DateShow = 'เลยกำหนดการ';
                }
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),@$value->bnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->rnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),ParsetoDate(@$dateSequester));  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),ParsetoDate(@$value->dateSequester_case));  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),$DateShow ); 
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
        /** ประกาศขายทอดตลาด **/
        $countPrepare = DB::select("  select a.Date_legis,a.Contract_legis,a.Name_legis,b.bnumber_court,b.rnumber_court,c.id,
           c.orderDatePublish,d.Dateset_publish,e.sequester_asset,d.Round_publish,c.amountsequester_case,c.datesoldout_case,c.resultsell_case
           from legislations a
           left join legiscourts b on b.legislation_id = a.id
           left join legiscourtcases c on c.legislation_id = a.id
           left join legis_publishsells d on d.id = (select Top(1) id from legis_publishsells where Flag_publish = 'NOW' and legislation_id = a.id  and  FORMAT(cast(Dateset_publish  as date),'yyyy-MM') = '". $y_m."'  order by id desc)
           left join legisassets e on e.id = (select id from legisassets where sendsequester_asset = 'สืบทรัพย์เจอ' and legislation_id = a.id)
           where a.Flag = 'Y' and a.Status_legis is null and a.Flag_Class = 'ประกาศขายทอดตลาด' and  FORMAT(cast(d.Dateset_publish  as date),'yyyy-MM') = '". $y_m."' ");     
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),'ประกาศขายทอดตลาด');  

            $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+2),'เลขที่สัญญา');  
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+2),'ชื่อ-สกุล');  
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+2),'เลขคดีดำ');  
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+2),'เลขคดีแดง');  
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+2),'กำหนดวันประกาศ');  
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+2),'วันประกาศ');  
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'ครั้งที่');
            $objPHPExcel->getActiveSheet()->setCellValue('I'.($row+2),'ผล');
            $objPHPExcel->getActiveSheet()->setCellValue('J'.($row+2),'วันที่ขาย');
            $objPHPExcel->getActiveSheet()->setCellValue('K'.($row+2),'ยอดขาย');
            $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':K'.($row+2))->applyFromArray($default_style);
            $sB = 'B'.($row+2);
            $row = $row+2;
            foreach ($countPrepare as  $value) {

                $orderDatePublish=  (@$value->orderDatePublish == NULL ? ($value->sequester_asset != NULL?date('Y-m-d', strtotime(' +45 days', strtotime($value->sequester_asset))):'') : @$value->orderDatePublish );

                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),@$value->bnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->rnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),ParsetoDate(@$orderDatePublish));  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),ParsetoDate(@$value->Dateset_publish));  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),@$value->Round_publish ); 
                $objPHPExcel->getActiveSheet()->setCellValue('I'.($row+1),@$value->resultsell_case ); 
                $objPHPExcel->getActiveSheet()->setCellValue('J'.($row+1),@$value->datesoldout_case ); 
                $objPHPExcel->getActiveSheet()->setCellValue('K'.($row+1),@$value->amountsequester_case ); 
                $row++;
            } 
            $objPHPExcel->getActiveSheet()->getStyle( $sB.':K'.($row))->applyFromArray(
                array(
                    
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                );




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
$objPHPExcel->getActiveSheet()->setTitle('การเปลี่ยนสถานะในเดือน');
$objPHPExcel->createSheet();    
$objPHPExcel->setActiveSheetIndex(1);
$objPHPExcel->getActiveSheet()->getStyle('F:G') ->getNumberFormat()
                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY); 

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
            $objPHPExcel->getActiveSheet()->setCellValue('H4','สถานะ'); 

            $objPHPExcel->getActiveSheet()->getStyle('B4:H4')->applyFromArray($default_style);
            foreach ($countlegis as  $value) {
                      $DateFixcourt =  (@$value->orderdatecourt == NULL ? date('Y-m-d', strtotime(' +45 days', strtotime($value->Date_legis))) : @$value->orderdatecourt );
                         $fillingdate_court = @$row->fillingdate_court == NULL ? date('Y-m-d') : @$value->fillingdate_court;
                          $due = @$value->fillingdate_court == NULL ? $DateFixcourt : @$value->fillingdate_court;
                         if($due >= date('Y-m-d')  ) {
                            $DateDue = date_create($due);
                            $NowDate = date_create(date('Y-m-d'));
                            $DateDiff = date_diff($NowDate,$DateDue);
                            if($DateDiff->d <= 7){
                              $Tag = 'Active';
                              $DateShow = "กำหนดการ ".$DateDiff->format("%a วัน");
                            }else{
                              $DateShow = 'รอดำเนินการ';
                            }
                          }else{
                            $DateShow = 'เลยกำหนดการ';
                          }
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),@$value->bnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->rnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),ParsetoDate($DateFixcourt));  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),ParsetoDate(@$value->fillingdate_court));  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1), $DateShow); 
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
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'สถานะ');
            $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':H'.($row+2))->applyFromArray($default_style);
            $sB = 'B'.($row+2);
            $row = $row+2;
            foreach ($countExamine as  $value) {
                    $orderexamiday =  (@$value->orderexamiday == NULL ? date('Y-m-d', strtotime(' +75 days', strtotime($value->Date_legis))) : @$value->orderexamiday );
                    
                    
                        $SetDate = $value->examiday_court==NULL?date('Y-m-d'):$value->examiday_court;
                        
                        $due = $value->examiday_court==NULL?$orderexamiday:$value->examiday_court;
                        if($due >= date('Y-m-d')) {
                        $DateDue = date_create($due);
                        $NowDate = date_create(date('Y-m-d'));
                        $DateDiff = date_diff($NowDate,$DateDue);
                        // $dd = $DateDiff->d ;
                        if($DateDiff->d <= 7){
                            $Tag = 'Active';
                            $DateShow = 'กำหนดการ '.$DateDiff->format("%a วัน");
                        }else{
                            $Tag = NULL;
                            $DateShow = 'รอดำเนินการ';
                        }
                        }else{
                        $Tag = 'Closest';
                        $DateShow = 'เลยกำหนดการ';
                        }
                
        
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),@$value->bnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->rnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),ParsetoDate(@$orderexamiday));  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),ParsetoDate(@$value->examiday_court));  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),$DateShow ); 
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
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'สถานะ'); 
            $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':H'.($row+2))->applyFromArray($default_style);
            $sB = 'B'.($row+2);
            $row = $row+2;
            foreach ($countOrder as  $value) {
                $orderday_court =  (@$value->orderday_court == NULL ? date('Y-m-d', strtotime(' +120 days', strtotime($value->Date_legis))) : @$value->orderday_court );

                            $SetDate = $value->ordersend_court==NULL?date('Y-m-d'):$value->ordersend_court;
                          $due = $value->ordersend_court==NULL?$orderday_court:$value->ordersend_court;

                          if($due >= date('Y-m-d')) {
                            $DateDue = date_create($due);
                            $NowDate = date_create(date('Y-m-d'));
                            $DateDiff = date_diff($NowDate,$DateDue);
                            if($DateDiff->d <= 7){
                              $Tag = 'Active';
                              $DateShow = 'กำหนดการ '.$DateDiff->format("%a วัน");
                            }else{
                              $Tag = NULL;
                              $DateShow = 'รอดำเนินการ';
                            }
                          }else{
                            $Tag = 'Closest';
                            $DateShow = 'เลยกำหนดการ';
                          }
       
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),@$value->bnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->rnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),ParsetoDate(@$orderday_court));  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),ParsetoDate(@$value->ordersend_court));  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),$DateShow); 
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
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'สถานะ'); 
            $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':H'.($row+2))->applyFromArray($default_style);
            $sB = 'B'.($row+2);
            $row = $row+2;
            foreach ($countCheckSend as  $value) {
                $checkday_court =  (@$value->checkday_court == NULL ? date('Y-m-d', strtotime(' +165 days', strtotime($value->Date_legis))) : @$value->checkday_court );
                        $SetDate = $value->checksend_court==NULL?date('Y-m-d'):$value->checksend_court;
                          $due = $value->checksend_court==NULL? $checkday_court:$value->checksend_court;
                          if($due >= date('Y-m-d')) {
                            $DateDue = date_create($due);
                            $NowDate = date_create(date('Y-m-d'));
                            $DateDiff = date_diff($NowDate,$DateDue);
                            if($DateDiff->d <= 7){
                              $Tag = 'Active';
                              $DateShow = 'กำหนดการ '.$DateDiff->format("%a วัน");
                            }else{
                              $Tag = NULL;
                              $DateShow = 'รอดำเนินการ';
                            }
                          }else{
                            $Tag = 'Closest';
                            $DateShow = 'เลยกำหนดการ';
                          }
       
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),@$value->bnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->rnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),ParsetoDate(@$checkday_court));  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),ParsetoDate(@$value->checksend_court));  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1), $DateShow ); 
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
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'สถานะ'); 
            $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':H'.($row+2))->applyFromArray($default_style);
            $sB = 'B'.($row+2);
            $row = $row+2;
            foreach ($countSetOffice as  $value) {
                $setoffice_court =  (@$value->setoffice_court == NULL ? date('Y-m-d', strtotime(' +220 days', strtotime($value->Date_legis))) : @$value->setoffice_court );
                    $SetDate = @$value->sendoffice_court==NULL?date('Y-m-d'):@$value->sendoffice_court;
                    $due = @$value->sendoffice_court==NULL?$setoffice_court:@$value->sendoffice_court;
                    if($due >= date('Y-m-d')) {
                    $DateDue = date_create($due);
                    $NowDate = date_create( date('Y-m-d'));
                    $DateDiff = date_diff($NowDate,$DateDue);
                    if($DateDiff->d <= 7){
                        $Tag = 'Active';
                        $DateShow = 'กำหนดการ '.$DateDiff->format("%a วัน");
                    }else{
                        $Tag = NULL;
                        $DateShow = 'รอดำเนินการ';
                    }
                    }else{
                    $Tag = 'Closest';
                    $DateShow = 'เลยกำหนดการ';
                    }
        
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),@$value->bnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->rnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),ParsetoDate(@$setoffice_court));  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),ParsetoDate(@$value->sendoffice_court));  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1), $DateShow); 
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
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'สถานะ'); 
            $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':H'.($row+2))->applyFromArray($default_style);
            $sB = 'B'.($row+2);
            $row = $row+2;
            foreach ($countCheckOffice as  $value) {
                $checkresults_court =  (@$value->checkresults_court == NULL ? date('Y-m-d', strtotime(' +265 days', strtotime($value->Date_legis))) : @$value->checkresults_court );
                        $SetDate = $value->sendcheckresults_court==NULL?date('Y-m-d'):$value->sendcheckresults_court;
                         
                          $due = $value->sendcheckresults_court==NULL?$checkresults_court:$value->sendcheckresults_court;
                          if($due >= date('Y-m-d')) {
                            $DateDue = date_create($due);
                            $NowDate = date_create(date('Y-m-d'));
                            $DateDiff = date_diff($NowDate,$DateDue);
                            if($DateDiff->d <= 7){
                              $Tag = 'Active';
                              $DateShow = 'กำหนดการ '.$DateDiff->format("%a วัน");
                            }else{
                              $Tag = NULL;
                              $DateShow = 'รอดำเนินการ';
                            }
                          }else{
                            $Tag = 'Closest';
                            $DateShow = 'เลยกำหนดการ';
                          }

                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),@$value->bnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->rnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),ParsetoDate(@$checkresults_court));  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),ParsetoDate(@$value->sendcheckresults_court));  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1), $DateShow); 
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
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'สถานะ'); 
            $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':H'.($row+2))->applyFromArray($default_style);
            $sB = 'B'.($row+2);
            $row = $row+2;
            foreach ($countCertificate as  $value) {
                $orderDateCer =  (@$value->orderDateCer == NULL ? date('Y-m-d', strtotime(' +310 days', strtotime($value->Date_legis))) : @$value->orderDateCer );

                    $SetDate = @$value->dateCertificate_case == NULL ?  date('Y-m-d') : @$value->dateCertificate_case ;
                    $due = @$value->dateCertificate_case == NULL ?  $orderDateCer: @$value->dateCertificate_case ;
                    if(@$due >= date('Y-m-d')) {
                    $DateDue = date_create(@$due);
                    $NowDate = date_create( date('Y-m-d'));
                    $DateDiff = date_diff($NowDate,$DateDue);
                    if($DateDiff->d <= 7){
                        $Tag = 'Active';
                        $DateShow = 'กำหนดการ '.$DateDiff->format("%a วัน");
                    }else{
                        $Tag = NULL;
                        $DateShow = 'รอดำเนินการ';
                    }
                    }
                    else if(@$row->legiscourtCase->dateCertificate_case == NULL){
                    $Tag = 'Unknow';
                    $DateShow = 'ไม่พบข้อมูล';
                    }
                    else{
                    $Tag = 'Closest';
                    $DateShow = 'เลยกำหนดการ';
                    }
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),@$value->bnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->rnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),ParsetoDate(@$orderDateCer));  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),ParsetoDate(@$value->dateCertificate_case));  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),$DateShow); 
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
                                where a.Flag = 'Y' and a.Status_legis is null  and a.Flag_Class='สถานะสืบทรัพย์บังคับคดี'");
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),'รายงานสืบทรัพย์');  

            $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+2),'เลขที่สัญญา');  
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+2),'ชื่อ-สกุล');  
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+2),'เลขคดีดำ');  
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+2),'เลขคดีแดง');  
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+2),'วันที่สืบทรัพย์ล่าสุด');  
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+2),'สถานะทรัพย์');  
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'สถานะ'); 
            $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':H'.($row+2))->applyFromArray($default_style);
            $sB = 'B'.($row+2);
            $row = $row+2;
            foreach ($countAsset as  $value) {
                
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),@$value->bnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->rnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),ParsetoDate(@$value->sequester_asset));  
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
          $countPrepare = DB::select(" select a.Date_legis,a.Contract_legis,a.Name_legis,b.bnumber_court,b.rnumber_court,c.id,
            d.sequester_asset,c.orderDatepreparedoc,c.datepreparedoc_case,b.adjudicate_price
           from legislations a
           left join legiscourts b on b.legislation_id = a.id
           left join legiscourtcases c on c.legislation_id = a.id
           left join legisassets d on d.id = (select id from legisassets where sendsequester_asset = 'สืบทรัพย์เจอ' and legislation_id = a.id)
           where a.Flag = 'Y' and a.Status_legis is null and a.Flag_Class = 'สถานะคัดโฉนด'");     
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),'คัดโฉนด/ถ่ายภาพ');  

            $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+2),'เลขที่สัญญา');  
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+2),'ชื่อ-สกุล');  
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+2),'เลขคดีดำ');  
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+2),'เลขคดีแดง');  
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+2),'กำหนดวันคัดโฉนด');  
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+2),'วันที่คัดโฉนด');  
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'สถานะ');
            $objPHPExcel->getActiveSheet()->setCellValue('I'.($row+2),'ศาลสั่งจ่าย');
            $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':H'.($row+2))->applyFromArray($default_style);
            $sB = 'B'.($row+2);
            $row = $row+2;
            foreach ($countPrepare as  $value) {
                $datepreparedoc =  (@$value->orderDatepreparedoc == NULL ? date('Y-m-d', strtotime(' +30 days', strtotime($value->sequester_asset))) : @$value->orderDatepreparedoc );

                $SetDate = @$value->datepreparedoc_case == NULL ?  date('Y-m-d') : @$value->datepreparedoc_case ;
                $due = @$value->datepreparedoc_case == NULL ?  $datepreparedoc: @$value->datepreparedoc_case ;
                if(@$due >= date('Y-m-d')) {
                $DateDue = date_create(@$due);
                $NowDate = date_create( date('Y-m-d'));
                $DateDiff = date_diff($NowDate,$DateDue);
                if($DateDiff->d <= 7){
                    $Tag = 'Active';
                    $DateShow = 'กำหนดการ '.$DateDiff->format("%a วัน");
                }else{
                    $Tag = NULL;
                    $DateShow = 'รอดำเนินการ';
                }
                }
                else{
                $Tag = 'Closest';
                $DateShow = 'เลยกำหนดการ';
                }
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),@$value->bnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->rnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),ParsetoDate(@$datepreparedoc));  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),ParsetoDate(@$value->datepreparedoc_case));  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),$DateShow ); 
                $objPHPExcel->getActiveSheet()->setCellValue('I'.($row+1),@$value->adjudicate_price ); 
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

            /** ตั้งเรื่องยึดทรัพย์ **/
            $countPrepare = DB::select("  select a.Date_legis,a.Contract_legis,a.Name_legis,b.bnumber_court,b.rnumber_court,c.id,
            d.sequester_asset,c.ordeDateSequester,c.dateSequester_case
           from legislations a
           left join legiscourts b on b.legislation_id = a.id
           left join legiscourtcases c on c.legislation_id = a.id
           left join legisassets d on d.id = (select id from legisassets where sendsequester_asset = 'สืบทรัพย์เจอ' and legislation_id = a.id) 
           where a.Flag = 'Y' and a.Status_legis is null and a.Flag_Class = 'สถานะตั้งยึดทรัพย์'");     
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),'ตั้งเรื่องยึดทรัพย์');  

            $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+2),'เลขที่สัญญา');  
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+2),'ชื่อ-สกุล');  
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+2),'เลขคดีดำ');  
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+2),'เลขคดีแดง');  
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+2),'กำหนดวันยึดทรัพย์');  
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+2),'วันที่ยึดทรัพย์');  
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'สถานะ');
            $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':H'.($row+2))->applyFromArray($default_style);
            $sB = 'B'.($row+2);
            $row = $row+2;
            foreach ($countPrepare as  $value) {
                $dateSequester=  (@$value->ordeDateSequester == NULL ? date('Y-m-d', strtotime(' +45 days', strtotime($value->sequester_asset))) : @$value->ordeDateSequester );

                $SetDate = @$value->dateSequester_case == NULL ?  date('Y-m-d') : @$value->dateSequester_case ;
                $due = @$value->dateSequester_case == NULL ?  $datepreparedoc: @$value->dateSequester_case ;
                if(@$due >= date('Y-m-d')) {
                $DateDue = date_create(@$due);
                $NowDate = date_create( date('Y-m-d'));
                $DateDiff = date_diff($NowDate,$DateDue);
                if($DateDiff->d <= 7){
                    $Tag = 'Active';
                    $DateShow = 'กำหนดการ '.$DateDiff->format("%a วัน");
                }else{
                    $Tag = NULL;
                    $DateShow = 'รอดำเนินการ';
                }
                }
               
                else{
                $Tag = 'Closest';
                $DateShow = 'เลยกำหนดการ';
                }
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),@$value->bnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->rnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),ParsetoDate(@$dateSequester));  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),ParsetoDate(@$value->dateSequester_case));  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),$DateShow ); 
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
        /** ประกาศขายทอดตลาด **/
        $countPrepare = DB::select("  select a.Date_legis,a.Contract_legis,a.Name_legis,b.bnumber_court,b.rnumber_court,c.id,
           c.orderDatePublish,d.Dateset_publish,e.sequester_asset,d.Round_publish,c.amountsequester_case,c.datesoldout_case,c.resultsell_case
           from legislations a
           left join legiscourts b on b.legislation_id = a.id
           left join legiscourtcases c on c.legislation_id = a.id
           left join legis_publishsells d on d.id = (select Top(1) id from legis_publishsells where Flag_publish = 'NOW' and legislation_id = a.id order by id)
           left join legisassets e on e.id = (select id from legisassets where sendsequester_asset = 'สืบทรัพย์เจอ' and legislation_id = a.id)
           where a.Flag = 'Y' and a.Status_legis is null and a.Flag_Class = 'ประกาศขายทอดตลาด'");     
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),'ประกาศขายทอดตลาด');  

            $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+2),'เลขที่สัญญา');  
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+2),'ชื่อ-สกุล');  
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+2),'เลขคดีดำ');  
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+2),'เลขคดีแดง');  
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+2),'กำหนดวันประกาศ');  
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+2),'วันประกาศ');  
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'ครั้งที่');
            $objPHPExcel->getActiveSheet()->setCellValue('I'.($row+2),'ผล');
            $objPHPExcel->getActiveSheet()->setCellValue('J'.($row+2),'วันที่ขาย');
            $objPHPExcel->getActiveSheet()->setCellValue('K'.($row+2),'ยอดขาย');
            $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':K'.($row+2))->applyFromArray($default_style);
            $sB = 'B'.($row+2);
            $row = $row+2;
            foreach ($countPrepare as  $value) {

                $orderDatePublish=  (@$value->orderDatePublish == NULL ? ($value->sequester_asset != NULL?date('Y-m-d', strtotime(' +45 days', strtotime($value->sequester_asset))):'') : @$value->orderDatePublish );

                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),@$value->bnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->rnumber_court);  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),ParsetoDate(@$orderDatePublish));  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),ParsetoDate(@$value->Dateset_publish));  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),@$value->Round_publish ); 
                $objPHPExcel->getActiveSheet()->setCellValue('I'.($row+1),@$value->resultsell_case ); 
                $objPHPExcel->getActiveSheet()->setCellValue('J'.($row+1),@$value->datesoldout_case ); 
                $objPHPExcel->getActiveSheet()->setCellValue('K'.($row+1),@$value->amountsequester_case ); 
                $row++;
            } 
            $objPHPExcel->getActiveSheet()->getStyle( $sB.':K'.($row))->applyFromArray(
                array(
                    
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                );




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
$objPHPExcel->getActiveSheet()->setTitle('สถานะลูกหนี้ฟ้อง');

$objPHPExcel->createSheet();    
$objPHPExcel->setActiveSheetIndex(2);
$row = 4;
$c1 = 2;
$m=0;
$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
$objPHPExcel->getActiveSheet()->setCellValue('A1',"รายงานลูกหนี้ประนอมหนี้");  

$objPHPExcel->getActiveSheet()->getStyle('F') ->getNumberFormat()
                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
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
// $dataNormal = DB::select("select *,DATEDIFF(month,  DateDue_Payment ,CONVERT (Date, GETDATE())) as monthdiff
//                                 ,Type_Promise,Sum_FirstPromise,Sum_DuePayPromise,Total_Promise
//                                 from legislations a
//                                 left join legispayments b on b.legislation_id = a.id
//                                 left join legiscompromises c on c.legislation_id = a.id
//                                 where a.Status_legis is null and b.Flag_Payment = 'Y' and Flag_Promise = 'Active'");
    $dataNormal = \App\Legislation::where('Status_legis', NULL)->where('Flag_status',3)
  
            ->with(['legispayments' => function ($query) {
              return $query->where('Flag_Payment', 'Y')->selectRaw('*,DATEDIFF(day,  DateDue_Payment ,CONVERT (Date, GETDATE()))/30 as monthdiff ,DATEDIFF(day,  Date_Payment ,CONVERT (Date, GETDATE()))/30 as NONPAY');
            }])
           ->Wherehas('legisCompromise')
            ->with('legisTrackings')
            ->get();
          

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
        
                $d1 = date_create(@$dataNormal[$j]->legispayments->DateDue_Payment  );
                $d2 = date_create(date('Y-m-d'));
               
                $interval = date_diff($d1,$d2);
              
                $numMonth = $interval->format('%m');
                $numYear = $interval->format('%y');
                
             // $numDue = @$dataNormal[$j]->legispayments->monthdiff;
             $numDue = @$dataNormal[$j]->legisCompromise->HLDNO;
              if ($dataNormal[$j]->legispayments != NULL) {   
                  
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

            $objPHPExcel->getActiveSheet()->setCellValue('A4','เลขที่สัญญา');  
            $objPHPExcel->getActiveSheet()->setCellValue('B4','ประเภทลูกหนี้');  
            $objPHPExcel->getActiveSheet()->setCellValue('C4','ชื่อ-สกุล');  
            $objPHPExcel->getActiveSheet()->setCellValue('D4','สถานะประนอม');  
            $objPHPExcel->getActiveSheet()->setCellValue('E4','ประเภทการประนอม'); 
            $objPHPExcel->getActiveSheet()->setCellValue('F4','LPAYD'); 
            $objPHPExcel->getActiveSheet()->setCellValue('G4','ยอดค้าง'); 
            $objPHPExcel->getActiveSheet()->setCellValue('H4','ยอดดิว');  
            $objPHPExcel->getActiveSheet()->setCellValue('I4','ยอดที่ชำระ');  
            $objPHPExcel->getActiveSheet()->setCellValue('J4','NON');  
            $objPHPExcel->getActiveSheet()->setCellValue('K4','ยอดจ่ายมาแล้ว');  
            $objPHPExcel->getActiveSheet()->setCellValue('L4','ยอดคงเหลือ'); 
            $objPHPExcel->getActiveSheet()->getStyle('B4:L4')->applyFromArray($default_style);
            foreach ($data1 as  $value) { 
                // if ($value->legispayments != NULL){
                //     if ($value->legispayments->DateDue_Payment < date('Y-m-d')) {
                //     $DateDue = date_create($value->legispayments->DateDue_Payment);
                //     $Date = date_create(date('Y-m-d'));
                //     $Datediff = date_diff($DateDue,$Date);
                    
                //     if($Datediff->y != NULL) {
                //         $SetYear = ($Datediff->y * 12);
                //     }else{
                //         $SetYear = 0;
                //     }
                //     $DueCus = ($SetYear + $Datediff->m);
                //     }
                //     else{
                //     $DueCus = 0;
                //     }
                // }
                // else{
                //     $DueCus = 0;
                // }     
                //non
                $non = "0 days";
                 if ($value->legispayments != NULL){
                 
                    $DateDue = date_create($value->legispayments->Date_Payment);
                    $Date = date_create(date('Y-m-d'));
                    $Datediff = date_diff($DateDue,$Date);
                    
                    $non = $Datediff->format("%a days");
                   
                }
                $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),@$value->Contract_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),'ลูกหนี้ปกติ');  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),$Flag[@$value->Flag]);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->legisCompromise->Type_Promise); 
             
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),ParsetoDate(@$value->legispayments->Date_Payment));  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),0 );  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),@$value->legisCompromise->Due_1);  
                $objPHPExcel->getActiveSheet()->setCellValue('I'.($row+1),@$value->legispayments->Gold_Payment);  
                    //@$value->legispayments->NONPAY
                $objPHPExcel->getActiveSheet()->setCellValue('J'.($row+1),$non);  
                $sumpay = floatval(@$value->legisCompromise->Sum_FirstPromise) + floatval(@$value->legisCompromise->Sum_DuePayPromise);
                $objPHPExcel->getActiveSheet()->setCellValue('K'.($row+1), ($sumpay));  
                $objPHPExcel->getActiveSheet()->setCellValue('L'.($row+1),( floatval((@$value->legisCompromise->Total_Promise)-$sumpay))); 
                $row++;
            } 
            // $objPHPExcel->getActiveSheet()->getStyle( 'B4:L'.($row))->applyFromArray(
            //     array(
                    
            //         'borders' => array(
            //             'allborders' => array(
            //                 'style' => PHPExcel_Style_Border::BORDER_THIN
            //                 )
            //             )
            //         )
            //     );   
            // $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),'ลูกหนี้ค้าง 1 งวด');  

            // $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+2),'เลขที่สัญญา');  
            // $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+2),'ชื่อ-สกุล');  
            // $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+2),'สถานะประนอม');  
            // $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+2),'ประเภทการประนอม');  
            // $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+2),'LPAYD'); 
            // $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+2),'ยอดค้าง'); 
            // $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'ยอดดิว'); 
            // $objPHPExcel->getActiveSheet()->setCellValue('I'.($row+2),'ยอดที่ชำระ');  
            // $objPHPExcel->getActiveSheet()->setCellValue('J'.($row+2),'NON');  
            // $objPHPExcel->getActiveSheet()->setCellValue('K'.($row+2),'ยอดจ่ายมาแล้ว');  
            // $objPHPExcel->getActiveSheet()->setCellValue('L'.($row+2),'ยอดคงเหลือ'); 
            // $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':L'.($row+2))->applyFromArray($default_style);
            // $sB = 'B'.($row+2);
            // $row = $row+1;
            foreach ($data1_1 as  $value) {
                $non = "0 days";
            
                    if ($value->legispayments != NULL){
                    
                        $DateDue = date_create($value->legispayments->Date_Payment);
                        $Date = date_create(date('Y-m-d'));
                        $Datediff = date_diff($DateDue,$Date);
                        
                        $non = $Datediff->format("%a days");
                    
                    }
                
                $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),@$value->Contract_legis);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),'ลูกหนี้ค้าง 1 งวด');  
                $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),$Flag[@$value->Flag]);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->legisCompromise->Type_Promise);  
                if(@$value->TypeCon_legis=='P01'){
                    $kangSum = (@$value->legisCompromise->DuePay_Promise*@$value->legispayments->monthdiff );
                    }else{
                    $kangSum = (@$value->legisCompromise->Due_1*@$value->legispayments->monthdiff );
                    }
                $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),ParsetoDate(@$value->legispayments->Date_Payment));  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),@$value->legisCompromise->EXP_AMT );  
                $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),@$value->legisCompromise->Due_1);  
                $objPHPExcel->getActiveSheet()->setCellValue('I'.($row+1),@$value->legispayments->Gold_Payment);  

                $objPHPExcel->getActiveSheet()->setCellValue('J'.($row+1),$non);  
                $sumpay = floatval(@$value->legisCompromise->Sum_FirstPromise) + floatval(@$value->legisCompromise->Sum_DuePayPromise);
                $objPHPExcel->getActiveSheet()->setCellValue('K'.($row+1), ($sumpay));  
                $objPHPExcel->getActiveSheet()->setCellValue('L'.($row+1),( floatval((@$value->legisCompromise->Total_Promise)-$sumpay))); 
                $row++;
            } 
            // $objPHPExcel->getActiveSheet()->getStyle( $sB.':L'.($row))->applyFromArray(
            //     array(
                    
            //         'borders' => array(
            //             'allborders' => array(
            //                 'style' => PHPExcel_Style_Border::BORDER_THIN
            //                 )
            //             )
            //         )
            //     );   
            //     $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),'ลูกหนี้ค้าง 2 งวด');  

            //     $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+2),'เลขที่สัญญา');  
            //     $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+2),'ชื่อ-สกุล');  
            //     $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+2),'สถานะประนอม');  
            //     $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+2),'ประเภทการประนอม');  
            //     $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+2),'LPAYD'); 
            //     $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+2),'ยอดค้าง'); 
            //     $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'ยอดดิว'); 
            //     $objPHPExcel->getActiveSheet()->setCellValue('I'.($row+2),'ยอดที่ชำระ');  
            //     $objPHPExcel->getActiveSheet()->setCellValue('J'.($row+2),'NON');  
            //     $objPHPExcel->getActiveSheet()->setCellValue('K'.($row+2),'ยอดจ่ายมาแล้ว');  
            //     $objPHPExcel->getActiveSheet()->setCellValue('L'.($row+2),'ยอดคงเหลือ'); 
            //     $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':L'.($row+2))->applyFromArray($default_style);
            //     $sB = 'B'.($row+2);
                // $row = $row+1;
                foreach ($data1_2 as  $value) {
                    $non = "0 days";
                    if ($value->legispayments != NULL){
                    
                        $DateDue = date_create($value->legispayments->Date_Payment);
                        $Date = date_create(date('Y-m-d'));
                        $Datediff = date_diff($DateDue,$Date);
                        
                        $non = $Datediff->format("%a days");
                    
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),@$value->Contract_legis);  

                    $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),'ลูกหนี้ค้าง 2 งวด');  
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),$Flag[@$value->Flag]);  
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->legisCompromise->Type_Promise);  
                    // if(@$value->TypeCon_legis=='P01'){
                    // $kangSum = (@$value->legisCompromise->DuePay_Promise*@$value->legispayments->monthdiff );
                    // }else{
                    // $kangSum = (@$value->legisCompromise->Due_1*@$value->legispayments->monthdiff );
                    // }
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),ParsetoDate(@$value->legispayments->Date_Payment));  
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),@$value->legisCompromise->EXP_AMT );  
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),@$value->legisCompromise->Due_1);  
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.($row+1),@$value->legispayments->Gold_Payment);  

                    $objPHPExcel->getActiveSheet()->setCellValue('J'.($row+1),$non);  
                    $sumpay = floatval(@$value->legisCompromise->Sum_FirstPromise) + floatval(@$value->legisCompromise->Sum_DuePayPromise);
                    $objPHPExcel->getActiveSheet()->setCellValue('K'.($row+1), ($sumpay));  
                    $objPHPExcel->getActiveSheet()->setCellValue('L'.($row+1),( floatval((@$value->legisCompromise->Total_Promise)-$sumpay))); 
                    $row++;
                } 
                // $objPHPExcel->getActiveSheet()->getStyle( $sB.':L'.($row))->applyFromArray(
                //     array(
                        
                //         'borders' => array(
                //             'allborders' => array(
                //                 'style' => PHPExcel_Style_Border::BORDER_THIN
                //                 )
                //             )
                //         )
                //     );   
                // $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),'ลูกหนี้ค้าง 3 งวด');  

                // $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+2),'เลขที่สัญญา');  
                // $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+2),'ชื่อ-สกุล');  
                // $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+2),'สถานะประนอม');  
                // $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+2),'ประเภทการประนอม');  
                // $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+2),'LPAYD'); 
                // $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+2),'ยอดค้าง'); 
                // $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'ยอดดิว'); 
                // $objPHPExcel->getActiveSheet()->setCellValue('I'.($row+2),'ยอดที่ชำระ');  
                // $objPHPExcel->getActiveSheet()->setCellValue('J'.($row+2),'NON');  
                // $objPHPExcel->getActiveSheet()->setCellValue('K'.($row+2),'ยอดจ่ายมาแล้ว');  
                // $objPHPExcel->getActiveSheet()->setCellValue('L'.($row+2),'ยอดคงเหลือ'); 
                // $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':L'.($row+2))->applyFromArray($default_style);
                // $sB = 'B'.($row+2);
                // $row = $row+1;
                foreach ($data1_3 as  $value) {
                    $non = "0 days";
                    if ($value->legispayments != NULL){
                    
                        $DateDue = date_create($value->legispayments->Date_Payment);
                        $Date = date_create(date('Y-m-d'));
                        $Datediff = date_diff($DateDue,$Date);
                        
                        $non = $Datediff->format("%a days");
                    
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),@$value->Contract_legis);  
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),'ลูกหนี้ค้าง 3 งวด');  
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),$Flag[@$value->Flag]);  
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->legisCompromise->Type_Promise);  
                    // if(@$value->TypeCon_legis=='P01'){
                    // $kangSum = (@$value->legisCompromise->DuePay_Promise*@$value->legispayments->monthdiff );
                    // }else{
                    // $kangSum = (@$value->legisCompromise->Due_1*@$value->legispayments->monthdiff );
                    // }
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),ParsetoDate(@$value->legispayments->Date_Payment));  
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),@$value->legisCompromise->EXP_AMT );  
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),@$value->legisCompromise->Due_1);  
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.($row+1),@$value->legispayments->Gold_Payment);  

                    $objPHPExcel->getActiveSheet()->setCellValue('J'.($row+1),@$non);  
                    $sumpay = floatval(@$value->legisCompromise->Sum_FirstPromise) + floatval(@$value->legisCompromise->Sum_DuePayPromise);
                    $objPHPExcel->getActiveSheet()->setCellValue('K'.($row+1), ($sumpay));  
                    $objPHPExcel->getActiveSheet()->setCellValue('L'.($row+1),( floatval((@$value->legisCompromise->Total_Promise)-$sumpay))); 
                    $row++;
                } 
                // $objPHPExcel->getActiveSheet()->getStyle( $sB.':L'.($row))->applyFromArray(
                //     array(
                        
                //         'borders' => array(
                //             'allborders' => array(
                //                 'style' => PHPExcel_Style_Border::BORDER_THIN
                //                 )
                //             )
                //         )
                //     );   
                // $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),'ลูกหนี้ค้าง 3 งวดขึ้นไป');  

                // $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+2),'เลขที่สัญญา');  
                // $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+2),'ชื่อ-สกุล');  
                // $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+2),'สถานะประนอม');  
                // $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+2),'ประเภทการประนอม');  
                // $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+2),'LPAYD'); 
                // $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+2),'ยอดค้าง'); 
                // $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'ยอดดิว'); 
                // $objPHPExcel->getActiveSheet()->setCellValue('I'.($row+2),'ยอดที่ชำระ');  
                // $objPHPExcel->getActiveSheet()->setCellValue('J'.($row+2),'NON');  
                // $objPHPExcel->getActiveSheet()->setCellValue('K'.($row+2),'ยอดจ่ายมาแล้ว');  
                // $objPHPExcel->getActiveSheet()->setCellValue('L'.($row+2),'ยอดคงเหลือ');  
                // $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':L'.($row+2))->applyFromArray($default_style);
                // $sB = 'B'.($row+2);
                // $row = $row+1;
                foreach ($data1_4 as  $value) {
                    $non = "0 days";
                    if ($value->legispayments != NULL){
                    
                        $DateDue = date_create($value->legispayments->Date_Payment);
                        $Date = date_create(date('Y-m-d'));
                        $Datediff = date_diff($DateDue,$Date);
                        
                        $non = $Datediff->format("%a days");
                    
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),@$value->Contract_legis);  
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),'ลูกหนี้ค้าง 3 งวดขึ้นไป');  
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),$Flag[@$value->Flag]);  
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->legisCompromise->Type_Promise);  
                    // if(@$value->TypeCon_legis=='P01'){
                    // $kangSum = (@$value->legisCompromise->DuePay_Promise*@$value->legispayments->monthdiff );
                    // }else{
                    // $kangSum = (@$value->legisCompromise->Due_1*@$value->legispayments->monthdiff );
                    // }
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),ParsetoDate(@$value->legispayments->Date_Payment));  
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),@$value->legisCompromise->EXP_AMT);  
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),@$value->legisCompromise->Due_1);  
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.($row+1),@$value->legispayments->Gold_Payment);  
                    
                    
                    $objPHPExcel->getActiveSheet()->setCellValue('J'.($row+1),@$non);  
                    $sumpay = floatval(@$value->legisCompromise->Sum_FirstPromise) + floatval(@$value->legisCompromise->Sum_DuePayPromise);
                    $objPHPExcel->getActiveSheet()->setCellValue('K'.($row+1), ($sumpay));  
                    $objPHPExcel->getActiveSheet()->setCellValue('L'.($row+1),( floatval((@$value->legisCompromise->Total_Promise)-$sumpay))); 
                    $row++;
                } 
                $objPHPExcel->getActiveSheet()->getStyle('B4:L'.($row))->applyFromArray(
                    array(
                        
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                                )
                            )
                        )
                    );   
                      

                    $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+2),'เลขที่สัญญา'); 
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),'สถานะลูกหนี้'); 
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+2),'ชื่อ-สกุล');  
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+2),'สถานะประนอม');  
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+2),'ประเภทการประนอม'); 
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+2),'วันที่นัดจ่ายเงินก้อนแรก');   
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+2),'เงินก้อนแรก'); 
                   
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+2),'ยอดจ่ายเงินก้นแรก'); 
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.($row+2),'ยอดดิว'); 
                    // $objPHPExcel->getActiveSheet()->setCellValue('I'.($row+2),'ยอดที่ชำระ');  
                    $objPHPExcel->getActiveSheet()->setCellValue('J'.($row+2),'NON');  
                    $objPHPExcel->getActiveSheet()->setCellValue('K'.($row+2),'ยอดจ่ายมาแล้ว');  
                    $objPHPExcel->getActiveSheet()->setCellValue('L'.($row+2),'ยอดคงเหลือ');  
                    $objPHPExcel->getActiveSheet()->getStyle('B'.($row+2).':L'.($row+2))->applyFromArray($default_style);
                    $sB = 'B'.($row+2);
                    $row = $row+2;
                    foreach ($NullData as  $value) {
                     // if(@$value->legisCompromise!=NULL){

                      
                        $non = "0 days";

                        $lastday = @$value->legispayments->Date_Payment!=NULL?@$value->legispayments->Date_Payment:@$value->legisCompromise->Date_Promise;
                                             
                            $DateDue = date_create($lastday);
                            $Date = date_create(date('Y-m-d'));
                            $Datediff = date_diff($DateDue,$Date);
                            
                            $non = $Datediff->format("%a days");
                        
                    
                        
                        $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1),@$value->Contract_legis);  
                        $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),'ลูกหนี้ประนอมไม่มีการชำระ');  
                        $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$value->Name_legis);  
                        $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),$Flag[@$value->Flag]);  
                        $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),@$value->legisCompromise->Type_Promise);  
                        // if(@$value->TypeCon_legis=='P01'){
                        // $kangSum = (@$value->legisCompromise->DuePay_Promise*@$value->legispayments->monthdiff );
                        // }else{
                        // $kangSum = (@$value->legisCompromise->Due_1*@$value->legispayments->monthdiff );
                        // }
                        $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),ParsetoDate(@$value->legisCompromise->fdate_first));
                        $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),@$value->legisCompromise->FirstManey_1);  
                          
                        $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),@$value->legisCompromise->Sum_FirstPromise);  
                        $objPHPExcel->getActiveSheet()->setCellValue('I'.($row+1),@$value->legisCompromise->Due_1);  
                    
                        $objPHPExcel->getActiveSheet()->setCellValue('J'.($row+1),@$non);  
                        $sumpay = floatval(@$value->legisCompromise->Sum_FirstPromise) + floatval(@$value->legisCompromise->Sum_DuePayPromise);
                        $objPHPExcel->getActiveSheet()->setCellValue('K'.($row+1), ($sumpay));  
                        $objPHPExcel->getActiveSheet()->setCellValue('L'.($row+1),( floatval((@$value->legisCompromise->Total_Promise)-$sumpay))); 
                        $row++;
                     // }
                    } 
                    $objPHPExcel->getActiveSheet()->getStyle( $sB.':L'.($row))->applyFromArray(
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
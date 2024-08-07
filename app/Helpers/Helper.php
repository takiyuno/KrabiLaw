<?php // Code within app\Helpers\Helper.php

    function formatDateThai($strDate) {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("d",strtotime($strDate));
        $strHour= date("H",strtotime($strDate));
        $strMinute= date("i",strtotime($strDate));
        $strSeconds= date("s",strtotime($strDate));
        //$strMonthCut = Array("" , "มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฟษภาคม","มิถุนายน","กรกฏาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        // $strMonthCut = Array("","01","02","03","04","05","06","07","08","09","10","11","12");
        $strMonthThai=$strMonthCut[$strMonth];

        return $strDay." ".$strMonthThai." ".$strYear;
    }

    function formatDateThaiShort($strDate) {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("d",strtotime($strDate));
        $strHour= date("H",strtotime($strDate));
        $strMinute= date("i",strtotime($strDate));
        $strSeconds= date("s",strtotime($strDate));
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];

        return $strDay." ".$strMonthThai." ".substr($strYear,2,3);
    }

    function formatDateThaiLong($strDate) {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("d",strtotime($strDate));
        $strHour= date("H",strtotime($strDate));
        $strMinute= date("i",strtotime($strDate));
        $strSeconds= date("s",strtotime($strDate));
        $strMonthCut = Array("" , "มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฏาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
        $strMonthThai=$strMonthCut[$strMonth];

        return $strDay." ".$strMonthThai." ".$strYear;
    }

    function num2thai($thb) {
        list($thb, $ths) = explode('.', $thb);
        $ths = substr($ths.'00', 0, 0);
        $thaiNum = array('','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า');
        $unitBaht = array('บาทถ้วน','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน');
        $unitSatang = array('สตางค์','สิบ');
        $THB = '';
        $j = 0;
        for($i=strlen($thb)-1; $i>=0; $i--,$j++) {
            $num = $thb[$i];
            $tnum = $thaiNum[$num];
            $unit = $unitBaht[$j];
            switch(true) {
                case $j==0 && $num==1 && strlen($thb)>1: $tnum = 'เอ็ด'; break;
                case $j==1 && $num==1: $tnum = ''; break;
                case $j==1 && $num==2: $tnum = 'ยี่'; break;
                case $j==6 && $num==1 && strlen($thb)>7: $tnum = 'เอ็ด'; break;
                case $j==7 && $num==1: $tnum = ''; break;
                case $j==7 && $num==2: $tnum = 'ยี่'; break;
                case $j!=0 && $j!=6 && $num==0: $unit = ''; break;
            }
            $S = $tnum . $unit;
            $THB = $S . $THB;
        }
        if($ths=='00') {
            $THS = 'ถ้วน';
        } 
        else {
            $j=0;
            $THS = '';
            for($i=strlen($ths)-1; $i>=0; $i--,$j++) {
                $num = $ths[$i];
                $tnum = $thaiNum[$num];
                $unit = $unitSatang[$j];
                switch(true) {
                    case $j==0 && $num==1 && strlen($ths)>1: $tnum = 'เอ็ด'; break;
                    case $j==1 && $num==1: $tnum = ''; break;
                    case $j==1 && $num==2: $tnum = 'ยี่'; break;
                    case $j!=0 && $j!=6 && $num==0: $unit = ''; break;
                }
                $S = $tnum . $unit;
                $THS = $S . $THS;
            }
        }
        return $THB.$THS;
    }

    function formatCard($val) {
        $strvalue = substr($val,0,1).'-'.substr($val,1,4).'-'.substr($val,5,5).'-'.substr($val,10,2).'-'.substr($val,12,1);
        return $strvalue;
    }
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <h2 class="card-title p-3" align="center" style="line-height: 3px;">แบบฟอร์มสัญญาประนอมหนี้</h2>
  <body style="margin-top: 0 0 0px;">
    <table border="0">
      <tbody>
        <tr align="right">
          <th width="550px" style="font-size: 8px">วันที่ {{ date('d-m-Y') }}</th>
        </tr>
      </tbody>
    </table>

    <table border="0" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid">
      <tbody>
        <tr style="line-height: 200%; background-color: #D9E2F3;">
          <th width="450px">
            <span style="font-size: 12px"><b>รายละเอียดสัญญา</b></span>
            <span style="font-size: 12px"><b> (Contract Details)</b></span>
          </th>
          <th width="100px" align="right">
            สำหรับลูกค้า &nbsp;
          </th>
        </tr>
        <tr>
          <th></th>
        </tr>
        <tr>
          <th width="305px">
            @if ($data->TypeCon_legis == '101')
            ที่อยู่ บริษัท ชูเกียรติลิสซิ่ง กระบี่ จำกัด
            @else
              ที่อยู่ บริษัท ชูเกียรติ พร๊อมเพอร์ตี้ จำกัด 
            @endif
          </th>
        </tr>
        <tr >
          <th width="305px">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 266 ม.2 ต.กระบี่น้อย อ.เมือง จ.กระบี่ 81000 
          </th>
        </tr>
        <tr>
          <th width="305px">
          @if (@$ItemPay->PaymentTolegislation->TypeCon_legis == '101')
            เบอร์โทร 075-650919 แฟกซ์ 075-650683
            @else
            เบอร์โทร 075-650919 แฟกซ์ 075-650683
            @endif
          </th>
        </tr>
        <tr>
          <th></th>
        </tr>
        <tr style="line-height: 170%;">
          <th width="100px" style="border-left-style: solid; background-color: #FBE4D5">
            เลขที่สัญญา
          </th>
          <th width="200px" style="">
            {{@$data->Contract_legis}}
          </th>
        </tr>
        <tr>
          <th width="100px" style="border-left-style: solid; background-color: #FBE4D5">
            ชื่อ - นามสกุล
          </th>
          <th width="200px" style="">
            {{@$data->Name_legis}}
          </th>
          <th align="center" width="250px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #D9E2F3;">
            รายละเอียดสัญญา (Contract Details)
          </th>
        </tr>
        <tr style="line-height: 170%;">
          <th width="100px" style="border-left-style: solid; background-color: #FBE4D5">
            เลขบัตรประชาชน
          </th>
          <th width="200px" style="">
            {{formatCard(@$data->Idcard_legis)}}
          </th>
          <th width="100px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #FBE4D5">
            ยอดประนอมหนี้
          </th>
          <th align="right" width="150px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid;">
            {{number_format(@$data->legisCompromise->Total_Promise, 2)}}
          </th>
        </tr>
        <tr style="line-height: 170%;">
          <th width="100px" style="border-left-style: solid; background-color: #FBE4D5">
            เบอร์โทรศัพท์
          </th>
          <th width="200px" style="">
            {{@$data->Phone_legis}}
          </th>
          <th width="100px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #FBE4D5">
            ยอดก้อนแรก
          </th>
          <th align="right" width="150px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid;">
            @php
              if($data->legisCompromise->FirstManey_1 != 0){
                $SetFirstMoney = $data->legisCompromise->FirstManey_1;
              }else{
                $SetFirstMoney = $data->legisCompromise->Payall_Promise;
              }
            @endphp
            {{number_format(@$SetFirstMoney, 2)}}
          </th>
        </tr>
        <tr style="line-height: 170%;">
          <th width="100px" style="border-left-style: solid; background-color: #FBE4D5">
            ที่อยู่
          </th>
          <th width="200px" style="">
            {{@$data->Address_legis}}
          </th>
          <th width="100px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #FBE4D5">
            ค่างวด
          </th>
          <th align="right" width="150px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid;">
            @php
              if($data->legisCompromise->Due_1 != 0){
                $SetPaydue = $data->legisCompromise->Due_1;
              }else{
                $SetPaydue = $data->legisCompromise->DuePay_Promise;
              }
            @endphp
            {{number_format(@$SetPaydue, 2)}}
          </th>
        </tr>
        <tr style="line-height: 170%;">
          <th width="100px" style="border-left-style: solid; background-color: #FBE4D5">
            ชื่อ - นามสกุล (ผู้ค่ำ)
          </th>
          <th width="200px" style="">
            {{@$data->NameGT_legis}}
          </th>
          <th width="100px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #FBE4D5">
            ระยะเวลาผ่อน
          </th>
          <th align="right" width="150px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid;">
            @php
              if($data->legisCompromise->Period_1 != 0){
                $SetPeriod = $data->legisCompromise->Period_1;
              }else{
                $SetPeriod = $data->legisCompromise->Due_Promise;
              }
            @endphp
            {{@$SetPeriod}} งวด
          </th>
        </tr>
        <tr style="line-height: 170%;">
          <th width="100px" style="border-bottom-style: solid; border-left-style: solid; background-color: #FBE4D5">
            เลขบัตรประชาชน (ผู้ค่ำ)
          </th>
          <th width="200px" style="border-bottom-style: solid;">
            {{formatCard(@$data->IdcardGT_legis)}}
          </th>
          <th width="100px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #FBE4D5">
            วันที่ชำระงวดแรก
          </th>
          <th align="right" width="150px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid;">
            {{ date('d-m-Y', strtotime(@$data->legisCompromise->Date_Promise)) }}
          </th>
        </tr>
        <tr>
          <th></th>
        </tr>
        <tr>
          <th align="center" width="550px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #D9E2F3;">
            รายละเอียดทรัพย์ (Asset Details)
          </th>
        </tr>
        @if ($data->TypeCon_legis == 'P01')
          <tr style="line-height: 170%;">
            <th width="100px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #FBE4D5">
              ประเภทโฉนด
            </th>
            <th width="200px" style="">
              {{@$data->BrandCar_legis}}
            </th>
            <th width="100px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #FBE4D5">
              เลขที่โฉนด
            </th>
            <th width="150px" style="">
              {{@$data->register_legis}}
            </th>
          </tr>
          <tr style="line-height: 170%;">
            <th width="100px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #FBE4D5">
              เลขทีดิน
            </th>
            <th width="200px" style="">
              {{ number_format(@$data->YearCar_legis,0) }}
            </th>
            <th width="100px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #FBE4D5">
              หน้าสำรวจ
            </th>
            <th width="150px" style="">
              {{@$data->Category_legis}}
            </th>
          </tr>
          <tr style="line-height: 170%;">
            <th width="100px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #FBE4D5">
              เล่ม-หน้า
            </th>
            <th width="200px" style="">
              {{@$data->Mile_legis}}
            </th>
            <th width="100px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #FBE4D5">
              ขนาดที่ดิน
            </th>
            <th width="150px" style="">
              {{@$data->Realty_legis}}
            </th>
          </tr>
        @else
          <tr style="line-height: 170%;">
            <th width="100px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #FBE4D5">
              สถานะทรัพย์
            </th>
            <th width="200px" style="">
              {{@$data->Realty_legis}}
            </th>
            <th width="100px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #FBE4D5">
              ป้ายทะเบียน
            </th>
            <th width="150px" style="">
              {{@$data->register_legis}}
            </th>
          </tr>
          <tr style="line-height: 170%;">
            <th width="100px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #FBE4D5">
              ยี่ห้อ
            </th>
            <th width="200px" style="">
              {{@$data->BrandCar_legis}}
            </th>
            <th width="100px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #FBE4D5">
              ปีรถ
            </th>
            <th width="150px" style="">
              {{@$data->YearCar_legis}}
            </th>
          </tr>
          <tr style="line-height: 170%;">
            <th width="100px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #FBE4D5">
              ประเภทรถ
            </th>
            <th width="200px" style="">
              {{@$data->Category_legis}}
            </th>
            <th width="100px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #FBE4D5">
              เลขไมล์
            </th>
            <th width="150px" style="">
              {{@$data->Mile_legis}}
            </th>
          </tr>
        @endif
      </tbody>
    </table>

    <p style="border-style: dashed;"></p>
    <br>
    <table border="0" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid">
      <tbody>
        <tr style="line-height: 200%; background-color: #D9E2F3;">
          <th width="450px">
            <span style="font-size: 12px"><b>ใบนำฝากชำระเงินค่าสินค้าหรือบริการ</b></span>
            <span style="font-size: 12px"><b> (Bill PaymentPay-in-Slip)</b></span>
          </th>
          <th width="100px" align="right">
            สำหรับธนาคาร &nbsp;
          </th>
        </tr>
        <tr>
          <th></th>
        </tr>
        <tr>
          <th width="305px">
            @if ($data->TypeCon_legis == '101')
            ที่อยู่ บริษัท ชูเกียรติลิสซิ่ง กระบี่ จำกัด
            @else
              ที่อยู่ บริษัท ชูเกียรติ พร๊อมเพอร์ตี้ จำกัด 
            @endif
          </th>
        </tr>
        <tr >
          <th width="305px">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 266 ม.2 ต.กระบี่น้อย อ.เมือง จ.กระบี่ 81000 
          </th>
        </tr>
        <tr>
          <th width="305px">
          @if (@$ItemPay->PaymentTolegislation->TypeCon_legis == '101')
            เบอร์โทร 075-650919 แฟกซ์ 075-650683
            @else
            เบอร์โทร 075-650919 แฟกซ์ 075-650683
            @endif
          </th>
        </tr>
        <tr style="line-height: 150%;">
          <th width="305px">
          </th>
        </tr>
        <tr>
          <th width="5px" rowspan="2"></th>
          <th width="25px" rowspan="2">
            @if ($data->TypeCon_legis == 'F01')
              <img class="center" width="22" height="22" src="{{ asset('dist\img\payments\checkbox.png') }}">
            @endif
          </th>
          <th width="25px" rowspan="2">
            @if ($data->TypeCon_legis == 'F01')
              <img class="center" src="{{ asset('dist\img\payments\baac.png') }}" alt="ธกส">
            @endif
          </th>
          <th width="250px">
            @if ($data->TypeCon_legis == 'F01')
              ธนาคารเพือการเกษตรและสหกรณ์การเกษตร
            @endif
          </th>
        </tr>
        <tr >
          <th width="250px">
            @if ($data->TypeCon_legis == 'F01')
              SERVICE CODE : PNL1
            @endif
          </th>
        </tr>
        <tr>
          <th width="5px" rowspan="2"></th>
          <th width="25px" rowspan="2">
            @if ($data->TypeCon_legis == 'F01')
              <img class="center" width="22" height="22" src="{{ asset('dist\img\payments\checkbox.png') }}">
            @endif
          </th>
          <th width="25px" rowspan="2">
            @if ($data->TypeCon_legis == 'F01')
              <img class="center" src="{{ asset('dist\img\payments\gsb.png') }}" alt="ออมสิน">
            @endif
          </th>
          <th width="250px">
            @if ($data->TypeCon_legis == 'F01')
              ธนาคารออมสิน
            @endif
          </th>
        </tr>
        <tr>
          <th width="250px">
            @if ($data->TypeCon_legis == 'F01')
              COM CODE : PNL
            @endif
          </th>
        </tr>
        <tr>
          <th width="5px" rowspan="2"></th>
          <th width="25px" rowspan="2">
            <img class="center" width="22" height="22" src="{{ asset('dist\img\payments\checkbox.png') }}">
          </th>
          <th width="25px" rowspan="2">
            @if($data->TypeCon_legis == '101')
            <img class="center" src="{{ asset('dist\img\payments\kma.png') }}" alt="กรุงศรี">
            @else
            <img class="center" src="{{ asset('dist\img\payments\kb.png') }}" alt="กสิกร">
            @endif
          </th>
          <th width="250px">
           @if($data->TypeCon_legis == '101')
            ธนาคารกรุงศีอยุธยา ชื่อบัญชี (บริษัท ชูเกียรติลิสซิ่ง กระบี่ จำกัด)
            @else
            ธนาคารกสิกรไทย ชื่อบัญชี (บริษัท ชูเกียรติ พร๊อมเพอร์ตี้ จำกัด )
            @endif
            
          </th>
          <th width="100px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid;"></th>
          <th width="145px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid">
            วันที่
          </th>
        </tr>
        <tr>
          <th width="250px">
            @if($data->TypeCon_legis == '101')
              เลขที่บัญชี 800-9-051005
            @else
            เลขที่บัญชี 009-2-82479-7
            @endif 
          </th>
          <th width="60px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid;">
            ชื่อลูกค้า
          </th>
          <th width="185px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid">
            {{@$data->Name_legis}}
          </th>
        </tr>
        <tr>
          <th width="5px" rowspan="2"></th>
          <th width="25px" rowspan="2">
            
          </th>
          <th width="25px" rowspan="2">
          </th>
          <th width="250px">
          (กรุณา โอนเข้าบัญชีตามที่บริษัทระบุไว้เท่านั้น )
           
          </th>
          <th width="60px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid;">
            เลขอ้างอิงที่ 1
          </th>
          <th width="185px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid">
            {{@$contract}}
          </th>
        </tr>
        <tr>
          <th width="250px">
           
          </th>
          <th width="60px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid;">
            เลขอ้างอิงที่ 2
          </th>
          <th width="185px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid">
            006
          </th>
        </tr>
        <tr>
          <th width="305px" align="center">
            
          </th>
          <th width="60px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid;">
            จำนวนเงิน
          </th>
          <th width="185px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid">
            @php
              if($data->legisCompromise->Due_1 != 0){
                $SetPaydue = $data->legisCompromise->Due_1;
              }else{
                $SetPaydue = $data->legisCompromise->DuePay_Promise;
              }
            @endphp
            {{number_format(@$SetPaydue,2)}} บาท
          </th>
        </tr>
        <tr style="line-height: 200%; font-size: 12px" align="center">
          <th width="152px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #FBE4D5">
            <span><b>รับชำระด้วยเงินสดเท่านั้น</b></span>
          </th>
          <th width="153px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #FBE4D5">
            <span><b>จำนวนเงิน/AMOUNT</b></span>
          </th>
          <th width="180px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid">
          </th>
          <th width="65px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #FBE4D5">
            <span><b>บาท/BAHT</b></span>
          </th>
        </tr>
        <tr style="line-height: 200%; font-size: 12px">
          <th width="152px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #FBE4D5">
            <span><b>จำนวนเงินเป็นตัวอักษร</b></span>
          </th>
          <th width="398px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid;">
          </th>
        </tr>
        <tr style="line-height: 200%;">
          <th width="380px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid">
            ชื่อผู้นำฝาก______________________
          </th>
          <th width="170px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #FBE4D5;" align="center">
            <span><b>สำหรับเจ้าหน้าทีธนาคาร</b></span>
          </th>
        </tr>
        <tr style="line-height: 200%;">
          <th width="380px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid">
            โทรศัพท์________________________
          </th>
          <th width="170px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid;">
            สำหรับเจ้าหน้าทีธนาคาร
          </th>
        </tr>
      </tbody>
    </table>
    <br>
    <br>

    {{--<table border="0">
      <tbody>
        <tr style="line-height: 280%;">
          <th width="350px" align="center">
            <img class="center" height="25" src="{{ asset('cache_barcode/'.$NamepathBr.'.png') }}" alt="barcode">
          </th>
          <th width="200px" rowspan="2" align="right">
            <img height="50" src="{{ asset('cache_barcode/'.$NamepathQr.'.svg') }}" alt="qrcode">
            &nbsp;&nbsp;&nbsp;
          </th>
        </tr>
        <tr>
          <th width="350px" align="center">
            <span >{{$Bar}}</span>
          </th>
        </tr>
      </tbody>
    </table>--}}
  </body>
</html>

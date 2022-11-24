<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name=Generator content="Microsoft Word 15 (filtered)">
    <title></title>
  </head>
  <body>
    <table border="0">
      <tbody>
        <tr>
          <th width="50px"></th>
          <th width="355px">  
            @if (@$ItemPay->PaymentTolegislation->TypeCon_legis == '101')
             บริษัท ชูเกียรติลิสซิ่ง กระบี่ จำกัด
          @else
             บริษัท ชูเกียรติ พร๊อมเพอร์ตี้ จำกัด 
          @endif</th>
          {{-- <th width="305px"></th> --}}
          <th align="right" width="100px">พิมพ์ : {{date('d-m-Y')}} &nbsp;</th>
        </tr>
        <tr >
          <th width="50px"></th>
          <th width="355px">ที่อยู่ 266 ม.2 ต.กระบี่น้อย อ.เมือง จ.กระบี่ 81000 </th>
          <th align="right" width="100px">เลขใบเสร็จ : {{ $ItemPay->Jobnumber_Payment }} &nbsp;</th>
        </tr>
        <tr>
          <th width="50px"></th>
          <th width="305px">           
            เบอร์โทร 075-650919 แฟกซ์ 075-650683         
          </th>
        </tr>
      </tbody>
    </table>
    <br>

    <table border="0" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid">
      <tbody>
        <tr style="line-height: 200%; background-color: #D9E2F3;">
          <th width="450px">
            <span style="font-size: 12px"><b>ใบเสร็จรับชำระเงินหรือบริการ</b></span>
            <span style="font-size: 12px"><b> (Bill PaymentPay-in-Slip)</b></span>
          </th>
          <th width="100px" align="right">
            สำหรับลูกค้า &nbsp;
          </th>
        </tr>
        <tr style="line-height: 50%;">
          <th></th>
        </tr>
        <tr>
          <th width="350px">
            <b>ส่งที่&nbsp;&nbsp;&nbsp; {{@$ItemPay->PaymentTolegislation->Name_legis}}</b>
          </th>
          <th width="200px" align="right"></th>
        </tr>
        <tr >
          <th width="305px">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>{{@$ItemPay->PaymentTolegislation->Address_legis}}</b>
          </th>
        </tr>
        <tr>
          <th width="305px">
           &nbsp;&nbsp;&nbsp;&nbsp; <b>เบอร์โทร &nbsp;{{@$ItemPay->PaymentTolegislation->Phone_legis}}</b>
          </th>
        </tr>
        <tr style="line-height: 150%;">
          <th width="305px">
          </th>
          <th width="245px" align="center" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #D9E2F3;">
            ข้อมูลการชำระ (Payment Details)
          </th>
        </tr>
        <tr>
          <th width="100px" style="border-left-style: solid; background-color: #FBE4D5">
            เลขที่สัญญา
          </th>
          <th width="205px" style="">
            {{@$ItemPay->PaymentTolegislation->Contract_legis}}
          </th>
          <th width="60px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; background-color: #FBE4D5">
            วันที่ชำระ
          </th>
          <th width="185px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid">
            {{ date('d-m-Y', strtotime(substr(@$ItemPay->created_at,0,10))) }}
          </th>
        </tr>
        <tr>
          <th width="100px" style="border-left-style: solid; background-color: #FBE4D5">
            ยอดประนอมหนี้
          </th>
          <th width="205px" style="">
            
            {{number_format(@$ItemCompro->Total_Promise, 2)}}
          </th>
          <th width="60px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; background-color: #FBE4D5">
            ยอด
          </th>
          <th width="185px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid">
            @php
              $SetPrice = ($ItemPay->Gold_Payment / 1.07);
            @endphp
            {{number_format($ItemPay->Gold_Payment, 2)}}
          </th>
        </tr>
        <tr>
          <th width="100px" style="border-left-style: solid; background-color: #FBE4D5">
            ยอดชำระต่องวด
          </th>
          <th width="205px" style="">
            @php
              if($ItemCompro->Due_1 != 0){
                $SetPaydue = $ItemCompro->Due_1;
              }else{
                $SetPaydue = $ItemCompro->DuePay_Promise;
              }
            @endphp
            {{number_format(@$SetPaydue, 2)}}
          </th>
          <th width="60px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; background-color: #FBE4D5">
            {{-- vat --}}
          </th>
          <th width="185px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid">
            {{-- 7% --}}
          </th>
        </tr>
        <tr>
          <th width="100px" style="border-left-style: solid; background-color: #FBE4D5">
            ชำระงวดถัดไป
          </th>
          <th width="205px" style="">
            {{ date('d-m-Y', strtotime($ItemPay->DateDue_Payment)) }}
          </th>
          <th width="60px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; background-color: #FBE4D5">
          </th>
          <th width="185px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid">
            @php
              $SetVat = ($ItemPay->Gold_Payment * 7) / 107;
            @endphp
            {{-- {{number_format($SetVat, 2)}} --}}
          </th>
        </tr>
        <tr>
          <th width="305px" align="center"></th>
          <th width="60px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; background-color: #FBE4D5">
            คงเหลือสุทธิ
          </th>
          <th width="185px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid">
            @if ($ItemPay->Flag_Payment == 'Y')
              {{number_format($ItemCompro->Total_Promise - @$ItemCompro->Discount_Promise - @$SumItemPay, 2)}} บาท
            @else 
              {{number_format($ItemCompro->Total_Promise - @$SumItemPay, 2)}} บาท
            @endif
          </th>
        </tr>
        <tr style="line-height: 200%; font-size: 12px" align="center">
          <th width="305px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #FBE4D5">
            <span><b>จำนวนเงิน/AMOUNT</b></span>
          </th>
          <th width="180px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid">
            <b> {{number_format($ItemPay->Gold_Payment, 2)}}</b>
          </th>
          <th width="65px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #FBE4D5">
            <span><b>บาท/BAHT</b></span>
          </th>
        </tr>
        <tr style="line-height: 200%; font-size: 12px">
          <th width="152px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #FBE4D5">
            <span><b>จำนวนเงินเป็นตัวอักษร</b></span>
          </th>
          <th width="398px" align="center" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid;">
            <b> ( {{  num2thai($ItemPay->Gold_Payment.".00")  }} )</b>
          </th>
        </tr>
        <tr style="line-height: 200%;">
          <th width="380px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid">
            ชื่อผู้นำฝาก______________________
          </th>
          <th width="170px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #FBE4D5;" align="center">
            <span><b>สำหรับเจ้าหน้าที</b></span>
          </th>
        </tr>
        <tr style="line-height: 200%;">
          <th width="380px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid">
            โทรศัพท์________________________
          </th>
          <th width="170px" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid;">
            สำหรับเจ้าหน้าที________________________
          </th>
        </tr>
      </tbody>
    </table>
    <br>
    <br>

   {{--<table border="0">
      <tbody>
        <tr style="line-height: 180%;">
          <th width="350px" align="left">
            <b style="color: #e72b2b"> *** หมายเหตุ : </b> ใช้แสกนเพื่อโอนชำระค่างวดเท่านั้น ไม่สามารถชำระที่เคาน์เตอร์ทุกธนาคารได้
          </th>
          <th width="200px" rowspan="3" align="right">
            <img height="50" src="{{ asset('cache_barcode/'.$NamepathQr.'.svg') }}" alt="qrcode">
            &nbsp;&nbsp;&nbsp;
          </th>
        </tr>
        <tr style="line-height: 280%;">
          <th width="350px" align="center">
            <img class="center" height="25" src="{{ asset('cache_barcode/'.$NamepathBr.'.png') }}" alt="barcode">
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


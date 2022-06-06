
<link rel="stylesheet" href="{{ asset('css/pluginLegislations.css') }}">

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>

<!-- ส่วนหัว -->
  @if($type == 1)     <!-- ใบเสร็จรับชำระค่างวด -->
    <table border="0">
      <tbody>
        <tr>
          <th width="10px"></th>
          <th width="200px" align="left">วันที่ชำระ : {{ formatDateThai(substr($ItemPay->created_at,0,10)) }}</th>
          <th width="230px" align="left"></th>
          <th width="110px" align="right">พิมพ์ : {{ formatDateThai(date('d-m-Y')) }}</th>
        </tr>
        <tr>
          <th width="10px"></th>
          <th width="200px" align="left">เลขที่ใบเสร็จ : {{ $ItemPay->Jobnumber_Payment }}<b></b></th>
        </tr>
      </tbody>
    </table>
    <h3 class="card-title p-3" align="center">ใบเสร็จรับชำระค่างวด</h3>
    <hr>
  @elseif($type == 4) <!-- รายงานรับชำระค่างวด-PDF -->
    <label align="right">พิมพ์ : <u>{{ date('d-m-Y') }}</u></label>
    <h2 class="card-title p-3" align="center" style="font-weight: bold;line-height:3px;"><b>รายงาน รับชำระค่างวด</b></h2>
    <h5 class="card-title p-3 " align="center" style="font-weight: bold;line-height:5px;">วันที่ {{ date('d-m-Y', strtotime($newfdate)) }} ถึงวันที่ {{ date('d-m-Y', strtotime($newtdate)) }}</h5>
  @elseif($type == 6) <!-- ลูกหนี้ชำระตามดิว -->
    <label align="right">พิมพ์ : <u>{{ date('d-m-Y') }}</u></label>
    <h2 class="card-title p-3" align="center" style="font-weight: bold;line-height:3px;"><b>รายงาน ลูกหนี้ชำระตามดิว</b></h2>
    <h5 class="card-title p-3 " align="center" style="font-weight: bold;line-height:5px;">วันที่ {{ date('d-m-Y', strtotime($newfdate)) }} ถึงวันที่ {{ date('d-m-Y', strtotime($newtdate)) }}</h5>
  @endif
  

  <!-- ส่วนข้อมูล -->
  @if($type == 1)     <!-- ใบเสร็จรับชำระค่างวด -->
    <body style="margin-top: 0 0 0px;">
      <br>
      <table border="0">
        <tbody>
          <tr style="line-height:150%;">
            <th width="80px" align="right"><b>ชื่อ - นามสกุล : </b></th>
            <th width="10px"></th>
            <th width="150px" align="left">{{ $ItemPay->PaymentTolegislation->Name_legis }}</th>
          </tr>
          <tr style="line-height:150%;">
            <th width="80px" align="right"><b>เลขที่สัญญา :</b></th>
            <th width="10px"></th>
            <th width="150px" align="left">{{ $ItemPay->PaymentTolegislation->Contract_legis }}</th>
          </tr>
          <tr style="line-height:150%;">
            <th width="80px" align="right"><b>ที่อยู่ :</b></th>
            <th width="10px"></th>
            <th width="300px" align="left">{{ $ItemPay->PaymentTolegislation->Address_legis }}</th>
          </tr>
          <tr style="line-height:200%;">
            <th width="80px" align="right"><b>ยี่ห้อ :</b></th>
            <th width="10px"></th>
            <th width="150px">{{ $ItemPay->PaymentTolegislation->BrandCar_legis }}</th>
            <th width="80px" align="right"><b>ป้ายทะเบียน :</b></th>
            <th width="10px"></th>
            <th width="150px">{{ $ItemPay->PaymentTolegislation->register_legis }}</th>
          </tr>
          <tr style="line-height:200%;">
            <th width="80px" align="right"><b>แบบ :</b></th>
            <th width="10px"></th>
            <th width="150px">{{ $ItemPay->PaymentTolegislation->Category_legis }}</th>
            <th width="80px" align="right"><b>ปีรถ :</b></th>
            <th width="10px"></th>
            <th width="150px">{{ $ItemPay->PaymentTolegislation->YearCar_legis }}</th>
          </tr>
        </tbody>
      </table>
      <br>

      <table border="0">
        <tbody>
          <tr style="line-height:150%;">
            <th width="80px" align="right"><b>งวดละ : </b></th>
            <th width="180px" align="center">
              {{number_format($ItemCompro->DuePay_Promise, 2)}} บาท
            </th>
            <th width="180px" align="right"></th>
          </tr>
          <tr style="line-height:150%;">
            <th width="80px" align="right"><b>ประเภทชำระ : </b></th>
            <th width="180px" align="center"> {{ $ItemPay->Type_Payment }}</th>
            <th width="180px" align="right"></th>
          </tr>
          @if($ItemCompro->Sum_Promise != 0)
            <tr style="line-height:150%;">
              <th width="80px" align="right"><b>ชำระงวดถัดไป : </b></th>
              <th width="180px" align="center"> {{ date('d-m-Y', strtotime($ItemPay->DateDue_Payment)) }}</th>
              <th width="180px" align="right"></th>
            </tr>
          @endif
          <tr><th></th></tr>
          <tr style="line-height:150%;">
            <th width="80px" align="right"></th>
            <th width="360px" align="right">
              @php
                $SetPrice = ($ItemPay->Gold_Payment / 1.07);
              @endphp
              {{number_format($SetPrice, 2)}}
            </th>
          </tr>
          <tr style="line-height:150%;">
            <th width="80px" align="right"></th>
            <th width="360px" align="right">7%</th>
          </tr>
          <tr style="line-height:150%;">
            <th width="80px" align="right"></th>
            <th width="360px" align="right">
              @php
                $SetVat = ($ItemPay->Gold_Payment * 7) / 107;
              @endphp
              {{number_format($SetVat, 2)}}
            </th>
          </tr>
          <tr style="line-height:10%;">
            <th></th>
          </tr>
          <tr style="line-height:150%;">
            <th width="80px" align="right"><b>ยอดสุทธิ : </b></th>
            <th width="260px" align="center"><b> ( {{  num2thai($ItemPay->Gold_Payment.".00")  }} )</b></th>
            <th width="100px" align="right">{{number_format($ItemPay->Gold_Payment, 2)}}</th>
          </tr>
          <tr style="line-height:150%;">
            <th width="80px" align="right"><b>ส่วนลด : </b></th>
            <th width="360px" align="right">
              @if ($ItemPay->Flag_Payment == 'Y')
                {{number_format($ItemCompro->Discount_Promise, 2)}}
              @else 
                0.00
              @endif
            </th>
          </tr>
          <tr style="line-height:150%;">
            <th width="80px" align="right"><b>ยอดคงเหลือ : </b></th>
            <th width="360px" align="right">
              @if ($ItemPay->Flag_Payment == 'Y')
                {{number_format($ItemCompro->Total_Promise - @$ItemCompro->Discount_Promise - @$SumItemPay, 2)}} บาท
              @else 
                {{number_format($ItemCompro->Total_Promise - @$SumItemPay, 2)}} บาท
              @endif
            </th>
          </tr>
        </tbody>
      </table>

      <table border="0">
        <tbody>
          <tr style="line-height:170%;">
            <th></th>
          </tr>
          <tr style="line-height:150%;">
            <th width="250px" align="center">(..............................................)</th>
            <th width="250px" align="center">(..............................................)</th>
          </tr>
          <tr style="line-height:150%;">
            <th width="250px" align="center">ผู้รับเงิน</th>
            <th width="250px" align="center">ผู้จ่ายเงิน</th>
          </tr>
        </tbody>
      </table>
    </body>
  @elseif($type == 4) <!-- รายงานรับชำระค่างวด-PDF -->
    <body style="margin-top: 0 0 0px;">
      <table border="1">
          <tr align="center" style="background-color: yellow;line-height: 150%;font-weight:bold;">
            <th style="width: 30px">ลำดับ</th>
            <th style="width: 70px">เลขที่สัญญา</th>
            <th style="width: 120px">ชื่อ - สกุล</th>
            <th style="width: 70px">ประเภทลูกหนี้</th>
            <th style="width: 70px">วันที่รับชำระ</th>
            <th style="width: 70px">ยอดชำระ</th>
            <th style="width: 70px">ยอดคงเหลือ</th>
            <th style="width: 80px">ประเภทชำระ</th>
            <th style="width: 70px">เลขอ้างอิง</th>
            <th style="width: 100px">ผู้รับชำระ</th>
            <th style="width: 70px">หมายเหตุ</th>
          </tr>
          @php
            $sumPayment = 0;
            $sumAll = 0;
          @endphp
          @foreach($data as $key => $row)
            @php
              $sumPayment += $row->Gold_Payment;
              $sumAll += $row->Sum_Promise;

              if ($row->Flag == 'C') {
                $SetStatus = "ลูกหนี้ประนอมเก่า";
              }else {
                $SetStatus = "ลูกหนี้ประนอมใหม่";
              }
            @endphp
            <tr style="line-height: 110%;">
              <td align="center" style="width: 30px">{{$key+1}}</td>
              <td align="center" style="width: 70px">{{$row->Contract_legis}}</td>
              <td align="left" style="width: 120px">&nbsp;{{$row->Name_legis}}</td>
              <td align="center" style="width: 70px">{{$SetStatus}}</td>
              <td align="center" style="width: 70px">{{formatDateThai(substr($row->created_at,0,10))}}</td>
              <td align="right" style="width: 70px">{{number_format($row->Gold_Payment,2)}} &nbsp;</td>
              <td align="right" style="width: 70px">{{number_format($row->Sum_Promise, 2) }} &nbsp;</td>
              <td align="left" style="width: 80px">&nbsp; {{$row->Type_Payment}}</td>
              <td align="center" style="width: 70px">{{$row->Jobnumber_Payment}}</td>
              <td align="left" style="width: 100px">&nbsp; {{$row->Adduser_Payment}} &nbsp;</td>
              <td align="left" style="width: 70px">&nbsp; {{$row->Note_Payment}}</td>
            </tr>
          @endforeach
      </table>
      <table border="1" style="background-color:#F6FEA1;">
        <tr>
          <td align="center" style="width: 100px"><b>รวม {{count($data)}} รายการ</b></td>
          <td align="right" style="width: 260px"><b>รวมยอดชำระ </b></td>
          <td align="right" style="width: 70px"><b>{{number_format($sumPayment, 2)}} </b></td>
          <td align="right" style="width: 70px"><b>{{number_format($sumAll, 2)}} </b></td>
          <td align="left" style="width: 320px"><b>บาท</b></td>
        </tr>
      </table>
    </body>
  @elseif($type == 6) <!-- ลูกหนี้ชำระตามดิว -->
    <body style="margin-top: 0 0 0px;">
      <table border="1">
          <tr align="center" style="background-color: yellow;line-height: 150%;font-weight:bold;">
            <th style="width: 30px">ลำดับ</th>
            <th style="width: 70px">เลขที่สัญญา</th>
            <th style="width: 120px">ชื่อ - สกุล</th>
            <th style="width: 60px">ประเภทลูกหนี้</th>
            <th style="width: 60px">วันดิวชำระ</th>
            <th style="width: 60px">ค่างวด</th>
            <th style="width: 70px">เลขที่ใบเสร็จ</th>
            <th style="width: 60px">วันที่ชำระ</th>
            <th style="width: 70px">ประเภท</th>
            <th style="width: 60px">ยอดชำระ</th>
            <th style="width: 90px">ผู้รับชำระ</th>
            <th style="width: 70px">หมายเหตุ</th>
          </tr>
          @php
            $sumPayment = 0;
            $sumAll = 0;
          @endphp
          @foreach($data as $key => $row)
            @php
              $sumPayment += $row->Gold_Payment;
              $sumAll += $row->PaymentToCompro->DuePay_Promise;

              if ($row->PaymentTolegislation->Flag == 'C') {
                $SetStatus = "ประนอมเก่า";
              }else {
                $SetStatus = "ประนอมใหม่";
              }
            @endphp
            <tr style="line-height: 110%;">
              <td align="center" style="width: 30px">{{$key+1}}</td>
              <td align="center" style="width: 70px">{{$row->PaymentTolegislation->Contract_legis}}</td>
              <td align="left" style="width: 120px">&nbsp;{{$row->PaymentTolegislation->Name_legis}}</td>
              <td align="center" style="width: 60px">{{$SetStatus}}</td>
              <td align="center" style="width: 60px">{{formatDateThai($row->DateDue_Payment)}}</td>
              <td align="right" style="width: 60px">{{number_format($row->PaymentToCompro->DuePay_Promise,0)}} &nbsp;</td>
              <td align="center" style="width: 70px">{{$row->Jobnumber_Payment}}</td>
              <td align="center" style="width: 60px">{{formatDateThai(substr($row->created_at,0,10))}}</td>
              <td align="center" style="width: 70px">{{$row->Type_Payment}}</td>
              <td align="right" style="width: 60px">{{number_format($row->Gold_Payment,0)}} &nbsp;</td>
              <td align="left" style="width: 90px">&nbsp;{{$row->Adduser_Payment}}</td>
              <td align="left" style="width: 70px">{{$row->Note_Payment}}</td>
            </tr>
          @endforeach
      </table>
      <table border="1" style="background-color:#F6FEA1;">
        <tr>
          <td align="center" style="width: 100px"><b>รวม {{count($data)}} รายการ</b></td>
          <td align="right" style="width: 240px"><b>รวมยอดต้องชำระ </b></td>
          <td align="right" style="width: 60px"><b>{{number_format($sumAll, 2)}} </b></td>
          <td align="right" style="width: 200px"><b>รวมยอดชำระ </b></td>
          <td align="right" style="width: 60px"><b>{{number_format($sumPayment, 2)}} </b></td>
          <td align="left" style="width: 160px"><b>บาท</b></td>
        </tr>
      </table>
    </body>
  @endif
</html>

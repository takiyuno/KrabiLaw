
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>

<!-- ส่วนหัว -->
  @if($type == 1)
    <h3 class="card-title p-3" align="center">ใบเสร็จปิดบัญชี</h3>
    <hr>
  @endif
  
<!-- ส่วนข้อมูล -->
  @if($type == 1)
    <body style="margin-top: 0 0 0px;">
      <br>
      <table border="0">
        <tbody>
          <tr style="line-height:180%;">
            <th width="80px" align="right"><b>ชื่อ - นามสกุล : </b></th>
            <th width="10px"></th>
            <th width="150px" align="left"> {{ $user->Name_legis }} </th>
          </tr>
          <tr style="line-height:180%;">
            <th width="80px" align="right"><b>เลขที่สัญญา :</b></th>
            <th width="10px"></th>
            <th width="150px" align="left">{{ $user->Contract_legis }}</th>
          </tr>
          <tr style="line-height:180%;">
            <th width="80px" align="right"><b>ที่อยู่ :</b></th>
            <th width="10px"></th>
            <th width="300px" align="left"> {{ $user->Address_legis }} </th>
          </tr>
          <tr style="line-height:180%;">
            <th width="80px" align="right"><b>ยี่ห้อ :</b></th>
            <th width="10px"></th>
            <th width="150px">{{ $user->BrandCar_legis }}</th>
            <th width="80px" align="right"><b>ป้ายทะเบียน :</b></th>
            <th width="10px"></th>
            <th width="150px">{{ $user->register_legis }}</th>
          </tr>
          <tr style="line-height:180%;">
            <th width="80px" align="right"><b>แบบ :</b></th>
            <th width="10px"></th>
            <th width="150px">{{ $user->Category_legis }}</th>
            <th width="80px" align="right"><b>ปี :</b></th>
            <th width="10px"></th>
            <th width="150px">{{ $user->YearCar_legis }}</th>
          </tr>
        </tbody>
      </table>
      <br><br>
      <table border="0">
        <tbody>
          <tr style="line-height:150%;">
            <th width="80px" align="right"><b>วันที่รับชำระ : </b></th>
            <th width="150px" align="center">{{ formatDateThai($user->DateStatus_legis) }}</th>
          </tr>
          <tr style="line-height:180%;">
            <th width="80px" align="right"></th>
            <th width="300px" align="right">
              @php
                $SetPrice = ($user->txtStatus_legis / 1.07);
              @endphp
              {{number_format($SetPrice, 2)}}
            </th>
          </tr>
          <tr style="line-height:180%;">
            <th width="80px" align="right"></th>
            <th width="300px" align="right">7%</th>
          </tr>
          <tr style="line-height:180%;">
            <th width="80px" align="right"></th>
            <th width="300px" align="right">
              @php
                $SetVat = ($user->txtStatus_legis * 7) / 107;
              @endphp
              {{number_format($SetVat, 2)}}
            </th>
          </tr>
          <tr style="line-height:10%;">
            <th></th>
          </tr>
          <tr style="line-height:180%;">
            <th width="80px" align="right"><b>ยอดสุทธิ : </b></th>
            <th width="150px" align="center"><b> ( {{  num2thai($user->txtStatus_legis.".00")  }} )</b></th>
            <th width="150px" align="right">{{number_format($user->txtStatus_legis, 2)}}</th>
          </tr>
          <tr style="line-height:180%;">
            <th width="80px" align="right"><b>ยอดส่วนลด : </b></th>
            <th width="300px" align="right">{{number_format($user->Discount_legis, 2)}}</th>
          </tr>
          <tr style="line-height:180%;">
            <th width="80px" align="right"><b>ยอดปิดบัญชี : </b></th>
            <th width="300px" align="right">{{number_format($user->PriceStatus_legis, 2)}}</th>
          </tr>
          <tr style="line-height:180%;">
            <th width="80px" align="right"><b>ยอดคงเหลือ : </b></th>
            <th width="300px" align="right">
              @php
                $SetCountPrice = ($user->txtStatus_legis + $user->Discount_legis) - $user->PriceStatus_legis;
              @endphp
              {{number_format($SetCountPrice , 2)}} บาท
            </th>
          </tr>
        </tbody>
      </table>
      <table border="0">
        <tbody>
        <tr style="line-height:150%;">
            <th></th>
          </tr>
          <tr style="line-height:180%;">
            <th width="200px" align="center">(..............................................)</th>
            <th width="200px" align="center">(..............................................)</th>
          </tr>
          <tr style="line-height:150%;">
            <th width="200px" align="center">ผู้รับเงิน</th>
            <th width="200px" align="center">ผู้จ่ายเงิน</th>
          </tr>
        </tbody>
      </table>
    </body>
  @endif
</html>

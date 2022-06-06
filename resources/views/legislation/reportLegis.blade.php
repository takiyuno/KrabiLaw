@php
  function DateThai($strDate){
    $strYear = date("Y",strtotime($strDate))+543;
    $strMonth= date("n",strtotime($strDate));
    $strDay= date("d",strtotime($strDate));
    $strMonthCut = Array("" , "ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
    $strMonthThai=$strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
  }
@endphp

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>

<!-- ส่วนหัว -->
  @if($type == 18)
    <h1 align="center" style="font-weight: bold;line-height:1px;"><b>รายงานลูกหนี้สิบพยาน</b></h1>
    <h3 align="center" style="font-weight: bold;line-height:10px;"><b>จากวันที่ {{DateThai($newfdate)}} ถึงวันที่ {{DateThai($newtdate)}}</b></h3>
    <hr>
  @endif

<!-- ส่วนข้อมูล -->
  @if($type == 18)
    <body>
      <br>
      <table border="1">
          <tr align="center" style="background-color: yellow;line-height: 200%;font-weight:bold;">
            <th style="width: 30px">ลำดับ</th>
            <th style="width: 80px">เลขที่สัญญา</th>
            <th style="width: 130px">ชื่อ-นามสกุล</th>
            <th style="width: 80px">วันที่สืบพยาน</th>
            <th style="width: 80px">ศาล</th>
            <th style="width: 80px">เลขคดีดำ</th>
            <th style="width: 80px">ชื่อผู้ส่งฟ้อง</th>
          </tr>
          @foreach($data as $key => $row)
          <tr style="line-height: 200%;">
            <td align="center" style="width: 30px"> {{$key+1}}</td>
            <td align="center" style="width: 80px"> {{$row->Contract_legis}}</td>
            <td align="center" style="width: 130px"> {{$row->Name_legis}}</td>
            <td align="center" style="width: 80px"> {{DateThai($row->examiday_court)}}</td>
            <td align="center" style="width: 80px"> {{$row->law_court}}</td>
            <td align="center" style="width: 80px"> {{$row->bnumber_court}}</td>
            <td align="center" style="width: 80px"> {{$row->User_court}}</td>
          </tr>
          @endforeach
      </table>
    </body>
  @endif

</html>

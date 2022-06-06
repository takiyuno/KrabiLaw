<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  @php
    function DateThai($strDate){
      $strYear = date("Y",strtotime($strDate))+543;
      $strMonth= date("n",strtotime($strDate));
      $strDay= date("d",strtotime($strDate));
      $strMonthCut = Array("" , "มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฏาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
      //$strMonthCut = Array("" , "ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
      //$strMonthCut = Array("" , "01","02","03","04","05","06","07","08","09","10","11","12");
      $strMonthThai=$strMonthCut[$strMonth];
      //return "$strDay $strMonthThai $strYear";
      return "$strDay $strMonthThai $strYear";
    }
  @endphp

<!-- ส่วนหัว -->
  @if($type == 1)
    <!-- <h3 class="card-title p-3" align="center">ใบเสร็จค่าใช้จ่ายภายในศาล</h3> -->
    <table border="0" width="370px">
      <tr>
        <td width="210px" align="right" rowspan="3"><img src="{{ asset('dist/img/leasingLogo.png') }}" width="45"></td>
        <td width="80px" align="right"> เลขใบเสร็จ :</td>
        <td width="90px"> {{@$data->Receiptno_expense}}</td>
      </tr>
      <tr>
        <td align="right">วันที่ตั้งเบิก :</td>
        <td style="border-style: dotted;"> {{DateThai($data->Date_expense)}}</td>
      </tr>
      <tr style="line-height: -5px;">
        <td align="right"> </td>
        <td style="border-style: dotted;"> </td>
      </tr>
      <tr>
        <td colspan="3" align="center"  height="30"> <font style="font-size:16px;">ใบขอเบิกเงินฝ่ายกฎหมาย(ค่าภายในศาล)</font></td>
      </tr>
    </table>

    <table border="0" width="370px">
      <tr>
        <td width="150px"></td>
        <td width="95px" align="right"> เลขที่สัญญา&nbsp;&nbsp;&nbsp;</td>
        <!-- <td width="120px">{{@$data->ExpenseTolegislation->Contract_legis}}</td> -->
        <td width="120px">{{@$data->Contract_expense}}</td>
      </tr>
      <tr>
        <td width="150px"></td>
        <td width="95px" align="right"> ชื่อ-สกุล&nbsp;&nbsp;&nbsp;</td>
        <td width="120px" style="border-style: dotted;">{{@$data->ExpenseTolegislation->Name_legis}}</td>
      </tr>
      <tr>
        <td width="150px"></td>
        <td width="95px" align="right"> ศาล&nbsp;&nbsp;&nbsp;</td>
        <td width="120px" style="border-style: dotted;">{{@$data->ExpenseTolegiscourt->law_court}}</td>
      </tr>
      <tr>
        <td width="150px"></td>
        <td width="95px" align="right"> คดีหมายเลขดำที่&nbsp;&nbsp;&nbsp;</td>
        <td width="120px" style="border-style: dotted;">{{@$data->ExpenseTolegiscourt->bnumber_court}}</td>
      </tr>
      <tr>
        <td width="150px"></td>
        <td width="95px" align="right"> คดีหมายเลขแดงที่&nbsp;&nbsp;&nbsp;</td>
        <td width="120px" style="border-style: dotted;">{{@$data->ExpenseTolegiscourt->rnumber_court}}</td>
      </tr>
      <tr style="line-height: -5px;">
        <td width="150px"></td>
        <td width="95px"></td>
        <td width="120px" style="border-style: dotted;"></td>
      </tr>
      <tr>
        <td colspan="2" width="45px" align="right"> ผู้ตั้งเบิก&nbsp;&nbsp;</td>
        <td width="325px"> {{$data->Useradd_expense}}</td>
      </tr>
      <tr>
        <td colspan="2" align="right"></td>
        <td width="320px" style="border-style: dotted;"></td>
      </tr>
    </table>
    
    <table border="1" width="370px">
      <tr align="center">
        <td width="290px">รายการ</td>
        <td width="80px">จำนวนเงิน(บาท)</td>
      </tr>
      <tr>
        <td  height="150"> 
          - {{$data->Topic_expense}}
          @if($data->Note_expense != NULL)
            <br><br>
            *** หมายเหตุ
            <br>
            {{$data->Note_expense}}
          @endif
        </td>
        <td align="right"> {{@number_format($data->Amount_expense,2)}}&nbsp;&nbsp;</td>
      </tr>
      <tr>
        <td> รวมเป็นจำนวนเงิน ( {{num2thai($data->Amount_expense.".00")}} )</td>
        <td align="right">{{@number_format($data->Amount_expense,2)}}&nbsp;&nbsp;</td>
      </tr>
    </table>

    <table border="0" width="370px">
      <tr>
        <td colsapn="3" height="15" width="370px"></td>
      </tr>
      <tr>
        <td width="140px" align="right">ลงชื่อ</td>
        <td width="120px" align="center">
          @if($data->LawyerName_expense != NULL)
            {{$data->LawyerName_expense}}
          @else
            {{$data->NameApprove_expense}}
          @endif
        </td>
        <td width="110px">ผู้รับเงิน</td>
      </tr>
      <tr>
        <td width="140px" align="right">(</td>
        <td width="120px" align="center" style="border-style: dashed;">
          @if($data->LawyerName_expense != NULL)
            {{$data->LawyerName_expense}}
          @else
            {{$data->NameApprove_expense}}
          @endif
        </td>
        <td width="100px">)</td>
      </tr>
      <tr>
        <td width="140px" align="right">ตำแหน่ง</td>
        <td width="120px" align="center" style="border-style: dashed;"> 
          @if($data->LawyerName_expense != NULL)
            ทนายความ
          @else
            เจ้าหน้าที่การเงิน
          @endif
        </td>
        <td width="100px"></td>
      </tr>
      <tr>
        <td width="140px" align="right"></td>
        <td width="130px" style="border-style: dashed;"></td>
        <td width="100px"></td>
      </tr>
    </table>
  @elseif($type == 2)
    <table border="0" width="370px">
      <tr>
        <td width="220px" align="right" rowspan="3"><img src="{{ asset('dist/img/leasingLogo.png') }}" width="50"></td>
        <td width="70px" align="right"> เลขใบเสร็จ :</td>
        <td width="90px"> {{$data[0]->Receiptno_expense}}</td>
      </tr>
      <tr>
        <td align="right">วันที่ตั้งเบิก :</td>
        <td style="border-style: dotted;"> {{DateThai($data[0]->Date_expense)}}</td>
      </tr>
      <tr style="line-height: -5px;">
        <td align="right"> </td>
        <td style="border-style: dotted;"> </td>
      </tr>
      <tr>
        <td colspan="3" align="center"  height="30"> <font style="font-size:16px;">ใบขอเบิกเงินฝ่ายกฎหมาย(ค่าพิเศษ)</font></td>
      </tr>
    </table>
    <table border="0" width="370px">
      <tr>
        <td colspan="2" width="45px" align="right"> ผู้ตั้งเบิก&nbsp;&nbsp;</td>
        <td width="325px"> {{$data[0]->Useradd_expense}}</td>
      </tr>
      <tr>
        <td colspan="2" align="right"></td>
        <td width="320px" style="border-style: dotted;"></td>
      </tr>
    </table>
    <table border="1" width="370px">
      <tr align="center">
        <td width="290px">รายการ</td>
        <td width="80px">จำนวนเงิน(บาท)</td>
      </tr>
      <tr>
        <td> - {{$data[0]->Topic_expense}}</td>
        <td align="right">&nbsp;&nbsp;</td>
      </tr>
      <tr>
        <td height="200">
          <table>
            @foreach($data as $key => $value)
              @php
                @$SumAmount += $value->Amount_expense;
              @endphp
              <tr border="0">
                <td> &nbsp;&nbsp;&nbsp;{{$key+1}}.เลขที่สัญญา {{$value->Contract_expense}}</td>
              </tr>
            @endforeach
          </table>
          @if($data[0]->Note_expense != NULL)
            <br><br>
            *** หมายเหตุ
            <br>
            {{$data[0]->Note_expense}}
          @endif
        </td>
        <td align="right">
          <table>
            @foreach($data as $key => $value)
              <tr border="0">
                <td align="right">{{@number_format($value->Amount_expense,2)}}&nbsp;&nbsp;</td>
              </tr>
            @endforeach
          </table>
        </td>
      </tr>
      
      <tr>
        <td> รวมเป็นจำนวนเงิน ( {{num2thai(@$SumAmount.".00")}} )</td>
        <td align="right">{{@number_format(@$SumAmount,2)}}&nbsp;&nbsp;</td>
      </tr>
    </table>

    <table border="0" width="370px">
      <tr>
        <td colsapn="3" height="15" width="370px"></td>
      </tr>
      <tr>
        <td width="140px" align="right">ลงชื่อ</td>
        <td width="120px" align="center">
          @if($data[0]->LawyerName_expense != NULL)
            {{$data[0]->LawyerName_expense}}
          @else
            {{$data[0]->NameApprove_expense}}
          @endif
        </td>
        <td width="110px">ผู้รับเงิน</td>
      </tr>
      <tr>
        <td width="140px" align="right">(</td>
        <td width="120px" align="center" style="border-style: dashed;">
          @if($data[0]->LawyerName_expense != NULL)
            {{$data[0]->LawyerName_expense}}
          @else
            {{$data[0]->NameApprove_expense}}
          @endif
        </td>
        <td width="100px">)</td>
      </tr>
      <tr>
        <td width="140px" align="right">ตำแหน่ง</td>
        <td width="120px" align="center" style="border-style: dashed;"> 
          @if($data[0]->LawyerName_expense != NULL)
            ทนายความ
          @else
            เจ้าหน้าที่การเงิน
          @endif
        </td>
        <td width="100px"></td>
      </tr>
      <tr>
        <td width="140px" align="right"></td>
        <td width="130px" style="border-style: dashed;"></td>
        <td width="100px"></td>
      </tr>
    </table>
  @elseif($type == 3)
    <!-- <h3 class="card-title p-3" align="center">ใบเสร็จค่าใช้จ่ายภายในศาล</h3> -->
    <table border="0" width="370px">
      <tr>
        <td width="210px" align="right" rowspan="3"><img src="{{ asset('dist/img/leasingLogo.png') }}" width="45"></td>
        <td width="80px" align="right"> เลขใบเสร็จ :</td>
        <td width="90px"> {{$data->Receiptno_expense}}</td>
      </tr>
      <tr>
        <td align="right">วันที่ตั้งเบิก :</td>
        <td style="border-style: dotted;"> {{DateThai($data->Date_expense)}}</td>
      </tr>
      <tr style="line-height: -5px;">
        <td align="right"> </td>
        <td style="border-style: dotted;"> </td>
      </tr>
      <tr>
        <td colspan="3" align="center"  height="30"> <font style="font-size:16px;">ใบขอเบิกเงินฝ่ายกฎหมาย(เบิกสำรองจ่าย)</font></td>
      </tr>
    </table>

    <table border="0" width="370px">
      <tr>
        <td colspan="2" width="45px" align="right"> ผู้ตั้งเบิก&nbsp;&nbsp;</td>
        <td width="325px"> {{$data->Useradd_expense}}</td>
      </tr>
      <tr>
        <td colspan="2" align="right"></td>
        <td width="320px" style="border-style: dotted;"></td>
      </tr>
    </table>
    
    <table border="1" width="370px">
      <tr align="center">
        <td width="290px">รายการ</td>
        <td width="80px">จำนวนเงิน(บาท)</td>
      </tr>
      <tr>
      @if($data->PayAmount_expense == NULL)
        <td height="150">
      @else 
        <td>
      @endif
          - {{$data->Topic_expense}}
        </td>
        <td align="right"> {{@number_format($data->Amount_expense,2)}}&nbsp;&nbsp;</td>
      </tr>
      @if($data->PayAmount_expense != NULL)
      <tr>
        <td  height="150"> 
          - ยอดใช้จ่ายจริง
          @if($data->Note_expense != NULL)
            <br><br>
            *** หมายเหตุ
            <br>
            {{$data->Note_expense}}
          @endif
        </td>
        <td align="right"> {{@number_format($data->PayAmount_expense,2)}}&nbsp;&nbsp;</td>
      </tr>
      @endif
      <tr>
        <td> รวมเป็นจำนวนเงิน ( {{num2thai(($data->Amount_expense - $data->PayAmount_expense).".00")}} )</td>
        <td align="right">{{@number_format($data->Amount_expense - $data->PayAmount_expense,2)}}&nbsp;&nbsp;</td>
      </tr>
    </table>

    <table border="0" width="370px">
      <tr>
        <td colsapn="3" height="15" width="370px"></td>
      </tr>
      <tr>
        <td width="140px" align="right">ลงชื่อ</td>
        <td width="120px" align="center">
          @if($data->LawyerName_expense != NULL)
            {{$data->LawyerName_expense}}
          @else
            {{$data->NameApprove_expense}}
          @endif
        </td>
        <td width="110px">ผู้รับเงิน</td>
      </tr>
      <tr>
        <td width="140px" align="right">(</td>
        <td width="120px" align="center" style="border-style: dashed;">
          @if($data->LawyerName_expense != NULL)
            {{$data->LawyerName_expense}}
          @else
            {{$data->NameApprove_expense}}
          @endif
        </td>
        <td width="100px">)</td>
      </tr>
      <tr>
        <td width="140px" align="right">ตำแหน่ง</td>
        <td width="120px" align="center" style="border-style: dashed;"> 
          @if($data->LawyerName_expense != NULL)
            ทนายความ
          @else
            เจ้าหน้าที่การเงิน
          @endif
        </td>
        <td width="100px"></td>
      </tr>
      <tr>
        <td width="140px" align="right"></td>
        <td width="130px" style="border-style: dashed;"></td>
        <td width="100px"></td>
      </tr>
    </table>
  @elseif($type == 4)

    <table border="0" width="370px">
      <tr>
        <td width="210px" align="right" rowspan="3"><img src="{{ asset('dist/img/leasingLogo.png') }}" width="45"></td>
        <td width="80px" align="right"> เลขใบเสร็จ :</td>
        <td width="90px"> {{$data->Receiptno_expense}}</td>
      </tr>
      <tr>
        <td align="right">วันที่ตั้งเบิก :</td>
        <td style="border-style: dotted;"> {{DateThai($data->Date_expense)}}</td>
      </tr>
      <tr style="line-height: -5px;">
        <td align="right"> </td>
        <td style="border-style: dotted;"> </td>
      </tr>
      <tr>
        <td colspan="3" align="center"  height="30"> <font style="font-size:16px;">ใบขอเบิกเงินฝ่ายกฎหมาย(ค่าของกลาง)</font></td>
      </tr>
    </table>

    <table border="0" width="370px">
      <tr>
        <td width="150px"></td>
        <td width="95px" align="right"> เลขที่สัญญา&nbsp;&nbsp;&nbsp;</td>
        <td width="120px">{{@$data->ExpenseToExhibit->Contract_legis}}</td>
      </tr>
      <tr>
        <td width="150px"></td>
        <td width="95px" align="right"> ชื่อ-สกุล&nbsp;&nbsp;&nbsp;</td>
        <td width="120px" style="border-style: dotted;">{{@$data->ExpenseToExhibit->Name_legis}}</td>
      </tr>
      <tr style="line-height: -5px;">
        <td width="150px"></td>
        <td width="95px"></td>
        <td width="120px" style="border-style: dotted;"></td>
      </tr>
      <tr>
        <td colspan="2" width="45px" align="right"> ผู้ตั้งเบิก&nbsp;&nbsp;</td>
        <td width="325px"> {{$data->Useradd_expense}}</td>
      </tr>
      <tr>
        <td colspan="2" align="right"></td>
        <td width="320px" style="border-style: dotted;"></td>
      </tr>
    </table>
    
    <table border="1" width="370px">
      <tr align="center">
        <td width="290px">รายการ</td>
        <td width="80px">จำนวนเงิน(บาท)</td>
      </tr>
      <tr>
        <td  height="150"> 
          - {{$data->Topic_expense}}
          @if($data->Note_expense != NULL)
            <br><br>
            *** หมายเหตุ
            <br>
            {{$data->Note_expense}}
          @endif
        </td>
        <td align="right"> {{@number_format($data->Amount_expense,2)}}&nbsp;&nbsp;</td>
      </tr>
      <tr>
        <td> รวมเป็นจำนวนเงิน ( {{num2thai($data->Amount_expense.".00")}} )</td>
        <td align="right">{{@number_format($data->Amount_expense,2)}}&nbsp;&nbsp;</td>
      </tr>
    </table>

    <table border="0" width="370px">
      <tr>
        <td colsapn="3" height="15" width="370px"></td>
      </tr>
      <tr>
        <td width="140px" align="right">ลงชื่อ</td>
        <td width="120px" align="center">
          @if($data->LawyerName_expense != NULL)
            {{$data->LawyerName_expense}}
          @else
            {{$data->NameApprove_expense}}
          @endif
        </td>
        <td width="110px">ผู้รับเงิน</td>
      </tr>
      <tr>
        <td width="140px" align="right">(</td>
        <td width="120px" align="center" style="border-style: dashed;">
          @if($data->LawyerName_expense != NULL)
            {{$data->LawyerName_expense}}
          @else
            {{$data->NameApprove_expense}}
          @endif
        </td>
        <td width="100px">)</td>
      </tr>
      <tr>
        <td width="140px" align="right">ตำแหน่ง</td>
        <td width="120px" align="center" style="border-style: dashed;"> 
          @if($data->LawyerName_expense != NULL)
            ทนายความ
          @else
            เจ้าหน้าที่การเงิน
          @endif
        </td>
        <td width="100px"></td>
      </tr>
      <tr>
        <td width="140px" align="right"></td>
        <td width="130px" style="border-style: dashed;"></td>
        <td width="100px"></td>
      </tr>
    </table>
  @endif

</html>
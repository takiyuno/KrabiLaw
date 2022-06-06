<section class="content" style="font-family: 'Prompt', sans-serif;">
  @if($CountData != 0)
    <div class="table-responsive text-sm">
      <table class="table table-hover" id="table">
        <thead>
          <tr>
            <th class="text-center">ลำดับ</th>
            <th class="text-center">เลขที่สัญญา</th>
            <th class="text-center">ชื่อ-สกุล</th>
            <th class="text-center">เลขบัตรประชาชน</th>
            <th class="text-center">เบอร์โทร</th>
            <th class="text-center">ป้ายทะเบียน</th>
            <th class="text-center">#</th>
          </tr>
        </thead>
        <tbody>
          @foreach($data as $key => $row)
            @if($DB_type == 1)
              <tr>
                <td class="text-center"> {{$key+1}}</td>
                <td class="text-center"> {{$row->CONTNO}}</td>
                <td class="text-left"> {{iconv('TIS-620', 'utf-8',str_replace(" ","",$row->SNAM))}}{{iconv('TIS-620', 'utf-8',str_replace(" ","",$row->NAME1))}}&nbsp;&nbsp;&nbsp;{{iconv('TIS-620', 'utf-8',str_replace(" ","",$row->NAME2))}}</td>
                <td class="text-center">{{iconv('TIS-620', 'utf-8',str_replace(" ","",$row->IDNO))}} </td>
                <td class="text-center"> {{iconv('TIS-620', 'utf-8',str_replace(" ","",$row->TELP))}}</td>
                <td class="text-center"> {{iconv('Tis-620','utf-8',$row->REGNO)}}</td>
                <td class="text-right">
                  <a href="{{ route('MasterPrecipitate.create')}}?type={{1}}&DB_type={{$DB_type}}&Contno={{$row->CONTNO}}" class="btn btn-warning btn-sm" title="เลือกรายการ">
                    <i class="far fa-edit">เลือก</i>
                  </a>
                </td>
              </tr>
            @elseif($DB_type == 2)
              <tr>
                <td class="text-center"> {{$key+1}}</td>
                <td class="text-center"> {{$row->CONTNO}}</td>
                <td class="text-left"> {{iconv('TIS-620', 'utf-8',str_replace(" ","",$row->SNAM))}}{{iconv('TIS-620', 'utf-8',str_replace(" ","",$row->NAME1))}}&nbsp;&nbsp;&nbsp;{{iconv('TIS-620', 'utf-8',str_replace(" ","",$row->NAME2))}}</td>
                <td class="text-center">{{iconv('TIS-620', 'utf-8',str_replace(" ","",$row->IDNO))}} </td>
                <td class="text-center"> {{iconv('TIS-620', 'utf-8',str_replace(" ","",$row->TELP))}}</td>
                <td class="text-center"> {{iconv('Tis-620','utf-8',$row->REGNO)}}</td>
                <td class="text-right">
                  <a href="{{ route('MasterPrecipitate.create')}}?type={{1}}&DB_type={{$DB_type}}&Contno={{$row->CONTNO}}" class="btn btn-warning btn-sm" title="เลือกรายการ">
                    <i class="far fa-edit">เลือก</i>
                  </a>
                </td>
              </tr>
            @endif
          @endforeach
        </tbody>
      </table>
    </div>
  @else
    <div class="error-page">
      <h2 class="headline text-danger"> No</h2>
      <div class="error-content">
        <h4><i class="fas fa-exclamation-triangle text-danger prem"></i> ข้อมูลไม่ถูกต้อง ไม่พบเลขที่สัญญานี้!!</h4>
        <br>
        <a href="{{ route('MasterPrecipitate.create')}}?type={{1}}" class="btn btn-block bg-success" title="เลือกรายการ">
          <i class="fas fa-plus-circle"> เพิ่มใหม่</i>
        </a>
      </div>
    </div>
  @endif
</section>
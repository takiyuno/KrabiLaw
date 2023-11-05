<section class="content" style="font-family: 'Prompt', sans-serif;">
    <div class="card">
      <div class="card-header" style="background-image: url({{ asset('dist/img/bg1.jpg') }})">
        <h5 class="text-left">
          <b class="text-white">ตารางรับชำระ <small class="textHeader">(Payments Record)</small></b>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">x</span>
          </button>
        </h5>
      </div>
        <table class="table table-hover SizeText-1 table-sm table1" id="">
            <thead>
            <tr>
                <th class="text-center" style="width: 20px">No.</th>
                <th class="text-center" style="width: 50px">วันที่รับชำระ</th>
                <th class="text-center" style="width: 100px">ประเภท</th>
                <th class="text-center" style="width: 50px">ยอดชำระ</th>
                {{-- <th class="text-center" style="width: 50px">ดิวถัดไป</th> --}}
                <th class="text-center" style="width: 100px">ผู้รับชำระ</th>
                <th class="text-center" style="width: 100px"></th>
            </tr>
            </thead>
            <tbody>
            @if(@$dataPay)
            
            @foreach($dataPay as $key => $row)
                @php
                $cancel="";
                if($row->Flag=='C'){
                    $cancel='style=text-decoration:line-through';
                }
                @endphp
                <tr {{ $cancel}}>
                <td class="text-center"> {{$key+1}} </td>
                <td class="text-center"> {{ date('d-m-Y', strtotime($row->Date_Payment)) }} </td>
                <td class="text-center" title="{{$row->Jobnumber_Payment}}"> {{$row->Type_Payment}} </td>
                <td class="text-right"> 
                    {{ number_format($row->Gold_Payment, 2) }} 
                </td>
                {{-- <td class="text-center text-red"> {{ date('d-m-Y', strtotime($row->DateDue_Payment)) }}</td> --}}
                <td class="text-right"> {{$row->Adduser_Payment}} </td>
                <td class="text-right">
                   
                </td>
                </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center">ไม่พบข้อมูล </td>
            </tr>
            @endif
            </tbody>
        </table> 
    </div>
</section>
@extends('layouts.master')
@section('title','ลูกหนี้เตรียมฟ้อง')
@section('content')
<style>
       .dateHide {
      display:none;
    }
  </style>
  <!-- Main content -->
  <section class="Profile-container" style="font-family: 'Prompt', sans-serif;">
    <div class="content-header">
      @if(session()->has('success'))
        <script type="text/javascript">
          toastr.success('{{ session()->get('success') }}')
        </script>
      @endif
      <div class="container-fluid text-sm">
        <div class="row mb-0">
          <div class="col-sm-6">
            <h5>ลูกหนี้ชั้นเตรียมฟ้อง <small class="textHeader">(Prepare Debtors)</small></h5>
          </div>
          <div class="col-sm-6">
            <form method="get" action="{{ route('MasterLegis.index') }}">
              <div class="card-tools d-inline float-right btn-page">
                <div class="input-group form-inline">
                  <input type="hidden" name="searchButton" value="1">
                  <label for="text" class="mr-sm-1">สถานะ : </label>
                  <select name="FlagStatus" id="text" class="form-control form-control-sm textSize">
                    <option selected value="">-------- สถานะ -------</option>
                    <option value="1" {{ ($FlagStatus == '1') ? 'selected' : '' }}>ลูกหนี้เตรียมฟ้อง</option>
                    <option value="2" {{ ($FlagStatus == '2') ? 'selected' : '' }}>ลูกหนี้ส่งฟ้อง</option>
                    <option value="3" {{ ($FlagStatus == '3') ? 'selected' : '' }}>ประนอมหนี้</option>
                    
                  </select>
                  
                  <label for="text" class="mr-sm-2 ml-sm-2">วันที่ : </label>
                  <input type="text" id="dateSearch" name="dateSearch" value="{{ ($dateSearch != '') ?$dateSearch: '' }}" class="form-control form-control-sm textSize" placeholder="วันที - ถึงวันที่">
                  <span class="input-group-append">
                    <button type="submit" class="btn btn-info btn-sm button-id mr-sm-1">
                      <i class="fas fa-search"></i>
                    </button>
                  </span>
                  <button class="btn btn-info btn-sm hover-up" data-toggle="dropdown">
                    <i class="fas fa-print"></i>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a target="_blank" class="dropdown-item SizeText" href="{{ route('Legislation.Report') }}?type={{7}}">รายงาน ลูกหนี้ฟ้องทั้งหมด'</a></li>
                    {{-- <li><a target="_blank" class="dropdown-item SizeText" href="{{ route('Legislation.Report') }}?type={{8}}">รายงาน ลูกหนี้ขายฝากทั้งหมด'</a></li> --}}
                    {{-- <li class="dropdown-divider"></li>
                     <li><a target="_blank" class="dropdown-item SizeText" href="{{ route('Legislation.Report') }}?type={{2}}">รายงาน ลูกหนี้ Non-Vat</a></li> --}}
                    <li class="dropdown-divider"></li>
                    <li><a class="dropdown-item textSize-13" data-toggle="modal" data-target="#modal-lg" data-link="{{ route('MasterLegis.create') }}?type={{2}}&FlagTab={{9}}">รายงาน สถานะลูกหนี้ทั้งหมด</a></li>
                    <li><a class="dropdown-item textSize-13" data-toggle="modal" data-target="#modal-lg" data-link="{{ route('MasterLegis.create') }}?type={{2}}&FlagTab={{6}}">รายงาน ลูกหนี้ทั้งหมด</a></li>
                  </ul>
                </div>
              </div>
              <input type="hidden" name="type" value="{{$type}}"/>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="content-body">
      <div class="card text-sm card-primary card-outline">
        <div class="card-body row text-sm">
          <div class="col-md-12">
            <div class="table-responsive textSize">
              <table class="table table-nowrap text-nowrap table-hover" id="table">
                <thead>
                  <tr>
                    <th class="text-center">เลขที่สัญญา</th>
                    <th class="text-center">ชื่อ-สกุล</th>
                    <th class="text-center">ประเภทลูกหนี้</th>
                    <th class="text-center">สสถานะประนอม</th>
                    {{-- <th class="text-center">งวด</th> --}}
                    <th class="text-center">ยอดค้าง</th>
                    <th class="text-center">วันรับงาน</th>
                    <th class="text-center">ระยะเวลา</th>
                    
                    <th class="text-center">วันหยุดรับรู้รายได้</th>
                    <th class="text-center">วันตัดหนี้ศูนย์</th>
                    <th class="text-center">หมายเหตุ</th>
                    <th class="text-center">ผู้จัดเตรียม</th>
                    <th class="text-center" style="width: 80px">สถานะ</th>
                    <th class="text-center" style="width: 80px">ตัวเลือก</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($data as $key => $row)
                    <tr>
                      <td class="text-center"> {{$row->Contract_legis}}</td>
                      <td class="text-left"> {{$row->Name_legis}}</td>
                      <td class="text-left"> {{@$Flag[@$row->Flag]}} </td>
                      <td class="text-left"> {{@$Flag_Status[@$row->Flag_status] }}</td>
                       @php
                            $StrCon = explode("/",$row->Contract_legis);
                            @$SetStr1 = $StrCon[0];
                            @$SetStr2 = $StrCon[1];
                        @endphp
                      {{-- <td class="text-center">
                       
                        {{$row->Realperiod_legis}}
                      </td> --}}
                      <td class="text-left"> {{number_format($row->Sumperiod_legis,2)}}</td>
                      <td class="text-center"> 
                      <span class="dateHide">{{ date_format(date_create(@$row->Date_legis), 'Ymd')}} </span> 
                        {{date('d-m-Y', strtotime($row->Date_legis))}}</td>
                      <td class="text-center">
                        @if($row->Datesend_Flag == null)
                          @php
                            $nowday = date('Y-m-d');
                            $Cldate = date_create($row->Date_legis);
                            $nowCldate = date_create($nowday);
                            $ClDateDiff = date_diff($Cldate,$nowCldate);
                            $duration = $ClDateDiff->format("%a วัน")
                          @endphp
                          <span class="btn-danger btn-sm hover-up textSize">
                            <i class="far fa-calendar-check prem pr-1"></i> {{$duration}}
                          </span>
                        @else
                          @php
                            $Cldate = date_create($row->Date_legis);
                            $nowCldate = date_create($row->Datesend_Flag);
                            $ClDateDiff = date_diff($Cldate,$nowCldate);
                            $duration = $ClDateDiff->format("%a วัน")
                          @endphp
                          <span class="btn-success btn-sm hover-up textSize">
                            <i class="far fa-calendar-check prem pr-1"></i> {{$duration}}
                          </span>
                        @endif
                      </td>
                      
                      <td class="text-left" title="{{ @$row->dateStopRev }}">
                        <span class="dateHide">{{ $row->dateStopRev!=NULL?date_format(date_create(@$row->dateStopRev), 'Ymd'):''}} </span> 
                        {{$row->dateStopRev!=NULL?date('d-m-Y', strtotime($row->dateStopRev)):''}}
                      </td>
                      <td class="text-left" title="{{ @$row->dateCutOff }}">
                        <span class="dateHide">{{ @$row->dateCutOff!=NULL?date_format(date_create(@$row->dateCutOff), 'Ymd'):''}} </span> 
                        {{@$row->dateCutOff!=NULL?date('d-m-Y', strtotime($row->dateCutOff)):''}}
                      </td>
                      <td class="text-center"> {{ $row->UserSend2_legis }}</td>
                      <td class="text-left" title="{{ $row->Noteby_legis }}"> {{ str_limit($row->Noteby_legis,30) }} </td>
                      
                      <td class="text-center">
                        @if($row->Flag== 'W')
                         
                            <span class="btn-warning btn-sm hover-up textSize" title="ประนอม">
                              <i class="fas fa-hand-holding-usd prem"></i>
                            </span>
                        
                        @elseif($row->Flag== 'Y')
                          <span class="btn-success btn-sm hover-up textSize" title="วันส่งทนาย {{date('d-m-Y', strtotime($row->Datesend_Flag))}}">
                            {{-- <i class="fas fa-user-check"></i>--}} {{$row->Flag_Class !=NULL ? $row->Flag_Class :'เตรียมเอกสาร'}} 
                          </span>
                        @elseif($row->Flag== 'C')
                          @if($row->legisCompromise != NULL && $row->Flag_status=='3')
                            <span class="btn-warning btn-sm hover-up textSize" title="ประนอม">
                              <i class="fas fa-hand-holding-usd prem"></i>ประนอมหลุดขายฝาก
                            </span>
                          @else
                            <span class="btn-danger btn-sm hover-up textSize" title="หลุดขายฝาก">
                              <i class="fas fa-file-signature pr-1"></i> หลุดขายฝาก 
                            </span>
                          @endif
                        @endif

                       
                      </td>
                      <td class="text-center">
                        <a href="{{ route('MasterLegis.edit',[$row->id]) }}?type={{3}}" class="btn btn-warning btn-sm hover-up" title="แก้ไขรายการ">
                          <i class="far fa-edit"></i>
                        </a>
                        @if(auth::user()->position=="Admin")
                        <form method="post" class="delete_form" action="{{ route('MasterLegis.destroy',[$row->id]) }}" style="display:inline;">
                        {{csrf_field()}}
                          <input type="hidden" name="type" value="1" />
                          <input type="hidden" name="_method" value="DELETE" />
                          <button type="submit"  data-name="{{ $row->Contract_legis }}" class="delete-modal btn btn-danger btn-sm hover-up AlertForm" title="ลบรายการ">
                            <i class="far fa-trash-alt"></i>
                          </button>
                        </form>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <a id="button"></a>
    </div>
  </section>

  <div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
          <p>One fine body…</p>
        </div>
        <div class="modal-footer justify-content-between">
        </div>
      </div>
    </div>
  </div>

<script>
  //*************** Modal *************//
  $(function () {
        $("#modal-lg").on("show.bs.modal", function (e) {
            var link = $(e.relatedTarget).data("link");
            $("#modal-lg .modal-body").load(link, function(){
            });
        });
    });

  </script>
@endsection

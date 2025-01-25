@extends('layouts.master')
@section('title','กฏหมาย/ลูกหนี้ประนอมหนี้')
@section('content')

  @if(session()->has('success'))
    <script type="text/javascript">
      toastr.success('{{ session()->get('success') }}')
    </script>
  @endif

  {{-- เช็คงวดขาด 3 งวด --}}
  @php
    // if ($data->legispayments != NULL){
    //   if ($data->legispayments->DateDue_Payment < date('Y-m-d')) {
    //     $DateDue = date_create($data->legispayments->DateDue_Payment);
    //     $Date = date_create(date('Y-m-d'));
    //     $Datediff = date_diff($DateDue,$Date);
        
    //     if($Datediff->y != NULL) {
    //       $SetYear = ($Datediff->y * 12);
    //     }else{
    //       $SetYear = NULL;
    //     }
    //     $DateNew = ($SetYear + $Datediff->m);
    //   }
    //   else{
    //     $DateNew = NULL;
    //   }
    // }
    // else{
    //   $DateNew = NULL;
    // }
    $DateNew = @$data->legisCompromise->HLDNO;
  @endphp
 
  @if ($data->TypeCon_legis == '')
    <section class="Profile-container" style="font-family: 'Prompt', sans-serif;">
      <div class="content">
        <div class="content-header">
          <div class="row">
            <div class="col-8">
              <div class="form-inline">
                {{-- @if ($data->Flag == "C")
                  <h5>ระบบประนอมหนี้เก่า <small class="textHeader">(Compromise Old)</small></h5>
                @else --}}
                  <h5>ระบบประนอมหนี้ <small class="textHeader">(Compromise )</small></h5>
                {{-- @endif --}}
              </div>
            </div>
            <div class="col-4">
              <div class="card-tools d-inline float-right">
                {{-- <form name="form1" method="post" action="{{ route('MasterCompro.update',[$data->id]) }}" enctype="multipart/form-data">
                  @csrf
                  @method('put')
                  <input type="hidden" name="type" value="2">
                  <input type="hidden" name="_method" value="PATCH"/>
                  <input type="hidden" name="GetNote" id="GetNote" value="{{@$data->legisCompromise->Note_Promise}}">

                  <button type="submit" class="btn btn-info btn-sm SizeText hover-up" {{ (@$data->legisCompromise->Flag_Promise == NULL) ? 'disabled' : '' }}>
                    <i class="fa-solid fa-download"></i> อัพเดต
                  </button>
                </form> --}}
                  {{-- @if($data->Flag == 'Y' and @$DateNew > 3) --}}
                    <a href="{{ route('MasterCompro.edit',[$data->id]) }}?type={{4}}" data-name="{{ $data->Contract_legis }}" class="btn btn-danger btn-sm SizeText hover-up DeleteCompro" title="ลบรายการ"  {{ (@$data->legisCompromise->Flag_Promise == NULL) ? 'disabled' : '' }}>
                      <i class="far fa-trash-alt"></i> ล้าง
                    </a>
                   
                  {{-- @endif --}}
                
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-3">
            <div class="box-shadow">
              <div class="author-card pb-3 pt-3">
                <div class="author-card-cover" style="background-image: url({{ asset('dist/img/bg1.jpg') }})">
                  @if($data->Status_legis != NULL)
                    <a class="btn btn-style-1 btn-sm hover-up bg-green" data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterLegis.show',$id) }}?type={{3}}">
                      <i class="fas fa-clipboard-check text-md"></i> {{$data->Status_legis}}
                    </a>
                  @else
                    <a class="btn btn-style-1 btn-sm hover-up bg-white" data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterLegis.show',$id) }}?type={{2}}">
                      <i class="fas fa-clipboard-check text-md"></i> ปิดบัญชี
                    </a>
                  @endif
                </div>
                <div class="author-card-profile">
                  <div class="author-card-avatar"><img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="Daniel Adams">
                  </div>
                  <div class="author-card-details">
                    <h5 class="author-card-name text-lg">{{ $data->Contract_legis }}</h5>
                    <span class="author-card-position">{{ $data->Name_legis }}</span>
                  </div>
                </div>
              </div>
              <div class="wizard">
                <nav class="list-group list-group-flush">
                  <a class="list-group-item hover-up" href="{{ route('MasterLegis.edit',[$data->id]) }}?type={{3}}">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <i class="fas fa-user-tag mr-1 text-muted"></i>
                        <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ เตรียมฟ้อง</div>
                      </div>
                      @if($data->Flag_status == 2)
                        <i class="far fa-check-square sub-target"></i>
                      @endif
                    </div>
                  </a>
                  <a class="list-group-item  hover-up {{ ($data->Flag_status >1  && $data->Flag != 'W') ? '' : 'disabled' }}" href="{{ route('MasterLegis.edit',[$data->id]) }}?type={{4}}">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <i class="fas fa-balance-scale text-muted"></i>
                        <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ ชั้นศาล</div>
                      </div>
                      @if( $data->Flag_Class == 'สถานะคัดหนังสือรับรองคดี' or  $data->Flag_Class === 'สถานะสืบทรัพย์บังคับคดี' or $data->Flag_Class === 'สถานะคัดโฉนด' or $data->Flag_Class === 'สถานะตั้งยึดทรัพย์' or $data->Flag_Class === 'ประกาศขายทอดตลาด' or $data->Flag_Class === 'จบงานชั้นบังคับคดี')
                        <i class="far fa-check-square sub-target"></i>
                      @endif
                    </div>
                  </a>
                  <a class="list-group-item hover-up {{ ($data->Flag_status >1  && $data->Flag != 'W') ? '' : 'disabled' }}" href="{{ route('MasterLegis.edit',[$data->id]) }}?type={{5}}">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                          <i class="fas fa-link text-muted"></i>
                          <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ ชั้นบังคับคดี</div>
                        </div>
                        @if($data->Flag_Class == 'จบงานชั้นบังคับคดี')
                          <i class="far fa-check-square sub-target"></i>
                        @endif
                      </div>
                  </a>
                  <a class="list-group-item hover-up {{ ($data->Flag_status >1  && $data->Flag != 'W') ? '' : 'disabled' }}" href="{{ route('MasterLegis.edit',[$data->id]) }}?type={{6}}">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                          <i class="fas fa-search-location text-muted"></i>
                          <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ สืบทรัพย์</div>
                        </div>
                        @if(@$data->Legisasset->propertied_asset === 'Y')
                          <i class="fa fa-1x" style="color:red;"><span title="ลูกหนี้มีทรัพย์">Y</span></i> 
                        @elseif(@$data->Legisasset->propertied_asset === 'N')
                          <i class="fa fa-1x" style="color:red;" title="ลูกหนี้ไม่มีทรัพย์"><span>N</span></i> 
                        @endif
                      </div>
                  </a>
                  <a class="list-group-item hover-up active {{ ($data->Flag_status == 3 or $data->Flag == 'C' or $data->Flag == 'Y' or $data->Flag == 'W') ? '' : 'disabled' }}" href="#"><i class="fas fa-hand-holding-usd text-muted"></i>ลูกหนี้ ประนอมหนี้</a>
                  <a class="list-group-item hover-up {{ ($data->Flag_status == 3 or $data->Flag == 'C' or $data->Flag == 'Y' or $data->Flag == 'W') ? '' : 'disabled' }}" href="{{ route('MasterLegis.edit',[$data->id]) }}?type={{7}}"><i class="fas fa-folder-open text-muted"></i>เอกสาร ลูกหนี้</a>
                  <a class="list-group-item hover-up {{ ($data->Flag_status == 3 or $data->Flag == 'C' or $data->Flag == 'Y' or $data->Flag == 'W') ? '' : 'disabled' }}" href="{{ route('MasterExpense.edit',[$data->id]) }}?type={{1}}"><i class="fas fa-money-check-alt text-muted"></i>ธุรกรรม ลูกหนี้</a>
                </nav>
              </div>
            </div>
          </div>
          <div class="col-lg-9">
            <div class="card">
              <div class="card-body text-sm">
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link SizeText {{ ($FlagTab == '1' or $FlagTab == '') ? 'active' : '' }}" data-toggle="tab" href="#list-page1-list">ข้อมูลประนอมหนี้</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link SizeText {{ ($FlagTab == '2') ? 'active' : '' }}" data-toggle="tab" href="#list-page2-list">ตารางผ่อนชำระ</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link SizeText {{ ($FlagTab == '3') ? 'active' : '' }}" data-toggle="tab" href="#list-page3-list">บันทึกติดตาม</a>
                  </li>
                </ul>
                <br>
                <div class="tab-content">
                  <div id="list-page1-list" class="tab-pane {{ ($FlagTab == '1' or $FlagTab == '') ? 'active' : '' }}">
                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">รายละเอียด <span class="textHeader">(Details Compromise)</span></h6>
                      <div class="d-inline float-right">
                        <button type="button" class="btn btn-outline-warning btn-sm hover-up inputButton" data-toggle="dropdown">
                          <span class="SizeText"> <i class="fa-solid fa-list-check"></i> ตั้งค่า </span>
                        </button>
                        <ul class="dropdown-menu text-sm" role="menu">
                          <li>
                            <a class="dropdown-item SizeText" data-toggle="modal" data-target="#modal-default" data-backdrop="static" data-keyboard="false" data-link="{{ route('MasterCompro.show',[$data->id]) }}?type={{4}}">
                              <i class="fa-solid fa-cash-register"></i> ตั้งประนอมหนี้
                            </a>
                          </li>
                          <li class="dropdown-divider"></li>
                          <li>
                            <a target="_blank" href="{{ route('MasterCompro.show',[$data->id]) }}?type={{10}}" class="dropdown-item SizeText {{ (@$data->legisCompromise->Flag_Promise == NULL) ? 'disabled' : '' }}">
                              <i class="fa-solid fa-address-card"></i> แบบฟอร์มสัญญา
                            </a>
                          </li>
                        </ul>
                        <button type="button" class="btn btn-sm btn-outline-success inputButton-1" data-toggle="modal" data-target="#modal-Popup" data-backdrop="static" data-keyboard="false" data-link="{{ route('MasterCompro.show',[$data->id]) }}?type={{5}}" title="รับชำระค่างวด" {{ (@$data->legisCompromise->Flag_Promise == NULL) ? 'disabled' : '' }}>
                          <i class="fa-brands fa-bitcoin"></i> <span class="SizeText">รับชำระ</span>
                        </button>
                      </div>
                      <div class="row mb-3">
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText">ประเภทประนอมหนี้  :</label>
                            <div class="col-sm-8">
                              <input type="text" value="{{@$data->legisCompromise->Type_Promise}}" class="form-control form-control-sm SizeText"/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText">วันที่ประนอม :</label>
                            <div class="col-sm-8">
                              <input type="date" value="{{ @$data->legisCompromise->Date_Promise }}" class="form-control form-control-sm SizeText" readonly/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText">เงินต้น :</label>
                            <div class="col-sm-8">
                              <input type="text" value="{{ (@$data->legisCompromise->Total_Promise != NULL) ?number_format($data->legisCompromise->Total_Promise,2): 0 }}" class="form-control form-control-sm SizeText" placeholder="0.00"/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText">ค่างวด :</label>
                            <div class="col-sm-8">
                              <input type="text" value="{{ (@$data->legisCompromise->DuePay_Promise != NULL) ?number_format($data->legisCompromise->DuePay_Promise,2): 0 }}" class="form-control form-control-sm SizeText" placeholder="0.00"/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText text-red">ยอดชำระรวม :</label>
                            <div class="col-sm-8">
                              <input type="text" value="{{number_format(@$data->legisCompromise->Sum_Promise,2)}}" class="form-control form-control-sm SizeText Boxcolor" placeholder="0.00"/>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6"> 
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText text-red">วันที่ชำระล่าสุด :</label>
                            <div class="col-sm-8">
                              <input type="date" data-date="" value="{{ ($data->legispayments != NULL) ?(substr($data->legispayments->Date_Payment,0,10)): '' }}" class="form-control form-control-sm SizeText Boxcolor" placeholder="วว/ดด/ปปปป"/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText text-red">ยอดชำระล่าสุด :</label>
                            <div class="col-sm-8">
                              <input type="text" value="{{ ($data->legispayments != NULL) ?number_format($data->legispayments->Gold_Payment, 2): '' }}" class="form-control form-control-sm SizeText Boxcolor" placeholder="0.00"/>
                            </div>
                          </div>
                        </div>
                        @if($data->Status_legis == NULL)
                          <div class="col-md-6">
                            <div class="form-group row mb-0">
                              <label class="col-sm-4 col-form-label text-right SizeText text-red">วันดิวงวดถัดไป :</label>
                              <div class="col-sm-8">
                                <input type="date" value="{{ ($data->legispayments != NULL) ?$data->legispayments->DateDue_Payment: '' }}" class="form-control form-control-sm SizeText Boxcolor"  placeholder="วว/ดด/ปปปป"/>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group row mb-0">
                              <label class="col-sm-4 col-form-label text-right SizeText text-red">งวดขาดชำระ :</label>
                              <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm SizeText Boxcolor" value="{{ $DateNew }}" placeholder="งวด"/>
                              </div>
                            </div>
                          </div>
                        @endif
                      </div>
                    <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600 SubHeading SizeText">หมายเหตุ <span class="textHeader">(Compromise Notes)</span></h6>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group row mb-0">
                              <textarea name="NotePromise" id="NotePromise" class="form-control form-control-sm SizeText" rows="5">{{@$data->legisCompromise->Note_Promise}}</textarea>
                          </div>
                        </div>
                      </div>
                  </div>
                  <div id="list-page2-list" class="tab-pane {{ ($FlagTab == '2') ? 'active' : '' }}">
                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">รายการผ่อนชำระ <span class="textHeader">(Instalment Debters)</span></h6>
                      <table class="table table-hover SizeText-1 table-sm " id="">
                        <thead>
                          <tr>
                            <th class="text-center" style="width: 20px">No.</th>
                            <th class="text-center" style="width: 50px">วันที่รับชำระ</th>
                            <th class="text-center" style="width: 100px">ประเภท</th>
                            <th class="text-center" style="width: 50px">ยอดชำระ</th>
                            <th class="text-center" style="width: 50px">ดิวถัดไป</th>
                            <th class="text-center" style="width: 100px">ผู้รับชำระ</th>
                            <th class="text-center" style="width: 100px"></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($dataPay as $key => $row)
                            <tr>
                              <td class="text-center"> {{$key+1}} </td>
                              <td class="text-center"> {{ date('d-m-Y', strtotime($row->Date_Payment)) }} </td>
                              <td class="text-center" title="{{$row->Jobnumber_Payment}}"> {{$row->Type_Payment}} </td>
                              <td class="text-right"> 
                                {{ number_format($row->Gold_Payment, 2) }} 
                                @if($row->Gold_Payment < $data->DuePay_Promise)
                                  <span class="badge bg-danger prem">ต่ำกว่าค่างวด</span>
                                @endif
                              </td>
                              <td class="text-center text-red"> {{ date('d-m-Y', strtotime($row->DateDue_Payment)) }}</td>
                              <td class="text-right"> {{$row->Adduser_Payment}} </td>
                              <td class="text-right">
                                <a target="_blank" class="btn btn-sm hover-up bg-warning {{ ($row->Flag_Payment != 'Y' or Auth::user()->position != 'MANAGER' and Auth::user()->position != 'Admin') ? 'disabled' : '' }}" data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterCompro.show',$row->id) }}?type={{9}}">
                                  <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a target="_blank" href="{{ route('MasterCompro.show',[$row->id]) }}?type={{11}}" class="btn btn-info btn-sm hover-up" title="ปริ้นใบเสร็จ">
                                  <i class="fas fa-print"></i>
                                </a>
                                <form method="post" class="delete_form" action="{{ route('MasterCompro.destroy',[$row->id]) }}?type={{2}}" style="display:inline;">
                                {{csrf_field()}}
                                  <input type="hidden" name="_method" value="DELETE" />
                                  <button type="submit" data-name="{{ $row->Jobnumber_Payment }}" class="delete-modal btn btn-danger btn-sm AlertForm hover-up {{ (auth::user()->type == 'Admin' or auth::user()->type == 'แผนก วิเคราะห์') ? '' : 'disabled' }}" title="ลบรายการ">
                                    <i class="far fa-trash-alt"></i>
                                  </button>
                                </form>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                      <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText"><span class="textHeader"></span></h6>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText text-red">ยอดประนอม :</label>
                            <div class="col-sm-8">
                              <input type="text" value="{{ ($row->legisCompromise != NULL) ?number_format($row->legisCompromise->Total_Promise, 2): '' }}" class="form-control form-control-sm SizeText" readonly/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText text-red">ยอดชำระแล้ว :</label>
                            <div class="col-sm-8">
                              <input type="text" value="{{ ($row->legisCompromise != NULL) ?number_format($Setpaid, 2): '' }}" class="form-control form-control-sm SizeText" readonly/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText text-red">ยอดคงเหลือ :</label>
                            <div class="col-sm-8">
                              <input type="text" value="{{ ($row->legisCompromise != NULL) ?number_format($SetSum, 2): '' }}" class="form-control form-control-sm SizeText" readonly/>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                  <div id="list-page3-list" class="tab-pane {{ ($FlagTab == '3') ? 'active' : '' }}">
                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">บันทึกติดตาม <span class="textHeader">(Tracking Debters)</span></h6>
                      <button type="button" class="btn btn-sm bg-gray SizeText inputButton" data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterCompro.show',[$data->id]) }}?type={{6}}" title="บันทึกติดตาม" {{ (@$data->legisCompromise->Flag_Promise == NULL) ? 'disabled' : '' }}>
                        <i class="fas fa-tags SizeText"></i> ติดตาม
                      </button>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText {{ (@$data->legisTrackings->JobPayment_Track != NULL) ? 'text-success' : 'text-red' }}">Status :</label>
                            <div class="col-sm-8">
                              @if (@$data->legisTrackings->DateDue_Track != NULL )
                                @if(@$data->legisTrackings->DateDue_Track > date('Y-m-d') and @$data->legisTrackings->Status_Track == 'Y')
                                  <input type="text" value="แจ้งกำหนดชำระ" class="form-control form-control-sm SizeText Boxcolor prem text-red"/>
                                @else
                                  @if(@$data->legisTrackings->JobPayment_Track != NULL)
                                    <input type="text" value="ชำระเรียบร้อยแล้ว" class="form-control form-control-sm SizeText Boxcolor-G prem text-success"/>
                                  @else
                                    <input type="text" value="เลยกำหนดชำระ" class="form-control form-control-sm SizeText Boxcolor prem text-red"/>
                                  @endif
                                @endif
                              @else
                                <input type="text" value="ไม่มีการติดตาม" class="form-control form-control-sm SizeText prem text-gray"/>
                              @endif
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText text-red">JobNumber :</label>
                            <div class="col-sm-8">
                              <input type="text" value="{{ @$data->legisTrackings->JobNumber_Track }}" class="form-control form-control-sm SizeText Boxcolor" placeholder="JobNumber"/>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText text-red">สถานะติดตาม :</label>
                            <div class="col-sm-8">
                              <input type="text" value="{{ @$data->legisTrackings->Subject_Track }}" class="form-control form-control-sm SizeText Boxcolor" placeholder="สถานะติดตาม"/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText text-red">วันนัดชำระ :</label>
                            <div class="col-sm-8">
                              <input type="date" value="{{ @$data->legisTrackings->DateDue_Track }}" class="form-control form-control-sm SizeText Boxcolor" placeholder="สถานะติดตาม"/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group row mb-0">
                            <label class="col-sm-2 col-form-label text-right SizeText">รายละเอียด :</label>
                            <div class="col-sm-10">
                              <textarea name="NotePromise" class="form-control form-control-sm SizeText" rows="3">{{ @$data->legisTrackings->Detail_Track }}</textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                      <br>
                      <table class="table table-sm table-hover SizeText-1" id="table2">
                        <thead>
                          <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">วันที่บันทึก</th>
                            <th class="text-center">เลขอ้างอิง</th>
                            <th class="text-center">สถานะ</th>
                            <th class="text-center">วันนัดชำระ</th>
                            <th class="text-center">ผู้บันทึก</th>
                            <th class="text-center"></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($dataTrack as $key => $row)
                            <tr>
                              <td class="text-center"> {{$key+1}} </td>
                              <td class="text-center">{{ date('d-m-Y', strtotime(substr($row->created_at,0,10))) }}</td>
                              <td class="text-center">
                                {{ $row->JobNumber_Track }}
                                @if ($row->JobPayment_Track != NULL)
                                  <span placeholder="ชำระเรียบร้อย">
                                    <i class="fas fa-check-circle float-right text-green prem"></i>
                                  </span>
                                @else
                                  <span placeholder="รอดำเนินการ">
                                    <i class="fas fa-exclamation-circle float-right text-red prem"></i>
                                  </span>
                                @endif
                              </td>
                              <td class="text-center" title="{{$row->Detail_Track}}">{{ $row->Subject_Track }}</td>
                              <td class="text-center">{{ ($row->DateDue_Track != NULL) ?formatDateThai($row->DateDue_Track) : '-' }}</td>
                              <td class="text-right">{{ $row->User_Track }}</td>
                              <td class="text-right">
                              <form method="post" class="delete_form" action="{{ route('MasterCompro.destroy',[$row->id]) }}?type={{3}}" style="display:inline;">
                                {{csrf_field()}}
                                  <input type="hidden" name="_method" value="DELETE" />
                                  <button type="submit" data-name="{{ $row->JobNumber_Track }}" class="delete-modal btn btn-danger btn-sm AlertForm hover-up" title="ลบรายการ">
                                    <i class="far fa-trash-alt"></i>
                                  </button>
                                </form>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  @else
    <section class="Profile-container" style="font-family: 'Prompt', sans-serif;">
      <div class="content">
        <div class="content-header">
          <div class="row">
            <div class="col-8">
              <div class="form-inline">
                {{-- @if ($data->Flag == "C")
                  <h5>ระบบประนอมหนี้เก่า <small class="textHeader">(Compromise Old)</small></h5>
                @else --}}
                  <h5>ระบบประนอมหนี้<small class="textHeader">(Compromise )</small></h5>
                {{-- @endif --}}
              </div>
            </div>
            <div class="col-4">
              <div class="card-tools d-inline float-right">
                <form name="form1" method="post" action="{{ route('MasterCompro.update',[$data->id]) }}" enctype="multipart/form-data">
                  @csrf
                  @method('put')
                  <input type="hidden" name="type" value="2">
                  <input type="hidden" name="_method" value="PATCH"/>
                  <input type="hidden" name="GetNote" id="GetNote" value="{{@$data->legisCompromise->Note_Promise}}">

                  {{-- <button type="submit" class="btn btn-info btn-sm SizeText hover-up" {{ (@$data->legisCompromise->Flag_Promise == NULL) ? 'disabled' : '' }}>
                    <i class="fa-solid fa-download"></i> อัพเดต
                  </button> --}}
                  @if( @$data->legisCompromise->Flag_Promise != 'Complete')

                  <button type="button" class="btn btn-info btn-sm SizeText hover-up ClearPromise"  id='{{ $data->Contract_legis }}' data-name="{{ route('MasterCompro.edit',[$data->id]) }}?type={{4}}" {{ (@$data->legisCompromise->Flag_Promise == NULL) ? 'disabled' : '' }}>
                    <i class="far fa-trash-alt"></i> ล้าง
                  </button>
                    {{-- <a href="" data-name="{{ $data->Contract_legis }}" class="btn btn-danger btn-sm SizeText hover-up ClearPromise" title="ลบรายการ">
                      <i class="far fa-trash-alt"></i> ล้าง
                    </a> --}}
                  @endif
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-3">
            <div class="box-shadow">
              <div class="author-card pb-3 pt-3">
                <div class="author-card-cover" style="background-image: url({{ asset('dist/img/bg1.jpg') }})">
                  @if($data->Status_legis != NULL)
                    <a class="btn btn-style-1 btn-sm hover-up bg-green" data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterLegis.show',$id) }}?type={{3}}">
                      <i class="fas fa-clipboard-check text-md"></i> {{$data->Status_legis}}
                    </a>
                  @else
                    <a class="btn btn-style-1 btn-sm hover-up bg-white" data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterLegis.show',$id) }}?type={{2}}">
                      <i class="fas fa-clipboard-check text-md"></i> ปิดบัญชี
                    </a>
                  @endif
                </div>
                <div class="author-card-profile">
                  <div class="author-card-avatar"><img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="Daniel Adams">
                  </div>
                  <div class="author-card-details">
                    <h5 class="author-card-name text-lg">{{ $data->Contract_legis }}</h5>
                    <span class="author-card-position">{{ $data->Name_legis }}</span>
                  </div>
                </div>
              </div>
              <div class="wizard">
                <nav class="list-group list-group-flush">
                  <a class="list-group-item hover-up" href="{{ route('MasterLegis.edit',[$data->id]) }}?type={{3}}">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <i class="fas fa-user-tag mr-1 text-muted"></i>
                        <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ เตรียมฟ้อง</div>
                      </div>
                      @if($data->Flag_status == 2)
                        <i class="far fa-check-square sub-target"></i>
                      @endif
                    </div>
                  </a>
                  <a class="list-group-item  hover-up {{ ($data->Flag_status == 2) ? '' : 'disabled' }}" href="{{ route('MasterLegis.edit',[$data->id]) }}?type={{4}}">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <i class="fas fa-balance-scale text-muted"></i>
                        <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ ชั้นศาล</div>
                      </div>
                      @if($data->Flag_Class === 'สถานะสืบทรัพย์บังคับคดี' or $data->Flag_Class === 'สถานะคัดโฉนด' or $data->Flag_Class === 'สถานะตั้งยึดทรัพย์' or $data->Flag_Class === 'ประกาศขายทอดตลาด' or $data->Flag_Class === 'จบงานชั้นบังคับคดี')
                        <i class="far fa-check-square sub-target"></i>
                      @endif
                    </div>
                  </a>
                  <a class="list-group-item hover-up {{ ($data->Flag_status == 2) ? '' : 'disabled' }}" href="{{ route('MasterLegis.edit',[$data->id]) }}?type={{5}}">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                          <i class="fas fa-link text-muted"></i>
                          <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ ชั้นบังคับคดี</div>
                        </div>
                        @if($data->Flag_Class == 'จบงานชั้นบังคับคดี')
                          <i class="far fa-check-square sub-target"></i>
                        @endif
                      </div>
                  </a>
                  <a class="list-group-item hover-up {{ ($data->Flag_status == 2) ? '' : 'disabled' }}" href="{{ route('MasterLegis.edit',[$data->id]) }}?type={{6}}">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                          <i class="fas fa-search-location text-muted"></i>
                          <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ สืบทรัพย์</div>
                        </div>
                        @if(@$data->Legisasset->propertied_asset === 'Y')
                          <i class="fa fa-1x" style="color:red;"><span title="ลูกหนี้มีทรัพย์">Y</span></i> 
                        @elseif(@$data->Legisasset->propertied_asset === 'N')
                          <i class="fa fa-1x" style="color:red;" title="ลูกหนี้ไม่มีทรัพย์"><span>N</span></i> 
                        @endif
                      </div>
                  </a>
                  <a class="list-group-item hover-up active {{ ($data->Flag_status == 2 or $data->Flag == 'C') ? '' : 'disabled' }}" href="#"><i class="fas fa-hand-holding-usd text-muted"></i>ลูกหนี้ ประนอมหนี้</a>
                  <a class="list-group-item hover-up {{ ($data->Flag_status == 2 or $data->Flag == 'C') ? '' : 'disabled' }}" href="{{ route('MasterLegis.edit',[$data->id]) }}?type={{7}}"><i class="fas fa-folder-open text-muted"></i>เอกสาร ลูกหนี้</a>
                  <a class="list-group-item hover-up {{ ($data->Flag_status == 2 or $data->Flag == 'C') ? '' : 'disabled' }}" href="{{ route('MasterExpense.edit',[$data->id]) }}?type={{1}}"><i class="fas fa-money-check-alt text-muted"></i>ธุรกรรม ลูกหนี้</a>
                </nav>
              </div>
            </div>
          </div>
          <div class="col-lg-9">
            <div class="card">
              <div class="card-body text-sm">
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link SizeText {{ ($FlagTab == '1' or $FlagTab == '') ? 'active' : '' }}" data-toggle="tab" href="#list-page1-list">ข้อมูลประนอมหนี้</a>
                  </li>
                
                  @if(@$dataPay!=NULL && count(@$dataPay->legisToFDue)>0)
                  <li class="nav-item">
                    <a class="nav-link SizeText {{ ($FlagTab == '5') ? 'active' : '' }}" data-toggle="tab" href="#list-page5-list">ตารางเงินก้อนเเรก</a>
                  </li>
                  @endif
                  <li class="nav-item">
                    <a class="nav-link SizeText {{ ($FlagTab == '2') ? 'active' : '' }}" data-toggle="tab" href="#list-page2-list">ตารางผ่อนชำระ</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link SizeText {{ ($FlagTab == '3') ? 'active' : '' }}" data-toggle="tab" href="#list-page3-list">ตารางรับชำระ</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link SizeText {{ ($FlagTab == '4') ? 'active' : '' }}" data-toggle="tab" href="#list-page4-list">บันทึกติดตาม</a>
                  </li>
                </ul>
                <br>
                <div class="tab-content">
                  <div id="list-page1-list" class="tab-pane {{ ($FlagTab == '1' or $FlagTab == '') ? 'active' : '' }}">
                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">รายละเอียด <span class="textHeader">(Details Compromise)</span></h6>
                      <div class="d-inline float-right">
                        <button type="button" class="btn btn-outline-warning btn-sm hover-up inputButton" data-toggle="dropdown">
                          <span class="SizeText"> <i class="fa-solid fa-list-check"></i> ตั้งค่า </span>
                        </button>
                        <ul class="dropdown-menu text-sm" role="menu">
                          <li>
                            <a class="dropdown-item SizeText" data-toggle="modal" data-target="#modal-default" data-backdrop="static" data-keyboard="false" data-link="{{ route('MasterCompro.show',[$data->id]) }}?type={{4}}">
                              <i class="fa-solid fa-cash-register"></i> ตั้งประนอมหนี้
                            </a>
                          </li>
                          <li class="dropdown-divider"></li>
                          <li>
                            <a target="_blank" href="{{ route('MasterCompro.show',[$data->id]) }}?type={{10}}" class="dropdown-item SizeText">
                              <i class="fa-solid fa-address-card"></i> แบบฟอร์มสัญญา
                            </a>
                          </li>
                        </ul>
                        <button type="button" class="btn btn-sm btn-outline-success inputButton-1" data-toggle="modal" data-target="#modal-Popup" data-backdrop="static" data-keyboard="false" data-link="{{ route('MasterCompro.show',[$data->id]) }}?type={{5}}" title="รับชำระค่างวด" {{ (@$data->legisCompromise->Flag_Promise == NULL) ? 'disabled' : '' }}>
                          <i class="fa-brands fa-bitcoin"></i> <span class="SizeText">รับชำระ</span>
                        </button>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText">ประเภทประนอมหนี้ :</label>
                            <div class="col-sm-8">
                             
                                <select class="form-control form-control-sm SizeText">
                                  <option value="" selected>--- เลือกประนอม ---</option>
                                  <option value="ชำระหนี้ตามคำพิภากษาตามยอม" {{ (@$data->legisCompromise->Type_Promise === 'ชำระหนี้ตามคำพิภากษาตามยอม') ? 'selected' : '' }}>01. ชำระหนี้ตามคำพิภากษาตามยอม</option>
                                  <option value="ประนอมหนี้บริษัท" {{ (@$data->legisCompromise->Type_Promise === 'ประนอมหนี้บริษัท') ? 'selected' : '' }}>02. ประนอมหนี้บริษัท</option>
                                  {{-- <option value="จำนำทรัพย์" {{ (@$data->legisCompromise->Type_Promise === 'จำนำทรัพย์') ? 'selected' : '' }}>03. จำนำทรัพย์</option>
                                  <option value="ประนอมขายฝาก" {{ (@$data->legisCompromise->Type_Promise === 'ประนอมขายฝาก') ? 'selected' : '' }}>04. ประนอมขายฝาก</option>
                                  <option value="ประนอมหนี้หลังยึดทรัพย์" {{ (@$data->legisCompromise->Type_Promise === 'ประนอมหนี้หลังยึดทรัพย์') ? 'selected' : '' }}>05. ประนอมหนี้หลังยึดทรัพย์</option> --}}
                                  
                                </select>
                          
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText">วันที่ประนอม :</label>
                            <div class="col-sm-8">
                              <input type="date" value="{{ @$data->legisCompromise->Date_Promise }}"  class="form-control form-control-sm SizeText" readonly/>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText">ยอดประนอมหนี้ :</label>
                            <div class="col-sm-8">
                              <input type="text" value="{{ ($data->legisCompromise != NULL) ?number_format($data->legisCompromise->Total_Promise, 2): '' }}" class="form-control form-control-sm SizeText" placeholder="0.00"/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText">
                              @if($data->legisCompromise != NULL)
                                @php
                                  if($data->legisCompromise->FirstManey_1 != 0){
                                    $SetFirstMoney = $data->legisCompromise->FirstManey_1;
                                  }else{
                                    $SetFirstMoney = $data->legisCompromise->Payall_Promise;
                                  }
                                @endphp
                                @if($data->legisCompromise->Sum_FirstPromise == $SetFirstMoney)
                                  <font color="green">ยอดเงินก้อนแรก : </font>
                                @else
                                  <font color="red" class="prem">ยอดเงินก้อนแรก /ชำระ: </font>
                                @endif
                              @else
                                ยอดเงินก้อนแรก :
                              @endif
                            </label>
                            <div class="col-sm-4">
                                <input type="text" value="{{ ($data->legisCompromise != NULL) ? number_format($data->legisCompromise->FirstManey_1, 2): 0 }}" class="form-control form-control-sm SizeText" placeholder="0.00"/>
                            </div>
                            <div class="col-sm-4">
                              <input type="text" value="{{ ($data->legisCompromise != NULL) ? number_format($data->legisCompromise->Sum_FirstPromise,2): 0 }}" class="form-control form-control-sm SizeText" placeholder="0.00"/>
                          </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText">ค่างวด :</label>
                            <div class="col-sm-8">
                              @if ($data->legisCompromise != NULL and $data->legisCompromise->Due_1 != 0)
                                <input type="text" value="{{ ($data->legisCompromise != NULL) ?number_format($data->legisCompromise->Due_1, 2): '' }}" class="form-control form-control-sm SizeText" placeholder="0.00"/>
                              @else
                                <input type="text" value="{{ ($data->legisCompromise != NULL) ?number_format($data->legisCompromise->DuePay_Promise, 2): '' }}" class="form-control form-control-sm SizeText" placeholder="0.00"/>
                              @endif
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText">ระยะเวลาผ่อน :</label>
                            <div class="col-sm-8">
                              @if ($data->legisCompromise != NULL and $data->legisCompromise->Period_1 != 0)
                                <input type="text" value="{{ ($data->legisCompromise != NULL) ?$data->legisCompromise->Period_1: '' }}" class="form-control form-control-sm SizeText" placeholder="0.00"/>
                              @else
                                <input type="text" value="{{ ($data->legisCompromise != NULL) ?$data->legisCompromise->Due_Promise: '' }}" class="form-control form-control-sm SizeText" placeholder="0"/>
                              @endif
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText">ส่วนลด :</label>
                            <div class="col-sm-8">
                              <input type="text" value="{{ ($data->legisCompromise != NULL) ?number_format($data->legisCompromise->Discount_Promise, 2): '' }}" class="form-control form-control-sm SizeText" readonly/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText">ค้างค่าปรับ :</label>
                            <div class="col-sm-8">
                              <input type="text" value="{{ ($intamtbl != NULL) ?number_format($intamtbl, 2): 0 }}" class="form-control form-control-sm SizeText" readonly/>
                            </div>
                          </div>
                        </div>
                      </div>

                      @php
                        $Setpaid = NULL;
                        $SetSum = NULL;

                        if ($data->legisCompromise != NULL){
                          $Setpaid = $data->legisCompromise->Sum_FirstPromise + $data->legisCompromise->Sum_DuePayPromise;
                          $SetSum = ($data->legisCompromise->Total_Promise - ($data->legisCompromise->Sum_FirstPromise + $data->legisCompromise->Sum_DuePayPromise + $data->legisCompromise->Discount_Promise));
                        }
                      @endphp
                      <div class="row">
                        <div class="col-md-6"> 
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText text-red">วันที่ชำระล่าสุด :</label>
                            <div class="col-sm-8">
                              <input type="date" value="{{ ($data->legispayments != NULL) ?(substr($data->legispayments->Date_Payment,0,10)): '' }}" class="form-control form-control-sm SizeText Boxcolor" placeholder="วว/ดด/ปปปป"/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText text-red">ยอดชำระล่าสุด :</label>
                            <div class="col-sm-8">
                              <input type="text" value="{{ ($data->legispayments != NULL) ?number_format($data->legispayments->Gold_Payment, 2): '' }}" class="form-control form-control-sm SizeText Boxcolor" placeholder="0.00"/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText text-red">ยอดชำระแล้ว :</label>
                            <div class="col-sm-8">
                              <input type="text" value="{{ ($data->legisCompromise != NULL) ?number_format($Setpaid, 2): '' }}" class="form-control form-control-sm SizeText Boxcolor" placeholder="0.00"/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText text-red">ยอดคงเหลือ :</label>
                            <div class="col-sm-8">
                              <input type="text" value="{{ ($data->legisCompromise != NULL) ?number_format($SetSum, 2): '' }}" class="form-control form-control-sm SizeText Boxcolor" placeholder="0.00"/>
                            </div>
                          </div>
                        </div>
                        @if($data->Status_legis == NULL)
                          {{-- <div class="col-md-6">
                            <div class="form-group row mb-0">
                              <label class="col-sm-4 col-form-label text-right SizeText text-red">วันดิวงวดถัดไป :</label>
                              <div class="col-sm-8">
                                <input type="date" value="{{ ($data->legispayments != NULL) ?$data->legispayments->DateDue_Payment: '' }}" class="form-control form-control-sm SizeText Boxcolor"  placeholder="วว/ดด/ปปปป"/>
                              </div>
                            </div>
                          </div> --}}
                          <div class="col-md-6">
                            <div class="form-group row mb-0">
                              <label class="col-sm-4 col-form-label text-right SizeText text-red">งวดขาดชำระ :</label>
                              <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm SizeText Boxcolor" value="{{ $DateNew }}" placeholder="งวด"/>
                              </div>
                            </div>
                          </div>
                        @endif
                      </div>
                    
                      @if($dataOldPromise->legisCompromiseInact!=NULL)
                    <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600 SubHeading SizeText">ประนอมเก่าสร้างใหม่ <span class="textHeader">(Compromise Old)</span></h6>
                    <table class=" table-hover SizeText-1 table-sm table" id="">
                      <thead>
                        <tr>
                          <th class="text-center" style="width: 20px">No.</th>
                          <th class="text-center" style="width: 50px">วันที่ประนอม</th>
                          <th class="text-center" style="width: 100px">ประเภท</th>
                          <th class="text-center" style="width: 50px">ยอดประนอม</th>
                          <th class="text-center" style="width: 50px">ค่างวด</th>
                          <th class="text-center" style="width: 50px">ยอดชำระแล้ว</th>
                          <th class="text-center" style="width: 50px">ยอดคงเหลือ</th>
                          {{-- <th class="text-center" style="width: 100px">วันที่ทำสัญญาใหม่</th> --}}
                          <th class="text-center" style="width: 100px"></th>
                        </tr>
                      </thead>
                       
                        @foreach($dataOldPromise->legisCompromiseInact as $key => $value)
                        @php
                          $sumpay = 0;
                          $sumpay = (@$value->Sum_FirstPromise!=NULL?floatval(@$value->Sum_FirstPromise):0)+(@$value->Sum_DuePayPromise!=NULL?floatval(@$value->Sum_DuePayPromise):0);

                        @endphp
                        <tr>
                          <td class="text-center" style="width: 20px">{{$key+1}}</td>
                          <td class="text-center" style="width: 50px">{{@$value->Date_Promise}}</td>
                          <td class="text-center" style="width: 100px">{{@$value->Type_Promise}}</td>
                          <td class="text-center" style="width: 50px">{{@$value->Total_Promise}}</td>
                          <td class="text-center" style="width: 50px">{{@$value->Due_1>0?@$value->Due_1:@$value->DuePay_Promise}}</td>
                          <td class="text-center" style="width: 50px">{{$sumpay}}</td>
                          <td class="text-center" style="width: 50px">{{floatval(@$value->Total_Promise)-$sumpay}}</td>
                          {{-- <td class="text-center" style="width: 100px">{{@$value->Date_Promise}}</td> --}}
                          <td class="text-center" style="width: 100px">
                            <button type="button"  class="btn btn-sm btn-outline-success" title="ดูรายการชำระ" data-toggle="modal" data-target="#modal-Popup" data-backdrop="static" data-keyboard="false" data-link="{{ route('MasterCompro.show',[$value->id]) }}?viewData={{'oldpayment'}}">
                              <i class="far fa-eye"></i>
                            </button>
                         
                          </td>
                        </tr>
                        @endforeach

                      <tbody>
                      </tbody>
                    </table>
                    @endif
                    <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600 SubHeading SizeText">หมายเหตุ <span class="textHeader">(Compromise Notes1)</span></h6>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group row mb-0">
                              <textarea name="NotePromise" id="NotePromise" class="form-control form-control-sm SizeText" rows="5">{{@$data->legisCompromise->Note_Promise}}</textarea>
                          </div>
                        </div>
                      </div>
                  </div>
                 
                  @if(@$dataPay!=NULL && count(@$dataPay->legisToFDue)>0)
                  <div id="list-page5-list" class="tab-pane {{ ($FlagTab == '5') ? 'active' : '' }}">
                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">รายการผ่อนชำระ <span class="textHeader">(Instalment Debters)</span></h6>
                    <table class="table table-hover SizeText-1 table-sm table1" id="">
                      <thead>
                        <tr>
                          <th class="text-center" style="width: 20px">งวด</th>
                          <th class="text-center" style="width: 50px">วันดิว</th>
                          <th class="text-center" style="width: 50px">ค่างวด</th>
                          <th class="text-center" style="width: 50px">วันที่รับชำระ</th>
                          <th class="text-center" style="width: 50px">ยอดชำระ</th>
                          <th class="text-center" style="width: 50px">เบี้ยปรับ</th>
                        </tr>
                      </thead>
                      <tbody>
                       
                        @foreach(@$dataPay->legisToFDue as $key => $row)
                          <tr>
                            <td class="text-center"> {{@$row->nopay}} </td>
                            <td class="text-center"> {{ @$row->ddate!=NULL? date('d-m-Y', strtotime($row->ddate)):'' }} </td>
                            <td class="text-center"> {{ @$row->damt!=NULL? number_format($row->damt,2):0 }} </td>
                            <td class="text-center"> {{ @$row->date1!=NULL? date('d-m-Y', strtotime($row->date1)):'' }} </td>
                            <td class="text-center"  > {{ @$row->payment!=NULL? number_format($row->payment,2):0 }} </td>
                            <td class="text-center"  > {{ @$row->intamt!=NULL? number_format($row->intamt,2):0 }} </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>  
                    
                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText"><span class="textHeader"></span></h6>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText text-red">ยอดประนอม :</label>
                            <div class="col-sm-8">
                              <input type="text" value="{{ ($data->legisCompromise != NULL) ?number_format($data->legisCompromise->Total_Promise, 2): '' }}" class="form-control form-control-sm SizeText" readonly/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText text-red">ยอดชำระแล้ว :</label>
                            <div class="col-sm-8">
                              <input type="text" value="{{ ($data->legisCompromise != NULL) ?number_format($Setpaid, 2): '' }}" class="form-control form-control-sm SizeText" readonly/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText text-red">ยอดคงเหลือ :</label>
                            <div class="col-sm-8">
                              <input type="text" value="{{ ($data->legisCompromise != NULL) ?number_format($SetSum, 2): '' }}" class="form-control form-control-sm SizeText" readonly/>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                  @endif
                  <div id="list-page2-list" class="tab-pane {{ ($FlagTab == '2') ? 'active' : '' }}">
                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">รายการผ่อนชำระ <span class="textHeader">(Instalment Debters)</span></h6>
                    <table class="table table-hover SizeText-1 table-sm table1" id="">
                      <thead>
                        <tr>
                          <th class="text-center" style="width: 20px">งวด</th>
                          <th class="text-center" style="width: 50px">วันดิว</th>
                          <th class="text-center" style="width: 50px">ค่างวด</th>
                          <th class="text-center" style="width: 50px">วันที่รับชำระ</th>
                          <th class="text-center" style="width: 50px">ยอดชำระ</th>
                          <th class="text-center" style="width: 50px">เบี้ยปรับ</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if(@$dataPay->legisToDue!=NULL)
                        @foreach(@$dataPay->legisToDue as $key => $row)
                          <tr>
                            <td class="text-center"> {{@$row->nopay}} </td>
                            <td class="text-center"> {{ @$row->ddate!=NULL? date('d-m-Y', strtotime($row->ddate)):'' }} </td>
                            <td class="text-center"> {{ @$row->damt!=NULL? number_format($row->damt,2):0 }} </td>
                            <td class="text-center"> {{ @$row->date1!=NULL? date('d-m-Y', strtotime($row->date1)):'' }} </td>
                            <td class="text-center"  > {{ @$row->payment!=NULL? number_format($row->payment,2):0 }} </td>
                            <td class="text-center"  > {{ @$row->intamt!=NULL? number_format($row->intamt,2):0 }} </td>
                          </tr>
                        @endforeach
                        @else
                        <tr>
                          <td class="text-center">ไม่พบข้อมูล </td>
                          <td class="text-center"> </td>
                          <td class="text-center"> </td>
                          <td class="text-center"> </td>
                          <td class="text-center"> </td>
                          <td class="text-center"> </td>
                        </tr>
                        @endif
                      </tbody>
                    </table>  
                    
                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText"><span class="textHeader"></span></h6>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText text-red">ยอดประนอม :</label>
                            <div class="col-sm-8">
                              <input type="text" value="{{ ($data->legisCompromise != NULL) ?number_format($data->legisCompromise->Total_Promise, 2): '' }}" class="form-control form-control-sm SizeText" readonly/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText text-red">ยอดชำระแล้ว :</label>
                            <div class="col-sm-8">
                              <input type="text" value="{{ ($data->legisCompromise != NULL) ?number_format($Setpaid, 2): '' }}" class="form-control form-control-sm SizeText" readonly/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText text-red">ยอดคงเหลือ :</label>
                            <div class="col-sm-8">
                              <input type="text" value="{{ ($data->legisCompromise != NULL) ?number_format($SetSum, 2): '' }}" class="form-control form-control-sm SizeText" readonly/>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                  <div id="list-page3-list" class="tab-pane {{ ($FlagTab == '3') ? 'active' : '' }}">
                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">รายการผ่อนชำระ <span class="textHeader">(Instalment Debters)</span></h6>
                    
                      <table class="table table-hover SizeText-1 table-sm table2" id="">
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
                         
                          @if(@$dataPay->ComproToPaymentAll)
                         
                          @foreach($dataPay->ComproToPaymentAll as $key => $row)
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
                                @if($row->Gold_Payment < $data->DuePay_Promise)
                                  <span class="badge bg-danger prem">ต่ำกว่าค่างวด</span>
                                @endif
                              </td>
                              {{-- <td class="text-center text-red"> {{ date('d-m-Y', strtotime($row->DateDue_Payment)) }}</td> --}}
                              <td class="text-right"> {{$row->Adduser_Payment}} </td>
                              <td class="text-right">
                                {{-- <a target="_blank" class="btn btn-sm hover-up bg-warning {{ ($row->Flag_Payment != 'Y' or Auth::user()->position != 'MANAGER' and Auth::user()->position != 'Admin') ? 'disabled' : '' }}" data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterCompro.show',$row->id) }}?type={{9}}">
                                  <i class="fa-solid fa-pen-to-square"></i>
                                </a> --}}
                                <a target="_blank" href="{{ route('MasterCompro.show',[$row->id]) }}?type={{11}}" class="btn btn-info btn-sm hover-up" title="พิมพ์ใบเสร็จ">
                                  <i class="fas fa-print"></i>
                                </a>
                                @if(count($dataPay->ComproToPaymentAll)==($key+1))
                                <form method="post" class="delete_form" action="{{ route('MasterCompro.destroy',[$row->id]) }}?type={{2}}" style="display:inline;">
                                {{csrf_field()}}
                                  <input type="hidden" name="_method" value="DELETE" />
                                  <button type="submit" data-name="{{ $row->Jobnumber_Payment }}" class="delete-modal btn btn-danger btn-sm AlertForm hover-up {{ ((auth::user()->type == 'Admin' or auth::user()->type == 'แผนก วิเคราะห์') AND $row->Flag!='C') ? '' : 'disabled' }}" title="ลบรายการ">
                                    <i class="far fa-trash-alt"></i> 
                                  </button>
                                </form>
                                @endif
                              </td>
                            </tr>
                          @endforeach
                          @else
                          <tr>
                            <td class="text-center" >ไม่พบข้อมูล </td>
                            <td class="text-center" > </td>
                            <td class="text-center" > </td>
                            <td class="text-center" > </td>
                            <td class="text-center" > </td>
                            <td class="text-center" > </td>
                          </tr>
                          @endif
                        </tbody>
                      </table> 
                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText"><span class="textHeader"></span></h6>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText text-red">ยอดประนอม :</label>
                            <div class="col-sm-8">
                              <input type="text" value="{{ ($data->legisCompromise != NULL) ?number_format($data->legisCompromise->Total_Promise, 2): '' }}" class="form-control form-control-sm SizeText" readonly/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText text-red">ยอดชำระแล้ว :</label>
                            <div class="col-sm-8">
                              <input type="text" value="{{ ($data->legisCompromise != NULL) ?number_format($Setpaid, 2): '' }}" class="form-control form-control-sm SizeText" readonly/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText text-red">ยอดคงเหลือ :</label>
                            <div class="col-sm-8">
                              <input type="text" value="{{ ($data->legisCompromise != NULL) ?number_format($SetSum, 2): '' }}" class="form-control form-control-sm SizeText" readonly/>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                  <div id="list-page4-list" class="tab-pane {{ ($FlagTab == '4') ? 'active' : '' }}">
                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">บันทึกติดตาม <span class="textHeader">(Tracking Debters)</span></h6>
                      <button type="button" class="btn btn-sm bg-gray SizeText inputButton" data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterCompro.show',[$data->id]) }}?type={{6}}" title="บันทึกติดตาม" {{ (@$data->legisCompromise->Flag_Promise == NULL) ? 'disabled' : '' }}>
                        <i class="fas fa-tags SizeText"></i> ติดตาม
                      </button>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText {{ (@$data->legisTrackings->JobPayment_Track != NULL) ? 'text-success' : 'text-red' }}">Status :</label>
                            <div class="col-sm-8">
                              @if (@$data->legisTrackings->DateDue_Track != NULL )
                                @if(@$data->legisTrackings->DateDue_Track > date('Y-m-d') and @$data->legisTrackings->Status_Track == 'Y')
                                  <input type="text" value="แจ้งกำหนดชำระ" class="form-control form-control-sm SizeText Boxcolor prem text-red"/>
                                @else
                                  @if(@$data->legisTrackings->JobPayment_Track != NULL)
                                    <input type="text" value="ชำระเรียบร้อยแล้ว" class="form-control form-control-sm SizeText Boxcolor-G prem text-success"/>
                                  @else
                                    <input type="text" value="เลยกำหนดชำระ" class="form-control form-control-sm SizeText Boxcolor prem text-red"/>
                                  @endif
                                @endif
                              @else
                                <input type="text" value="ไม่มีการติดตาม" class="form-control form-control-sm SizeText prem text-gray"/>
                              @endif
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText text-red">JobNumber :</label>
                            <div class="col-sm-8">
                              <input type="text" value="{{ @$data->legisTrackings->JobNumber_Track }}" class="form-control form-control-sm SizeText Boxcolor" placeholder="JobNumber"/>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText text-red">สถานะติดตาม :</label>
                            <div class="col-sm-8">
                              <input type="text" value="{{ @$data->legisTrackings->Subject_Track }}" class="form-control form-control-sm SizeText Boxcolor" placeholder="สถานะติดตาม"/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText text-red">วันนัดชำระ :</label>
                            <div class="col-sm-8">
                              <input type="date" value="{{ @$data->legisTrackings->DateDue_Track }}" class="form-control form-control-sm SizeText Boxcolor" placeholder="สถานะติดตาม"/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group row mb-0">
                            <label class="col-sm-2 col-form-label text-right SizeText">รายละเอียด :</label>
                            <div class="col-sm-10">
                              <textarea name="NotePromise" class="form-control form-control-sm SizeText" rows="3">{{ @$data->legisTrackings->Detail_Track }}</textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                      <br>
                      <table class="table table-sm table-hover SizeText-1" id="table2">
                        <thead>
                          <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">วันที่บันทึก</th>
                            <th class="text-center">เลขอ้างอิง</th>
                            <th class="text-center">สถานะ</th>
                            <th class="text-center">วันนัดชำระ</th>
                            <th class="text-center">ผู้บันทึก</th>
                            <th class="text-center"></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($dataTrack as $key => $row)
                            <tr>
                              <td class="text-center"> {{$key+1}} </td>
                              <td class="text-center">{{ date('d-m-Y', strtotime(substr($row->created_at,0,10))) }}</td>
                              <td class="text-center">
                                {{ $row->JobNumber_Track }}
                                @if ($row->JobPayment_Track != NULL)
                                  <span placeholder="ชำระเรียบร้อย">
                                    <i class="fas fa-check-circle float-right text-green prem"></i>
                                  </span>
                                @else
                                  <span placeholder="รอดำเนินการ">
                                    <i class="fas fa-exclamation-circle float-right text-red prem"></i>
                                  </span>
                                @endif
                              </td>
                              <td class="text-center" title="{{$row->Detail_Track}}">{{ $row->Subject_Track }}</td>
                              <td class="text-center">{{ ($row->DateDue_Track != NULL) ?formatDateThai($row->DateDue_Track) : '-' }}</td>
                              <td class="text-right">{{ $row->User_Track }}</td>
                              <td class="text-right">
                              <form method="post" class="delete_form" action="{{ route('MasterCompro.destroy',[$row->id]) }}?type={{3}}" style="display:inline;">
                                {{csrf_field()}}
                                  <input type="hidden" name="_method" value="DELETE" />
                                  <button type="submit" data-name="{{ $row->JobNumber_Track }}" class="delete-modal btn btn-danger btn-sm AlertForm hover-up" title="ลบรายการ">
                                    <i class="far fa-trash-alt"></i>
                                  </button>
                                </form>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  @endif

  <div class="modal fade" id="modal-Popup">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-xl">
      <div class="modal-content bg-default">
        <div class="modal-body">
          <p>One fine body…</p>
        </div>
      </div>
    </div>
  </div>

  <script>
    $('#NotePromise').on('input', function() {
      var SetNotePromise = $('#NotePromise').val();
      console.log(SetNotePromise);

      $('#GetNote').val(SetNotePromise);
    });
    $(function () {
    $('.table1,.table2').DataTable( {
      
      "searching" : true,
      "lengthChange" : true,
      "info" : false,
      "pageLength": 6,
      "order": [[ 0, "asc" ]],
      "dom": 'Blfrtip',
      "buttons": [
        'excel', 'print'
      ]
    });
    // $('.table3').DataTable( {
      
    //   "searching" : false,
    //   "lengthChange" : false,
    //   "info" : false,
    //   "pageLength": 6,
    //   "order": [[ 0, "asc" ]],
      
    // });
  });



    $('.ClearPromise').click(function (evt) {
         var Contract_buyer = $(this).data("name");
         var _token =  $('input[name="_token"]').val();
          var id =  idName = $(this).attr("id");
         console.log(id);
         evt.preventDefault();
         swal({
             title: `${id}`,
             icon: "warning",
             text: "คุณต้องการยืนยันการยกยอดประนอมหรือไม่ ?",
             buttons: true,
             dangerMode: true,
         })
         .then((isConfirm)=>{
             // console.log(isConfirm);
             
             if (isConfirm) {
              $.ajax({
                  url: Contract_buyer,
                  method: "GET",
                  data: {
                    _token: _token,
                    
                  },
                  success: function(result) {
                    swal("ยกยอดประนอมสำเร็จ !", {
                     icon: "success",
                     timer: 5000,
                    })
                    location.reload();
                  }
                })
                
                 
             }
         });
 
     });
  </script>
@endsection

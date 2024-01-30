@extends('layouts.master')
@section('title','ลูกหนี้เตรียมฟ้อง')
@section('content')


  @if(session()->has('success'))
    <script type="text/javascript">
      toastr.success('{{ session()->get('success') }}')
    </script>
  @endif

  <!-- Main content -->
  <section class="Profile-container" style="font-family: 'Prompt', sans-serif;">
    <form name="form1" method="post" action="{{ route('MasterLegis.update',$id) }}" enctype="multipart/form-data">
      @csrf
      @method('put')
      <div class="content">
        <div class="content-header">
          <div class="row">
            <div class="col-8">
              <div class="form-inline">
                <h5>ธุรกรรม ลูกหนี้ <small class="textHeader">(Transactions Debtor)</small></h5>
              </div>
            </div>
            <div class="col-4">
              <div class="card-tools d-inline float-right">
                <!-- <button type="submit" class="btn btn-success btn-sm SizeText hover-up">
                  <i class="fas fa-save"></i> บันทึก
                </button> -->
                @if(auth()->user()->position != "STAFF")
                <button type="button" class="btn btn-sm bg-success SizeText hover-up" data-toggle="modal" data-target="#modal-Popup" data-backdrop="static" data-keyboard="false" data-link="{{ route('MasterExpense.show',[0]) }}?type={{1}}" title="เพิ่มรายการค่าใช้จ่าย">
                  <i class="fas fa-plus"></i> เพิ่ม
                </button>
                <a class="btn btn-danger btn-sm SizeText hover-up" href="{{ route('MasterCompro.index') }}?type={{2}}">
                  <i class="far fa-window-close"></i> กลับ
                </a>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-3">
            <div class="box-shadow">
              <div class="author-card pb-3 pt-3">
                <div class="author-card-cover" style="background-image: url({{ asset('dist/img/bg1.jpg') }})">
                  @if($data->Flag_status == 2)
                    @if($data->Status_legis != NULL)
                      <a href="{{ route('MasterLegis.index') }}?type={{6}}" class="btn btn-style-1 btn-sm hover-up bg-green" data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterLegis.show',$id) }}?type={{2}}">
                        <i class="fas fa-clipboard-check text-md"></i> {{$data->Status_legis}}
                      </a>
                    @else
                      <a href="{{ route('MasterLegis.index') }}?type={{6}}" class="btn btn-style-1 btn-sm hover-up bg-white" data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterLegis.show',$id) }}?type={{2}}">
                        <i class="fas fa-clipboard-check text-md"></i> ปิดบัญชี
                      </a>
                    @endif
                  @else
                    @if($data->Status_legis != NULL)
                      <a class="btn btn-style-1 btn-sm hover-up bg-green" data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterLegis.show',$id) }}?type={{3}}">
                        <i class="fas fa-clipboard-check text-md"></i> {{$data->Status_legis}}
                      </a>
                    @endif
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
                  <a class="list-group-item hover-up {{ ($data->Flag_status == 2) ? '' : 'disabled' }}" href="{{ route('MasterLegis.edit',[$data->id]) }}?type={{4}}">
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
                  <a class="list-group-item hover-up {{ ($data->Flag_status == 2 or $data->Flag == 'C') ? '' : 'disabled' }}" href="{{ route('MasterCompro.edit',[$data->id]) }}?type={{1}}"><i class="fas fa-hand-holding-usd text-muted"></i>ลูกหนี้ ประนอมหนี้</a>
                  <a class="list-group-item hover-up {{ ($data->Flag_status == 2 or $data->Flag == 'C') ? '' : 'disabled' }}" href="{{ route('MasterLegis.edit',[$data->id]) }}?type={{7}}"><i class="fas fa-folder-open text-muted"></i>เอกสาร ลูกหนี้</a>
                  <a class="list-group-item hover-up active {{ ($data->Flag_status == 2) ? '' : 'disabled' }}" href="{{ route('MasterExpense.edit',[$data->id]) }}?type={{1}}">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <i class="fas fa-money-check-alt text-muted"></i>
                        <div class="d-inline-block font-weight-medium text-uppercase">ธุรกรรม ลูกหนี้</div>
                      </div>
                      @if(count($dataExpense) > 0)
                        <i class="far fa-check-square sub-target"></i>
                      @endif
                    </div>
                  </a>
                </nav>
              </div>
            </div>
          </div>
          <div class="col-lg-9">
            <div class="card">
              <div class="card-body text-sm">
                <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">รายการธุรกรรม <span class="textHeader text-red">(ยอดรวม: {{@number_format($Sum,2)}})</span></h6>
                  {{--<div class="row">
                    <div class="col-md-6">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText text-red">เลขที่สัญญา :</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control form-control-sm SizeText" value="{{ $data->Contract_legis }}"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText text-red">ชื่อ - นามสกุล :</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control form-control-sm SizeText" value="{{ $data->Name_legis }}"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText">ปชช.ผู้ซื้อ :</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control form-control-sm SizeText" value="{{ $data->Idcard_legis }}" data-inputmask="&quot;mask&quot;:&quot;9-9999-99999-99-9&quot;" data-mask=""/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText">เบอร์ติดต่อ :</label>
                        <div class="col-sm-8">
                          <input type="text" name="Phonelegis" class="form-control form-control-sm SizeText" value="{{ (iconv('TIS-620', 'utf-8', @$data1->TELP)) }}"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText">วันที่ทำสัญญา :</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control form-control-sm SizeText" value="{{date('d-m-Y', strtotime($data->DateDue_legis))}}"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText">ป้ายทะเบียน :</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control form-control-sm SizeText" value="{{ $data->register_legis }}"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText">ยี่ห้อ :</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control form-control-sm SizeText" value="{{ $data->BrandCar_legis }}"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText">ปีรถ :</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control form-control-sm SizeText" value="{{ $data->YearCar_legis }}"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText">ประเภทรถ :</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control form-control-sm SizeText" value="{{ $data->Category_legis }}"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText">เลขไมล์ :</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control form-control-sm SizeText" value="{{ number_format($data->Mile_legis, 2) }}"/>
                        </div>
                      </div>
                    </div>
                  </div>--}}
                  <div class="row">
                    <div class="col-md-12">
                      <table class="table table-hover SizeText" id="tableD">
                        <thead>
                          <tr>
                            <!-- <th class="text-center" style="width: 10px">ลำดับ</th> -->
                            <th class="text-center">วันที่เบิก</th>
                            <th class="text-center">เลขใบเสร็จ</th>
                            <th class="text-center">ประเภท คชจ.</th>
                            <th class="text-center">เรื่อง</th>
                            <th class="text-center">ค่าใช้จ่าย</th>
                            <th class="text-center">ผู้เบิก</th>
                            <!-- <th class="text-center" style="width: 150px">หมายเหตุ</th> -->
                            <th class="text-center">#</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($dataExpense as $key => $row)
                            <tr>
                              <!-- <td class="text-center">{{$key+1}}</td> -->
                              <td class="text-center">{{date('d-m-Y',strtotime($row->Date_expense))}}</td>
                              <td class="text-left">
                                @if($row->Flag_expense == 'wait')
                                  <Span class="text-red">{{$row->Receiptno_expense}}</Span>
                                @elseif($row->Flag_expense == 'complete')
                                  <span class="text-success" data-toggle="tooltip" data-placement="top" title="วันอนุมัติ : {{FormatDatethai($row->DateApprove_expense)}}">
                                    {{$row->Receiptno_expense}}
                                  </span>
                                @endif
                              </td>
                              <td class="text-left">{{$row->Type_expense}}</td>
                              <td class="text-left">{{$row->Topic_expense}}</td>
                              <td class="text-right">{{@number_format($row->Amount_expense,2)}}</td>
                              <td class="text-left">{{$row->Useradd_expense}}</td>
                              <!-- <td class="text-left">{{$row->Note_expense}}</td> -->
                              <td class="text-right">
                                <a target="_Blank" href="{{ route('MasterExpense.show',[$row->id]) }}?type={{4}}&Flagtype={{1}}&Groupcode={{$row->Code_expense}}" class="btn btn-warning btn-sm hover-up" title="ปริ้นใบเสร็จ">
                                  <i class="fas fa-print"></i>
                                </a>
                                @if(auth()->user()->position != "STAFF")
                                <form method="post" class="delete_form" action="{{ route('MasterExpense.destroy',[$row->id]) }}" style="display:inline;">
                                {{csrf_field()}}
                                  <input type="hidden" name="type" value="1" />
                                  <input type="hidden" name="_method" value="DELETE" />
                                  <button type="submit" data-name="{{ $row->Receiptno_expense }}" class="delete-modal btn btn-danger btn-sm DeleteBook hover-up" title="ลบรายการ">
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
          </div>
        </div>
      </div>
      <input type="hidden" value="3" name="type">
      <input type="hidden" name="_method" value="PATCH"/>
    </form>
  </section>

  <div class="modal fade" id="modal-Popup">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
        </div>
      </div>
    </div>
  </div>
@endsection

@extends('layouts.master')
@section('title','ลูกหนี้เตรียมฟ้อง')
@section('content')

  <link rel="stylesheet" href="{{ asset('css/pluginLegislations.css') }}">

  <style>
    #todo-list{
      width:100%;
      margin:0 auto 50px auto;
      padding:5px;
      background:white;
      position:relative;
      /*box-shadow*/
      -webkit-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3);
      -moz-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3);
            box-shadow:0 1px 4px rgba(0, 0, 0, 0.3);
      /*border-radius*/
      -webkit-border-radius:5px;
      -moz-border-radius:5px;
            border-radius:5px;
    }
    #todo-list:before{
      content:"";
      position:absolute;
      z-index:-1;
      /*box-shadow*/
      -webkit-box-shadow:0 0 20px rgba(0,0,0,0.4);
      -moz-box-shadow:0 0 20px rgba(0,0,0,0.4);
            box-shadow:0 0 20px rgba(0,0,0,0.4);
      top:50%;
      bottom:0;
      left:10px;
      right:10px;
      /*border-radius*/
      -webkit-border-radius:100px / 10px;
      -moz-border-radius:100px / 10px;
            border-radius:100px / 10px;
    }
    .todo-wrap{
      display:block;
      position:relative;
      padding-left:35px;
      /*box-shadow*/
      -webkit-box-shadow:0 2px 0 -1px #ebebeb;
      -moz-box-shadow:0 2px 0 -1px #ebebeb;
            box-shadow:0 2px 0 -1px #ebebeb;
    }
    .todo-wrap:last-of-type{
      /*box-shadow*/
      -webkit-box-shadow:none;
      -moz-box-shadow:none;
            box-shadow:none;
    }
    input[type="checkbox"]{
      position:absolute;
      height:0;
      width:0;
      opacity:0;
      /* top:-600px; */
    }
    .todo{
      display:inline-block;
      font-weight:200;
      padding:10px 5px;
      height:37px;
      position:relative;
    }
    .todo:before{
      content:'';
      display:block;
      position:absolute;
      top:calc(50% + 10px);
      left:0;
      width:0%;
      height:1px;
      background:#cd4400;
      /*transition*/
      -webkit-transition:.25s ease-in-out;
      -moz-transition:.25s ease-in-out;
        -o-transition:.25s ease-in-out;
            transition:.25s ease-in-out;
    }
    .todo:after{
      content:'';
      display:block;
      position:absolute;
      z-index:0;
      height:18px;
      width:18px;
      top:9px;
      left:-25px;
      /*box-shadow*/
      -webkit-box-shadow:inset 0 0 0 2px #d8d8d8;
      -moz-box-shadow:inset 0 0 0 2px #d8d8d8;
            box-shadow:inset 0 0 0 2px #d8d8d8;
      /*transition*/
      -webkit-transition:.25s ease-in-out;
      -moz-transition:.25s ease-in-out;
        -o-transition:.25s ease-in-out;
            transition:.25s ease-in-out;
      /*border-radius*/
      -webkit-border-radius:4px;
      -moz-border-radius:4px;
            border-radius:4px;
    }
    .todo:hover:after{
      /*box-shadow*/
      -webkit-box-shadow:inset 0 0 0 2px #949494;
      -moz-box-shadow:inset 0 0 0 2px #949494;
            box-shadow:inset 0 0 0 2px #949494;
    }
    .todo .fa-check{
      position:absolute;
      z-index:1;
      left:-31px;
      top:0;
      font-size:1px;
      line-height:36px;
      width:36px;
      height:36px;
      text-align:center;
      color:transparent;
      text-shadow:1px 1px 0 white, -1px -1px 0 white;
    }
    :checked + .todo{
      color:#717171;
    }
    :checked + .todo:before{
      width:100%;
    }
    :checked + .todo:after{
      /*box-shadow*/
      -webkit-box-shadow:inset 0 0 0 2px #0eb0b7;
      -moz-box-shadow:inset 0 0 0 2px #0eb0b7;
            box-shadow:inset 0 0 0 2px #0eb0b7;
    }
    :checked + .todo .fa-check{
      font-size:20px;
      line-height:35px;
      color:#0eb0b7;
    }
  </style>

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
                <h5>ลูกหนี้เตรียมฟ้อง <small class="textHeader">(Prepare Debtor)</small></h5>
              </div>
            </div>
            <div class="col-4">
              <div class="card-tools d-inline float-right">
                @if($data->Flag_status == 1)
                  <button type="button" class="delete-modal btn btn-info btn-sm SizeText hover-up" data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterLegis.show',$id) }}?type={{1}}">
                    <i class="fas fa-share-square"></i> ยื่นฟ้อง
                  </button>
                @endif
                <button type="submit" class="btn btn-success btn-sm SizeText hover-up">
                  <i class="fas fa-save"></i> บันทึก
                </button>
                <a href="{{ route('MasterLegis.edit',$id) }}?type={{13}}" data-name="{{ $data->Contract_legis }}" class="btn btn-danger btn-sm SizeText hover-up DeleteCompro" title="ลบรายการ">
                  <i class="far fa-trash-alt"></i> ลบ
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-3">
            <div class="box-shadow">
              <div class="author-card pb-3 pt-3">
                @if(auth()->user()->position =='Admin')
                <div class="author-card-cover" style="background-image: url({{ asset('dist/img/bg1.jpg') }})">
                  @php
                    if ($data->Flag_status == 2) {
                      $Settype = 2;
                    }else {
                      $Settype = 3;
                    }
                  @endphp
                  @if($data->Status_legis != NULL)
                    <a href="{{ route('MasterLegis.index') }}?type={{6}}" class="btn btn-style-1 btn-sm hover-up bg-green" data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterLegis.show',$id) }}?type={{$Settype}}">
                      <i class="fas fa-clipboard-check text-md"></i> {{$data->Status_legis}}
                    </a>
                  @else
                    <a href="{{ route('MasterLegis.index') }}?type={{6}}" class="btn btn-style-1 btn-sm hover-up bg-white" data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterLegis.show',$id) }}?type={{2}}">
                      <i class="fas fa-clipboard-check text-md"></i> ปิดบัญชี
                    </a>
                  @endif
                </div>
                @endif
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
                  <a class="list-group-item active hover-up" href="#">
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
                  <a class="list-group-item hover-up {{ ($data->Flag_status == 2) ? '' : 'disabled' }}" href="{{ route('MasterExpense.edit',[$data->id]) }}?type={{1}}">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <i class="fas fa-money-check-alt text-muted"></i>
                        <div class="d-inline-block font-weight-medium text-uppercase">ธุรกรรม ลูกหนี้</div>
                      </div>
                      @if($data->LegisExpense != NULL)
                        <i class="far fa-check-square sub-target"></i>
                      @endif
                    </div>
                  </a>
                </nav>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card">
              <div class="card-body text-sm">
                <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ข้อมูลลูกหนี้ <span class="textHeader">(Profiles Debtors)</span></h6>
                  <div class="row">
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
                          <input type="text" name="phone" class="form-control form-control-sm SizeText" value="{{ @$data->Phone_legis }}"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText">ที่อยู่ :</label>
                        <div class="col-sm-8">
                          <input type="text" name="address" class="form-control form-control-sm SizeText" value="{{ @$data->Address_legis }}"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText">วันนำเข้าระบบ :</label>
                        <div class="col-sm-8">
                          <input type="date" class="form-control form-control-sm SizeText" value="{{ $data->Date_legis }}" readonly/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText">ชื่อผู้ค้ำ :</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control form-control-sm SizeText" value="{{ @$data->NameGT_legis }}"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText">ปชช.ผู้ค่ำ :</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control form-control-sm SizeText" value="{{ @$data->IdcardGT_legis }}" data-inputmask="&quot;mask&quot;:&quot;9-9999-99999-99-9&quot;" data-mask=""/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText text-red">ประเภทลูกหนี้ :</label>
                        <div class="col-sm-8">
                          <select name="TypeCus_Flag" class="form-control form-control-sm SizeText Boxcolor" required>
                            <option value="" selected>--- ประเภทลูกหนี้ ---</option>
                            <option value="Y" {{ ($data->Flag == 'Y') ? 'selected' : '' }}>1. ลูกหนี้งานฟ้อง</option>
                            <option value="C" {{ ($data->Flag == 'C') ? 'selected' : '' }}>2. ลูกหนี้ประนอมหนี้/หลุดขายฝาก</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText text-red">สถานะลูกหนี้ :</label>
                        <div class="col-sm-8">
                          <select class="form-control form-control-sm SizeText" readonly>
                            <option value="" selected>--- สถานะลูกหนี้ ---</option>
                            <option value="1" {{ ($data->Flag_status == 1) ? 'selected' : '' }}>เตรียมฟ้อง</option>
                            <option value="2" {{ ($data->Flag_status == 2) ? 'selected' : '' }}>ส่งฟ้อง</option>
                            <option value="3" {{ ($data->Flag_status == 3) ? 'selected' : '' }}>ประนอมหนี้</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>

                <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600 SubHeading SizeText">ข้อมูลทรัพย์ <span class="textHeader">(Asset Details)</span></h6>
                  @if ($data->TypeCon_legis == 'P01')
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row mb-0">
                          <label class="col-sm-4 col-form-label text-right SizeText">ประเภทโฉนด :</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm SizeText" value="{{ @$data->BrandCar_legis }}"/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row mb-0">
                          <label class="col-sm-4 col-form-label text-right SizeText">เลขที่โฉนด :</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm SizeText" value="{{ @$data->register_legis }}"/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row mb-0">
                          <label class="col-sm-4 col-form-label text-right SizeText">เลขทีดิน :</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm SizeText" value="{{ @$data->YearCar_legis }}"/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row mb-0">
                          <label class="col-sm-4 col-form-label text-right SizeText">หน้าสำรวจ :</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm SizeText" value="{{ @$data->Category_legis }}"/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row mb-0">
                          <label class="col-sm-4 col-form-label text-right SizeText">เล่ม-หน้า :</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm SizeText" value="{{ @$data->Mile_legis }}"/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row mb-0">
                          <label class="col-sm-4 col-form-label text-right SizeText">ขนาดที่ดิน :</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm SizeText" value="{{ @$data->Realty_legis }}"/>
                          </div>
                        </div>
                      </div>
                    </div>
                  @else
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row mb-0">
                          <label class="col-sm-4 col-form-label text-right SizeText">ป้ายทะเบียน :</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm SizeText" value="{{ @$data->register_legis }}"/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row mb-0">
                          <label class="col-sm-4 col-form-label text-right SizeText">ยี่ห้อ :</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm SizeText" value="{{ @$data->BrandCar_legis }}"/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row mb-0">
                          <label class="col-sm-4 col-form-label text-right SizeText">ปีรถ :</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm SizeText" value="{{ @$data->YearCar_legis }}"/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row mb-0">
                          <label class="col-sm-4 col-form-label text-right SizeText">ประเภทรถ :</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm SizeText" value="{{ @$data->Category_legis }}"/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row mb-0">
                          <label class="col-sm-4 col-form-label text-right SizeText">เลขไมล์ :</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm SizeText" value="{{ number_format(@$data->Mile_legis, 0) }}"/>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endif

                <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600 SubHeading SizeText">ข้อมูลการจัด <span class="textHeader">(Finance Details)</span></h6>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText">วันที่ทำสัญญา :</label>
                        <div class="col-sm-8">
                          <input type="date" class="form-control form-control-sm SizeText" value="{{ @$data->DateCon_legis }}"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText">ยอดทั้งสัญญา :</label>
                        <div class="col-sm-8">
                          <input type="text" name="TopPrice_legis" class="form-control form-control-sm SizeText" value="{{ number_format(@$data->TopPrice_legis ,2) }}"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText">เงินต้น :</label>
                        <div class="col-sm-8">
                          <input type="text" name="Pay_legis" class="form-control form-control-sm SizeText" value="{{ number_format(@$data->Pay_legis ,2) }}"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText">ดอกเบี้ย-ปี :</label>
                        <div class="col-sm-8">
                          <input type="text" name="Interest_legis" class="form-control form-control-sm SizeText" value="{{ @$data->Interest_legis }}"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText">ค่าผ่อน :</label>
                        <div class="col-sm-8">
                          <input type="text" name="Period_legis" class="form-control form-control-sm SizeText" value="{{ number_format(@$data->Period_legis, 2) }}"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText">งวดทั้งหมด :</label>
                        <div class="col-sm-8">
                          <input type="text" name="Countperiod_legis" class="form-control form-control-sm SizeText" value="{{@$data->Countperiod_legis }}"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText">ยอดชำระแล้ว :</label>
                        <div class="col-sm-8">
                          <input type="text" name="Beforemoey_legis" class="form-control form-control-sm SizeText" value="{{ number_format(@$data->Beforemoey_legis, 2) }}"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText">คงเหลือ :</label>
                        <div class="col-sm-8">
                          <input type="text" name="Sumperiod_legis" class="form-control form-control-sm SizeText" value="{{ number_format(@$data->Sumperiod_legis, 2) }}"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group row mb-0">
                        <label class="col-sm-2 col-form-label text-right SizeText">หมายเหตุ :</label>
                        <div class="col-sm-10">
                          <textarea name="Noteby_legis" class="form-control form-control-sm SizeText" rows="5">{{ @$data->Noteby_legis }}</textarea>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="card">
              <div class="card-body text-sm">
                <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ทั่วไป <span class="textHeader">(Generals)</span></h6>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText text-red">วันที่รับ :</label>
                        <div class="col-sm-8">
                          <input type="date" value="{{ @$data->Date_legis }}" class="form-control form-control-sm SizeText" readonly/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText text-red">วันที่ส่ง :</label>
                        <div class="col-sm-8">
                          <input type="date" value="{{ @$data->Datesend_Flag }}" class="form-control form-control-sm SizeText" readonly/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText text-red">วันที่หยุด :</label>
                        <div class="col-sm-8">
                          <input type="date" name="dateStopRev" value="{{ @$data->dateStopRev }}" class="form-control form-control-sm SizeText" {{@$data->dateStopRev!=NULL?'readonly':''}}/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText text-red">วันที่ตัดหนี้ 0 :</label>
                        <div class="col-sm-8">
                          <input type="date" name="dateCutOff" value="{{ @$data->dateCutOff }}" class="form-control form-control-sm SizeText" {{@$data->dateCutOff!=NULL?'readonly':''}}/>
                        </div>
                      </div>
                    </div>
                  </div>
                <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600 SubHeading SizeText">เอกสาร <span class="textHeader">(Documents)</span></h6>
                  <div class="row">
                    <div id="todo-list">
                    <span class="todo-wrap SizeText">
                        <input type="checkbox" id="1" name="Twoduelist" value="{{(@$data->Twodue_list !== NULL) ?$data->Twodue_list : 'on' }}" {{ ($data->Twodue_list !== NULL) ? 'checked' : '' }}/>
                        <label for="1" class="todo"><i class="fa fa-check"></i>หนังสือ 2 งวด</label>
                      </span>
                      <span class="todo-wrap SizeText">
                        <input type="checkbox" id="2" name="AcceptTwoduelist" value="{{(@$data->AcceptTwodue_list !== NULL) ?$data->AcceptTwodue_list : 'on' }}" {{ ($data->AcceptTwodue_list !== NULL) ? 'checked' : '' }}/>
                        <label for="2" class="todo"><i class="fa fa-check"></i>ใบตอบรับหนังสือ 2 งวด</label>
                      </span>
                      <span class="todo-wrap SizeText">
                        <input type="checkbox" id="3" name="Terminatebuyerlist" value="{{(@$data->Terminatebuyer_list !== NULL) ?$data->Terminatebuyer_list : 'on' }}" {{ ($data->Terminatebuyer_list !== NULL) ? 'checked' : '' }}/>
                        <label for="3" class="todo"><i class="fa fa-check"></i>หนังสือบอกเลิกผู้ซื้อ - ผู้ค้ำ</label>
                      </span>
                      <span class="todo-wrap SizeText">
                        <input type="checkbox" id="4" name="Acceptbuyerandsuplist" value="{{(@$data->Acceptbuyerandsup_list !== NULL) ?$data->Acceptbuyerandsup_list : 'on' }}" {{ ($data->Acceptbuyerandsup_list !== NULL) ? 'checked' : '' }}/>
                        <label for="4" class="todo"><i class="fa fa-check"></i>ใบตอบรับผู้ซื้อ - ผู้ค้ำ</label>
                      </span>
                      <span class="todo-wrap SizeText">
                        <input type="checkbox" id="5" name="Noticelist" value="{{(@$data->Notice_list !== NULL) ?$data->Notice_list : 'on' }}" {{ ($data->Notice_list !== NULL) ? 'checked' : '' }}/>
                        <label for="5" class="todo"><i class="fa fa-check"></i>หนังสือโนติสผู้ซื้อ - ผู้ค้ำ</label>
                      </span>
                      <span class="todo-wrap SizeText">
                        <input type="checkbox" id="6" name="AcceptTwoNoticelist" value="{{(@$data->AcceptTwoNotice_list !== NULL) ?$data->AcceptTwoNotice_list : 'on' }}" {{ ($data->AcceptTwoNotice_list !== NULL) ? 'checked' : '' }}/>
                        <label for="6" class="todo"><i class="fa fa-check"></i>ใบตอบรับโนติสผู้ซื้อ - ผู้ค้ำ</label>
                      </span>
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

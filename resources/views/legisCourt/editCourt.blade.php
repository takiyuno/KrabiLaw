@extends('layouts.master')
@section('title','กฏหมาย/ลูกหนี้ชั้นศาล')
@section('content')

  <style>
    #todo-list{
      width:100%;
      margin:0 auto 50px auto;
      padding:5px;
      background:white;
      /* position:relative; */
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

  <style>
    [type="radio"]:checked,
    [type="radio"]:not(:checked) {
        position: absolute;
        left: -9999px;
    }
    [type="radio"]:checked + label,
    [type="radio"]:not(:checked) + label
    {
        position: relative;
        padding-left: 28px;
        cursor: pointer;
        line-height: 30px;
        display: inline-block;
        color: #666;
    }
    [type="radio"]:checked + label:before,
    [type="radio"]:not(:checked) + label:before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 25px;
        height: 25px;
        border: 1px solid #ddd;
        border-radius: 100%;
        background: #fff;
    }
    [type="radio"]:checked + label:after,
    [type="radio"]:not(:checked) + label:after {
        content: '';
        width: 16px;
        height: 16px;
        background: #ff0000;
        position: absolute;
        top: 4px;
        left: 4px;
        border-radius: 100%;
        -webkit-transition: all 0.2s ease;
        transition: all 0.2s ease;
    }
    [type="radio"]:not(:checked) + label:after {
        opacity: 0;
        -webkit-transform: scale(0);
        transform: scale(0);
    }
    [type="radio"]:checked + label:after {
        opacity: 1;
        -webkit-transform: scale(1);
        transform: scale(1);
    }
  </style>

  @if(session()->has('success'))
    <script type="text/javascript">
      toastr.success('{{ session()->get('success') }}')
    </script>
  @endif

  <!-- Main content -->
  <section class="Profile-container" style="font-family: 'Prompt', sans-serif;">
    <form name="form1" method="post" action="{{ route('MasterLegis.update',[$data->id]) }}" enctype="multipart/form-data">
      @csrf
      @method('put')
      <input type="hidden" name="type" value="4">
      <input type="hidden" name="_method" value="PATCH"/>
      <input type="hidden" name="FlagTab"/>

      <div class="content">
        <div class="content-header">
          <div class="row">
            <div class="col-8">
              <div class="form-inline">
                <h5>ลูกหนี้ชั้นศาล  <small class="textHeader">(Court Debtor)</small></h5>
              </div>
            </div>
            <div class="col-4">
              <div class="card-tools d-inline float-right">
                <button type="submit" class="btn btn-success btn-sm SizeText hover-up">
                  <i class="fas fa-save"></i> บันทึก
                </button>
                @if (isset($FlagPage))
                  @if ($FlagPage == 4)
                    <a class="btn btn-sm bg-gray color-palette SizeText hover-up" href="{{ route('MasterLegis.index') }}?type={{4}}&dateSearch={{$dateSearch}}&FlagTab={{$FlagTab}}">
                      <i class="fas fa-chevron-left"></i> Back
                    </a>
                  @endif
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
                      <a class="btn btn-style-1 btn-sm hover-up bg-green" data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterLegis.show',$id) }}?type={{2}}">
                        <i class="fas fa-clipboard-check text-md"></i> {{$data->Status_legis}}
                      </a>
                    @else
                      <a class="btn btn-style-1 btn-sm hover-up bg-white" data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterLegis.show',$id) }}?type={{2}}">
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
                  <a class="list-group-item active hover-up {{ ($data->Flag_status == 2) ? '' : 'disabled' }}" href="#">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <i class="fas fa-balance-scale text-muted"></i>
                        <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ ชั้นศาล</div>
                      </div>
                      @if($data->Flag_Class === "สถานะคัดหนังสือรับรองคดี" or $data->Flag_Class === 'สถานะสืบทรัพย์บังคับคดี' or $data->Flag_Class === 'สถานะคัดโฉนด' or $data->Flag_Class === 'สถานะตั้งยึดทรัพย์' or $data->Flag_Class === 'ประกาศขายทอดตลาด' or $data->Flag_Class === 'จบงานชั้นบังคับคดี')
                        <i class="far fa-check-square sub-target"></i>
                      @endif
                    </div>
                  </a>
                  <a class="list-group-item hover-up {{ ($data->Flag_status == 2) ? '' : 'disabled' }}" href="{{ route('MasterLegis.edit',[$data->id]) }}?type={{5}}">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <i class="fas fa-link text-muted"></i>
                        <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ ชั้นบังคับคดี </div>
                      </div>
                      @if($data->Flag_Class === 'จบงานชั้นบังคับคดี')
                        <i class="far fa-check-square sub-target"></i>
                      @endif
                    </div>
                  </a>
                  <a class="list-group-item hover-up {{ ($data->Flag_status == 2) ? '' : 'disabled' }}" href="{{ route('MasterLegis.edit',[$data->id]) }}?type={{6}}">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <i class="fas fa-search-location text-muted"></i>
                        <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ สินทรัพย์</div>
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
          <div class="col-lg-9">
            <div class="card">
              <div class="card-body text-sm">
                <div class="row">
                  <div class="col-md-12">
                    <ul class="nav nav-tabs" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link SizeText {{ ($FlagTab === 1) ? 'actives active' : '' }}" id="vert-tabs-1-tab" data-toggle="tab" href="#list-page1-list">
                          @if($data->Flag_Class === 'สถานะส่งสืบพยาน' or $data->Flag_Class === 'สถานะส่งคำบังคับ' or $data->Flag_Class === 'สถานะส่งตรวจผลหมาย' or $data->Flag_Class === 'สถานะส่งตั้งเจ้าพนักงาน' or $data->Flag_Class === 'สถานะส่งตรวจผลหมายตั้ง' or $data->Flag_Class === 'สถานะคัดหนังสือรับรองคดี' or $data->Flag_Class === 'สถานะสืบทรัพย์บังคับคดี' or $data->Flag_Class === 'สถานะคัดโฉนด' or $data->Flag_Class === 'สถานะตั้งยึดทรัพย์' or $data->Flag_Class === 'ประกาศขายทอดตลาด' or $data->Flag_Class === 'จบงานชั้นบังคับคดี')
                            <i class="far fa-check-square text-success"></i>
                          @endif  
                          ฟ้อง
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link SizeText {{ ($FlagTab === 2) ? 'actives active' : '' }}" id="vert-tabs-2-tab" data-toggle="tab" href="#list-page2-list">
                          @if($data->Flag_Class === 'สถานะส่งคำบังคับ' or $data->Flag_Class === 'สถานะส่งตรวจผลหมาย' or $data->Flag_Class === 'สถานะส่งตั้งเจ้าพนักงาน' or $data->Flag_Class === 'สถานะส่งตรวจผลหมายตั้ง' or $data->Flag_Class === 'สถานะคัดหนังสือรับรองคดี' or $data->Flag_Class === 'สถานะสืบทรัพย์บังคับคดี' or $data->Flag_Class === 'สถานะคัดโฉนด' or $data->Flag_Class === 'สถานะตั้งยึดทรัพย์' or $data->Flag_Class === 'ประกาศขายทอดตลาด' or $data->Flag_Class === 'จบงานชั้นบังคับคดี')
                            <i class="far fa-check-square text-success"></i>
                          @endif
                          สืบพยาน
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link SizeText {{ ($FlagTab === 3) ? 'actives active' : '' }}" id="vert-tabs-3-tab" data-toggle="tab" href="#list-page3-list">
                          @if($data->Consent_court == NULL)
                            @if($data->Flag_Class === 'สถานะส่งตรวจผลหมาย' or $data->Flag_Class === 'สถานะส่งตั้งเจ้าพนักงาน' or $data->Flag_Class === 'สถานะส่งตรวจผลหมายตั้ง' or $data->Flag_Class === 'สถานะคัดหนังสือรับรองคดี' or $data->Flag_Class === 'สถานะสืบทรัพย์บังคับคดี' or $data->Flag_Class === 'สถานะคัดโฉนด' or $data->Flag_Class === 'สถานะตั้งยึดทรัพย์' or $data->Flag_Class === 'ประกาศขายทอดตลาด' or $data->Flag_Class === 'จบงานชั้นบังคับคดี')
                              <i class="far fa-check-square text-success"></i>
                            @endif
                          @else
                            @if($data->Flag_Class === 'สถานะส่งตรวจผลหมาย' or $data->Flag_Class === 'สถานะส่งตั้งเจ้าพนักงาน' or $data->Flag_Class === 'สถานะส่งตรวจผลหมายตั้ง' or $data->Flag_Class === 'สถานะคัดหนังสือรับรองคดี' or $data->Flag_Class === 'สถานะสืบทรัพย์บังคับคดี' or $data->Flag_Class === 'สถานะคัดโฉนด' or $data->Flag_Class === 'สถานะตั้งยึดทรัพย์' or $data->Flag_Class === 'ประกาศขายทอดตลาด' or $data->Flag_Class === 'จบงานชั้นบังคับคดี')
                            <i class="fas fa-unlink text-muted"></i>
                            @endif
                          @endif
                          ส่งคำบังคับ
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link SizeText {{ ($FlagTab === 4) ? 'actives active' : '' }}" id="vert-tabs-4-tab" data-toggle="tab" href="#list-page4-list">
                          @if($data->Consent_court == NULL)
                            @if($data->Flag_Class === 'สถานะส่งตั้งเจ้าพนักงาน' or $data->Flag_Class === 'สถานะส่งตรวจผลหมายตั้ง' or $data->Flag_Class === 'สถานะคัดหนังสือรับรองคดี' or $data->Flag_Class === 'สถานะสืบทรัพย์บังคับคดี' or $data->Flag_Class === 'สถานะคัดโฉนด' or $data->Flag_Class === 'สถานะตั้งยึดทรัพย์' or $data->Flag_Class === 'ประกาศขายทอดตลาด' or $data->Flag_Class === 'จบงานชั้นบังคับคดี')
                              <i class="far fa-check-square text-success"></i>
                            @endif
                          @else
                            @if($data->Flag_Class === 'สถานะส่งตั้งเจ้าพนักงาน' or $data->Flag_Class === 'สถานะส่งตรวจผลหมายตั้ง' or $data->Flag_Class === 'สถานะคัดหนังสือรับรองคดี' or $data->Flag_Class === 'สถานะสืบทรัพย์บังคับคดี' or $data->Flag_Class === 'สถานะคัดโฉนด' or $data->Flag_Class === 'สถานะตั้งยึดทรัพย์' or $data->Flag_Class === 'ประกาศขายทอดตลาด' or $data->Flag_Class === 'จบงานชั้นบังคับคดี')
                              <i class="fas fa-unlink text-muted"></i>
                            @endif
                          @endif
                          ตรวจผลหมาย
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link SizeText {{ ($FlagTab === 5) ? 'actives active' : '' }}" id="vert-tabs-5-tab" data-toggle="tab" href="#list-page5-list">
                          @if($data->Flag_Class === 'สถานะส่งตรวจผลหมายตั้ง' or $data->Flag_Class === 'สถานะคัดหนังสือรับรองคดี'  or $data->Flag_Class === 'สถานะตั้งยึดทรัพย์' or $data->Flag_Class === 'จบงานชั้นบังคับคดี')
                            <i class="far fa-check-square text-success"></i>
                          @endif
                          ตั้งเจ้าพนักงาน
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link SizeText {{ ($FlagTab === 6) ? 'actives active' : '' }}" id="vert-tabs-6-tab" data-toggle="tab" href="#list-page6-list">
                          @if($data->Flag_Class === 'สถานะสืบทรัพย์บังคับคดี' or $data->Flag_Class == 'สถานะคัดหนังสือรับรองคดี' or $data->Flag_Class === 'สถานะคัดโฉนด' or $data->Flag_Class === 'สถานะตั้งยึดทรัพย์' or $data->Flag_Class === 'ประกาศขายทอดตลาด' or $data->Flag_Class === 'จบงานชั้นบังคับคดี')
                            <i class="far fa-check-square text-success"></i>
                          @endif
                          ต.ผลหมายตั้ง
                        </a>
                      </li>
                    </ul>
                  </div>
                  <br/><br/><br/>
                  <div class="col-md-12">
                    <div class="tab-content">
                      <div id="list-page1-list" class="container tab-pane {{ ($FlagTab === 1) ? 'active' : '' }}">
                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ขั้นตอนฟ้อง <span class="textHeader">(45-60 วัน)</span></h6>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group row mb-0">
                                <label class="col-sm-4 col-form-label text-right SizeText">วันที่ฟ้อง :</label>
                                <div class="col-sm-8">
                                  <input type="date" id="fillingdatecourt" name="fillingdatecourt" class="form-control form-control-sm SizeText" value="{{ ($data->legiscourt->fillingdate_court) }}"/>
                                </div>

                                <label class="col-sm-4 col-form-label text-right SizeText">ศาล :</label>
                                <div class="col-sm-8">
                                  <select name="lawcourt" class="form-control form-control-sm SizeText">
                                    <option value="" selected>--- ศาล ---</option>
                                    <option value="ศาลแขวงกระบี่" {{ ($data->legiscourt->law_court === 'ศาลแขวงกระบี่') ? 'selected' : '' }}>01. ศาลแขวงกระบี่</option>
                                    <option value="ศาลแขวงตรัง" {{ ($data->legiscourt->law_court === 'ศาลแขวงตรัง') ? 'selected' : '' }}>02 .ศาลแขวงตรัง</option>
                                    <option value="ศาลแขวงพังงา" {{ ($data->legiscourt->law_court === 'ศาลแขวงพังงา') ? 'selected' : '' }}>03. ศาลแขวงพังงา</option>
                                    <option value="ศาลแขวงภูเก็ต" {{ ($data->legiscourt->law_court === 'ศาลแขวงภูเก็ต') ? 'selected' : '' }}>04. ศาลแขวงภูเก็ต</option>
                                    <option value="ศาลแขวงนครศรีธรรมราช" {{ ($data->legiscourt->law_court === 'ศาลแขวงนครศรีธรรมราช') ? 'selected' : '' }}>05. ศาลแขวงนครศรีธรรมราช</option>
                                    <option value="ศาลแขวงสุราษฎร์ธานี" {{ ($data->legiscourt->law_court === 'ศาลแขวงสุราษฎร์ธานี') ? 'selected' : '' }}>06. ศาลแขวงสุราษฎร์ธานี</option>
                                    <option value="ศาลจังหวัดกระบี่" {{ ($data->legiscourt->law_court === 'ศาลจังหวัดกระบี่') ? 'selected' : '' }}>07. ศาลจังหวัดกระบี่</option>
                                    <option value="ศาลจังหวัดตรัง" {{ ($data->legiscourt->law_court === 'ศาลจังหวัดตรัง') ? 'selected' : '' }}>08 .ศาลจังหวัดตรัง</option>
                                    <option value="ศาลจังหวัดพังงา" {{ ($data->legiscourt->law_court === 'ศาลจังหวัดพังงา') ? 'selected' : '' }}>09. ศาลจังหวัดพังงา</option>
                                    <option value="ศาลจังหวัดภูเก็ต" {{ ($data->legiscourt->law_court === 'ศาลจังหวัดภูเก็ต') ? 'selected' : '' }}>10. ศาลจังหวัดภูเก็ต</option>
                                    <option value="ศาลจังหวัดนครศรีธรรมราช" {{ ($data->legiscourt->law_court === 'ศาลจังหวัดนครศรีธรรมราช') ? 'selected' : '' }}>11. ศาลจังหวัดนครศรีธรรมราช</option>
                                    <option value="ศาลจังหวัดสุราษฎร์ธานี" {{ ($data->legiscourt->law_court === 'ศาลจังหวัดสุราษฎร์ธานี') ? 'selected' : '' }}>12. ศาลจังหวัดสุราษฎร์ธานี</option>
                                  </select>
                                </div>

                                <label class="col-sm-4 col-form-label text-right SizeText">ทุนทรัพย์ :</label>
                                <div class="col-sm-8">
                                  <input type="text" id="capitalcourt" name="capitalcourt" class="form-control form-control-sm SizeText" value="{{ ($data->legiscourt->capital_court != '') ? number_format($data->legiscourt->capital_court, 2) : '' }}" oninput="CalculateCap();"/>
                                </div>

                                <label class="col-sm-4 col-form-label text-right SizeText">ค่าทนาย :</label>
                                <div class="col-sm-8">
                                  <input type="text" id="pricelawyercourt" name="pricelawyercourt" class="form-control form-control-sm SizeText" value="{{ ($data->legiscourt->pricelawyer_court != '') ? number_format($data->legiscourt->pricelawyer_court, 2) : '' }}" />
                                </div>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group row mb-0">
                                <label class="col-sm-4 col-form-label text-right SizeText">เลขคดีดำ :</label>
                                <div class="col-sm-8">
                                  <input type="text" name="bnumbercourt" class="form-control form-control-sm SizeText" value="{{ ($data->legiscourt->bnumber_court) }}" />
                                </div>

                                <label class="col-sm-4 col-form-label text-right SizeText">เลขคดีแดง :</label>
                                <div class="col-sm-8">
                                  <input type="text" name="rnumbercourt" class="form-control form-control-sm SizeText" value="{{ ($data->legiscourt->rnumber_court) }}"  />
                                </div>

                                <label class="col-sm-4 col-form-label text-right SizeText">ค่าฟ้อง :</label>
                                <div class="col-sm-8">
                                  <input type="text" id="indictmentcourt" name="indictmentcourt" class="form-control form-control-sm SizeText" value="{{ ($data->legiscourt->indictment_court != '') ? number_format($data->legiscourt->indictment_court, 2) : '' }}" oninput="CalculateCap();"/>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-info">
                                  <div class="card-header">
                                    <h6><i class="fas fa-tasks"></i> สถานะ (Next Status)</h6>
                                  </div>
                                  <div class="card-body">
                                    <div class="col-md-12">
                                        <span class="todo-wrap SizeText">
                                          <input type="checkbox" id="11" name="FlagClass" value="สถานะส่งสืบพยาน" {{ ($data->Flag_Class === 'สถานะส่งสืบพยาน' or $data->Flag_Class === 'สถานะส่งคำบังคับ' or $data->Flag_Class === 'สถานะส่งตรวจผลหมาย' or $data->Flag_Class === 'สถานะส่งตั้งเจ้าพนักงาน' or $data->Flag_Class === 'สถานะส่งตรวจผลหมายตั้ง' or $data->Flag_Class === 'สถานะคัดหนังสือรับรองคดี' or $data->Flag_Class === 'สถานะสืบทรัพย์บังคับคดี' or $data->Flag_Class === 'สถานะคัดโฉนด' or $data->Flag_Class === 'สถานะตั้งยึดทรัพย์' or $data->Flag_Class === 'ประกาศขายทอดตลาด' or $data->Flag_Class === 'จบงานชั้นบังคับคดี') ? 'checked' : '' }}/>
                                          <label for="11" class="todo">
                                            <i class="fa fa-check"></i> Prosecute (ส่งสืบพยาน)
                                          </label>
                                        </span>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                      </div>
                      <div id="list-page2-list" class="container tab-pane {{ ($FlagTab === 2) ? 'active' : '' }}">
                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ขั้นตอนสืบพยาน <span class="textHeader">(30 วัน)</span></h6>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group row mb-0">
                                <label class="col-sm-4 col-form-label text-right SizeText">วันที่สืบพยาน :</label>
                                <div class="col-sm-8">
                                  <input type="date" id="examidaycourt" name="examidaycourt" class="form-control form-control-sm SizeText" value="{{ ($data->legiscourt->examiday_court) }}" oninput="CourtDate();" />
                                </div>
                              </div>
                              <div class="form-group row mb-0">
                                <label class="col-sm-4 col-form-label text-right SizeText">ศาลสั่งจ่าย :</label>
                                <div class="col-sm-8">
                                  <input type="text" id="adjudicate_price" name="adjudicate_price" class="form-control form-control-sm SizeText" value="{{ ($data->legiscourt->adjudicate_price != '') ? number_format($data->legiscourt->adjudicate_price, 2) : '' }}" oninput="CalculateCap();"/>
                                </div>                             
                          </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group row mb-0">
                                <label class="col-sm-4 col-form-label text-right SizeText">วันเลือน :</label>
                                <div class="col-sm-8">
                                  <input type="date" id="fuzzycourt" name="fuzzycourt" class="form-control form-control-sm SizeText" value="{{ ($data->legiscourt->fuzzy_court) }}" oninput="CourtDate();" />
                                </div>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="card card-info">
                                <div class="card-header SizeText">
                                  <h6><i class="fas fa-tasks"></i> สถานะ (Next Status)</h6>
                                </div>
                                <div class="card-body">
                                  <div class="col-md-12">
                                    <span class="todo-wrap SizeText">
                                      @if($data->Consent_court == NULL)
                                      <input type="checkbox" id="12" name="FlagClass" value="สถานะส่งคำบังคับ" {{ ($data->Flag_Class === 'สถานะส่งคำบังคับ' or $data->Flag_Class === 'สถานะส่งตรวจผลหมาย' or $data->Flag_Class === 'สถานะส่งตั้งเจ้าพนักงาน' or $data->Flag_Class === 'สถานะส่งตรวจผลหมายตั้ง'or $data->Flag_Class === 'สถานะคัดหนังสือรับรองคดี' or $data->Flag_Class === 'สถานะสืบทรัพย์บังคับคดี' or $data->Flag_Class === 'สถานะคัดโฉนด' or $data->Flag_Class === 'สถานะตั้งยึดทรัพย์' or $data->Flag_Class === 'ประกาศขายทอดตลาด' or $data->Flag_Class === 'จบงานชั้นบังคับคดี') ? 'checked' : '' }}/>
                                      @else
                                      <input type="checkbox" id="12" name="FlagClass" value="สถานะส่งคำบังคับ"/>
                                      @endif
                                      <label for="12" class="todo">
                                        <i class="fa fa-check"></i> Prosecute (ส่งคำบังคับ)
                                      </label>
                                    </span>
                                    <span class="todo-wrap SizeText">
                                      <input type="checkbox" id="19" name="Consent" value="ลูกหนี้ยินยอม" {{ ($data->legiscourt->Consent_court == 'ลูกหนี้ยินยอม') ? 'checked' : '' }}/>
                                      <label for="19" class="todo">
                                        <i class="fa fa-check"></i> Consent (ยินยอม)
                                      </label>
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                         
                      </div>
                      <div id="list-page3-list" class="container tab-pane {{ ($FlagTab === 3) ? 'active' : '' }}">
                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ขั้นตอนส่งคำบังคับ <span class="textHeader">(45 วัน)</span></h6>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group row mb-0">
                                <label class="col-sm-4 col-form-label text-right SizeText">วันที่จากระบบ :</label>
                                <div class="col-sm-8">
                                  <input type="date" id="orderdaycourt" name="orderdaycourt" class="form-control form-control-sm SizeText" value="{{ ($data->legiscourt->orderday_court) }}" readonly/>
                                </div>
                              </div>                              
                            </div>

                            <div class="col-md-4">
                              <div class="form-group row mb-0">
                                <label class="col-sm-4 col-form-label text-right SizeText">วันส่งจริง :</label>
                                <div class="col-sm-8">
                                  <input type="date" id="ordersendcourt" name="ordersendcourt" class="form-control form-control-sm SizeText" value="{{ ($data->legiscourt->ordersend_court) }}" oninput="CourtDate();" />
                                </div>
                              </div>
                             
                              
                            </div>
                            
                            <div class="col-md-4">
                              <div class="card card-info">
                                <div class="card-header SizeText">
                                  <h6><i class="fas fa-tasks"></i> สถานะ (Next Status)</h6>
                                </div>
                                <div class="card-body">
                                  <div class="col-md-12">
                                    <span class="todo-wrap SizeText">
                                      @if($data->Consent_court == NULL)
                                        <input type="checkbox" id="13" name="FlagClass" value="สถานะส่งตรวจผลหมาย" {{ ($data->Flag_Class === 'สถานะส่งตรวจผลหมาย' or $data->Flag_Class === 'สถานะคัดหนังสือรับรองคดี' or $data->Flag_Class === 'สถานะส่งตั้งเจ้าพนักงาน' or $data->Flag_Class ==='สถานะส่งตรวจผลหมายตั้ง' or $data->Flag_Class === 'สถานะสืบทรัพย์บังคับคดี' or $data->Flag_Class === 'สถานะคัดโฉนด' or $data->Flag_Class === 'สถานะตั้งยึดทรัพย์' or $data->Flag_Class === 'ประกาศขายทอดตลาด' or $data->Flag_Class === 'จบงานชั้นบังคับคดี') ? 'checked' : '' }}/>
                                      @else 
                                        <input type="checkbox" id="13" name="FlagClass" value="สถานะส่งตรวจผลหมาย"/>
                                      @endif
                                      <label for="13" class="todo">
                                        <i class="fa fa-check"></i> Prosecute (ส่งตรวจผลหมาย)
                                      </label>
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                      </div>
                      <div id="list-page4-list" class="container tab-pane {{ ($FlagTab === 4) ? 'active' : '' }}">
                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ขั้นตอนตรวจผลหมาย <span class="textHeader">(45 วัน)</span></h6>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group row mb-0">
                                <label class="col-sm-4 col-form-label text-right SizeText">วันที่ตรวจ :</label>
                                <div class="col-sm-8">
                                  <input type="date" id="checkdaycourt" name="checkdaycourt" class="form-control form-control-sm SizeText" value="{{ ($data->legiscourt->checkday_court) }}" oninput="CourtDate2();" readonly/>
                                </div>
                              </div>

                              @if($data->legiscourt->social_flag == 'infomation' or $data->legiscourt->social_flag == NULL)
                                <div id="DivRadio1" style="display:none;">
                              @else
                                <div id="myDIV">
                              @endif
                                <div class="form-group row mb-0">
                                  <label class="col-sm-4 col-form-label text-right SizeText">ผู้ซื้อได้รับ :</label>
                                  <div class="col-sm-8">
                                    <input type="date" id="buyercourt" name="buyercourt" class="form-control form-control-sm SizeText" value="{{ ($data->legiscourt->buyer_court) }}" oninput="CourtDate2();"/>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group row mb-0">
                                <label class="col-sm-4 col-form-label text-right SizeText">วันตรวจจริง :</label>
                                <div class="col-sm-8">
                                  <input type="date" id="checksendcourt" name="checksendcourt" class="form-control form-control-sm SizeText" value="{{ ($data->legiscourt->checksend_court) }}" onchange="CourtDate2();" />
                                </div>

                                @if($data->legiscourt->social_flag == 'infomation' or $data->legiscourt->social_flag == NULL)
                                  <div id="DivRadio2" style="display:none;">
                                @else
                                  <div id="myDIV">
                                @endif
                                  <div class="form-group row mb-0">
                                    <label class="col-sm-4 col-form-label text-right SizeText">ผู้ค้ำ 1 ได้รับ :</label>
                                    <div class="col-sm-8">
                                      <input type="date" id="supportcourt" name="supportcourt" class="form-control form-control-sm SizeText" value="{{ ($data->legiscourt->support_court) }}" oninput="CourtDate2();"/>
                                    </div>
                                    <label class="col-sm-4 col-form-label text-right SizeText">ผู้ค้ำ 2 ได้รับ :</label>
                                    <div class="col-sm-8">
                                      <input type="date" id="support1court" name="support1court" class="form-control form-control-sm SizeText" value="{{ ($data->legiscourt->support1_court) }}" oninput="CourtDate2();"/>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="card card-info">
                                <div class="card-header SizeText">
                                  <h6><i class="fas fa-tasks"></i> สถานะ (Next Status)</h6>
                                </div>
                                <div class="card-body">
                                  <div class="col-md-12">
                                    <span class="todo-wrap SizeText">
                                      @if($data->Consent_court == NULL)
                                        <input type="checkbox" id="14" name="FlagClass" value="สถานะส่งตั้งเจ้าพนักงาน" {{ ($data->Flag_Class === 'สถานะส่งตั้งเจ้าพนักงาน' or $data->Flag_Class === 'สถานะส่งตรวจผลหมายตั้ง' or $data->Flag_Class === 'สถานะสืบทรัพย์บังคับคดี' or $data->Flag_Class === 'สถานะคัดหนังสือรับรองคดี' or $data->Flag_Class === 'สถานะคัดโฉนด' or $data->Flag_Class === 'สถานะตั้งยึดทรัพย์' or $data->Flag_Class === 'ประกาศขายทอดตลาด' or $data->Flag_Class === 'จบงานชั้นบังคับคดี') ? 'checked' : '' }}/>
                                      @else 
                                        <input type="checkbox" id="14" name="FlagClass" value="สถานะส่งตั้งเจ้าพนักงาน"/>
                                      @endif
                                      <label for="14" class="todo">
                                        <i class="fa fa-check"></i> Prosecute (ส่งตั้งเจ้าพนักงาน)
                                      </label>
                                    </span>
                                    <input type="radio" id="socialflag1" name="socialflag" class="socialflag" value="infomation" onclick="CourtDate2();hiddenDivRadio();" {{ ($data->legiscourt->social_flag == 'infomation') ? 'checked' : '' }}/>
                                    <label for="socialflag1" class="ml-sm-2 mr-sm-2 SizeText"> ประกาศสื่ออิเล็กทรอนิกส์</label>
                                    <br>
                                    <input type="radio" id="socialflag2" name="socialflag" class="socialflag" value="success"  onclick="ShowDivRadio();" {{ ($data->legiscourt->social_flag == 'success') ? 'checked' : '' }}/>
                                    <label for="socialflag2" class="ml-sm-2 mr-sm-2 SizeText"> ได้รับผลหมายทั้งคู่</label>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                      </div>
                      <div id="list-page5-list" class="container tab-pane {{ ($FlagTab === 5) ? 'active' : '' }}">
                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ขั้นตอนตั้งเจ้าพนักงาน <span class="textHeader">(45 วัน)</span></h6>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group row mb-0">
                                <label class="col-sm-4 col-form-label text-right SizeText">วันทีจากระบบ :</label>
                                <div class="col-sm-8">
                                  <input type="date" id="setofficecourt" name="setofficecourt" class="form-control form-control-sm SizeText" value="{{ $data->legiscourt->setoffice_court }}" readonly/>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group row mb-0">
                                <label class="col-sm-4 col-form-label text-right SizeText">วันที่ส่งจริง :</label>
                                <div class="col-sm-8">
                                  <input type="date" id="sendofficecourt" name="sendofficecourt" class="form-control form-control-sm SizeText" value="{{ $data->legiscourt->sendoffice_court }}" oninput="SendofficeDate();"/>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="card card-info">
                                <div class="card-header SizeText">
                                  <h6><i class="fas fa-tasks"></i> สถานะ (Next Status)</h6>
                                </div>
                                <div class="card-body">
                                  <div class="col-md-12">
                                      <span class="todo-wrap SizeText">
                                        <input type="checkbox" id="15" name="FlagClass" value="สถานะส่งตรวจผลหมายตั้ง" {{ ($data->Flag_Class === 'สถานะส่งตรวจผลหมายตั้ง' or $data->Flag_Class === 'สถานะคัดหนังสือรับรองคดี' or $data->Flag_Class === 'สถานะสืบทรัพย์บังคับคดี' or $data->Flag_Class === 'สถานะคัดโฉนด' or $data->Flag_Class === 'สถานะตั้งยึดทรัพย์' or $data->Flag_Class === 'ประกาศขายทอดตลาด' or $data->Flag_Class === 'จบงานชั้นบังคับคดี') ? 'checked' : '' }}/>
                                        <label for="15" class="todo">
                                          <i class="fa fa-check"></i>
                                          Prosecute (ส่งตรวจผลหมายตั้ง)
                                        </label>
                                      </span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                      </div>
                      <div id="list-page6-list" class="container tab-pane {{ ($FlagTab === 6) ? 'active' : '' }}">
                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ขั้นตอนตรวจผลหมายตั้ง <span class="textHeader">(45 วัน)</span></h6>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group row mb-0">
                                <label class="col-sm-4 col-form-label text-right SizeText">วันทีจากระบบ :</label>
                                <div class="col-sm-8">
                                  <input type="date" id="checkresultscourt" name="checkresultscourt" class="form-control form-control-sm SizeText" value="{{ $data->legiscourt->checkresults_court }}" readonly/>
                                </div>
                                <label class="col-sm-4 mb-3 col-form-label text-right SizeText">ผลตรวจ :</label>
                                <div class="col-sm-8">
                                  <input type="radio" id="test3" name="radio-receivedflag" value="Y" onclick="hiddenDivRadio()" {{ ($data->legiscourt->received_court === 'Y') ? 'checked' : '' }} />
                                  <label for="test3" class="mr-sm-3 SizeText">ได้รับ</label>
                                  <input type="radio" id="test4" name="radio-receivedflag" value="N" onclick="ShowDivRadio()" {{ ($data->legiscourt->received_court === 'N') ? 'checked' : '' }}/>
                                  <label for="test4" class="mr-sm-3 SizeText">ไม่ได้รับ</label>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group row mb-0">
                                <label class="col-sm-4 col-form-label text-right SizeText">วันที่ตรวจจริง :</label>
                                <div class="col-sm-8">
                                  <input type="date" id="sendcheckresultscourt" name="sendcheckresultscourt" class="form-control form-control-sm SizeText" value="{{ $data->legiscourt->sendcheckresults_court }}"/>
                                </div>
                              </div>

                              @if($data->legiscourt->received_court == "Y" or $data->legiscourt->received_court == Null)
                                <div id="myDIV" style="display:none;">
                              @else
                                <div id="myDIV">
                              @endif
                                <div class="form-group row mb-3">
                                  <label class="col-sm-4 col-form-label text-right SizeText">วันทีโทร :</label>
                                  <div class="col-sm-8">
                                    <input type="date" id="telresultscourt" name="telresultscourt" class="form-control form-control-sm SizeText" value="{{ $data->legiscourt->telresults_court }}" />
                                  </div>
                                  <label class="col-sm-4 col-form-label text-right SizeText">วันทีไปรับ :</label>
                                  <div class="col-sm-8">
                                    <input type="date" id="dayresultscourt" name="dayresultscourt" class="form-control form-control-sm SizeText" value="{{ $data->legiscourt->dayresults_court }}"/>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="card card-info">
                                <div class="card-header SizeText">
                                  <h6><i class="fas fa-tasks"></i> สถานะ (Next Status)</h6>
                                </div>
                                <div class="card-body">
                                  <div class="col-md-12">
                                    <span class="todo-wrap SizeText">
                                      <input type="checkbox" id="16" name="FlagClass" value="สถานะคัดหนังสือรับรองคดี" {{ ($data->Flag_Class === 'สถานะสืบทรัพย์บังคับคดี' or $data->Flag_Class === 'สถานะคัดหนังสือรับรองคดี' or $data->Flag_Class === 'สถานะคัดโฉนด' or $data->Flag_Class === 'สถานะตั้งยึดทรัพย์' or $data->Flag_Class === 'ประกาศขายทอดตลาด' or $data->Flag_Class === 'จบงานชั้นบังคับคดี') ? 'checked' : '' }}/>
                                      <label for="16" class="todo">
                                        <i class="fa fa-check"></i> Prosecute (ส่งชั้นบังคับคดี)
                                      </label>
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                      </div>
                      <h6 class="m-b-20 m-t-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">หมายเหตุ <span class="textHeader">(Court Notes)</span></h6>
                      <div class="form-group row mb-0">
                        <textarea name="suenotecourt" class="form-control form-control-sm SizeText" rows="8">{{ ($data->legiscourt->SueNote_court) }}</textarea>
                      </div>
                    </div>
                  </div>
                </div>
                
              </div>
            </div>
          </div>
        </div>
      </div>
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

  {{-- process ชั้นศาล --}}
  <script>
    function CourtDate(){
      //---------- วันสืบพยาน --------
        var date1 = document.getElementById('examidaycourt').value;   //วันที่สืบพยาน
        var fannydate = document.getElementById('fuzzycourt').value;
        var orderdaycourt = document.getElementById('orderdaycourt').value;
        var ordersenddate = document.getElementById('ordersendcourt').value;

        if (date1 != '') {
          var newdate = new Date(date1);
          if (fannydate != '') {
            var newdate = new Date(fannydate);
          }
        }else if (fannydate != '') {
          var newdate = new Date(fannydate);
        }

        newdate.setDate(newdate.getDate() + 30);
        var dd = newdate.getDate();
        var mm = newdate.getMonth() + 1;
        var yyyy = newdate.getFullYear();

        if (dd < 10) {
          var Newdd = '0' + dd;
        }else {
          var Newdd = dd;
        }
        if (mm < 10) {
          var Newmm = '0' + mm;
        }else {
          var Newmm = mm;
        }
        var result = yyyy + '-' + Newmm + '-' + Newdd;

        document.getElementById('orderdaycourt').value = result;
      //---------- end -------------

      //---------- วันส่งคำบังคับ ------
        var date2 = document.getElementById('orderdaycourt').value;           //วันที่จากระบบ
        var ordersenddate = document.getElementById('ordersendcourt').value;  //วันที่ส่งจริง 

        if (date2 != '') {
          var newdate = new Date(date2);
          if (ordersenddate != '') {
            var newdate = new Date(ordersenddate);
          }
        }else if (ordersenddate != '') {
          var newdate = new Date(ordersenddate);
        }

        newdate.setDate(newdate.getDate() + 45);
        var dd = newdate.getDate();
        var mm = newdate.getMonth() + 1;
        var yyyy = newdate.getFullYear();

        if (dd < 10) {
          var Newdd = '0' + dd;
        }else {
          var Newdd = dd;
        }
        if (mm < 10) {
          var Newmm = '0' + mm;
        }else {
          var Newmm = mm;
        }
        var result = yyyy + '-' + Newmm + '-' + Newdd;
        document.getElementById('checkdaycourt').value = result;
      //---------- end -------------
    }
    // ฟังชันคำนวณ วันที่จาก การเลือก checkbox
    function CourtDate2(){
      var date = document.getElementById('checkdaycourt').value;            //วันที่ตรวจ
      var checksendcourt = document.getElementById('checksendcourt').value; //วันตรวจจริง
      
      var buyercourt = document.getElementById('buyercourt').value;         //ผู้ซื้อได้รับ
      var supportcourt = document.getElementById('supportcourt').value;     //ผู้ค้ำ 1 ได้รับ
      var support1court = document.getElementById('support1court').value;   //ผู้ค้ำ 2 ได้รับ
      var messageFlag = document.querySelector('input[name="socialflag"]:checked').value;

      if (messageFlag == 'infomation') {    //ประกาศสื่ออิเล็กทรอนิกส์
        if (date != '') {
          var newdate = new Date(date);
          if (checksendcourt != '') {
            var newdate = new Date(checksendcourt);
          }
        }else if (checksendcourt != '') {
          var newdate = new Date(checksendcourt);
        }

        newdate.setDate(newdate.getDate() + 15);
        var dd = newdate.getDate();
        var mm = newdate.getMonth() + 1;
        var yyyy = newdate.getFullYear();

        if (dd < 10) {
          var Newdd = '0' + dd;
        }else {
          var Newdd = dd;
        }
        if (mm < 10) {
          var Newmm = '0' + mm;
        }else {
          var Newmm = mm;
        }
        var result = yyyy + '-' + Newmm + '-' + Newdd;
        document.getElementById('setofficecourt').value = result;
      }
      else if(messageFlag == 'success') {   //ได้รับผลหมายทั้งคู่
        if (buyercourt >= supportcourt && buyercourt >= support1court) {
          var newdate = new Date(buyercourt);
        }
        else if (supportcourt >= buyercourt && supportcourt >= support1court) {
          var newdate = new Date(supportcourt);
        }
        else if (support1court >= buyercourt && support1court >= supportcourt) {
          var newdate = new Date(support1court);
        }

        newdate.setDate(newdate.getDate() + 45);
        var dd = newdate.getDate();
        var mm = newdate.getMonth() + 1;
        var yyyy = newdate.getFullYear();

        if (dd < 10) {
          var Newdd = '0' + dd;
        }else {
          var Newdd = dd;
        }
        if (mm < 10) {
          var Newmm = '0' + mm;
        }else {
          var Newmm = mm;
        }
        var result = yyyy + '-' + Newmm + '-' + Newdd;
        document.getElementById('setofficecourt').value = result;
      }
      //---------- ตรวจผลหมายตั้ง ------
        var sendoffice = document.getElementById('sendofficecourt').value;

        if (result != '') {
          var newdate = new Date(result);
          if (sendoffice != '') {
            var newdate = new Date(sendoffice);
          }
        }else if (sendoffice != '') {
          var newdate = new Date(sendoffice);
        }

        newdate.setDate(newdate.getDate() + 45);
        var dd = newdate.getDate();
        var mm = newdate.getMonth() + 1;
        var yyyy = newdate.getFullYear();

        if (dd < 10) {
          var Newdd = '0' + dd;
        }else {
          var Newdd = dd;
        }
        if (mm < 10) {
          var Newmm = '0' + mm;
        }else {
          var Newmm = mm;
        }
        var result = yyyy + '-' + Newmm + '-' + Newdd;
        document.getElementById('checkresultscourt').value = result;
      //---------- end -------------

    }
    //---------- ตั้งเจ้าพนักงาน ------
    function SendofficeDate(){
      var checkresultscourt = document.getElementById('checkresultscourt').value;
      var sendoffice = document.getElementById('sendofficecourt').value;

        if (checkresultscourt != '') {
          var newdate = new Date(checkresultscourt);
          if (sendoffice != '') {
            var newdate = new Date(sendoffice);
          }
        }else if (sendoffice != '') {
          var newdate = new Date(sendoffice);
        }

        newdate.setDate(newdate.getDate() + 45);
        var dd = newdate.getDate();
        var mm = newdate.getMonth() + 1;
        var yyyy = newdate.getFullYear();

        if (dd < 10) {
          var Newdd = '0' + dd;
        }else {
          var Newdd = dd;
        }
        if (mm < 10) {
          var Newmm = '0' + mm;
        }else {
          var Newmm = mm;
        }
        var result = yyyy + '-' + Newmm + '-' + Newdd;
        document.getElementById('checkresultscourt').value = result;
    }
    function CalculateCap(){
        var cap = document.getElementById('capitalcourt').value;
        var Setcap = cap.replace(",","");
        var ind = document.getElementById('indictmentcourt').value;
        var Setind = ind.replace(",","");

        var Sumcap = (Setcap * 0.1);

        // if(!isNaN(Setcap)){
        //     document.form1.capitalcourt.value = addCommas(Setcap);
        //     document.form1.pricelawyercourt.value = addCommas(Sumcap.toFixed(2));
        // }
        // if(!isNaN(Setind)){
        //     document.form1.indictmentcourt.value = addCommas(Setind);
        // }
    }
  </script>
@endsection

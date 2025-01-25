@extends('layouts.master')
@section('title','กฏหมาย/ลูกหนี้ชั้นบังคับคดี')
@section('content')

<style>
  .readonly-div {
    background-color: #f9f9f9;
    color: #666;
    pointer-events: none; /* Prevent interaction like clicks */
  }
 
    #todo-list{
      width:100%;
      /* margin:0 auto 50px auto; */
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

  <style>
    .icetab {
      border: 2px solid #292929;
      display: inline-block; 
      border-bottom: 0px;	
      margin: 0px;	
      color: #000;
      cursor: pointer;
      border-right: 0px;
      border-right: 2px solid #292929;
    }

    #icetab-content {
      overflow: hidden;
      position: relative;
      border-top: 0px solid #292929;
      box-shadow:0 3px 10px rgba(0,0,0,.3);
    }
    .box-shadow {
      padding: 5px;
      box-shadow:0 3px 10px rgba(0,0,0,.3);
    }
    .tabcontent {
      position: absolute;
      left: 0px;
      top: 0px;
      background: #fff;
      width: 100%;
      border-top: 0px;
      border: 2px solid #dad9d7;
      border-top: 0px;
      transform: translateY(-100%);
      -moz-transform: translateY(-100%);
      -webkit-transform: translateY(-100%);
    }

    .tabcontent:first-child {
      position: relative;	
    }
    .tabcontent.tab-active {
      border-top: 0px;
      display: block;
      transform: translateY(0%);
      -moz-transform: translateY(0%);
      -webkit-transform: translateY(0%);
    }
    .title {
      color: #292929;
      text-align: center;
      letter-spacing: 14px;
      text-transform: uppercase;
      font-size: 17px;
      margin: 5px 0px;
      margin-bottom: 40px;
    }

    .icetab {
      padding: 10px;
      text-transform: uppercase;
      letter-spacing: 2px;
      background-color:#def2ee;
      font-size: 12px;
    }
    .current-tab { 
      background: #292929;
      color:#fff;
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
      <input type="hidden" name="type" value="5">
      <input type="hidden" name="contract" value="{{ $data->Contract_legis }}">
      <input type="hidden" name="_method" value="PATCH"/>

      <div class="content">
        <div class="content-header">
          <div class="row">
            <div class="col-8">
              <div class="form-inline">
                <h5>ลูกหนี้ชั้นบังคับคดี <small class="textHeader">(Courtcase Debtor)</small></h5>
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
                  <a class="list-group-item  hover-up {{ ($data->Flag_status == 2) ? '' : 'disabled' }}" href="{{ route('MasterLegis.edit',[$data->id]) }}?type={{4}}">
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
                  <a class="list-group-item active hover-up {{ ($data->Flag_status == 2) ? '' : 'disabled' }}" href="#">
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
          {{--<div class="col-lg-6">
            <div class="card">
              <div class="card-body text-sm">
                <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ขั้นตอนที่ 1 เตรียมเอกสาร <span class="textHeader">(30 วัน)</span></h6>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText">วันที่คัดฉโหนด :</label>
                        <div class="col-sm-8 mb-5">
                          <input type="date" id="datepreparedoc" name="datepreparedoc" class="form-control form-control-sm SizeText" value="{{ @$data->legiscourtCase->datepreparedoc_case }}"/>
                        </div>
                      </div>
                    </div>
                  </div>
                <h6 class="m-b-20 m-t-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ขั้นตอนที่ 2 ตั้งเรื่องยึดทรัพย์ <span class="textHeader">(180 วัน)</span></h6>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText">วันที่จากระบบ :</label>
                        <div class="col-sm-8">
                          <input type="date" id="DateSequester" name="DateSequester" class="form-control form-control-sm SizeText" value="{{ @$data->legiscourtCase->dateSequester_case }}" readonly/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText">วันที่ตั้งเรื่องยึด :</label>
                        <div class="col-sm-8">
                          <input type="date" id="DatesetSequester" name="DatesetSequester" class="form-control form-control-sm SizeText" value="{{ @$data->legiscourtCase->datesetsequester_case }}" />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText text-red">สถานะบังคับคดี :</label>
                        <div class="col-sm-8">
                          <select id="StatusCase" name="StatusCase" class="form-control form-control-sm SizeText Boxcolor">
                            <option value="" selected>--- สถานะ ---</option>
                            <option value="ถอนบังคับคดีปิดบัญชี" {{ (@$data->legiscourtCase->Status_case === 'ถอนบังคับคดีปิดบัญชี') ? 'selected' : '' }}>ถอนบังคับคดีปิดบัญชี</option>
                            <option value="ถอนบังคับคดียึดรถ" {{ (@$data->legiscourtCase->Status_case === 'ถอนบังคับคดียึดรถ') ? 'selected' : '' }}>ถอนบังคับคดียึดรถ</option>
                            <option value="ประนอมหลังยึดทรัพย์" {{ (@$data->legiscourtCase->Status_case === 'ประนอมหลังยึดทรัพย์') ? 'selected' : '' }}>ประนอมหลังยึดทรัพย์</option>
                            <option value="ถอนบังคับคดียอดเหลือน้อย" {{ (@$data->legiscourtCase->Status_case === 'ถอนบังคับคดียอดเหลือน้อย') ? 'selected' : '' }}>ถอนบังคับคดียอดเหลือน้อย</option>
                            <option value="ถอนบังคับคดีขายเต็มจำนวน" {{ (@$data->legiscourtCase->Status_case === 'ถอนบังคับคดีขายเต็มจำนวน') ? 'selected' : '' }}>ถอนบังคับคดีขายเต็มจำนวน</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group row mb-0">
                        <label class="col-sm-4 col-form-label text-right SizeText">ประกาศขาย :</label>
                        <div class="col-sm-8 mb-5">
                          <select id="ResultSequester" name="ResultSequester" class="form-control form-control-sm SizeText">
                            <option value="" selected>--- เลือกผลการประกาศขาย ---</option>
                            <option value="ขายได้" {{ (@$data->legiscourtCase->resultsequester_case === 'ขายได้') ? 'selected' : '' }}>ขายได้</option>
                            <option value="ขายไม่ได้" {{ (@$data->legiscourtCase->resultsequester_case === 'ขายไม่ได้') ? 'selected' : '' }}>ขายไม่ได้</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      @if(@$data->legiscourtCase->resultsequester_case == 'ขายได้')
                        <div id="ShowDetail2">
                      @else
                        <div id="ShowDetail2" style="display:none;">
                      @endif
                        <div class="form-group row mb-0">
                          <label class="col-sm-4 col-form-label text-right SizeText">ผลจากการขาย :</label>
                          <div class="col-sm-4">
                            <select id="ResultSell" name="ResultSell" class="form-control form-control-sm SizeText">
                              <option value="" selected>--- เลือกผลจากการขาย ---</option>
                              <option value="เต็มจำนวน" {{ (@$data->legiscourtCase->resultsell_case === 'เต็มจำนวน') ? 'selected' : '' }}>เต็มจำนวน</option>
                              <option value="ไม่เต็มจำนวน" {{ (@$data->legiscourtCase->resultsell_case === 'ไม่เต็มจำนวน') ? 'selected' : '' }}>ไม่เต็มจำนวน</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      @if(@$data->legiscourtCase->resultsell_case == 'เต็มจำนวน')
                      <div id="ShowSellDetail1">
                      @else
                      <div id="ShowSellDetail1" style="display:none;">
                      @endif
                        <div class="form-group row mb-0">
                          <label class="col-sm-4 col-form-label text-right SizeText">วันที่ขายได้ :</label>
                          <div class="col-sm-4">
                            <input type="date" id="Datesoldout" name="Datesoldout" class="form-control form-control-sm SizeText" value="{{@$data->legiscourtCase->datesoldout_case}}" />
                          </div>
                        </div>
                      </div>
                      @if(@$data->legiscourtCase->resultsell_case == 'ไม่เต็มจำนวน')
                      <div id="ShowSellDetail2">
                      @else
                      <div id="ShowSellDetail2" style="display:none;">
                      @endif
                        <div class="form-group row mb-0">
                          <label class="col-sm-4 col-form-label text-right SizeText">จำนวนเงิน :</label>
                          <div class="col-sm-4">
                            <input type="text" id="Amountsequester" name="Amountsequester" class="form-control form-control-sm SizeText" value="{{number_format(@$data->amountsequester_case,0)}}" />
                          </div>
                        </div>
                      </div>

                      @if(@$data->legiscourtCase->resultsequester_case == 'ขายไม่ได้')
                      <div id="ShowDetail1">
                      @else
                      <div id="ShowDetail1" style="display:none;">
                      @endif
                        <div class="form-group row mb-0">
                          <label class="col-sm-4 col-form-label text-right SizeText">วันที่จ่ายเงิน :</label>
                          <div class="col-sm-4">
                            <input type="date" id="DatenextSequester" name="DatenextSequester" class="form-control form-control-sm SizeText" value="{{@$data->legiscourtCase->datenextsequester_case}}" />
                          </div>
                          <label class="col-sm-4 col-form-label text-right SizeText">เงินค่าใช้จ่าย :</label>
                          <div class="col-sm-4">
                            <input type="text" id="Paidseguester" name="Paidseguester" class="form-control form-control-sm SizeText" value="{{number_format(@$data->legiscourtCase->paidsequester_case,0)}}" />
                          </div>
                          <label class="col-sm-4 col-form-label text-right SizeText">จำนวนประกาศ :</label>
                          <div class="col-sm-4">
                            <input type="number" id="CountSeliing" name="CountSeliing" class="form-control form-control-sm SizeText" min="1" value="{{@$data->legiscourtCase->NumAmount_case }}" />
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600 SubHeading SizeText">หมายเหตุ <span class="textHeader">(Courtcase Notes)</span></h6>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group row mb-0">
                        <textarea name="noteprepare" class="form-control form-control-sm SizeText" rows="6">{{@$data->legiscourtCase->noteprepare_case}}</textarea>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="card">
              <div class="card-body text-sm">
              <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">สถานะ <span class="textHeader">(Courtcase Status)</span></h6>
                <div class="row">
                  <div class="col-md-12">
                    <div class="" id="todo-list">
                      <span class="todo-wrap SizeText">
                        <input type="checkbox" id="12" {{ (@$data->Flag_Class == 'สถานะคัดหนังสือรับรองคดี' or @$data->Flag_Class == 'สถานะตั้งยึดทรัพย์') ? 'checked' : '' }} disabled/>
                        <label for="12" class="todo"> 
                          <i class="fa fa-check"></i> Prosecute (สถานะคัดโฉนด)
                        </label>
                      </span>
                      <span class="todo-wrap SizeText">
                        <input type="checkbox" id="13" name="FlagClass" value="สถานะตั้งยึดทรัพย์" onclick="CourtCaseDate();" {{ (@$data->Flag_Class == 'สถานะตั้งยึดทรัพย์') ? 'checked' : '' }} />
                        <label for="13" class="todo"> 
                          <i class="fa fa-check"></i> Prosecute (สถานะตั้งยึดทรัพย์)
                        </label>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>--}}
          <div class="col-lg-9">
            <div class="card">
              <div class="card-body text-sm">
                <div class="row">
                  <div class="col-md-12">
                    <ul class="nav nav-tabs" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link SizeText {{ ($FlagTab === 1) ? 'actives active' : '' }}" id="vert-tabs-1-tab" data-toggle="tab" href="#list-page1-list">
                          @if($data->Flag_Class == 'สถานะสืบทรัพย์บังคับคดี' or $data->Flag_Class == 'สถานะคัดโฉนด' or $data->Flag_Class == 'สถานะตั้งยึดทรัพย์' or $data->Flag_Class == 'ประกาศขายทอดตลาด' or $data->Flag_Class == 'จบงานชั้นบังคับคดี')
                            <i class="far fa-check-square text-success"></i>
                          @endif  
                          คัดหนังสือรับรองคดี 
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link SizeText {{ ($FlagTab === 2) ? 'actives active' : '' }}" id="vert-tabs-2-tab" data-toggle="tab" href="#list-page2-list">
                          @if($data->Flag_Class == 'สถานะคัดโฉนด' or $data->Flag_Class == 'สถานะตั้งยึดทรัพย์' or $data->Flag_Class == 'ประกาศขายทอดตลาด' or $data->Flag_Class == 'จบงานชั้นบังคับคดี')
                            <i class="far fa-check-square text-success"></i>
                          @endif  
                          สืบทรัพย์(บังคับคดี)
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link SizeText {{ ($FlagTab === 3) ? 'actives active' : '' }}" id="vert-tabs-3-tab" data-toggle="tab" href="#list-page3-list">
                          @if($data->Flag_Class == 'สถานะตั้งยึดทรัพย์' or $data->Flag_Class == 'ประกาศขายทอดตลาด' or $data->Flag_Class == 'จบงานชั้นบังคับคดี')
                            <i class="far fa-check-square text-success"></i>
                          @endif 
                          คัดโฉนด/ถ่ายภาพ
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link SizeText {{ ($FlagTab === 4) ? 'actives active' : '' }}" id="vert-tabs-4-tab" data-toggle="tab" href="#list-page4-list">
                          @if($data->Flag_Class == 'ประกาศขายทอดตลาด' or $data->Flag_Class == 'จบงานชั้นบังคับคดี')
                            <i class="far fa-check-square text-success"></i>
                          @endif 
                          ตั้งเรื่องยึดทรัพย์
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link SizeText {{ ($FlagTab === 5) ? 'actives active' : '' }}" id="vert-tabs-5-tab" data-toggle="tab" href="#list-page5-list">
                          @if($data->Flag_Class == 'จบงานชั้นบังคับคดี')
                            <i class="far fa-check-square text-success"></i>
                          @endif 
                          ประกาศขายทอดตลาด
                        </a>
                      </li>
                    </ul>
                  </div>
                  <br/><br/><br/>
                  <div class="col-md-12">
                    <div class="tab-content">
                      <div id="list-page1-list" class="container  tab-pane {{ ($FlagTab === 1) ? 'active' : '' }}  {{ ($FlagTab === 1 || Auth()->user()->position =='Admin' ) ? '' : 'readonly-div' }}  ">
                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">คัดหนังสือรับรองคดีถึงที่สุด  <span class="textHeader">(15-30 วัน)</span></h6>
                          <div class="row">
                            <div class="col-md-7">
                              <div class="form-group row mb-0">
                                @php
                                    $orderDateCer  = date('Y-m-d', strtotime(' +310 days', strtotime($data->Date_legis)));  
                                @endphp
                                <label class="col-sm-4 col-form-label text-right SizeText">กำหนดการคัดหนังสือ :</label>
                                <div class="col-sm-7">
                                  <input type="date" name="orderDateCer" class="form-control form-control-sm SizeText" value="{{ @$data->legiscourtCase->orderDateCer==NULL ? $orderDateCer:$data->legiscourtCase->orderDateCer}}" readonly/>
                                </div>
                                <label class="col-sm-4 col-form-label text-right SizeText">วันที่คัดหนังสือรับรองคดี :</label>
                                <div class="col-sm-7">
                                  <input type="date" name="dateCertificate" class="form-control form-control-sm SizeText" value="{{@$data->legiscourtCase->dateCertificate_case}}"/>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-5">
                                <div class="card card-info">
                                  <div class="card-header">
                                    <h6><i class="fas fa-tasks"></i> สถานะ (Next Status)</h6>
                                  </div>
                                  <div class="card-body">
                                    <div class="col-md-12">
                                        <span class="todo-wrap SizeText">
                                          <input type="checkbox" id="11" name="FlagClass" value="สถานะสืบทรัพย์บังคับคดี" {{ ($data->Flag_Class === 'สถานะสืบทรัพย์บังคับคดี' or $data->Flag_Class === 'สถานะคัดโฉนด' or $data->Flag_Class === 'สถานะตั้งยึดทรัพย์' or $data->Flag_Class === 'ประกาศขายทอดตลาด' or $data->Flag_Class === 'จบงานชั้นบังคับคดี') ? 'checked' : '' }}/>
                                          <label for="11" class="todo">
                                            <i class="fa fa-check"></i> Prosecute (สถานะสืบทรัพย์(บังคับคดี))
                                          </label>
                                        </span>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                      </div>
                      <div id="list-page2-list" class="container tab-pane {{ ($FlagTab === 2) ? 'active' : '' }} {{ ($FlagTab === 2 || Auth()->user()->position =='Admin' ) ? '' : 'readonly-div' }}">
                      <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">สืบทรัพย์(บังคับคดี) <span class="textHeader">(15-30 วัน)</span></h6>
                        <div class="row">
                          <div class="col-md-7">
                            {{-- <div class="form-group row mb-0">
                              <label class="col-sm-4 col-form-label text-right SizeText">สถานะทรัพย์ :</label>
                              <div class="col-sm-8">
                                <input type="radio" id="test1" name="radio_propertied" value="Y" {{ (@$data->Legisasset->propertied_asset === 'Y') ? 'checked' : '' }} />
                                <label for="test1" class="mr-sm-3 SizeText">ลูกหนี้มีทรัพย์</label>
                                <input type="radio" id="test2" name="radio_propertied" value="N" {{ (@$data->Legisasset->propertied_asset === 'N') ? 'checked' : '' }}/>
                                <label for="test2" class="mr-sm-3 SizeText">ลูกหนี้ไม่มีทรัพย์</label>
                              </div>
                            </div> --}}
                            @php
                              if( @$data->Legisasset->sendsequester_asset =='สืบทรัพย์เจอ'){
                                $chkReadOnly = "readonly";
                              }else{
                                $chkReadOnly = "";
                              }   
                            @endphp
                            <div class="form-group row mb-0">
                              <label class="col-sm-4 col-form-label text-right SizeText">วันที่สืบทรัพย์ :</label>
                              <div class="col-sm-7">
                                <input type="date" id="sequesterasset" name="sequesterasset" class="form-control form-control-sm SizeText" value="{{ @$data->Legisasset->sequester_asset }}" {{ $chkReadOnly}}/>
                              </div>
                            </div>
                            <div class="form-group row mb-0">
                              <label class="col-sm-4 col-form-label text-right SizeText">วันที่สืบทรัพย์ถัดไป:</label>
                              <div class="col-sm-7">
                                <input type="date" id="NewpursueDateasset" name="NewpursueDateasset" class="form-control form-control-sm SizeText" value="{{ @$data->Legisasset->NewpursueDate_asset }}" readonly/>
                              </div>
                            </div>
                            <div class="form-group row mb-0">
                              <label class="col-sm-4 col-form-label text-right SizeText">ผลสืบ :</label>
                              <div class="col-sm-7">
                                <select id="sendsequesterasset" name="sendsequesterasset" class="form-control form-control-sm SizeText">
                                  <option value="" selected>--- เลือกผล ---</option>
                                  <option value="สืบทรัพย์เจอ" {{ (@$data->Legisasset->sendsequester_asset === 'สืบทรัพย์เจอ') ? 'selected' : '' }}>สืบทรัพย์เจอ</option>
                                  <option value="สืบทรัพย์ไม่เจอ" {{ (@$data->Legisasset->sendsequester_asset === 'สืบทรัพย์ไม่เจอ') ? 'selected' : '' }}>สืบทรัพย์ไม่เจอ</option>
                                  {{-- <option value="หมดอายุความคดี" {{ (@$data->Legisasset->sendsequester_asset === 'หมดอายุความคดี') ? 'selected' : '' }}>หมดอายุความคดี</option>
                                  <option value="จบงานสืบทรัพย์" {{ (@$data->Legisasset->sendsequester_asset === 'จบงานสืบทรัพย์') ? 'selected' : '' }}>จบงานสืบทรัพย์</option> --}}
                                </select>
                              </div>
                            </div>
                            <input type="hidden" name="statusasset" value="สืบทรัพย์ชั้นบังคับคดี"/>
                          </div>
                          <div class="col-md-5">
                              <div class="card card-info" style="margin-right: 15px;">
                                <div class="card-header">
                                  <h6><i class="fas fa-tasks"></i> สถานะ (Next Status)</h6>
                                </div>
                                <div class="card-body">
                                  <div class="col-md-12">
                                      <span class="todo-wrap SizeText">
                                        <input type="checkbox" id="12" name="FlagClass" value="สถานะคัดโฉนด" {{ ($data->Flag_Class === 'สถานะคัดโฉนด' or $data->Flag_Class === 'สถานะตั้งยึดทรัพย์' or $data->Flag_Class === 'ประกาศขายทอดตลาด' or $data->Flag_Class === 'จบงานชั้นบังคับคดี') ? 'checked' : '' }}/>
                                        <label for="12" class="todo">
                                          <i class="fa fa-check"></i> Prosecute (สถานะคัดโฉนด/ถ่ายภาพ)
                                        </label>
                                      </span>
                                  </div>
                                </div>
                              </div>
                          </div>
                        </div>
                        @if(count(@$data->LegisassetAll)>1 && (@$data->LegisassetAll[0]->propertied_asset!="Y" || @$data->LegisassetAll[0]->propertied_asset==NULL ) && @$data->LegisassetAll[0]->Status_asset != NULL )
                        <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600 SubHeading SizeText">จำนวนครั้งสืบทรัพย์ </h6>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group row mb-0">
                              <table id="table-payments" class="table table-striped table-bordered text-nowrap table-hover table-sm table-installments" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                      <th>ครั้งที่</th>
                                      <th>วันที่สืบทรัพย์</th>
                                      <th>วันที่สืบทรัพย์ใหม่</th>
                                      <th>ผลสืบ</th>
                                      <th>วันที่อับเดท</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach(@$data->LegisassetAll as $key=>$dataAsset)
                                  <tr>
                                    <td>{{@$key+1}}</td>
                                    <td>{{@$dataAsset->sequester_asset}}</td>
                                    <td>{{@$dataAsset->NewpursueDate_asset}}</td>
                                    <td>{{@$dataAsset->sendsequester_asset}}</td>
                                    <td>{{@$dataAsset->updated_at}}</td>
                                  </tr>
                                  @endforeach
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                        @endif
                      </div>
                      <div id="list-page3-list" class="container tab-pane {{ ($FlagTab === 3) ? 'active' : '' }} {{ ($FlagTab === 3 || Auth()->user()->position =='Admin' ) ? '' : 'readonly-div' }}">
                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">คัดโฉนด/ถ่ายภาพ/หนังสือประเมิณราคา <span class="textHeader">(30 วัน)</span></h6>
                        <div id="icetab-container">
                          <div class="icetab current-tab">ข้อมูลคัดโฉนด</div>
                          {{-- <div class="icetab">รูปโฉนด</div>  
                          <div class="icetab">แผนที่โฉนด</div>   --}}
                        </div>
                        <div id="icetab-content">
                          <div class="tabcontent tab-active">
                            <br>
                            <div class="row">
                              <div class="col-md-7">
                                <div class="form-group row mb-0">
                                  <label class="col-sm-4 col-form-label text-right SizeText">กำหนดวันที่คัดโฉนด :</label>
                                  <div class="col-sm-7">
                                    <input type="date" name="orderDatepreparedoc" class="form-control form-control-sm SizeText" value="{{@$data->legiscourtCase->orderDatepreparedoc}}" readonly/>
                                  </div>
                                </div>
                                <div class="form-group row mb-0">
                                  <label class="col-sm-4 col-form-label text-right SizeText">วันที่คัดโฉนด :</label>
                                  <div class="col-sm-7">
                                    <input type="date" name="datepreparedoc" class="form-control form-control-sm SizeText" value="{{@$data->legiscourtCase->datepreparedoc_case}}"/>
                                  </div>
                                </div>
                                <div class="form-group row mb-0">
                                  <label class="col-sm-4 col-form-label text-right SizeText">วันที่ถ่ายภาพ :</label>
                                  <div class="col-sm-7">
                                    <input type="date" name="Date_Takephoto" class="form-control form-control-sm SizeText" value="{{ @$data->Legisasset->DateTakephoto_asset }}"/>
                                  </div>
                                </div>
                                <div class="form-group row mb-0">
                                  <label class="col-sm-4 col-form-label text-right SizeText">Link ข้อมูลการฟ้อง :</label>
                                  <div class="col-sm-7">
                                    <input type="text" name="file_image" class="form-control form-control-sm SizeText" value="{{ @$data->Legisasset->DateTakephoto_asset }}"/>
                                  </div>
                                </div>
                                {{-- <div class="form-group row mb-0">
                                  <label class="col-sm-4 col-form-label text-right SizeText">วันที่ได้รับภาพ :</label>
                                  <div class="col-sm-7">
                                    <input type="date" name="Date_Getphoto" class="form-control form-control-sm SizeText" value="{{ @$data->Legisasset->DateGetphoto_asset }}"/>
                                  </div>
                                </div> --}}
                              </div>
                              <div class="col-md-5" >
                                  <div class="card card-info" style="margin-right: 15px;">
                                    <div class="card-header">
                                      <h6><i class="fas fa-tasks"></i> สถานะ (Next Status)</h6>
                                    </div>
                                    <div class="card-body">
                                      <div class="col-md-12">
                                          <span class="todo-wrap SizeText">
                                            <input type="checkbox" id="13" name="FlagClass" value="สถานะตั้งยึดทรัพย์" {{ ($data->Flag_Class === 'สถานะตั้งยึดทรัพย์' or $data->Flag_Class === 'ประกาศขายทอดตลาด' or $data->Flag_Class === 'จบงานชั้นบังคับคดี') ? 'checked' : '' }}/>
                                            <label for="13" class="todo">
                                              <i class="fa fa-check"></i> Prosecute (สถานะคัดโฉนด/ถ่ายภาพ)
                                            </label>
                                          </span>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                            </div>
                          </div> 
                          {{-- <div class="tabcontent">     
                            <br>         
                            <div class="row">
                              <div class="col-md-6">
                                <div class="card" style="margin-left:10px;">
                                  <div class="card-header">
                                    <h5 class="card-title"> รูปภาพโฉนด </h5>
                                    <div class="card-tools">
                                      @if(count($dataImages) > 0 )
                                        <a href="{{ action('LegislationController@deleteImageAll',$id) }}?type={{1}}&contract={{ $data->Contract_legis }}" title="ลบรูปทั้งหมด" class="btn btn-tool AlertDelete" data-name="รูปภาพโฉนดที่ 1">
                                          <i class="fa fa-trash"></i>
                                        </a>
                                      @endif
                                    </div>
                                  </div>
                                  <div class="card-body">
                                      <div id="myImg">

                                      <div class="input-group">
                                        <div class="custom-file">
                                          <input type="file" name="file_image[]" class="custom-file-input" id="exampleInputFile" multiple>
                                          <label class="custom-file-label" for="exampleInputFile">เลือกรูปภาพอัพโหลด</label>
                                        </div>
                                      </div>
                                      <hr>
                                    </div>
                                  </div>
                                </div>
                                <br><br><br>
                              </div>

                              <div class="col-md-6">
                                <div class="card" style="margin-right:10px;">
                                  @if(count($dataImages) > 0)
                                    <div class="form-inline">
                                      @foreach($dataImages as $images)
                                        @if($images->type_image == 1)
                                          <div class="col-sm-6">
                                            <a href="{{ asset('legislation/'.str_replace("/","",$data->Contract_legis).'/'.$images->name_image) }}" class="MagicZoom" data-gallery="gallery" data-options="hint:true; zoomMode:magnifier; variableZoom: true">
                                              <img id="myImg" src="{{ asset('legislation/'.str_replace("/","",$data->Contract_legis).'/'.$images->name_image) }}">
                                            </a>
                                          </div>
                                        @endif
                                      @endforeach
                                    </div>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div> --}}
                          {{-- <div class="tabcontent">     
                            <br>         
                            <div class="row">
                              <div class="col-md-6">
                                <div class="card" style="margin-left:10px;">
                                  <div class="card-header">
                                    <h5 class="card-title">แผนที่โฉนด</h5>
                                  </div>
                                  <div class="card-body">
                                    <div class="row">
                                      <div class="col-md-12 SizeText">
                                          <div class="form-group row mb-0">
                                            <label class="col-sm-4 col-form-label text-right">ละติจูด : </label>
                                            <div class="col-sm-6">
                                              <input type="text" name="latitude" class="form-control form-control-sm" value="{{ @$lat }}"/>
                                            </div>
                                          </div>  
                                          <div class="form-group row mb-0">
                                            <label class="col-sm-4 col-form-label text-right">ลองจิจูด : </label>
                                            <div class="col-sm-6">
                                              </label> <input type="text" name="longitude" class="form-control form-control-sm" value="{{ @$long }}"/>
                                            </div>
                                          </div>                                      
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="card" style="margin-right:10px;">
                                  @if($lat != NULL and $long != NULL)
                                    <div id="map" style="width:100%;height:33vh"></div>
                                  @endif
                                </div>
                              </div>

                              
                            </div>
                          </div> --}}
                        </div> 
                      </div>
                      <div id="list-page4-list" class="container tab-pane {{ ($FlagTab === 4) ? 'active' : '' }} {{ ($FlagTab === 4 || Auth()->user()->position =='Admin' ) ? '' : 'readonly-div' }}">
                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ตั้งเรื่องยึดทรัพย์ <span class="textHeader">(15 วัน)</span></h6>
                          <div class="row">
                            <div class="col-md-7">
                              <div class="form-group row mb-0">
                                <label class="col-sm-4 col-form-label text-right SizeText">กำหนดวันที่ตั้งยึดทรัพย์ :</label>
                                <div class="col-sm-7">
                                  <input type="date" name="ordeDateSequester" class="form-control form-control-sm SizeText" value="{{@$data->legiscourtCase->ordeDateSequester}}" readonly/>
                                </div>
                              </div>
                              <div class="form-group row mb-0">
                                <label class="col-sm-4 col-form-label text-right SizeText">วันที่ตั้งเรื่องยึดทรัพย์ :</label>
                                <div class="col-sm-7">
                                  <input type="date" name="dateSequester" class="form-control form-control-sm SizeText" value="{{@$data->legiscourtCase->dateSequester_case}}"/>
                                </div>
                              </div>
                            </div>
                            {{-- <hr>
                            <div class="form-group row mb-0">
                              <label class="col-sm-4 col-form-label text-right SizeText">วันที่ทำหนังสือประเมิณ :</label>
                              <div class="col-sm-7">
                                <input type="date" name="Date_predict" class="form-control form-control-sm SizeText" value="{{ @$data->legiscourtCase->datePredict_case }}"/>
                              </div>
                            </div>
                            <div class="form-group row mb-0">
                              <label class="col-sm-4 col-form-label text-right SizeText">ราคาประเมิณ :</label>
                              <div class="col-sm-7">
                                <input type="number" name="Price_predict" class="form-control form-control-sm SizeText" value="{{ @$data->legiscourtCase->pricePredict_case }}"/>
                              </div>
                            </div> --}}
                            <div class="col-md-5">
                                <div class="card card-info">
                                  <div class="card-header">
                                    <h6><i class="fas fa-tasks"></i> สถานะ (Next Status)</h6>
                                  </div>
                                  <div class="card-body">
                                    <div class="col-md-12">
                                        <span class="todo-wrap SizeText">
                                          <input type="checkbox" id="14" name="FlagClass" value="ประกาศขายทอดตลาด" {{ ($data->Flag_Class === 'ประกาศขายทอดตลาด' or $data->Flag_Class === 'จบงานชั้นบังคับคดี') ? 'checked' : '' }}/>
                                          <label for="14" class="todo">
                                            <i class="fa fa-check"></i> Prosecute (สถานะประกาศขายทอดตลาด)
                                          </label>
                                        </span>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                      </div>
                      <div id="list-page5-list" class="container tab-pane {{ ($FlagTab === 5) ? 'active' : '' }}">
                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ประกาศขายทอดตลาด <span class="textHeader">(6 ครั้ง)</span></h6>
                        @if($data->Flag_Class != "จบงานชั้นบังคับคดี")
                        <button type="button" class="btn btn-sm bg-gradient-info SizeText Button" data-toggle="modal" data-target="#modal-default1">
                          <i class="fas fa-plus SizeText" title="เพิ่มประกาศขาย"></i> เพิ่มประกาศ
                        </button>
                        @endif
                          <div class="row">
                            <div class="col-md-7">
                              <!-- <div class="form-group row mb-0">
                                <label class="col-sm-4 col-form-label text-right SizeText">วันที่ประกาศขาย :</label>
                                <div class="col-sm-7">
                                  <input type="date" name="datePublicsell" class="form-control form-control-sm SizeText" value="{@$data->legiscourtCase->datePublicsell_case}}"/>
                                </div>
                              </div> -->
                              <div class="form-group row mb-0">
                                <label class="col-sm-4 col-form-label text-right SizeText">กำหนดประกาศขาย :</label>
                                <div class="col-sm-7">
                                  <input type="date" name="orderDatePublish" class="form-control form-control-sm SizeText" value="{{@$data->legiscourtCase->orderDatePublish}}" readonly/>
                                </div>
                                <label class="col-sm-4 col-form-label text-right SizeText">ผลประกาศขาย :</label>
                                <div class="col-sm-7">
                                  <select id="ResultSequester" name="ResultSequester" class="form-control form-control-sm SizeText">
                                    <option value="" selected>--- เลือกผล ---</option>
                                    <option value="ชลอการขาย" {{ (@$data->legiscourtCase->resultsequester_case === 'ชลอการขาย') ? 'selected' : '' }}>ชลอการขาย</option>
                                    <option value="ขายได้" {{ (@$data->legiscourtCase->resultsequester_case === 'ขายได้') ? 'selected' : '' }}>ขายได้</option>
                                    <option value="ขายไม่ได้" {{ (@$data->legiscourtCase->resultsequester_case === 'ขายไม่ได้') ? 'selected' : '' }}>ขายไม่ได้</option>
                                  </select>
                                </div>
                              </div>
                              @if(@$data->legiscourtCase->resultsequester_case == 'ขายได้')
                                <div id="ShowDetail2">
                              @else
                                <div id="ShowDetail2" style="display:none;">
                              @endif
                                <div class="form-group row mb-0">
                                  <label class="col-sm-4 col-form-label text-right SizeText">ผลจากการขาย :</label>
                                  <div class="col-sm-7">
                                    <select id="ResultSell" name="ResultSell" class="form-control form-control-sm SizeText">
                                      <option value="" selected>--- เลือกผล ---</option>
                                      <option value="เต็มจำนวน" {{ (@$data->legiscourtCase->resultsell_case === 'เต็มจำนวน') ? 'selected' : '' }}>เต็มจำนวน</option>
                                      <option value="ไม่เต็มจำนวน" {{ (@$data->legiscourtCase->resultsell_case === 'ไม่เต็มจำนวน') ? 'selected' : '' }}>ไม่เต็มจำนวน</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              @if(@$data->legiscourtCase->resultsell_case == 'เต็มจำนวน')
                              <div id="ShowSellDetail1">
                              @else
                              <div id="ShowSellDetail1" style="display:none;">
                              @endif
                                <div class="form-group row mb-0">
                                  <label class="col-sm-4 col-form-label text-right SizeText">วันที่ขายได้ :</label>
                                  <div class="col-sm-7">
                                    <input type="date" id="Datesoldout" name="Datesoldout" class="form-control form-control-sm SizeText" value="{{@$data->legiscourtCase->datesoldout_case}}" />
                                  </div>
                                </div>
                              </div>
                                @if(@$data->legiscourtCase->resultsell_case == 'ไม่เต็มจำนวน')
                                <div id="ShowSellDetail2">
                                @else
                                <div id="ShowSellDetail2" style="display:none;">
                                @endif
                                  <div class="form-group row mb-0">
                                    <label class="col-sm-4 col-form-label text-right SizeText">จำนวนเงิน :</label>
                                    <div class="col-sm-7">
                                      <input type="text" id="Amountsequester" name="Amountsequester" class="form-control form-control-sm SizeText" value="{{number_format(@$data->legiscourtCase->amountsequester_case,0)}}" />
                                    </div>
                                  </div>
                                </div>

                                  @if(@$data->legiscourtCase->resultsequester_case == 'ขายไม่ได้')
                                  <div id="ShowDetail1">
                                  @else
                                  <div id="ShowDetail1" style="display:none;">
                                  @endif
                                <div class="form-group row mb-0">
                                  <label class="col-sm-4 col-form-label text-right SizeText">วันที่ค่าใช้จ่าย:</label>
                                  <div class="col-sm-7">
                                    <input type="date" id="DatenextSequester" name="DatenextSequester" class="form-control form-control-sm SizeText" value="{{@$data->legiscourtCase->datenextsequester_case}}" />
                                  </div>
                                  <!-- <div class="col-sm-4">
                                  </div> -->
                                  <label class="col-sm-4 col-form-label text-right SizeText">เงินค่าใช้จ่าย :</label>
                                  <div class="col-sm-7">
                                    <input type="text" id="Paidseguester" name="Paidseguester" class="form-control form-control-sm SizeText" value="{{number_format(@$data->legiscourtCase->paidsequester_case,0)}}" />
                                  </div>
                                  <!-- <div class="col-sm-4">
                                  </div> -->
                                  <label class="col-sm-4 col-form-label text-right SizeText">จำนวนประกาศ :</label>
                                  <div class="col-sm-7">
                                    <input type="number" id="CountSeliing" name="CountSeliing" class="form-control form-control-sm SizeText" min="1" value="{{@$data->legiscourtCase->NumAmount_case }}" />
                                  </div>
                                </div>
                              </div>
                              <hr>
                              <div class="form-group row mb-0">
                                <label class="col-sm-4 col-form-label text-right SizeText text-red">สถานะบังคับคดี :</label>
                                <div class="col-sm-7">
                                  <select id="StatusCase" name="StatusCase" class="form-control form-control-sm SizeText Boxcolor">
                                    <option value="" selected>--- สถานะ ---</option>
                                    <option value="ถอนบังคับคดีปิดบัญชี" {{ (@$data->legiscourtCase->Status_case === 'ถอนบังคับคดีปิดบัญชี') ? 'selected' : '' }}>ถอนบังคับคดีปิดบัญชี</option>
                                    <option value="ถอนบังคับคดียึดรถ" {{ (@$data->legiscourtCase->Status_case === 'ถอนบังคับคดียึดรถ') ? 'selected' : '' }}>ถอนบังคับคดียึดรถ</option>
                                    <option value="ประนอมหลังยึดทรัพย์" {{ (@$data->legiscourtCase->Status_case === 'ประนอมหลังยึดทรัพย์') ? 'selected' : '' }}>ประนอมหลังยึดทรัพย์</option>
                                    <option value="ถอนบังคับคดียอดเหลือน้อย" {{ (@$data->legiscourtCase->Status_case === 'ถอนบังคับคดียอดเหลือน้อย') ? 'selected' : '' }}>ถอนบังคับคดียอดเหลือน้อย</option>
                                    <option value="ถอนบังคับคดีขายเต็มจำนวน" {{ (@$data->legiscourtCase->Status_case === 'ถอนบังคับคดีขายเต็มจำนวน') ? 'selected' : '' }}>ถอนบังคับคดีขายเต็มจำนวน</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-5" style="font-size:12px;">
                                <div class="card card-info">
                                  <div class="card-header">
                                    <h6><i class="fas fa-calendar"></i> ตารางประกาศขาย @if(count($dataPublish) > 0) ( ครั้งที่ {{@$dataPublish[0]->Round_publish}} ) @endif</h6>
                                  </div>
                                  <!-- <div class="card-body"> -->
                                    <!-- <div class="col-md-12"> -->
                                        <table class="table table-bordered">
                                          <!-- <tr>
                                            <td width="30px">ลำดับ</td>
                                            <td>วันที่</td>
                                            <td>ผล</td>
                                          </tr> -->
                                          @php
                                              $key = 1;
                                          @endphp
                                          @foreach($dataPublish->sortBy('id') as  $row)
                                            @if($row->Dateset_publish != NULL)
                                            <tr>
                                              <td width="20px">{{$key}}</td>
                                              <td width="150px">{{formatDateThaiLong($row->Dateset_publish)}}</td>
                                              <td>
                                              @if($data->legiscourtCase->datesoldout_case != NULL)
                                                @if($row->Dateset_publish < $data->legiscourtCase->datesoldout_case)
                                                  <i class="far fa-window-close text-danger"></i> ขายไม่ได้
                                                @else
                                                  @if($row->Dateset_publish == $data->legiscourtCase->datesoldout_case)
                                                  <i class="far fa-calendar-check text-success"></i> ขายได้ ({{$data->legiscourtCase->resultsell_case}})
                                                  @else 
                                                    -
                                                  @endif
                                                @endif
                                              @else 
                                                @if($row->Dateset_publish < date('Y-m-d'))
                                                  <i class="far fa-window-close text-danger"></i> ขายไม่ได้
                                                @else 
                                                  -
                                                @endif
                                              @endif
                                              </td>
                                            </tr>
                                            @endif
                                            @php
                                                $key++;
                                            @endphp
                                          @endforeach
                                        </table>
                                    <!-- </div> -->
                                  <!-- </div> -->
                                </div>
                            </div>
                          </div>
                      </div>
                      
                      <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600 SubHeading SizeText">หมายเหตุ <span class="textHeader">(Courtcase Notes)</span></h6>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group row mb-0">
                              <textarea name="noteprepare" class="form-control form-control-sm SizeText" rows="6">{{@$data->legiscourtCase->noteprepare_case}}</textarea>
                            </div>
                          </div>
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

  <div class="modal fade show" id="modal-default1" aria-modal="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      <div class="card">
      <div class="card-header" style="background-image: url({{ asset('dist/img/bg1.jpg') }})">
        <h5 class="text-left">
          <b class="text-white">เพิ่ม ประกาศขายทอดตลาด <small class="textHeader">(Announcement to Sell)</small></b>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">x</span>
            </button>
        </h5>
      </div>
      <form name="form" class="form" action="{{ route('MasterLegis.store') }}" method="post" enctype="multipart/form-data" sstyle="font-family: 'Prompt', sans-serif;" id="quickForm">
        {{ csrf_field() }}
        <input type="hidden" name="type" value="3">
        <input type="hidden" name="Nameuser" value="{{auth::user()->name}}"/>
        <input type="hidden" name="legis_id" value="{{$data->id}}"/>

        <div class="card-body SizeText">
            <div class="table-responsive">  
                <table class="table table-bordered">  
                <thead>
                    <tr>
                        <th class="text-left SizeText" style="width: 10px">ลำดับ</th>
                        <th class="text-left SizeText" style="width: 70px">วันที่ตั้งประกาศ</th>
                        <th class="text-left SizeText">หมายเหตุ</th>
                    </tr>
                </thead>
                    <tr>  
                        <td class="text-center">1</td>
                        <td class="text-left">
                          <input type="date" name="datePublish1" class="form-control form-control-sm list SizeText" required/>
                        </td>  
                        <td class="text-left">
                            <input type="text" name="Note1" class="form-control form-control-sm SizeText"/>
                        </td>  
                    </tr> 
                    <tr>  
                        <td class="text-center">2</td>
                        <td class="text-left">
                          <input type="date" name="datePublish2" class="form-control form-control-sm list SizeText" required/>
                        </td>  
                        <td class="text-left">
                            <input type="text" name="Note2" class="form-control form-control-sm SizeText"/>
                        </td>  
                    </tr>  
                    <tr>  
                        <td class="text-center">3</td>
                        <td class="text-left">
                          <input type="date" name="datePublish3" class="form-control form-control-sm list SizeText" required/>
                        </td>  
                        <td class="text-left">
                            <input type="text" name="Note3" class="form-control form-control-sm SizeText"/>
                        </td>  
                    </tr>  
                    <tr>  
                        <td class="text-center">4</td>
                        <td class="text-left">
                          <input type="date" name="datePublish4" class="form-control form-control-sm list SizeText" required/>
                        </td>  
                        <td class="text-left">
                            <input type="text" name="Note4" class="form-control form-control-sm SizeText"/>
                        </td>  
                    </tr>  
                    <tr>  
                        <td class="text-center">5</td>
                        <td class="text-left">
                          <input type="date" name="datePublish5" class="form-control form-control-sm list SizeText"/>
                        </td>  
                        <td class="text-left">
                            <input type="text" name="Note5" class="form-control form-control-sm SizeText"/>
                        </td>  
                    </tr>  
                    <tr>  
                        <td class="text-center">6</td>
                        <td class="text-left">
                          <input type="date" name="datePublish6" class="form-control form-control-sm list SizeText"/>
                        </td>  
                        <td class="text-left">
                            <input type="text" name="Note6" class="form-control form-control-sm SizeText"/>
                        </td>  
                    </tr>   
                </table>  
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-info hover-up" style="color:#ffff";>
            <i class="fas fa-save pr-1"></i> บันทึก
          </button>
        </div>
      </form>
    </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

  <script>
    $('#ResultSequester').change(function(){
      var value = document.getElementById('ResultSequester').value;
        if(value == 'ขายไม่ได้'){
          $('#ShowDetail1').show();
          $('#ShowDetail2').hide();
          $('#ShowSellDetail1').hide();
          $('#ShowSellDetail2').hide();
          $('#ResultSell').val('');
        }
        else if(value == 'ขายได้'){
          $('#ShowDetail2').show();
          $('#ShowDetail1').hide();
          $('#ShowSellDetail1').hide();
          $('#ShowSellDetail2').hide();
        }
        else{
          $('#ShowDetail1').hide();
          $('#ShowDetail2').hide();
          $('#ShowSellDetail1').hide();
          $('#ShowSellDetail2').hide();
          $('#ResultSell').val('');
        }
    });

    $('#ResultSell').change(function(){
      var value = document.getElementById('ResultSell').value;
        if(value == 'เต็มจำนวน'){
          $('#ShowSellDetail1').show();
          $('#ShowSellDetail2').hide();
        }
        else if(value == 'ไม่เต็มจำนวน'){
          $('#ShowSellDetail1').show();
          $('#ShowSellDetail2').show();
        }
        else{
          $('#ShowSellDetail1').hide();
          $('#ShowSellDetail1').val('');
          $('#ShowSellDetail2').hide();
          $('#ShowSellDetail2').val('');
        }
    });

    $('#sequesterasset').change(function(){
        $('#sendsequesterasset').val('');
    });
  </script>

  <script>
    function CourtCaseDate(){
      //---------- ตั้งเรื่องยึดทรัพย์ --------
        var messageFlag = document.querySelector('input[name="FlagClass"]:checked').value;
        var datepreparedoc = document.getElementById('datepreparedoc').value;
        var newdate = new Date(datepreparedoc);

        if (messageFlag != '') {
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

          document.getElementById('DateSequester').value = result;
        }
      //---------- end -------------
    }
  </script>

  <script>
    var tabs = document.getElementById('icetab-container').children;
    var tabcontents = document.getElementById('icetab-content').children;

    var myFunction = function() {
      var tabchange = this.mynum;
      for(var int=0;int<tabcontents.length;int++){
        tabcontents[int].className = ' tabcontent';
        tabs[int].className = 'icetab';
      }
      tabcontents[tabchange].classList.add('tab-active');
      this.classList.add('current-tab');
    }	

    for(var index=0;index<tabs.length;index++){
      tabs[index].mynum=index;
      tabs[index].addEventListener('click', myFunction, false);
    }
  </script>

  @if($lat != null && $long != null)
    <script>
      function initMap() {
        var myLatlng = {lat: {{ $lat }}, lng: {{ $long }}};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 15,
          center: myLatlng
        });
        var marker = new google.maps.Marker({
          position: myLatlng,
          map: map,
          title: 'Click to zoom'
        });
        // var myLatlng2 = {lat: 6.855323, lng: 101.220649};
        // var map = new google.maps.Map(document.getElementById('map2'), {
        //   zoom: 5,
        //   center: myLatlng2
        // });
        map.addListener('center_changed', function() {
          // 3 seconds after the center of the map has changed, pan back to the
          // marker.
          window.setTimeout(function() {
            map.panTo(marker.getPosition());
          }, 3000);
        });
        marker.addListener('click', function() {
          map.setZoom(15);
          map.setCenter(marker.getPosition());
        });
      }
    </script>
  @endif

  <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHvHdio8MNE9aqZZmfvd49zHgLbixudMs&callback=initMap&language=th">
  </script>
@endsection

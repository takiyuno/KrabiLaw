@extends('layouts.master')
@section('title','กฏหมาย/ลูกหนี้สืบทรัพย์')
@section('content')

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

  @php 
    $Flag = session()->get('Flag');
  @endphp

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
      <input type="hidden" name="_method" value="PATCH"/>
      <input type="hidden" name="contract" value="{{ $data->Contract_legis }}">
      <input type="hidden" name="useradd" value="{{auth::user()->name}}"/>
      <input type="hidden" name="type" id="type">
      <input type="hidden" name="flag" id="flag">

      <div class="content">
        <div class="content-header">
          <div class="row">
            <div class="col-8">
              <div class="form-inline">
                <h5>ลูกหนี้สินทรัพย์ <small class="textHeader">(Assets Debtor)</small></h5>
              </div>
            </div>
            <div class="col-4">
              <div class="card-tools d-inline float-right">
                <button type="submit" class="btn btn-success btn-sm SizeText hover-up">
                  <i class="fas fa-save"></i> บันทึก
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <section class="col-lg-3 connectedSortable ui-sortable">
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
                  <a class="list-group-item hover-up active {{ ($data->Flag_status == 2) ? '' : 'disabled' }}" href="#">
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
          </section>

          <section class="col-lg-9 connectedSortable ui-sortable">
            <div class="card">
              <div class="card-body text-sm">
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link SizeText @if(isset($Flag)) {{($Flag == 1) ? 'active' : '' }} @else active @endif" data-toggle="tab" href="#list-page1-list">ข้อมูลสืบทรัพย์</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link SizeText @if(isset($Flag)) {{($Flag == 2) ? 'active' : '' }} @endif" data-toggle="tab" href="#list-page2-list">ข้อมูลโฉนดที่ 1</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link SizeText @if(isset($Flag)) {{($Flag == 3) ? 'active' : '' }} @endif" data-toggle="tab" href="#list-page3-list">ข้อมูลโฉนดที่ 2</a>
                  </li>
                </ul>
                <br/>
                <div class="col-md-12">
                  <div class="tab-content">
                    <div id="list-page1-list" class="container tab-pane @if(isset($Flag)) {{($Flag == 1) ? 'active' : '' }} @else active @endif">
                      <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ขั้นตอนสืบทรัพย์ <span class="textHeader">(Pursue Asset)</span></h6>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText">สถานะทรัพย์ :</label>
                            <div class="col-sm-8">
                              <input type="radio" id="test1" name="radio_propertied" value="Y" {{ (@$data->Legisasset->propertied_asset === 'Y') ? 'checked' : '' }} />
                              <label for="test1" class="mr-sm-3 SizeText">ลูกหนี้มีทรัพย์</label>
                              <input type="radio" id="test2" name="radio_propertied" value="N" {{ (@$data->Legisasset->propertied_asset === 'N') ? 'checked' : '' }}/>
                              <label for="test2" class="mr-sm-3 SizeText">ลูกหนี้ไม่มีทรัพย์</label>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText">สถานะสืบ :</label>
                            <div class="col-sm-8">
                              <select id="statusasset" name="statusasset" class="form-control form-control-sm SizeText">
                                <option value="" selected>--- สถานะสืบ ---</option>
                                <option value="สืบทรัพย์ชั้นศาล" {{ (@$data->Legisasset->Status_asset === 'สืบทรัพย์ชั้นศาล') ? 'selected' : '' }}>สืบทรัพย์ชั้นศาล</option>
                                <option value="สืบทรัพย์ชั้นบังคับคดี" {{ (@$data->Legisasset->Status_asset === 'สืบทรัพย์ชั้นบังคับคดี') ? 'selected' : '' }}>สืบทรัพย์ชั้นบังคับคดี</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <!-- <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText">วันสืบทรัพย์ :</label>
                            <div class="col-sm-8">
                              <input type="date" id="Dateasset" name="Dateasset" class="form-control form-control-sm SizeText" value="{{@$data->Legisasset->Date_asset}}" readonly/>
                            </div>
                          </div> -->
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText text-red">วันสืบทรัพย์ครั้งแรก :</label>
                            <div class="col-sm-8">
                              <input type="date" id="sequesterasset" name="sequesterasset" class="form-control form-control-sm SizeText" value="{{ @$data->Legisasset->sequester_asset }}"/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText">ผลสืบ :</label>
                            <div class="col-sm-8">
                              <select id="sendsequesterasset" name="sendsequesterasset" class="form-control form-control-sm SizeText">
                                <option value="" selected>--- เลือกผล ---</option>
                                <option value="สืบทรัพย์เจอ" {{ (@$data->Legisasset->sendsequester_asset === 'สืบทรัพย์เจอ') ? 'selected' : '' }}>สืบทรัพย์เจอ</option>
                                <option value="สืบทรัพย์ไม่เจอ" {{ (@$data->Legisasset->sendsequester_asset === 'สืบทรัพย์ไม่เจอ') ? 'selected' : '' }}>สืบทรัพย์ไม่เจอ</option>
                                <option value="หมดอายุความคดี" {{ (@$data->Legisasset->sendsequester_asset === 'หมดอายุความคดี') ? 'selected' : '' }}>หมดอายุความคดี</option>
                                <option value="จบงานสืบทรัพย์" {{ (@$data->Legisasset->sendsequester_asset === 'จบงานสืบทรัพย์') ? 'selected' : '' }}>จบงานสืบทรัพย์</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText">วันที่สืบทรัพย์ใหม่ :</label>
                            <div class="col-sm-8">
                              <input type="date" id="NewpursueDateasset" name="NewpursueDateasset" class="form-control form-control-sm SizeText" value="{{ @$data->Legisasset->NewpursueDate_asset }}"/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText">ค่าใช้จ่าย :</label>
                            <div class="col-sm-8">
                              <input type="text" id="Priceasset" name="Priceasset" class="form-control form-control-sm SizeText" value="{{ number_format(@$data->Legisasset->Price_asset) }}"/>
                            </div>
                          </div>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText">วันที่ส่งถ่ายภาพ :</label>
                            <div class="col-sm-8">
                              <input type="date" name="Date_Takephoto" class="form-control form-control-sm SizeText" value="{{ @$data->Legisasset->DateTakephoto_asset }}"/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row mb-0">
                            <label class="col-sm-4 col-form-label text-right SizeText">วันที่ได้รับภาพ :</label>
                            <div class="col-sm-8">
                              <input type="date" name="Date_Getphoto" class="form-control form-control-sm SizeText" value="{{ @$data->Legisasset->DateGetphoto_asset }}"/>
                            </div>
                          </div>
                        </div>
                      </div>
                      <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600 SubHeading SizeText">หมายเหตุ <span class="textHeader">(Notes)</span></h6>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group row mb-0">
                            <textarea name="Notepursueasset" class="form-control form-control-sm SizeText" rows="7">{{ @$data->Legisasset->Notepursue_asset }}</textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="list-page2-list" class="container tab-pane {{ ($Flag === '2') ? 'active' : '' }}">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="card">
                            <div class="card-header">
                              <h5 class="card-title"> รูปภาพโฉนด 1 </h5>
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
                              @php 
                                $Currdate = date('2021-08-01');
                              @endphp
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

                        <div class="col-md-6">
                          <div class="card">
                            <div class="card-header">
                              <h5 class="card-title">แผนที่โฉนด 1</h5>
              
                              <div class="card-tools">
                                <!-- <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button> -->
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="row">
                                <div class="col-md-12 SizeText">
                                    <div class="form-group row mb-0">
                                      <label class="col-sm-2 col-form-label text-right">ละติจูด : </label>
                                      <div class="col-sm-4">
                                        <input type="text" name="latitude" class="form-control form-control-sm" value="{{ @$lat }}"/>
                                      </div>
                                      <label class="col-sm-2 col-form-label text-right">ลองจิจูด : </label>
                                      <div class="col-sm-4">
                                        </label> <input type="text" name="longitude" class="form-control form-control-sm" value="{{ @$long }}"/>
                                      </div>
                                    </div>
                                  <hr>
                                  @if($lat != NULL and $long != NULL)
                                    <div id="map" style="width:100%;height:33vh"></div>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="list-page3-list" class="container tab-pane {{ ($Flag === '3') ? 'active' : '' }}">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="card">
                            <div class="card-header">
                              <h5 class="card-title"> รูปภาพโฉนด 2</h5>
                              <div class="card-tools">
                                @if(count($dataImages) > 0)
                                  <a href="{{ action('LegislationController@deleteImageAll',$id) }}?type={{2}}&contract={{ $data->Contract_legis }}" title="ลบรูปทั้งหมด" class="btn btn-tool AlertDelete" data-name="รูปภาพโฉนดที่ 2">
                                    <i class="fa fa-trash fa-xs"></i>
                                  </a>
                                @endif
                                <!-- <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button> -->
                              </div>
                            </div>
                            <div class="card-body">
                                <div id="myImg">

                                <div class="input-group">
                                  <div class="custom-file">
                                    <input type="file" name="file_image2[]" class="custom-file-input" id="exampleInputFile" multiple>
                                    <label class="custom-file-label" for="exampleInputFile">เลือกรูปภาพอัพโหลด</label>
                                  </div>
                                </div>
                                <hr>
                              </div>
                              @if(count($dataImages) > 0)
                                <div class="form-inline">
                                    @foreach($dataImages as $images)
                                      @if($images->type_image == 11)
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

                        <div class="col-md-6">
                          <div class="card">
                            <div class="card-header">
                              <h5 class="card-title">แผนที่โฉนด 2</h5>
              
                              <div class="card-tools">
                                <!-- <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button> -->
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="row">
                                <div class="col-md-12 SizeText">
                                    <div class="form-group row mb-0">
                                      <label class="col-sm-2 col-form-label text-right">ละติจูด : </label>
                                      <div class="col-sm-4">
                                        <input type="text" name="latitude2" class="form-control form-control-sm" value="{{ @$lat2 }}"/>
                                      </div>
                                      <label class="col-sm-2 col-form-label text-right">ลองจิจูด : </label>
                                      <div class="col-sm-4">
                                        </label> <input type="text" name="longitude2" class="form-control form-control-sm" value="{{ @$long2 }}"/>
                                      </div>
                                    </div>
                                    <hr>
                                    @if(@$lat2 != NULL and @$long2 != NULL)
                                      <div id="map2" style="width:100%;height:33vh"></div>
                                    @endif
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
          </section>
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

  <script>
    $('#Priceasset').on('input', function() {
      var SetPriceasset = $('#Priceasset').val();
      var Priceasset = SetPriceasset.replace(",","");

      $('#Priceasset').val(addCommas(Priceasset));
    });
  </script>

  @if($lat != null && $long != null && $lat2 == null && $long2 == null)
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
  @elseif($lat == null && $long == null && $lat2 != null && $long2 != null)
    <script>
      function initMap() {
        // var myLatlng = {lat: 6.855323, lng: 101.220649};
        // var map = new google.maps.Map(document.getElementById('map'), {
        //   zoom: 15,
        //   center: myLatlng
        // });
        var myLatlng2 = {lat: {{ $lat2 }}, lng: {{ $long2 }}};
        var map = new google.maps.Map(document.getElementById('map2'), {
          zoom: 15,
          center: myLatlng2
        });
        var marker = new google.maps.Marker({
          position: myLatlng2,
          map: map,
          title: 'Click to zoom'
        });
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
  @elseif($lat != null && $long != null && $lat2 != null && $long2 != null)
    <script>
      function initMap() {
        var myLatlng2 = {lat: {{ $lat2 }}, lng: {{ $long2 }}};
        var map = new google.maps.Map(document.getElementById('map2'), {
          zoom: 15,
          center: myLatlng2
        });
        var marker = new google.maps.Marker({
          position: myLatlng2,
          map: map,
          title: 'Click to zoom'
        });
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

  <script type="text/javascript">
    $(document).ready(function(){
      $("#list-page1-list").on("click", function(){
          $("#type").val(8);
          $("#flag").val(1);
      });
      $("#list-page2-list").on("click", function(){
          $("#type").val(11);
          $("#flag").val(2);
      });
      $("#list-page3-list").on("click", function(){
          $("#type").val(11);
          $("#flag").val(3);
      });
    });
  </script>
@endsection

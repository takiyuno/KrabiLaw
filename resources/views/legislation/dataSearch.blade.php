<link rel="stylesheet" href="{{ asset('css/pluginLegislations.css') }}">
<style>
    .Button {
        position: absolute;
        top: 15px;
        right: 5px;
        padding: 3px 10px;
    }
    .Button2 {
        position: absolute;
        top: 15px;
        right: 45px;
        padding: 3px 10px;
    }
    .CardHeight{
        height: 200px;
    }
</style>
 
@if($type == 1)     {{-- ดึงรายชื่อ เข้าระบบ --}}
    <section class="content" style="font-family: 'Prompt', sans-serif;">
        @if ($data != NULL)
            <form name="form1" method="get" action="{{ action('LegislationController@Savestore') }}" enctype="multipart/form-data">
                <div class="card user-card-full">
                    <div class="row m-l-0 m-r-0">
                        <div class="col-sm-4 bg-c-lite-green user-profile">
                            <div class="card-block text-center text-white">
                                <div class="m-b-25"> 
                                    <img src="{{ asset('dist/img/user.png') }}" class="img-radius" alt="User-Profile-Image">
                                </div>
                                <h5 class="f-w-600">{{$data->CONTNO}}</h5>
                                <p>       
                                    {{ $data->Prefix }}
                                    {{ $data->Firstname_Cus }}
                                    {{ $data->Surname_Cus }}
                                </p> 
                                <i class=" mdi mdi-square-edit-outline feather icon-edit m-t-10 f-16"></i>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="card-block mb-2">
                                <h6 class="m-b-20 p-b-5 b-b-default f-w-600" style="color: rgb(255, 117, 25)">ข้อมูลลูกหนี้ <small class="textHeader">(Detail Customers)</small></h6>
                                <div class="row">
                                    @if ($DB_type == 1 or $DB_type == 2 or $DB_type == 3)
                                        <div class="col-md-12">
                                            <div class="form-group row mb-0">
                                            <label class="col-sm-4 col-form-label text-right SizeText text-red">วันทำสัญญา :</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm SizeText SizeText" value="{{date('d-m-Y', strtotime(@$data->SDATE))}}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row mb-0">
                                            <label class="col-sm-4 col-form-label text-right SizeText text-red">ค้างงวด :</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm SizeText SizeText" value="{{@$data->HLDNO}}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row mb-0">
                                            <label class="col-sm-4 col-form-label text-right SizeText text-red">ยอดคงเหลือ :</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm SizeText SizeText" value="{{number_format($data->TOTPRC - $data->SMPAY??0, 2)}}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row mb-0">
                                            <label class="col-sm-4 col-form-label text-right SizeText text-red">ยอดตั้งหนี้สูญ:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm SizeText SizeText" name="RateCutOff" value="{{$data->TBOOKVALUE}}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row mb-0">
                                            <label class="col-sm-4 col-form-label text-right SizeText text-red">สถานะทรัพย์ :</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm SizeText SizeText" value="{{@$data->Vehicle_Chassis!=NULL?'มีทรัพย์':'ไม่มีทรัพย์'}}"/>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($DB_type == 4 or $DB_type == 5 or $DB_type == 6)
                                        <div class="col-md-12">
                                            <div class="form-group row mb-0">
                                            <label class="col-sm-4 col-form-label text-right SizeText text-red">วันทำสัญญา :</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm SizeText SizeText" value="{{date('d-m-Y', strtotime(@$data->SDATE))}}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row mb-0">
                                            <label class="col-sm-4 col-form-label text-right SizeText text-red">เลขโฉนด :</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm SizeText SizeText" value="{{str_replace(" ","",$data->STRNO)}}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row mb-0">
                                            <label class="col-sm-4 col-form-label text-right SizeText text-red">เลขที่ดิน :</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm SizeText SizeText" value="{{number_format(str_replace(" ","",$data->MILERT),0)}}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row mb-0">
                                            <label class="col-sm-4 col-form-label text-right SizeText text-red">ขนาดที่ดิน :</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm SizeText SizeText" value="{{str_replace(" ","",@$data->MANUYR)}}" placeholder="เนื้อที"/>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control form-control-sm SizeText SizeText" value="{{str_replace(" ","",@$data->REGNO)}}" placeholder="ไร่"/>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control form-control-sm SizeText SizeText" value="{{str_replace(" ","",@$data->DORECV)}}" placeholder="งาน"/>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                        <label class="col-sm-4 col-form-label text-right SizeText text-red">* ประเภทลูกหนี้ :</label>
                                            <div class="col-sm-8">
                                                <select name="TypeCus_Flag" class="form-control form-control-sm SizeText Boxcolor" required>
                                                    <option value="" selected>--- ประเภทลูกหนี้ ---</option>
                                                    <option value="W" {{ (@$datalegis->Flag == 'W') ? 'selected' : '' }}>ลูกหนี้ก่อนฟ้อง</option>
                                                    <option value="Y" {{ (@$datalegis->Flag == 'Y') ? 'selected' : '' }}>ลูกหนี้ฟ้อง</option>
                                                    <option value="C" {{ (@$datalegis->Flag == 'C') ? 'selected' : '' }}>ลูกหนี้หลุดขายฝาก</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                        <label class="col-sm-4 col-form-label text-right SizeText text-red">* BILLCOLL :</label>
                                            <div class="col-sm-8">
                                                <select class="form-control form-control-sm SizeText" name="BILLCOLL" >
                                                    <option value="" selected>--- BILLCOLL ---</option>
                                                    @foreach(@$billcoll as $bill)
                                                    <option value="{{@$bill->BILLCOLL}}}">{{@$bill->BILLCOLL}}</option>
                                                    @endforeach
                                                   
                                                  </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            @if($datalegis != NULL)
                                <button type="button" class="btn btn-block btn-sm btn-danger hover-up" disabled>
                                <i class="fas fa-user-check prem"></i> ลูกหนี้อยู่ในระบบแล้ว
                                </button>
                            @else
                                <button type="submit" class="btn btn-block btn-sm btn-success hover-up">
                                <i class="fas fa-user-plus pr-2 prem"></i> นำเข้าระบบ
                                </button>
                            @endif
                            
                            <input type="hidden" name="Flag_DB" value="{{$DB_type}}"/>
                            <input type="hidden" name="type" value="{{$DB_type}}"/>
                            <input type="hidden" name="Contno" value="{{$data->CONTNO}}"/>
                            <input type="hidden" name="_method" value="PATCH"/>
                        </div>
                    </div>
                </div>
            </form>
        @else
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
            ไม่พบข้อมูล. โปรดตรวจสอบเลขที่สัญญา หรือฐานข้อมูล.
        </div>
        @endif
    </section>
@elseif($type == 2)
    <section class="content" style="font-family: 'Prompt', sans-serif;">
        @if($data != NULL)
        <div class="row SizeText">
            <div class="col-sm-5">
            <div class="box-shadow">
                <div class="author-card pb-3 pt-3">
                    <div class="author-card-cover" style="background-image: url({{ asset('dist/img/bg1.jpg') }})">
                        <a class="btn btn-style-1 btn hover-up bg-secondary">
                        <i class="fas fa-info-circle text-md"></i> 
                            @if($data->Flag == 'Y')
                                ลูกหนี้งานฟ้อง
                            @else
                                ลูกหนี้ประนอมหนี้
                            @endif
                        </a>
                    </div>
                    <div class="author-card-profile">
                        <div class="author-card-avatar">
                            @if($data->Status_legis == 'ปิดบัญชี' or $data->Status_legis == 'ปิดจบประนอม' or $data->Status_legis == 'ปิดจบรถยึด' or $data->Status_legis == 'ปิดจบถอนบังคับคดี')
                                <img src="{{ asset('dist/img/Done.jpg') }}" alt="User-Profile-Image" title="ลูกหนี้{{$data->Status_legis}}แล้ว">
                            @else 
                                <img src="{{ asset('dist/img/user.png') }}" alt="User-Profile-Image">
                            @endif
                        </div>
                        <div class="author-card-details">
                            <h5 class="author-card-name text-lg">{{ $data->Contract_legis }}</h5>
                            <span class="author-card-position mb-2">{{ $data->Name_legis }}</span>
                            @if($data->Status_legis == 'ปิดบัญชี' or $data->Status_legis == 'ปิดจบประนอม' or $data->Status_legis == 'ปิดจบรถยึด' or $data->Status_legis == 'ปิดจบถอนบังคับคดี')
                                <span class="author-card-position">
                                    <font color="green">[ {{($data->Status_legis)}} ]</font>
                                </span>
                            @else 
                                <span class="author-card-position prem">
                                    <font color="red">[ {{($data->Flag_Class != NULL)?$data->Flag_Class:'-'}} ]</font>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="wizard">
                <nav class="list-group list-group-flush">
                    <a class="list-group-item hover-up active" data-toggle="tab" href="#list-page1-list">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-user-tag mr-1 text-muted"></i>
                                <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ เตรียมฟ้อง</div>
                            </div>
                            <div class="form-inline">
                                @if($data->Flag_status == 2)
                                    <i class="far fa-check-square sub-target"></i>
                                @endif
                            </div>
                        </div>
                    </a>
                    <a class="list-group-item  hover-up {{ ($data->Flag_status == 2) ? '' : 'disabled' }}" data-toggle="tab" href="#list-page2-list">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-balance-scale text-muted"></i>
                                <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ ชั้นศาล</div>
                            </div>
                            @if($data->Flag_Class == 'สถานะส่งคัดโฉนด' or $data->Flag_Class == 'สถานะตั้งยึดทรัพย์' or $data->Flag_Class == 'จบงานชั้นบังคับคดี')
                                <i class="far fa-check-square sub-target"></i>
                            @endif
                        </div>
                    </a>
                    <a class="list-group-item hover-up {{ ($data->Flag_status == 2) ? '' : 'disabled' }}" data-toggle="tab" href="#list-page3-list">
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
                    <a class="list-group-item hover-up {{ ($data->Flag_status == 2) ? '' : 'disabled' }}" data-toggle="tab" href="#list-page4-list">
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
                    <a class="list-group-item hover-up {{ ($data->Flag_status == 2 or $data->Flag == 'C') ? '' : 'disabled' }}" data-toggle="tab" href="#list-page5-list">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-balance-scale text-muted"></i>
                                <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ ประนอมหนี้</div>
                            </div>
                        </div>                  
                    </a>
                    <!-- <a class="list-group-item hover-up {{ ($data->Flag_status == 2 or $data->Flag == 'C') ? '' : 'disabled' }}" data-toggle="tab" href="#list-page6-list"><i class="fas fa-folder-open text-muted"></i>เอกสารประกอบลูกหนี้</a> -->
                </nav>
                </div>
            </div>
            </div>
            <div class="col-sm-7">
                <div class="card CardHeight">
                    <div class="card-body text-sm">
                        <div class="tab-content">
                            <div id="list-page1-list" class="container tab-pane active">
                                <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText"><i class="fas fa-toggle-on"></i> ข้อมูลลูกหนี้</h6>
                                <a href="{{ route('MasterLegis.edit',[$data->id]) }}?type={{3}}" class="btn btn-sm bg-primary Button">
                                    <span class="prem SizeText"> ดูเพิ่มเติม <i class="fas fa-forward"></i></span>
                                </a>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            <label class="col-sm-5 col-form-label text-right SizeText">ปชช.ผู้ซื้อ :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control form-control-sm SizeText" value="{{ $data->Idcard_legis }}" data-inputmask="&quot;mask&quot;:&quot;9-9999-99999-99-9&quot;" data-mask="" style="border:none;"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            <label class="col-sm-5 col-form-label text-right SizeText">เบอร์ติดต่อ :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control form-control-sm SizeText" value="{{$data->Phone_legis}}" style="border:none;"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            <label class="col-sm-5 col-form-label text-right SizeText">ป้ายทะเบียน :</label>
                                            <div class="col-sm-7 mb-3">
                                                <input type="text" class="form-control form-control-sm SizeText" value="{{$data->register_legis}}" style="border:none;"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="m-b-10 p-b-5 b-b-default f-w-600 SubHeading SizeText"><i class="fas fa-toggle-on"></i> ข้อมูลส่งฟ้อง</h6>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            @if($data->Flag == 'Y')
                                                <label class="col-sm-5 col-form-label text-right SizeText">วันที่ส่งทนาย :</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control form-control-sm SizeText" value="{{ ($data->Datesend_Flag != NULL) ?FormatDatethai($data->Datesend_Flag) : '-' }}" style="border:none;"/>
                                                </div>
                                            @elseif($data->Flag == 'C')
                                                <label class="col-sm-5 col-form-label text-right SizeText">วันที่ประนอม :</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control form-control-sm SizeText" value="{{ (@$data->legisCompromise->Date_Promise != NULL) ?FormatDatethai($data->legisCompromise->Date_Promise) : '-' }}" style="border:none;"/>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            @if($data->Flag == 'Y')
                                                <label class="col-sm-5 col-form-label text-right SizeText">ผู้ส่งทนาย :</label>
                                                <div class="col-sm-7 mb-3">
                                                    <input type="text" class="form-control form-control-sm SizeText" value="{{ ($data->UserSend2_legis != NULL) ?$data->UserSend2_legis : '-' }}" style="border:none;"/>
                                                </div>
                                            @elseif($data->Flag == 'C')
                                                <label class="col-sm-5 col-form-label text-right SizeText">ผู้ส่งประนอม :</label>
                                                <div class="col-sm-7 mb-3">
                                                    <input type="text" class="form-control form-control-sm SizeText" value="{{ ($data->UserSend1_legis != NULL) ?$data->UserSend1_legis : '-' }}" style="border:none;"/>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <h6 class="m-b-10 p-b-5 b-b-default f-w-600 SubHeading SizeText"><i class="fas fa-toggle-on"></i> หมายเหตุ</h6>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            <textarea name="NotebyAnalysis" class="form-control form-control-sm SizeText" rows="5">{{ $data->Noteby_legis }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="list-page2-list" class="container tab-pane">
                                <h6 class="m-b-10 p-b-5 b-b-default f-w-600 SubHeading SizeText"><i class="fas fa-toggle-on"></i> ข้อมูลชั้นศาล</h6>
                                <a href="{{ route('MasterLegis.edit',[$data->id]) }}?type={{4}}" class="btn btn-sm bg-primary Button">
                                    <span class="prem SizeText"> ดูเพิ่มเติม <i class="fas fa-forward"></i></span>
                                </a>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            <label class="col-sm-5 col-form-label text-right SizeText">วันฟ้อง :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control form-control-sm SizeText" value="{{ ($data->legiscourt != NULL) ? FormatDatethai($data->legiscourt->fillingdate_court) : '-' }}" style="border:none;"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            <label class="col-sm-5 col-form-label text-right SizeText">ศาล :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control form-control-sm SizeText" value="{{ ($data->legiscourt != NULL) ? $data->legiscourt->law_court : '-' }}" style="border:none;"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            <label class="col-sm-5 col-form-label text-right SizeText">ทุนทรัพย์ :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control form-control-sm SizeText" value="{{ ($data->legiscourt != '') ? @number_format($data->legiscourt->capital_court, 2) : '-' }}" style="border:none;"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            <label class="col-sm-5 col-form-label text-right SizeText">ค่าทนาย :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control form-control-sm SizeText" value="{{ ($data->legiscourt != '') ? @number_format($data->legiscourt->pricelawyer_court, 2) : '-' }}" style="border:none;"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            <label class="col-sm-5 col-form-label text-right SizeText">เลขคดีดำ :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control form-control-sm SizeText"  value="{{ ($data->legiscourt != NULL) ? $data->legiscourt->bnumber_court : '-' }}" style="border:none;"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            <label class="col-sm-5 col-form-label text-right SizeText">เลขคดีแดง :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control form-control-sm SizeText" value="{{ ($data->legiscourt != NULL) ? $data->legiscourt->rnumber_court : '-' }}" style="border:none;"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            <label class="col-sm-5 col-form-label text-right SizeText">ค่าฟ้อง :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control form-control-sm SizeText" value="{{ ($data->legiscourt != '') ? @number_format($data->legiscourt->indictment_court, 2) : '-' }}" style="border:none;"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="m-t-20 p-b-5 b-b-default f-w-600 SubHeading SizeText"><i class="fas fa-toggle-on"></i> หมายเหตุ</h6>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            <textarea name="suenotecourt" class="form-control form-control-sm SizeText" rows="3">{{ ($data->legiscourt != '') ? $data->legiscourt->SueNote_court : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="list-page3-list" class="container tab-pane">
                                <h6 class="m-b-10 p-b-5 b-b-default f-w-600 SubHeading SizeText"><i class="fas fa-toggle-on"></i> ข้อมูลสืบทรัพย์</h6>
                                <a href="{{ route('MasterLegis.edit',[$data->id]) }}?type={{6}}" class="btn btn-sm bg-primary Button">
                                    <span class="prem SizeText"> ดูเพิ่มเติม <i class="fas fa-forward"></i></span>
                                </a>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            <label class="col-sm-5 col-form-label text-right SizeText"><i class="fas fa-toggle-on"></i> สถานะทรัพย์ :</label>
                                            <div class="col-sm-7">
                                                @if($data->Legisasset != NULL)
                                                    @if($data->Legisasset->propertied_asset == 'Y')
                                                        <input type="text" class="form-control form-control-sm SizeText" value="มีทรัพย์" style="border:none;"/>
                                                    @elseif($data->Legisasset->propertied_asset == 'N')
                                                        <input type="text" class="form-control form-control-sm SizeText" value="ไม่มีทรัพย์" style="border:none;"/>
                                                    @else
                                                        <input type="text" class="form-control form-control-sm SizeText" value="ไม่มีข้อมูล" style="border:none;"/>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            <label class="col-sm-5 col-form-label text-right SizeText">วันที่สืบทรัพย์ :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control form-control-sm SizeText" value="{{ ($data->Legisasset != NULL) ? FormatDatethai($data->Legisasset->Date_asset) : '-' }}" style="border:none;"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            <label class="col-sm-5 col-form-label text-right SizeText">สถานะสืบ :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control form-control-sm SizeText" value="{{ ($data->Legisasset != NULL) ? $data->Legisasset->Status_asset : '-' }}" style="border:none;"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            <label class="col-sm-5 col-form-label text-right SizeText">ผลสืบ :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control form-control-sm SizeText" value="{{ ($data->Legisasset != NULL) ? $data->Legisasset->sendsequester_asset : '-' }}" style="border:none;"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="m-t-20 p-b-5 b-b-default f-w-600 SubHeading SizeText"><i class="fas fa-toggle-on"></i> หมายเหตุ</h6>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            <textarea name="suenotecourt" class="form-control form-control-sm SizeText" rows="5">{{ ($data->Legisasset != NULL) ? $data->Legisasset->Notepursue_asset : ''}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="list-page4-list" class="container tab-pane">
                                <h6 class="m-b-10 p-b-5 b-b-default f-w-600 SubHeading SizeText"><i class="fas fa-toggle-on"></i> ข้อมูลชั้นบังคับคดี</h6>
                                <a href="{{ route('MasterLegis.edit',[$data->id]) }}?type={{5}}" class="btn btn-sm bg-primary Button">
                                    <span class="prem SizeText"> ดูเพิ่มเติม <i class="fas fa-forward"></i></span>
                                </a>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            <label class="col-sm-5 col-form-label text-right SizeText">วันที่คัดโฉนด :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control form-control-sm SizeText" value="{{($data->legiscourtCase != NULL) ? FormatDatethai($data->legiscourtCase->datepreparedoc_case) : '-' }}" style="border:none;"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            <label class="col-sm-5 col-form-label text-right SizeText">วันที่ตั้งเรื่องยึด :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control form-control-sm SizeText" value="{{($data->legiscourtCase != NULL) ? FormatDatethai($data->legiscourtCase->datesetsequester_case) : '-' }}" style="border:none;"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            <label class="col-sm-5 col-form-label text-right SizeText">สถานะบังคับคดี :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control form-control-sm SizeText" value="{{($data->legiscourtCase != NULL) ? $data->legiscourtCase->Status_case : '-' }}" style="border:none;"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            <label class="col-sm-5 col-form-label text-right SizeText">ผลประกาศขาย :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control form-control-sm SizeText" value="{{($data->legiscourtCase != NULL) ? $data->legiscourtCase->resultsequester_case : '-' }}" style="border:none;"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="m-t-20 p-b-5 b-b-default f-w-600 SubHeading SizeText"><i class="fas fa-toggle-on"></i> หมายเหตุ</h6>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            <textarea name="suenotecourt" class="form-control form-control-sm SizeText" rows="5">{{ ($data->legiscourtCase != NULL) ? $data->legiscourtCase->noteprepare_case : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="list-page5-list" class="container tab-pane">
                                <h6 class="m-b-10 p-b-5 b-b-default f-w-600 SubHeading SizeText"><i class="fas fa-toggle-on"></i> ข้อมูลประนอมหนี้ @if($data->Status_legis == 'ปิดจบประนอม')<font color="red">({{$data->Status_legis}})</font>@endif</h6>
                                <a href="{{ route('MasterCompro.edit',[$data->id]) }}?type={{1}}" class="btn btn-sm bg-primary Button">
                                    <span class="prem SizeText"> ดูเพิ่มเติม <i class="fas fa-forward"></i></span>
                                </a>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            <label class="col-sm-5 col-form-label text-right SizeText">วันประนอม :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control form-control-sm SizeText" value="{{($data->legisCompromise != NULL) ? FormatDatethai(substr($data->legisCompromise->created_at,0,10)) : '-' }}" style="border:none;"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            <label class="col-sm-5 col-form-label text-right SizeText">ประเภทประนอมหนี้ :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control form-control-sm SizeText" value="{{($data->legisCompromise != NULL) ? $data->legisCompromise->Type_Promise : '-' }}" style="border:none;"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            <label class="col-sm-5 col-form-label text-right SizeText">ยอดประนอมหนี้ :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control form-control-sm SizeText" value="{{($data->legisCompromise != NULL) ? @number_format($data->legisCompromise->Total_Promise, 0) : '-' }}" style="border:none;"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            <label class="col-sm-5 col-form-label text-right SizeText">
                                            @if($data->legisCompromise != NULL)
                                                @if($data->legisCompromise->Payall_Promise == $data->legisCompromise->Sum_FirstPromise)
                                                    <font color="green">ยอดเงินก้อนแรก : </font>
                                                @else
                                                    <font color="red" class="prem">ยอดเงินก้อนแรก : </font>
                                                @endif
                                            @else
                                                ยอดเงินก้อนแรก :
                                            @endif
                                            </label>
                                            <div class="col-sm-7">
                                                @if ($data->legisCompromise != NULL and $data->legisCompromise->FirstManey_1 != 0)
                                                    <input type="text" value="{{ ($data->legisCompromise != NULL) ?number_format($data->legisCompromise->FirstManey_1, 2): '' }}" class="form-control form-control-sm SizeText"  style="border:none;"/>
                                                @else
                                                    <input type="text" value="{{ ($data->legisCompromise != NULL) ?number_format($data->legisCompromise->Payall_Promise, 2): '' }}" class="form-control form-control-sm SizeText"  style="border:none;"/>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            <label class="col-sm-5 col-form-label text-right SizeText">ค่างวด / เวลาผ่อน :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control form-control-sm SizeText" value="{{($data->legisCompromise != NULL) ? @number_format($data->legisCompromise->Due_1, 0) : '-' }} / {{($data->legisCompromise != NULL) ? @number_format($data->legisCompromise->Period_1, 0) : '' }}" style="border:none;"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            @php
                                                $Setpaid = NULL;
                                                $SetSum = NULL;

                                                if ($data->legisCompromise != NULL){
                                                    $Setpaid = $data->legisCompromise->Sum_FirstPromise + $data->legisCompromise->Sum_DuePayPromise;
                                                    $SetSum = ($data->legisCompromise->Total_Promise - ($data->legisCompromise->Sum_FirstPromise + $data->legisCompromise->Sum_DuePayPromise));
                                                }
                                            @endphp
                                            <label class="col-sm-5 col-form-label text-right SizeText text-danger">ชำระล่าแล้ว :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control form-control-sm SizeText" value="{{($data->legisCompromise != NULL) ? @number_format($Setpaid, 0) : '-' }}" style="border:none;"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            <label class="col-sm-5 col-form-label text-right SizeText text-danger">ยอดคงเหลือ :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control form-control-sm SizeText" value="{{($data->legisCompromise != NULL) ? @number_format($SetSum, 0) : '-' }}" style="border:none;"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="m-t-20 p-b-5 b-b-default f-w-600 SubHeading SizeText"><i class="fas fa-toggle-on"></i> หมายเหตุ</h6>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row mb-0">
                                            <textarea name="suenotecourt" class="form-control form-control-sm SizeText" rows="3">{{ ($data->legisCompromise != NULL) ? $data->legisCompromise->Note_Promise : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="card user-card-full">
            <div class="card-tools d-inline float-right">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button> 
            </div>
            <section class="content">
            <div class="error-page">
                <h2 class="headline text-danger"><i class="fas fa-exclamation-triangle text-danger prem"></i></h2>
                <div class="error-content">
                <h3 class="text-danger"> ไม่พบเลขที่สัญญาในระบบ.</h3>
                <p>
                    โปรดตรวจสอบเลขที่สัญญาใหม่อีกครั้ง.
                    หากมีข้อส่งสัยหรือเกิดข้อผิดพลาด โปรดติดต่อแผนกไอที (เบอร์ภายใน 240).
                </p>
                </div>
            </div>
            </section>
        </div>
        @endif
    </section>
@endif

<script>
    //*************** แจ้งเตือน *************//
    function blinker() {
        $('.prem').fadeOut(1500);
        $('.prem').fadeIn(1500);
    }
    setInterval(blinker, 1500);

    //*************** Data Mark *************//
    $(function () {
        $('[data-mask]').inputmask()
    });
</script>

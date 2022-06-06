<link rel="stylesheet" href="{{ asset('css/pluginLegislations.css') }}">
<!-- Validate Form -->
<script src="{{asset('plugins/jquery-validation/jquery.validate.min.js')}}"></script>

@if($type == 1) {{-- เพิ่มของกลาง --}}
  <section class="content" style="font-family: 'Prompt', sans-serif;">
    <div class="card">
      <div class="card-header" style="background-image: url({{ asset('dist/img/bg1.jpg') }})">
        <h5 class="text-left">
          <b class="text-white">เพิ่มของกลาง <small class="textHeader">(New Exhibit)</small></b>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">x</span>
          </button>
        </h5>
      </div>
      <form name="form" action="{{ route('MasterLegis.store') }}" method="post" id="quickForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="type" value="2">
        <input type="hidden" name="Nameuser" value="{{auth::user()->name}}"/>
        <input type="hidden" name="FlagTab" value="{{$FlagTab}}">

        <div class="card-body SizeText" id="Cul-Payments">
          <div class="row">
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right"><font color="red">เลขที่สัญญา : </font></label>
                <div class="col-sm-8">
                  <input type="text" name="ContractNo" class="form-control form-control-sm SizeText" maxlength="12" placeholder="ป้อนเลขที่สัญญา" data-inputmask="&quot;mask&quot;:&quot;99-9999/9999&quot;" data-mask="" required/>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">วันที่รับเรื่อง :</label>
                <div class="col-sm-8">
                  <input type="date" name="DateExhibit" class="form-control form-control-sm SizeText" required>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">ชื่อ-สกุล :</label>
                <div class="col-sm-8">
                  <input type="text" name="NameContract" class="form-control form-control-sm SizeText" placeholder="ป้อนชื่อ-สกุลผู้เช่าซื้อ" required/>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">สถานีตำรวจภูธร :</label>
                <div class="col-sm-8">
                  <input type="text" name="PoliceStation" class="form-control form-control-sm SizeText" placeholder="ป้อนชื่อสถานีตำรวจภูธร">
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">ชื่อผู้ต้องหา :</label>
                <div class="col-sm-8">
                  <input type="text" name="NameSuspect" class="form-control form-control-sm SizeText" placeholder="ป้อนชื่อผู้ต้องหา" required/>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">ข้อหา :</label>
                <div class="col-sm-8">
                  <select name="PlaintExhibit" class="form-control form-control-sm SizeText" required>
                    <option selected value="">---เลือกข้อหา---</option>
                    <option value="ยาบ้า">ยาบ้า</option>
                    <option value="พืชกระท่อม">พืชกระท่อม</option>
                    <option value="ศุลกากร">ศุลกากร</option>
                    <option value="จราจร">จราจร</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">พนักงานสอบสวน :</label>
                <div class="col-sm-8">
                  <input type="text" name="InquiryOfficial" class="form-control form-control-sm SizeText" placeholder="ป้อนพนักงานสอบสวน"/>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">เบอร์โทรศัพท์ :</label>
                <div class="col-sm-8">
                  <input type="text" name="InquiryOfficialtel" class="form-control form-control-sm SizeText" placeholder="ป้อนพนักงานสอบสวน"/>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">บอกเลิกสัญญา :</label>
                <div class="col-sm-8">
                  <select id="TerminateExhibit" name="TerminateExhibit" class="form-control form-control-sm SizeText" required>
                    <option selected value="">---เลือกบอกเลิกสัญญา---</option>
                    <option value="เร่งรัด">เร่งรัด</option>
                    <option value="ทนาย">ทนาย</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">ประเภทของกลาง :</label>
                <div class="col-sm-8">
                  <select id="TypeExhibit" name="TypeExhibit" class="form-control form-control-sm SizeText" required>
                    <option selected value="">---เลือกประเภท---</option>
                    <option value="ของกลาง">ของกลาง</option>
                    <option value="ยึดตามมาตราการ(ปปส.)">ยึดตามมาตราการ(ปปส.)</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div id="ShowType1" style="display:none;">
            <h6 class="p-b-5 b-b-default f-w-600 SubHeading SizeText"></h6>
            <div class="row" style="color:blue;">
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">วันที่สอบคำให้การ :</label>
                  <div class="col-sm-8">
                    <input type="date" name="DateGiveword" class="form-control form-control-sm SizeText"/>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">วันที่ยื่นคำร้อง :</label>
                  <div class="col-sm-8">
                    <input type="date" name="DateSendword" class="form-control form-control-sm SizeText"/>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">วันที่เตรียมเอกสาร :</label>
                  <div class="col-sm-8">
                    <input type="date" name="DatePreparedoc" class="form-control form-control-sm SizeText"/>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">วันทีไต่สวน :</label>
                  <div class="col-sm-8">
                    <input type="date" name="DateInvestigate" class="form-control form-control-sm SizeText"/>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">วันที่เช็คสำนวน :</label>
                  <div class="col-sm-8">
                    <input type="date" name="DateCheckexhibit" class="form-control form-control-sm SizeText"/>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">ชั้นสำนวน :</label>
                  <div class="col-sm-8">
                    <select name="TypeGiveword" class="form-control form-control-sm SizeText">
                      <option selected value="">---เลือกคำให้การ---</option>
                      <option value="พนักงานสอบสวน">ชั้นพนักงานสอบสวน</option>
                      <option value="พนักงานอัยการ">ชั้นพนักงานอัยการ</option>
                      <option value="ชั้นศาล">ชั้นศาล</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">ผล :</label>
                  <div class="col-sm-8">
                    <select name="ResultExhibit1" class="form-control form-control-sm SizeText">
                      <option selected value="">---เลือกผล---</option>
                        <option value="คืน">คืน</option>
                        <option value="ไม่คืน">ไม่คืน</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">วิธีดำเนินการ :</label>
                  <div class="col-sm-8">
                    <select id="ProcessExhibit1" name="ProcessExhibit1" class="form-control form-control-sm SizeText">
                      <option selected value="">---เลือกวิธีดำเนินการ---</option>
                      <option value="รับคืน">รับคืน</otion>
                      <option value="ไม่รับคืน">ไม่รับคืน</otion>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-6">
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">วันที่ดำเนินการ :</label>
                  <div class="col-sm-8">
                    <input type="date" id="DategetResult1" name="DategetResult1" class="form-control form-control-sm SizeText"/>
                  </div>
                </div>
              </div>
            </div>
            <h6 class="p-b-5 b-b-default f-w-600 SubHeading SizeText"></h6>
          </div>
          <div id="ShowType2" style="display:none;">
            <h6 class="p-b-5 b-b-default f-w-600 SubHeading SizeText"></h6>
            <div class="row" style="color:blue;">
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">วันทีส่งรายละเอียด :</label>
                  <div class="col-sm-8">
                    <input type="date" name="DateSenddetail" class="form-control form-control-sm SizeText"/>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">วิธีดำเนินการ :</label>
                  <div class="col-sm-8">
                    <select id="ProcessExhibit2" name="ProcessExhibit2" class="form-control form-control-sm SizeText">
                      <option selected value="">---เลือกวิธีดำเนินการ---</option>
                      <option value="ไปรับเช็ค">ไปรับเช็ค</option>
                      <option value="ไปรับรถ">ไปรับรถ</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">ผล :</label>
                  <div class="col-sm-8">
                    <select name="ResultExhibit2" class="form-control form-control-sm SizeText">
                      <option selected value="">---เลือกผล---</option>
                        <option value="รับเช็ค">รับเช็ค</option>
                        <option value="รับรถ">รับรถ</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">วันที่ดำเนินการ :</label>
                  <div class="col-sm-8">
                    <input type="date" id="DategetResult2" name="DategetResult2" class="form-control form-control-sm SizeText"/>
                  </div>
                </div>
              </div>
            </div>
            <h6 class="p-b-5 b-b-default f-w-600 SubHeading SizeText"></h6>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="form-group row mb-0">
                <label class="col-sm-2 col-form-label text-right">หมายเหตุ : </label>
                <div class="col-sm-10">
                  <textarea name="NoteExhibit" placeholder="ป้อนหมายเหตุ" class="form-control form-control-sm SizeText" rows="3"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer text-right">
          <button type="submit" class="btn btn-sm btn-info SizeText hover-up">
            <i class="fas fa-save"></i> บันทึก
          </button>
        </div>
      </form>
    </div>
  </section>
@elseif($type == 8) {{-- แก้ไขของกลาง --}}
  <section class="content" style="font-family: 'Prompt', sans-serif;">
    <div class="card">
      <div class="card-header" style="background-image: url({{ asset('dist/img/bg1.jpg') }})">
        <h5 class="text-left">
          <b class="text-white">แก้ไขของกลาง <small class="textHeader">(Edit Exhibit)</small></b>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">x</span>
          </button>
        </h5>
      </div>
      <form name="form" action="{{ route('MasterLegis.update',[$id]) }}" method="post" id="quickForm" enctype="multipart/form-data">
        @csrf
        @method('put')
        <input type="hidden" name="type" value="9">
        <input type="hidden" name="Nameuser" value="{{auth::user()->name}}"/>
        <input type="hidden" name="FlagTab" value="{{$FlagTab}}"/>

        <div class="card-body SizeText" id="Cul-Payments">
          <div class="row">
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right"><font color="red">เลขที่สัญญา : </font></label>
                <div class="col-sm-8">
                  <input type="text" name="ContractNo" class="form-control form-control-sm SizeText" value="{{$data->Contract_legis}}" maxlength="12" placeholder="ป้อนเลขที่สัญญา" data-inputmask="&quot;mask&quot;:&quot;99-9999/9999&quot;" data-mask="" required/>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">วันที่รับเรื่อง :</label>
                <div class="col-sm-8">
                  <input type="date" name="DateExhibit" class="form-control form-control-sm SizeText" value="{{$data->Dateaccept_legis}}" required>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">ชื่อ-สกุล :</label>
                <div class="col-sm-8">
                  <input type="text" name="NameContract" class="form-control form-control-sm SizeText" placeholder="ป้อนชื่อ-สกุลผู้เช่าซื้อ" value="{{$data->Name_legis}}" required/>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">สถานีตำรวจภูธร :</label>
                <div class="col-sm-8">
                  <input type="text" name="PoliceStation" class="form-control form-control-sm SizeText" placeholder="ป้อนชื่อสถานีตำรวจภูธร" value="{{$data->Policestation_legis}}">
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">ชื่อผู้ต้องหา :</label>
                <div class="col-sm-8">
                  <input type="text" name="NameSuspect" class="form-control form-control-sm SizeText" placeholder="ป้อนชื่อผู้ต้องหา" value="{{$data->Suspect_legis}}" required/>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">ข้อหา :</label>
                <div class="col-sm-8">
                  <select name="PlaintExhibit" class="form-control form-control-sm SizeText" required>
                    <option selected value="">---เลือกข้อหา---</option>
                    <option value="ยาบ้า" {{($data->Plaint_legis === 'ยาบ้า') ? 'selected' : '' }}>ยาบ้า</option>
                    <option value="พืชกระท่อม" {{($data->Plaint_legis === 'พืชกระท่อม') ? 'selected' : '' }}>พืชกระท่อม</option>
                    <option value="ศุลกากร" {{($data->Plaint_legis === 'ศุลกากร') ? 'selected' : '' }}>ศุลกากร</option>
                    <option value="จราจร" {{($data->Plaint_legis === 'จราจร') ? 'selected' : '' }}>จราจร</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">พนักงานสอบสวน :</label>
                <div class="col-sm-8">
                  <input type="text" name="InquiryOfficial" class="form-control form-control-sm SizeText" placeholder="ป้อนพนักงานสอบสวน" value="{{$data->Inquiryofficial_legis}}"/>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">เบอร์โทรศัพท์ :</label>
                <div class="col-sm-8">
                  <input type="text" name="InquiryOfficialtel" class="form-control form-control-sm SizeText" placeholder="ป้อนพนักงานสอบสวน" value="{{$data->Inquiryofficialtel_legis}}"/>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">บอกเลิกสัญญา :</label>
                <div class="col-sm-8">
                  <select id="TerminateExhibit" name="TerminateExhibit" class="form-control form-control-sm SizeText" required>
                    <option selected value="">---เลือกบอกเลิกสัญญา---</option>
                    <option value="เร่งรัด" {{($data->Terminate_legis === 'เร่งรัด') ? 'selected' : '' }}>เร่งรัด</option>
                    <option value="ทนาย" {{($data->Terminate_legis === 'ทนาย') ? 'selected' : '' }}>ทนาย</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">ประเภทของกลาง :</label>
                <div class="col-sm-8">
                  <select id="TypeExhibit" name="TypeExhibit" class="form-control form-control-sm SizeText" required>
                    <option selected value="">---เลือกประเภท---</option>
                    <option value="ของกลาง" {{($data->Typeexhibit_legis === 'ของกลาง') ? 'selected' : '' }}>ของกลาง</option>
                    <option value="ยึดตามมาตราการ(ปปส.)" {{($data->Typeexhibit_legis === 'ยึดตามมาตราการ(ปปส.)') ? 'selected' : '' }}>ยึดตามมาตราการ(ปปส.)</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          @if($data->Typeexhibit_legis == 'ของกลาง')
            <div id="ShowType1">
          @else
            <div id="ShowType1" style="display:none;">
          @endif
            <h6 class="p-b-5 b-b-default f-w-600 SubHeading SizeText"></h6>
            <div class="row" style="color:blue;">
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">วันที่สอบคำให้การ :</label>
                  <div class="col-sm-8">
                    <input type="date" name="DateGiveword" class="form-control form-control-sm SizeText" value="{{$data->Dategiveword_legis}}"/>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">วันที่ยื่นคำร้อง :</label>
                  <div class="col-sm-8">
                    <input type="date" name="DateSendword" class="form-control form-control-sm SizeText" value="{{$data->Datesendword_legis}}"/>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">วันที่เตรียมเอกสาร :</label>
                  <div class="col-sm-8">
                    <input type="date" name="DatePreparedoc" class="form-control form-control-sm SizeText" value="{{$data->Datepreparedoc_legis}}"/>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">วันทีไต่สวน :</label>
                  <div class="col-sm-8">
                    <input type="date" name="DateInvestigate" class="form-control form-control-sm SizeText" value="{{$data->Dateinvestigate_legis}}"/>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">วันที่เช็คสำนวน :</label>
                  <div class="col-sm-8">
                    <input type="date" name="DateCheckexhibit" class="form-control form-control-sm SizeText" value="{{$data->Datecheckexhibit_legis}}"/>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">ชั้นสำนวน :</label>
                  <div class="col-sm-8">
                    <select name="TypeGiveword" class="form-control form-control-sm SizeText">
                      <option selected value="">---เลือกคำให้การ---</option>
                      <option value="ชั้นพนักงานสอบสวน" {{($data->Typegiveword_legis === 'ชั้นพนักงานสอบสวน') ? 'selected' : '' }}>ชั้นพนักงานสอบสวน</otion>
                      <option value="ชั้นพนักงานอัยการ" {{($data->Typegiveword_legis === 'ชั้นพนักงานอัยการ') ? 'selected' : '' }}>ชั้นพนักงานอัยการ</otion>
                      <option value="ชั้นศาล" {{($data->Typegiveword_legis === 'ชั้นศาล') ? 'selected' : '' }}>ชั้นศาล</otion>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">ผล :</label>
                  <div class="col-sm-8">
                    <select name="ResultExhibit1" class="form-control form-control-sm SizeText">
                      <option selected value="">---เลือกผล---</option>
                      <option value="คืน" {{($data->Resultexhibit1_legis === 'คืน') ? 'selected' : '' }}>คืน</otion>
                      <option value="ไม่คืน" {{($data->Resultexhibit1_legis === 'ไม่คืน') ? 'selected' : '' }}>ไม่คืน</otion>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">วิธีดำเนินการ :</label>
                  <div class="col-sm-8">
                    <select id="ProcessExhibit1" name="ProcessExhibit1" class="form-control form-control-sm SizeText">
                      <option selected value="">---เลือกวิธีดำเนินการ---</option>
                      <option value="รับคืน" {{($data->Processexhibit1_legis === 'รับคืน') ? 'selected' : '' }}>รับคืน</otion>
                      <option value="ไม่รับคืน" {{($data->Processexhibit1_legis === 'ไม่รับคืน') ? 'selected' : '' }}>ไม่รับคืน</otion>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-6">
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">วันที่ดำเนินการ :</label>
                  <div class="col-sm-8">
                    <input type="date" id="DategetResult1" name="DategetResult1" class="form-control form-control-sm SizeText" value="{{$data->Dategetresult_legis}}"/>
                  </div>
                </div>
              </div>
            </div>
            <h6 class="p-b-5 b-b-default f-w-600 SubHeading SizeText"></h6>
          </div>

        @if($data->Typeexhibit_legis == 'ยึดตามมาตราการ(ปปส.)')
          <div id="ShowType2">
        @else
          <div id="ShowType2" style="display:none;">
        @endif
            <h6 class="p-b-5 b-b-default f-w-600 SubHeading SizeText"></h6>
            <div class="row" style="color:blue;">
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">วันทีส่งรายละเอียด :</label>
                  <div class="col-sm-8">
                    <input type="date" name="DateSenddetail" class="form-control form-control-sm SizeText" value="{{$data->Datesenddetail_legis}}"/>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">วิธีดำเนินการ :</label>
                  <div class="col-sm-8">
                    <select id="ProcessExhibit2" name="ProcessExhibit2" class="form-control form-control-sm SizeText">
                      <option selected value="">---เลือกวิธีดำเนินการ---</option>
                      <option value="ไปรับเช็ค" {{($data->Processexhibit2_legis === 'ไปรับเช็ค') ? 'selected' : '' }}>ไปรับเช็ค</otion>
                      <option value="ไปรับรถ" {{($data->Processexhibit2_legis === 'ไปรับรถ') ? 'selected' : '' }}>ไปรับรถ</otion>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">ผล :</label>
                  <div class="col-sm-8">
                    <select name="ResultExhibit2" class="form-control form-control-sm SizeText">
                      <option selected value="">---เลือกผล---</option>
                      <option value="รับเช็ค" {{($data->Resultexhibit2_legis === 'รับเช็ค') ? 'selected' : '' }}>รับเช็ค</otion>
                      <option value="รับรถ" {{($data->Resultexhibit2_legis === 'รับรถ') ? 'selected' : '' }}>รับรถ</otion>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">วันที่ดำเนินการ :</label>
                  <div class="col-sm-8">
                    <input type="date" id="DategetResult2" name="DategetResult2" class="form-control form-control-sm SizeText" value="{{$data->Dategetresult_legis}}"/>
                  </div>
                </div>
              </div>
            </div>
            <h6 class="p-b-5 b-b-default f-w-600 SubHeading SizeText"></h6>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="form-group row mb-0">
                <label class="col-sm-2 col-form-label text-right">หมายเหตุ : </label>
                <div class="col-sm-10">
                  <textarea name="NoteExhibit" placeholder="ป้อนหมายเหตุ" class="form-control form-control-sm SizeText" rows="5">{{$data->Noteexhibit_legis}}</textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer text-right">
          <button type="submit" class="btn btn-sm btn-info SizeText hover-up">
            <i class="fas fa-save"></i> บันทึก
          </button>
        </div>
      </form>
    </div>
  </section>
@endif


  <script>
    $('#TypeExhibit').change(function(){
      var value = document.getElementById('TypeExhibit').value;
        if(value == 'ของกลาง'){
          $('#ShowType1').show();
          $('#ShowType2').hide();
        }
        else if(value == 'ยึดตามมาตราการ(ปปส.)'){
          $('#ShowType1').hide();
          $('#ShowType2').show();
        }
        else{
          $('#ShowType1').hide();
          $('#ShowType2').hide();
        }
    });
    $('#TerminateExhibit').change(function(){
      var value = document.getElementById('TerminateExhibit').value;
        if(value == 'ทนาย'){
          $('#ShowTerminate').show();
        }
        else{
          $('#ShowTerminate').hide();
        }
    });
  </script>

  <script>
    $('#ProcessExhibit1').change(function(){
      var value = document.getElementById('ProcessExhibit1').value;
      var today = new Date();
      var date = today.getFullYear()+'-'+(today.getMonth()+1).toString().padStart(2, "0")+'-'+today.getDate().toString().padStart(2, "0");
        if(value != ''){
          $('#DategetResult1').val(date);
        }
        else{
          $('#DategetResult1').val('');
        }
    });
  </script>

  <script>
    $('#ProcessExhibit2').change(function(){
      var value = document.getElementById('ProcessExhibit2').value;
      var today = new Date();
      var date = today.getFullYear()+'-'+(today.getMonth()+1).toString().padStart(2, "0")+'-'+today.getDate().toString().padStart(2, "0");
        if(value != ''){
          $('#DategetResult2').val(date);
        }
        else{
          $('#DategetResult2').val('');
        }
    });
  </script>

  <script>
    $(function () {
      $('[data-mask]').inputmask()
    })

    $(function () {
      $('#quickForm').validate({
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.col-sm-4').append(error);
          element.closest('.col-sm-6').append(error);
          element.closest('.col-sm-8').append(error);
          element.closest('.col-sm-10').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
      });
    });
  </script>


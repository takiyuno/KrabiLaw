<link rel="stylesheet" href="{{ asset('css/pluginLegislations.css') }}">
<script src="{{asset('js/pluginLegisCompro.js')}}"></script>
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<link rel="stylesheet" href="{{asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')}}">
<script src="{{asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>
<script src="{{asset('plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

@if($type == 1) {{-- Modal Add New Expenses --}}
  <section class="content" style="font-family: 'Prompt', sans-serif;">
      <div class="card-header" style="background-image: url({{ asset('dist/img/bg1.jpg') }})">
        <h5 class="text-left">
          <b class="text-white">เพิ่มค่าใช้จ่าย <small class="textHeader">(New Expenses)</small></b>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">x</span>
          </button>
        </h5>
      </div>
      <form name="form" action="{{ route('MasterExpense.store') }}" method="post" id="quickForm" novalidate="novalidate" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="type" value="1">
        <input type="hidden" name="UseraddExpense" value="{{ Auth::user()->name }}"/>
        <input type="hidden" name="_token" value="{{csrf_token()}}" />

        <div class="card-body SizeText" id="Cul-Payments">
          <div class="row">
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">วันที่เพิ่ม : </label>
                <div class="col-sm-8">
                  <input type="date" id="DateExpense" name="DateExpense" class="form-control form-control-sm SizeText" value="{{date('Y-m-d') }}" readonly/>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">ประเภท คชจ. : </label>
                <div class="col-sm-8">
                  <select id="TypeExpense" name="TypeExpense" class="form-control form-control-sm SizeText" required>
                    <option value="" selected>--- ประเภทค่าใช้จ่าย ---</option>
                    <option value="ภายในศาล">ภายในศาล</option>
                    <option value="ค่าพิเศษ">ค่าพิเศษ</option>
                    <option value="เบิกสำรองจ่าย">เบิกสำรองจ่าย</option>
                    <option value="ค่าของกลาง">ค่าของกลาง</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right text1">ค่าใช้จ่าย : </label>
                <div class="col-sm-8">
                  <input type="number" name="AmountExpense" class="form-control form-control-sm SizeText" maxlength="9" placeholder="0.00" required/>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right text2">เรื่อง : </label>
                <div class="col-sm-8 a">
                  <select name="TopicExpense" class="form-control form-control-sm SizeText" required>
                    <option value="">--- เลือกเรื่อง ---</option>
                  </select>
                </div>
                <div class="col-sm-8 b">
                  <select id="TopicExpense1" name="TopicExpense1" class="form-control form-control-sm SizeText" required>
                    <option value="">--- เลือกเรื่อง ---</option>
                    <option value="ค่าธรรมเนียมศาล">1. ค่าธรรมเนียมศาล</option>
                    <option value="ค่าส่งหมายเรียกและสำเนาคำฟ้อง">2. ค่าส่งหมายเรียกและสำเนาคำฟ้อง</option>
                    <option value="ค่าฟ้องศาล">3. ค่าฟ้องศาล</option>
                    <option value="ค่าธรรมเนียมชั้นบังคับคดี">4. ค่าธรรมเนียมชั้นบังคับคดี</option>
                    <option value="ค่าธรรมเนียมถอนการบังคับคดี">5. ค่าธรรมเนียมถอนการบังคับคดี</option>
                    <option value="ค่าส่งหมายบังคับคดี">6. ค่าส่งหมายบังคับคดี</option>
                    <option value="ค่าตรวจสอบหลักทรัพย์">7. ค่าตรวจสอบหลักทรัพย์</option>
                    <option value="ค่าอื่นๆ">8. ค่าอื่นๆ</option>
                    <option value="ลูกหนี้ฟ้องเก่า">9. ลูกหนี้ฟ้องเก่า</option>
                    <!-- <option value="ค่ารับรองสำเนาเอกสาร">6. ค่ารับรองสำเนาเอกสาร</option>
                    <option value="ค่าใบสำคัญรับรองคดีถึงที่สุด">7. ค่าใบสำคัญรับรองคดีถึงที่สุด</option> -->
                  </select>
                </div>
                <div class="col-sm-8 c">
                  <select id="TopicExpense2" name="TopicExpense2" class="form-control form-control-sm SizeText" required>
                    <option value="">--- เลือกเรื่อง ---</option>
                    <option value="ค่าถ่ายภาพ">1. ค่าถ่ายภาพ</option>
                    <option value="ค่ารับของกลาง">2. ค่ารับของกลาง</option>
                    <option value="ยื่นฟ้องคดี">3. ยื่นฟ้องคดี</option>
                    <option value="นำคำบังคับ">4. นำคำบังคับ</option>
                    <option value="คัดคำพิพากษา">5. คัดคำพิพากษา</option>
                    <option value="คัดทะเบียนราษฎร์">6. คัดทะเบียนราษฎร์</option>
                    <option value="เช็คเบอร์ลูกค้า">7. เช็คเบอร์ลูกค้า</option>
                    <option value="คัดโฉนดเพื่อยึดทรัพย์">8. คัดโฉนดเพื่อยึดทรัพย์</option>
                    <option value="สืบทรัพย์">9. สืบทรัพย์</option>
                    <option value="อื่นๆ">10. อื่นๆ</option>
                    <option value="ลูกหนี้ฟ้องเก่า">11. ลูกหนี้ฟ้องเก่า</option>
                  </select>
                </div>
                <div class="col-sm-8 d">
                  <input type="number" name="EditAmountExpense" class="form-control form-control-sm SizeText" maxlength="9" placeholder="0.00" readonly/>
                  <input type="hidden" name="Contract3[]"  value="0|00-0000/0000"/>
                </div>
                <div class="col-sm-8 e">
                  <select name="Contract4[]" class="form-control form-control-sm SizeText select2" style="width: 100%;" required>
                    @foreach($dataExhibit as $row)
                      <option class="SizeText" value="{{$row->id}}|{{$row->Contract_legis}}">{{$row->Contract_legis}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="col-6">

            </div>
            <div class="col-6">
              <div class="form-group row mb-3">
                <label class="col-sm-4 col-form-label text-right">ผู้รับเงิน : </label>
                <div class="col-sm-8">
                  <select name="LawyerName" class="form-control form-control-sm SizeText" required>
                    <option value="">--- เลือกผู้รับเงิน ---</option>
                    <option value="ทนายสมคิด แก้วสว่าง">1. ทนายสมคิด แก้วสว่าง</option>
                    <!-- <option value="อารีฟ หัสบู">2. อารีฟ หัสบู</option> -->
                  </select>
                </div>
              </div>
            </div>
            <div id="type1">
              <div class="col-12">
                <div class="form-group row mb-1">
                  <label class="col-sm-2 col-form-label text-right">เลขที่สัญญา : </label>
                  <div class="col-sm-10">
                        <div class="select2-primary">
                          <div class="form-group">
                              <select name="Contract2[]" class="duallistbox SizeText" data-placeholder="เลือกเลขที่สัญญาลูกหนี้" multiple="multiple" style="display: none;" required>
                                @foreach($data as $row)
                                  <option data-select2-id="{{$row->id}}" value="{{$row->id}}|{{$row->Contract_legis}}">{{$row->Contract_legis}}</option>
                                @endforeach
                              </select>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="type2">
              <div class="col-6">
                <div class="form-group row mb-1">
                  <label class="col-sm-4 col-form-label text-right">เลขที่สัญญา : </label>
                  <div class="col-sm-8">
                    <select name="Contract1[]" class="form-control form-control-sm SizeText select2" style="width: 100%;" required>
                      @foreach($data as $row)
                        <option class="SizeText" value="{{$row->id}}|{{$row->Contract_legis}}">{{$row->Contract_legis}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div id="type3">
              <div class="col-6">
                <div class="form-group row mb-1">
                  <label class="col-sm-4 col-form-label text-right">เลขที่สัญญา : </label>
                  <div class="col-sm-8">
                    <input type="text" name="Contract5[]" class="form-control form-control-sm SizeText" value="|" required/>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group row mb-0">
                <label class="col-sm-2 col-form-label text-right">หมายเหตุ : </label>
                <div class="col-sm-10">
                  <textarea name="NoteExpense" class="form-control form-control-sm SizeText" rows="5"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer text-right">
          <button type="submit" class="btn btn-sm btn-success SizeText hover-up">
            <i class="fas fa-save pr-1"></i>บันทึก
          </button>
        </div>
      </form>
  </section>
  <script>
    $('#type1').hide();
    $('#type2').hide();
    $('#type3').hide();
    $('.b').hide();
    $('.c').hide();
    $('.d').hide();
    $('.e').hide();
    $('#TypeExpense,#TopicExpense1,#TopicExpense2').on("input" ,function() {
        var GetType = document.getElementById('TypeExpense').value;
        var GetTopic1 = document.getElementById('TopicExpense1').value;
        var GetTopic2 = document.getElementById('TopicExpense2').value;
        console.log(GetType,GetTopic1,GetTopic2);
        if(GetType == 'ภายในศาล'){
          $('#type1').hide();
          $('#type2').show();
          $('.text1').text('ค่าใช้จ่าย :');
          $('.text2').text('เรื่อง :');
          $('.a').hide();
          $('.b').show();
          $('.c').hide();
          $('.d').hide();
          $('.e').hide();
        }
        else if(GetType == 'ค่าพิเศษ'){
          $('#type1').show();
          $('#type2').hide();
          $('.text1').text('ค่าใช้จ่าย :');
          $('.text2').text('เรื่อง :');
          $('.a').hide();
          $('.b').hide();
          $('.c').show();
          $('.d').hide();
          $('.e').hide();
          
        }
        else if(GetType == 'เบิกสำรองจ่าย'){
          $('#type1').hide();
          $('#type2').hide();
          $('#type3').hide();
          $('.text1').text('ยอดขอเบิก :');
          $('.text2').text('ยอดใช้จ่ายจริง :');
          $('.a').hide();
          $('.b').hide();
          $('.c').hide();
          $('.d').show();
          $('.e').hide();
        }
        else if(GetType == 'ค่าของกลาง'){
          $('#type1').hide();
          $('#type2').hide();
          $('.text1').text('ค่าใช้จ่าย :');
          $('.text2').text('เลขที่สัญญา :');
          $('.a').hide();
          $('.b').hide();
          $('.c').hide();
          $('.d').hide();
          $('.e').show();
        }
        else{
          $('#type1').hide();
          $('#type2').hide();
          $('.text1').text('ค่าใช้จ่าย :');
          $('.text2').text('เรื่อง :');
          $('.a').show();
          $('.b').hide();
          $('.c').hide();
          $('.d').hide();
          $('.e').hide();
        }

        if(GetType == 'ภายในศาล' && GetTopic1 == 'ลูกหนี้ฟ้องเก่า'){
          $('#type1').hide();
          $('#type2').hide();
          $('#type3').show();
        }
        else if(GetType == 'ค่าพิเศษ' && GetTopic2 == 'ลูกหนี้ฟ้องเก่า'){
          $('#type1').hide();
          $('#type2').hide();
          $('#type3').show();
        }
        else{
          $('#type3').hide();
        }

    });
  </script>
@elseif($type == 2) {{-- Details Expenses --}}
  <section class="content" style="font-family: 'Prompt', sans-serif;">
      <div class="card-header" style="background-image: url({{ asset('dist/img/bg1.jpg') }})">
        <h5 class="text-left">
          <b class="text-white">รายละเอียด <small class="textHeader">(ใบเสร็จ : {{$receoitNo}})</small></b>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">x</span>
          </button>
        </h5>
      </div>
        <div class="card-body SizeText" id="Cul-Payments">
        <h5 class="m-b-20 p-b-5">เรื่อง :  <span class="">{{$topic}}</span></h5>
          <div class="row">
            <div class="col-md-12">
                  <table class="table table-hover SizeText" id="tablee">
                    <thead>
                      <tr>
                        <th class="text-center" style="width: 5px">ลำดับ</th>
                        <th class="text-center" style="width: 100px">เลขที่สัญญา</th>
                        <th class="text-center" style="width: 150px">ชื่อ-สกุล</th>
                        <th class="text-right" style="width: 50px">ค่าใช้จ่าย</th>
                        <th class="text-center" style="width: 200px">หมายเหตุ</th>
                        <th class="text-center" style="width: 50px">#</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data as $key => $row)
                        <tr>
                          <td class="text-center">{{$key+1}}</td>
                          <td class="text-center">{{$row->Contract_expense}}</td>
                          <td class="text-left">{{$row->ExpenseTolegislation->Name_legis}}</td>
                          <td class="text-right">{{@number_format($row->Amount_expense,2)}}</td>
                          <td class="text-left">{{$row->Note_expense}}</td>
                          <td class="text-right">
                            <a target="_Blank" href="{{ route('MasterExpense.show',[$row->id]) }}?type={{4}}&Flagtype={{1}}&Groupcode={{$row->Code_expense}}" class="btn btn-warning btn-sm hover-up" data-toggle="tooltip" data-placement="top" title="ปริ้นใบเสร็จ">
                              <i class="fas fa-print"></i>
                            </a>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
            </div>
          </div>
        </div>
  </section>
  <script>
    $(document).ready(function() {
        $('#tablee').DataTable( {
            "responsive": true,
            "autoWidth": false,
            "ordering": false,
            "searching" : false,
            "lengthChange" : false,
            "info" : false,
            "pageLength": 5,
            "order": [[ 0, "asc" ]]
        });
    });
  </script>
@elseif($type == 3) {{-- Modal Edit Expenses --}}
  <section class="content" style="font-family: 'Prompt', sans-serif;">
      <div class="card-header" style="background-image: url({{ asset('dist/img/bg1.jpg') }})">
        <h5 class="text-left">
          <b class="text-white">แก้ไขค่าใช้จ่าย <small class="textHeader">(Edit Expenses)</small></b>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">x</span>
          </button>
        </h5>
      </div>
      @if($Flagtype == 1)
        <form name="form" action="{{ route('MasterExpense.update',$data->id) }}" method="post" id="quickForm" novalidate="novalidate" enctype="multipart/form-data">
          @csrf
          @method('put')
          <input type="hidden" name="type" value="1">
          <input type="hidden" name="_method" value="PATCH"/>
          <input type="hidden" name="UserEditExpense" value="{{ Auth::user()->name }}"/>
          <input type="hidden" name="FlagTab" value="{{$FlagTab}}">

          <div class="card-body SizeText" id="Cul-Payments">
            <div class="row">
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">วันที่เพิ่ม : </label>
                  <div class="col-sm-8">
                    <input type="date" id="DateExpense" name="DateExpense" class="form-control form-control-sm SizeText" value="{{$data->Date_expense}}" readonly/>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">ประเภท คชจ. : </label>
                  <div class="col-sm-8">
                    <select id="TypeExpense" name="TypeExpense" class="form-control form-control-sm SizeText" required>
                      <option value="" selected>--- ประเภทค่าใช้จ่าย ---</option>
                      <option value="ภายในศาล" {{ ($data->Type_expense === 'ภายในศาล') ? 'selected' : '' }}>ภายในศาล</option>
                      <option value="ค่าพิเศษ" {{ ($data->Type_expense === 'ค่าพิเศษ') ? 'selected' : '' }}>ค่าพิเศษ</option>
                      <option value="เบิกสำรองจ่าย" {{ ($data->Type_expense === 'เบิกสำรองจ่าย') ? 'selected' : '' }}>เบิกสำรองจ่าย</option>
                      <option value="ค่าของกลาง" {{ ($data->Type_expense === 'ค่าของกลาง') ? 'selected' : '' }}>ค่าของกลาง</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">ค่าใช้จ่าย : </label>
                  <div class="col-sm-8">
                    <input type="number" name="AmountExpense" class="form-control form-control-sm SizeText" maxlength="9" value="{{$data->Amount_expense}}" placeholder="0.00" required/>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">เรื่อง : </label>
                    <div class="col-sm-8 b">
                      <select name="TopicExpense" class="form-control form-control-sm SizeText" required>
                        <option value="">--- เลือกเรื่อง ---</option>
                        <option value="ค่าธรรมเนียมศาล" {{ ($data->Topic_expense === 'ค่าธรรมเนียมศาล') ? 'selected' : '' }}>1. ค่าธรรมเนียมศาล</option>
                        <option value="ค่าส่งหมายเรียกและสำเนาคำฟ้อง" {{ ($data->Topic_expense === 'ค่าส่งหมายเรียกและสำเนาคำฟ้อง') ? 'selected' : '' }}>2. ค่าส่งหมายเรียกและสำเนาคำฟ้อง</option>
                        <option value="ค่าฟ้องศาล" {{ ($data->Topic_expense === 'ค่าฟ้องศาล') ? 'selected' : '' }}>3. ค่าฟ้องศาล</option>
                        <option value="ค่าธรรมเนียมชั้นบังคับคดี" {{ ($data->Topic_expense === 'ค่าธรรมเนียมชั้นบังคับคดี') ? 'selected' : '' }}>4. ค่าธรรมเนียมชั้นบังคับคดี</option>
                        <option value="ค่าธรรมเนียมถอนการบังคับคดี" {{ ($data->Topic_expense === 'ค่าธรรมเนียมถอนการบังคับคดี') ? 'selected' : '' }}>5. ค่าธรรมเนียมถอนการบังคับคดี</option>
                        <option value="ค่าส่งหมายบังคับคดี" {{ ($data->Topic_expense === 'ค่าส่งหมายบังคับคดี') ? 'selected' : '' }}>6. ค่าส่งหมายบังคับคดี</option>
                        <option value="ค่าตรวจสอบหลักทรัพย์" {{ ($data->Topic_expense === 'ค่าตรวจสอบหลักทรัพย์') ? 'selected' : '' }}>7. ค่าตรวจสอบหลักทรัพย์</option>
                        <option value="ค่าอื่นๆ" {{ ($data->Topic_expense === 'ค่าอื่นๆ') ? 'selected' : '' }}>8. ค่าอื่นๆ</option>
                        <option value="ลูกหนี้ฟ้องเก่า" {{ ($data->Topic_expense === 'ลูกหนี้ฟ้องเก่า') ? 'selected' : '' }}>9. ลูกหนี้ฟ้องเก่า</option>
                      </select>
                    </div>
                </div>
              </div>
              <div class="col-6">

              </div>
              <div class="col-6">
                <div class="form-group row mb-3">
                  <label class="col-sm-4 col-form-label text-right text2">ผู้รับเงิน : </label>
                  <div class="col-sm-8">
                    <select name="LawyerName" class="form-control form-control-sm SizeText" required>
                      <option value="">--- เลือกผู้รับเงิน ---</option>
                      <option value="ทนายสมคิด แก้วสว่าง" {{ ($data->LawyerName_expense === 'ทนายสมคิด แก้วสว่าง') ? 'selected' : '' }}>1. ทนายสมคิด แก้วสว่าง</option>
                      <!-- <option value="อารีฟ หัสบู" {{ ($data->LawyerName_expense === 'อารีฟ หัสบู') ? 'selected' : '' }}>2. อารีฟ หัสบู</option> -->
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group row mb-0">
                  <label class="col-sm-2 col-form-label text-right">หมายเหตุ : </label>
                  <div class="col-sm-10">
                    <textarea name="NoteExpense" class="form-control form-control-sm SizeText" rows="5">{{$data->Note_expense}}</textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="submit" class="btn btn-sm btn-success SizeText hover-up">
              <i class="fas fa-save pr-1"></i>อัพเดท
            </button>
          </div>
        </form>
      @elseif($Flagtype == 2)
        <form name="form" action="{{ route('MasterExpense.update',$data[0]->Code_expense) }}" method="post" id="quickForm" novalidate="novalidate" enctype="multipart/form-data">
          @csrf
          @method('put')
          <input type="hidden" name="type" value="2">
          <input type="hidden" name="_method" value="PATCH"/>
          <input type="hidden" name="UserEditExpense" value="{{ Auth::user()->name }}"/>
          <input type="hidden" name="FlagTab" value="{{$FlagTab}}">

          <div class="card-body SizeText" id="Cul-Payments">
            <div class="row">
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">วันที่เพิ่ม : </label>
                  <div class="col-sm-8">
                    <input type="date" id="DateExpense" name="DateExpense" class="form-control form-control-sm SizeText" value="{{$data[0]->Date_expense}}" readonly/>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">ประเภท คชจ. : </label>
                  <div class="col-sm-8">
                    <select id="TypeExpense" name="TypeExpense" class="form-control form-control-sm SizeText" required>
                      <option value="" selected>--- ประเภทค่าใช้จ่าย ---</option>
                      <option value="ภายในศาล" {{ ($data[0]->Type_expense === 'ภายในศาล') ? 'selected' : '' }}>ภายในศาล</option>
                      <option value="ค่าพิเศษ" {{ ($data[0]->Type_expense === 'ค่าพิเศษ') ? 'selected' : '' }}>ค่าพิเศษ</option>
                      <option value="เบิกสำรองจ่าย" {{ ($data[0]->Type_expense === 'เบิกสำรองจ่าย') ? 'selected' : '' }}>เบิกสำรองจ่าย</option>
                      <option value="ค่าของกลาง" {{ ($data[0]->Type_expense === 'ค่าของกลาง') ? 'selected' : '' }}>ค่าของกลาง</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">ค่าใช้จ่าย : </label>
                  <div class="col-sm-8">
                    <input type="number" name="AmountExpense" class="form-control form-control-sm SizeText" maxlength="9" value="{{$data[0]->Amount_expense * $data[0]->Total}}" placeholder="0.00" required/>
                    <input type="hidden" name="TotalExpense" value="{{$data[0]->Total}}"/>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">เรื่อง : </label>
                    <div class="col-sm-8 c">
                      <select name="TopicExpense" class="form-control form-control-sm SizeText" required>
                        <option value="">--- เลือกเรื่อง ---</option>
                        <option value="ค่าถ่ายภาพ" {{ ($data[0]->Topic_expense === 'ค่าถ่ายภาพ') ? 'selected' : '' }}>1. ค่าถ่ายภาพ</option>
                        <option value="ค่ารับของกลาง" {{ ($data[0]->Topic_expense === 'ค่ารับของกลาง') ? 'selected' : '' }}>2. ค่ารับของกลาง</option>
                        <option value="ยื่นฟ้องคดี" {{ ($data[0]->Topic_expense === 'ยื่นฟ้องคดี') ? 'selected' : '' }}>3. ยื่นฟ้องคดี</option>
                        <option value="นำคำบังคับ" {{ ($data[0]->Topic_expense === 'นำคำบังคับ') ? 'selected' : '' }}>4. นำคำบังคับ</option>
                        <option value="คัดคำพิพากษา" {{ ($data[0]->Topic_expense === 'คัดคำพิพากษา') ? 'selected' : '' }}>5. คัดคำพิพากษา</option>
                        <option value="คัดทะเบียนราษฎร์" {{ ($data[0]->Topic_expense === 'คัดทะเบียนราษฎร์') ? 'selected' : '' }}>6. คัดทะเบียนราษฎร์</option>
                        <option value="เช็คเบอร์ลูกค้า" {{ ($data[0]->Topic_expense === 'เช็คเบอร์ลูกค้า') ? 'selected' : '' }}>7. เช็คเบอร์ลูกค้า</option>
                        <option value="คัดโฉนดเพื่อยึดทรัพย์" {{ ($data[0]->Topic_expense === 'คัดโฉนดเพื่อยึดทรัพย์') ? 'selected' : '' }}>8. คัดโฉนดเพื่อยึดทรัพย์</option>
                        <option value="สืบทรัพย์" {{ ($data[0]->Topic_expense === 'สืบทรัพย์') ? 'selected' : '' }}>9. สืบทรัพย์</option>
                        <option value="อื่นๆ" {{ ($data[0]->Topic_expense === 'อื่นๆ') ? 'selected' : '' }}>10. อื่นๆ</option>
                        <option value="ลูกหนี้ฟ้องเก่า" {{ ($data[0]->Topic_expense === 'ลูกหนี้ฟ้องเก่า') ? 'selected' : '' }}>11. ลูกหนี้ฟ้องเก่า</option>
                      </select>
                    </div>
                </div>
              </div>
              <div class="col-6">

              </div>
              <div class="col-6">
                <div class="form-group row mb-3">
                  <label class="col-sm-4 col-form-label text-right text2">ผู้รับเงิน : </label>
                  <div class="col-sm-8">
                    <select name="LawyerName" class="form-control form-control-sm SizeText" required>
                      <option value="">--- เลือกผู้รับเงิน ---</option>
                      <option value="พัชรินทร์ ทวีสุข" {{ ($data[0]->LawyerName_expense === 'พัชรินทร์ ทวีสุข') ? 'selected' : '' }}>1. พัชรินทร์ ทวีสุข</option>
                      <option value="จริยา บ้านนบ" {{ ($data[0]->LawyerName_expense === 'จริยา บ้านนบ') ? 'selected' : '' }}>2. จริยา บ้านนบ</option>
                      <option value="พรวิมล ทองปิด" {{ ($data[0]->LawyerName_expense === 'พรวิมล ทองปิด') ? 'selected' : '' }}>2. พรวิมล ทองปิด</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group row mb-0">
                  <label class="col-sm-2 col-form-label text-right">หมายเหตุ : </label>
                  <div class="col-sm-10">
                    <textarea name="NoteExpense" class="form-control form-control-sm SizeText" rows="5">{{$data[0]->Note_expense}}</textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="submit" class="btn btn-sm btn-success SizeText hover-up">
              <i class="fas fa-save pr-1"></i>อัพเดท
            </button>
          </div>
        </form>
      @elseif($Flagtype == 3)
        <form name="form" action="{{ route('MasterExpense.update',$data->id) }}" method="post" id="quickForm" novalidate="novalidate" enctype="multipart/form-data">
          @csrf
          @method('put')
          <input type="hidden" name="type" value="3">
          <input type="hidden" name="_method" value="PATCH"/>
          <input type="hidden" name="UserEditExpense" value="{{ Auth::user()->name }}"/>
          <input type="hidden" name="FlagTab" value="{{$FlagTab}}">

          <div class="card-body SizeText" id="Cul-Payments">
            <div class="row">
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">วันที่เพิ่ม : </label>
                  <div class="col-sm-8">
                    <input type="date" id="DateExpense" name="DateExpense" class="form-control form-control-sm SizeText" value="{{$data->Date_expense}}" readonly/>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">ประเภท คชจ. : </label>
                  <div class="col-sm-8">
                    <select id="TypeExpense" name="TypeExpense" class="form-control form-control-sm SizeText" required>
                      <option value="" selected>--- ประเภทค่าใช้จ่าย ---</option>
                      <option value="ภายในศาล" {{ ($data->Type_expense === 'ภายในศาล') ? 'selected' : '' }}>ภายในศาล</option>
                      <option value="ค่าพิเศษ" {{ ($data->Type_expense === 'ค่าพิเศษ') ? 'selected' : '' }}>ค่าพิเศษ</option>
                      <option value="เบิกสำรองจ่าย" {{ ($data->Type_expense === 'เบิกสำรองจ่าย') ? 'selected' : '' }}>เบิกสำรองจ่าย</option>
                      <option value="ค่าของกลาง" {{ ($data->Type_expense === 'ค่าของกลาง') ? 'selected' : '' }}>ค่าของกลาง</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">ยอดขอเบิก : </label>
                  <div class="col-sm-8">
                    <input type="number" id="AmountExpense" name="AmountExpense" class="form-control form-control-sm SizeText" maxlength="9" value="{{$data->Amount_expense}}" placeholder="0.00" readonly/>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">ยอดใช้จ่ายจริง : </label>
                    <div class="col-sm-8">
                      <input type="number" id="EditAmountExpense" name="EditAmountExpense" class="form-control form-control-sm SizeText" maxlength="9" value="{{$data->PayAmount_expense}}" required/>
                    </div>
                </div>
              </div>
              <div class="col-6">
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right text-red">ยอดคงเหลือ : </label>
                    <div class="col-sm-8">
                      <input type="number" id="BalanceExpense" name="BalanceExpense" class="form-control form-control-sm SizeText text-red" maxlength="9" value="{{$data->BalanceAmount_expense}}" readonly/>
                    </div>
                </div>
              </div>
              <div class="col-6">

              </div>
              <div class="col-6">
                <div class="form-group row mb-3">
                  <label class="col-sm-4 col-form-label text-right text2">ผู้รับเงิน : </label>
                  <div class="col-sm-8">
                    <select name="LawyerName" class="form-control form-control-sm SizeText" required>
                      <option value="">--- เลือกผู้รับเงิน ---</option>
                      <option value="พัชรินทร์ ทวีสุข" {{ ($data->LawyerName_expense === 'พัชรินทร์ ทวีสุข') ? 'selected' : '' }}>1. พัชรินทร์ ทวีสุข</option>
                      <option value="จริยา บ้านนบ" {{ ($data->LawyerName_expense === 'จริยา บ้านนบ') ? 'selected' : '' }}>2. จริยา บ้านนบ</option>
                      <option value="พรวิมล ทองปิด" {{ ($data->LawyerName_expense === 'พรวิมล ทองปิด') ? 'selected' : '' }}>2. พรวิมล ทองปิด</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group row mb-0">
                  <label class="col-sm-2 col-form-label text-right">หมายเหตุ : </label>
                  <div class="col-sm-10">
                    <textarea name="NoteExpense" class="form-control form-control-sm SizeText" rows="5">{{$data->Note_expense}}</textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="submit" class="btn btn-sm btn-success SizeText hover-up">
              <i class="fas fa-save pr-1"></i>อัพเดท
            </button>
          </div>
        </form>
        <script>
          $('#EditAmountExpense').on("input" ,function() {
              var GetEdit = $('#EditAmountExpense').val();
              if(GetEdit != ''){
                var BalanceExpense = parseFloat($('#AmountExpense').val()) - parseFloat($('#EditAmountExpense').val());
              }else{
                var BalanceExpense = $('#AmountExpense').val();
              }
              $('#BalanceExpense').val(BalanceExpense);
          });
        </script>
      @elseif($Flagtype == 4)
        <form name="form" action="{{ route('MasterExpense.update',$data->id) }}" method="post" id="quickForm" novalidate="novalidate" enctype="multipart/form-data">
          @csrf
          @method('put')
          <input type="hidden" name="type" value="4">
          <input type="hidden" name="_method" value="PATCH"/>
          <input type="hidden" name="UserEditExpense" value="{{ Auth::user()->name }}"/>
          <input type="hidden" name="FlagTab" value="{{$FlagTab}}">

          <div class="card-body SizeText" id="Cul-Payments">
            <div class="row">
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">วันที่เพิ่ม : </label>
                  <div class="col-sm-8">
                    <input type="date" id="DateExpense" name="DateExpense" class="form-control form-control-sm SizeText" value="{{$data->Date_expense}}" readonly/>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">ประเภท คชจ. : </label>
                  <div class="col-sm-8">
                    <select id="TypeExpense" name="TypeExpense" class="form-control form-control-sm SizeText" required>
                      <option value="" selected>--- ประเภทค่าใช้จ่าย ---</option>
                      <option value="ภายในศาล" {{ ($data->Type_expense === 'ภายในศาล') ? 'selected' : '' }}>ภายในศาล</option>
                      <option value="ค่าพิเศษ" {{ ($data->Type_expense === 'ค่าพิเศษ') ? 'selected' : '' }}>ค่าพิเศษ</option>
                      <option value="เบิกสำรองจ่าย" {{ ($data->Type_expense === 'เบิกสำรองจ่าย') ? 'selected' : '' }}>เบิกสำรองจ่าย</option>
                      <option value="ค่าของกลาง" {{ ($data->Type_expense === 'ค่าของกลาง') ? 'selected' : '' }}>ค่าของกลาง</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">ค่าใช้จ่าย : </label>
                  <div class="col-sm-8">
                    <input type="number" name="AmountExpense" class="form-control form-control-sm SizeText" maxlength="9" value="{{$data->Amount_expense}}" placeholder="0.00" required/>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group row mb-0">
                  <label class="col-sm-2 col-form-label text-right">หมายเหตุ : </label>
                  <div class="col-sm-10">
                    <textarea name="NoteExpense" class="form-control form-control-sm SizeText" rows="5">{{$data->Note_expense}}</textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="submit" class="btn btn-sm btn-success SizeText hover-up">
              <i class="fas fa-save pr-1"></i>อัพเดท
            </button>
          </div>
        </form>
      @endif
  </section>
@endif
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

  })
</script>

<script>
  $(function () {
    $('#quickForm').validate({
      // rules: {
      //   TypeExpense: {
      //     required: true
      //   },
      //   AmountExpense: {
      //     required: true
      //   },
      //   TopicExpense: {
      //     required: true
      //   },
      //   Contract: {
      //     required: true
      //   },
      // },
      // messages: {
      //   TypeExpense: {
      //     required: "โปรดเลือกประเภทค่าใช้จ่าย",
      //   },
      //   TopicExpense: {
      //     required: "โปรดเลือกเรื่องค่าใช้จ่าย",
      //   },
      //   AmountExpense: {
      //     required: "โปรดระบุค่าใช้จ่าย",
      //   },
      //   Contract: {
      //     required: "โปรดเลือกเลขที่สัญญา",
      //   }
      // },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
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

<script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
</script>
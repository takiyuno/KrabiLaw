<link rel="stylesheet" href="{{ asset('css/pluginLegislations.css') }}">
<script src="{{asset('js/pluginLegisCompro.js')}}"></script>

@if ($type == 4)    {{-- Modal Compro --}}
  <section class="content" style="font-family: 'Prompt', sans-serif;">
    <div class="card">
      <div class="card-header" style="background-image: url({{ asset('dist/img/bg1.jpg') }})">
        <h5 class="text-left">
          <b class="text-white">ข้อมูลประนอมหนี้ <small class="textHeader">(Debt Compromises)</small></b>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">x</span>
          </button>
        </h5>
      </div>
      @if ($data->TypeCon_legis == 'P01')
        <form name="form" action="{{ route('MasterCompro.store') }}" method="post" enctype="multipart/form-data" id="quickForm">
          @csrf
          <div class="card-body SizeText">
            <div class="justify-content-center mb-3" id="Convert-Cult2">
              <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading-1 SizeText"><i class="fas fa-toggle-on"></i> ยอดผ่อนชำระ : </h6>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row mb-0">
                    <label class="col-sm-4 col-form-label text-right SizeText">ประเภทประนอม :</label>
                    <div class="col-sm-8">
                      @php
                        $Settype = 'ประนอมขายฝาก';
                      @endphp
                      <input type="text" name="TypePromise" value="{{$Settype}}" class="form-control form-control-sm SizeText" />
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
                  <div class="form-group row mb-0">
                    <label class="col-sm-4 col-form-label text-right SizeText">เงินต้น :</label>
                    <div class="col-sm-8">
                      <input type="text" name="SHowTotal" id="TotalPrice" value="{{ (@$data->legisCompromise->Total_Promise != NULL) ?number_format($data->legisCompromise->Total_Promise,0): 0 }}" class="form-control form-control-sm SizeText" placeholder="0.00"/>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row mb-0">
                    <label class="col-sm-4 col-form-label text-right SizeText">ค่างวด :</label>
                    <div class="col-sm-8">
                      <input type="text" name="Installment" id="Installment" value="{{ (@$data->legisCompromise->DuePay_Promise != NULL) ?number_format($data->legisCompromise->DuePay_Promise,0): 0 }}" class="form-control form-control-sm Boxcolor SizeText" placeholder="0.00" required/>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row mb-0">
                    <label class="col-sm-4 col-form-label text-right SizeText">วันที่ประนอม :</label>
                    <div class="col-sm-8">
                      <input type="date" name="Dateinsert" value="{{ (@$data->legisCompromise->Date_Promise != NULL) ?@$data->legisCompromise->Date_Promise: date('Y-m-d') }}" class="form-control form-control-sm Boxcolor SizeText" />
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row mb-0">
                    <label class="col-sm-4 col-form-label text-right SizeText">ผู้ส่งประนอม :</label>
                    <div class="col-sm-8">
                      <input type="text" name="Userinsert" value="{{ (@$data->legisCompromise->User_Promise != NULL) ?@$data->legisCompromise->User_Promise: auth::user()->name }}" class="form-control form-control-sm Boxcolor SizeText" readonly/>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="text-right">
              <button type="submit" class="btn btn-sm btn-warning SizeText hover-up">
                <i class="fas fa-save"></i> บันทึก
              </button>
            </div>
          </div>

          <input type="hidden" name="type" value="1">
          <input type="hidden" name="id" value="{{$data->id}}">
        </form>
      @else
        <form name="form" action="{{ route('MasterCompro.store') }}" method="post" enctype="multipart/form-data" id="quickForm">
          @csrf
          <div class="card-body SizeText">
            <div class="justify-content-center mb-3" id="Convert-Cult">
              <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading-1 SizeText"><i class="fas fa-toggle-on"></i> คำนวณยอดประนอมหนี้ : </h6>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group row mb-0">
                      <label class="col-sm-4 col-form-label text-right SizeText">ประเภทประนอมหนี้ :</label>
                      <div class="col-sm-8">
                     
                          <select id="TypePromise" name="TypePromise" class="form-control form-control-sm SizeText" required>
                            <option value="" selected>--- เลือกประนอม ---</option>
                            <option value="ประนอมที่ศาล" {{ ($data->legisCompromise->Type_Promise === 'ประนอมที่ศาล') ? 'selected' : '' }}>01. ประนอมที่ศาล</option>
                            <option value="ประนอมที่บริษัท" {{ ($data->legisCompromise->Type_Promise === 'ประนอมที่บริษัท') ? 'selected' : '' }}>02. ประนอมหนี้ก่อนฟ้อง</option>
                            <option value="จำนำทรัพย์" {{ ($data->legisCompromise->Type_Promise === 'จำนำทรัพย์') ? 'selected' : '' }}>03. จำนำทรัพย์</option>
                            <option value="ประนอมขายฝาก" {{ ($data->legisCompromise->Type_Promise === 'ประนอมขายฝาก') ? 'selected' : '' }}>04. ประนอมขายฝาก</option>
                            <option value="ประนอมหนี้หลังยึดทรัพย์" {{ ($data->legisCompromise->Type_Promise === 'ประนอมหนี้หลังยึดทรัพย์') ? 'selected' : '' }}>05. ประนอมหนี้หลังยึดทรัพย์</option>
                          </select>
                        
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row mb-0">
                      <label class="col-sm-4 col-form-label text-right SizeText">วันที่ประนอม :</label>
                      <div class="col-sm-8">
                        <input type="date" name="Dateinsert" value="{{ @$data->legisCompromise->Date_Promise }}" class="form-control form-control-sm Boxcolor SizeText" />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group row mb-0">
                      <label class="col-sm-4 col-form-label text-right SizeText">ยอดคงเหลือ :</label>
                      <div class="col-sm-8">
                        <input type="text" name="TotalPrice" id="TotalPrice" value="{{ ($data->legisCompromise != NULL) ?$data->legisCompromise->TotalSum_Promise: '' }}" class="form-control form-control-sm Boxcolor SizeText" placeholder="0" required/>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row mb-0">
                      <label class="col-sm-4 col-form-label text-right SizeText">ยอดชำระแล้ว :</label>
                      <div class="col-sm-8">
                        <input type="text" name="TotalPaid" id="TotalPaid" value="{{ ($data->legisCompromise != NULL) ?$data->legisCompromise->TotalPaid_Promise: '' }}" class="form-control form-control-sm Boxcolor SizeText" placeholder="0" required/>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row mb-0">
                      <label class="col-sm-4 col-form-label text-right SizeText">ยอดค่าขาดประโยชน์ :</label>
                      <div class="col-sm-4">
                        <input type="text" name="Compensation" id="Compensation" value="{{ ($data->legisCompromise != NULL) ?$data->legisCompromise->Compen_Promise: '' }}" class="form-control form-control-sm Boxcolor SizeText" placeholder="0" required/>
                      </div>
                      <div class="col-sm-4">
                        <input type="number" name="PercentCompensation" id="PercentCompensation" value="{{ ($data->legisCompromise != NULL) ?$data->legisCompromise->P_Compen_Promise: '' }}" maxlength="2" class="form-control form-control-sm Boxcolor SizeText" placeholder="10% - 50%" required/>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row mb-0">
                      <label class="col-sm-4 col-form-label text-right SizeText">ทุนทรัพย์ :</label>
                      <div class="col-sm-8">
                        <input type="text" name="TotalCapital" id="TotalCapital" value="{{ ($data->legisCompromise != NULL) ?$data->legisCompromise->TotalCapital_Promise: '' }}" class="form-control form-control-sm SizeText" placeholder="0" readonly/>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6">
                    <div class="form-group row mb-0">
                      <label class="col-sm-4 col-form-label text-right SizeText">ค่าธรรมเนียม/ค่าใช้จ่าย :</label>
                      <div class="col-sm-4">
                        <input type="text" name="FeePrire" id="FeePrire" value="{{ ($data->legisCompromise != NULL) ?$data->legisCompromise->FeePrire_Promise: '' }}" class="form-control form-control-sm SizeText" placeholder="0" readonly/>
                      </div>
                      <div class="col-sm-4">
                        <input type="number" name="PercentFeePrire" id="PercentFeePrire" value="{{ ($data->legisCompromise != NULL) ?$data->legisCompromise->P_FeePrire_Promise: '' }}" maxlength="3" class="form-control form-control-sm Boxcolor SizeText" placeholder="0% - 100%" required/>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row mb-0">
                      <label class="col-sm-4 col-form-label text-right SizeText">ต้นทุน :</label>
                      <div class="col-sm-8">
                        <input type="text" name="TotalCost" id="TotalCost" value="{{ ($data->legisCompromise != NULL) ?$data->legisCompromise->TotalCost_Promise: '' }}" class="form-control form-control-sm Boxcolor SizeText" placeholder="0" required/>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row mb-0">
                      <label class="col-sm-4 col-form-label text-right SizeText">เงินก้อนแรก :</label>
                      <div class="col-sm-4">
                        <input type="text" name="firstMoney" id="firstMoney" value="{{ ($data->legisCompromise != NULL) ?$data->legisCompromise->Payall_Promise: '' }}" class="form-control form-control-sm SizeText" placeholder="0" readonly/>
                      </div>
                      <div class="col-sm-4">
                        <input type="text" name="PercentfirstMoney" id="PercentfirstMoney" value="{{ ($data->legisCompromise != NULL) ?$data->legisCompromise->P_Payall_Promise: '' }}" maxlength="2" class="form-control form-control-sm Size Boxcolor SizeText" placeholder="5% - 20%" required/>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row mb-0">
                      <label class="col-sm-4 col-form-label text-right SizeText">ยอดประนอมหนี้ :</label>
                      <div class="col-sm-8">
                        <input type="text" name="SHowTotal" id="SHowTotal" value="{{ ($data->legisCompromise != NULL) ?$data->legisCompromise->Total_Promise: '' }}" class="form-control form-control-sm SizeText" placeholder="0" readonly/>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row mb-0">
                      <label class="col-sm-4 col-form-label text-right SizeText">ค่างวด :</label>
                      <div class="col-sm-4">
                        <input type="text" name="Installment" id="Installment" value="{{ ($data->legisCompromise != NULL) ?$data->legisCompromise->DuePay_Promise: '' }}" class="form-control form-control-sm Boxcolor SizeText" placeholder="0" required/>
                      </div>
                      <div class="col-sm-4">
                        <input type="text" name="PercentInstallment" id="PercentInstallment" value="{{ ($data->legisCompromise != NULL) ?$data->legisCompromise->P_DuePay_Promise: '' }}" maxlength="3" class="form-control form-control-sm Boxcolor SizeText" placeholder="50% - 100%" required/>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row mb-0">
                      <label class="col-sm-4 col-form-label text-right SizeText">ค่างวด/ระยะเวลาผ่อน :</label>
                      <div class="col-sm-4">
                        <input type="text" name="ShowDue" id="ShowDue" value="{{ ($data->legisCompromise != NULL) ?$data->legisCompromise->ShowDue_Promise: '' }}" class="form-control form-control-sm SizeText" placeholder="0" readonly/>
                      </div>
                      <div class="col-sm-4">
                        <input type="number" name="ShowPeriod" id="ShowPeriod" value="{{ ($data->legisCompromise != NULL) ?$data->legisCompromise->ShowPeriod_Promise: '' }}" class="form-control form-control-sm SizeText" placeholder="0" readonly/>
                      </div>
                    </div>
                  </div>
                </div>
              <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600 SubHeading-1 SizeText"><i class="fas fa-toggle-on"></i> ยอดผ่อนชำระ : </h6>
                <div class="row mb-3">
                  <div class="col-md-6">
                    <div class="form-group row mb-0">
                      <label class="col-sm-4 col-form-label text-right SizeText">ยอดประนอมหนี้ :</label>
                      <div class="col-sm-8">
                        <input type="text" name="CompoundTotal_1" id="CompoundTotal_1" value="{{ ($data->legisCompromise != NULL) ?$data->legisCompromise->CompoundTotal_1: '' }}" class="form-control form-control-sm SizeText" placeholder="0.00" readonly/>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row mb-0">
                      <label class="col-sm-4 col-form-label text-right SizeText">เงินก้อนแรก :</label>
                      <div class="col-sm-8">
                        <input type="text" name="First_1" id="First_1" value="{{ ($data->legisCompromise != NULL) ?$data->legisCompromise->FirstManey_1: '' }}" class="form-control form-control-sm Boxcolor SizeText" placeholder="0.00" required/>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row mb-0">
                      <label class="col-sm-4 col-form-label text-right SizeText">ค่างวด/ระยะเวลาผ่อน :</label>
                      <div class="col-sm-4">
                        <input type="text" name="Due_1" id="Due_1" value="{{ ($data->legisCompromise != NULL) ?$data->legisCompromise->Due_1: '' }}" class="form-control form-control-sm Boxcolor SizeText" placeholder="0.00" required/>
                      </div>
                      <div class="col-sm-4">
                        <input type="number" name="Period_1" id="Period_1" value="{{ ($data->legisCompromise != NULL) ?$data->legisCompromise->Period_1: '' }}" class="form-control form-control-sm Boxcolor SizeText" placeholder="จำนวนงวด" required/>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row mb-0">
                      <label class="col-sm-4 col-form-label text-right SizeText">กำไรไม่หักภาษี/เปอร์เซ็น :</label>
                      <div class="col-sm-4">
                        <input type="text" name="Profit_1" id="Profit_1" value="{{ ($data->legisCompromise != NULL) ?$data->legisCompromise->Profit_1: '' }}" class="form-control form-control-sm SizeText" placeholder="0.00" readonly/>
                      </div>
                      <div class="col-sm-4">
                        <input type="text" name="PercentProfit_1" id="PercentProfit_1" value="{{ ($data->legisCompromise != NULL) ?$data->legisCompromise->PercentProfit_1: '' }}" class="form-control form-control-sm SizeText" placeholder="%" readonly/>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="text-right">
              <button type="submit" class="btn btn-sm btn-warning SizeText hover-up">
                <i class="fas fa-save"></i> บันทึก
              </button>
            </div>
          </div>

          <input type="hidden" name="type" value="1">
          <input type="hidden" name="id" value="{{$data->id}}">
        </form>
      @endif
    </div>
  </section>
@elseif($type == 5) {{-- Modal Payments --}}
  <section class="content" style="font-family: 'Prompt', sans-serif;">
    <div class="card">
      <div class="card-header" style="background-image: url({{ asset('dist/img/bg1.jpg') }})">
        <h5 class="text-left">
          <b class="text-white">รับชำระค่างวด <small class="textHeader">(New Payments)</small></b>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">x</span>
          </button>
        </h5>
      </div>
      <form name="form" action="{{ route('MasterCompro.update', $id) }}" method="post" id="formimage" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="card-body SizeText" id="Cul-Payments">
          <div class="row">
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">วันที่รับชำระ : </label>
                <div class="col-sm-8">
                  <input type="date"  id="DatePayment" name="DatePayment" class="form-control form-control-sm SizeText" value="{{date('Y-m-d') }}" />
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">ผู้รับชำระ : </label>
                <div class="col-sm-8">
                  <input type="text" name="AdduserPayment" class="form-control form-control-sm" value="{{ Auth::user()->name }}" readonly/>
                </div>
              </div>
            </div>
            @php
              $SetFirstMoney = 0;
              if($data->legisCompromise != NULL){
               // if($data->legisCompromise->FirstManey_1 > 0){
                  $SetFirstMoney =floatval($data->legisCompromise->FirstManey_1 )- floatval($data->legisCompromise->Sum_FirstPromise)  ;
               // }
                // else{
                //   $SetFirstMoney = floatval($data->legisCompromise->Sum_FirstPromise) - floatval($data->legisCompromise->Payall_Promise);
                // }
              }
           // dd($SetFirstMoney);
            @endphp
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">ประเภทชำระ : </label>
                <div class="col-sm-8">
                  <select id="TypePayment" name="TypePayment" class="form-control form-control-sm SizeText Boxcolor" required>
                    <option value="" selected>--- ประเภทชำระ ---</option>
                    @if( $SetFirstMoney>0)
                    <option value="เงินก้อนแรก(เงินสด)" {{ (@$data->TypeCon_legis == 'P01') ? 'disabled' : '' }}>T01. เงินก้อนแรก(เงินสด)</option>
                    <option value="เงินก้อนแรก(เงินโอน)" {{ (@$data->TypeCon_legis == 'P01') ? 'disabled' : '' }}>T02. เงินก้อนแรก(เงินโอน)</option>
                    @endif
                    <option value="ชำระเงินสด" {{ ($SetFirstMoney <= 0) ? '' : 'disabled' }}>T03. ชำระเงินสด</option>
                    <option value="ชำระผ่านโอน" {{ ($SetFirstMoney <= 0) ? '' : 'disabled' }}>T04. ชำระผ่านโอน</option>
                    {{-- <option value="ชำระผ่านธนานัติ" {{ ($SetFirstMoney >= 0) ? '' : 'disabled' }}>T05. ชำระผ่านธนานัติ</option> --}}
                  </select>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">ยอดรับชำระ : </label>
                <div class="col-sm-8">
                  <input type="text" name="Cash" id="Cash" class="form-control form-control-sm SizeText Boxcolor" maxlength="9" placeholder="0.00" readonly required/>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">โอนเข้าบัญชี : </label>
                <div class="col-sm-8">
                  <select id="BankIn" name="BankIn" class="form-control form-control-sm SizeText Boxcolor" disabled >
                    <option value="SV" >SV</option>
                    <option value="กรุงศรี 5100-5" >กรุงศรี 5100-5</option>
                    <option value="กสิกร 2479-9">กสิกร 2479-9</option>
                    <option value="กรุงไทย 0134-6">กรุงไทย 0124-9</option>
                  </select>
                </div>
              </div>
            </div>
            @if($data->legisCompromise->Discount_Promise == 0)
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right">ส่วนลด : </label>
                  <div class="col-sm-8">
                    <input type="text" name="Discount" id="Discount" class="form-control form-control-sm SizeText" maxlength="9" placeholder="0.00" readonly/>
                  </div>
                </div>
              </div>
            @endif
            <div class="col-12">
              <div class="form-group row mb-0">
                <label class="col-sm-2 col-form-label text-right">หมายเหตุ : </label>
                <div class="col-sm-10">
                  <textarea name="NotePayment" class="form-control form-control-sm SizeText" rows="3"></textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="text-right mt-3">
            <button type="submit" class="btn btn-sm btn-success SizeText hover-up">
              <i class="fas fa-check"></i> รับชำระ
            </button>
          </div>
        </div>
        @php
          $CashDue = 0;
          if($data->legisCompromise != NULL){
            if($data->legisCompromise->Due_1 != 0){
              $CashDue = $data->legisCompromise->Due_1;
            }
            else{
              $CashDue = $data->legisCompromise->DuePay_Promise;
            }
          }
        @endphp
        <input type="hidden" id="DateDuePay" name="DateDuePay" value="{{ ($data->legispayments != NULL) ?$data->legispayments->DateDue_Payment: $data->legisCompromise->Date_Promise }}"/>
        <input type="hidden" id="defCash" name="defCash" value="{{ $CashDue }}"/>
        <input type="hidden" id="DateDue" name="DateDue"/>

        <input type="hidden" name="idCompro" value="{{ $data->legisCompromise->id }}"/>
        <input type="hidden" name="type" value="1"/>
        <input type="hidden" name="_method" value="PATCH"/>
      </form>
    </div>

    <script>
      $('#Cul-Payments').on('input', function() {
        var TypePayment = $('#TypePayment').val();
        var DatePayment = $('#DatePayment').val();  //วันปัจจุบัน
        var DateDuePay = $('#DateDuePay').val(); 
        //alert(DatePayment);   //วันชำระล่าสุด
        var GetCash = $('#Cash').val();          
        var Cash = GetCash.replace(",","");         //ยอดเงิน
        var defCash = $('#defCash').val();          //ยอดค่างวด
        var Discount = $('#Discount').val();        //สว่นลด

        var DateDue = '';
        $("#Cash").removeAttr("readonly");
        $("#Discount").removeAttr("readonly");

        if (TypePayment == 'เงินก้อนแรก(เงินสด)' || TypePayment == 'เงินก้อนแรก(เงินโอน)') {
          if (DateDuePay != '') {
            var DateDue = moment(DateDuePay).add(1, 'months').format('YYYY-MM-DD');
          }else{
            var DateDue = moment(DatePayment).add(1, 'months').format('YYYY-MM-DD');
          }
        }else{
          var round = Math.floor(Cash/defCash); //รอบวนลูป
          if (round == 0) {
            var Setround = 1;
          }else{
            var Setround = round;
          }
          console.log(round);
          var DateDue = moment(DateDuePay).add(Setround, 'months').format('YYYY-MM-DD');
        }

        $('#Cash').val(addCommas(Cash));
        $('#Discount').val(addCommas(Discount));
        $('#DateDue').val(DateDue);
      });
      $('#TypePayment').on('change',function(){
      var payType= $('#TypePayment').val();
      if(payType=="เงินก้อนแรก(เงินโอน)" || payType=="ชำระผ่านโอน" ){
          $("#BankIn").removeAttr('disabled'); 
          $("#BankIn").attr("required", "true");
      }else{
        $("#BankIn").attr('disabled','disabled');
        $("#BankIn").removeAttr("required");
      }
    });
    </script>
  </section>
@elseif($type == 6) {{-- Modal Trackings --}}
  <section class="content" style="font-family: 'Prompt', sans-serif;">
    <div class="card">
      <div class="card-header" style="background-image: url({{ asset('dist/img/bg1.jpg') }})">
        <h5 class="text-left">
          <b class="text-white">บันทึกติดตาม <small class="textHeader">(Tracking Debters)</small></b>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">x</span>
          </button>
        </h5>
      </div>
      <form name="form" action="{{ route('MasterCompro.update', $id) }}" method="post" id="formimage" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="card-body SizeText" id="Cul-Payments">
          <div class="row">
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">สถานะติดตาม : </label>
                <div class="col-sm-8">
                  <select id="StatusTrack" name="StatusTrack" class="form-control form-control-sm SizeText" required>
                    <option value="" selected>--- สถานะ ---</option>
                    <option value="ติดต่อได้">T01. ติดต่อได้</option>
                    <option value="ไม่รับสาย">T02. ไม่รับสาย</option>
                    <option value="เบอร์ติดต่อผิด">T03. เบอร์ติดต่อผิด</option>
                    <option value="เบอร์ติดต่อถูกระงับ">T04. เบอร์ติดต่อถูกระงับ</option>
                    <option value="ไม่มีเลขหมายปลายทาง">T05. ไม่มีเลขหมายปลายทาง</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">วันที่นัดชำระ : </label>
                <div class="col-sm-8">
                  <input type="date" name="DateDueTrack" class="form-control form-control-sm SizeText"/>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">ผู้ลงบันทึก : </label>
                <div class="col-sm-8">
                  <input type="text" name="Users" value="{{ Auth::user()->name }}" class="form-control form-control-sm SizeText" readonly/>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">วันที่บันทึก : </label>
                <div class="col-sm-8">
                  <input type="date" name="JobNumber" value="{{date('Y-m-d') }}" class="form-control form-control-sm SizeText" readonly/>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group row mb-0">
                <label class="col-sm-2 col-form-label text-right">รายละเอียด : </label>
                <div class="col-sm-10">
                  <textarea name="NoteTrack" class="form-control form-control-sm SizeText" rows="3"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer text-right">
          <button type="submit" class="btn btn-sm bg-gray SizeText hover-up">
            <i class="fas fa-save"></i> บันทึก
          </button>
        </div>

        <input type="hidden" name="type" value="3"/>
        <input type="hidden" name="_method" value="PATCH"/>
      </form>
    </div>
  </section>
@elseif($type == 7) {{-- Modal รายงาน รับชำระค่างวด --}}
  <section class="content" style="font-family: 'Prompt', sans-serif;">
    <div class="card">
      <div class="card-header" style="background-image: url({{ asset('dist/img/bg1.jpg') }})">
        <h5 class="text-left">
          <b class="text-white">รายงาน รับชำระค่างวด <small class="textHeader">(Payments Report)</small></b>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">x</span>
          </button>
        </h5>
      </div>
      <form name="form" target="_blank" action="{{ route('LegisCompro.Report') }}" method="get" id="formimage" enctype="multipart/form-data">
        @csrf
        <div class="card-body SizeText" id="Cul-Payments">
          <div class="row">
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">จากวันที่ : </label>
                <div class="col-sm-8">
                  <input type="date" name="Fdate" value="{{ date('Y-m-d') }}" class="form-control form-control-sm SizeText"/>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">ถึงวันที่ : </label>
                <div class="col-sm-8">
                  <input type="date" name="Tdate" value="{{ date('Y-m-d') }}" class="form-control form-control-sm SizeText"/>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">ผู้รับชำระ : </label>
                <div class="col-sm-8">
                  <select name="CashReceiver" class="form-control form-control-sm SizeText">
                    <option value="" selected>--- เลือกผู้รับชำระ ---</option>
                    @foreach ($User as $key => $value)
                      <option value="{{$value->name}}">{{$key+1}}. {{$value->name}}</option>
                    @endforeach
                  </select>
                </div>
              </select>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">รูปแบบเอกสาร : </label>
                <div class="col-sm-8">
                  <select name="Flag" class="form-control form-control-sm SizeText" required>
                    <option value="" selected>--- เลือกแบบเอกสาร ---</option>
                    <option value="2">01. Excel</option>
                    <option value="1">02. PDF</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer text-right">
          <button type="submit" class="btn btn-sm bg-info SizeText hover-up">
            <i class="fas fa-print"></i> พิมพ์
          </button>
        </div>

        <input type="hidden" name="type" value="4"/>
      </form>
    </div>
  </section>
@elseif($type == 8) {{-- Modal รายงาน ลูกหนี้ชำระตามดิว --}}
  <section class="content" style="font-family: 'Prompt', sans-serif;">
    <div class="card">
      <div class="card-header" style="background-image: url({{ asset('dist/img/bg1.jpg') }})">
        <h5 class="text-left">
          <b class="text-white">รายงาน ลูกหนี้ชำระตามดิว <small class="textHeader">(DueCustomers Report)</small></b>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">x</span>
          </button>
        </h5>
      </div>
      <form name="form" target="_blank" action="{{ route('LegisCompro.Report') }}" method="get" id="formimage" enctype="multipart/form-data">
        @csrf
        <div class="card-body SizeText">
          <div class="row">
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">จากวันที่ : </label>
                <div class="col-sm-8">
                  <input type="date" name="Fdate" value="{{ date('Y-m-d') }}" class="form-control form-control-sm SizeText" required/>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">ถึงวันที่ : </label>
                <div class="col-sm-8">
                  <input type="date" name="Tdate" value="{{ date('Y-m-d') }}" class="form-control form-control-sm SizeText" required/>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">ประเภทลูกหนี้ : </label>
                <div class="col-sm-8">
                  <select name="typeCus" class="form-control form-control-sm SizeText">
                    <option value="" selected>--- ประเภทลูกหนี้ ---</option>
                    <option value="Y">01. ลูกหนี้ประนอมใหม่</option>
                    <option value="C">02. ลูกหนี้ประนอมเก่า</option>
                  </select>
                </div>
              </select>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">รูปแบบเอกสาร : </label>
                <div class="col-sm-8">
                  <select name="FlagDoc" class="form-control form-control-sm SizeText" required>
                    <option value="" selected>--- เลือกแบบเอกสาร ---</option>
                    <option value="1">01. Excel</option>
                    <option value="2">02. PDF</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer text-right">
          <button type="submit" class="btn btn-sm bg-info SizeText hover-up">
            <i class="fas fa-print"></i> พิมพ์
          </button>
        </div>

        <input type="hidden" name="type" value="6"/>
      </form>
    </div>
  </section>
@elseif($type == 9) {{-- Modal Edit Payments --}}
  <section class="content" style="font-family: 'Prompt', sans-serif;">
    <div class="card">
      <div class="card-header bg-warning">
        <h5 class="text-left">
          <b class="text-white">รายการชำระค่างวด <small class="textHeader">(Edit Payments)</small></b>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">x</span>
          </button>
        </h5>
      </div>
      <form name="form" action="{{ route('MasterCompro.update', $id) }}" method="post" id="formimage" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="card-body SizeText" id="Cul-Payments">
          <div class="row">
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">วันที่รับชำระ : </label>
                <div class="col-sm-8">
                  <input type="date" class="form-control form-control-sm SizeText" value="{{ substr($data->created_at,0,10) }}" readonly/>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">ผู้รับชำระ : </label>
                <div class="col-sm-8">
                  <input type="text" class="form-control form-control-sm SizeText" value="{{$data->Adduser_Payment}}" readonly/>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">ประเภทชำระ : </label>
                <div class="col-sm-8">
                  <select id="TypePayment" name="TypePayment" class="form-control form-control-sm SizeText Boxcolor">
                    <option value="" selected>--- ประเภทชำระ ---</option>
                    <option value="เงินก้อนแรก(เงินสด)" {{ ($data->Type_Payment == 'เงินก้อนแรก(เงินสด)') ? 'selected' : '' }}>T01. เงินก้อนแรก(เงินสด)</option>
                    <option value="เงินก้อนแรก(เงินโอน)" {{ ($data->Type_Payment == 'เงินก้อนแรก(เงินโอน)') ? 'selected' : '' }}>T02. เงินก้อนแรก(เงินโอน)</option>
                    <option value="ชำระเงินสด" {{ ($data->Type_Payment == 'ชำระเงินสด') ? 'selected' : '' }}>T03. ชำระเงินสด</option>
                    <option value="ชำระผ่านโอน" {{ ($data->Type_Payment == 'ชำระผ่านโอน') ? 'selected' : '' }}>T04. ชำระผ่านโอน</option>
                    <option value="ชำระผ่านธนานัติ" {{ ($data->Type_Payment == 'ชำระผ่านธนานัติ') ? 'selected' : '' }}>T05. ชำระผ่านธนานัติ</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">ยอดรับชำระ : </label>
                <div class="col-sm-8">
                  <input type="text" name="Cash" id="Cash" value="{{number_format($data->Gold_Payment,0)}}" class="form-control form-control-sm SizeText Boxcolor" maxlength="9"/>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">โอนเข้าบัญชี : </label>
                <div class="col-sm-8">
                  <select id="BankIn" name="BankIn" class="form-control form-control-sm SizeText Boxcolor">
                    <option value="" selected>--- ประเภทชำระ ---</option>
                    <option value="SV" {{ ($data->BankIn == 'SV') ? 'selected' : '' }}>SV</option>
                    <option value="กรุงศรี 5100-5" {{ ($data->BankIn == 'กรุงศรี 5100-5') ? 'selected' : '' }}>กรุงศรี 5100-5</option>
                    <option value="กสิกร 2479-9" {{ ($data->BankIn == 'กสิกร 2479-9') ? 'selected' : '' }}>กสิกร 2479-9</option>
                    <option value="กรุงไทย 0134-6" {{ ($data->BankIn == 'กรุงไทย 0124-9') ? 'selected' : '' }}>กรุงไทย 0124-9</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">ส่วนลด : </label>
                <div class="col-sm-8">
                  <input type="text" name="Discount" id="Discount" value="{{ (@$data->Discount_Payment != NULL) ?number_format(@$data->Discount_Payment,0) : '' }}" class="form-control form-control-sm SizeText Boxcolor" maxlength="9" placeholder="0.00"/>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">วันดิวงวดถัดไป : </label>
                <div class="col-sm-8">
                  <input type="date" name="DateDue" id="DateDue" value="{{ $data->DateDue_Payment }}" class="form-control form-control-sm SizeText Boxcolor" readonly/>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group row mb-0">
                <label class="col-sm-2 col-form-label text-right">หมายเหตุ : </label>
                <div class="col-sm-10">
                  <textarea name="NotePayment" class="form-control form-control-sm SizeText" rows="3">{{@$data->Note_Payment}}</textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="text-right mt-3">
            <button type="submit" class="btn btn-sm btn-warning SizeText hover-up">
              <i class="fa-solid fa-square-caret-down"></i>  อัพเดต
            </button>
          </div>
        </div>

        @php
          if (@$Paylast != NULL) {
            $SetDateDue = $Paylast->DateDue_Payment;
          }else {
            $SetDateDue = $data->PaymentToCompro->Date_Promise;
          }

          $CashDue = 0;
          if($data->PaymentToCompro->Due_1 != 0){
            $CashDue = $data->PaymentToCompro->Due_1;
          }else{
            $CashDue = $data->PaymentToCompro->DuePay_Promise;
          }
        @endphp

        <input type="hidden" id="DateDuePay" name="DateDuePay" value="{{$SetDateDue }}"/>
        <input type="hidden" id="defCash" name="defCash" value="{{ $CashDue }}"/>

        <input type="hidden" name="idCompro" value="{{ $data->PaymentToCompro->id }}"/>
        <input type="hidden" name="type" value="4"/>
      </form>
    </div>
  </section>

  <script>
    $('#Cul-Payments').on('input', function() {
      var TypePayment = $('#TypePayment').val();
      var DatePayment = $('#DatePayment').val();  //วันปัจจุบัน
      var DateDuePay = $('#DateDuePay').val();    //วันชำระล่าสุด
      var GetCash = $('#Cash').val();          
      var Cash = GetCash.replace(",","");         //ยอดเงิน
      var defCash = $('#defCash').val();          //ยอดค่างวด
      var Discount = $('#Discount').val();        //สว่นลด

      var DateDue = '';
      $("#Cash").removeAttr("readonly");
      $("#Discount").removeAttr("readonly");

      if (TypePayment == 'เงินก้อนแรก(เงินสด)' || TypePayment == 'เงินก้อนแรก(เงินโอน)') {
        if (DateDuePay != '') {
          var DateDue = moment(DateDuePay).add(1, 'months').format('YYYY-MM-DD');
        }else{
          var DateDue = moment(DatePayment).add(1, 'months').format('YYYY-MM-DD');
        }
      }else{
        var round = Math.floor(Cash/defCash); //รอบวนลูป
        if (round == 0) {
          var Setround = 1;
        }else{
          var Setround = round;
        }
        var DateDue = moment(DateDuePay).add(Setround, 'months').format('YYYY-MM-DD');
      }

      $('#Cash').val(addCommas(Cash));
      $('#Discount').val(addCommas(Discount));
      $('#DateDue').val(DateDue);
    });
   
    $('#TypePayment').on('change',function(){
      var payType= $('#TypePayment').val();
      if(payType=="เงินก้อนแรก(เงินโอน)" || payType=="ชำระผ่านโอน" ){
          $("#BankIn").removeAttr('disabled'); 
      }else{
        $("#BankIn").attr('disabled','disabled');
      }
    });
  </script>
@endif

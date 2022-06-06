<link rel="stylesheet" href="{{ asset('css/pluginLegislations.css') }}">

@if ($type == 1)    {{-- ยืนยันการยื่นฟ้อง --}}
  <section class="content" style="font-family: 'Prompt', sans-serif;">
    <div class="card">
      <div class="card-header" style="background-image: url({{ asset('dist/img/bg1.jpg') }})">
        <h5 class="text-left">
          <b class="text-white">ยืนยันการยื่นฟ้อง <small class="textHeader">(File Lawsuit)</small></b>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">x</span>
            </button>
        </h5>
      </div>
      <form name="form" action="{{ route('MasterLegis.update', $datalegis->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="card-body SizeText">
          <div class="d-flex justify-content-center mb-3">
            <h4 class="top prem">เลขสัญญา.</h4>
            <h4 class="head">{{$datalegis->Contract_legis}}</h4>
          </div>
          <div class="d-flex justify-content-center mb-3">
            <!-- <i class="fa fa-arrows-alt icon1"></i><i class="fa fa-laptop icon2"></i> -->
            <i class="fab fa-creative-commons-by icon2"></i>
          </div>
          <div class="justify-content-center">
            <div class="row">
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right text-red"> วันที่ยื่นฟ้อง :</label>
                  <div class="col-sm-8">
                    <input type="date" name="DateCourt" class="form-control form-control-sm SizeText Boxcolor" required/>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right text-red"> ผู้ส่งฟ้อง :</label>
                  <div class="col-sm-8">
                    <select name="Plaintiff" id="Plaintiff" class="form-control form-control-sm SizeText Boxcolor" required>
                      <option selected value="">---- ทนายความ ----</option>
                      <option value="ทนายสมคิด แก้วสว่าง">01. สมคิด แก้วสว่าง</option>
                      <!-- <option value="ทนายซารีพะ ยูโซะ">02. ทนายซารีพะ ยูโซะ</option> -->
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right text-red"> ชื่อลูกหนี้ :</label>
                  <div class="col-sm-8">
                    <input type="text" value="{{$datalegis->Name_legis}}" class="form-control form-control-sm SizeText"/>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right text-red"> เลขประชาชน :</label>
                  <div class="col-sm-8">
                    <input type="text" value="{{$datalegis->Idcard_legis}}" class="form-control form-control-sm SizeText" data-inputmask="&quot;mask&quot;:&quot;9-9999-99999-99-9&quot;" data-mask=""/>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-info hover-up" style="color:#ffff";>
            <i class="fas fa-check pr-1"></i>ตกลง
          </button>
        </div>

        <input type="hidden" name="type" value="1">
        <input type="hidden" name="_method" value="PATCH"/>
      </form>
    </div>
  </section>
@elseif($type == 2 or $type == 7) {{-- ปิดบัญชี --}}
  <section class="content" style="font-family: 'Prompt', sans-serif;">
    <div class="card">
      <div class="card-header" style="background-image: url({{ asset('dist/img/bg1.jpg') }})">
        <h5 class="text-left">
          <b class="text-white">ปิดบัญชีลูกหนี้ <small class="textHeader">(Releasee Debts)</small></b>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">x</span>
            </button>
        </h5>
      </div>
      <form name="form" class="form" action="{{ route('MasterLegis.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card-body SizeText">
          <div class="d-flex justify-content-center mb-3">
            <h4 class="top prem">เลขสัญญา.</h4>
            <h4 class="head">{{$datalegis->Contract_legis}}</h4>
          </div>
          <div class="d-flex justify-content-center mb-3">
            <i class="fas fa-check icon1"></i><i class="fas fa-chalkboard-teacher icon2"></i>
          </div>
          <div class="justify-content-center">
            <div class="row">
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right text-red"> ผู้รับ :</label>
                  <div class="col-sm-8">
                  <input type="text" name="UserCloseAccount" value="{{ ($datalegis->UserStatus_legis == NULL) ? Auth::user()->username : $datalegis->UserStatus_legis }}" class="form-control form-control-sm SizeText" readonly/>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right text-red"> ประเภทปิดบัญชี :</label>
                  <div class="col-sm-8">
                    @php
                      if ($datalegis->legisCompromise != NULL) {
                        $ActiveCompro = true;
                      }else {
                        $ActiveCompro = false;
                      }
                    @endphp
                    <select name="Status" id="Status" class="form-control form-control-sm SizeText" {{($type == 7) ?'readonly': '' }}>
                      <option value="" selected>--- ประเภทปิดบัญชี ---</option>
                      <option value="ปิดบัญชี" {{($datalegis->Status_legis == 'ปิดบัญชี') ? 'selected' : ''}} {{(@$ActiveCompro == true) ? 'disabled' : ''}}>01. ปิดบัญชี</option>
                      <option value="ปิดจบประนอม" {{($datalegis->Status_legis == 'ปิดจบประนอม') ? 'selected' : ''}} {{(@$ActiveCompro == true) ? 'disabled' : ''}}>02 .ปิดจบประนอม</option>
                      <option value="ปิดจบรถยึด" {{($datalegis->Status_legis == 'ปิดจบรถยึด') ? 'selected' : ''}}>03 .ปิดจบรถยึด</option>
                      <option value="ปิดจบถอนบังคับคดี" {{($datalegis->Status_legis == 'ปิดจบถอนบังคับคดี') ? 'selected' : ''}}>04. ปิดจบถอนบังคับคดี</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <input type="hidden" name="DateCloseAccount" value="{{ ($datalegis->DateStatus_legis != NULL) ?$datalegis->DateStatus_legis : date('Y-m-d')}}" class="form-control form-control-sm SizeText" readonly/>
            @if($datalegis->Status_legis != "ปิดบัญชี")
              <div id="ShowData" style="display:none;">
            @else
              <div id="ShowData">
            @endif
              <div class="row">
                <input type="hidden" name="DateCloseAccount" value="{{ ($datalegis->DateStatus_legis != NULL) ?$datalegis->DateStatus_legis : date('Y-m-d')}}" class="form-control form-control-sm SizeText" readonly/>
                <!-- <div class="col-6">
                  <div class="form-group row mb-0">
                    <label class="col-sm-4 col-form-label text-right text-red"> วันที่ปิดบัญชี :</label>
                    <div class="col-sm-8">
                      <input type="date" name="DateCloseAccount" value="{{ ($datalegis->DateStatus_legis != NULL) ?$datalegis->DateStatus_legis : date('Y-m-d')}}" class="form-control form-control-sm SizeText" readonly/>
                    </div>
                  </div>
                </div> -->
                <div class="col-6">
                  <div class="form-group row mb-0">
                    <label class="col-sm-4 col-form-label text-right text-red"> ทุนทรัพย์ :</label>
                    <div class="col-sm-8">
                      <input type="text" id="capital" name="capital" value="{{ ($datalegis->legiscourt != NULL) ?number_format($datalegis->legiscourt->capital_court): '' }}" class="form-control form-control-sm SizeText" readonly/>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group row mb-0">
                    <label class="col-sm-4 col-form-label text-right text-red"> ยอดส่วนลด :</label>
                    <div class="col-sm-8">
                      <input type="number" id="DiscountAccount" name="DiscountAccount" value="{{ ($datalegis->Discount_legis != NULL) ?number_format($datalegis->Discount_legis): '' }}" class="form-control form-control-sm SizeText" placeholder="5% - 20%" {{($type == 7) ?'readonly': '' }}/>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group row mb-0">
                    <label class="col-sm-4 col-form-label text-right text-red"> ยอดปิดบัญชี :</label>
                    <div class="col-sm-8">
                      <input type="text" id="PriceAccount" name="PriceAccount" value="{{ ($datalegis->PriceStatus_legis != NULL) ?number_format($datalegis->PriceStatus_legis): '' }}" class="form-control form-control-sm SizeText" placeholder="0.00" readonly/>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group row mb-0">
                    <label class="col-sm-4 col-form-label text-right text-red"> ยอดรับชำระ :</label>
                    <div class="col-sm-8">
                      <input type="text" id="TopCloseAccount" name="TopCloseAccount" value="{{ ($datalegis->txtStatus_legis != NULL) ?number_format($datalegis->txtStatus_legis): '' }}" class="form-control form-control-sm SizeText" oninput="addcomma();" placeholder="0.00" {{($type == 7) ?'readonly': '' }}/>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <div class="row" id="DataSum">
                <div class="col-6">
                  <div class="form-group row mb-0">
                    <label class="col-sm-4 col-form-label text-right"> ยอดชำระแล้ว :</label>
                    <div class="col-sm-8">
                      <input type="text" id="Paidamount" name="Paidamount" class="form-control form-control-sm SizeText" oninput="addcomma();"/>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group row mb-0">
                    <label class="col-sm-4 col-form-label text-right"> ต้นทุน :</label>
                    <div class="col-sm-8">
                      <input type="text" id="CostPrice"name="CostPrice" class="form-control form-control-sm SizeText" oninput="addcomma();"/>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group row mb-0">
                    <label class="col-sm-4 col-form-label text-right"> กำไรไม่หักภาษี :</label>
                    <div class="col-sm-8">
                      <input type="text" id="ShowPrices" class="form-control form-control-sm SizeText" readonly/>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group row mb-0">
                    <label class="col-sm-4 col-form-label text-right"> เปอร์เซ็น :</label>
                    <div class="col-sm-8">
                      <input type="text" id="Percents" class="form-control form-control-sm SizeText" readonly/>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-info hover-up" style="color:#ffff";>
            <i class="fas fa-download pr-1"></i> {{ ($type == 2) ?'บันทึก' : 'พิมพ์'}}
          </button>
        </div>

        <input type="hidden" name="type" value="1">
        <input type="hidden" name="id" value="{{$datalegis->id}}">
      </form>
    </div>
  </section>
@elseif($type == 3) {{-- ปิดจบประนอม --}}
  <section class="content" style="font-family: 'Prompt', sans-serif;">
    <div class="card">
      <div class="card-header" style="background-image: url({{ asset('dist/img/bg1.jpg') }})">
        <h5 class="text-left">
          <b class="text-white">ปิดจบประนอมหนี้ <small class="textHeader">(End Compounds)</small></b>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">x</span>
            </button>
        </h5>
      </div>
        <div class="card-body SizeText">
          <div class="d-flex justify-content-center mb-3">
            <h4 class="top prem">เลขสัญญา.</h4>
            <h4 class="head">{{$datalegis->Contract_legis}}</h4>
          </div>
          <div class="d-flex justify-content-center mb-3">
            <i class="fas fa-check icon1"></i><i class="fas fa-chalkboard-teacher icon2-green"></i>
          </div>
          <div class="justify-content-center">
            <div class="row mb-3">
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right text-red"> ประเภทประนอมหนี้ :</label>
                  <div class="col-sm-8">
                    <input type="text" value="{{ @$datalegis->legisCompromise->Type_Promise }}" class="form-control form-control-sm SizeText" readonly/>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right text-red"> ยอดประนอม :</label>
                  <div class="col-sm-8">
                    <input type="text" value="{{ ($datalegis->legisCompromise != NULL) ?number_format($datalegis->legisCompromise->Total_Promise, 2): '' }}" class="form-control form-control-sm SizeText" readonly/>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right text-red"> ยอดก้อนแรก :</label>
                  <div class="col-sm-8">
                    <input type="text" value="{{ ($datalegis->legisCompromise != NULL) ?number_format($datalegis->legisCompromise->FirstManey_1, 2): '' }}" class="form-control form-control-sm SizeText" placeholder="0.00" readonly/>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group row mb-0">
                  <label class="col-sm-4 col-form-label text-right text-red"> ยอดชำระแล้ว :</label>
                  <div class="col-sm-8">
                    <input type="text" value="{{ ($datalegis->legisCompromise != NULL) ?number_format($datalegis->legisCompromise->Sum_FirstPromise + $datalegis->legisCompromise->Sum_DuePayPromise, 2): '' }}" class="form-control form-control-sm SizeText" placeholder="0.00" readonly/>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="justify-content-center">
            <div class="row">
              <div class="col-12">
                <table class="table table-sm table-hover SizeText-1" id="table">
                  <thead>
                    <tr>
                      <th class="text-center">No.</th>
                      <th class="text-center">วันที่รับชำระ</th>
                      <th class="text-center">ยอดชำระ</th>
                      <th class="text-center">ประเภท</th>
                      <th class="text-center">ดิวถัดไป</th>
                      <th class="text-center">ผู้รับชำระ</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($dataPayment as $key => $row)
                      <tr>
                        <td class="text-center"> {{$key+1}} </td>
                        <td class="text-center"> {{ date('d-m-Y', strtotime(substr($row->created_at,0,10))) }}</td>
                        <td class="text-center"> 
                          {{ number_format($row->Gold_Payment, 2) }} 
                        </td>
                        <td class="text-center"> {{$row->Type_Payment}} </td>
                        <td class="text-center"> {{ date('d-m-Y', strtotime($row->DateDue_Payment)) }}</td>
                        <td class="text-right"> {{$row->Adduser_Payment}} </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
    </div>
  </section>
@endif

<script>
  $('#Status').change(function(){
    var valuetype = document.getElementById('Status').value;
    if(valuetype == 'ปิดบัญชี'){
      $('#ShowData').show();
      $('.form').attr('target','_blank');
    }else{
      $('#ShowData').hide();
      $('.form').removeAttr('target','_blank');
    }
  });

  $('#DiscountAccount').on('input', function() {
    var Setcapital = $('#capital').val();
    var capital = Setcapital.replace(",","");
    var SetDiscountAccountt = $('#DiscountAccount').val();

    var Percent = (parseFloat(SetDiscountAccountt) / 100);
    var Prices = ((parseFloat(capital) - (parseFloat(capital) * Percent)))

    $('#PriceAccount').val(addCommas(Prices.toFixed(2)));
  });

  $('#DataSum').on('input', function() {
    var SetPriceAccount = $('#PriceAccount').val();
    var PriceAccount = SetPriceAccount.replace(",","");
    var SetPaidamount = $('#Paidamount').val();
    var Paidamount = SetPaidamount.replace(",","");
    var SetCostPrice = $('#CostPrice').val();
    var CostPrice = SetCostPrice.replace(",","");

    var Prices = ((parseFloat(PriceAccount) + parseFloat(Paidamount) - parseFloat(CostPrice)));
    var Percent = ((Prices * 100) / parseFloat(CostPrice));

    $('#ShowPrices').val(addCommas(Prices.toFixed(2)));
    $('#Percents').val(addCommas(Percent.toFixed(2)));
  });
</script>

<script>
  $(function () {
    $('[data-mask]').inputmask()
  })
</script>

<script type="text/javascript">
  function addCommas(nStr){
      nStr += '';
      x = nStr.split('.');
      x1 = x[0];
      x2 = x.length > 1 ? '.' + x[1] : '';
      var rgx = /(\d+)(\d{3})/;
      while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
      }
    return x1 + x2;
  }
  function addcomma(){
    var SetTopCloseAccount = document.getElementById('TopCloseAccount').value;
    var TopCloseAccount = SetTopCloseAccount.replace(",","");
    var SetPaidamount = document.getElementById('Paidamount').value;
    var Paidamount = SetPaidamount.replace(",","");
    var SetCostPrice = document.getElementById('CostPrice').value;
    var CostPrice = SetCostPrice.replace(",","");

    document.form.TopCloseAccount.value = addCommas(TopCloseAccount);
    document.form.Paidamount.value = addCommas(Paidamount);
    document.form.CostPrice.value = addCommas(CostPrice);
  }
</script>

<script>
  $(document).ready(function() {
    $('#table').DataTable( {
        "autoWidth": false,
        "searching" : false,
        "lengthChange" : false,
        "info" : false,
        "order": false,
    });
  });
</script>
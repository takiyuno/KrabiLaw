  <section class="content" style="font-family: 'Prompt', sans-serif;">
    <div class="card card-warning">
      {{-- <div class="card-header">
        @if (@$type == 1)
          <h6 class="card-title" style="font-size: 15px;"> รายงาน อนุมัติสินเชื่อ <span class="small">(Approve Contract Report)</span></h6>
        @elseif(@$type == 2)
          <h6 class="card-title" style="font-size: 15px;"> รายงาน ตามเลขที่สัญญา <span class="small">(Contract Report)</span></h6>
        @endif
      </div> --}}
      <form name="Report_Contract" target="_blank" class="form-Validate" action="{{ route('Legislation.Report') }}" method="get" enctype="multipart/form-data">
        @csrf
        @method('put')
        <input type="hidden" name="FlagTab" value="{{@$FlagTab}}"/>

        <div class="card-body text-sm">
          <div class="row textSize-13">
            <div class="col-12 col-lg-6">
              <div class="form-group row mb-0">
                <label class="col-sm-3 col-form-label text-right textSize-13">จากวันที่ :</label>
                <div class="col-sm-7">
                  <input type="date" name="Fdate" value="{{ date('Y-m-d') }}" class="form-control form-control-sm textSize-13" title="จากวันที่" required/>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-6">
              <div class="form-group row mb-0">
                <label class="col-sm-3 col-form-label text-right textSize-13">ถึงวันที่ :</label>
                <div class="col-sm-7">
                  <input type="date" name="Tdate" value="{{ date('Y-m-d') }}" class="form-control form-control-sm textSize-13" title="ถึงวันที่" required/>
                </div>
              </div>
            </div>
            {{-- <div class="col-12 col-lg-6">
              <div class="form-group row mb-0">
                <label class="col-sm-3 col-form-label text-right textSize-13">สัญญา :</label>
                <div class="col-sm-7">
                  <select name="TypeLoans" class="form-control form-control-sm textSize-13 is-warning" title="ประเภทสัญญา">
                    <option value="" selected>--- ประเภทสัญญา ---</option>
                    @foreach($TypeLoan as $key => $value)
                      <option value="{{$value->Loan_Code}}-{{$value->Loan_Name}}-{{$value->id_rateType}}">{{$value->Loan_Code}} - {{$value->Loan_Name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div> --}}
            {{-- <div class="col-12 col-lg-6">
              <div class="form-group row mb-0">
                <label class="col-sm-3 col-form-label text-right textSize-13">สาขา :</label>
                <div class="col-sm-7">
                  <select name="Branch_Con" class="form-control form-control-sm textSize-13" {{@$type == 2?'disabled': ''}}>
                    <option value="" selected>--- สาขา ---</option>
                    @foreach(@$dataBranchs as $key => $value)
                      <option value="{{$value->id}}" >({{$value->NickName_Branch}}) - {{$value->Name_Branch}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div> --}}
          
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm bg-info SizeText hover-up">
            <i class="fa-sharp fa-solid fa-print"></i> พิมพ์
          </button>
        </div>
      </form>
    </div>
  </section>


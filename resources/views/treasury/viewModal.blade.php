<link rel="stylesheet" href="{{ asset('css/pluginLegislations.css') }}">
<script src="{{asset('js/pluginLegisCompro.js')}}"></script>
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<link rel="stylesheet" href="{{asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')}}">
<script src="{{asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>
<script src="{{asset('plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

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
        border-radius:5px;}
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

  #myImg {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
    width: 150px;
    height: 200px;
  }
  #myImg:hover {opacity: 0.7;}
</style>

@if($type == 1) {{-- Modal Check Expenses --}}
  <section class="content" style="font-family: 'Prompt', sans-serif;">
      <div class="card-header" style="background-image: url({{ asset('dist/img/bg1.jpg') }})">
        <h5 class="text-left">
          <b class="text-white">ตรวจสอบรายการเบิกสำรองจ่าย <small class="textHeader">(Checks Expenses)</small></b>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">x</span>
          </button>
        </h5>
      </div>
      <form name="form" action="{{ route('MasterTreasury.update',$data->id) }}" method="post" id="quickForm" novalidate="novalidate" enctype="multipart/form-data">
      @csrf
      @method('put')
      <input type="hidden" name="type" value="1">
      <input type="hidden" name="_method" value="PATCH"/>
      <input type="hidden" name="UserEditExpense" value="{{ Auth::user()->name }}"/>
      <input type="hidden" name="FlagTab" value="1">

        <div class="card-body SizeText" id="Cul-Payments">
          <div class="row">
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">วันที่ตั้งเบิก : </label>
                <div class="col-sm-8">
                  <input type="date" class="form-control form-control-sm SizeText" value="{{$data->Date_expense}}" readonly/>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right text1">ยอดเบิกสำรอง : </label>
                <div class="col-sm-8">
                  <input type="text" class="form-control form-control-sm SizeText" value="{{@number_format($data->Amount_expense,0)}}" readonly/>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">วันที่อนุมัติเงิน : </label>
                <div class="col-sm-8">
                  <input type="date" class="form-control form-control-sm SizeText" value="{{$data->Transfer_expense}}" readonly/>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">ยอดใช้จ่ายจริง : </label>
                <div class="col-sm-8">
                  <input type="text" class="form-control form-control-sm SizeText" value="{{@number_format($data->PayAmount_expense,0)}}" readonly/>
                </div>
              </div>
            </div>
            <div class="col-6">
              @if($data->DateApprove_expense != NULL)
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right">วันที่อนุมัติเงิน : </label>
                <div class="col-sm-8">
                  <input type="date" class="form-control form-control-sm SizeText" value="{{$data->DateApprove_expense}}" readonly/>
                </div>
              </div>
              @endif
            </div>
            <div class="col-6">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label text-right text-danger">ยอดคงเหลือ : </label>
                <div class="col-sm-8">
                  <input type="text" class="form-control form-control-sm SizeText text-danger" value="{{@number_format($data->BalanceAmount_expense,0)}}" readonly/>
                </div>
              </div>
            </div>
            <div class="col-12">
              <hr>
              <div class="form-group row mb-0">
                <label class="col-sm-2 col-form-label text-right">หมายเหตุ : </label>
                <div class="col-sm-10">
                  <textarea name="NoteExpense" class="form-control form-control-sm SizeText" rows="3" readonly>{{$data->Note_expense}}</textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer text-right">
          <div class="form-inline float-right">
            <i class="fas fa-grip-vertical"></i>
            <span class="todo-wrap SizeText">
              @if($data->Flag_expense == 'complete')
                <input type="checkbox" class="ShowCKL" id="1" name="CorrectCheck" value="complete" checked/>
              @else
                <input type="checkbox" class="ShowCKL" id="1" name="CorrectCheck" value="complete" />
              @endif
              <label for="1" class="todo mr-sm-3">
                <i class="fa fa-check"></i>
                <font color="blue"> ข้อมูลถูกต้อง</font>
              </label>
            </span>
            <button type="submit" class="btn btn-sm btn-success SizeText hover-up">
              <i class="fas fa-save pr-1"></i>บันทึก
            </button>
          </div>
        </div>
      </form>
  </section>
@endif

<script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
</script>
<link rel="stylesheet" href="{{ asset('css/pluginLegislations.css') }}">

@if($type == 1)
  <section class="content" style="font-family: 'Prompt', sans-serif;">
    <div class="card card-warning">
      <div class="card-header" style="background-image: url({{ asset('dist/img/bg1.jpg') }})">
        <h5 class="text-left">
          <b class="text-white">ค้นหารายชื่อ <small class="textHeader">(Search Customers)</small></b>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">x</span>
          </button>
        </h5>
      </div>
      <div class="card-body text-sm">   
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="row textSize">
          <div class="col-6">
            <div class="form-group row mb-0">
              <label class="col-sm-3 col-form-label text-right textSize">ฐานลูกหนี้ : </label>
              <div class="col-sm-9">
                <select name="DB_type" id="DB_type" class="form-control form-control-sm textSize Boxcolor" required>
                  <option value="" class="text-red" selected>--------- ฐานลูกหนี้ใหม่ ---------</option>
                  <option value="1">1. ลูกหนี้เช่าซื้อ (RSFHP)</option>
                  <option value="3">2. ลูกหนี้เงินกู้ (PSFHP)</option>
                  <!-- <option value="6">3. ลูกหนี้ขายฝาก (PSFHP)</option> -->
                  <option value="" class="text-red">--------- ฐานลูกหนี้เก่า -------</option>
                  <option value="2">1. ลูกหนี้เช่าซื้อเก่า (ASFHP)</option>
                  <!-- <option value="4">2. ลูกหนี้ขายฝากเก่า (LSFHP)</option>
                  <option value="5">3. ลูกหนี้หลุดขายฝากเก่า (LSFHP)</option> -->
                </select>
              </div>
            </div>
          </div> 
          <div class="col-6">
            <div class="card-tools d-inline float-right">
              <div class="input-group form-inline">
                <label class="textSize" >เลขที่สัญญา : &nbsp;&nbsp;</label>
                <input type="text" name="Contno" id="Contno" maxlength="12" class="form-control form-control-sm textSize Boxcolor" data-inputmask="&quot;mask&quot;:&quot;101-99999999&quot;" data-mask="" required/>
                <input type="text" name="Contno2" id="Contno2" maxlength="12" class="form-control form-control-sm textSize Boxcolor" data-inputmask="&quot;mask&quot;:&quot;P99-99999999&quot;" data-mask="" required/>
                <input type="text" name="Contno3" id="Contno3" maxlength="12" class="form-control form-control-sm textSize Boxcolor"  required/>
                <span class="input-group-append">
                  <button type="button" class="btn btn-info btn-sm button">
                    <i class="fas fa-search"></i>
                  </button>
                </span>
              </div>
            </div>      
          </div>   
        </div>
        <hr>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div id="LegisData"></div>
      </div>
    </div>
  </section>
@endif   

<script>
  $(function () {
      $('[data-mask]').inputmask()
  })
</script>

<script type="text/javascript">
    $('#Contno2,#Contno3').hide();
    $('#DB_type').on("input" ,function() {
        var DB_type = document.getElementById('DB_type').value;
        if(DB_type == 1 ){
          $('#Contno').show(); 
          $('#Contno2,#Contno3').hide();
        }
        else if(DB_type == 3){
          $('#Contno2').show();
          $('#Contno,#Contno3').hide();
        }
        else if(DB_type == 2){
          $('#Contno3').show();
          $('#Contno,#Contno2').hide();
        }
    });
</script>

<script type="text/javascript">
  $(".button").click(function(ev){
      var DB_type = $('#DB_type').val();
      if(DB_type == 1 ){
        var Contno = $('#Contno').val();  //format (101-99999)
      }
      else if(DB_type == 3){              //format (P99-99999999)
        var Contno = $('#Contno2').val();
      }
      else if(DB_type == 2){              //format ()
        var Contno = $('#Contno3').val();
      }
      var _token = $('input[name="_token"]').val();

    if (Contno != '') {
      console.log(DB_type,Contno);
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url:"{{ route('legislation.SearchData', 1) }}",
        method:"POST",
        data:{DB_type:DB_type,Contno:Contno,_token:_token},

        success:function(result){ //เสร็จแล้วทำอะไรต่อ
          console.log(result);
          $('#LegisData').html(result);
        }
      })
    }
  });
</script>


@extends('layouts.master')
@section('title','กฏหมาย/หนังสือเข้า-ออก')
@section('content')

  @if(session()->has('success'))
    <script type="text/javascript">
      toastr.success('{{ session()->get('success') }}')
    </script>
  @endif

  <!-- Main content -->
  <section class="Profile-container" style="font-family: 'Prompt', sans-serif;">
    <div class="content">
      <div class="content-header">
        <div class="row">
          <div class="col-8">
            <div class="form-inline">
                <h5>หนังสือ <small class="textHeader">(เข้า-ออก)</small></h5>
            </div>
          </div>
          <div class="col-4">
            <form method="get" action="{{ route('MasterBook.index') }}">
              <div class="card-tools d-inline float-right btn-page">
                <div class="input-group form-inline">
                  <span class="text-right mr-sm-1">วันที่ : </span>
                  <input type="text" id="dateSearch" name="dateSearch" value="{{ (@$dateSearch != '') ?@$dateSearch: '' }}" class="form-control form-control-sm textSize" placeholder="วันที - ถึงวันที่">
                  <span class="input-group-append">
                    <button type="submit" class="btn btn-info btn-sm button-id mr-sm-1">
                      <i class="fas fa-search"></i>
                    </button>
                  </span>
                  {{--<button class="btn btn-info btn-sm hover-up" data-toggle="dropdown">
                    <i class="fas fa-print"></i>
                  </button>
                  <ul class="dropdown-menu text-sm" role="menu">
                    <li><a target="_blank" class="dropdown-item" data-toggle="modal" data-target="#modal-new" data-link="#"> รายงาน บันทึกติดตาม</a></li>
                    <li class="dropdown-divider"></li>
                    <li><a target="_blank" href="#" class="dropdown-item"> รายงาน ลูกค้าขาดติดตาม</a></li>
                  </ul>--}}
                </div>
              </div>
              <input type="hidden" name="type" value="2">
            </form>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3">
          <a data-toggle="modal" data-target="#modal-addbook" class="btn btn-outline-info SizeText btn-block mb-3 text-info"><i class="far fa-plus-square"></i> เพิ่มหนังสือ</a>
          <div class="box-shadow">
            <div class="author-card pb-3 pt-3">
              <span class="text-right textHeader-1">
                <i class="mr-3 text-muted"></i> 
                  ทั้งหมด (<b><span class="text-red">{{count($data)+count($data2)}}</span></b> ฉบับ)
              </span>
              <div class="author-card-profile">
                <div class="author-card-avatar">
              </div>
            </div>
          </div>
            <div class="wizard">
              <nav class="list-group list-group-flush" role="tablist">
                <a class="list-group-item hover-up active" data-toggle="tab" href="#list-page1-list">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <i class="fas fa-book-open mr-1 text-success"></i>
                      <div class="d-inline-block font-weight-medium text-uppercase">หนังสือเข้า</div>
                    </div>
                      @if(count($data) != 0)
                        <span class="badge bg-info prem">{{count($data)}}</span>
                      @endif
                  </div>
                </a>
                <a class="list-group-item hover-up" data-toggle="tab" href="#list-page2-list">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <i class="fas fa-book-open mr-1 text-danger"></i>
                      <div class="d-inline-block font-weight-medium text-uppercase">หนังสือออก</div>
                    </div>
                      @if(count($data2) != 0)
                        <span class="badge bg-info prem">{{count($data2)}}</span>
                      @endif
                  </div>
                </a>
              </nav>
            </div>
          </div>
        </div>
        <div class="col-lg-9">
            <div class="tab-content">
                <div id="list-page1-list" class="container tab-pane active SizeText">
                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">หนังสือ  <span class="textHeader">(เข้า)</span></h6>
                    <table class="table table-hover SizeText" id="table11">
                        <thead>
                            <tr>
                                <th class="text-center">ลำดับ</th>
                                <th class="text-center">วันที่</th>
                                <th class="text-center">เรื่อง</th>
                                <th class="text-center">ไปถึง</th>
                                <th class="text-center">มาจาก</th>
                                <th class="text-center">หมายเหตุ</th>
                                <th class="text-center">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $key => $row)
                                <tr class="textSize">
                                    <td class="text-center"><font color="{{($row->Type_book == 'หนังสือเข้า'?'green':'red')}}">{{$row->OrdinalNumber_book}}</font></td>
                                    <td class="text-center">{{formatDateThaiShort($row->Datecreate_book)}}</td>
                                    <td class="text-left">{{$row->Title_book}}</td>
                                    <td class="text-left">{{$row->Fromwhere_book}}</td>
                                    <td class="text-left">{{$row->Towhere_book}}</td>
                                    <td class="text-left">{{$row->Note_book}}</td>
                                    <td class="text-right">
                                        <button class="btn btn-xs btn-warning hover-up" data-toggle="modal" data-target="#modal-editlist"
                                            data-link="{{ route('MasterBook.edit',[$row->id]) }}?type={{2}}">
                                            <i class="far fa-edit" data-toggle="tooltip" data-placement="top" title="แก้ไขรายการ"></i> 
                                        </button>
                                        <form method="post" class="delete_form" action="{{ route('MasterBook.destroy',[$row->id]) }}" style="display:inline;">
                                        {{csrf_field()}}
                                            <input type="hidden" name="type" value="2" />
                                            <input type="hidden" name="_method" value="DELETE" />
                                            <button type="submit"  data-name="ลำดับ {{$row->OrdinalNumber_book}}" class="delete-modal btn btn-danger btn-xs DeleteBook hover-up" data-toggle="tooltip" data-placement="top" title="ลบรายการ">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="list-page2-list" class="container tab-pane fade SizeText">
                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">หนังสือ <span class="textHeader">(ออก)</span></h6>
                    <table class="table table-hover SizeText" id="table22">
                        <thead>
                            <tr>
                                <th class="text-center">ลำดับ</th>
                                <th class="text-center">วันที่</th>
                                <th class="text-center">เรื่อง</th>
                                <th class="text-center">ไปถึง</th>
                                <th class="text-center">มาจาก</th>
                                <th class="text-center">หมายเหตุ</th>
                                <th class="text-center">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data2 as $key => $row)
                                <tr class="textSize">
                                    <td class="text-center"><font color="{{($row->Type_book == 'หนังสือเข้า'?'green':'red')}}">{{$row->OrdinalNumber_book}}</font></td>
                                    <td class="text-center">{{formatDateThaiShort($row->Datecreate_book)}}</td>
                                    <td class="text-left">{{$row->Title_book}}</td>
                                    <td class="text-left">{{$row->Fromwhere_book}}</td>
                                    <td class="text-left">{{$row->Towhere_book}}</td>
                                    <td class="text-left">{{$row->Note_book}}</td>
                                    <td class="text-right">
                                        <button class="btn btn-xs btn-warning hover-up" data-toggle="modal" data-target="#modal-editlist"
                                            data-link="{{ route('MasterBook.edit',[$row->id]) }}?type={{2}}">
                                            <i class="far fa-edit" data-toggle="tooltip" data-placement="top" title="แก้ไขรายการ"></i> 
                                        </button>
                                        <form method="post" class="delete_form" action="{{ route('MasterBook.destroy',[$row->id]) }}" style="display:inline;">
                                        {{csrf_field()}}
                                            <input type="hidden" name="type" value="2" />
                                            <input type="hidden" name="_method" value="DELETE" />
                                            <button type="submit"  data-name="ลำดับ {{$row->OrdinalNumber_book}}" class="delete-modal btn btn-danger btn-xs DeleteBook hover-up" data-toggle="tooltip" data-placement="top" title="ลบรายการ">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
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

  <div class="modal fade" id="modal-Popup">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
        </div>
      </div>
    </div>
  </div>

  {{-- popup เพิ่มรายการ --}}
  <form name="form2" action="{{ route('MasterBook.store') }}" method="post" enctype="multipart/form-data" style="font-family: 'Prompt', sans-serif;" id="quickForm">
      {{ csrf_field() }}
      <input type="hidden" name="type" value="2">
      <input type="hidden" name="Nameuser" value="{{auth::user()->name}}"/>

      <div class="modal fade" id="modal-addbook">
          <div class="modal-dialog modal-xl">
              <div class="modal-content">
              <div class="modal-header bg-info">
                  <div class="col text-left">
                      <h5 class="modal-title"><i class="fas fa-plus fa-xs"></i> เพิ่มรายการหนังสือ เข้า-ออก</h5>
                  </div>
                  <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                  </button> -->
              </div>
              <div class="modal-body text-sm SizeText">
                  <form name="product_name" id="product_name">  
                      <div class="table-responsive">  
                          <table class="table table-bordered" id="dynamic_field">  
                          <thead>
                              <tr>
                                  <th class="text-center SizeText" style="width: 10px">ที่</th>
                                  <th class="text-center SizeText">วันที่</th>
                                  <th class="text-center SizeText" style="width: 150px">ประเภท</th>
                                  <th class="text-center SizeText">เรื่อง</th>
                                  <th class="text-center SizeText">ไปถึง</th>
                                  <th class="text-center SizeText">มาจาก</th>
                                  <th class="text-center SizeText">หมายเหตุ</th>
                                  <th class="text-center SizeText">#</th>
                              </tr>
                          </thead>
                              <tr>  
                                  <td>1</td>
                                  <td><input type="date" name="DateBook[]" class="form-control form-control-sm list SizeText" required/></td>  
                                  <td>
                                      <!-- <input type="text" name="Sname[]" class="form-control form-control-sm list SizeText" /> -->
                                      <select name="TypeBook[]" class="form-control form-control-sm list SizeText" required>
                                          <option value="">--เลือก--</option>
                                          <option value="หนังสือเข้า">หนังสือเข้า</option>
                                          <option value="หนังสือออก">หนังสือออก</option>
                                      </select>
                                  </td>  
                                  <td><input type="text" name="TitleBook[]" class="form-control form-control-sm list SizeText" required/></td>  
                                  <td><input type="text" name="FromWhere[]" class="form-control form-control-sm list SizeText" /></td>  
                                  <td><input type="text" name="ToWhere[]" class="form-control form-control-sm list SizeText" /></td>  
                                  <td><input type="text" name="NoteBook[]" class="form-control form-control-sm list SizeText" /></td>  
                                  <td><button type="button" name="add" id="add" class="btn btn-xs btn-success hover-up" title="เพิ่มบรรทัด"><i class="fas fa-plus"></i></button></td>  
                              </tr>  
                          </table>  
                      </div>
                  </form>  
              <hr>
              </div>
              <div align="center">
                  <button type="submit" class="btn btn-sm btn-success hover-up list SizeText"><i class="fas fa-save"></i> บันทึก</button>
                  <button type="button" class="btn btn-sm btn-danger hover-up list SizeText" data-dismiss="modal"><i class="far fa-window-close"></i> ยกเลิก</button>
              </div>
              <br>
              </div>
          </div>
      </div>
  </form>
  <script type="text/javascript">
      $(document).ready(function(){      
      var postURL = "<?php echo url('addProduct'); ?>";
      var i=1;  
      $('#add').click(function(){  
          i++;  
          $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added SizeText">'+
          '<td>'+i+'</td>'+
          '<td><input type="date" name="DateBook[]" class="form-control list SizeText" /></td>'+
          '<td><select name="TypeBook[]" class="form-control list SizeText"><option value="">--เลือก--</option><option value="หนังสือเข้า">หนังสือเข้า</option><option value="หนังสือออก">หนังสือออก</option></select></td>'+
          '<td><input type="text" name="TitleBook[]" class="form-control list SizeText" /></td>'+
          '<td><input type="text" name="FromWhere[]" class="form-control list SizeText" /></td>'+
          '<td><input type="text" name="ToWhere[]" class="form-control list SizeText" /></td>'+
          '<td><input type="text" name="NoteBook[]" class="form-control list SizeText" /></td>'+
          '<td><button type="button" name="remove" id="'+i+'" class="btn btn-xs btn-danger btn_remove">X</button></td>'+
          '</tr>');  
      });  
      $(document).on('click', '.btn_remove', function(){  
              i--; 
          var button_id = $(this).attr("id");   
          $('#row'+button_id+'').remove();  
      });  
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $('#submit').click(function(){            
          $.ajax({  
                  url:postURL,  
                  method:"POST",  
                  data:$('#product_name').serialize(),
                  type:'json',
                  success:function(data)  
                  {
                      if(data.error){
                          previewMessage(data.error);
                      }else{
                          i=1;
                          $('.dynamic-added').remove();
                          $('#product_name')[0].reset();
                          $(".print-success-msg").find("ul").html('');
                          $(".print-success-msg").css('display','block');
                          $(".error-message-display").css('display','none');
                          $(".print-success-msg").find("ul").append('<li>Record Inserted Successfully.</li>');
                      }
                  }  
          });  
      });  
      function previewMessage (msg) {
          $(".error-message-display").find("ul").html('');
          $(".error-message-display").css('display','block');
          $(".print-success-msg").css('display','none');
          $.each( msg, function( key, value ) {
              $(".error-message-display").find("ul").append('<li>'+value+'</li>');
          });
      }
      });  
  </script>

  {{-- popup แก้ไขรายการ --}}
    <div class="modal fade" id="modal-editlist">
        <div class="modal-dialog modal-lg">
            
        </div>
    </div>
    <script>
        $(function () {
        $("#modal-editlist").on("show.bs.modal", function (e) {
            var link = $(e.relatedTarget).data("link");
            $("#modal-editlist .modal-dialog").load(link, function(){
            });
        });
        });
    </script>
@endsection

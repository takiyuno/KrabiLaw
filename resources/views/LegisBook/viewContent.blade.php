@extends('layouts.master')
@section('title','ระบบติดตามลูกค้า')
@section('content')

@if(session()->has('success'))
    <script type="text/javascript">
        toastr.success('{{ session()->get('success') }}')
    </script>
@endif

<style>
    .list {
        font-size: 14px;
    }
</style>

    <section class="content" style="font-family: 'Prompt', sans-serif;">
        <div class="content-header">
            @if(session()->has('success'))
                <script type="text/javascript">
                    toastr.success('{{ session()->get('success') }}')
                </script>
            @endif
            <div class="container-fluid text-sm">
                <div class="row mb-0">
                    <div class="col-sm-6">
                        <h5>หนังสือ <small class="textHeader">(สารบัญ)</small></h5>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-right">
                            <ol class="breadcrumb float-right">
                                <button type="button" id="button-id" class="btn btn-xs bg-info mr-sm-1 hover-up" data-toggle="modal" data-target="#modal-adds">
                                    <i class="fas fa-plus"></i> เพิ่ม
                                </button>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- import excel file --}}
        {{--<div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <form method="post" enctype="multipart/form-data" action="{{ url('/import_excel/import') }}">
                    {{ csrf_field() }}
                    <div class="form-inline">
                        <table class="table">
                            <tr>
                                <td width="50%" align="right"><label>Select File for Upload</label></td>
                                <td width="30%">
                                    <input type="file" name="select_file" required/>
                                </td>
                                <td width="20%" align="left">
                                    <input type="submit" name="upload" class="btn btn-primary" value="Upload">
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
            <div class="col-md-3">
            </div>
        </div>--}}
        <div class="content">
            <div class="card text-sm card-outline">
                <div class="card-body row text-sm">
                    <div class="col-md-12">
                        <div class="table-responsive SizeText">
                            <table class="table table-bordered table-hover" id="table">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 30px">ลำดับ</th>
                                        <th class="text-center" style="width: 100px">เลขที่สัญญา</th>
                                        <th class="text-center" style="width: 200px">ชื่อสกุลผู้ซื้อ</th>
                                        <th class="text-center" style="width: 50px">เลขคดี</th>
                                        <th class="text-center" style="width: 250px">จัดเก็บอยู่ที่</th>
                                        <th class="text-center" style="width: 200px">ผู้ขอเบิกแฟ้ม</th>
                                        <th class="text-center" style="width: 100px">วันแก้ไขล่าสุด</th>
                                        <th class="text-center" style="width: 70px">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $key => $row)
                                        <tr class="textSize">
                                            <td class="text-center">{{$row->Locat}}</td>
                                            <td class="text-left">{{$row->Contractno}}</td>
                                            <td class="text-left">{{$row->Sname}}{{$row->Fname}}   {{$row->Lname}}</td>
                                            <td class="text-left">{{$row->Casenumber}}</td>
                                            <td class="text-left">{{$row->Filepath}}</td>
                                            <td class="text-left">
                                                {{$row->Usertake}}
                                                @if($row->Usertake != NULL)
                                                    <i class="fas fa-calendar text-warning prem" title="วันที่เบิก: {{formatDateThaiShort($row->Datetake)}}"></i>
                                                @endif
                                            </td>
                                            <td class="text-center">{{($row->updated_at != NULL?formatDateThaiShort(substr($row->updated_at,0,10)):'-')}}</td>
                                            <td class="text-right">
                                                <button class="btn btn-sm btn-warning hover-up" data-toggle="modal" data-target="#modal-editlist"
                                                    data-link="{{ route('MasterBook.edit',[$row->Content_id]) }}?type={{1}}">
                                                    <i class="far fa-edit" data-toggle="tooltip" data-placement="top" title="แก้ไขรายการ"></i> 
                                                </button>
                                                <form method="post" class="delete_form" action="{{ route('MasterBook.destroy',[$row->Content_id]) }}" style="display:inline;">
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="type" value="1" />
                                                    <input type="hidden" name="_method" value="DELETE" />
                                                    <button type="submit"  data-name="{{ $row->Contractno }}" class="delete-modal btn btn-danger btn-sm DeleteBook hover-up" data-toggle="tooltip" data-placement="top" title="ลบรายการ">
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

    <a id="button"></a>

    {{-- popup add new content--}}
    <form name="form2" action="{{ route('MasterBook.store') }}" method="post" enctype="multipart/form-data" style="font-family: 'Prompt', sans-serif;" id="quickForm">
        {{ csrf_field() }}
        <input type="hidden" name="type" value="1">
        <input type="hidden" name="Nameuser" value="{{auth::user()->name}}"/>

        <div class="modal fade SizeText" id="modal-adds">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                <div class="modal-header bg-info">
                    <div class="col text-left">
                    <h5 class="modal-title"><i class="fas fa-plus fa-xs"></i> เพิ่มรายการสารบัญ</h5>
                    </div>
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button> -->
                </div>
                <div class="modal-body text-sm">
                    <form name="product_name" id="product_name">  
                        <div class="table-responsive">  
                            <table class="table table-bordered" id="dynamic_field">  
                            <thead>
                                <tr>
                                    <th class="text-center SizeText" style="width: 10px">ที่</th>
                                    <th class="text-center SizeText" style="width: 150px">เลขที่สัญญา</th>
                                    <th class="text-center SizeText" style="width: 100px">คำนำหน้า</th>
                                    <th class="text-center SizeText" style="width: 200px">ชื่อผู้ซื้อ</th>
                                    <th class="text-center SizeText" style="width: 200px">สกุลผู้ซื้อ</th>
                                    <th class="text-center SizeText" style="width: 150px">เลขคดี</th>
                                    <th class="text-center SizeText" style="width: 200px">จัดเก็บอยู่ที่</th>
                                    <th class="text-center SizeText" style="width: 5px">#</th>
                                </tr>
                            </thead>
                                <tr>  
                                    <td>1</td>
                                    <td><input type="text" name="Contract_no[]" class="form-control form-control-sm list SizeText" required/></td>  
                                    <td>
                                        <input type="text" name="Sname[]" class="form-control form-control-sm list SizeText" required/>
                                        <!-- <select name="Sname[]" class="form-control form-control-sm list SizeText">
                                            <option value="นาย">นาย</option>
                                            <option value="นาง">นาง</option>
                                            <option value="นางสาว">นางสาว</option>
                                        </select> -->
                                    </td>  
                                    <td><input type="text" name="Fname[]" class="form-control form-control-sm list SizeText" required/></td>  
                                    <td><input type="text" name="Lname[]" class="form-control form-control-sm list SizeText" required/></td>  
                                    <td><input type="text" name="Casenumber[]" class="form-control form-control-sm list SizeText" /></td>  
                                    <td><input type="text" name="File_path[]" class="form-control form-control-sm list SizeText" /></td>  
                                    <td><button type="button" name="add" id="add" class="btn btn-sm btn-success hover-up" title="เพิ่มบรรทัด"><i class="fas fa-plus"></i></button></td>  
                                </tr>  
                            </table>  
                        </div>
                    </form>  
                <hr>
                </div>
                <div align="center">
                    <button type="submit" class="btn btn-sm btn-success hover-up list"><i class="fas fa-save"></i> บันทึก</button>
                    <button type="button" class="btn btn-sm btn-danger hover-up list" data-dismiss="modal"><i class="far fa-window-close"></i> ยกเลิก</button>
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
            $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added">'+
            '<td>'+i+'</td>'+
            '<td><input type="text" name="Contract_no[]" class="form-control list" /></td>'+
            '<td><input type="text" name="Sname[]" class="form-control list" /></td>'+
            '<td><input type="text" name="Fname[]" class="form-control list" /></td>'+
            '<td><input type="text" name="Lname[]" class="form-control list" /></td>'+
            '<td><input type="text" name="Casenumber[]" class="form-control list" /></td>'+
            '<td><input type="text" name="File_path[]" class="form-control list" /></td>'+
            '<td><button type="button" name="remove" id="'+i+'" class="btn btn-sm btn-danger btn_remove">X</button></td>'+
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

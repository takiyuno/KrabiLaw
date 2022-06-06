@extends('layouts.master')
@section('title','แผนกการเงิน')
@section('content')

<style>
  .content{
    padding:10px 50px 10px 50px;
  }
</style>

  <!-- Main content -->
  <section class="content">
    <div class="content-header">
      @if(session()->has('success'))
        <script type="text/javascript">
          toastr.success('{{ session()->get('success') }}')
        </script>
      @endif

      <section class="content" style="font-family: 'Prompt', sans-serif;">
        <div class="row justify-content-center">
          <div class="col-12 table-responsive">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col-6">
                    <div class="form-inline">
                      <h5>
                      @if($Subfolder == null)
                        <a href="{{ route('MasterDocument.index') }}?type={{1}}">คลังข้อมูล </a> / {{$title1}} 
                      @else
                        <a href="{{ route('MasterDocument.index') }}?type={{1}}">คลังข้อมูล </a> / <a href="javascript:history.back()">{{$Maintitle}}</a> / {{$Subfolder}}
                      @endif
                      </h5>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="card-tools d-inline float-right">
                      @if(auth::user()->type == "Admin" or auth::user()->position == "MANAGER" or auth::user()->position == "AUDIT")
                        @if($Subfolder == null)
                        <a class="btn bg-info btn-xs hover-up" data-toggle="modal" data-target="#modal-newfolder" data-backdrop="static">
                          <span class="fas fa-plus"></span> New Folder
                        </a>
                        @endif
                        <a class="btn bg-info btn-xs hover-up" data-toggle="modal" data-target="#modal-lg" data-backdrop="static">
                          <span class="fas fa-plus"></span> New file
                        </a>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body text-sm">
                <div class="col-md-12">

                    @if($countDataF != 0)
                      <div class="row">
                        @foreach($dataF as $row)
                          <div class="col-sm-1">
                          @if(auth::user()->type == "Admin" or auth::user()->position == "MANAGER" or auth::user()->position == "AUDIT")
                            <form method="post" class="delete_form float-right" action="{{ route('MasterDocument.destroy',[$row->folder_id]) }}?type={{1}}" style="display:inline;">
                              {{csrf_field()}}
                              <input type="hidden" name="_method" value="DELETE" />
                              <input type="hidden" name="foldername" value="{{$row->folder_name}}" />
                              <button type="submit" data-name="โฟลเดอร์ {{$row->folder_name}}" class="delete-modal btn btn-xs AlertForm text-red hover-up" data-toggle="tooltip" data-placement="top" title="ลบโฟลเดอร์">
                                <i class="far fa-trash-alt"></i>
                              </button>
                            </form>
                          @endif
                            <a href="{{ route('MasterDocument.edit',[$row->folder_id]) }}?type={{1}}&main_folder={{$title1}}&sub_folder={{$row->folder_name}}">
                              <img src="{{ asset('dist/img/folder6.png') }}" class="img-fluid">
                            </a>
                            <p align="center"> {{$row->folder_name}}</p>
                          </div>
                        @endforeach
                      </div>
                      <hr>
                    @endif
                  <div class="table-responsive">
                    <table class="table table-striped table-valign-middle" id="table1">
                      <thead>
                        <tr>
                          <th class="text-center"  style="width: 50px;">No.</th>
                          <th class="text-left">File Name</th>
                          <!-- <th class="text-center">รายละเอียด</th> -->
                          <th class="text-center"></th>
                          <th class="text-left">User Upload</th>
                          <th class="text-left">Date Upload</th>
                          <th class="text-right"></th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach($data as $key => $row)
                              @php 
                                $SetStr = explode(".",$row->file_name);
                                $extension = $SetStr[1];
                              @endphp
                          <tr>
                            <td class="text-center"> {{$key+1}}</td>
                            <td class="text-left"> 
                              @if($extension == 'pdf')
                                <i class="fas fa-file-pdf-o text-red"></i>
                              @elseif($extension == 'xls' or $extension == 'xlsx')
                                <i class="fas fa-file-excel-o text-green"></i>
                              @elseif($extension == 'doc' or $extension == 'docx')
                                <i class="fas fa fa fa-file-word-o text-primary"></i>
                              @elseif($extension == 'ppt' or $extension == 'pptx')
                                <i class="fas fa fa fa-file-powerpoint-o text-red"></i>
                              @elseif($extension == 'jpg')
                                <i class="fas fa-file-photo-o text-blue"></i>
                              @elseif($extension == 'zip')
                                <i class="fas fa fa-file-zip-o text-purple"></i>
                              @elseif($extension == 'sql' or $extension == 'txt')
                                <i class="fas fa-file-text-o"></i>
                              @elseif($extension == 'mp4')
                                <i class="fas fa-file-video-o"></i>
                              @elseif($extension == 'wmv')
                                <i class="fas fa-file-video-o"></i>
                              @endif
                              &nbsp;{{$row->file_title}}
                            </td>
                            <!-- <td class="text-left"> {{$row->file_description}}</td> -->
                            <td class="text-left">
                              .{{$extension}}
                            </td>
                            <td class="text-left">{{$row->file_uploader}}</td>
                            <td class="text-left">{{formatDateThai(substr($row->created_at,0,10))}}</td>
                            <td class="text-right">
                              @if($extension == 'pdf' or $extension == 'jpg' or $extension == 'png' or $extension == 'txt' or $extension == 'mp4' or $extension == 'wmv')
                                <a data-toggle="modal" data-target="#modal-preview" data-link="{{ route('MasterDocument.edit',[$row->file_id]) }}?type={{2}}&foldername={{$title1}}" class="btn btn-warning btn-sm hover-up" data-toggle="tooltip" data-placement="top" title="ดูไฟล์">
                                  <i class="far fa-eye"></i>
                                </a>
                              @endif
                                <a href="{{ action('DocumentController@download',[$row->file_name])}}?foldername={{$title1}}" class="btn btn-info btn-sm hover-up" data-toggle="tooltip" data-placement="top" title="ดาวน์โหลดไฟล์">
                                  <i class="fas fa-download"></i>
                                </a>
                                @if(auth::user()->type == "Admin" or auth::user()->position == "MANAGER" or auth::user()->position == "AUDIT")
                                  <form method="post" class="delete_form" action="{{ route('MasterDocument.destroy',[$row->file_id]) }}?type={{2}}" style="display:inline;">
                                  {{csrf_field()}}
                                    <input type="hidden" name="_method" value="DELETE" />
                                    <input type="hidden" name="foldername" value="{{$title1}}" />
                                    <button type="submit" data-name="{{$row->file_name}}" class="delete-modal btn btn-danger btn-sm AlertForm hover-up" data-toggle="tooltip" data-placement="top" title="ลบไฟล์">
                                      <i class="far fa-trash-alt"></i>
                                    </button>
                                  </form>
                                @endif
                            </td>
                          </tr>
                          @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>

                <a id="button"></a>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </section>

  <!-- pop up เพิ่มไฟล์อัพโหลด -->
  <form action="{{ route('MasterDocument.store') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" name="type" value="2">

    <div class="modal fade" id="modal-lg" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-info">
              <div class="col text-center">
                <h4 class="modal-title text-left" style="font-family: 'Prompt', sans-serif;">อัพโหลดไฟล์</h4>
              </div>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <br />
            @if(count($errors) > 0)
              <div class="alert alert-danger">
              Upload Validation Error<br><br>
              <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
              </div>
            @endif

            <div class="modal-body" style="font-family: 'Prompt', sans-serif;">
                <div class="row">
                  <div class="col-12">
                    <div class="form-group row mb-1">
                      <label class="col-sm-3 col-form-label text-right">ชื่อไฟล์ : </label>
                      <div class="col-sm-8">
                        <input type="text" name="title" class="form-control" placeholder="ป้อนชื่อไฟล์"/>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- <div class="row">
                  <div class="col-12">
                    <div class="form-group row mb-1">
                      <label class="col-sm-3 col-form-label text-right">รายละเอียด : </label>
                      <div class="col-sm-8">
                        <input type="text" name="description" class="form-control" placeholder="ป้อนรายละเอียด (ถ้ามี)"/>
                      </div>
                    </div>
                  </div>
                </div> -->
                <div class="row">
                  <div class="col-12">
                    <div class="form-group row mb-1">
                      <label class="col-sm-3 col-form-label text-right"> เลือกไฟล์ :</label>
                      <div class="col-sm-8">
                        <!-- <input type="file" name="file" required/> -->
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" name="file" class="custom-file-input" id="exampleInputFile">
                            <label class="custom-file-label" for="exampleInputFile">เลือกไฟล์ที่ต้องการ</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <br/>
                <input type="hidden" name="uploader" value="{{auth::user()->name}}"/>
                <input type="hidden" name="foldername" value="{{$title1}}" />
                <input type="hidden" name="folder_id" value="{{$id}}"/>
            </div>
            <div style="text-align: center;font-family: 'Prompt', sans-serif;">
              <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-upload"></i> อัพโหลด</button>
              <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="far fa-times-circle"></i> ยกเลิก</button>
            </div>
            <br>
          </div>
        </div>
    </div>
  </form>

  <!-- pop up create new folder -->
  <form action="{{ route('MasterDocument.store') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="modal fade" id="modal-newfolder" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-info">
              <div class="col text-center">
                <h4 class="modal-title text-left" style="font-family: 'Prompt', sans-serif;">สร้างโฟลเดอร์</h4>
              </div>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <br />

            <div class="modal-body" style="font-family: 'Prompt', sans-serif;">
                <div class="row">
                  <div class="col-12">
                    <div class="form-group row mb-1">
                      <label class="col-sm-3 col-form-label text-right">ชื่อโฟลเดอร์ : </label>
                      <div class="col-sm-8">
                        <input type="text" name="foldername" class="form-control" placeholder="ป้อนชื่อโฟลเดอร์ใหม่"/>
                      </div>
                    </div>
                  </div>
                </div>
                <br/>
                <input type="hidden" name="creator" value="{{auth::user()->name}}"/>
                <input type="hidden" name="type" value="1"/>
                <input type="hidden" name="foldertype" value="2"/>
                <input type="hidden" name="folderID" value="{{$folderID}}"/>
            </div>
            <div style="text-align: center; font-family: 'Prompt', sans-serif;">
              <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-folder-plus"></i> สร้าง</button>
              <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="far fa-times-circle"></i> ยกเลิก</button>
            </div>
            <br>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
  </form>

  <div class="modal fade" id="modal-preview">
    <div class="modal-dialog modal-xl">
      <div class="modal-content bg-default">
        <div class="modal-body" style="font-family: 'Prompt', sans-serif;">
          <p>One fine body…</p>
        </div>
        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  {{-- button-to-top --}}
  <script>
    var btn = $('#button');
    $(window).scroll(function() {
      if ($(window).scrollTop() > 300) {
        btn.addClass('show');
      } else {
        btn.removeClass('show');
      }
    });

    btn.on('click', function(e) {
      e.preventDefault();
      $('html, body').animate({scrollTop:0}, '300');
    });
  </script>

  <script>
    $(function () {
      $("#modal-preview").on("show.bs.modal", function (e) {
        var link = $(e.relatedTarget).data("link");
        $("#modal-preview .modal-body").load(link, function(){
        });
      });
    });
  </script>

  <script type="text/javascript">
    $(document).ready(function () {
      bsCustomFileInput.init();
    });
  </script>


@endsection

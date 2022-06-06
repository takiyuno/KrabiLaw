@extends('layouts.master')
@section('title','แผนกการเงิน')
@section('content')

<style>
  .content{
    padding:10px 50px 10px 50px;
  }
</style>

  <!-- Main content -->
  <section class="content" style="font-family: 'Prompt', sans-serif;">
    <div class="content-header">
      @if(session()->has('success'))
        <script type="text/javascript">
          toastr.success('{{ session()->get('success') }}')
        </script>
      @endif

      <section class="content">
        <div class="row justify-content-center">
          <div class="col-12 table-responsive">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col-6">
                    <div class="form-inline">
                      <h5>คลังข้อมูล (Data warehouse)</h5>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="card-tools d-inline float-right">
                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                        <a class="btn bg-info btn-xs hover-up" data-toggle="modal" data-target="#modal-lg" data-backdrop="static">
                          <span class="fas fa-plus"></span> New Folder
                        </a>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body text-sm">
                <div class="row">
                  <div class="col-12">
                    <div class="card card-primary">
                      <div class="card-body">
                        <div class="row">
                          @foreach($data as $row)
                            <div class="col-sm-2">
                            @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                              <form method="post" class="delete_form float-right" action="{{ route('MasterDocument.destroy',[$row->folder_id]) }}?type={{1}}" style="display:inline;">
                                {{csrf_field()}}
                                <input type="hidden" name="_method" value="DELETE" />
                                <input type="hidden" name="foldername" value="{{$row->folder_name}}" />
                                <button type="submit" data-name="โฟลเดอร์ {{$row->folder_name}}" class="delete-modal btn btn-xs AlertForm text-red hover-up" data-toggle="tooltip" data-placement="top" title="ลบโฟลเดอร์">
                                  <i class="far fa-trash-alt"></i>
                                </button>
                              </form>
                            @endif
                              <a href="{{ route('MasterDocument.edit',[$row->folder_id]) }}?type={{1}}">
                                <img src="{{ asset('dist/img/folder6.png') }}" class="img-fluid">
                              </a>
                              <p align="center"> {{$row->folder_name}}</p>
                            </div>
                          @endforeach
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </section>

  <!-- pop up create new folder -->
  <form action="{{ route('MasterDocument.store') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" name="type" value="1">

    <div class="modal fade" id="modal-lg" aria-hidden="true" style="display: none;font-family: 'Prompt', sans-serif;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-info">
              <div class="col text-left">
                <h5 class="modal-title">สร้างโฟลเดอร์</h5>
              </div>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <br />

            <div class="modal-body">
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
                <input type="hidden" name="foldertype" value="1"/>
                <input type="hidden" name="folderID" value=""/>
            </div>
            <div style="text-align: center;">
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

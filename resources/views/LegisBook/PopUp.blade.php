<link rel="stylesheet" href="{{ asset('css/pluginLegislations.css') }}">

<section class="content" style="font-family: 'Prompt', sans-serif;">
  <div class="card card-warning">
    <div class="card-header">
      <h4 class="card-title">
        @if($type == 1)
          <i class="far fa-edit"></i>  แก้ไขรายการสารบัญ
        @elseif($type == 2)
          <i class="far fa-edit"></i>  แก้ไขรายการหนังสือ เข้า-ออก
        @endif
      </h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
    @if($type == 1) {{-- แก้ไขรายการสารบัญ --}}
      <form name="form1" method="post" action="{{ route('MasterBook.update',[$data->Content_id]) }}" enctype="multipart/form-data">
        @csrf
        @method('put')
        <input type="hidden" name="_method" value="PATCH"/>
        <input type="hidden" name="type" value="1">
        <input type="hidden" name="Nameuser" value="{{auth::user()->name}}"/>

        <div class="modal-content">
            <div class="modal-body SizeText">
                {{--<table class="table table-bordered">  
                  <thead>
                      <tr>
                          <th class="text-center" style="width: 50px">ลำดับ</th>
                          <th class="text-center" style="width: 150px">เลขที่สัญญา</th>
                          <th class="text-center" style="width: 90px">คำนำหน้า</th>
                          <th class="text-center" style="width: 150px">ชื่อผู้ซื้อ</th>
                          <th class="text-center" style="width: 150px">สกุลผู้ซื้อ</th>
                          <th class="text-center" style="width: 120px">เลขคดี</th>
                          <th class="text-center" style="width: 250px">จัดเก็บอยู่ที่</th>
                      </tr>
                  </thead>
                    <tr>  
                        <td><input type="text" name="Locat" class="form-control SizeText" value="{{$data->Locat}}"/></td>  
                        <td><input type="text" name="Contract_no" class="form-control SizeText" value="{{$data->Contractno}}"/></td>  
                        <td><input type="text" name="Sname" class="form-control SizeText" value="{{$data->Sname}}"/></td>  
                        <td><input type="text" name="Fname" class="form-control SizeText" value="{{$data->Fname}}"/></td>  
                        <td><input type="text" name="Lname" class="form-control SizeText" value="{{$data->Lname}}"/></td>  
                        <td><input type="text" name="Casenumber" class="form-control SizeText" value="{{$data->Casenumber}}"/></td>  
                        <td><input type="text" name="File_path" class="form-control SizeText" value="{{$data->Filepath}}"/></td>  
                    </tr>  
                </table> --}}
              <div class="row">
                <div class="col-6">
                  <div class="form-group row mb-0">
                    <label class="col-sm-4 col-form-label text-right">เลขที่สัญญา : </label>
                    <div class="col-sm-8">
                      <input type="text" name="Contract_no" class="form-control form-control-sm SizeText" value="{{$data->Contractno }}"/>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group row mb-0">
                    <label class="col-sm-4 col-form-label text-right">วันที่แก้ไขล่าสุด : </label>
                    <div class="col-sm-8">
                      <input type="date" class="form-control form-control-sm SizeText" value="{{substr($data->updated_at,0,10) }}" readonly/>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group row mb-0">
                    <label class="col-sm-4 col-form-label text-right">ชื่อผู้ซื้อ : </label>
                    <div class="col-sm-3">
                      <input type="text" name="Sname" class="form-control form-control-sm SizeText" value="{{$data->Sname }}"/>
                    </div>
                    <div class="col-sm-5">
                      <input type="text" name="Fname" class="form-control form-control-sm SizeText" value="{{$data->Fname }}"/>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group row mb-0">
                    <label class="col-sm-4 col-form-label text-right">สกุลผู้ซื้อ : </label>
                    <div class="col-sm-8">
                      <input type="text" name="Lname" class="form-control form-control-sm SizeText" value="{{$data->Lname }}"/>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group row mb-0">
                    <label class="col-sm-4 col-form-label text-right">เลขคดี : </label>
                    <div class="col-sm-8">
                      <input type="text" name="Casenumber" class="form-control form-control-sm SizeText" value="{{$data->Casenumber }}"/>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group row mb-0">
                    <label class="col-sm-4 col-form-label text-right">ผู้ขอเบิกแฟ้ม : </label>
                    <div class="col-sm-8">
                      <input type="text" name="Usertake" class="form-control form-control-sm SizeText" value="{{$data->Usertake }}"/>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group row mb-0">
                    <label class="col-sm-2 col-form-label text-right">จัดเก็บอยู่ที่ : </label>
                    <div class="col-sm-10">
                      <textarea name="File_path" class="form-control form-control-sm SizeText" rows="3">{{$data->Filepath}}</textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <input type="hidden" name="Locat" class="form-control SizeText" value="{{$data->Locat}}"/>
            <div align="center">
              <button type="submit" class="btn btn-success hover-up SizeText"><i class="fas fa-save"></i> อัพเดท</button>
              <button type="button" class="btn btn-danger hover-up SizeText" data-dismiss="modal"><i class="far fa-window-close"></i> ยกเลิก</button>
            </div>
            <br>
        </div>
      </form>
    @elseif($type == 2)
      <form name="form1" method="post" action="{{ route('MasterBook.update',[$data->id]) }}" enctype="multipart/form-data">
        @csrf
        @method('put')
        <input type="hidden" name="_method" value="PATCH"/>
        <input type="hidden" name="type" value="2">
        <input type="hidden" name="Nameuser" value="{{auth::user()->name}}"/>

        <div class="modal-content">
            <div class="modal-body">
                {{--<table class="table table-bordered">  
                  <thead>
                      <tr>
                        <th class="text-center" style="width: 50px">วันที่</th>
                        <th class="text-center" style="width: 150px">ประเภท</th>
                        <th class="text-center">เรื่อง</th>
                        <th class="text-center">ไปถึง</th>
                        <th class="text-center">มาจาก</th>
                        <th class="text-center">หมายเหตุ</th>
                      </tr>
                  </thead>
                    <tr>  
                        <td><input type="date" name="DateBook" class="form-control SizeText" value="{{$data->Datecreate_book}}"/></td>  
                        <td>
                          <select name="TypeBook" class="form-control SizeText">
                              <option value="หนังสือเข้า" {{ ($data->Type_book === 'หนังสือเข้า') ? 'selected' : '' }}>หนังสือเข้า</option>
                              <option value="หนังสือออก" {{ ($data->Type_book === 'หนังสือออก') ? 'selected' : '' }}>หนังสือออก</option>
                          </select>
                        </td>  
                        <td><input type="text" name="TitleBook" class="form-control SizeText" value="{{$data->Title_book}}"/></td>  
                        <td><input type="text" name="FromWhere" class="form-control SizeText" value="{{$data->Fromwhere_book}}"/></td>  
                        <td><input type="text" name="ToWhere" class="form-control SizeText" value="{{$data->Towhere_book}}"/></td>  
                        <td><input type="text" name="NoteBook" class="form-control SizeText" value="{{$data->Note_book}}"/></td>  
                    </tr>  
                </table>--}}
              <div class="row SizeText">
                <div class="col-6">
                  <div class="form-group row mb-0">
                    <label class="col-sm-4 col-form-label text-right">วันที่เพิ่ม : </label>
                    <div class="col-sm-8">
                      <input type="date" name="DateBook" class="form-control form-control-sm SizeText" value="{{substr($data->Datecreate_book,0,10) }}" readonly/>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group row mb-0">
                    <label class="col-sm-4 col-form-label text-right">ผู้เพิ่ม : </label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control form-control-sm SizeText" value="{{$data->Useradd }}" readonly/>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group row mb-0">
                    <label class="col-sm-4 col-form-label text-right">ประเภท : </label>
                    <div class="col-sm-8">
                        <select name="TypeBook" class="form-control form-control-sm SizeText">
                            <option value="หนังสือเข้า" {{ ($data->Type_book === 'หนังสือเข้า') ? 'selected' : '' }}>หนังสือเข้า</option>
                            <option value="หนังสือออก" {{ ($data->Type_book === 'หนังสือออก') ? 'selected' : '' }}>หนังสือออก</option>
                        </select>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group row mb-0">
                    <label class="col-sm-4 col-form-label text-right">เรื่อง : </label>
                    <div class="col-sm-8">
                      <input type="text" name="TitleBook" class="form-control form-control-sm SizeText" value="{{$data->Title_book }}"/>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group row mb-0">
                    <label class="col-sm-4 col-form-label text-right">ไปถึง : </label>
                    <div class="col-sm-8">
                      <input type="text" name="FromWhere" class="form-control form-control-sm SizeText" value="{{$data->Fromwhere_book }}"/>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group row mb-0">
                    <label class="col-sm-4 col-form-label text-right">มาจาก : </label>
                    <div class="col-sm-8">
                      <input type="text" name="ToWhere" class="form-control form-control-sm SizeText" value="{{$data->Towhere_book }}"/>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group row mb-0">
                    <label class="col-sm-2 col-form-label text-right">หมายเหตุ : </label>
                    <div class="col-sm-10">
                      <textarea name="NoteExpense" class="form-control form-control-sm SizeText" rows="3">{{$data->Note_book}}</textarea>
                    </div>
                  </div>
                </div>
              </div>  
            </div>

            <div align="center">
              <button type="submit" class="btn btn-success hover-up SizeText"><i class="fas fa-save"></i> อัพเดท</button>
              <button type="button" class="btn btn-danger hover-up SizeText" data-dismiss="modal"><i class="far fa-window-close"></i> ยกเลิก</button>
            </div>
            <br>
        </div>
      </form>
    @endif   
    
  </div>
</section>



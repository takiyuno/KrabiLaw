@extends('layouts.master')
@section('title','กฏหมาย/เอกสารประกอบลูกหนี้')
@section('content')

  @if(session()->has('success'))
    <script type="text/javascript">
      toastr.success('{{ session()->get('success') }}')
    </script>
  @endif

  <!-- Main content -->
  <section class="Profile-container" style="font-family: 'Prompt', sans-serif;">
    <form name="form1" method="post" action="{{ route('MasterLegis.update',[$data->id]) }}" enctype="multipart/form-data">
      @csrf
      @method('put')
      <input type="hidden" name="_method" value="PATCH"/>
      <input type="hidden" name="contract" value="{{ $data->Contract_legis }}">
      <input type="hidden" name="useradd" value="{{auth::user()->name}}"/>
      <input type="hidden" name="type" value="11"/>

      <div class="content">
        <div class="content-header">
          <div class="row">
            <div class="col-8">
              <div class="form-inline">
                <h5>เอกสารประกอบลูกหนี้ <small class="textHeader">(Documents Debtor)</small></h5>
              </div>
            </div>
            <div class="col-4">
              <div class="card-tools d-inline float-right">
                <button type="submit" class="btn btn-success btn-sm SizeText hover-up">
                  <i class="fas fa-save"></i> บันทึก
                </button>
                <a class="btn btn-danger btn-sm SizeText hover-up" href="{{ route('MasterCompro.index') }}?type={{2}}">
                  <i class="far fa-window-close"></i> กลับ
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <section class="col-lg-3 connectedSortable ui-sortable">
            <div class="box-shadow">
              <div class="author-card pb-3 pt-3">
                <div class="author-card-cover" style="background-image: url({{ asset('dist/img/bg1.jpg') }})">
                  @if($data->Flag_status == 2)
                    @if($data->Status_legis != NULL)
                      <a href="{{ route('MasterLegis.index') }}?type={{6}}" class="btn btn-style-1 btn-sm hover-up bg-green" data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterLegis.show',$id) }}?type={{2}}">
                        <i class="fas fa-clipboard-check text-md"></i> {{$data->Status_legis}}
                      </a>
                    @else
                      <a href="{{ route('MasterLegis.index') }}?type={{6}}" class="btn btn-style-1 btn-sm hover-up bg-white" data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterLegis.show',$id) }}?type={{2}}">
                        <i class="fas fa-clipboard-check text-md"></i> ปิดบัญชี
                      </a>
                    @endif
                  @else
                    @if($data->Status_legis != NULL)
                      <a class="btn btn-style-1 btn-sm hover-up bg-green" data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterLegis.show',$id) }}?type={{3}}">
                        <i class="fas fa-clipboard-check text-md"></i> {{$data->Status_legis}}
                      </a>
                    @endif
                  @endif
                </div>
                <div class="author-card-profile">
                  <div class="author-card-avatar"><img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="Daniel Adams">
                  </div>
                  <div class="author-card-details">
                    <h5 class="author-card-name text-lg">{{ $data->Contract_legis }}</h5>
                    <span class="author-card-position">{{ $data->Name_legis }}</span>
                  </div>
                </div>
              </div>
              <div class="wizard">
                <nav class="list-group list-group-flush">
                  <a class="list-group-item hover-up" href="{{ route('MasterLegis.edit',[$data->id]) }}?type={{3}}">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <i class="fas fa-user-tag mr-1 text-muted"></i>
                        <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ เตรียมฟ้อง</div>
                      </div>
                      @if($data->Flag_status == 2)
                        <i class="far fa-check-square sub-target"></i>
                      @endif
                    </div>
                  </a>
                  <a class="list-group-item  hover-up {{ ($data->Flag_status == 2) ? '' : 'disabled' }}" href="{{ route('MasterLegis.edit',[$data->id]) }}?type={{4}}">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <i class="fas fa-balance-scale text-muted"></i>
                        <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ ชั้นศาล</div>
                      </div>
                      @if($data->Flag_Class === 'สถานะสืบทรัพย์บังคับคดี' or $data->Flag_Class === 'สถานะคัดโฉนด' or $data->Flag_Class === 'สถานะตั้งยึดทรัพย์' or $data->Flag_Class === 'ประกาศขายทอดตลาด' or $data->Flag_Class === 'จบงานชั้นบังคับคดี')
                        <i class="far fa-check-square sub-target"></i>
                      @endif
                    </div>
                  </a>
                  <a class="list-group-item hover-up {{ ($data->Flag_status == 2) ? '' : 'disabled' }}" href="{{ route('MasterLegis.edit',[$data->id]) }}?type={{5}}">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <i class="fas fa-link text-muted"></i>
                        <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ ชั้นบังคับคดี</div>
                      </div>
                      @if($data->Flag_Class == 'จบงานชั้นบังคับคดี')
                        <i class="far fa-check-square sub-target"></i>
                      @endif
                    </div>
                  </a>
                  <a class="list-group-item hover-up {{ ($data->Flag_status == 2) ? '' : 'disabled' }}" href="{{ route('MasterLegis.edit',[$data->id]) }}?type={{6}}">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <i class="fas fa-search-location text-muted"></i>
                        <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ สืบทรัพย์</div>
                      </div>
                      @if(@$data->Legisasset->propertied_asset === 'Y')
                        <i class="fa fa-1x" style="color:red;"><span title="ลูกหนี้มีทรัพย์">Y</span></i> 
                      @elseif(@$data->Legisasset->propertied_asset === 'N')
                        <i class="fa fa-1x" style="color:red;" title="ลูกหนี้ไม่มีทรัพย์"><span>N</span></i> 
                      @endif
                    </div>
                  </a>
                  <a class="list-group-item hover-up {{ ($data->Flag_status == 2 or $data->Flag == 'C') ? '' : 'disabled' }}" href="{{ route('MasterCompro.edit',[$data->id]) }}?type={{1}}"><i class="fas fa-hand-holding-usd text-muted"></i>ลูกหนี้ ประนอมหนี้</a>
                  <a class="list-group-item hover-up active{{ ($data->Flag_status == 2 or $data->Flag == 'C') ? '' : 'disabled' }}" href="{{ route('MasterLegis.edit',[$data->id]) }}?type={{7}}"><i class="fas fa-folder-open text-muted"></i>เอกสาร ลูกหนี้</a>
                  <a class="list-group-item hover-up {{ ($data->Flag_status == 2 or $data->Flag == 'C') ? '' : 'disabled' }}" href="{{ route('MasterExpense.edit',[$data->id]) }}?type={{1}}">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <i class="fas fa-money-check-alt text-muted"></i>
                        <div class="d-inline-block font-weight-medium text-uppercase">ธุรกรรม ลูกหนี้</div>
                      </div>
                      @if($data->LegisExpense != NULL)
                        <i class="far fa-check-square sub-target"></i>
                      @endif
                    </div>
                  </a>
                </nav>
              </div>
            </div>
          </section>
          <section class="col-lg-9 connectedSortable ui-sortable">
            <div class="card">
              <div class="card-body text-sm">
                  <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">เอกสารประกอบ <span class="textHeader">(Documents)</span></h6>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="input-group">
                        <div class="custom-file mb-2">
                          <input type="file" name="filePDF[]" class="custom-file-input" id="exampleInputFile" multiple>
                          <label class="custom-file-label" for="exampleInputFile">เลือกไฟล์อัพโหลด</label>
                        </div>
                      </div>
                    </div>
                  </div>
                    <div class="card">
                      <div class="card-body">
                        <div class="row">
                          <div class="table-responsive SizeText">
                            <table class="table table-striped table-valign-middle " id="table">
                              <thead>
                                <tr>
                                  <th class="text-center"  style="width: 50px;">ลำดับ.</th>
                                  <th class="text-center">ชื่อเอกสาร</th>
                                  <th class="text-center">วันที่อัพโหลด</th>
                                  <th class="text-center">ผู้อัพโหลด</th>
                                  <th class="text-center" style="width: 100px;">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach($dataImages as $key => $row)
                                  <tr>
                                    <td class="text-center"> {{$key+1}}</td>
                                    <td class="text-left"> 
                                      <i class="fa fa-file-o text-primary"></i>
                                      &nbsp;{{$row->name_image}}
                                    </td>
                                    <td class="text-center">{{formatDateThai(substr($row->created_at,0,10))}}</td>
                                    <td class="text-center">{{$row->useradd_image}}</td>
                                    <td class="text-right">
                                      <a target="_blank" href="{{ route('MasterLegis.edit',[$data->id]) }}?type={{7}}&preview={{1}}&file_id={{$row->id}}" class="btn btn-warning btn-xs hover-up" title="ดูไฟล์">
                                        <i class="far fa-eye"></i>
                                      </a>
                                      <a href="{{ action('LegislationController@download',[$row->name_image])}}?contractNo={{$data->Contract_legis}}" class="btn btn-info btn-xs hover-up" title="ดาวน์โหลดไฟล์">
                                        <i class="fas fa-download"></i>
                                      </a>
                                      <a href="{{ action('LegislationController@deleteImageAll',$data->id) }}?type={{3}}&contract={{ $data->Contract_legis }}&file_id={{$row->id}}" title="ลบรายการนี้" class="btn btn-danger btn-xs AlertDelete hover-up" data-name="{{$row->name_image}}">
                                        <i class="fa fa-trash"></i>
                                      </a>
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
            </div>
          </section>
        </div>
      </div>
    </form>
  </section>

  <div class="modal fade" id="modal-Popup">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
        </div>
      </div>
    </div>
  </div>
@endsection

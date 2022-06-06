@extends('layouts.master')
@section('title','กฏหมาย/ลูกหนี้ชั้นศาล')
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
                <h5>ลูกหนี้จบงานฟ้อง <small class="textHeader">(Endcase Debtors)</small></h5>
            </div>
          </div>
          <div class="col-4">
            <form method="get" action="{{ route('MasterLegis.index') }}">
              <div class="card-tools d-inline float-right btn-page">
                <div class="input-group form-inline">
                  <span class="text-right mr-sm-1">วันที่ : </span>
                  <input type="text" id="dateSearch" name="dateSearch" value="{{ ($dateSearch != '') ?$dateSearch: '' }}" class="form-control form-control-sm textSize" placeholder="วันที - ถึงวันที่">
                  <span class="input-group-append">
                    <button type="submit" class="btn btn-info btn-sm button-id mr-sm-1">
                      <i class="fas fa-search"></i>
                    </button>
                  </span>
                  <button class="btn btn-info btn-sm hover-up" data-toggle="dropdown">
                    <i class="fas fa-print"></i>
                  </button>
                  <ul class="dropdown-menu text-sm" role="menu">
                    <li><a target="_blank" class="dropdown-item SizeText" href="{{ route('Legislation.Report') }}?type={{5}}">รายงาน ลูกหนี้จบงานฟ้อง</a></li>
                    <!-- <li class="dropdown-divider"></li>
                    <li><a target="_blank" href="#" class="dropdown-item"> รายงาน ลูกค้าขาดติดตาม</a></li> -->
                  </ul>
                </div>
              </div>
              <input type="hidden" name="FlagTab" id="FlagTab">
              <input type="hidden" name="type" value="{{$type}}">
            </form>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3">
          <div class="box-shadow">
            <div class="author-card pb-3 pt-3">
              <span class="text-right textHeader-1">
                <i class="mr-3 text-muted"></i> 
                  ลูกหนี้ทั้งหมด (<b><span class="text-red">{{count($data1)+count($data2)+count($data3)}}</span></b> ราย)
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
                      <i class="fas fa-user-tag mr-1 text-muted"></i>
                      <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ ปิดบัญชี</div>
                    </div>
                      @if(count($data1) != 0)
                        <span class="badge bg-danger prem">{{count($data1)}}</span>
                      @endif
                  </div>
                </a>
                <a class="list-group-item hover-up" data-toggle="tab" href="#list-page2-list">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <i class="fas fa-user-tag mr-1 text-muted"></i>
                      <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ ปิดจบประนอม</div>
                    </div>
                      @if(count($data2) != 0)
                        <span class="badge bg-danger prem">{{count($data2)}}</span>
                      @endif
                  </div>
                </a>
                <a class="list-group-item hover-up" data-toggle="tab" href="#list-page3-list">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <i class="fas fa-user-tag mr-1 text-muted"></i>
                      <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ ปิดจบยึดรถ</div>
                    </div>
                      @if(count($data3) != 0)
                        <span class="badge bg-danger prem">{{count($data3)}}</span>
                      @endif
                  </div>
                </a>
                <a class="list-group-item hover-up" data-toggle="tab" href="#list-page4-list">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <i class="fas fa-user-tag mr-1 text-muted"></i>
                      <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ ปิดจบถอนบังคับคดี</div>
                    </div>
                      @if(count($data4) != 0)
                        <span class="badge bg-danger prem">{{count($data4)}}</span>
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
                <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ลูกหนี้  <span class="textHeader">(ปิดบัญชี)</span></h6>
                    <table class="table table-hover SizeText" id="table11">
                      <thead>
                        <tr>
                          <th class="text-center">ลำดับ</th>
                          <th class="text-center">เลขที่สัญญา</th>
                          <th class="text-center">ชื่อ-สกุล</th>
                          <th class="text-center">วันฟ้อง</th>
                          <th class="text-center">สถานะ</th>
                          <th class="text-center">วันที่ปิดจบ</th>
                          <th class="text-center" style="width: 70px">#</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($data1 as $key => $row)
                          <tr>
                            <td class="text-center"> {{$key+1}}</td>
                            <td class="text-center"> {{$row->Contract_legis}}</td>
                            <td class="text-left"> {{$row->Name_legis}} </td>
                            <td class="text-center"> {{ ($row->legiscourt->fillingdate_court != NULL?formatDateThai($row->legiscourt->fillingdate_court): '-') }} </td>
                            <td class="text-center">
                              @if($row->Status_legis != NULL)
                                <button class="btn btn-success btn-xs SizeText" data-toggle="tooltip" data-placement="top" title="ปิดจบงานแล้ว">
                                  <i class="fas fa-user-check pr-1 prem"></i> {{$row->Status_legis}}
                                </button>
                              @endif
                            </td>
                            <td class="text-center">
                              <!-- <button class="btn btn-success btn-xs SizeText" title="ปิดจบงานแล้ว"> -->
                                {{ ($row->DateStatus_legis != NULL ?formatDateThai($row->DateStatus_legis): '-') }}
                              <!-- </button> -->
                            </td>
                            <td class="text-right">
                              <a href="{{ route('MasterLegis.edit',[$row->id]) }}?type={{3}}" class="btn btn-warning btn-sm hover-up" data-toggle="tooltip" data-placement="top" title="แก้ไขรายการ">
                                <i class="far fa-edit"></i>
                              </a>
                              <a data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterLegis.show',[$row->id]) }}?type={{7}}" class="btn btn-info btn-sm hover-up" data-toggle="tooltip" data-placement="top" title="ดูรายการปิดบัญชี">
                                <i class="far fa-eye"></i>
                              </a>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
              </div>
              <div id="list-page2-list" class="container tab-pane fade SizeText">
                <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ลูกหนี้ <span class="textHeader">(ปิดจบประนอม)</span></h6>
                    <table class="table table-hover SizeText" id="table22">
                      <thead>
                        <tr>
                          <th class="text-center">ลำดับ</th>
                          <th class="text-center">เลขที่สัญญา</th>
                          <th class="text-center">ชื่อ-สกุล</th>
                          <th class="text-center">ยอดประนอม</th>
                          <th class="text-center">สถานะ</th>
                          <th class="text-center">วันที่ปิดจบ</th>
                          <th class="text-center" style="width: 70px">#</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($data2 as $key => $row)
                          <tr>
                            <td class="text-center"> {{$key+1}}</td>
                            <td class="text-center"> {{$row->Contract_legis}}</td>
                            <td class="text-left"> {{$row->Name_legis}} </td>
                            <td class="text-center"> {{ number_format(@$row->legisCompromise->Total_Promise, 2) }} </td>
                            <td class="text-center">
                              @if($row->Status_legis != NULL)
                                <button class="btn btn-success btn-xs SizeText" data-toggle="tooltip" data-placement="top" title="ปิดจบงานแล้ว">
                                  <i class="fas fa-user-check pr-1 prem"></i> {{$row->Status_legis}}
                                </button>
                              @endif
                            </td>
                            <td class="text-center">
                              <!-- <button class="btn btn-success btn-xs SizeText" title="ปิดจบงานแล้ว"> -->
                                {{ ($row->DateStatus_legis != NULL ?formatDateThai($row->DateStatus_legis): '-') }}
                                <!-- </button> -->
                            </td>
                            <td class="text-right">
                              <a href="{{ route('MasterCompro.edit',[$row->id]) }}?type={{1}}" class="btn btn-warning btn-sm hover-up" data-toggle="tooltip" data-placement="top" title="แก้ไขรายการ">
                                <i class="far fa-edit"></i>
                              </a>
                              <a data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterLegis.show',[$row->id]) }}?type={{3}}" class="btn btn-info btn-sm hover-up" data-toggle="tooltip" data-placement="top" title="ดูรายการปิดบัญชี">
                                <i class="far fa-eye"></i>
                              </a>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
              </div>
              <div id="list-page3-list" class="container tab-pane fade SizeText">
                <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ลูกหนี้ <span class="textHeader">(ปิดจบยึดรถ)</span></h6>
                    <table class="table table-hover SizeText" id="table33">
                      <thead>
                        <tr>
                          <th class="text-center">ลำดับ</th>
                          <th class="text-center">เลขที่สัญญา</th>
                          <th class="text-center">ชื่อ-สกุล</th>
                          <th class="text-center">วันฟ้อง</th>
                          <th class="text-center">สถานะ</th>
                          <th class="text-center">วันที่ปิดจบ</th>
                          <th class="text-center" style="width: 70px">#</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($data3 as $key => $row)
                          <tr>
                            <td class="text-center"> {{$key+1}}</td>
                            <td class="text-center"> {{$row->Contract_legis}}</td>
                            <td class="text-left"> {{$row->Name_legis}} </td>
                            <td class="text-center"> {{ ($row->legiscourt->fillingdate_court != NULL?formatDateThai($row->legiscourt->fillingdate_court): '-') }} </td>
                            <td class="text-center">
                              @if($row->Status_legis != NULL)
                                <button class="btn btn-success btn-xs SizeText" data-toggle="tooltip" data-placement="top" title="ปิดจบงานแล้ว">
                                  <i class="fas fa-user-check pr-1 prem"></i> {{$row->Status_legis}}
                                </button>
                              @endif
                            </td>
                            <td class="text-center">
                              <!-- <button class="btn btn-success btn-xs SizeText" title="ปิดจบงานแล้ว"> -->
                                {{ ($row->DateStatus_legis != NULL ?formatDateThai($row->DateStatus_legis): '-') }}
                              <!-- </button> -->
                            </td>
                            <td class="text-right">
                              <a href="{{ route('MasterLegis.edit',[$row->id]) }}?type={{3}}" class="btn btn-warning btn-sm hover-up" data-toggle="tooltip" data-placement="top" title="แก้ไขรายการ">
                                <i class="far fa-edit"></i>
                              </a>
                              <a data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterLegis.show',[$row->id]) }}?type={{7}}" class="btn btn-info btn-sm hover-up" data-toggle="tooltip" data-placement="top" title="ดูรายการปิดบัญชี">
                                <i class="far fa-eye"></i>
                              </a>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
              </div>
              <div id="list-page4-list" class="container tab-pane fade SizeText">
                <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ลูกหนี้ <span class="textHeader">(ปิดจบถอนบังคับคดี)</span></h6>
                    <table class="table table-hover SizeText" id="table33">
                      <thead>
                        <tr>
                          <th class="text-center">ลำดับ</th>
                          <th class="text-center">เลขที่สัญญา</th>
                          <th class="text-center">ชื่อ-สกุล</th>
                          <th class="text-center">วันฟ้อง</th>
                          <th class="text-center">สถานะ</th>
                          <th class="text-center">วันที่ปิดจบ</th>
                          <th class="text-center" style="width: 70px">#</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($data4 as $key => $row)
                          <tr>
                            <td class="text-center"> {{$key+1}}</td>
                            <td class="text-center"> {{$row->Contract_legis}}</td>
                            <td class="text-left"> {{$row->Name_legis}} </td>
                            <td class="text-center"> {{ ($row->legiscourt->fillingdate_court != NULL?formatDateThai($row->legiscourt->fillingdate_court): '-') }} </td>
                            <td class="text-center">
                              @if($row->Status_legis != NULL)
                                <button class="btn btn-success btn-xs SizeText" data-toggle="tooltip" data-placement="top" title="ปิดจบงานแล้ว">
                                  <i class="fas fa-user-check pr-1 prem"></i> {{$row->Status_legis}}
                                </button>
                              @endif
                            </td>
                            <td class="text-center">
                              <!-- <button class="btn btn-success btn-xs SizeText" title="ปิดจบงานแล้ว"> -->
                                {{ ($row->DateStatus_legis != NULL ?formatDateThai($row->DateStatus_legis): '-') }}
                              <!-- </button> -->
                            </td>
                            <td class="text-right">
                              <a href="{{ route('MasterLegis.edit',[$row->id]) }}?type={{3}}" class="btn btn-warning btn-sm hover-up" data-toggle="tooltip" data-placement="top" title="แก้ไขรายการ">
                                <i class="far fa-edit"></i>
                              </a>
                              <a data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterLegis.show',[$row->id]) }}?type={{7}}" class="btn btn-info btn-sm hover-up" data-toggle="tooltip" data-placement="top" title="ดูรายการปิดบัญชี">
                                <i class="far fa-eye"></i>
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

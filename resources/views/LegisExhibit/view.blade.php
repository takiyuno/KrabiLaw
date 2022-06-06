@extends('layouts.master')
@section('title','กฏหมาย/ลูกหนี้ชั้นศาล')
@section('content')

  @if(session()->has('success'))
    <script type="text/javascript">
      toastr.success('{{ session()->get('success') }}')
    </script>
  @endif

  @if(session()->has('success'))
    @php
      $FlagTab = session()->get('FlagTab');
    @endphp
  @endif

  <!-- Main content -->
  <section class="Profile-container" style="font-family: 'Prompt', sans-serif;">
    <div class="content">
      <div class="content-header">
        <div class="row">
          <div class="col-8">
            <div class="form-inline">
                <h5>ลูกหนี้ของกลาง <small class="textHeader">(Exhibit Debtors)</small></h5>
            </div>
          </div>
          <div class="col-4">
            <form method="get" action="#">
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
                    <li><a target="_blank" class="dropdown-item" data-toggle="modal" data-target="#modal-new" data-link="#"> รายงาน บันทึกติดตาม</a></li>
                    <li class="dropdown-divider"></li>
                    <li><a target="_blank" href="#" class="dropdown-item"> รายงาน ลูกค้าขาดติดตาม</a></li>
                  </ul>
                </div>
              </div>
              <input type="hidden" name="FlagTab" id="FlagTab">
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
                <a class="list-group-item hover-up @if(isset($FlagTab)) {{($FlagTab == 1) ? 'active' : '' }} @else active @endif" id="vert-tabs-01-tab" data-toggle="tab" href="#list-page1-list">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <i class="fas fa-user-tag mr-1 text-muted"></i>
                      <div class="d-inline-block font-weight-medium text-uppercase">ประเภท ของกลาง</div>
                    </div>
                      @if(count($data1) != 0)
                        <span class="badge bg-danger">{{count($data1)}}</span>
                      @endif
                  </div>
                </a>
                <a class="list-group-item hover-up @if(isset($FlagTab)) {{($FlagTab == 2) ? 'active' : '' }} @endif" id="vert-tabs-02-tab" data-toggle="tab" href="#list-page2-list">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <i class="fas fa-user-tag mr-1 text-muted"></i>
                      <div class="d-inline-block font-weight-medium text-uppercase">ประเภท ยึดตามมาตราการ(ปปส.)</div>
                    </div>
                      @if(count($data2) != 0)
                        <span class="badge bg-danger">{{count($data2)}}</span>
                      @endif
                  </div>
                </a>
                <!-- <a class="list-group-item hover-up @if(isset($FlagTab)) {{($FlagTab == 3) ? 'active' : '' }} @endif" id="vert-tabs-03-tab" data-toggle="tab" href="#list-page3-list">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <i class="fas fa-user-tag mr-1 text-muted"></i>
                      <div class="d-inline-block font-weight-medium text-uppercase">ประเภท ยังไม่ระบุ</div>
                    </div>
                      @if(count($data3) != 0)
                        <span class="badge bg-danger">{{count($data3)}}</span>
                      @endif
                  </div>
                </a> -->
              </nav>
            </div>
          </div>
        </div>
        <div class="col-lg-9">
            <div class="tab-content">
              <div id="list-page1-list" class="container tab-pane SizeText @if(isset($FlagTab)) {{($FlagTab == 1) ? 'active' : '' }} @else active @endif">
                <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ประเภท  <span class="textHeader">(ของกลาง)</span></h6>
                <button type="button" class="btn btn-sm bg-success SizeText Button" data-toggle="modal" data-target="#modal-default" data-link="{{ route('MasterLegis.create') }}?type={{1}}&dateSearch={{$dateSearch}}&FlagTab={{1}}" title="เพิ่มรายการของกลาง">
                  <i class="fas fa-plus"></i> เพิ่ม
                </button>
                  <table class="table table-hover SizeText" id="table11">
                    <thead>
                      <tr>
                        <!-- <th class="text-center">ลำดับ</th> -->
                        <th class="text-center">เลขที่สัญญา</th>
                        <th class="text-center">ชื่อ-สกุล</th>
                        <th class="text-center">ชื่อผู้ต้องหา</th>
                        <th class="text-center">ข้อหา</th>
                        <th class="text-center">บอกเลิกโดย</th>
                        <th class="text-center">แจ้งเตือน</th>
                        <th class="text-center" style="width: 90px"></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data1 as $key => $row)
                        <tr>
                          <!-- <td class="text-center">{{$key+1}}</td> -->
                          <td class="text-left">{{$row->Contract_legis}}</td>
                          <td class="text-left">{{$row->Name_legis}}</td>
                          <td class="text-left">{{($row->Suspect_legis != NULL?$row->Suspect_legis:'-')}}</td>
                          <td class="text-left">{{($row->Plaint_legis != NULL?$row->Plaint_legis:'-')}}</td>
                          <td class="text-center">{{($row->Terminate_legis != NULL?$row->Terminate_legis:'-')}}</td>
                          <td class="text-center">
                            @if($row->Typeexhibit_legis == 'ของกลาง')
                              @if($row->Dategetresult_legis != null)
                              <button type="button" class="btn btn-success btn-sm" title="จบงาน {{FormatDatethai($row->Dategetresult_legis)}}">
                                <i class="fa fa-check-circle prem"></i>
                              </button>
                              @elseif($row->Dateinvestigate_legis != null)
                                  @php
                                    $datecheck = date('Y-m-d');
                                    $Cldate = date_create($row->Dateinvestigate_legis);
                                    $nowCldate = date_create($datecheck);
                                    $ClDateDiff = date_diff($Cldate,$nowCldate);
                                    // $duration = $ClDateDiff->format("อีก %a วัน");
                                  @endphp
                                  @if($datecheck > $row->Dateinvestigate_legis)
                                    <button type="button" class="btn btn-warning btn-sm" title="เลยไต่สวนแล้ว">
                                      <i class="fa fa-exclamation-triangle prem"></i>
                                    </button>
                                  @elseif($ClDateDiff->days <= 7)
                                    <button type="button" class="btn btn-danger btn-sm prem" title="ไต่สวนอีก {{$ClDateDiff->days}} วัน">
                                      <i class="fa fa-exclamation-triangle prem"></i>
                                    </button>
                                  @endif
                              @elseif($row->Datesendword_legis != null)
                                  <button type="button" class="btn btn-warning btn-sm" title="ยื่นคำร้อง">
                                    <i class="fa fa-exclamation-triangle prem"></i>
                                  </button>
                              @elseif($row->Datepreparedoc_legis != null)
                                  <button type="button" class="btn btn-primary btn-sm" title="เตรียมเอกสาร">
                                    <i class="fa fa-exclamation-triangle prem"></i>
                                  </button>
                              @elseif($row->Datecheckexhibit_legis != null)
                                  <button type="button" class="btn btn-primary btn-sm" title="เช็คสำนวน">
                                    <i class="fa fa-exclamation-triangle prem"></i>
                                  </button>
                              @elseif($row->Dategiveword_legis != null)
                                  <button type="button" class="btn btn-primary btn-sm" title="สอบคำให้การ">
                                    <i class="fa fa-exclamation-triangle prem"></i>
                                  </button>
                              @else
                                <button type="button" class="btn btn-gray btn-sm" title="ยังไม่มีแจ้งเตือน">
                                  <i class="fa fa-question-circle prem"></i>
                                </button>
                              @endif
                            @endif
                            @if($row->Typeexhibit_legis == 'ยึดตามมาตราการ(ปปส.)')
                              @if($row->Dategetresult_legis != null)
                              <button type="button" class="btn btn-success btn-sm" title="จบงาน {{FormatDatethai($row->Dategetresult_legis)}}">
                                <i class="fa fa-check-circle prem"></i>
                              </button>
                              @elseif($row->Datesenddetail_legis != null)
                                <button type="button" class="btn btn-danger btn-sm" title="ส่งรายละเอียด">
                                  <i class="fa fa-exclamation-triangle prem"></i>
                                </button>
                              @else
                                  <button type="button" class="btn btn-gray btn-sm" title="ยังไม่มีแจ้งเตือน">
                                    <i class="fa fa-question-circle prem"></i>
                                  </button>
                                @endif
                            @endif
                          </td>
                          <td class="text-right">
                            @if($row->ExpenseToExhibit != NULL)
                            <a target="_Blank" href="{{ route('MasterExpense.show',[$row->ExpenseToExhibit->id]) }}?type={{4}}&Flagtype={{4}}&Groupcode={{$row->ExpenseToExhibit->Code_expense}}" class="btn btn-primary btn-xs hover-up" data-toggle="tooltip" data-placement="top" title="ปริ้นใบเสร็จ">
                              <i class="fas fa-print"></i>
                            </a>
                            @endif
                            <a data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterLegis.edit',[$row->id]) }}?type={{8}}&dateSearch={{$dateSearch}}&FlagTab={{1}}" class="btn btn-warning btn-xs hover-up" data-backdrop="static">
                              <i class="far fa-edit" data-toggle="tooltip" data-placement="top" title="แก้ไขรายการ"></i>
                            </a>
                            <form method="post" class="delete_form" action="{{ route('MasterLegis.destroy',[$row->id]) }}" style="display:inline;">
                            {{csrf_field()}}
                              <input type="hidden" name="type" value="3" />
                              <input type="hidden" name="FlagTab" value="1" />
                              <input type="hidden" name="_method" value="DELETE" />
                              <button type="submit" data-name="{{ $row->Contract_legis }}" class="delete-modal btn btn-danger btn-xs AlertForm hover-up" data-toggle="tooltip" data-placement="top" title="ลบรายการ">
                                <i class="far fa-trash-alt"></i>
                              </button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
              </div>
              <div id="list-page2-list" class="container tab-pane fade show SizeText @if(isset($FlagTab)) {{($FlagTab == 2) ? 'active' : '' }} @endif">
                <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ประเภท <span class="textHeader">(ยึดตามมาตราการ(ปปส.))</span></h6>
                <button type="button" class="btn btn-sm bg-success SizeText Button" data-toggle="modal" data-target="#modal-default" data-link="{{ route('MasterLegis.create') }}?type={{1}}&dateSearch={{$dateSearch}}&FlagTab={{2}}" title="เพิ่มรายการของกลาง">
                  <i class="fas fa-plus"></i> เพิ่ม
                </button>
                  <table class="table table-hover SizeText" id="table22">
                    <thead>
                      <tr>
                        <!-- <th class="text-center">ลำดับ</th> -->
                        <th class="text-center">เลขที่สัญญา</th>
                        <th class="text-center">ชื่อ-สกุล</th>
                        <th class="text-center">ชื่อผู้ต้องหา</th>
                        <th class="text-center">ข้อหา</th>
                        <th class="text-center">บอกเลิกโดย</th>
                        <th class="text-center">แจ้งเตือน</th>
                        <th class="text-center" style="width: 90px"></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data2 as $key => $row)
                        <tr>
                          <!-- <td class="text-center">{{$key+1}}</td> -->
                          <td class="text-left">{{$row->Contract_legis}}</td>
                          <td class="text-left">{{$row->Name_legis}}</td>
                          <td class="text-left">{{($row->Suspect_legis != NULL?$row->Suspect_legis:'-')}}</td>
                          <td class="text-left">{{($row->Plaint_legis != NULL?$row->Plaint_legis:'-')}}</td>
                          <td class="text-center">{{($row->Terminate_legis != NULL?$row->Terminate_legis:'-')}}</td>
                          <td class="text-center">
                            @if($row->Typeexhibit_legis == 'ของกลาง')
                              @if($row->Dategetresult_legis != null)
                              <button type="button" class="btn btn-success btn-sm" title="จบงาน {{FormatDatethai($row->Dategetresult_legis)}}">
                                <i class="fa fa-check-circle prem"></i>
                              </button>
                              @elseif($row->Dateinvestigate_legis != null)
                                  @php
                                    $datecheck = date('Y-m-d');
                                    $Cldate = date_create($row->Dateinvestigate_legis);
                                    $nowCldate = date_create($datecheck);
                                    $ClDateDiff = date_diff($Cldate,$nowCldate);
                                    // $duration = $ClDateDiff->format("อีก %a วัน");
                                  @endphp
                                  @if($datecheck > $row->Dateinvestigate_legis)
                                    <button type="button" class="btn btn-warning btn-sm" title="เลยไต่สวนแล้ว">
                                      <i class="fa fa-exclamation-triangle prem"></i>
                                    </button>
                                  @elseif($ClDateDiff->days <= 7)
                                    <button type="button" class="btn btn-danger btn-sm prem" title="ไต่สวนอีก {{$ClDateDiff->days}} วัน">
                                      <i class="fa fa-exclamation-triangle prem"></i>
                                    </button>
                                  @endif
                              @elseif($row->Datesendword_legis != null)
                                  <button type="button" class="btn btn-warning btn-sm" title="ยื่นคำร้อง">
                                    <i class="fa fa-exclamation-triangle prem"></i>
                                  </button>
                              @elseif($row->Datepreparedoc_legis != null)
                                  <button type="button" class="btn btn-primary btn-sm" title="เตรียมเอกสาร">
                                    <i class="fa fa-exclamation-triangle prem"></i>
                                  </button>
                              @elseif($row->Datecheckexhibit_legis != null)
                                  <button type="button" class="btn btn-primary btn-sm" title="เช็คสำนวน">
                                    <i class="fa fa-exclamation-triangle prem"></i>
                                  </button>
                              @elseif($row->Dategiveword_legis != null)
                                  <button type="button" class="btn btn-primary btn-sm" title="สอบคำให้การ">
                                    <i class="fa fa-exclamation-triangle prem"></i>
                                  </button>
                              @else
                                <button type="button" class="btn btn-gray btn-sm" title="ยังไม่มีแจ้งเตือน">
                                  <i class="fa fa-question-circle prem"></i>
                                </button>
                              @endif
                            @endif
                            @if($row->Typeexhibit_legis == 'ยึดตามมาตราการ(ปปส.)')
                              @if($row->Dategetresult_legis != null)
                              <button type="button" class="btn btn-success btn-sm" title="จบงาน {{FormatDatethai($row->Dategetresult_legis)}}">
                                <i class="fa fa-check-circle prem"></i>
                              </button>
                              @elseif($row->Datesenddetail_legis != null)
                                <button type="button" class="btn btn-danger btn-sm" title="ส่งรายละเอียด">
                                  <i class="fa fa-exclamation-triangle prem"></i>
                                </button>
                              @else
                                  <button type="button" class="btn btn-gray btn-sm" title="ยังไม่มีแจ้งเตือน">
                                    <i class="fa fa-question-circle prem"></i>
                                  </button>
                                @endif
                            @endif
                          </td>
                          <td class="text-right">
                            @if($row->ExpenseToExhibit != NULL)
                            <a target="_Blank" href="{{ route('MasterExpense.show',[$row->ExpenseToExhibit->id]) }}?type={{4}}&Flagtype={{4}}&Groupcode={{$row->ExpenseToExhibit->Code_expense}}" class="btn btn-primary btn-xs hover-up" data-toggle="tooltip" data-placement="top" title="ปริ้นใบเสร็จ">
                              <i class="fas fa-print"></i>
                            </a>
                            @endif
                            <a data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterLegis.edit',[$row->id]) }}?type={{8}}&dateSearch={{$dateSearch}}&FlagTab={{2}}" class="btn btn-warning btn-xs hover-up">
                              <i class="far fa-edit" data-toggle="tooltip" data-placement="top" title="แก้ไขรายการ"></i>
                            </a>
                            <form method="post" class="delete_form" action="{{ route('MasterLegis.destroy',[$row->id]) }}" style="display:inline;">
                            {{csrf_field()}}
                              <input type="hidden" name="type" value="3" />
                              <input type="hidden" name="FlagTab" value="2" />
                              <input type="hidden" name="_method" value="DELETE" />
                              <button type="submit" data-name="{{ $row->Contract_legis }}" class="delete-modal btn btn-danger btn-xs AlertForm hover-up" data-toggle="tooltip" data-placement="top" title="ลบรายการ">
                                <i class="far fa-trash-alt"></i>
                              </button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
              </div>
              <div id="list-page3-list" class="container tab-pane fade show SizeText @if(isset($FlagTab)) {{($FlagTab == 3) ? 'active' : '' }} @endif">
                <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ประเภท <span class="textHeader">(ยังไม่ระบุ)</span></h6>
                <button type="button" class="btn btn-sm bg-success SizeText Button" data-toggle="modal" data-target="#modal-default" data-link="{{ route('MasterLegis.create') }}?type={{1}}&dateSearch={{$dateSearch}}&FlagTab={{3}}" title="เพิ่มรายการของกลาง">
                  <i class="fas fa-plus"></i> เพิ่ม
                </button>
                  <table class="table table-hover SizeText" id="table33">
                    <thead>
                      <tr>
                        <!-- <th class="text-center">ลำดับ</th> -->
                        <th class="text-center">เลขที่สัญญา</th>
                        <th class="text-center">ชื่อ-สกุล</th>
                        <th class="text-center">ชื่อผู้ต้องหา</th>
                        <th class="text-center">ข้อหา</th>
                        <th class="text-center">บอกเลิกโดย</th>
                        <th class="text-center">แจ้งเตือน</th>
                        <th class="text-center" style="width: 70px"></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data3 as $key => $row)
                        <tr>
                          <!-- <td class="text-center">{{$key+1}}</td> -->
                          <td class="text-left">{{$row->Contract_legis}}</td>
                          <td class="text-left">{{$row->Name_legis}}</td>
                          <td class="text-left">{{($row->Suspect_legis != NULL?$row->Suspect_legis:'-')}}</td>
                          <td class="text-left">{{($row->Plaint_legis != NULL?$row->Plaint_legis:'-')}}</td>
                          <td class="text-center">{{($row->Terminate_legis != NULL?$row->Terminate_legis:'-')}}</td>
                          <td class="text-center">
                            @if($row->Typeexhibit_legis == 'ของกลาง')
                              @if($row->Dategetresult_legis != null)
                              <button type="button" class="btn btn-success btn-sm" title="จบงาน {{FormatDatethai($row->Dategetresult_legis)}}">
                                <i class="fa fa-check-circle prem"></i>
                              </button>
                              @elseif($row->Dateinvestigate_legis != null)
                                  @php
                                    $datecheck = date('Y-m-d');
                                    $Cldate = date_create($row->Dateinvestigate_legis);
                                    $nowCldate = date_create($datecheck);
                                    $ClDateDiff = date_diff($Cldate,$nowCldate);
                                    // $duration = $ClDateDiff->format("อีก %a วัน");
                                  @endphp
                                  @if($datecheck > $row->Dateinvestigate_legis)
                                    <button type="button" class="btn btn-warning btn-sm" title="เลยไต่สวนแล้ว">
                                      <i class="fa fa-exclamation-triangle prem"></i>
                                    </button>
                                  @elseif($ClDateDiff->days <= 7)
                                    <button type="button" class="btn btn-danger btn-sm prem" title="ไต่สวนอีก {{$ClDateDiff->days}} วัน">
                                      <i class="fa fa-exclamation-triangle prem"></i>
                                    </button>
                                  @endif
                              @elseif($row->Datesendword_legis != null)
                                  <button type="button" class="btn btn-warning btn-sm" title="ยื่นคำร้อง">
                                    <i class="fa fa-exclamation-triangle prem"></i>
                                  </button>
                              @elseif($row->Datepreparedoc_legis != null)
                                  <button type="button" class="btn btn-primary btn-sm" title="เตรียมเอกสาร">
                                    <i class="fa fa-exclamation-triangle prem"></i>
                                  </button>
                              @elseif($row->Datecheckexhibit_legis != null)
                                  <button type="button" class="btn btn-primary btn-sm" title="เช็คสำนวน">
                                    <i class="fa fa-exclamation-triangle prem"></i>
                                  </button>
                              @elseif($row->Dategiveword_legis != null)
                                  <button type="button" class="btn btn-primary btn-sm" title="สอบคำให้การ">
                                    <i class="fa fa-exclamation-triangle prem"></i>
                                  </button>
                              @else
                                <button type="button" class="btn btn-gray btn-sm" title="ยังไม่มีแจ้งเตือน">
                                  <i class="fa fa-question-circle prem"></i>
                                </button>
                              @endif
                            @endif
                            @if($row->Typeexhibit_legis == 'ยึดตามมาตราการ(ปปส.)')
                              @if($row->Dategetresult_legis != null)
                              <button type="button" class="btn btn-success btn-sm" title="จบงาน {{FormatDatethai($row->Dategetresult_legis)}}">
                                <i class="fa fa-check-circle prem"></i> 
                              </button>
                              @elseif($row->Datesenddetail_legis != null)
                                <button type="button" class="btn btn-danger btn-sm" title="ส่งรายละเอียด">
                                  <i class="fa fa-exclamation-triangle prem"></i>
                                </button>
                              @else
                                  <button type="button" class="btn btn-gray btn-sm" title="ยังไม่มีแจ้งเตือน">
                                    <i class="fa fa-question-circle prem"></i>
                                  </button>
                                @endif
                            @endif
                            @if($row->Typeexhibit_legis == '')
                              <button type="button" class="btn btn-gray btn-sm" title="ยังไม่มีแจ้งเตือน">
                                <i class="fa fa-question-circle prem"></i>
                              </button>
                            @endif
                          </td>
                          <td class="text-right">
                            <a data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterLegis.edit',[$row->id]) }}?type={{8}}&dateSearch={{$dateSearch}}&FlagTab={{3}}" class="btn btn-warning btn-sm hover-up" title="แก้ไขรายการ">
                              <i class="far fa-edit"></i>
                            </a>
                            <form method="post" class="delete_form" action="{{ route('MasterLegis.destroy',[$row->id]) }}" style="display:inline;">
                            {{csrf_field()}}
                              <input type="hidden" name="type" value="3" />
                              <input type="hidden" name="FlagTab" value="3" />
                              <input type="hidden" name="_method" value="DELETE" />
                              <button type="submit" data-name="{{ $row->Contract_legis }}" class="delete-modal btn btn-danger btn-sm AlertForm hover-up" title="ลบรายการ">
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

  <div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
        </div>
      </div>
    </div>
  </div>

@endsection

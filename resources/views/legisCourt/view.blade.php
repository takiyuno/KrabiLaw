@extends('layouts.master')
@section('title','ลูกหนี้ชั้นศาล')
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
              @if($type == 4)
                <h5>ลูกหนี้ชั้นศาล <small class="textHeader">(Court Debtors)</small></h5>
              @elseif($type == 5)
                <h5>ลูกหนี้ชั้นบังคับคดี <small class="textHeader">(Courtcase Debtors)</small></h5>
              @endif
            </div>
          </div>
          <div class="col-4">
            <form method="get" action="#">
              <div class="card-tools d-inline float-right btn-page">
                <div class="input-group form-inline">
                  <span class="text-right mr-sm-1">วันที่ : </span>
                  <input type="text" id="dateSearch" name="dateSearch" value="{{ ($dateSearch != '') ?$dateSearch: '' }}" class="form-control form-control-sm textSize" placeholder="วันที - ถึงวันที่" disabled>
                  <span class="input-group-append">
                    <button type="submit" class="btn btn-info btn-sm button-id mr-sm-1" disabled>
                      <i class="fas fa-search"></i>
                    </button>
                  </span>
                  <button class="btn btn-info btn-sm hover-up" data-toggle="dropdown">
                    <i class="fas fa-print"></i>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    @if($type == 4)
                      <li><a target="_blank" class="dropdown-item SizeText" href="{{ route('Legislation.Report') }}?type={{3}}">รายงาน ลูกหนี้ชั้นศาล</a></li>
                    @elseif($type == 5)
                      <li><a target="_blank" class="dropdown-item SizeText" href="{{ route('Legislation.Report') }}?type={{4}}">รายงาน ลูกหนี้ชั้นบังคับคดี</a></li>
                    @endif
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
                @if($type == 4)
                  ลูกหนี้ทั้งหมด (<b><span class="text-red">{{count($data1)+count($data2)+count($data3)+count($data4)+count($data5)+count($data6)}}</span></b> ราย)
                @elseif($type == 5)
                  ลูกหนี้ทั้งหมด (<b><span class="text-red">{{count($data1)+count($data2)+count($data3)+count($data4)+count($data5)}}</span></b> ราย)
                @endif
              </span>
              <div class="author-card-profile">
                <div class="author-card-avatar">
              </div>
            </div>
          </div>
            <div class="wizard">
            @if($type == 4)
              <nav class="list-group list-group-flush" role="tablist">
                <a class="list-group-item hover-up @if(isset($FlagTab)) {{($FlagTab == 1) ? 'active' : '' }} @else active @endif" id="vert-tabs-01-tab" data-toggle="tab" href="#list-page1-list">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <i class="fas fa-user-tag mr-1 text-muted"></i>
                      <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ ชั้นฟ้อง</div>
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
                      <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ ชั้นสืบพยาน</div>
                    </div>
                      @if(count($data2) != 0)
                        <span class="badge bg-danger">{{count($data2)}}</span>
                      @endif
                  </div>
                </a>
                <a class="list-group-item hover-up @if(isset($FlagTab)) {{($FlagTab == 3) ? 'active' : '' }} @endif" id="vert-tabs-03-tab" data-toggle="tab" href="#list-page3-list">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <i class="fas fa-user-tag mr-1 text-muted"></i>
                      <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ ชั้นส่งคำบังคับ</div>
                    </div>
                      @if(count($data3) != 0)
                        <span class="badge bg-danger">{{count($data3)}}</span>
                      @endif
                  </div>
                </a>
                <a class="list-group-item hover-up @if(isset($FlagTab)) {{($FlagTab == 4) ? 'active' : '' }} @endif" id="vert-tabs-04-tab" data-toggle="tab" href="#list-page4-list">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <i class="fas fa-user-tag mr-1 text-muted"></i>
                      <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ ชั้นตรวจผลหมาย</div>
                    </div>
                      @if(count($data4) != 0)
                        <span class="badge bg-danger">{{count($data4)}}</span>
                      @endif
                  </div>
                </a>
                <a class="list-group-item hover-up @if(isset($FlagTab)) {{($FlagTab == 5) ? 'active' : '' }} @endif" id="vert-tabs-05-tab" data-toggle="tab" href="#list-page5-list">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <i class="fas fa-user-tag mr-1 text-muted"></i>
                      <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ ชั้นตั้งเจ้าพนักงาน</div>
                    </div>
                      @if(count($data5) != 0)
                        <span class="badge bg-danger">{{count($data5)}}</span>
                      @endif
                  </div>
                </a>
                <a class="list-group-item hover-up @if(isset($FlagTab)) {{($FlagTab == 6) ? 'active' : '' }} @endif" id="vert-tabs-06-tab" data-toggle="tab" href="#list-page6-list">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <i class="fas fa-user-tag mr-1 text-muted"></i>
                      <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ ชั้นตรวจผลหมายตั้ง</div>
                    </div>
                      @if(count($data6) != 0)
                        <span class="badge bg-danger">{{count($data6)}}</span>
                      @endif              
                  </div>
                </a>
              </nav>
            @elseif($type == 5)
              <nav class="list-group list-group-flush" role="tablist">
                <a class="list-group-item hover-up @if(isset($FlagTab)) {{($FlagTab == 1) ? 'active' : '' }} @else active @endif" id="vert-tabs-01-tab" data-toggle="tab" href="#list-page1-list">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <i class="fas fa-user-tag mr-1 text-muted"></i>
                      <div class="d-inline-block font-weight-medium text-uppercase">คัดหนังสือรับรองคดีถึงที่สุด</div>
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
                      <div class="d-inline-block font-weight-medium text-uppercase">สืบทรัพย์(บังคับคดี)</div>
                    </div>
                      @if(count($data2) != 0)
                        <span class="badge bg-danger">{{count($data2)}}</span>
                      @endif
                  </div>
                </a>
                <a class="list-group-item hover-up @if(isset($FlagTab)) {{($FlagTab == 3) ? 'active' : '' }} @endif" id="vert-tabs-03-tab" data-toggle="tab" href="#list-page3-list">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <i class="fas fa-user-tag mr-1 text-muted"></i>
                      <div class="d-inline-block font-weight-medium text-uppercase">คัดโฉนด/ถ่ายภาพ/ประเมิณ</div>
                    </div>
                      @if(count($data3) != 0)
                        <span class="badge bg-danger">{{count($data3)}}</span>
                      @endif
                  </div>
                </a>
                <a class="list-group-item hover-up @if(isset($FlagTab)) {{($FlagTab == 4) ? 'active' : '' }} @endif" id="vert-tabs-04-tab" data-toggle="tab" href="#list-page4-list">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <i class="fas fa-user-tag mr-1 text-muted"></i>
                      <div class="d-inline-block font-weight-medium text-uppercase">ตั้งเรื่องยึดทรัพย์</div>
                    </div>
                      @if(count($data4) != 0)
                        <span class="badge bg-danger">{{count($data4)}}</span>
                      @endif
                  </div>
                </a>
                <a class="list-group-item hover-up @if(isset($FlagTab)) {{($FlagTab == 5) ? 'active' : '' }} @endif" id="vert-tabs-05-tab" data-toggle="tab" href="#list-page5-list">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <i class="fas fa-user-tag mr-1 text-muted"></i>
                      <div class="d-inline-block font-weight-medium text-uppercase">ประกาศขายทอดตลาด</div>
                    </div>
                      @if(count($data5) != 0)
                        <span class="badge bg-danger">{{count($data5)}}</span>
                      @endif
                  </div>
                </a>
              </nav>
            @endif
            </div>
          </div>
        </div>
        <div class="col-lg-9">
          @if($type == 4)
            <div class="tab-content">
              <div id="list-page1-list" class="container tab-pane SizeText @if(isset($FlagTab)) {{($FlagTab == 1) ? 'active' : '' }} @else active @endif">
                <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ลูกหนี้  <span class="textHeader">(ชั้นฟ้อง)</span></h6>
                  <table class="table table-hover SizeText" id="table11">
                    <thead>
                      <tr>
                        <th class="text-center">เลขที่สัญญา</th>
                        <th class="text-center">ชื่อ-สกุล</th>
                        <th class="text-center">วันฟ้อง</th>
                        <th class="text-center">แจ้งเตือน</th>
                        <th class="text-center" style="width: 70px"></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data1 as $key => $row)
                        @php
                          if($row->legiscourt->fillingdate_court >= date('Y-m-d')) {
                            $DateDue = date_create($row->legiscourt->fillingdate_court);
                            $NowDate = date_create(date('Y-m-d'));
                            $DateDiff = date_diff($NowDate,$DateDue);
                            if($DateDiff->d <= 7){
                              $Tag = 'Active';
                              $DateShow = $DateDiff->format("%a วัน");
                            }else{
                              $Tag = NULL;
                              $DateShow = 'รอดำเนินการ';
                            }
                          }else{
                            $Tag = 'Closest';
                            $DateShow = 'เลยกำหนดการ';
                          }
                        @endphp
                        <tr>
                          <td class="text-left"> 
                            @if($row->legisCompromise != NULL)
                              <span class="text-info">{{$row->Contract_legis}}</span>
                              <a href="{{ route('MasterCompro.edit',[$row->id]) }}?type={{1}}" class="float-right btn-info btn-sm hover-up textSize" data-toggle="tooltip" data-placement="top" title="อยู่ระหว่างประนอมหนี้">
                                <i class="fas fa-hand-holding-usd prem"></i>
                              </a>
                            @else
                              {{$row->Contract_legis}}
                            @endif
                          </td>
                          <td class="text-left"> {{$row->Name_legis}}</td>
                          <td class="text-center"> {{ ($row->legiscourt->fillingdate_court != NULL) ?formatDateThai($row->legiscourt->fillingdate_court): 'ไม่พบข้อมูล' }}</td>
                          <td class="text-left"> 
                            @if($Tag == 'Active')
                              <span class="btn-outline-warning btn-sm hover-up mr-2">
                                <i class="far fa-calendar-alt prem"></i>
                              </span>
                              <span class="textSize text-warning">กำหนดการอีก {{$DateShow}}</span>
                            @elseif($Tag == 'Closest')
                              <span class="btn-outline-danger btn-sm hover-up mr-2">
                                <i class="fas fa-exclamation-circle prem"></i>
                              </span>
                              <span class="textSize text-red">{{$DateShow}}</span>
                            @else
                              <span class="btn-outline-success btn-sm hover-up textSize mr-2">
                                <i class="fas fa-history prem"></i>
                              </span>
                              <span class="textSize text-green">{{$DateShow}}</span>
                            @endif
                          </td>
                          <td class="text-right">
                            <a href="{{ route('MasterLegis.edit',[$row->id]) }}?type={{4}}&dateSearch={{$dateSearch}}&FlagPage={{4}}&FlagTab={{1}}" class="btn btn-warning btn-sm hover-up hover-up" data-toggle="tooltip" data-placement="top" title="แก้ไขรายการ">
                              <i class="far fa-edit"></i>
                            </a>
                            <form method="post" class="delete_form" action="{{ route('MasterLegis.destroy',[$row->id]) }}" style="display:inline;">
                            {{csrf_field()}}
                              <input type="hidden" name="type" value="1" />
                              <input type="hidden" name="_method" value="DELETE" />
                              <button type="submit" data-name="{{ $row->Contract_legis }}" class="delete-modal btn btn-danger btn-sm AlertForm hover-up" data-toggle="tooltip" data-placement="top" title="ลบรายการ">
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
                <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ลูกหนี้ <span class="textHeader">(ชั้นสืบพยาน)</span></h6>
                  <table class="table table-hover SizeText" id="table22">
                    <thead>
                      <tr>
                        <th class="text-center">เลขที่สัญญา</th>
                        <th class="text-center">ชื่อ-สกุล</th>
                        <th class="text-center">วันสืบพยาน</th>
                        <th class="text-center">แจ้งเตือน</th>
                        <th class="text-center" style="width: 70px"></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data2 as $key => $row)
                        @php
                          $SetDate = NULL;
                          if($row->legiscourt->fuzzy_court != NULL) {
                            $SetDate = $row->legiscourt->fuzzy_court;
                          }else{
                            $SetDate = $row->legiscourt->examiday_court;
                          }
                          if($SetDate >= date('Y-m-d')) {
                            $DateDue = date_create($SetDate);
                            $NowDate = date_create(date('Y-m-d'));
                            $DateDiff = date_diff($NowDate,$DateDue);
                            if($DateDiff->d <= 7){
                              $Tag = 'Active';
                              $DateShow = $DateDiff->format("%a วัน");
                            }else{
                              $Tag = NULL;
                              $DateShow = 'รอดำเนินการ';
                            }
                          }else{
                            $Tag = 'Closest';
                            $DateShow = 'เลยกำหนดการ';
                          }
                        @endphp
                        <tr>
                          <td class="text-left"> 
                            @if($row->legisCompromise != NULL)
                              <span class="text-info">{{$row->Contract_legis}}</span>
                              <a href="{{ route('MasterCompro.edit',[$row->id]) }}?type={{1}}" class="float-right btn-info btn-sm hover-up textSize" data-toggle="tooltip" data-placement="top" title="อยู่ระหว่างประนอมหนี้">
                                <i class="fas fa-hand-holding-usd prem"></i>
                              </a>
                            @else
                              {{$row->Contract_legis}}
                            @endif
                          </td>
                          <td class="text-left"> {{$row->Name_legis}} </td>
                          <td class="text-center">{{($SetDate !== NULL) ? formatDateThai($SetDate) : '-' }}</td>
                          <td class="text-left"> 
                            @if($Tag == 'Active')
                              <span class="btn-outline-warning btn-sm hover-up mr-2">
                                <i class="far fa-calendar-alt prem"></i>
                              </span>
                              <span class="textSize text-warning">กำหนดการอีก {{$DateShow}}</span>
                            @elseif($Tag == 'Closest')
                              @if($SetDate != NULL)
                                <span class="btn-outline-danger btn-sm hover-up mr-2">
                                  <i class="fas fa-exclamation-circle prem"></i>
                                </span>
                                <span class="textSize text-red">{{$DateShow}}</span>
                              @else
                                <i class="text-secondary">ไม่พบข้อมูล</i>
                              @endif
                            @else
                              <span class="btn-outline-success btn-sm hover-up textSize mr-2">
                                <i class="fas fa-history prem"></i>
                              </span>
                              <span class="textSize text-green">{{$DateShow}}</span>
                            @endif
                          </td>
                          <td class="text-right">
                            <a href="{{ route('MasterLegis.edit',[$row->id]) }}?type={{4}}&dateSearch={{$dateSearch}}&FlagPage={{4}}&FlagTab={{2}}" class="btn btn-warning btn-sm hover-up hover-up" data-toggle="tooltip" data-placement="top" title="แก้ไขรายการ">
                              <i class="far fa-edit"></i>
                            </a>
                            <form method="post" class="delete_form" action="{{ route('MasterLegis.destroy',[$row->id]) }}" style="display:inline;">
                            {{csrf_field()}}
                              <input type="hidden" name="type" value="1" />
                              <input type="hidden" name="_method" value="DELETE" />
                              <button type="submit"  data-name="{{ $row->Contract_legis }}" class="delete-modal btn btn-danger btn-sm AlertForm hover-up" data-toggle="tooltip" data-placement="top" title="ลบรายการ">
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
                <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ลูกหนี้ <span class="textHeader">(ชั้นส่งคำบังคับ)</span></h6>
                  <table class="table table-hover SizeText" id="table33">
                    <thead>
                      <tr>
                        <th class="text-center">เลขที่สัญญา</th>
                        <th class="text-center">ชื่อ-สกุล</th>
                        <th class="text-center">วันส่งคำบังคับ</th>
                        <th class="text-center">แจ้งเตือน</th>
                        <th class="text-center" style="width: 70px"></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data3 as $key => $row)
                        @php
                          $SetDate = NULL;
                          if($row->legiscourt->ordersend_court != NULL) {
                            $SetDate = $row->legiscourt->ordersend_court;
                          }else{
                            $SetDate = $row->legiscourt->orderday_court;
                          }

                          if($SetDate >= date('Y-m-d')) {
                            $DateDue = date_create($SetDate);
                            $NowDate = date_create(date('Y-m-d'));
                            $DateDiff = date_diff($NowDate,$DateDue);
                            if($DateDiff->d <= 7){
                              $Tag = 'Active';
                              $DateShow = $DateDiff->format("%a วัน");
                            }else{
                              $Tag = NULL;
                              $DateShow = 'รอดำเนินการ';
                            }
                          }else{
                            $Tag = 'Closest';
                            $DateShow = 'เลยกำหนดการ';
                          }
                        @endphp
                        <tr>
                          <td class="text-left">
                            @if($row->legisCompromise != NULL)
                              <span class="text-info">{{$row->Contract_legis}}</span>
                              <a href="{{ route('MasterCompro.edit',[$row->id]) }}?type={{1}}" class="float-right btn-info btn-sm hover-up textSize" data-toggle="tooltip" data-placement="top" title="อยู่ระหว่างประนอมหนี้">
                                <i class="fas fa-hand-holding-usd prem"></i>
                              </a>
                            @else
                              {{$row->Contract_legis}}
                            @endif
                          </td>
                          <td class="text-left"> {{$row->Name_legis}} </td>
                          <td class="text-center">
                            @if($SetDate != NULL)
                              {{ formatDateThai($SetDate) }}
                            @else
                              <i class="text-secondary">ไม่พบข้อมูล</i>
                            @endif
                          </td>
                          <td class="text-left"> 
                            @if($Tag == 'Active')
                              <span class="btn-outline-warning btn-sm hover-up mr-2">
                                <i class="far fa-calendar-alt prem"></i>
                              </span>
                              <span class="textSize text-warning">กำหนดการอีก {{$DateShow}}</span>
                            @elseif($Tag == 'Closest')
                              @if($SetDate != NULL)
                                <span class="btn-outline-danger btn-sm hover-up mr-2">
                                  <i class="fas fa-exclamation-circle prem"></i>
                                </span>
                                <span class="textSize text-red">{{$DateShow}}</span>
                              @else
                                <i class="text-secondary">ไม่พบข้อมูล</i>
                              @endif
                            @else
                              <span class="btn-outline-success btn-sm hover-up textSize mr-2">
                                <i class="fas fa-history prem"></i>
                              </span>
                              <span class="textSize text-green">{{$DateShow}}</span>
                            @endif
                          </td>
                          <td class="text-right">
                            <a href="{{ route('MasterLegis.edit',[$row->id]) }}?type={{4}}&dateSearch={{$dateSearch}}&FlagPage={{4}}&FlagTab={{3}}" class="btn btn-warning btn-sm hover-up hover-up" data-toggle="tooltip" data-placement="top" title="แก้ไขรายการ">
                              <i class="far fa-edit"></i>
                            </a>
                            <form method="post" class="delete_form" action="{{ route('MasterLegis.destroy',[$row->id]) }}" style="display:inline;">
                            {{csrf_field()}}
                              <input type="hidden" name="type" value="1" />
                              <input type="hidden" name="_method" value="DELETE" />
                              <button type="submit"  data-name="{{ $row->Contract_legis }}" class="delete-modal btn btn-danger btn-sm AlertForm hover-up" data-toggle="tooltip" data-placement="top" title="ลบรายการ">
                                <i class="far fa-trash-alt"></i>
                              </button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
              </div>
              <div id="list-page4-list" class="container tab-pane fade show SizeText @if(isset($FlagTab)) {{($FlagTab == 4) ? 'active' : '' }} @endif">
                <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ลูกหนี้ <span class="textHeader">(ชั้นตรวจผลหมาย)</span></h6>
                  <table class="table table-hover SizeText" id="table44">
                    <thead>
                      <tr>
                        <th class="text-center">เลขที่สัญญา</th>
                        <th class="text-center">ชื่อ-สกุล</th>
                        <th class="text-center">วันตรวจผล</th>
                        <th class="text-center">แจ้งเตือน</th>
                        <th class="text-center" style="width: 70px"></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data4 as $key => $row)
                        @php
                          $SetDate = NULL;
                          if($row->legiscourt->checksend_court != NULL) {
                            $SetDate = $row->legiscourt->checksend_court;
                          }else{
                            $SetDate = $row->legiscourt->checkday_court;
                          }

                          if($SetDate >= date('Y-m-d')) {
                            $DateDue = date_create($SetDate);
                            $NowDate = date_create(date('Y-m-d'));
                            $DateDiff = date_diff($NowDate,$DateDue);
                            if($DateDiff->d <= 7){
                              $Tag = 'Active';
                              $DateShow = $DateDiff->format("%a วัน");
                            }else{
                              $Tag = NULL;
                              $DateShow = 'รอดำเนินการ';
                            }
                          }else{
                            $Tag = 'Closest';
                            $DateShow = 'เลยกำหนดการ';
                          }
                        @endphp
                        <tr>
                          <td class="text-left">
                            @if($row->legisCompromise != NULL)
                              <span class="text-info">{{$row->Contract_legis}}</span>
                              <a href="{{ route('MasterCompro.edit',[$row->id]) }}?type={{1}}" class="float-right btn-info btn-sm hover-up textSize" data-toggle="tooltip" data-placement="top" title="อยู่ระหว่างประนอมหนี้">
                                <i class="fas fa-hand-holding-usd prem"></i>
                              </a>
                            @else
                              {{$row->Contract_legis}}
                            @endif
                          </td>
                          <td class="text-left"> {{$row->Name_legis}} </td>
                          <td class="text-center">
                            @if($SetDate != NULL)
                              {{ formatDateThai($SetDate) }}
                            @else
                              <i class="text-secondary">ไม่พบข้อมูล</i>
                            @endif
                          </td>
                          <td class="text-left"> 
                            @if($Tag == 'Active')
                              <span class="btn-outline-warning btn-sm hover-up mr-2">
                                <i class="far fa-calendar-alt prem"></i>
                              </span>
                              <span class="textSize text-warning">กำหนดการอีก {{$DateShow}}</span>
                            @elseif($Tag == 'Closest')
                              @if($SetDate != NULL)
                                <span class="btn-outline-danger btn-sm hover-up mr-2">
                                  <i class="fas fa-exclamation-circle prem"></i>
                                </span>
                                <span class="textSize text-red">{{$DateShow}}</span>
                              @else
                                <i class="text-secondary">ไม่พบข้อมูล</i>
                              @endif
                            @else
                              <span class="btn-outline-success btn-sm hover-up textSize mr-2">
                                <i class="fas fa-history prem"></i>
                              </span>
                              <span class="textSize text-green">{{$DateShow}}</span>
                            @endif
                          </td>
                          <td class="text-right">
                            <a href="{{ route('MasterLegis.edit',[$row->id]) }}?type={{4}}&dateSearch={{$dateSearch}}&FlagPage={{4}}&FlagTab={{4}}" class="btn btn-warning btn-sm hover-up hover-up" data-toggle="tooltip" data-placement="top" title="แก้ไขรายการ">
                              <i class="far fa-edit"></i>
                            </a>
                            <form method="post" class="delete_form" action="{{ route('MasterLegis.destroy',[$row->id]) }}" style="display:inline;">
                            {{csrf_field()}}
                              <input type="hidden" name="type" value="1" />
                              <input type="hidden" name="_method" value="DELETE" />
                              <button type="submit"  data-name="{{ $row->Contract_legis }}" class="delete-modal btn btn-danger btn-sm AlertForm hover-up" data-toggle="tooltip" data-placement="top"  title="ลบรายการ">
                                <i class="far fa-trash-alt"></i>
                              </button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
              </div>
              <div id="list-page5-list" class="container tab-pane fade show SizeText @if(isset($FlagTab)) {{($FlagTab == 5) ? 'active' : '' }} @endif">
                <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ลูกหนี้ <span class="textHeader">(ชั้นตั้งเจ้าพนักงาน)</span></h6>
                  <table class="table table-hover SizeText" id="table55">
                    <thead>
                      <tr>
                        <th class="text-center">เลขที่สัญญา</th>
                        <th class="text-center">ชื่อ-สกุล</th>
                        <th class="text-center">วัน ต.พนักงาน</th>
                        <th class="text-center">แจ้งเตือน</th>
                        <th class="text-center" style="width: 70px"></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data5 as $key => $row)
                        @php
                          $SetDate = NULL;
                          if($row->legiscourt->sendoffice_court != NULL) {
                            $SetDate = @$row->legiscourt->sendoffice_court;
                          }else{
                            $SetDate = @$row->legiscourt->setoffice_court;
                          }

                          if($SetDate >= date('Y-m-d')) {
                            $DateDue = date_create($SetDate);
                            $NowDate = date_create(date('Y-m-d'));
                            $DateDiff = date_diff($NowDate,$DateDue);
                            if($DateDiff->d <= 7){
                              $Tag = 'Active';
                              $DateShow = $DateDiff->format("%a วัน");
                            }else{
                              $Tag = NULL;
                              $DateShow = 'รอดำเนินการ';
                            }
                          }else{
                            $Tag = 'Closest';
                            $DateShow = 'เลยกำหนดการ';
                          }
                        @endphp
                        <tr>
                          <td class="text-left">
                            @if($row->legisCompromise != NULL)
                              <span class="text-info">{{$row->Contract_legis}}</span>
                              <a href="{{ route('MasterCompro.edit',[$row->id]) }}?type={{1}}" class="float-right btn-info btn-sm hover-up textSize" data-toggle="tooltip" data-placement="top" title="อยู่ระหว่างประนอมหนี้">
                                <i class="fas fa-hand-holding-usd prem"></i>
                              </a>
                            @else
                              {{$row->Contract_legis}}
                            @endif
                          </td>
                          <td class="text-left"> {{$row->Name_legis}} </td>
                          <td class="text-center">                         
                            @if($SetDate != NULL)
                              {{ formatDateThai($SetDate) }}
                            @else
                              <i class="text-secondary">ไม่พบข้อมูล</i>
                            @endif
                          </td>
                          <td class="text-left"> 
                            @if($Tag == 'Active')
                              <span class="btn-outline-warning btn-sm hover-up mr-2">
                                <i class="far fa-calendar-alt prem"></i>
                              </span>
                              <span class="textSize text-warning">กำหนดการอีก {{$DateShow}}</span>
                            @elseif($Tag == 'Closest')
                              @if($SetDate != NULL)
                                <span class="btn-outline-danger btn-sm hover-up mr-2">
                                  <i class="fas fa-exclamation-circle prem"></i>
                                </span>
                                <span class="textSize text-red">{{$DateShow}}</span>
                              @else
                                <i class="text-secondary">ไม่พบข้อมูล</i>
                              @endif
                            @else
                              <span class="btn-outline-success btn-sm hover-up textSize mr-2">
                                <i class="fas fa-history prem"></i>
                              </span>
                              <span class="textSize text-green">{{$DateShow}}</span>
                            @endif
                          </td>
                          <td class="text-right">
                            <a href="{{ route('MasterLegis.edit',[$row->id]) }}?type={{4}}&dateSearch={{$dateSearch}}&FlagPage={{4}}&FlagTab={{5}}" class="btn btn-warning btn-sm hover-up hover-up" data-toggle="tooltip" data-placement="top"  title="แก้ไขรายการ">
                              <i class="far fa-edit"></i>
                            </a>
                            <form method="post" class="delete_form" action="{{ route('MasterLegis.destroy',[$row->id]) }}" style="display:inline;">
                            {{csrf_field()}}
                              <input type="hidden" name="type" value="1" />
                              <input type="hidden" name="_method" value="DELETE" />
                              <button type="submit"  data-name="{{ $row->Contract_legis }}" class="delete-modal btn btn-danger btn-sm AlertForm hover-up" data-toggle="tooltip" data-placement="top" title="ลบรายการ">
                                <i class="far fa-trash-alt"></i>
                              </button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
              </div>
              <div id="list-page6-list" class="container tab-pane fade show SizeText @if(isset($FlagTab)) {{($FlagTab == 6) ? 'active' : '' }} @endif">
                <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ลูกหนี้  <span class="textHeader">(ชั้นตรวจผลหมายตั้ง)</span></h6>
                  <table class="table table-hover SizeText" id="table66">
                    <thead>
                      <tr>
                        <th class="text-center">เลขที่สัญญา</th>
                        <th class="text-center">ชื่อ-สกุล</th>
                        <th class="text-center">วัน ต.ผลหมายตั้ง</th>
                        <th class="text-center">แจ้งเตือน</th>
                        <th class="text-center" style="width: 70px"></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data6 as $key => $row)
                        @php
                          $SetDate = NULL;
                          if($row->legiscourt->sendcheckresults_court != NULL) {
                            $SetDate = $row->legiscourt->sendcheckresults_court;
                          }else{
                            $SetDate = $row->legiscourt->checkresults_court;
                          }

                          if($SetDate >= date('Y-m-d')) {
                            $DateDue = date_create($SetDate);
                            $NowDate = date_create(date('Y-m-d'));
                            $DateDiff = date_diff($NowDate,$DateDue);
                            if($DateDiff->d <= 7){
                              $Tag = 'Active';
                              $DateShow = $DateDiff->format("%a วัน");
                            }else{
                              $Tag = NULL;
                              $DateShow = 'รอดำเนินการ';
                            }
                          }else{
                            $Tag = 'Closest';
                            $DateShow = 'เลยกำหนดการ';
                          }
                        @endphp
                        <tr>
                          <td class="text-left">
                            @if($row->legisCompromise != NULL)
                              <span class="text-info">{{$row->Contract_legis}}</span>
                              <a href="{{ route('MasterCompro.edit',[$row->id]) }}?type={{1}}" class="float-right btn-info btn-sm hover-up textSize" data-toggle="tooltip" data-placement="top" title="อยู่ระหว่างประนอมหนี้">
                                <i class="fas fa-hand-holding-usd prem"></i>
                              </a>
                            @else
                              {{$row->Contract_legis}}
                            @endif
                          </td>
                          <td class="text-left"> {{$row->Name_legis}} </td>
                          <td class="text-center"> 
                            @if($SetDate != NULL)
                              {{ formatDateThai($SetDate) }}
                            @else
                              <i class="text-secondary">ไม่พบข้อมูล</i>
                            @endif
                          </td>
                          <td class="text-left"> 
                            @if($Tag == 'Active')
                              <span class="btn-outline-warning btn-sm hover-up mr-2">
                                <i class="far fa-calendar-alt prem"></i>
                              </span>
                              <span class="textSize text-warning">กำหนดการอีก {{$DateShow}}</span>
                            @elseif($Tag == 'Closest')
                              @if($SetDate != NULL)
                                <span class="btn-outline-danger btn-sm hover-up mr-2">
                                  <i class="fas fa-exclamation-circle prem"></i>
                                </span>
                                <span class="textSize text-red">{{$DateShow}}</span>
                              @else
                                <i class="text-secondary">ไม่พบข้อมูล</i>
                              @endif
                            @else
                              <span class="btn-outline-success btn-sm hover-up textSize mr-2">
                                <i class="fas fa-history prem"></i>
                              </span>
                              <span class="textSize text-green">{{$DateShow}}</span>
                            @endif
                          </td>
                          <td class="text-right">
                            <a href="{{ route('MasterLegis.edit',[$row->id]) }}?type={{4}}&dateSearch={{$dateSearch}}&FlagPage={{4}}&FlagTab={{6}}" class="btn btn-warning btn-sm hover-up" data-toggle="tooltip" data-placement="top" title="แก้ไขรายการ">
                              <i class="far fa-edit"></i>
                            </a>
                            <form method="post" class="delete_form" action="{{ route('MasterLegis.destroy',[$row->id]) }}" style="display:inline;">
                            {{csrf_field()}}
                              <input type="hidden" name="type" value="1" />
                              <input type="hidden" name="_method" value="DELETE" />
                              <button type="submit"  data-name="{{ $row->Contract_legis }}" class="delete-modal btn btn-danger btn-sm AlertForm" data-toggle="tooltip" data-placement="top" title="ลบรายการ">
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
          @elseif($type == 5)
            <div class="tab-content">
              <div id="list-page1-list" class="container tab-pane SizeText @if(isset($FlagTab)) {{($FlagTab == 1) ? 'active' : '' }} @else active @endif">
                <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ลูกหนี้  <span class="textHeader">(คัดหนังสือรับรองคดีถึงที่สุด)</span></h6>
                  <table class="table table-hover SizeText" id="table11">
                    <thead>
                      <tr>
                        <th class="text-center">เลขที่สัญญา</th>
                        <th class="text-center">ชื่อ-สกุล</th>
                        <th class="text-center">วันคัดหนังสือรองรับ</th>
                        <th class="text-center">แจ้งเตือน</th>
                        <th class="text-center" style="width: 70px"></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data1 as $key => $row)
                        @php
                          $SetDate = NULL;
                          if(@$row->legiscourtCase->dateCertificate_case >= date('Y-m-d')) {
                            $DateDue = date_create(@$row->legiscourtCase->dateCertificate_case);
                            $NowDate = date_create(date('Y-m-d'));
                            $DateDiff = date_diff($NowDate,$DateDue);
                            if($DateDiff->d <= 7){
                              $Tag = 'Active';
                              $DateShow = $DateDiff->format("%a วัน");
                            }else{
                              $Tag = NULL;
                              $DateShow = 'รอดำเนินการ';
                            }
                          }
                          else if(@$row->legiscourtCase->dateCertificate_case == NULL){
                            $Tag = 'Unknow';
                            $DateShow = 'ไม่พบข้อมูล';
                          }
                          else{
                            $Tag = 'Closest';
                            $DateShow = 'เลยกำหนดการ';
                          }
                        @endphp
                        <tr>
                          <td class="text-left">
                            @if($row->legisCompromise != NULL)
                              <span class="text-info">{{$row->Contract_legis}}</span>
                              <a href="{{ route('MasterCompro.edit',[$row->id]) }}?type={{1}}" class="float-right btn-info btn-sm hover-up textSize" data-toggle="tooltip" data-placement="top" title="อยู่ระหว่างประนอมหนี้">
                                <i class="fas fa-hand-holding-usd prem"></i>
                              </a>
                            @else
                              {{$row->Contract_legis}}
                            @endif
                          </td>
                          <td class="text-left"> {{$row->Name_legis}} </td>
                          <td class="text-center"> {{ (@$row->legiscourtCase->dateCertificate_case != NULL) ?FormatDatethai(@$row->legiscourtCase->dateCertificate_case): 'ยังไม่ระบุวันที่' }}</td>
                          <td class="text-left"> 
                            @if($Tag == 'Active')
                              <span class="btn-outline-warning btn-sm hover-up mr-2">
                                <i class="far fa-calendar-alt prem"></i>
                              </span>
                              <span class="textSize text-warning">กำหนดการอีก {{$DateShow}}</span>
                            @elseif($Tag == 'Closest')
                              <span class="btn-outline-danger btn-sm hover-up mr-2">
                                <i class="fas fa-exclamation-circle prem"></i>
                              </span>
                              <span class="textSize text-red">{{$DateShow}}</span>
                            @elseif($Tag == 'Unknow')
                              <span class="btn-outline-danger btn-sm hover-up mr-2">
                                <i class="fas fa-exclamation-circle prem"></i>
                              </span>
                              <span class="textSize text-red">{{$DateShow}}</span>
                            @else
                              <span class="btn-outline-success btn-sm hover-up textSize mr-2">
                                <i class="fas fa-history prem"></i>
                              </span>
                              <span class="textSize text-green">{{$DateShow}}</span>
                            @endif
                          </td>
                          <td class="text-right">
                            <a href="{{ route('MasterLegis.edit',[$row->id]) }}?type={{5}}&dateSearch={{$dateSearch}}&FlagPage={{5}}&FlagTab={{1}}" class="btn btn-warning btn-sm hover-up" data-toggle="tooltip" data-placement="top" title="แก้ไขรายการ">
                              <i class="far fa-edit"></i>
                            </a>
                            <form method="post" class="delete_form" action="{{ route('MasterLegis.destroy',[$row->id]) }}" style="display:inline;">
                            {{csrf_field()}}
                              <input type="hidden" name="type" value="1" />
                              <input type="hidden" name="_method" value="DELETE" />
                              <button type="submit" data-name="{{ $row->Contract_legis }}" class="delete-modal btn btn-danger btn-sm AlertForm hover-up" data-toggle="tooltip" data-placement="top" title="ลบรายการ">
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
                <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ลูกหนี้ <span class="textHeader">(สืบทรัพย์(บังคับคดี))</span></h6>
                  <table class="table table-hover SizeText" id="table22">
                    <thead>
                      <tr>
                        <th class="text-center">เลขที่สัญญา</th>
                        <th class="text-center">ชื่อ-สกุล</th>
                        <th class="text-center">วันที่สืบทรัพย์</th>
                        <th class="text-center">แจ้งเตือน</th>
                        <th class="text-center" style="width: 70px"></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data2 as $key => $row)
                        @php
                          $SetDate = NULL;
                          if($row->Legisasset->sequester_asset != NULL && $row->Legisasset->NewpursueDate_asset == NULL){
                            $SetDate = $row->Legisasset->sequester_asset;
                          }
                          elseif($row->Legisasset->sequester_asset != NULL && $row->Legisasset->NewpursueDate_asset != NULL){
                            $SetDate = $row->Legisasset->NewpursueDate_asset;
                          }

                          if($SetDate >= date('Y-m-d')) {
                            $DateDue = date_create($SetDate);
                            $NowDate = date_create(date('Y-m-d'));
                            $DateDiff = date_diff($NowDate,$DateDue);
                            if($DateDiff->d <= 7){
                              $Tag = 'Active';
                              $DateShow = $DateDiff->format("%a วัน");
                            }else{
                              $Tag = NULL;
                              $DateShow = 'รอดำเนินการ';
                            }
                          }
                          else if(@$SetDate == NULL){
                            $Tag = 'Unknow';
                            $DateShow = 'ไม่พบข้อมูล';
                          }
                          else{
                            $Tag = 'Closest';
                            $DateShow = 'เลยกำหนดการ';
                          }
                        @endphp
                        <tr>
                          <td class="text-center">
                            @if($row->legisCompromise != NULL)
                              <span class="text-info">{{$row->Contract_legis}}</span>
                              <a href="{{ route('MasterCompro.edit',[$row->id]) }}?type={{1}}" class="float-right btn-info btn-sm hover-up textSize" data-toggle="tooltip" data-placement="top" title="อยู่ระหว่างประนอมหนี้">
                                <i class="fas fa-hand-holding-usd prem"></i>
                              </a>
                            @else
                              {{$row->Contract_legis}}
                            @endif
                          </td>
                          <td class="text-left"> {{$row->Name_legis}} </td>
                          <td class="text-center"> {{ ($SetDate != NULL) ?FormatDatethai($SetDate): 'ยังไม่ระบุวันที่' }} </td>
                          <td class="text-left">
                            @if($Tag == 'Active')
                              <span class="btn-outline-warning btn-sm hover-up mr-2">
                                <i class="far fa-calendar-alt prem"></i>
                              </span>
                              <span class="textSize text-warning">กำหนดการอีก {{$DateShow}}</span>
                            @elseif($Tag == 'Closest')
                              @if($SetDate != NULL)
                                <span class="btn-outline-danger btn-sm hover-up mr-2">
                                  <i class="fas fa-exclamation-circle prem"></i>
                                </span>
                                <span class="textSize text-red">{{$DateShow}}</span>
                              @else
                                <i class="text-secondary">ไม่พบข้อมูล</i>
                              @endif
                            @elseif($Tag == 'Unknow')
                              <span class="btn-outline-danger btn-sm hover-up mr-2">
                                <i class="fas fa-exclamation-circle prem"></i>
                              </span>
                              <span class="textSize text-red">{{$DateShow}}</span>
                            @else
                              <span class="btn-outline-success btn-sm hover-up textSize mr-2">
                                <i class="fas fa-history prem"></i>
                              </span>
                              <span class="textSize text-green">{{$DateShow}}</span>
                            @endif
                          </td>
                          <td class="text-right">
                            <a href="{{ route('MasterLegis.edit',[$row->id]) }}?type={{5}}&dateSearch={{$dateSearch}}&FlagPage={{5}}&FlagTab={{2}}" class="btn btn-warning btn-sm hover-up" data-toggle="tooltip" data-placement="top" title="แก้ไขรายการ">
                              <i class="far fa-edit"></i>
                            </a>
                            <form method="post" class="delete_form" action="{{ route('MasterLegis.destroy',[$row->id]) }}" style="display:inline;">
                            {{csrf_field()}}
                              <input type="hidden" name="type" value="1" />
                              <input type="hidden" name="_method" value="DELETE" />
                              <button type="submit" data-name="{{ $row->Contract_legis }}" class="delete-modal btn btn-danger btn-sm AlertForm hover-up" data-toggle="tooltip" data-placement="top" title="ลบรายการ">
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
                <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ลูกหนี้ <span class="textHeader">(คัดโฉนด/ถ่ายภาพ/ประเมิณ)</span></h6>
                  <table class="table table-hover SizeText" id="table33">
                    <thead>
                      <tr>
                        <th class="text-center">เลขที่สัญญา</th>
                        <th class="text-center">ชื่อ-สกุล</th>
                        <th class="text-center">วันที่คัดโฉนด</th>
                        <th class="text-center">แจ้งเตือน</th>
                        <th class="text-center" style="width: 70px"></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data3 as $key => $row)
                        @php
                          $SetDate = NULL;
                          if($row->legiscourtCase->datepreparedoc_case != NULL) {
                            $SetDate = $row->legiscourtCase->datepreparedoc_case;
                          }else{
                            $SetDate = $row->legiscourtCase->datepreparedoc_case;
                          }

                          if($SetDate >= date('Y-m-d')) {
                            $DateDue = date_create($SetDate);
                            $NowDate = date_create(date('Y-m-d'));
                            $DateDiff = date_diff($NowDate,$DateDue);
                            if($DateDiff->d <= 7){
                              $Tag = 'Active';
                              $DateShow = $DateDiff->format("%a วัน");
                            }else{
                              $Tag = NULL;
                              $DateShow = 'รอดำเนินการ';
                            }
                          }
                          else if(@$row->legiscourtCase->datepreparedoc_case == NULL){
                            $Tag = 'Unknow';
                            $DateShow = 'ไม่พบข้อมูล';
                          }
                          else{
                            $Tag = 'Closest';
                            $DateShow = 'เลยกำหนดการ';
                          }
                        @endphp
                        <tr>
                          <td class="text-center">
                            @if($row->legisCompromise != NULL)
                              <span class="text-info">{{$row->Contract_legis}}</span>
                              <a href="{{ route('MasterCompro.edit',[$row->id]) }}?type={{1}}" class="float-right btn-info btn-sm hover-up textSize" data-toggle="tooltip" data-placement="top" title="อยู่ระหว่างประนอมหนี้">
                                <i class="fas fa-hand-holding-usd prem"></i>
                              </a>
                            @else
                              {{$row->Contract_legis}}
                            @endif
                          </td>
                          <td class="text-left"> {{$row->Name_legis}} </td>
                          <td class="text-center"> {{ ($row->legiscourtCase->datepreparedoc_case != NULL) ?FormatDatethai($row->legiscourtCase->datepreparedoc_case): 'ยังไม่ระบุวันที่' }} </td>
                          <td class="text-left">
                            @if($Tag == 'Active')
                              <span class="btn-outline-warning btn-sm hover-up mr-2">
                                <i class="far fa-calendar-alt prem"></i>
                              </span>
                              <span class="textSize text-warning">กำหนดการอีก {{$DateShow}}</span>
                            @elseif($Tag == 'Closest')
                              @if($SetDate != NULL)
                                <span class="btn-outline-danger btn-sm hover-up mr-2">
                                  <i class="fas fa-exclamation-circle prem"></i>
                                </span>
                                <span class="textSize text-red">{{$DateShow}}</span>
                              @else
                                <i class="text-secondary">ไม่พบข้อมูล</i>
                              @endif
                            @elseif($Tag == 'Unknow')
                              <span class="btn-outline-danger btn-sm hover-up mr-2">
                                <i class="fas fa-exclamation-circle prem"></i>
                              </span>
                              <span class="textSize text-red">{{$DateShow}}</span>
                            @else
                              <span class="btn-outline-success btn-sm hover-up textSize mr-2">
                                <i class="fas fa-history prem"></i>
                              </span>
                              <span class="textSize text-green">{{$DateShow}}</span>
                            @endif
                          </td>
                          <td class="text-right">
                            <a href="{{ route('MasterLegis.edit',[$row->id]) }}?type={{5}}&dateSearch={{$dateSearch}}&FlagPage={{5}}&FlagTab={{2}}" class="btn btn-warning btn-sm hover-up" data-toggle="tooltip" data-placement="top" title="แก้ไขรายการ">
                              <i class="far fa-edit"></i>
                            </a>
                            <form method="post" class="delete_form" action="{{ route('MasterLegis.destroy',[$row->id]) }}" style="display:inline;">
                            {{csrf_field()}}
                              <input type="hidden" name="type" value="1" />
                              <input type="hidden" name="_method" value="DELETE" />
                              <button type="submit" data-name="{{ $row->Contract_legis }}" class="delete-modal btn btn-danger btn-sm AlertForm hover-up" data-toggle="tooltip" data-placement="top" title="ลบรายการ">
                                <i class="far fa-trash-alt"></i>
                              </button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
              </div>
              <div id="list-page4-list" class="container tab-pane fade show SizeText @if(isset($FlagTab)) {{($FlagTab == 4) ? 'active' : '' }} @endif">
                <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ลูกหนี้ <span class="textHeader">(ตั้งเรื่องยึดทรัพย์)</span></h6>
                  <table class="table table-hover SizeText" id="table44">
                    <thead>
                      <tr>
                        <th class="text-center">เลขที่สัญญา</th>
                        <th class="text-center">ชื่อ-สกุล</th>
                        <th class="text-center">วันที่ตั้งยึดทรัพย์</th>
                        <th class="text-center">แจ้งเตือน</th>
                        <th class="text-center" style="width: 70px"></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data4 as $key => $row)
                        @php
                          $SetDate = NULL;
                          if($row->legiscourtCase->dateSequester_case != NULL) {
                            $SetDate = $row->legiscourtCase->dateSequester_case;
                          }else{
                            $SetDate = $row->legiscourtCase->dateSequester_case;
                          }

                          if($SetDate >= date('Y-m-d')) {
                            $DateDue = date_create($SetDate);
                            $NowDate = date_create(date('Y-m-d'));
                            $DateDiff = date_diff($NowDate,$DateDue);
                            if($DateDiff->d <= 7){
                              $Tag = 'Active';
                              $DateShow = $DateDiff->format("%a วัน");
                            }else{
                              $Tag = NULL;
                              $DateShow = 'รอดำเนินการ';
                            }
                          }
                          else if(@$row->legiscourtCase->dateSequester_case == NULL){
                            $Tag = 'Unknow';
                            $DateShow = 'ไม่พบข้อมูล';
                          }
                          else{
                            $Tag = 'Closest';
                            $DateShow = 'เลยกำหนดการ';
                          }
                        @endphp
                        <tr>
                          <td class="text-center">
                            @if($row->legisCompromise != NULL)
                              <span class="text-info">{{$row->Contract_legis}}</span>
                              <a href="{{ route('MasterCompro.edit',[$row->id]) }}?type={{1}}" class="float-right btn-info btn-sm hover-up textSize" data-toggle="tooltip" data-placement="top" title="อยู่ระหว่างประนอมหนี้">
                                <i class="fas fa-hand-holding-usd prem"></i>
                              </a>
                            @else
                              {{$row->Contract_legis}}
                            @endif
                          </td>
                          <td class="text-left"> {{$row->Name_legis}} </td>
                          <td class="text-center"> {{($row->legiscourtCase->dateSequester_case != NULL) ?FormatDatethai($row->legiscourtCase->dateSequester_case): 'ยังไม่ระบุวันที่' }} </td>
                          <td class="text-left">
                            @if($Tag == 'Active')
                              <span class="btn-outline-warning btn-sm hover-up mr-2">
                                <i class="far fa-calendar-alt prem"></i>
                              </span>
                              <span class="textSize text-warning">กำหนดการอีก {{$DateShow}}</span>
                            @elseif($Tag == 'Closest')
                              @if($SetDate != NULL)
                                <span class="btn-outline-danger btn-sm hover-up mr-2">
                                  <i class="fas fa-exclamation-circle prem"></i>
                                </span>
                                <span class="textSize text-red">{{$DateShow}}</span>
                              @else
                                <i class="text-secondary">ไม่พบข้อมูล</i>
                              @endif
                            @elseif($Tag == 'Unknow')
                              <span class="btn-outline-danger btn-sm hover-up mr-2">
                                <i class="fas fa-exclamation-circle prem"></i>
                              </span>
                              <span class="textSize text-red">{{$DateShow}}</span>
                            @else
                              <span class="btn-outline-success btn-sm hover-up textSize mr-2">
                                <i class="fas fa-history prem"></i>
                              </span>
                              <span class="textSize text-green">{{$DateShow}}</span>
                            @endif
                          </td>
                          <td class="text-right">
                            <a href="{{ route('MasterLegis.edit',[$row->id]) }}?type={{5}}&dateSearch={{$dateSearch}}&FlagPage={{5}}&FlagTab={{2}}" class="btn btn-warning btn-sm hover-up" data-toggle="tooltip" data-placement="top" title="แก้ไขรายการ">
                              <i class="far fa-edit"></i>
                            </a>
                            <form method="post" class="delete_form" action="{{ route('MasterLegis.destroy',[$row->id]) }}" style="display:inline;">
                            {{csrf_field()}}
                              <input type="hidden" name="type" value="1" />
                              <input type="hidden" name="_method" value="DELETE" />
                              <button type="submit" data-name="{{ $row->Contract_legis }}" class="delete-modal btn btn-danger btn-sm AlertForm hover-up" data-toggle="tooltip" data-placement="top" title="ลบรายการ">
                                <i class="far fa-trash-alt"></i>
                              </button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
              </div>
              <div id="list-page5-list" class="container tab-pane fade show SizeText @if(isset($FlagTab)) {{($FlagTab == 5) ? 'active' : '' }} @endif">
                <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ลูกหนี้ <span class="textHeader">(ประกาศขายทอดตลาด)</span></h6>
                  <table class="table table-hover SizeText" id="table55">
                    <thead>
                      <tr>
                        <th class="text-center">เลขที่สัญญา</th>
                        <th class="text-center">ชื่อ-สกุล</th>
                        <th class="text-center">วันที่ประกาศขาย</th>
                        <th class="text-center">แจ้งเตือน</th>
                        <th class="text-center" style="width: 70px"></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data5 as $key => $row)
                        @php
                          $SetDate = NULL;
                          if($row->legiscourtCase->datePublicsell_case != NULL) {
                            $SetDate = $row->legiscourtCase->datePublicsell_case;
                          }else{
                            $SetDate = $row->legiscourtCase->datePublicsell_case;
                          }

                          if($SetDate >= date('Y-m-d')) {
                            $DateDue = date_create($SetDate);
                            $NowDate = date_create(date('Y-m-d'));
                            $DateDiff = date_diff($NowDate,$DateDue);
                            if($DateDiff->d <= 7){
                              $Tag = 'Active';
                              $DateShow = $DateDiff->format("%a วัน");
                            }else{
                              $Tag = NULL;
                              $DateShow = 'รอดำเนินการ';
                            }
                          }
                          else if(@$row->legiscourtCase->datePublicsell_case == NULL){
                            $Tag = 'Unknow';
                            $DateShow = 'ไม่พบข้อมูล';
                          }
                          else{
                            $Tag = 'Closest';
                            $DateShow = 'เลยกำหนดการ';
                          }
                        @endphp
                        <tr>
                          <td class="text-center">
                            @if($row->legisCompromise != NULL)
                              <span class="text-info">{{$row->Contract_legis}}</span>
                              <a href="{{ route('MasterCompro.edit',[$row->id]) }}?type={{1}}" class="float-right btn-info btn-sm hover-up textSize" data-toggle="tooltip" data-placement="top" title="อยู่ระหว่างประนอมหนี้">
                                <i class="fas fa-hand-holding-usd prem"></i>
                              </a>
                            @else
                              {{$row->Contract_legis}}
                            @endif
                          </td>
                          <td class="text-left"> {{$row->Name_legis}} </td>
                          <td class="text-center">{{($row->legiscourtCase->datePublicsell_case != NULL) ?FormatDatethai($row->legiscourtCase->datePublicsell_case): 'ยังไม่ระบุวันที่' }}</td>
                          <td class="text-left">
                            @if($Tag == 'Active')
                              <span class="btn-outline-warning btn-sm hover-up mr-2">
                                <i class="far fa-calendar-alt prem"></i>
                              </span>
                              <span class="textSize text-warning">กำหนดการอีก {{$DateShow}}</span>
                            @elseif($Tag == 'Closest')
                              @if($SetDate != NULL)
                                <span class="btn-outline-danger btn-sm hover-up mr-2">
                                  <i class="fas fa-exclamation-circle prem"></i>
                                </span>
                                <span class="textSize text-red">{{$DateShow}}</span>
                              @else
                                <i class="text-secondary">ไม่พบข้อมูล</i>
                              @endif
                            @elseif($Tag == 'Unknow')
                              <span class="btn-outline-danger btn-sm hover-up mr-2">
                                <i class="fas fa-exclamation-circle prem"></i>
                              </span>
                              <span class="textSize text-red">{{$DateShow}}</span>
                            @else
                              <span class="btn-outline-success btn-sm hover-up textSize mr-2">
                                <i class="fas fa-history prem"></i>
                              </span>
                              <span class="textSize text-green">{{$DateShow}}</span>
                            @endif
                          </td>
                          <td class="text-right">
                            <a href="{{ route('MasterLegis.edit',[$row->id]) }}?type={{5}}&dateSearch={{$dateSearch}}&FlagPage={{5}}&FlagTab={{2}}" class="btn btn-warning btn-sm hover-up" data-toggle="tooltip" data-placement="top" title="แก้ไขรายการ">
                              <i class="far fa-edit"></i>
                            </a>
                            <form method="post" class="delete_form" action="{{ route('MasterLegis.destroy',[$row->id]) }}" style="display:inline;">
                            {{csrf_field()}}
                              <input type="hidden" name="type" value="1" />
                              <input type="hidden" name="_method" value="DELETE" />
                              <button type="submit" data-name="{{ $row->Contract_legis }}" class="delete-modal btn btn-danger btn-sm AlertForm hover-up" data-toggle="tooltip" data-placement="top" title="ลบรายการ">
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
          @endif
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

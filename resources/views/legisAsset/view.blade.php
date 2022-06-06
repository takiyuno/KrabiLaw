@extends('layouts.master')
@section('title','ลูกหนี้สืบทรัพย์')
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
              <h5>ลูกหนี้สินทรัพย์ <small class="textHeader">(Assets Debtors)</small></h5>
            </div>
          </div>
          <div class="col-4">
            <form method="get" action="#">
              <div class="card-tools d-inline float-right btn-page">
                <div class="input-group form-inline">
                  <span class="text-right mr-sm-1">วันที่ : </span>
                  <input type="text" id="dateSearch" name="dateSearch" value="" class="form-control form-control-sm textSize" placeholder="วันที - ถึงวันที่">
                  <span class="input-group-append">
                    <button type="submit" class="btn btn-info btn-sm button-id mr-sm-1">
                      <i class="fas fa-search"></i>
                    </button>
                  </span>
                  <button class="btn btn-info btn-sm hover-up" data-toggle="dropdown">
                    <i class="fas fa-print"></i>
                  </button>
                  <ul class="dropdown-menu text-sm" role="menu">
                  </ul>
                </div>
              </div>
              <!-- <input type="hidden" name="flag" id="flag"> -->
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
                ลูกหนี้ทั้งหมด (<b><span class="text-red">{{count($data1)+count($data2)+count($dataSubId)}}</span></b> คน)
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
                      <i class="fas fa-user-tag mr-1 text-success"></i>
                      <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ มีทรัพย์</div>
                    </div>
                    @if(count($data1) != 0)
                      <span class="badge bg-danger">{{count($data1)}}</span>
                    @endif
                  </div>
                </a>
                <a class="list-group-item hover-up" data-toggle="tab" href="#list-page2-list">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <i class="fas fa-user-tag mr-1 text-danger"></i>
                      <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ ไม่มีทรัพย์</div>
                    </div>
                    @if(count($data2) != 0)
                      <span class="badge bg-danger">{{count($data2)}}</span>
                    @endif
                  </div>
                </a>
                <a class="list-group-item hover-up" data-toggle="tab" href="#list-page3-list">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <i class="fas fa-user-tag mr-1 text-muted"></i>
                      <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ ไม่มีข้อมูล</div>
                    </div>
                    @if(count($dataSubId) != 0)
                      <span class="badge bg-danger">{{count($dataSubId)}}</span>
                    @endif
                  </div>
                </a>
              </nav>
            </div>
          </div>
        </div>
        <div class="col-lg-9">
          <div class="card">
            <div class="card-body text-sm">
              <div class="tab-content">
                <div id="list-page1-list" class="container tab-pane active SizeText">
                  <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ลูกหนี้มีทรัพย์ <span class="textHeader">(Asset debtor)</span></h6>
                    <table class="table table-hover SizeText" id="table11">
                      <thead>
                        <tr>
                          <th class="text-center">เลขที่สัญญา</th>
                          <th class="text-center">ชื่อ-สกุล</th>
                          <th class="text-center">วันสืบทรัพย์</th>
                          <th class="text-center">ผลสืบ</th>
                          <th class="text-center">แจ้งเตือน</th>
                          <th class="text-center" style="width: 70px"></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($data1 as $key => $row)
                          <tr>
                            <td class="text-left"> {{$row->Contract_legis}}</td>
                            <td class="text-left"> {{$row->Name_legis}} </td>
                            <td class="text-center"> 
                              @php
                                if($row->NewpursueDate_asset != NULL) {
                                  $SetDate = $row->NewpursueDate_asset;
                                }else{
                                  $SetDate = $row->sequester_asset;
                                }
                              @endphp

                              @if($SetDate != NULL)
                                {{ formatDateThai($SetDate) }}
                              @else
                                <i class="text-secondary">ไม่พบข้อมูล</i>
                              @endif
                            </td>
                            <td class="text-center"> 
                              @if($row->sendsequester_asset != NULL)
                                {{$row->sendsequester_asset}}
                              @else
                                <i class="text-secondary">ไม่พบข้อมูล</i>
                              @endif
                            </td>
                            <td class="text-center">
                              @php
                                if($SetDate != NULL){
                                  if($SetDate >= date('Y-m-d')) {
                                    $DateDue = date_create($SetDate);
                                    $NowDate = date_create(date('Y-m-d'));
                                    $DateDiff = date_diff($NowDate,$DateDue);
                                    if($DateDiff->d <= 7){
                                      $DateShow = $DateDiff->format("%a วัน");
                                    }else{
                                      $DateShow = 'รอดำเนินการ';
                                    }
                                  }else{
                                    $DateShow = 'เลยกำหนดการ';
                                  }
                                }else{
                                  $DateShow = 'ไม่พบข้อมูล';
                                }
                              @endphp
                              <span class="text-red"><i class="fas fa-exclamation-triangle prem"></i> {{$DateShow}}</span>
                            </td>
                            <td class="text-right">
                              <a href="{{ route('MasterLegis.edit',[$row->id]) }}?type={{6}}" class="btn btn-warning btn-sm hover-up" title="แก้ไขรายการ">
                                <i class="far fa-edit"></i>
                              </a>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>
                <div id="list-page2-list" class="container tab-pane fade SizeText">
                  <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ลูกหนี้ไม่มีทรัพย์ <span class="textHeader">(Asset debtor)</span></h6>
                    <table class="table table-hover SizeText" id="table22">
                      <thead>
                        <tr>
                          <th class="text-center">เลขที่สัญญา</th>
                          <th class="text-center">ชื่อ-สกุล</th>
                          <th class="text-center">วันสืบทรัพย์</th>
                          <th class="text-center">ผลสืบ</th>
                          <th class="text-center">แจ้งเตือน</th>
                          <th class="text-center" style="width: 70px"></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($data2 as $key => $row)
                          <tr>
                            <td class="text-left"> {{$row->Contract_legis}}</td>
                            <td class="text-left"> {{$row->Name_legis}} </td>
                            <td class="text-center"> 
                              @php
                                if($row->NewpursueDate_asset != NULL) {
                                  $SetDate = $row->NewpursueDate_asset;
                                }else{
                                  $SetDate = $row->sequester_asset;
                                }
                              @endphp

                              @if($SetDate != NULL)
                                {{ formatDateThai($SetDate) }}
                              @else
                                <i class="text-secondary">ไม่พบข้อมูล</i>
                              @endif
                            </td>
                            <td class="text-center">
                              @if($row->sendsequester_asset != NULL)
                                {{$row->sendsequester_asset}}
                              @else
                                <i class="text-secondary">ไม่พบข้อมูล</i>
                              @endif
                            </td>
                            <td class="text-center">
                              @php
                                if($SetDate != NULL){
                                  if($SetDate >= date('Y-m-d')) {
                                    $DateDue = date_create($SetDate);
                                    $NowDate = date_create(date('Y-m-d'));
                                    $DateDiff = date_diff($NowDate,$DateDue);
                                    if($DateDiff->d <= 7){
                                      $DateShow = $DateDiff->format("%a วัน");
                                    }else{
                                      $DateShow = 'รอดำเนินการ';
                                    }
                                  }else{
                                    $DateShow = 'เลยกำหนดการ';
                                  }
                                }else{
                                  $DateShow = 'ไม่พบข้อมูล';
                                }
                              @endphp
                              <span class="text-red"><i class="fas fa-exclamation-triangle prem"></i> {{$DateShow}}</span>
                            </td>
                            <td class="text-right">
                              <a href="{{ route('MasterLegis.edit',[$row->id]) }}?type={{6}}" class="btn btn-warning btn-sm hover-up" title="แก้ไขรายการ">
                                <i class="far fa-edit"></i>
                              </a>
                            </td>
                          </tr>
                        @endforeach      
                      </tbody>
                    </table>
                </div>
                <div id="list-page3-list" class="container tab-pane fade SizeText">
                  <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText">ลูกหนี้ไม่มีข้อมูล <span class="textHeader">(Empty debtor)</span></h6>
                    <table class="table table-hover SizeText" id="table22">
                      <thead>
                        <tr>
                          <th class="text-center">เลขที่สัญญา</th>
                          <th class="text-center">ชื่อ-สกุล</th>
                          <th class="text-center">วันสืบทรัพย์</th>
                          <th class="text-center">ผลสืบ</th>
                          <th class="text-center">แจ้งเตือน</th>
                          <th class="text-center" style="width: 70px"></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($dataSubId as $key => $row)
                          <tr>
                            <td class="text-left"> {{$row->Contract_legis}}</td>
                            <td class="text-left"> {{$row->Name_legis}} </td>
                            <td class="text-center"><i class="text-secondary">ไม่พบข้อมูล</i></td>
                            <td class="text-center"><i class="text-secondary">ไม่พบข้อมูล</i></td>
                            <td class="text-center"><span class="text-red"><i class="fas fa-exclamation-triangle prem"></i> ไม่พบข้อมูล</span></td>
                            <td class="text-right">
                              <a href="{{ route('MasterLegis.edit',[$row->id]) }}?type={{6}}" class="btn btn-warning btn-sm hover-up" title="แก้ไขรายการ">
                                <i class="far fa-edit"></i>
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

@extends('layouts.master')
@section('title','แจ้งเตือนขาดชำระลูกหนี้')
@section('content')

  @if(session()->has('success'))
    <script type="text/javascript">
      toastr.success('{{ session()->get('success') }}')
    </script>
  @endif

  <style>
    .font11{
      font-size: 11px;
    }
  </style>

  <!-- Main content -->
  <section class="Profile-container" style="font-family: 'Prompt', sans-serif;">
      <div class="content">
        <div class="content-header">
          <div class="row">
            <div class="col-8">
              <div class="form-inline">
                <h5>แจ้งเตือนขาดชำระลูกหนี้ <small class="textHeader">(Alert DefaulterDebt)</small></h5>
              </div>
            </div>
            <div class="col-4">
              <form>
                <ol class="breadcrumb float-right">
                  <div class="card-tools d-inline float-right btn-page">
                    <div class="input-group form-inline">
                      <span class="text-right mr-sm-1">วันที่ : </span>
                      <input type="text" id="dateSearch" name="dateSearch" value="" class="form-control form-control-sm" placeholder="วันที - ถึงวันที่">
                      <span class="input-group-append">
                        <button type="submit" class="btn btn-info btn-sm button-id mr-sm-1" >
                          <i class="fas fa-search"></i>
                        </button>
                      </span>
                      <button class="btn btn-info btn-sm" data-toggle="dropdown">
                        <i class="fas fa-print"></i>
                      </button>
                      <ul class="dropdown-menu text-sm" role="menu">
                        <li><a target="_blank" class="dropdown-item" data-toggle="modal" data-target="#modal-new" data-link="#"> รายงาน บันทึกติดตาม</a></li>
                      </ul>
                    </div>
                  </div>
                </ol>
                <input type="hidden" name="flag" id="flag">
              </form>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-3">
            <div class="box-shadow">
              <div class="author-card pb-3 pt-3">
                <span class="text-right">
                  <i class="mr-3 text-muted"></i> 
                    รวมแจ้งเตือน ( <b><font color="red">{{$Count1+$Count2}} </font></b> ราย )
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
                        <div class="d-inline-block font-weight-medium text-uppercase">แจ้งเตือนประนอมใหม่</div>
                      </div>
                        @if($Count1 != 0)
                          <span class="badge bg-danger">{{$Count1}}</span>
                        @endif
                    </div>
                  </a>
                  <a class="list-group-item hover-up" data-toggle="tab" href="#list-page2-list">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <i class="fas fa-user-tag mr-1 text-primary"></i>
                        <div class="d-inline-block font-weight-medium text-uppercase">แจ้งเตือนประนอมเก่า</div>
                      </div>
                        @if($Count2 != 0)
                          <span class="badge bg-danger">{{$Count2}}</span>
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
                  <div id="list-page1-list" class="tab-pane active">
                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText font11">ประนอมหนี้ใหม่  <span class="textHeader">(New Compounding Debt)</span></h6>
                      <table class="table table-hover SizeText font11" id="table11">
                        <thead>
                          <tr>
                            <th class="text-center">เลขที่สัญญา</th>
                            <th class="text-center">ชื่อ-สกุล</th>
                            <th class="text-center">เริ่มประนอม</th>
                            <th class="text-center">ยอดประนอม</th>
                            <th class="text-center">ยอดคงเหลือ</th>
                            <th class="text-center">วันชำระล่าสุด</th>
                            <th class="text-center">วันดิวถัดไป</th>
                            <th class="text-center">สถานะ</th>
                            <th class="text-right" style="width: 30px"></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($data1 as $key => $row)
                            @php 
                              $lastday = date('Y-m-d', strtotime("-3 month")); 
                            @endphp
                            <tr>
                              <td class="text-left"> {{$row->Contract_legis}}</td>
                              <td class="text-left"> {{$row->Name_legis}} </td>
                              <td class="text-center"> {{formatDateThai(@$row->legisCompromise->Date_Promise)}}</td>
                              <td class="text-right"> {{number_format(@$row->legisCompromise->Total_Promise, 2)}}</td>
                              <td class="text-right"> {{number_format(@$row->legisCompromise->Sum_Promise, 2)}}</td>
                              <td class="text-center"> {{ date('d-m-Y', strtotime(substr($row->legispayments->created_at,0,10))) }}</td>
                              <td class="text-center"> {{formatDateThai(@$row->legispayments->DateDue_Payment)}}</td>
                              <td class="text-right">
                                @php
                                  $SetPayAll = str_replace (",","",@$row->legisCompromise->FirstManey_1);
                                @endphp

                                @if(@$row->legisCompromise->FirstManey_1 != NULL)
                                  @if($row->legisCompromise->Sum_FirstPromise == $SetPayAll)
                                    <button data-toggle="tooltip" type="button" class="btn btn-success btn-sm hover-up" title="ครบชำระเงินก้อนแรก">
                                      <i class="fas fa-hands-helping prem"></i>
                                    </button>
                                  @else
                                    <button data-toggle="tooltip" type="button" class="btn btn-danger btn-sm hover-up" title="ขาดชำระเงินก้อนแรก">
                                      <i class="fas fa-hand-holding-usd prem"></i>
                                    </button>
                                  @endif
                                @else
                                  <button data-toggle="tooltip" type="button" class="btn btn-warning btn-sm hover-up" title="ยังไม่คีย์เงินก้อนแรก">
                                    <i class="fas fa-comment-dollar prem"></i>
                                  </button>
                                @endif
                                

                                @if(@$row->legispayments->DateDue_Payment < $lastday)
                                  <button data-toggle="tooltip" type="button" class="btn btn-danger btn-sm hover-up" title="ขาดชำระประนอม">
                                    <i class="fas fa-thumbs-down prem"></i>
                                  </button>
                                @endif
                              </td>
                              <td class="text-right">
                                <a href="{{ route('MasterCompro.edit',[$row->id]) }}?type={{2}}" class="btn btn-warning btn-sm hover-up" title="แก้ไขรายการ">
                                  <i class="far fa-edit"></i>
                                </a>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                  </div>
                  <div id="list-page2-list" class="tab-pane fade">
                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText font11">ประนอมหนี้เก่า  <span class="textHeader">(Old Compounding Debt)</span></h6>
                      <table class="table table-hover SizeText font11" id="table22">
                        <thead>
                          <tr>
                            <th class="text-center">เลขที่สัญญา</th>
                            <th class="text-center">ชื่อ-สกุล</th>
                            <th class="text-center">เริ่มประนอม</th>
                            <th class="text-center">ยอดประนอม</th>
                            <th class="text-center">ยอดคงเหลือ</th>
                            <th class="text-center">วันชำระล่าสุด</th>
                            <th class="text-center">วันดิวถัดไป</th>
                            <th class="text-center">สถานะ</th>
                            <th class="text-right" style="width: 30px"></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($data2 as $key => $row)
                            @php 
                              $lastday = date('Y-m-d', strtotime("-3 month")); 
                            @endphp
                            <tr>
                              <td class="text-left"> {{$row->Contract_legis}}</td>
                              <td class="text-left"> {{$row->Name_legis}} </td>
                              <td class="text-center"> {{formatDateThai(@$row->legisCompromise->Date_Promise)}}</td>
                              <td class="text-right"> {{number_format(@$row->legisCompromise->Total_Promise, 2)}}</td>
                              <td class="text-right"> {{number_format(@$row->legisCompromise->Sum_Promise, 2)}}</td>
                              <td class="text-center">{{formatDateThai(substr($row->legispayments->created_at,0,10))}}</td>
                              <td class="text-center">{{formatDateThai(@$row->legispayments->DateDue_Payment)}}</td>
                              <td class="text-right">
                                @php
                                  $SetPayAll = str_replace (",","",@$row->legisCompromise->FirstManey_1);
                                @endphp

                                @if(@$row->legisCompromise->FirstManey_1 != NULL)
                                  @if($row->legisCompromise->Sum_FirstPromise == $SetPayAll)
                                    <button data-toggle="tooltip" type="button" class="btn btn-success btn-sm hover-up" title="ครบชำระเงินก้อนแรก">
                                      <i class="fas fa-hands-helping prem"></i>
                                    </button>
                                  @else
                                    <button data-toggle="tooltip" type="button" class="btn btn-danger btn-sm hover-up" title="ขาดชำระเงินก้อนแรก">
                                      <i class="fas fa-hand-holding-usd prem"></i>
                                    </button>
                                  @endif
                                @else
                                  <button data-toggle="tooltip" type="button" class="btn btn-warning btn-sm hover-up" title="ยังไม่คีย์เงินก้อนแรก">
                                    <i class="fas fa-comment-dollar prem"></i>
                                  </button>
                                @endif

                                @if(@$row->legispayments->DateDue_Payment < $lastday)
                                  <button data-toggle="tooltip" type="button" class="btn btn-danger btn-sm hover-up" title="ขาดชำระประนอม">
                                    <i class="fas fa-thumbs-down prem"></i>
                                  </button>
                                @endif
                              </td>
                              <td class="text-right">
                                <a href="{{ route('MasterCompro.edit',[$row->id]) }}?type={{3}}" class="btn btn-warning btn-sm hover-up" title="แก้ไขรายการ">
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

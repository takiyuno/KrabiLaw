@extends('layouts.master')
@section('title','กฏหมาย/ลูกหนี้เตรียมฟ้อง')
@section('content')

  @if(session()->has('success'))
    <script type="text/javascript">
      toastr.success("{{ session()->get('success') }}")
    </script>
  @endif

  <style>
    .font12{
      font-size: 12px;
    }
    .dateHide span{
      display:none;
    }
    .dateHide2 p{
      display:none;
    }
  </style>

  <!-- Main content -->
  <section class="Profile-container" style="font-family: 'Prompt', sans-serif;">
      <div class="content">
        <div class="content-header">
          <div class="row">
            <div class="col-8">
              <div class="form-inline">
                @if($type == 2)
                  <h5>ลูกหนี้ประนอมใหม่ <small class="textHeader">(New Compounding Debt)</small></h5>
                @elseif($type == 3)
                  <h5>ลูกหนี้ประนอมเก่า <small class="textHeader">(Old Compounding Debt)</small></h5>
                @endif
              </div>
            </div>
            <div class="col-4">
              <form method="get" action="{{ route('MasterCompro.index') }}">
                <ol class="breadcrumb float-right">
                  <div class="card-tools d-inline float-right btn-page">
                    <div class="input-group form-inline">
                      <span class="text-right mr-sm-1">วันที่ : </span>
                      <input type="text" id="dateSearch" name="dateSearch" value="{{ ($dateSearch != '') ?$dateSearch: '' }}" class="form-control form-control-sm SizeText font12" placeholder="วันที - ถึงวันที่">
                      <span class="input-group-append">
                          <button type="submit" class="btn btn-info btn-sm button-id mr-sm-1">
                          <i class="fas fa-search"></i>
                          </button>
                      </span>
                      <button class="btn btn-info btn-sm" data-toggle="dropdown">
                          <i class="fas fa-print"></i>
                      </button>
                      <ul class="dropdown-menu SizeText font12" role="menu">
                        @if($type == 2)
                          <li><a target="_blank" class="dropdown-item SizeText font12" href="{{ route('LegisCompro.Report') }}?type={{2}}">รายงาน ลูกหนี้ประนอมใหม่</a></li>
                        @elseif($type == 3)
                          <li><a target="_blank" class="dropdown-item SizeText font12" href="{{ route('LegisCompro.Report') }}?type={{3}}">รายงาน ลูกหนี้ประนอมเก่า</a></li>
                        @endif
                          <li><a target="_blank" class="dropdown-item SizeText font12" href="{{ route('LegisCompro.Report') }}?type={{10}}">รายงาน ลูกหนี้ประนอมทั้งหมด</a></li>
                      </ul>
                    </div>
                  </div>
                </ol>
                <!-- <input type="hidden" name="flag" id="flag"> -->
                <input type="hidden" name="type" value="{{$type}}"/>
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
                  @if($type == 2)
                    รวมประนอมใหม่ ( <b><font color="red">{{$Count1 + $Count1_1 + $Count1_2 + $Count1_3 + $Count1_4+ $CountNullData}}</font></b> ราย )
                  @elseif($type == 3)
                    รวมประนอมเก่า ( <b><font color="red">{{$Count1 + $Count1_1 + $Count1_2 + $Count1_3 + $Count1_4 + $CountNullData + count($dataEndcaseOld)}}</font></b> ราย )
                  @endif
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
                        <div class="d-inline-block font-weight-medium text-uppercase">ชำระปกติ</div>
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
                        <div class="d-inline-block font-weight-medium text-uppercase">ขาดชำระ 1 งวด</div>
                      </div>
                        @if($Count1_1 != 0)
                          <span class="badge bg-danger">{{$Count1_1}}</span>
                        @endif
                    </div>
                  </a>
                  <a class="list-group-item hover-up" data-toggle="tab" href="#list-page3-list">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <i class="fas fa-user-tag mr-1 text-warning"></i>
                        <div class="d-inline-block font-weight-medium text-uppercase">ขาดชำระ 2 งวด</div>
                      </div>
                        @if($Count1_2 != 0)
                          <span class="badge bg-danger float-right">{{$Count1_2}}</span>
                        @endif
                    </div>
                  </a>
                  <a class="list-group-item hover-up" data-toggle="tab" href="#list-page4-list">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <i class="fas fa-user-tag mr-1 text-danger"></i>
                        <div class="d-inline-block font-weight-medium text-uppercase">ขาดชำระ 3 งวด</div>
                      </div>
                        @if($Count1_3 != 0)
                          <span class="badge bg-danger float-right">{{$Count1_3}}</span>
                        @endif
                    </div>
                  </a>
                  <a class="list-group-item hover-up" data-toggle="tab" href="#list-page6-list">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <i class="fas fa-user-tag mr-1 text-danger"></i>
                        <div class="d-inline-block font-weight-medium text-uppercase">ขาดชำระ 3 งวดขึ้นไป</div>
                      </div>
                        @if($Count1_4 != 0)
                          <span class="badge bg-danger float-right">{{$Count1_4}}</span>
                        @endif
                    </div>
                  </a>
                 
                    <a class="list-group-item hover-up" data-toggle="tab" href="#list-page5-list">
                      <div class="d-flex justify-content-between align-items-center">
                        <div>
                          <i class="fas fa-user-tag mr-1 text-muted"></i>
                          <div class="d-inline-block font-weight-medium text-uppercase">สถานะลูกหนี้ยังไม่มีการชำระ</div>
                        </div>
                          @if($CountNullData != 0)
                            <span class="badge bg-danger float-right">{{$CountNullData}}</span>
                          @endif
                      </div>
                    </a> 
                    @if($type == 3)
                    <a class="list-group-item hover-up" data-toggle="tab" href="#list-page6-list">
                      <div class="d-flex justify-content-between align-items-center">
                        <div>
                          <i class="fas fa-user-check mr-1 text-success"></i>
                          <div class="d-inline-block font-weight-medium text-uppercase">ปิดจบประนอม</div>
                        </div>
                          @if(count($dataEndcaseOld) != 0)
                            <span class="badge bg-danger float-right">{{count($dataEndcaseOld)}}</span>
                          @endif
                      </div>
                    </a>
                  @endif
                </nav>
              </div>
            </div>
          </div>
          <div class="col-lg-9">
            <div class="card">
              <div class="card-body text-sm">
                <div class="tab-content">
                  <div id="list-page1-list" class="tab-pane active">
                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText font12">ชำระปกติ  <span class="textHeader">(Normal Payment)</span></h6>
                      <table class="table table-hover SizeText font12 dateHide" id="table11">
                        <thead>
                          <tr>
                            <th class="text-center">เลขที่สัญญา</th>
                            <th class="text-center">ชื่อ-สกุล</th>
                            <th class="text-center">เริ่มประนอม</th>
                            <th class="text-center">ยอดประนอม</th>
                            <th class="text-center">ยอดคงเหลือ</th>
                            <th class="text-center">วันที่ชำระล่าสุด</th>
                            <th class="text-center">วันดิวถัดไป</th>
                            <th class="text-center">สถานะ</th>
                            <th class="text-right" style="width: 30px"></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($data1 as $key => $row)
                            @php 
                              if($row->legispayments != NULL){
                                $SetDateDue = date_create($row->legispayments->DateDue_Payment);
                                @$DateDuePayment = date_format($SetDateDue, 'd-m-Y'); 
                              }else{
                                @$DateDuePayment = NULL;
                              }
                            @endphp
                            <tr>
                              <td class="text-left"> {{$row->Contract_legis}}</td>
                              <td class="text-left"> {{$row->Name_legis}} </td>
                              <td class="text-center"> 
                              <span >{{ date_format(date_create(@$row->legisCompromise->Date_Promise), 'Ymd')}} </span>
                                 {{formatDateThai(@$row->legisCompromise->Date_Promise)}}</td>
                              <td class="text-right">{{(@$row->legisCompromise->Total_Promise != 0) ?number_format(@$row->legisCompromise->Total_Promise, 2): '-' }}</td>
                              <td class="text-right">{{(@$row->legisCompromise->Sum_Promise != 0) ?number_format(@$row->legisCompromise->Sum_Promise, 2): '-' }}</td>
                              <td class="text-center" >
                                <span >{{ date_format(date_create(@$row->legispayments->Date_Payment), 'Ymd')}} </span>
                                {{ formatDateThai(@$row->legispayments->Date_Payment)}}
                              </td>
                              <td class="text-center"> 
                              <span >{{ date_format(date_create(@$row->legispayments->DateDue_Payment), 'Ymd')}} </span>
                                {{(@$DateDuePayment != NULL) ?formatDateThai(@$DateDuePayment): '-' }} </td>
                              <td class="text-right">
                                @if(@$row->legisCompromise->FirstManey_1 != 0)
                                  @if($row->legisCompromise->Sum_FirstPromise >= str_replace (",","",@$row->legisCompromise->FirstManey_1))
                                    <button data-toggle="tooltip" type="button" class="btn btn-success btn-sm hover-up" title="ครบชำระเงินก้อนแรก">
                                      <i class="fas fa-hands-helping prem"></i>
                                    </button>
                                  @else
                                    <button data-toggle="tooltip" type="button" class="btn btn-danger btn-sm hover-up" title="ขาดชำระเงินก้อนแรก">
                                      <i class="fas fa-hand-holding-usd prem"></i>
                                    </button>
                                  @endif
                                @elseif (@$row->legisCompromise->Payall_Promise != 0)
                                  @if($row->legisCompromise->Sum_FirstPromise >= str_replace (",","",@$row->legisCompromise->Payall_Promise))
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

                              </td>
                              <td class="text-right">
                                <a href="{{ route('MasterCompro.edit',[$row->id]) }}?type={{$type}}" class="btn btn-warning btn-sm hover-up" title="แก้ไขรายการ">
                                  <i class="far fa-edit"></i>
                                </a>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                  </div>
                  <div id="list-page2-list" class="tab-pane fade">
                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText font12">ขาดชำระ 1 งวด  <span class="textHeader">(Missing 1 Installment)</span></h6>
                      <table class="table table-hover SizeText font12 dateHide" id="table22">
                        <thead>
                          <tr>
                            <th class="text-center">เลขที่สัญญา</th>
                            <th class="text-center">ชื่อ-สกุล</th>
                            <th class="text-center">เริ่มประนอม</th>
                            <th class="text-center">ยอดประนอม</th>
                            <th class="text-center">ยอดคงเหลือ</th>
                            <th class="text-center">วันที่ชำระล่าสุด</th>
                            <th class="text-center">วันดิวถัดไป</th>
                            <th class="text-center">สถานะ</th>
                            <th class="text-right" style="width: 30px"></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($data1_1 as $key => $row)
                            @php 
                              if($row->legispayments != NULL){
                                $SetDateDue = date_create($row->legispayments->DateDue_Payment);
                                @$DateDuePayment = date_format($SetDateDue, 'd-m-Y'); 
                              }else{
                                @$DateDuePayment = NULL;
                              }
                            @endphp
                            <tr>
                              <td class="text-left"> {{$row->Contract_legis}}</td>
                              <td class="text-left"> {{$row->Name_legis}} </td>
                              <td class="text-center">
                              <span >{{ date_format(date_create(@$row->legisCompromise->Date_Promise), 'Ymd')}} </span>  
                              {{formatDateThai(@$row->legisCompromise->Date_Promise)}}</td>
                              <td class="text-right">{{(@$row->legisCompromise->Total_Promise != 0) ?number_format(@$row->legisCompromise->Total_Promise, 2): '-' }}</td>
                              <td class="text-right">{{(@$row->legisCompromise->Sum_Promise != 0) ?number_format(@$row->legisCompromise->Sum_Promise, 2): '-' }}</td>
                              <td class="text-center"> <span >{{ date_format(date_create(@$row->legispayments->Date_Payment), 'Ymd')}} </span> {{formatDateThai(@$row->legispayments->Date_Payment)}}</td>
                              <td class="text-center">
                              <span >{{ date_format(date_create(@$row->legispayments->DateDue_Payment), 'Ymd')}} </span>  
                                 {{(@$DateDuePayment != NULL) ?formatDateThai(@$DateDuePayment): '-' }} </td>
                              <td class="text-right">
                                @if(@$row->legisCompromise->FirstManey_1 != 0)
                                  @if($row->legisCompromise->Sum_FirstPromise >= str_replace (",","",@$row->legisCompromise->FirstManey_1))
                                    <button data-toggle="tooltip" type="button" class="btn btn-success btn-sm hover-up" title="ครบชำระเงินก้อนแรก">
                                      <i class="fas fa-hands-helping prem"></i>
                                    </button>
                                  @else
                                    <button data-toggle="tooltip" type="button" class="btn btn-danger btn-sm hover-up" title="ขาดชำระเงินก้อนแรก">
                                      <i class="fas fa-hand-holding-usd prem"></i>
                                    </button>
                                  @endif
                                @elseif (@$row->legisCompromise->Payall_Promise != 0)
                                  @if($row->legisCompromise->Sum_FirstPromise >= str_replace (",","",@$row->legisCompromise->Payall_Promise))
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
                              </td>
                              <td class="text-right">
                                <a href="{{ route('MasterCompro.edit',[$row->id]) }}?type={{$type}}" class="btn btn-warning btn-sm hover-up" title="แก้ไขรายการ">
                                  <i class="far fa-edit"></i>
                                </a>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                  </div>
                  <div id="list-page3-list" class="tab-pane fade">
                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText font12">ขาดชำระ 2 งวด  <span class="textHeader">(Missing 2 Installment)</span></h6>
                      <table class="table table-hover SizeText font12 dateHide" id="table33">
                        <thead>
                          <tr>
                            <th class="text-center">เลขที่สัญญา</th>
                            <th class="text-center">ชื่อ-สกุล</th>
                            <th class="text-center">เริ่มประนอม</th>
                            <th class="text-center">ยอดประนอม</th>
                            <th class="text-center">ยอดคงเหลือ</th>
                            <th class="text-center">วันที่ชำระล่าสุด</th>
                            <th class="text-center">วันดิวถัดไป</th>
                            <th class="text-center">สถานะ</th>
                            <th class="text-right" style="width: 30px"></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($data1_2 as $key => $row)
                            @php 
                              if($row->legispayments != NULL){
                                $SetDateDue = date_create($row->legispayments->DateDue_Payment);
                                @$DateDuePayment = date_format($SetDateDue, 'd-m-Y'); 
                              }else{
                                @$DateDuePayment = NULL;
                              }
                            @endphp
                            <tr>
                              <td class="text-left"> {{$row->Contract_legis}}</td>
                              <td class="text-left"> {{$row->Name_legis}} </td>
                              <td class="text-center"> 
                              <span >{{ date_format(date_create(@$row->legisCompromise->Date_Promise), 'Ymd')}} </span>    
                              {{formatDateThai(@$row->legisCompromise->Date_Promise)}}</td>
                              <td class="text-right">{{(@$row->legisCompromise->Total_Promise != 0) ?number_format(@$row->legisCompromise->Total_Promise, 2): '-' }}</td>
                              <td class="text-right">{{(@$row->legisCompromise->Sum_Promise != 0) ?number_format(@$row->legisCompromise->Sum_Promise, 2): '-' }}</td>
                              <td class="text-center"><span >{{ date_format(date_create(@$row->legispayments->Date_Payment), 'Ymd')}} </span>  {{formatDateThai(@$row->legispayments->Date_Payment)}}</td>
                              <td class="text-center">
                              <span >{{ date_format(date_create(@$row->legispayments->DateDue_Payment), 'Ymd')}} </span> 
                                {{(@$DateDuePayment != NULL) ?formatDateThai(@$DateDuePayment): '-' }} </td>
                              <td class="text-right">
                                @if(@$row->legisCompromise->FirstManey_1 != 0)
                                  @if($row->legisCompromise->Sum_FirstPromise >= str_replace (",","",@$row->legisCompromise->FirstManey_1))
                                    <button data-toggle="tooltip" type="button" class="btn btn-success btn-sm hover-up" title="ครบชำระเงินก้อนแรก">
                                      <i class="fas fa-hands-helping prem"></i>
                                    </button>
                                  @else
                                    <button data-toggle="tooltip" type="button" class="btn btn-danger btn-sm hover-up" title="ขาดชำระเงินก้อนแรก">
                                      <i class="fas fa-hand-holding-usd prem"></i>
                                    </button>
                                  @endif
                                @elseif (@$row->legisCompromise->Payall_Promise != 0)
                                  @if($row->legisCompromise->Sum_FirstPromise >= str_replace (",","",@$row->legisCompromise->Payall_Promise))
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

                              </td>
                              <td class="text-right">
                                <a href="{{ route('MasterCompro.edit',[$row->id]) }}?type={{$type}}" class="btn btn-warning btn-sm hover-up" title="แก้ไขรายการ">
                                  <i class="far fa-edit"></i>
                                </a>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                  </div>
                  <div id="list-page4-list" class="tab-pane fade">
                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText font12">ขาดชำระ 3 งวด  <span class="textHeader">(Missing 3 Installment)</span></h6>
                      <table class="table table-hover SizeText font12 dateHide" id="table44">
                        <thead>
                          <tr>
                            <th class="text-center">เลขที่สัญญา</th>
                            <th class="text-center">ชื่อ-สกุล</th>
                            <th class="text-center">เริ่มประนอม</th>
                            <th class="text-center">ยอดประนอม</th>
                            <th class="text-center">ยอดคงเหลือ</th>
                            <th class="text-center">วันที่ชำระล่าสุด</th>
                            <th class="text-center">วันดิวถัดไป</th>
                            <th class="text-center">สถานะ</th>
                            <th class="text-right" style="width: 30px"></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($data1_3 as $key => $row)
                            @php 
                              if($row->legispayments != NULL){
                                $SetDateDue = date_create($row->legispayments->DateDue_Payment);
                                @$DateDuePayment = date_format($SetDateDue, 'd-m-Y'); 
                              }else{
                                @$DateDuePayment = NULL;
                              }
                            @endphp
                            <tr>
                              <td class="text-left"> {{$row->Contract_legis}}</td>
                              <td class="text-left"> {{$row->Name_legis}} </td>
                              <td class="text-center"> 
                              <span >{{ date_format(date_create(@$row->legisCompromise->Date_Promise), 'Ymd')}} </span>   
                              {{formatDateThai(@$row->legisCompromise->Date_Promise)}}</td>
                              <td class="text-right">{{(@$row->legisCompromise->Total_Promise != 0) ?number_format(@$row->legisCompromise->Total_Promise, 2): '-' }}</td>
                              <td class="text-right">{{(@$row->legisCompromise->Sum_Promise != 0) ?number_format(@$row->legisCompromise->Sum_Promise, 2): '-' }}</td>
                              <td class="text-center"><span >{{ date_format(date_create(@$row->legispayments->Date_Payment), 'Ymd')}} </span>  {{formatDateThai(@$row->legispayments->Date_Payment)}}</td>
                              <td class="text-center">
                              <span >{{ date_format(date_create(@$row->legispayments->DateDue_Payment), 'Ymd')}} </span>  
                                {{(@$DateDuePayment != NULL) ?formatDateThai(@$DateDuePayment): '-' }} </td>
                              <td class="text-right">
                                @if(@$row->legisCompromise->FirstManey_1 != 0)
                                  @if($row->legisCompromise->Sum_FirstPromise >= str_replace (",","",@$row->legisCompromise->FirstManey_1))
                                    <button data-toggle="tooltip" type="button" class="btn btn-success btn-sm hover-up" title="ครบชำระเงินก้อนแรก">
                                      <i class="fas fa-hands-helping prem"></i>
                                    </button>
                                  @else
                                    <button data-toggle="tooltip" type="button" class="btn btn-danger btn-sm hover-up" title="ขาดชำระเงินก้อนแรก">
                                      <i class="fas fa-hand-holding-usd prem"></i>
                                    </button>
                                  @endif
                                @elseif (@$row->legisCompromise->Payall_Promise != 0)
                                  @if($row->legisCompromise->Sum_FirstPromise >= str_replace (",","",@$row->legisCompromise->Payall_Promise))
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

                              </td>
                              <td class="text-right">
                                <a href="{{ route('MasterCompro.edit',[$row->id]) }}?type={{$type}}" class="btn btn-warning btn-sm hover-up" title="แก้ไขรายการ">
                                  <i class="far fa-edit"></i>
                                </a>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                  </div>
                  <div id="list-page6-list" class="tab-pane fade">
                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText font12">ขาดชำระ 3 งวดขึ้นไป  <span class="textHeader">(Missing More 3 Installment)</span></h6>
                      <table class="table table-hover SizeText font12 dateHide" id="table66">
                        <thead>
                          <tr>
                            <th class="text-center">เลขที่สัญญา</th>
                            <th class="text-center">ชื่อ-สกุล</th>
                            <th class="text-center">เริ่มประนอม</th>
                            <th class="text-center">ค้างงวด</th>
                            <th class="text-center">ยอดประนอม</th>
                            <th class="text-center">ยอดคงเหลือ</th>
                            <th class="text-center">วันที่ชำระล่าสุด</th>
                            <th class="text-center">วันดิวถัดไป</th>
                            <th class="text-center">สถานะ</th>
                            <th class="text-right" style="width: 30px"></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($data1_4 as $key => $row)
                            @php 
                              if($row->legispayments != NULL){
                                $SetDateDue = date_create($row->legispayments->DateDue_Payment);
                                @$DateDuePayment = date_format($SetDateDue, 'd-m-Y'); 
                              }else{
                                @$DateDuePayment = NULL;
                              }
                            @endphp
                            <tr>
                              <td class="text-left"> {{$row->Contract_legis}}</td>
                              <td class="text-left"> {{$row->Name_legis}} </td>
                              <td class="text-center">
                              <span >{{ date_format(date_create(@$row->legisCompromise->Date_Promise), 'Ymd')}} </span>    
                              {{formatDateThai(@$row->legisCompromise->Date_Promise)}}</td>
                              <td class="text-center"> 
                                @php
                                  if ($row->legispayments != NULL){
                                    if ($row->legispayments->DateDue_Payment < date('Y-m-d')) {
                                      $DateDue = date_create($row->legispayments->DateDue_Payment);
                                      $Date = date_create(date('Y-m-d'));
                                      $Datediff = date_diff($DateDue,$Date);
                                      
                                      if($Datediff->y != NULL) {
                                        $SetYear = ($Datediff->y * 12);
                                      }else{
                                        $SetYear = NULL;
                                      }
                                      $DueCus = ($SetYear + $Datediff->m);
                                    }
                                    else{
                                      $DueCus = NULL;
                                    }
                                  }
                                  else{
                                    $DueCus = NULL;
                                  }
                                @endphp
                                {{ $DueCus }} 
                              </td>
                              <td class="text-right">{{(@$row->legisCompromise->Total_Promise != 0) ?number_format(@$row->legisCompromise->Total_Promise, 2): '-' }}</td>
                              <td class="text-right">{{(@$row->legisCompromise->Sum_Promise != 0) ?number_format(@$row->legisCompromise->Sum_Promise, 2): '-' }}</td>
                              <td class="text-center"><span >{{ date_format(date_create(@$row->legispayments->Date_Payment), 'Ymd')}} </span>  {{formatDateThai(@$row->legispayments->Date_Payment)}}</td>
                              <td class="text-center"> 
                              <span >{{ date_format(date_create(@$row->legispayments->DateDue_Payment), 'Ymd')}} </span>    
                              {{(@$DateDuePayment != NULL) ?formatDateThai(@$DateDuePayment): '-' }} </td>
                              <td class="text-right">
                                @if(@$row->legisCompromise->FirstManey_1 != 0)
                                  @if($row->legisCompromise->Sum_FirstPromise >= str_replace (",","",@$row->legisCompromise->FirstManey_1))
                                    <button data-toggle="tooltip" type="button" class="btn btn-success btn-sm hover-up" title="ครบชำระเงินก้อนแรก">
                                      <i class="fas fa-hands-helping prem"></i>
                                    </button>
                                  @else
                                    <button data-toggle="tooltip" type="button" class="btn btn-danger btn-sm hover-up" title="ขาดชำระเงินก้อนแรก">
                                      <i class="fas fa-hand-holding-usd prem"></i>
                                    </button>
                                  @endif
                                @elseif (@$row->legisCompromise->Payall_Promise != 0)
                                  @if($row->legisCompromise->Sum_FirstPromise >= str_replace (",","",@$row->legisCompromise->Payall_Promise))
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

                              </td>
                              <td class="text-right">
                                <a href="{{ route('MasterCompro.edit',[$row->id]) }}?type={{$type}}" class="btn btn-warning btn-sm hover-up" title="แก้ไขรายการ">
                                  <i class="far fa-edit"></i>
                                </a>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                  </div>
                  
                    <div id="list-page5-list" class="tab-pane fade">
                      <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText font12">ไม่มีข้อมูลประนอมหนี้  <span class="textHeader">(New Customers)</span></h6>
                        <table class="table table-hover SizeText font12 dateHide2" id="table55">
                          <thead>
                            <tr>
                              <th class="text-center">เลขที่สัญญา</th>
                              <th class="text-center">ประเภทสัญญา</th>
                              <th class="text-center">ชื่อ-สกุล</th>
                              <th class="text-center">วันที่ประนอม</th>
                              <th class="text-center">สถานะ</th>
                              <th class="text-right" style="width: 30px"></th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($NullData as $key => $row)

                                  @php
                                  if(@$row->legisCompromise->Date_Promise!=NULL){
                                    $SetDate = @$row->legisCompromise->Date_Promise; 
                                    
                                  }else{
                                    $SetDate = NULL;
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
                                    $DateShow = 'รอเข้ามาชำระ';
                                  }
                                }else{
                                  $Tag = 'Closest';
                                  $DateShow = 'เลยกำหนดการ';
                                }
                                
                              @endphp
                              <tr>
                                <td class="text-left"> {{$row->Contract_legis}}</td>
                                <td class="text-center"> {{$row->TypeCon_legis}}</td>
                                <td class="text-left"> {{$row->Name_legis}} </td>
                                <td class="text-center"> 
                                  <p >{{ date_format(date_create(@$row->legisCompromise->Date_Promise), 'Ymd')}} </p>    
                                  {{formatDateThai(@$row->legisCompromise->Date_Promise)}}
                                </td>
                                    
                                <td class="text-left"> 
                                  @if($Tag == 'Active')
                                    <span class="btn-outline-warning btn-sm hover-up mr-2">
                                      <i class="far fa-calendar-alt prem"></i>
                                    </span>
                                    <span class="textSize text-warning">กำหนดงวดเเรก {{$DateShow}}</span>
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
                                  <a href="{{ route('MasterCompro.edit',[$row->id]) }}?type={{$type}}" class="btn btn-warning btn-sm hover-up" title="แก้ไขรายการ">
                                    <i class="far fa-edit"></i>
                                  </a>
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                    </div>
                    @if($type == 3)
                    <div id="list-page6-list" class="tab-pane fade">
                      <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText font12">ปิดจบประนอม  <span class="textHeader">(End Compounded)</span></h6>
                        <table class="table table-hover SizeText font12 dateHide" id="table66">
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
                            @foreach($dataEndcaseOld as $key => $row)
                              <tr>
                                <td class="text-center"> {{$key+1}}</td>
                                <td class="text-center"> {{$row->Contract_legis}}</td>
                                <td class="text-left"> {{$row->Name_legis}} </td>
                                <td class="text-center"> {{ number_format(@$row->legisCompromise->Total_Promise, 2) }} </td>
                                <td class="text-center">
                                  @if($row->Status_legis != NULL)
                                    <button class="btn btn-success btn-xs SizeText font12" data-toggle="tooltip" data-placement="top" title="ปิดจบงานแล้ว">
                                      <i class="fas fa-user-check pr-1 prem"></i>
                                      <span class="SizeText-1">{{$row->Status_legis}}</span>
                                    </button>
                                  @endif
                                </td>
                                <td class="text-center">
                                <span >{{ date_format(date_create(@$row->DateStatus_legis), 'Ymd')}} </span>
                                  <!-- <button class="btn btn-success btn-xs SizeText font12" title="ปิดจบงานแล้ว"> -->
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
                  @endif
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

  {{-- Date Rang --}}
  <script type="text/javascript">
      $('input[name="dateSearch"]').daterangepicker({
          timePicker: true,
          timePicker24Hour: true,
          timePickerIncrement: 30,
          locale: {
              format: 'DD-MM-YYYY'
          }
      });
  </script>

  <script type="text/javascript">
    $(document).ready(function(){
      $("#list-page1-list").on("click", function(){
          $("#flag").val(1);
      });
      $("#list-page2-list").on("click", function(){
          $("#flag").val(2);
      });
      $("#list-page3-list").on("click", function(){
          $("#flag").val(3);
      });
      $("#list-page4-list").on("click", function(){
          $("#flag").val(4);
      });
      $("#list-page5-list").on("click", function(){
          $("#flag").val(5);
      });
      $("#list-page6-list").on("click", function(){
          $("#flag").val(6);
      });
    });
  </script>
@endsection

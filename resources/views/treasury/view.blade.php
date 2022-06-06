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
        @if($type == 1)
          <div class="row">
            <div class="col-8">
              <div class="form-inline">
                  <h5>รายการขอเบิกเงิน <small class="textHeader">(Legislation Expenses)</small></h5>
              </div>
            </div>
            <div class="col-4">
              <form method="get" action="{{ route('MasterTreasury.index') }}">
                <input type="hidden" name="type" value="1">
                <input type="hidden" name="FlagTab" id="FlagTab">

                <div class="card-tools d-inline float-right btn-page">
                  <div class="input-group form-inline">
                    <span class="text-right mr-sm-1">วันที่ : </span>
                    <input type="text" id="dateSearch" name="dateSearch" value="{{ ($dateSearch != '') ?$dateSearch: '' }}" class="form-control form-control-sm textSize" placeholder="วันที - ถึงวันที่">
                    <span class="input-group-append">
                      <button type="submit" class="btn btn-info btn-sm button-id mr-sm-1">
                        <i class="fas fa-search"></i>
                      </button>
                    </span>
                    <button class="btn btn-info btn-sm hover-up disabled" data-toggle="dropdown">
                      <i class="fas fa-print"></i>
                    </button>
                    <ul class="dropdown-menu text-sm" role="menu">
                      <li><a target="_blank" class="dropdown-item" data-toggle="modal" data-target="#modal-new" data-link="#"> รายงาน บันทึกติดตาม</a></li>
                      <li class="dropdown-divider"></li>
                      <li><a target="_blank" href="#" class="dropdown-item"> รายงาน ลูกค้าขาดติดตาม</a></li>
                    </ul>
                  </div>
                </div>
              </form>
            </div>
          </div>
        @elseif($type == 2)
          <div class="row">
            <div class="col-8">
              <div class="form-inline">
                  <h5>รายการขอเบิกสำรองจ่าย <small class="textHeader">(Legislation Expenses)</small></h5>
              </div>
            </div>
            <div class="col-4">
              <form method="get" action="{{ route('MasterTreasury.index') }}">
                <input type="hidden" name="type" value="2">
                <input type="hidden" name="FlagTab" id="FlagTab">

                <div class="card-tools d-inline float-right btn-page">
                  <div class="input-group form-inline">
                    <span class="text-right mr-sm-1">วันที่ : </span>
                    <input type="text" id="dateSearch" name="dateSearch" value="{{ ($dateSearch != '') ?$dateSearch: '' }}" class="form-control form-control-sm textSize" placeholder="วันที - ถึงวันที่">
                    <span class="input-group-append">
                      <button type="submit" class="btn btn-info btn-sm button-id mr-sm-1">
                        <i class="fas fa-search"></i>
                      </button>
                    </span>
                    <button class="btn btn-info btn-sm hover-up disabled" data-toggle="dropdown">
                      <i class="fas fa-print"></i>
                    </button>
                    <ul class="dropdown-menu text-sm" role="menu">
                      <li><a target="_blank" class="dropdown-item" data-toggle="modal" data-target="#modal-new" data-link="#"> รายงาน บันทึกติดตาม</a></li>
                      <li class="dropdown-divider"></li>
                      <li><a target="_blank" href="#" class="dropdown-item"> รายงาน ลูกค้าขาดติดตาม</a></li>
                    </ul>
                  </div>
                </div>
              </form>
            </div>
          </div>
        @elseif($type == 3)
          <div class="row">
            <div class="col-8">
              <div class="form-inline">
                  <h5>รายการขอเบิกค่าของกลาง <small class="textHeader">(Legislation Expenses)</small></h5>
              </div>
            </div>
            <div class="col-4">
              <form method="get" action="{{ route('MasterTreasury.index') }}">
                <input type="hidden" name="type" value="3">
                <input type="hidden" name="FlagTab" id="FlagTab">

                <div class="card-tools d-inline float-right btn-page">
                  <div class="input-group form-inline">
                    <span class="text-right mr-sm-1">วันที่ : </span>
                    <input type="text" id="dateSearch" name="dateSearch" value="{{ ($dateSearch != '') ?$dateSearch: '' }}" class="form-control form-control-sm textSize" placeholder="วันที - ถึงวันที่">
                    <span class="input-group-append">
                      <button type="submit" class="btn btn-info btn-sm button-id mr-sm-1">
                        <i class="fas fa-search"></i>
                      </button>
                    </span>
                    <button class="btn btn-info btn-sm hover-up disabled" data-toggle="dropdown">
                      <i class="fas fa-print"></i>
                    </button>
                    <ul class="dropdown-menu text-sm" role="menu">
                      <li><a target="_blank" class="dropdown-item" data-toggle="modal" data-target="#modal-new" data-link="#"> รายงาน บันทึกติดตาม</a></li>
                      <li class="dropdown-divider"></li>
                      <li><a target="_blank" href="#" class="dropdown-item"> รายงาน ลูกค้าขาดติดตาม</a></li>
                    </ul>
                  </div>
                </div>
              </form>
            </div>
          </div>
        @endif
      </div>
      <div class="row">
        @if($type == 1)
          <div class="col-lg-3">
            <div class="box-shadow">
              <div class="author-card pb-3 pt-3">
                <span class="text-right textHeader-1">
                  <i class="mr-3 text-muted"></i> 
                    รายการทั้งหมด (<b><span class="text-red">{{count($data1)+count($data2)}}</span></b>)
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
                        <i class="fas fa-caret-right mr-1 text-muted"></i>
                        <div class="d-inline-block font-weight-medium text-uppercase">ค่าใช้จ่าย(ภายในศาล)</div>
                      </div>
                        @if(count($data1) != 0)
                          <span class="badge bg-danger">{{count($data1)}}</span>
                        @endif
                    </div>
                  </a>
                  <a class="list-group-item hover-up @if(isset($FlagTab)) {{($FlagTab == 2) ? 'active' : '' }} @endif" id="vert-tabs-02-tab" data-toggle="tab" href="#list-page2-list">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <i class="fas fa-caret-right text-muted"></i>
                        <div class="d-inline-block font-weight-medium text-uppercase">ค่าใช้จ่าย(ค่าพิเศษ)</div>
                      </div>
                        @if(count($data2) != 0)
                          <span class="badge bg-danger">{{count($data2)}}</span>
                        @endif
                    </div>
                  </a>
                </nav>
              </div>
            </div>
          </div>
          <div class="col-lg-9">
              <div class="tab-content">
                <div id="list-page1-list" class="container tab-pane SizeText @if(isset($FlagTab)) {{($FlagTab == 1) ? 'active' : '' }} @else active @endif">
                  <form method="get" action="{{ route('MasterTreasury.create') }}">
                    <h6 class="m-b-20 p-b-5 b-b-default SubHeading">ค่าใช้จ่ายภายในศาล</h6>
                    <div class="form-inline float-right Button">
                        <div class="input-group">
                            <label class="pr-1">ยอดรวม: </label>
                            <input type="text" class="form-control form-control-sm text-red mr-sm-1" size="6" value="{{@number_format($Sum1,0)}}" readonly/>
                            <input type="text" id="ShowSum1" class="form-control form-control-sm text-red" size="6" value="0" readonly/>
                            <div class="input-group-append">
                                <button type="submit" id="buttonSub1" class="btn btn-sm bg-green color-palette" title="ยืนยันการเบิก">
                                    <i class="fas fa-check"></i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                      <table class="table table-hover SizeText" id="table111">
                        <thead>
                          <tr>
                            <th class="text-center">เลขใบเสร็จ</th>
                            <th class="text-center">เลขที่สัญญา</th>
                            <th class="text-center">ชื่อ-สกุล</th>
                            <th class="text-center">เรื่อง</th>
                            <th class="text-center">วันที่ตั้งเบิก</th>
                            <th class="text-center">ยอดตั้งเบิก</th>
                            <th class="text-center" style="width: 50px">#</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($data1 as $key => $row)
                            <tr>
                              <td class="text-left">
                                <a target="_Blank" href="{{ route('MasterExpense.show',[$row->id]) }}?type={{4}}&Flagtype={{1}}&Groupcode={{$row->Code_expense}}" data-toggle="tooltip" data-placement="top" title="ปริ้นใบเสร็จ">
                                  @if($row->Flag_expense == 'wait')
                                    <Span class="text-red">{{$row->Receiptno_expense}}</Span>
                                  @elseif($row->Flag_expense == 'complete')
                                    <span class="text-success" data-toggle="tooltip" data-placement="left" title="วันอนุมัติ : {{FormatDatethai($row->DateApprove_expense)}}">
                                      {{$row->Receiptno_expense}}
                                    </span>
                                  @endif
                                </a>
                              </td>
                              <td class="text-left">{{$row->Contract_expense}}</td>
                              <td class="text-left">{{@$row->ExpenseTolegislation->Name_legis}}</td>
                              <td class="text-left">{{$row->Topic_expense}}</td>
                              <td class="text-center">{{date('d-m-Y',strtotime($row->Date_expense))}}</td>
                              <td class="text-right">{{@number_format($row->Amount_expense,0)}}</td>
                              <td class="text-center">
                                  <div class="icheck-green d-inline">
                                    <input type="checkbox" class="checkbox1" name="IDApp[]" value="{{$row->id}}" id="{{$row->id}}" {{ ($row->Flag_expense === 'complete') ? 'checked' : '' }}>
                                    <label for="{{$row->id}}"></label>
                                    <input type="hidden" name="ValueIDApp[{{$row->id}}]" value="{{$row->Amount_expense}}">
                                  </div>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                      <input type="hidden" name="type" value="1">
                      <input type="hidden" name="FlagTab" value="1">
                  </form>
                </div>
                <div id="list-page2-list" class="container tab-pane fade show SizeText @if(isset($FlagTab)) {{($FlagTab == 2) ? 'active' : '' }} @endif">
                  <form method="get" action="{{ route('MasterTreasury.create') }}">
                    <h6 class="m-b-20 p-b-5 b-b-default SubHeading ">ค่าใช้จ่ายค่าพิเศษ</h6>
                    <div class="form-inline float-right Button">
                        <div class="input-group">
                            <label class="pr-1">ยอดรวม: </label>
                            <input type="text" class="form-control form-control-sm text-red mr-sm-1" size="6" value="{{@number_format($Sum2,0)}}" readonly/>
                            <input type="text" id="ShowSum2" class="form-control form-control-sm text-red" size="6" value="0" readonly/>
                            <div class="input-group-append">
                                <button type="submit" id="buttonSub2" class="btn btn-sm bg-green color-palette" title="ยืนยันการเบิก">
                                    <i class="fas fa-check"></i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-hover SizeText" id="table222">
                      <thead>
                        <tr>
                          <th class="text-center">เลขใบเสร็จ</th>
                          <th class="text-center">จำนวนสัญญา</th>
                          <th class="text-center">เรื่อง</th>
                          <th class="text-center">วันที่ตั้งเบิก</th>
                          <th class="text-right">ยอดตั้งเบิก</th>
                          <th class="text-center" style="width: 50px">#</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($data2 as $key => $row)
                          <tr>
                            <td class="text-left">
                              <a target="_Blank" href="{{ route('MasterExpense.show',[0]) }}?type={{4}}&Flagtype={{($row->Total > 1)? 2:1}}&Groupcode={{$row->Code_expense}}" data-toggle="tooltip" data-placement="top" title="ปริ้นใบเสร็จ">
                                @if($row->Flag_expense == 'wait')
                                  <Span class="text-red">{{$row->Receiptno_expense}}</Span>
                                @elseif($row->Flag_expense == 'complete')
                                  <span class="text-success" data-toggle="tooltip" data-placement="left" title="วันอนุมัติ : {{FormatDatethai($row->DateApprove_expense)}}">
                                    {{$row->Receiptno_expense}}
                                  </span>
                                @endif
                              </a>
                              @if($row->Total > 1)
                                <button type="button" data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterExpense.show',[0]) }}?type={{2}}&Groupcode={{$row->Code_expense}}" class="btn btn-sm btn-tool hover-up" title="ดูรายเอียดมี {{$row->Total}} เลขที่สัญญา">
                                  <i class="fas fa-search text-red"></i>
                                </button>
                              @endif
                            </td>
                            <td class="text-center">{{$row->Total}} เลขสัญญา</td>
                            <td class="text-left">{{$row->Topic_expense}}</td>
                            <td class="text-center">{{date('d-m-Y',strtotime($row->Date_expense))}}</td>
                            <td class="text-right">{{@number_format($row->Amount_expense * $row->Total,0)}}</td>
                            <td class="text-right">
                                <div class="icheck-green d-inline">
                                  <input type="checkbox" class="checkbox2" name="IDApp2[]" value="{{$row->Code_expense}}" id="{{$row->Code_expense}}" {{ ($row->Flag_expense === 'complete') ? 'checked' : '' }}>
                                  <label for="{{$row->Code_expense}}"></label>
                                  <input type="hidden" name="ValueIDApp2[{{$row->Code_expense}}]" value="{{round($row->Amount_expense * $row->Total)}}">
                                </div>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                    <input type="hidden" name="type" value="2">
                    <input type="hidden" name="FlagTab" value="2">
                  </form>
                </div>
              </div> 
          </div>
        @elseif($type == 2)
          <div class="col-lg-3">
            <div class="box-shadow">
              <div class="author-card pb-3 pt-3">
                <span class="text-right textHeader-1">
                  <i class="mr-3 text-muted"></i> 
                    รายการทั้งหมด (<b><span class="text-red">{{count($data)}}</span></b>)
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
                        <i class="fas fa-caret-right mr-1 text-muted"></i>
                        <div class="d-inline-block font-weight-medium text-uppercase">ค่าเบิกสำรองจ่าย</div>
                      </div>
                        @if(count($data) != 0)
                          <span class="badge bg-danger">{{count($data)}}</span>
                        @endif
                    </div>
                  </a>
                </nav>
              </div>
            </div>
          </div>
          <div class="col-lg-9">
            <div class="tab-content">
              <div id="list-page1-list" class="container tab-pane SizeText @if(isset($FlagTab)) {{($FlagTab == 1) ? 'active' : '' }} @else active @endif">
                <form method="get" action="{{ route('MasterTreasury.create') }}">
                  <h6 class="m-b-20 p-b-5 b-b-default SubHeading">ค่าเบิกสำรองจ่าย</h6>
                  <div class="form-inline float-right Button">
                      <div class="input-group">
                          <label class="pr-1">ยอดรวม: </label>
                          <input type="text" class="form-control form-control-sm text-red mr-sm-1" size="6" value="{{@number_format($Sum,0)}}" readonly/>
                          <input type="text" id="ShowSum1" class="form-control form-control-sm text-red" size="6" value="0" readonly/>
                          <div class="input-group-append">
                              <button type="submit" id="buttonSub1" class="btn btn-sm bg-green color-palette" >
                                  <i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="ยืนยันอนุมัติ"></i></span>
                              </button>
                          </div>
                      </div>
                  </div>
                    <table class="table table-hover SizeText" id="table11">
                      <thead>
                        <tr>
                          <th class="text-center">เลขใบเสร็จ</th>
                          <!-- <th class="text-center">เรื่อง</th> -->
                          <th class="text-center">วันที่ตั้งเบิก</th>
                          <th class="text-center">ยอดตั้งเบิก</th>
                          <th class="text-center">ยอดใช้จริง</th>
                          <th class="text-center">ยอดคงเหลือ</th>
                          <th class="text-center">อนุมัติเงิน</th>
                          <th class="text-center">ตรวจสอบ</th> 
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($data as $key => $row)
                          <tr>
                            <td class="text-left">
                              <a target="_Blank" href="{{ route('MasterExpense.show',[$row->id]) }}?type={{4}}&Flagtype={{3}}&Groupcode={{$row->Code_expense}}" data-toggle="tooltip" data-placement="top" title="ปริ้นใบเสร็จ">
                                @if($row->Flag_expense == 'wait')
                                  <Span class="text-red">{{$row->Receiptno_expense}}</Span>
                                @elseif($row->Flag_expense == 'process')
                                  <span class="text-primary" data-toggle="tooltip" data-placement="left" title="วันอนุมัติเงิน : {{FormatDatethai($row->Transfer_expense)}}">
                                    {{$row->Receiptno_expense}}
                                  </span>
                                @elseif($row->Flag_expense == 'complete')
                                  <span class="text-success" data-toggle="tooltip" data-placement="left" title="วันตรวจสอบเงิน : {{FormatDatethai($row->DateApprove_expense)}}">
                                    {{$row->Receiptno_expense}}
                                  </span>
                                @endif
                              </a>
                            </td>
                            <!-- <td class="text-left">{{$row->Topic_expense}}</td> -->
                            <td class="text-center">{{date('d-m-Y',strtotime($row->Date_expense))}}</td>
                            <td class="text-center">{{@number_format($row->Amount_expense,0)}}</td>
                            <td class="text-center">{{@number_format($row->PayAmount_expense,0)}}</td>
                            <td class="text-center text-red">{{@number_format($row->BalanceAmount_expense,0)}}</td>
                            <td class="text-center">
                                <div class="icheck-green d-inline">
                                  <input type="checkbox" class="checkbox1" name="IDApp[]" value="{{$row->id}}" id="{{($row->Flag_expense === 'wait') ? $row->id : ''}}" {{ ($row->Flag_expense === 'process' or $row->Flag_expense === 'complete') ? 'checked' : '' }}>
                                  <label for="{{$row->id}}"></label>
                                  <input type="hidden" name="ValueIDApp[{{$row->id}}]" value="{{$row->Amount_expense}}">
                                </div>
                            </td>
                            <td class="text-center">
                              @if($row->Flag_expense == 'process' and $row->PayAmount_expense != NULL)
                                <button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterTreasury.show',[$row->id]) }}?type={{1}}"> 
                                  <i class="far fa-calendar-check" data-toggle="tooltip" data-placement="top" title="ตรวจสอบยอดใช้จ่ายจริง"></i> 
                                </button>
                              @elseif($row->Flag_expense == 'complete')
                                <button type="button" class="btn btn-xs btn-success" data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterTreasury.show',[$row->id]) }}?type={{1}}">
                                  <i class="far fa-calendar-check" data-toggle="tooltip" data-placement="top" title="ตรวจสอบแล้ว"></i>
                                </button>
                              @else 
                                <button type="button" class="btn btn-xs btn-default disabled"> <i class="far fa-calendar-check"></i> </button>
                              @endif
                            </td> 
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                    <input type="hidden" name="type" value="3">
                    <input type="hidden" name="FlagTab" value="1">
                </form>
              </div>
            </div> 
          </div>
        @elseif($type == 3)
          <div class="col-lg-3">
            <div class="box-shadow">
              <div class="author-card pb-3 pt-3">
                <span class="text-right textHeader-1">
                  <i class="mr-3 text-muted"></i> 
                    รายการทั้งหมด (<b><span class="text-red">{{count($data)}}</span></b>)
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
                        <i class="fas fa-caret-right mr-1 text-muted"></i>
                        <div class="d-inline-block font-weight-medium text-uppercase">ค่าของกลาง</div>
                      </div>
                        @if(count($data) != 0)
                          <span class="badge bg-danger">{{count($data)}}</span>
                        @endif
                    </div>
                  </a>
                </nav>
              </div>
            </div>
          </div>
          <div class="col-lg-9">
              <div class="tab-content">
                <div id="list-page1-list" class="container tab-pane SizeText @if(isset($FlagTab)) {{($FlagTab == 1) ? 'active' : '' }} @else active @endif">
                  <form method="get" action="{{ route('MasterTreasury.create') }}">
                    <h6 class="m-b-20 p-b-5 b-b-default SubHeading">ค่าใช้จ่ายภายในศาล</h6>
                    <div class="form-inline float-right Button">
                        <div class="input-group">
                            <label class="pr-1">ยอดรวม: </label>
                            <input type="text" class="form-control form-control-sm text-red mr-sm-1" size="6" value="{{@number_format($Sum,0)}}" readonly/>
                            <input type="text" id="ShowSum1" class="form-control form-control-sm text-red" size="6" value="0" readonly/>
                            <div class="input-group-append">
                                <button type="submit" id="buttonSub1" class="btn btn-sm bg-green color-palette" title="ยืนยันการเบิก">
                                    <i class="fas fa-check"></i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                      <table class="table table-hover SizeText" id="table111">
                        <thead>
                          <tr>
                            <th class="text-center">เลขใบเสร็จ</th>
                            <th class="text-center">เลขที่สัญญา</th>
                            <th class="text-center">ชื่อ-สกุล</th>
                            <th class="text-center">เรื่อง</th>
                            <th class="text-center">วันที่ตั้งเบิก</th>
                            <th class="text-center">ยอดตั้งเบิก</th>
                            <th class="text-center" style="width: 50px">#</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($data as $key => $row)
                            <tr>
                              <td class="text-left">
                                <a target="_Blank" href="{{ route('MasterExpense.show',[$row->id]) }}?type={{4}}&Flagtype={{4}}&Groupcode={{$row->Code_expense}}" data-toggle="tooltip" data-placement="top" title="ปริ้นใบเสร็จ">
                                  @if($row->Flag_expense == 'wait')
                                    <Span class="text-red">{{$row->Receiptno_expense}}</Span>
                                  @elseif($row->Flag_expense == 'complete')
                                    <span class="text-success" data-toggle="tooltip" data-placement="left" title="วันอนุมัติ : {{FormatDatethai($row->DateApprove_expense)}}">
                                      {{$row->Receiptno_expense}}
                                    </span>
                                  @endif
                                </a>
                              </td>
                              <td class="text-left">{{$row->Contract_expense}}</td>
                              <td class="text-left">{{@$row->ExpenseToExhibit->Name_legis}}</td>
                              <td class="text-left">{{$row->Topic_expense}}</td>
                              <td class="text-center">{{date('d-m-Y',strtotime($row->Date_expense))}}</td>
                              <td class="text-right">{{@number_format($row->Amount_expense,0)}}</td>
                              <td class="text-center">
                                  <div class="icheck-green d-inline">
                                    <input type="checkbox" class="checkbox1" name="IDApp[]" value="{{$row->id}}" id="{{$row->id}}" {{ ($row->Flag_expense === 'complete') ? 'checked' : '' }}>
                                    <label for="{{$row->id}}"></label>
                                    <input type="hidden" name="ValueIDApp[{{$row->id}}]" value="{{$row->Amount_expense}}">
                                  </div>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                      <input type="hidden" name="type" value="4">
                      <input type="hidden" name="FlagTab" value="1">
                  </form>
                </div>
              </div> 
          </div>
        @endif
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

  {{-- คำนวณยอด --}}
    <script>
        function addCommas(nStr){
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
        return x1 + x2;
        }
        
        $(document).ready(function(){
            $('#buttonSub1').attr("disabled", true);
            $('#buttonSub2').attr("disabled", true);

            $('.checkbox1').click(function(){
                var totalPrice = 0;
                $("input[name='IDApp[]']:checked").each(function(){
                    var getID = $(this).val();
                    var price = $('input[name="ValueIDApp['+getID+']"]').val();

                    totalPrice += Number(price);
                });
                $('#ShowSum1').val(addCommas(totalPrice));

                if($(this).prop("checked") == true){
                  $('#buttonSub1').removeAttr("disabled", true)
                }
                else if($(this).prop("checked") == false){
                  $('#buttonSub1').attr("disabled", true);
                }
            });
            $('.checkbox2').click(function(){
                var totalPrice2 = 0;
                $("input[name='IDApp2[]']:checked").each(function(){
                    var getID2 = $(this).val();
                    var price2 = $('input[name="ValueIDApp2['+getID2+']"]').val();

                    totalPrice2 += Number(price2);
                });
                $('#ShowSum2').val(addCommas(totalPrice2));

                if($(this).prop("checked") == true){
                  $('#buttonSub2').removeAttr("disabled", true)
                }
                else if($(this).prop("checked") == false){
                  $('#buttonSub2').attr("disabled", true);
                }
            });

        });
    </script>
@endsection

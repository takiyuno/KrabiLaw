@extends('layouts.master')
@section('title','กฏหมาย/ลูกหนี้ชั้นศาล')
@section('content')

  @if(session()->has('success'))
    <script type="text/javascript">
      toastr.success('{{ session()->get('success') }}')
    </script>
  @endif      
  @if (session()->has('FlagTab'))
    @php 
      $FlagTab = session()->get('FlagTab');
    @endphp
  @elseif (session()->has('FlagTab')) {
    @php
      $FlagTab = session('FlagTab');
    @endphp
  @endif

  <!-- Main content -->
  <section class="Profile-container" style="font-family: 'Prompt', sans-serif;">
    <div class="content">
      <div class="content-header">
        <div class="row">
          <div class="col-8">
            <div class="form-inline">
                <h5>ค่าใช้จ่ายกฎหมาย <small class="textHeader">(Legislation Expenses)</small></h5>
            </div>
          </div>
          <div class="col-4">
            <form method="get" action="{{ route('MasterExpense.index') }}?type={{1}}">
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
              <input type="hidden" name="FlagTab" id="FlagTab">
            </form>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3">
        <a class="btn btn-outline-info btn-block mb-3 text-info SizeText" data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterExpense.show',[0]) }}?type={{1}}" data-backdrop="static"><i class="far fa-plus-square"></i> เพิ่มรายการ</a>
          <div class="box-shadow">
            <div class="author-card pb-3 pt-3">
              <span class="text-right textHeader-1">
                <i class="mr-3 text-muted"></i> 
                  รายการทั้งหมด (<b><span class="text-red">{{count($data1)+count($data2)+count($data3)+count($data4)}}</span></b>)
              </span>
              <div class="author-card-profile">
                <div class="author-card-avatar">
              </div>
            </div>
          </div>
            <div class="wizard">
              <nav class="list-group list-group-flush" role="tablist">
                <a class="list-group-item hover-up @if(isset($FlagTab)) {{($FlagTab == 1) ? 'active' : '' }} @else active @endif " id="vert-tabs-01-tab" data-toggle="tab" href="#list-page1-list">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <i class="fas fa-user-tag mr-1 text-muted"></i>
                      <div class="d-inline-block font-weight-medium text-uppercase">ค่าใช้จ่าย(ภายในศาล)</div>
                    </div>
                      @if(count($data1) != 0)
                        <span class="badge bg-danger">{{count($data1)}}</span>
                      @endif
                  </div>
                </a>
                <a class="list-group-item hover-up @if(isset($FlagTab)) {{($FlagTab == 2) ? 'active' : '' }} @endif d-none" id="vert-tabs-02-tab" data-toggle="tab" href="#list-page2-list">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <i class="fas fa-user-tag mr-1 text-muted"></i>
                      <div class="d-inline-block font-weight-medium text-uppercase">ค่าใช้จ่าย(ค่าพิเศษ)</div>
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
                      <div class="d-inline-block font-weight-medium text-uppercase">เบิกสำรองจ่าย</div>
                    </div>
                      @if(count($data3) != 0)
                        <span class="badge bg-danger">{{count($data3)}}</span>
                      @endif
                  </div>
                </a>
                <a class="list-group-item hover-up @if(isset($FlagTab)) {{($FlagTab == 4) ? 'active' : '' }} @endif d-none" id="vert-tabs-04-tab" data-toggle="tab" href="#list-page4-list">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <i class="fas fa-user-tag mr-1 text-muted"></i>
                      <div class="d-inline-block font-weight-medium text-uppercase">ค่าของกลาง</div>
                    </div>
                      @if(count($data4) != 0)
                        <span class="badge bg-danger">{{count($data4)}}</span>
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
                <h6 class="m-b-20 p-b-5 b-b-default SubHeading">ค่าใช้จ่ายภายในศาล  <span class="textHeader text-red">(ยอดรวม: {{@number_format($Sum1,2)}})</span></h6>
                <!-- <button type="button" class="btn btn-sm bg-success SizeText Button" data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterExpense.show',[0]) }}?type={{1}}"  title="เพิ่มรายการค่าใช้จ่าย">
                  <i class="fas fa-plus"></i> เพิ่ม
                </button> -->
                  <table class="table table-hover SizeText" id="table11">
                    <thead>
                      <tr>
                        <!-- <th class="text-center" style="width: 10px">ลำดับ</th> -->
                        <th class="text-center">วันที่เบิก</th>
                        <th class="text-center">เลขใบเสร็จ</th>
                        <th class="text-center">เรื่อง</th>
                        <th class="text-center">เลขที่สัญญา</th>
                        <!-- <th class="text-center">ชื่อ-สกุล</th> -->
                        <th class="text-center">ค่าใช้จ่าย</th>
                        <th class="text-center">ผู้เบิก</th>
                        <!-- <th class="text-center" style="width: 150px">หมายเหตุ</th> -->
                        <th class="text-right">#</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data1 as $key => $row)
                        <tr>
                          <!-- <td class="text-center">{{$key+1}}</td> -->
                          <td class="text-center">{{date('d-m-Y',strtotime($row->Date_expense))}}</td>
                          <td class="text-left">
                            @if($row->Flag_expense == 'wait')
                              <Span class="text-red">{{$row->Receiptno_expense}}</Span>
                            @elseif($row->Flag_expense == 'complete')
                              <span class="text-success" data-toggle="tooltip" data-placement="top" title="วันอนุมัติ : {{FormatDatethai($row->DateApprove_expense)}}">
                                {{$row->Receiptno_expense}}
                              </span>
                            @endif
                          </td>
                          <td class="text-left">{{$row->Topic_expense}}</td>
                          <td class="text-left">{{$row->Contract_expense}}</td>
                          {{-- <td class="text-left">{{$row->ExpenseTolegislation->Name_legis}}</td> --}}
                          <td class="text-right">{{@number_format($row->Amount_expense,2)}}</td>
                          <!-- <td class="text-left">{{$row->Note_expense}}</td> -->
                          <td class="text-left">{{$row->Useradd_expense}}</td>
                          <td class="text-right">
                            <a target="_Blank" href="{{ route('MasterExpense.show',[$row->id]) }}?type={{4}}&Flagtype={{1}}&Groupcode={{$row->Code_expense}}" class="btn btn-primary btn-sm hover-up" data-toggle="tooltip" data-placement="top" title="ปริ้นใบเสร็จ">
                              <i class="fas fa-print"></i>
                            </a>
                            <a data-toggle="modal" data-target="#modal-edit" data-link="{{ route('MasterExpense.show',[$row->id]) }}?type={{3}}&Flagtype={{1}}&FlagTab={{1}}" class="btn btn-warning btn-sm hover-up {{ (auth::user()->type != 'Admin' and $row->Flag_expense != 'wait') ? 'disabled' : '' }}">
                              <i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="แก้ไขรายการ"></i>
                            </a>
                            @if(auth()->user()->position != "STAFF")
                            <form method="post" class="delete_form" action="{{ route('MasterExpense.destroy',[$row->id]) }}" style="display:inline;">
                            {{csrf_field()}}
                              <input type="hidden" name="type" value="1" />
                              <input type="hidden" name="FlagTab" value="1" />
                              <input type="hidden" name="_method" value="DELETE" />
                              <button type="submit" data-name="{{ $row->Receiptno_expense }}" class="delete-modal btn btn-danger btn-sm DeleteBook hover-up {{ ($row->Flag_expense == 'complete') ? 'disabled' : '' }}" data-toggle="tooltip" data-placement="top" title="ลบรายการ">
                                <i class="far fa-trash-alt"></i>
                              </button>
                            </form>
                            @endif
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
              </div>
              <div id="list-page2-list" class="container tab-pane fade show SizeText @if(isset($FlagTab)) {{($FlagTab == 2) ? 'active' : '' }} @endif">
                <h6 class="m-b-20 p-b-5 b-b-default SubHeading">ค่าใช้จ่ายค่าพิเศษ <span class="textHeader text-red">(ยอดรวม: {{@number_format($Sum2,2)}})</span></h6>
                  <table class="table table-hover SizeText" id="table22">
                    <thead>
                      <tr>
                        <!-- <th class="text-center" style="width: 10px">ลำดับ</th> -->
                        <th class="text-center">วันที่เบิก</th>
                        <th class="text-center" style="width: 150px">เลขใบเสร็จ</th>
                        <th class="text-center">เรื่อง</th>
                        <th class="text-center">จำนวนสัญญา</th>
                        <th class="text-right">ค่าใช้จ่าย</th>
                        <!-- <th class="text-center" style="width: 200px">หมายเหตุ</th> -->
                        <th class="text-center">ผู้เบิก</th>
                        <th class="text-right">#</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data2 as $key => $row)
                        <tr>
                          <!-- <td class="text-center">{{$key+1}}</td> -->
                          <td class="text-center">{{date('d-m-Y',strtotime($row->Date_expense))}}</td>
                          <td class="text-left">
                            @if($row->Flag_expense == 'wait')
                              <Span class="text-red">{{$row->Receiptno_expense}}</Span>
                            @elseif($row->Flag_expense == 'complete')
                              <span class="text-success" data-toggle="tooltip" data-placement="top" title="วันอนุมัติ : {{FormatDatethai($row->DateApprove_expense)}}">
                                {{$row->Receiptno_expense}}
                              </span>
                            @endif
                            @if($row->Total > 1)
                            <button type="button" data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterExpense.show',[0]) }}?type={{2}}&Groupcode={{$row->Code_expense}}" class="btn btn-sm btn-tool hover-up" title="ดูรายเอียดมี {{$row->Total}} เลขที่สัญญา">
                              <i class="fas fa-search text-red"></i>
                            </button>
                            @endif
                          </td>
                          <td class="text-left">{{$row->Topic_expense}}</td>
                          <td class="text-center">{{$row->Total}} เลขสัญญา</td>
                          <td class="text-right">{{@number_format($row->Amount_expense * $row->Total,2)}}</td>
                          <!-- <td class="text-left">{{$row->Note_expense}}</td> -->
                          <td class="text-left">{{$row->Useradd_expense}}</td>
                          <td class="text-right">
                            <a target="_Blank" href="{{ route('MasterExpense.show',[0]) }}?type={{4}}&Flagtype={{($row->Total > 0)? 2:1}}&Groupcode={{$row->Code_expense}}" class="btn btn-info btn-sm hover-up" data-toggle="tooltip" data-placement="top" title="ปริ้นใบเสร็จ">
                              <i class="fas fa-print"></i>
                            </a>
                            <a data-toggle="modal" data-target="#modal-edit" data-link="{{ route('MasterExpense.show',[$row->Code_expense]) }}?type={{3}}&Flagtype={{2}}&FlagTab={{2}}" class="btn btn-warning btn-sm hover-up {{ (auth::user()->type != 'Admin' and $row->Flag_expense != 'wait') ? 'disabled' : '' }}">
                              <i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="แก้ไขรายการ"></i>
                            </a>
                            @if(auth()->user()->position != "STAFF")
                            <form method="post" class="delete_form" action="{{ route('MasterExpense.destroy',[$row->Code_expense]) }}" style="display:inline;">
                            {{csrf_field()}}
                              <input type="hidden" name="type" value="2" />
                              <input type="hidden" name="FlagTab" value="2" />
                              <input type="hidden" name="_method" value="DELETE" />
                              <button type="submit" data-name="{{ $row->Receiptno_expense }}" class="delete-modal btn btn-danger btn-sm DeleteBook hover-up {{ ($row->Flag_expense == 'complete') ? 'disabled' : '' }}" data-toggle="tooltip" data-placement="top" title="ลบรายการ">
                                <i class="far fa-trash-alt"></i>
                              </button>
                            </form>
                            @endif
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
              </div>
              <div id="list-page3-list" class="container tab-pane fade show SizeText @if(isset($FlagTab)) {{($FlagTab == 3) ? 'active' : '' }} @endif">
                <h6 class="m-b-20 p-b-5 b-b-default SubHeading">ขอเบิกสำรองจ่าย <span class="textHeader text-red">(ยอดรวม: {{@number_format($Sum3,2)}})</span></h6>
                  <table class="table table-hover SizeText" id="table33">
                    <thead>
                      <tr>
                        <!-- <th class="text-center" style="width: 10px">ลำดับ</th> -->
                        <th class="text-center">วันที่เบิก</th>
                        <th class="text-center">เลขใบเสร็จ</th>
                        <th class="text-right">ยอดเบิก</th>
                        <th class="text-center">ใช้จริง</th>
                        <th class="text-center">คงเหลือ</th>
                        <th class="text-center">ผู้เบิก</th>
                        <th class="text-center">สถานะ</th>
                        <th class="text-center">#</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data3 as $key => $row)
                      @php 
                        if($row->PayAmount_expense != NULL){
                          $Balance = $row->Amount_expense - $row->PayAmount_expense;
                        }
                        else{
                          $Balance = $row->Amount_expense - $row->Amount_expense;
                        }
                      @endphp
                        <tr>
                          <!-- <td class="text-center">{{$key+1}}</td> -->
                          <td class="text-center">{{date('d-m-Y',strtotime($row->Date_expense))}}</td>
                          <td class="text-left">
                            @if($row->Flag_expense == 'wait')
                              <Span class="text-red">{{$row->Receiptno_expense}}</Span>
                            @elseif($row->Flag_expense == 'process')
                              <Span class="text-primary">{{$row->Receiptno_expense}}</Span>
                            @elseif($row->Flag_expense == 'complete')
                              <span class="text-success" data-toggle="tooltip" data-placement="top" title="วันอนุมัติ : {{FormatDatethai($row->DateApprove_expense)}}">
                                {{$row->Receiptno_expense}}
                              </span>
                            @endif
                          </td>
                          <td class="text-center">{{@number_format($row->Amount_expense,2)}}</td>
                          <td class="text-center">{{@number_format($row->PayAmount_expense,2)}}</td>
                          <td class="text-center text-red">{{@number_format($Balance,2)}}</td>
                          <td class="text-left">{{$row->Useradd_expense}}</td>
                          <td class="text-center">
                            <div class="icheck-primary d-inline" data-toggle="tooltip" data-placement="top" title="อนุมัติเงินแล้ว">
                              <input type="checkbox" {{($row->Flag_expense === 'process' or $row->Flag_expense === 'complete')?'checked':''}}>
                              <label for="checkboxPrimary1">
                                <!-- Primary -->
                              </label>
                            </div>
                            <div class="icheck-success d-inline" data-toggle="tooltip" data-placement="top" title="ตรวจสอบเงินแล้ว">
                              <input type="checkbox" {{($row->Flag_expense === 'complete')?'checked':''}}>
                              <label for="checkboxSuccess1">
                                <!-- Success -->
                              </label>
                            </div>
                          </td>
                          <td class="text-right">
                            <a target="_Blank" href="{{ route('MasterExpense.show',[$row->id]) }}?type={{4}}&Flagtype={{3}}&Groupcode={{$row->Code_expense}}" class="btn btn-primary btn-sm hover-up" data-toggle="tooltip" data-placement="top" title="ปริ้นใบเสร็จ">
                              <i class="fas fa-print"></i>
                            </a>
                            <!-- <a data-toggle="modal" data-target="#modal-edit" data-link="{{ route('MasterExpense.show',[$row->id]) }}?type={{3}}&Flagtype={{3}}&FlagTab={{3}}" class="btn btn-warning btn-sm hover-up {{ ($row->Flag_expense == 'complete') ? 'disabled' : '' }}"> -->
                            <a data-toggle="modal" data-target="#modal-edit" data-link="{{ route('MasterExpense.show',[$row->id]) }}?type={{3}}&Flagtype={{3}}&FlagTab={{3}}" class="btn btn-warning btn-sm hover-up {{ (auth::user()->type != 'Admin' and $row->Flag_expense == 'complete') ? 'disabled' : '' }}">
                              <i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="แก้ไขรายการ"></i>
                            </a>
                            @if(auth()->user()->position != "STAFF")
                            <form method="post" class="delete_form" action="{{ route('MasterExpense.destroy',[$row->id]) }}" style="display:inline;">
                            {{csrf_field()}}
                              <input type="hidden" name="type" value="1" />
                              <input type="hidden" name="FlagTab" value="1" />
                              <input type="hidden" name="_method" value="DELETE" />
                              <button type="submit" data-name="{{ $row->Receiptno_expense }}" class="delete-modal btn btn-danger btn-sm DeleteBook hover-up {{ ($row->Flag_expense == 'complete') ? 'disabled' : '' }}" data-toggle="tooltip" data-placement="top" title="ลบรายการ">
                                <i class="far fa-trash-alt"></i>
                              </button>
                            </form>
                            @endif
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
              </div>
              <div id="list-page4-list" class="container tab-pane SizeText @if(isset($FlagTab)) {{($FlagTab == 4) ? 'active' : '' }} @endif">
                <h6 class="m-b-20 p-b-5 b-b-default SubHeading">ค่าของกลาง  <span class="textHeader text-red">(ยอดรวม: {{@number_format($Sum4,2)}})</span></h6>
                <!-- <button type="button" class="btn btn-sm bg-success SizeText Button" data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterExpense.show',[0]) }}?type={{1}}"  title="เพิ่มรายการค่าใช้จ่าย">
                  <i class="fas fa-plus"></i> เพิ่ม
                </button> -->
                  <table class="table table-hover SizeText" id="table44">
                    <thead>
                      <tr>
                        <!-- <th class="text-center" style="width: 10px">ลำดับ</th> -->
                        <th class="text-center">วันที่เบิก</th>
                        <th class="text-center">เลขใบเสร็จ</th>
                        <th class="text-center">เรื่อง</th>
                        <th class="text-center">เลขที่สัญญา</th>
                        <!-- <th class="text-center">ชื่อ-สกุล</th> -->
                        <th class="text-center">ค่าใช้จ่าย</th>
                        <th class="text-center">ผู้เบิก</th>
                        <!-- <th class="text-center" style="width: 150px">หมายเหตุ</th> -->
                        <th class="text-right">#</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data4 as $key => $row)
                        <tr>
                          <!-- <td class="text-center">{{$key+1}}</td> -->
                          <td class="text-center">{{date('d-m-Y',strtotime($row->Date_expense))}}</td>
                          <td class="text-left">
                            @if($row->Flag_expense == 'wait')
                              <Span class="text-red">{{$row->Receiptno_expense}}</Span>
                            @elseif($row->Flag_expense == 'complete')
                              <span class="text-success" data-toggle="tooltip" data-placement="top" title="วันอนุมัติ : {{FormatDatethai($row->DateApprove_expense)}}">
                                {{$row->Receiptno_expense}}
                              </span>
                            @endif
                          </td>
                          <td class="text-left">{{$row->Topic_expense}}</td>
                          <td class="text-left">{{$row->Contract_expense}}</td>
                          <!-- <td class="text-left">{{$row->Name_legis}}</td> -->
                          <td class="text-right">{{@number_format($row->Amount_expense,2)}}</td>
                          <!-- <td class="text-left">{{$row->Note_expense}}</td> -->
                          <td class="text-left">{{$row->Useradd_expense}}</td>
                          <td class="text-right">
                            <a target="_Blank" href="{{ route('MasterExpense.show',[$row->id]) }}?type={{4}}&Flagtype={{4}}&Groupcode={{$row->Code_expense}}" class="btn btn-primary btn-sm hover-up" data-toggle="tooltip" data-placement="top" title="ปริ้นใบเสร็จ">
                              <i class="fas fa-print"></i>
                            </a>
                            <!-- <a data-toggle="modal" data-target="#modal-edit" data-link="{{ route('MasterExpense.show',[$row->id]) }}?type={{3}}&Flagtype={{4}}&FlagTab={{4}}" class="btn btn-warning btn-sm hover-up {{ ($row->Flag_expense != 'wait') ? 'disabled' : '' }}"> -->
                            <a data-toggle="modal" data-target="#modal-edit" data-link="{{ route('MasterExpense.show',[$row->id]) }}?type={{3}}&Flagtype={{4}}&FlagTab={{4}}" class="btn btn-warning btn-sm hover-up {{ (auth::user()->type != 'Admin' and $row->Flag_expense != 'wait') ? 'disabled' : '' }}">
                              <i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="แก้ไขรายการ"></i>
                            </a>
                            <form method="post" class="delete_form" action="{{ route('MasterExpense.destroy',[$row->id]) }}" style="display:inline;">
                            {{csrf_field()}}
                              <input type="hidden" name="type" value="1" />
                              <input type="hidden" name="FlagTab" value="1" />
                              <input type="hidden" name="_method" value="DELETE" />
                              <button type="submit" data-name="{{ $row->Receiptno_expense }}" class="delete-modal btn btn-danger btn-sm DeleteBook hover-up {{ ($row->Flag_expense == 'complete') ? 'disabled' : '' }}" data-toggle="tooltip" data-placement="top" title="ลบรายการ">
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
  <div class="modal fade" id="modal-edit">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
        </div>
      </div>
    </div>
  </div>
@endsection

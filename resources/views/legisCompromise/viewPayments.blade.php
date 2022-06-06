@extends('layouts.master')
@section('title','รายการรับชำระ')
@section('content')

<style>
  .font12{
    font-size: 12px;
  }
</style>

  <!-- Main content -->
  <section class="Profile-container" style="font-family: 'Prompt', sans-serif;">
      <div class="content">
        <div class="content-header">
          <div class="row">
            <div class="col-8">
              <div class="form-inline">
                  <h5>รายการรับชำระ <small class="textHeader">(New Payments)</small></h5>
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
                        <button type="submit" class="btn btn-info btn-sm button-id mr-sm-1" >
                          <i class="fas fa-search"></i>
                        </button>
                      </span>
                      <button class="btn btn-info btn-sm" data-toggle="dropdown">
                        <i class="fas fa-print"></i>
                      </button>
                      <ul class="dropdown-menu SizeText font12" role="menu">
                        <li><a target="_blank" class="dropdown-item" data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterCompro.create') }}?type={{1}}"> รายงาน รับชำระค่างวด</a></li>
                        <li class="dropdown-divider"></li>
                        <li><a target="_blank" class="dropdown-item" data-toggle="modal" data-target="#modal-Popup" data-link="{{ route('MasterCompro.create') }}?type={{2}}"> รายงาน ลูกหนี้ชำระตามดิว</a></li>
                      </ul>
                    </div>
                  </div>
                </ol>
                <input type="hidden" name="type" value="6"/>
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
                    รวมรับชำระ ( <b><font color="red">{{count($data1)+count($data2)}} </font></b> ราย )
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
                        <i class="fas fa-hand-holding-usd mr-1 text-success"></i>
                        <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ประนอมใหม่</div>
                      </div>
                        @if($data1 != NULL)
                          <span class="badge bg-danger">{{count($data1)}}</span>
                        @endif
                    </div>
                  </a>
                  <a class="list-group-item hover-up" data-toggle="tab" href="#list-page2-list">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <i class="fas fa-hand-holding-usd mr-1 text-primary"></i>
                        <div class="d-inline-block font-weight-medium text-uppercase">ลูกหนี้ประนอมเก่า</div>
                      </div>
                        @if($data2 != NULL)
                          <span class="badge bg-danger">{{count($data2)}}</span>
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
                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText font12">ประนอมหนี้ใหม่  <span class="textHeader">(New Compounding Debt)</span></h6>
                    <div class="form-inline float-right SumPayment">
                        <div class="input-group font12">
                            <label class="pr-1 SubHeading">ยอดรวม: </label>
                            <input type="text" class="form-control form-control-sm text-red mr-sm-1" size="8" value="{{number_format(@$SumData1,2)}}" readonly/>
                        </div>
                    </div>
                      <table class="table table-hover SizeText font12" id="table11">
                        <thead>
                          <tr>
                            <th class="text-center">เลขที่สัญญา</th>
                            <th class="text-center">ชื่อ-สกุล</th>
                            <th class="text-center">วันรับชำระ</th>
                            <th class="text-center">ประเภท</th>
                            <th class="text-center">ยอดชำระ</th>
                            <th class="text-center">ผู้รับ</th>
                            <th class="text-right"></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($data1 as $key => $row)
                            <tr>
                              <td class="text-center"> {{ $row->PaymentTolegislation->Contract_legis }}</td>
                              <td class="text-left"> {{ $row->PaymentTolegislation->Name_legis }} </td>
                              <td class="text-center"> {{ formatDateThai(substr($row->created_at,0,10)) }} </td>
                              <td class="text-center" title="{{ $row->Jobnumber_Payment}}"> {{ $row->Type_Payment }} </td>
                              <td class="text-right"> {{ number_format($row->Gold_Payment, 2) }} </td>
                              <td class="text-right"> {{$row->Adduser_Payment }} </td>
                              <td class="text-right" style="width: 10px;"> 
                                <a href="{{ route('MasterCompro.edit',[$row->PaymentTolegislation->id]) }}?type={{2}}" class="btn btn-warning btn-sm hover-up" title="แก้ไขรายการ">
                                  <i class="far fa-edit"></i>
                                </a>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                  </div>
                  <div id="list-page2-list" class="tab-pane fade">
                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText font12">ประนอมหนี้เก่า  <span class="textHeader">(Old Compounding Debt)</span></h6>
                    <div class="form-inline float-right SumPayment">
                        <div class="input-group font12">
                            <label class="pr-1 SubHeading">ยอดรวม: </label>
                            <input type="text" class="form-control form-control-sm text-red mr-sm-1" size="8" value="{{number_format(@$SumData2,2)}}" readonly/>
                        </div>
                    </div>  
                    <table class="table table-hover SizeText font12" id="table22">
                        <thead>
                          <tr>
                            <th class="text-center">เลขที่สัญญา</th>
                            <th class="text-center">ชื่อ-สกุล</th>
                            <th class="text-center">วันรับชำระ</th>
                            <th class="text-center">ประเภท</th>
                            <th class="text-center">ยอดชำระ</th>
                            <th class="text-center">ผู้รับ</th>
                            <th class="text-right"></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($data2 as $key => $row)
                            <tr>
                              <td class="text-center"> {{ $row->PaymentTolegislation->Contract_legis }}</td>
                              <td class="text-left"> {{ $row->PaymentTolegislation->Name_legis }} </td>
                              <td class="text-center"> {{ formatDateThai(substr($row->created_at,0,10)) }} </td>
                              <td class="text-center" title="{{ $row->Jobnumber_Payment}}"> {{ $row->Type_Payment }} </td>
                              <td class="text-right"> {{ number_format($row->Gold_Payment, 2) }} </td>
                              <td class="text-right"> {{$row->Adduser_Payment }} </td>
                              <td class="text-right" style="width: 10px;"> 
                                <a href="{{ route('MasterCompro.edit',[$row->PaymentTolegislation->id]) }}?type={{3}}" class="btn btn-warning btn-sm hover-up" title="แก้ไขรายการ">
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

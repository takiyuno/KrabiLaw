@extends('layouts.master')
@section('title','รายการติดตามลูกหนี้')
@section('content')

  @if(session()->has('success'))
    <script type="text/javascript">
      toastr.success('{{ session()->get('success') }}')
    </script>
  @endif

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
                  <h5>รายการติดตามลูกหนี้ <small class="textHeader">(TrackingsDebt)</small></h5>
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
                    ติดตามรวม ( <b><font color="red">{{count($dataY)+count($dataC)}} </font></b> ราย )
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
                        <div class="d-inline-block font-weight-medium text-uppercase">แจ้งติดตามประนอมใหม่</div>
                      </div>
                        @if($dataY != NULL)
                          <span class="badge bg-danger">{{count($dataY)}}</span>
                        @endif
                    </div>
                  </a>
                  <a class="list-group-item hover-up" data-toggle="tab" href="#list-page2-list">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <i class="fas fa-user-tag mr-1 text-primary"></i>
                        <div class="d-inline-block font-weight-medium text-uppercase">แจ้งติดตามประนอมเก่า</div>
                      </div>
                        @if($dataC != NULL)
                          <span class="badge bg-danger">{{count($dataC)}}</span>
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
                  <div id="list-page1-list" class="container tab-pane active">
                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText font12">ประนอมหนี้ใหม่  <span class="textHeader">(New Compounding Debt)</span></h6>
                      <table class="table table-hover SizeText font12" id="table11">
                        <thead>
                          <tr>
                            <th class="text-center">เลขที่สัญญา</th>
                            <th class="text-center">ชื่อ-สกุล</th>
                            <th class="text-center">วันชำระล่าสุด</th>
                            <th class="text-center">งวดค้าง</th>
                            <th class="text-center">สถานะ</th>
                            <th class="text-center">วันนัดชำระ</th>
                            <th class="text-center">แจ้งเตือน</th>
                            <th class="text-right" style="width: 30px"></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($dataY as $key => $row)
                            @php
                              if ($row->legisTrackings->DateDue_Track != NULL){
                                if ($row->legisTrackings->DateDue_Track > date('Y-m-d')) {
                                  $DateDue = date_create($row->legisTrackings->DateDue_Track);
                                  $Date = date_create(date('Y-m-d'));
                                  $Datediff = date_diff($DateDue,$Date);
                                  $DateNew = $Datediff->format("%a วัน");
                                }
                                else{
                                  $DateNew = NULL;
                                }
                              }
                              else{
                                $DateNew = NULL;
                              }
                            @endphp
                            <tr>
                              <td class="text-center"> {{$row->Contract_legis}}</td>
                              <td class="text-left"> {{$row->Name_legis}} </td>
                              <td class="text-center"> {{ date('d-m-Y', strtotime(substr($row->legispayments->created_at,0,10))) }} </td>
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
                              <td class="text-left" title="{{$row->legisTrackings->Detail_Track}}"> {{$row->legisTrackings->Subject_Track}} </td>
                              <td class="text-center"> {{ ($row->legisTrackings->DateDue_Track != NULL) ?formatDateThai($row->legisTrackings->DateDue_Track) : '-' }} </td>
                              <td class="text-center">
                                @if($DateNew != NULL)
                                  <span class="btn-outline-warning btn-sm hover-up mr-1 prem">
                                    <i class="far fa-calendar-alt"></i>
                                  </span>
                                  <span class="textSize text-warning">{{$DateNew}}</span>
                                @else
                                  <span class="btn-outline-danger btn-sm hover-up mr-1 prem">
                                    <i class="fas fa-exclamation-circle"></i>
                                  </span>
                                  <span class="textSize text-red">เลยกำหนดชำระ</span>
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
                  <div id="list-page2-list" class="container tab-pane fade">
                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600 SubHeading SizeText font12">ประนอมหนี้เก่า  <span class="textHeader">(Old Compounding Debt)</span></h6>
                      <table class="table table-hover SizeText font12" id="table22">
                        <thead>
                          <tr>
                            <th class="text-center">เลขที่สัญญา</th>
                            <th class="text-center">ชื่อ-สกุล</th>
                            <th class="text-center">วันที่ติดตาม</th>
                            <!-- <th class="text-center">วันชำระล่าสุด</th> -->
                            <th class="text-center">งวดค้าง</th>
                            <th class="text-center">สถานะ</th>
                            <th class="text-center">วันนัดชำระ</th>
                            <th class="text-center">แจ้งเตือน</th>
                            <th class="text-right" style="width: 30px"></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($dataC as $key => $row)
                            @php
                              if ($row->legisTrackings->DateDue_Track != NULL){
                                if ($row->legisTrackings->DateDue_Track > date('Y-m-d')) {
                                  $DateDue = date_create($row->legisTrackings->DateDue_Track);
                                  $Date = date_create(date('Y-m-d'));
                                  $Datediff = date_diff($DateDue,$Date);
                                  $DateNew = $Datediff->format("%a วัน");
                                }
                                else{
                                  $DateNew = NULL;
                                }
                              }
                              else{
                                $DateNew = NULL;
                              }
                            @endphp
                            <tr>
                              <td class="text-center"> {{$row->Contract_legis}}</td>
                              <td class="text-left"> {{$row->Name_legis}} </td>
                              <td class="text-center"> {{ date('d-m-Y', strtotime(substr($row->legisTrackings->created_at,0,10))) }} </td>
                              <!-- <td class="text-center"> {{ date('d-m-Y', strtotime(substr($row->legispayments->created_at,0,10))) }} -->
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
                              <td class="text-center" title="{{$row->legisTrackings->Detail_Track}}"> {{$row->legisTrackings->Subject_Track}} </td>
                              <td class="text-center"> {{ ($row->legisTrackings->DateDue_Track != NULL) ?formatDateThai($row->legisTrackings->DateDue_Track) : '-' }} </td>
                              <td class="text-center"> 
                                @if($DateNew != NULL)
                                  <span class="btn-outline-warning btn-sm hover-up mr-1 prem">
                                    <i class="far fa-calendar-alt"></i>
                                  </span>
                                  <span class="textSize text-warning">{{$DateNew}}</span>
                                @else
                                  <span class="btn-outline-danger btn-sm hover-up mr-1 prem">
                                    <i class="fas fa-exclamation-circle"></i>
                                  </span>
                                  <span class="textSize text-red">เลยกำหนดชำระ</span>
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

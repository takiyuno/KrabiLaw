@extends('layouts.master')
@section('title','Home')
@section('content')
<link rel="stylesheet" href="{{ asset('css/pluginLegislations.css') }}">
<link rel="stylesheet" href="{{ asset('css/pluginHomePage.css') }}">
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://apexcharts.com/samples/assets/stock-prices.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.15/lodash.min.js"></script>

  <div class="row InputSearch mb-2"  style="font-family: 'Prompt', sans-serif;">
    <div class="col-6">
      <h5 class="m-0 text-dark text-left">
        <i class="fa fa-dashboard text-muted"></i> 
        <a class="text-dark" href="{{ route('index','home') }}">Dashboard 1</a>
        <!-- |
        <a class="text-dark" href="{{ route('index','home') }}">Dashboard 2</a> -->
      </h5>
    </div>
    <div class="col-6">
      <form method="get" action="#" style="font-family: 'Prompt', sans-serif;">
        <input type="hidden" name="type" value="1">
        <input type="hidden" name="FlagTab" id="FlagTab">
        
        <div class="float-right form-inline btn-page SizeText">
              <div class="form-inline">
                <span class="text-right mr-sm-1">ข้อมูลวันที่ : </span>
                <input type="text" id="dateSearch" name="dateSearch" value="{{ (@$dateSearch != '') ?@$dateSearch: '' }}" class="form-control form-control-sm textSize mr-sm-1" placeholder="วันที - ถึงวันที่">
                <span class="input-group-append">
                  <button type="submit" class="btn btn-info btn-sm button-id mr-sm-1">
                    <i class="fas fa-search"></i>
                  </button>
                </span>
              </div>
        </div> 
      </form>
    </div>   
  </div>

  <div class="row"  style="font-family: 'Prompt', sans-serif;">
    <section class="col-lg-12 connectedSortable ui-sortable">
        <div class="col-12">
            <div id="icetab-container">
              @if($FlagTab == NULL)
              <div class="icetab {{(auth::user()->type == 'แผนก การเงินนอก' or auth::user()->type == 'แผนก เร่งรัด')? 'current-tab' : '' }}" id="vert-tabs-01-tab">
              @else 
              <div class="icetab {{($FlagTab == 1)? 'current-tab' : '' }}" id="vert-tabs-01-tab">
              @endif
                แจ้งเตือน
              </div>
              @if($FlagTab == NULL)
              <div class="icetab {{(auth::user()->type == 'Admin' or auth::user()->type == 'แผนก วิเคราะห์' or auth::user()->type == 'แผนก กฏหมาย')? 'current-tab' : '' }}" id="vert-tabs-02-tab">
              @else 
              <div class="icetab {{($FlagTab == 2)? 'current-tab' : '' }}" id="vert-tabs-02-tab">
              @endif
                งานฟ้อง
              </div>  
              @if($FlagTab == NULL)
              <div class="icetab" id="vert-tabs-03-tab">
              @else 
              <div class="icetab {{($FlagTab == 3)? 'current-tab' : '' }}" id="vert-tabs-03-tab">
              @endif
                ประนอมหนี้
              </div> 
              @if($FlagTab == NULL)
              <div class="icetab {{(auth::user()->type == 'แผนก การเงินใน')? 'current-tab' : ''}}" id="vert-tabs-04-tab">
              @else 
              <div class="icetab {{($FlagTab == 4)? 'current-tab' : '' }}" id="vert-tabs-04-tab">
              @endif 
                ค่าใช้จ่ายงานกฎหมาย
              </div>  
              @if($FlagTab == NULL)
              <div class="icetab" id="vert-tabs-05-tab">
              @else 
              <div class="icetab {{($FlagTab == 5)? 'current-tab' : '' }}" id="vert-tabs-05-tab">
              @endif 
                ลูกหนี้อื่นๆ
              </div>  
              <!-- <div class="icetab" id="vert-tabs-06-tab">
                ลูกหนี้ MONTHLY
              </div> -->
            </div>
            
            <div id="icetab-content">
                @if($FlagTab == NULL)
              <div class="tabcontent {{(auth::user()->type == 'แผนก การเงินนอก' or auth::user()->type == 'แผนก เร่งรัด')? 'tab-active' : '' }}">
                @else 
                <div class="tabcontent {{($FlagTab == 1)? 'tab-active' : '' }}">
                @endif
                <div class="py-2 mb-10">
                  <div class="row">
                    <div class="col-6">
                      <div class="row wrap-service-24 service-24">
                        <div class="col-lg-6 col-md-6">
                          <div class="card card-shadow border-0 mb-4">
                            <a href="{{ route('MasterCompro.index') }}?type={{4}}" class="card-hover py-4 text-center d-block rounded">
                              <span class="bg-success-grediant">{{$MissPay_pranom_new}}</span>
                              <h6 class="ser-title">แจ้งเตือนขาดชำระ. ประนอมใหม่</h6>
                            </a>
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                          <div class="card card-shadow border-0 mb-4">
                            <a href="{{ route('MasterCompro.index') }}?type={{4}}" class="card-hover py-4 text-center d-block rounded">
                              <span class="bg-success-grediant">{{$MissPay_pranom_old}}</span>
                              <h6 class="ser-title">แจ้งเตือนขาดชำระ. ประนอมเก่า</h6>
                            </a>
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                          <div class="card rounded card-shadow border-0 mb-4">
                            <a href="{{ route('MasterCompro.index') }}?type={{5}}" class="card-hover py-4 text-center d-block rounded">
                              <span class="bg-success-grediant">{{$Track_pranom_new}}</span>
                              <h6 class="ser-title">งานโทรเคลื่อนไหว. ประนอมใหม่</h6>
                            </a>
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                          <div class="card card-shadow border-0 mb-4">
                            <a href="{{ route('MasterCompro.index') }}?type={{5}}" class="card-hover py-4 text-center d-block rounded">
                              <span class="bg-success-grediant">{{$Track_pranom_old}}</span>
                              <h6 class="ser-title">งานโทรเคลื่อนไหว. ประนอมเก่า</h6>
                            </a>
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                          <div class="card card-shadow border-0 mb-4">
                            <a href="{{ route('MasterCompro.index') }}?type={{6}}" class="card-hover py-4 text-center d-block rounded">
                              <span class="bg-success-grediant">{{$dataGetpay_new}}</span>
                              <h6 class="ser-title">***รายการรับชำระ. ประนอมใหม่</h6>
                            </a>
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                          <div class="card card-shadow border-0 mb-4">
                            <a href="{{ route('MasterCompro.index') }}?type={{6}}" class="card-hover py-4 text-center d-block rounded">
                              <span class="bg-success-grediant">{{$dataGetpay_old}}</span>
                              <h6 class="ser-title">***รายการรับชำระ. ประนอมเก่า</h6>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="col-12 card box-shadow" style="height:400px;font-size:14px;">
                            <!-- <div class="card-header">
                              <h2 class="card-title SizeText"><b>*** เจ้าหน้าที่รับเงินประนอม</b></h2>
                            </div> -->
                            <!-- <div class="card-body"> -->
                              <table class="table table-bordered table-hover">
                                  <tr style="background-color:rgb(240, 241, 242);font-weight:bold;">
                                    <td>เจ้าหน้าที่รับเงินประนอม</td>
                                    <td>จำนวน(ราย)</td>
                                    <td>จำนวน(เงิน)</td>
                                  </tr>
                                  <tr>
                                    <td>บุปผา วงศ์สนิท</td>
                                    <td>{{$User1}}</td>
                                    <td><span class="badge bg-warning">{{number_format($SumUser1,2)}}</span></td>
                                  </tr>
                                  <tr>
                                    <td>ฮานีซะห์ ดือเระ</td>
                                    <td>{{$User2}}</td>
                                    <td><span class="badge bg-warning">{{number_format($SumUser2,2)}}</span></td>
                                  </tr>
                                  <tr>
                                    <td>กรองกาญจน์ เวชรักษ์</td>
                                    <td>{{$User3}}</td>
                                    <td><span class="badge bg-warning">{{number_format($SumUser3,2)}}</span></td>
                                  </tr>
                                  <tr>
                                    <td>ดาริณี ซ่อนกลิ่น</td>
                                    <td>{{$User4}}</td>
                                    <td><span class="badge bg-warning">{{number_format($SumUser4,2)}}</span></td>
                                  </tr>
                                  <tr>
                                    <td>เจ๊ะฟารีด๊ะห์ เจ๊ะกาเดร์</td>
                                    <td>{{$UserOther}}</td>
                                    <td><span class="badge bg-warning">{{number_format($SumUserOther,2)}}</span></td>
                                  </tr>
                                  <tr style="background-color:rgb(240, 241, 242)">
                                    <td>รวม</td>
                                    <td><span class="badge bg-danger">{{$User1+$User2+$User3+$User4+$UserOther}}</span></td>
                                    <td><span class="badge bg-danger">{{number_format($SumUser1+$SumUser2+$SumUser3+$SumUser4+$SumUserOther,2)}}</span></td>
                                  </tr>
                              </table>
                            <!-- </div> -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
                @if($FlagTab == NULL)
              <div class="tabcontent {{(auth::user()->type == 'Admin' or auth::user()->type == 'แผนก วิเคราะห์' or auth::user()->type == 'แผนก กฏหมาย')? 'tab-active' : '' }}">
                @else 
                <div class="tabcontent {{($FlagTab == 2)? 'tab-active' : '' }}">
                @endif 
                <div class="row">
                  <section class="col-lg-6 connectedSortable ui-sortable">
                    <div class="col-12 card box-shadow">
                      <div id="chartLegis"></div>
                    </div>
                  </section>
                  <section class="col-lg-6 connectedSortable ui-sortable">
                    <div class="col-12 card box-shadow">
                      <div id="chartCourt"></div>
                    </div>
                  </section>
                  <section class="col-lg-6 connectedSortable ui-sortable">
                    <div class="col-12 card box-shadow">
                      <div id="chartCourtcase"></div>
                    </div>
                  </section>
                  <section class="col-lg-6 connectedSortable ui-sortable">
                    <div class="col-12 card box-shadow">
                      <div id="chartEndcase"></div>
                    </div>
                  </section>
                  <!-- <section class="col-lg-6 connectedSortable ui-sortable">
                    <div class="col-12 card box-shadow">
                      <div id="chartAsset"></div>
                    </div>
                  </section>
                  <section class="col-lg-6 connectedSortable ui-sortable">
                    <div class="col-12 card box-shadow">
                      <div id="chartExhibit"></div>
                    </div>
                  </section> -->
                </div>
              </div>
                @if($FlagTab == NULL)
              <div class="tabcontent">   
                @else 
                <div class="tabcontent {{($FlagTab == 3)? 'tab-active' : '' }}">
                @endif 
                <div class="row">
                  <section class="col-lg-7 connectedSortable ui-sortable">
                    <div class="col-12 card box-shadow">
                      <div id="chartComproNew"></div>
                    </div>
                  </section>
                  <section class="col-lg-5 connectedSortable ui-sortable">
                    <div class="col-12 card box-shadow">
                      <!-- <div id="chartCapitalNew"></div> -->
                      <div id="chartComproPercent"></div>
                    </div>
                  </section>
                  <section class="col-lg-7 connectedSortable ui-sortable">
                    <div class="col-12 card box-shadow">
                      <div id="chartComproOld"></div>
                    </div>
                  </section>
                  <section class="col-lg-5 connectedSortable ui-sortable">
                    <div class="col-12 card box-shadow">
                      <!-- <div id="chartCapitalOld"></div> -->
                      <div id="chartCompro"></div>
                    </div>
                  </section>
                  <!-- <section class="col-lg-7 connectedSortable ui-sortable">
                    <div class="col-12 card box-shadow">
                      <div id="chartComproNewcash"></div>
                    </div>
                    <div class="col-12 card box-shadow">
                      <div id="chartComproOldcash"></div>
                    </div>
                  </section>
                  <section class="col-lg-5 connectedSortable ui-sortable">
                    <div class="col-12 card box-shadow">
                      <div id="chartComproPercentMonthly"></div>
                    </div>
                    <div class="col-12 card box-shadow">
                      <div id="chartComproMonthly"></div>
                    </div>
                  </section> -->
                </div>
              </div>
                @if($FlagTab == NULL)
              <div class="tabcontent {{(auth::user()->type == 'แผนก การเงินใน')? 'tab-active' : '' }}">      
                @else 
                <div class="tabcontent {{($FlagTab == 4)? 'tab-active' : '' }}">
                @endif 
                <div class="row">
                  <section class="col-lg-6 connectedSortable ui-sortable">
                    <div class="col-12 card box-shadow">
                      <div id="chartExpense"></div>
                    </div>
                  </section>
                  <section class="col-lg-6 connectedSortable ui-sortable">
                    <div class="col-12 card box-shadow">
                      <div id="chartExpenseMoney"></div>
                    </div>
                  </section>
                </div>
              </div>
              @if($FlagTab == NULL)
              <div class="tabcontent">     
                @else 
                <div class="tabcontent {{($FlagTab == 5)? 'tab-active' : '' }}">
                @endif 
                <div class="row">
                  <section class="col-lg-4 connectedSortable ui-sortable">
                    <div class="col-12 card box-shadow">
                      <div id="chartAsset"></div>
                    </div>
                  </section>
                  <section class="col-lg-4 connectedSortable ui-sortable">
                    <div class="col-12 card box-shadow">
                      <div id="chartExhibit"></div>
                    </div>
                  </section>
                  <section class="col-lg-4 connectedSortable ui-sortable">
                    <div class="col-12 card box-shadow">
                      <div id="chartPrepare"></div>
                    </div>
                  </section>
                </div>
              </div>
              <!-- <div class="tabcontent">
                <div class="row">
                  <section class="col-lg-6 connectedSortable ui-sortable">
                    <div class="col-12 card box-shadow">
                      <div id="chartPrepare"></div>
                    </div>
                  </section>
                </div>
              </div> -->
            </div> 
        </div>
    </section>
  </div>

  {{--ลูกหนี้ชั้นฟ้อง--}}
  <script>
    var options = {
      title: {
        text: 'ลูกหนี้งานฟ้องทุกชั้นสถานะ',
      },
      subtitle: {
        text: 'ลูกหนี้ฟ้องในระบบทั้งหมด '+({{count($dataPrepare)+count($dataSue)+count($dataTestify)+count($dataSubmit_decree)+count($dataSend_warrant)+count($dataSet_staff)+count($dataSet_warrant)+count($dataCourtcase1)+count($dataCourtcase2)+count($dataCourtcase3)+count($dataCourtcase4)+count($dataCourtcase5)+count($dataEndcase)}})+' ราย',
        align: 'left'
      },
      chart: {
        height: 250,
        type: "bar",
        zoom: {
          enabled: false
        },
        fontFamily: 'Prompt,sans-serif',
        fontsize: '8px',
      },
      plotOptions: {
        bar: {
          dataLabels: {
            position: "top" // top, center, bottom,,
          },
          distributed: true,
        }
      },
      dataLabels: {
        style: {
          colors: ['#000000']
        }
      },
      colors: ['#026EE3','#F5E30F','#F54305','#3EA513'],
      series: [{
        name: 'ลูกหนี้',
        data: [
          {{count($dataPrepare)}},
          {{count($dataSue)+count($dataTestify)+count($dataSubmit_decree)+count($dataSend_warrant)+count($dataSet_staff)+count($dataSet_warrant)}},
          {{count($dataCourtcase1)+count($dataCourtcase2)+count($dataCourtcase3)+count($dataCourtcase4)+count($dataCourtcase5)}},
          {{count($dataEndcase)}},
        ],
      }],
      xaxis: {
        categories: ['เตรียมฟ้อง','ชั้นศาล','ชั้นบังคับคดี','ปิดจบงาน']
      },
      tooltip: {
          y: {
            formatter: function (val) {
              return val + " ราย"
            }
          }
      },
      legend: {
        show: false,
      }
    }

    var chart = new ApexCharts(document.querySelector("#chartLegis"), options);

    chart.render();
  </script>

  {{-- ลูกหนี้ชั้นศาล --}}
  <script>
    var options = {
      title: {
        text: 'ลูกหนี้ชั้นศาล',
      },
      subtitle: {
        text: 'ลูกหนี้ชั้นศาลรวม '+({{count($dataSue)+count($dataTestify)+count($dataSubmit_decree)+count($dataSend_warrant)+count($dataSet_staff)+count($dataSet_warrant)}})+' ราย',
        align: 'left'
      },
      chart: {
        height: 250,
        type: "bar",
        zoom: {
          enabled: false
        },
        fontFamily: 'Prompt,sans-serif',
        fontsize: "10px"
      },
      plotOptions: {
        bar: {
          dataLabels: {
            position: "top" // top, center, bottom
          },
        columnWidth: '55%',
        }
      },
      dataLabels: {
          enabled: true,
          style: {
            colors: ['#000000']
          }
      },
      colors: ['#F5E30F'],
      series: [{
        name: 'ลูกหนี้',
        data: [ {{count($dataSue)}},{{count($dataTestify)}},{{count($dataSubmit_decree)}},{{count($dataSend_warrant)}},{{count($dataSet_staff)}},{{count($dataSet_warrant)}}],
      }],
      xaxis: {
        categories: ['ชั้นฟ้อง','สืบพยาน','ส่งคำบังคับ','ต.ผลหมาย','ตั้งเจ้า พนง.','ต.ผลหมายตั้ง']
      },
      tooltip: {
          y: {
            formatter: function (val) {
              return val + " ราย"
            }
          }
      },
      legend: {
        show: false,
      }
    }

    var chart = new ApexCharts(document.querySelector("#chartCourt"), options);

    chart.render();
  </script>

  {{-- ลูกหนี้ชั้นบังคับคดี --}}
  <script>
    var options = {
      title: {
        text: 'ลูกหนี้ชั้นบังคับคดี',
      },
      subtitle: {
        text: 'ลูกหนี้ชั้นบังคับคดีรวม '+({{count($dataCourtcase1)+count($dataCourtcase2)+count($dataCourtcase3)+count($dataCourtcase4)+count($dataCourtcase5)}})+' ราย',
        align: 'left'
      },
      chart: {
        height: 250,
        type: "bar",
        zoom: {
          enabled: false
        },
        fontFamily: 'Prompt,sans-serif',
        fontsize: "10px"
      },
      plotOptions: {
        bar: {
          dataLabels: {
            position: "top" // top, center, bottom
          },
        columnWidth: '55%',
        }
      },
      dataLabels: {
          enabled: true,
          style: {
            colors: ['#000000']
          }
      },
      colors: ['#F54305'],
      series: [{
        name: 'ลูกหนี้',
        data: [ {{count($dataCourtcase1)}},{{count($dataCourtcase2)}},{{count($dataCourtcase3)}},{{count($dataCourtcase4)}},{{count($dataCourtcase5)}}],
      }],
      xaxis: {
        categories: ['คัดหนังสือ','สืบทรัพย์','คัดโฉนด','ตั้งยึดทรัพย์','ประกาศขาย']
      },
      tooltip: {
          y: {
            formatter: function (val) {
              return val + " ราย"
            }
          }
      },
      legend: {
        show: false,
      }
    }

    var chart = new ApexCharts(document.querySelector("#chartCourtcase"), options);

    chart.render();
  </script>

  {{-- ลูกหนี้ปิดจบงานฟ้อง --}}
  <script>
    var options = {
      title: {
        text: 'ลูกหนี้ปิดจบ',
      },
      subtitle: {
        text: 'ลูกหนี้ปิดจบรวม '+({{count($dataEndcase1)+count($dataEndcase2)+count($dataEndcase3)+count($dataEndcase4)}})+' ราย',
        align: 'left'
      },
      chart: {
        height: 250,
        type: "bar",
        zoom: {
          enabled: false
        },
        fontFamily: 'Prompt,sans-serif',
        fontsize: "10px"
      },
      plotOptions: {
        bar: {
          dataLabels: {
            position: "top" // top, center, bottom
          },
        columnWidth: '55%',
        }
      },
      dataLabels: {
          enabled: true,
          style: {
            colors: ['#000000']
          }
      },
      colors: ['#3EA513'],
      series: [{
        name: 'ลูกหนี้',
        data: [ {{count($dataEndcase1)}},{{count($dataEndcase2)}},{{count($dataEndcase3)}},{{count($dataEndcase4)}}],
      }],
      xaxis: {
        categories: ['ปิดบัญชี','ปิดจบประนอม','ปิดจบรถยึด','ปิดจบถอนบังคับคดี']
      },
      tooltip: {
          y: {
            formatter: function (val) {
              return val + " ราย"
            }
          }
      },
      legend: {
        show: false,
      }
    }

    var chart = new ApexCharts(document.querySelector("#chartEndcase"), options);

    chart.render();
  </script>

  {{-- ลูกหนี้สินทรัพย์ --}}
  <script>
    var options = {
      title: {
        text: 'ลูกหนี้สินทรัพย์',
      },
      subtitle: {
        text: 'ลูกหนี้สินทรัพย์ทั้งหมด '+({{$dataAsset_yes + $dataAsset_no + count($dataAsset_null)}})+' ราย',
        align: 'left'
      },
      chart: {
        height: 300,
        type: "bar",
        zoom: {
          enabled: false
        },
        fontFamily: 'Prompt,sans-serif'
      },
      plotOptions: {
        bar: {
          dataLabels: {
            position: "top" // top, center, bottom
          },
        columnWidth: '55%',
        }
      },
      dataLabels: {
          enabled: true,
          style: {
            colors: ['#000000']
          }
      },
      colors: ['rgb(9, 209, 166)'],
      series: [{
        name: 'ลูกหนี้',
        data: [{{$dataAsset_yes}}, {{$dataAsset_no}}, {{count($dataAsset_null)}}],
      }],
      xaxis: {
        categories: ['มีทรัพย์','ไม่มีทรัพย์','ไม่มีข้อมูล']
      },
      tooltip: {
          y: {
            formatter: function (val) {
              return val + " ราย"
            }
          }
      }
    }

    var chart = new ApexCharts(document.querySelector("#chartAsset"), options);

    chart.render();
  </script>

  {{-- ลูกหนี้ประนอมหนี้ใหม่ --}}
  <script>
    var options = {
      title: {
        text: 'ลูกหนี้ประนอมหนี้ใหม่',
      },
      subtitle: {
        text: 'ลูกหนี้ประนอมหนี้ใหม่ทั้งหมด '+({{ $New_Count1 + $New_Count1_1 + $New_Count1_2 + $New_Count1_3 + $MissPay_pranom_new + $Track_pranom_new}})+' ราย',
        align: 'left'
      },
      chart: {
        height: 250,
        type: "bar",
        zoom: {
          enabled: false
        },
        fontFamily: 'Prompt,sans-serif'
      },
      plotOptions: {
        bar: {
          dataLabels: {
            position: "top" // top, center, bottom
          },
        columnWidth: '55%',
        }
      },
      dataLabels: {
          enabled: true,
          style: {
            colors: ['#000000']
          }
      },
      colors: ['rgb(9, 209, 166)'],
      series: [{
        name: 'ประนอมใหม่',
        data: [ {{$New_Count1}}, {{$New_Count1_1}}, {{$New_Count1_2}}, {{$New_Count1_3}}, {{$MissPay_pranom_new}}, {{$Track_pranom_new}}],
      }],
      xaxis: {
        categories: ['ชำระปกติ','ขาด1งวด','ขาด2งวด','ขาด3งวด','ค้างเกิน3งวด','งานโทรเคลื่อนไหว']
      },
      tooltip: {
          y: {
            formatter: function (val) {
              return val + " ราย"
            }
          }
      },
      legend: {
        show: false,
        showForSingleSeries: true,
        customLegendItems: [
          'ประนอมหนี้ใหม่รวม ({{ $New_Count1 + $New_Count1_1 + $New_Count1_2 + $New_Count1_3 + $MissPay_pranom_new + $Track_pranom_new}} ราย)',
          ],
        markers: {
          radius: 10,
        },
      }
    }

    var chart = new ApexCharts(document.querySelector("#chartComproNew"), options);

    chart.render();
  </script>

  {{-- ลูกหนี้ประนอมหนี้เก่า --}}
  <script>
    var options = {
      title: {
        text: 'ลูกหนี้ประนอมหนี้เก่า',
      },
      subtitle: {
        text: 'ลูกหนี้ประนอมหนี้เก่าทั้งหมด '+({{ $Old_Count1 + $Old_Count1_1 + $Old_Count1_2 + $Old_Count1_3 + $MissPay_pranom_old + $Track_pranom_old }})+' ราย',
        align: 'left'
      },
      chart: {
        height: 250,
        type: "bar",
        zoom: {
          enabled: false
        },
        fontFamily: 'Prompt,sans-serif'
      },
      plotOptions: {
        bar: {
          dataLabels: {
            position: "top" // top, center, bottom
          },
        columnWidth: '55%',
        }
      },
      dataLabels: {
          enabled: true,
          style: {
            colors: ['#000000']
          }
      },
      colors: ['rgb(238, 106, 54)'],
      series: [{
        name: 'ประนอมเก่า',
        // data: [ {{$Old_Count1}}, {{$Old_Count1_1}}, {{$Old_Count1_2}}, {{$Old_Count1_3}}, {{$MissPay_pranom_old}}, {{$Track_pranom_old}}, {{count($dataEndcaseOld)}}],
        data: [ {{$Old_Count1}}, {{$Old_Count1_1}}, {{$Old_Count1_2}}, {{$Old_Count1_3}}, {{$MissPay_pranom_old}}, {{$Track_pranom_old}}],
      }],
      xaxis: {
        // categories: ['ชำระปกติ','ขาด1งวด','ขาด2งวด','ขาด3งวด','ค้างเกิน3งวด','งานโทร','จบประนอม']
        categories: ['ชำระปกติ','ขาด1งวด','ขาด2งวด','ขาด3งวด','ค้างเกิน3งวด','งานโทร']
      },
      tooltip: {
          y: {
            formatter: function (val) {
              return val + " ราย"
            }
          }
      },
      legend: {
        show: false,
        showForSingleSeries: true,
        customLegendItems: [
          'ประนอมหนี้เก่ารวม ({{ $Old_Count1 + $Old_Count1_1 + $Old_Count1_2 + $Old_Count1_3 + $MissPay_pranom_old + $Track_pranom_old + count($dataEndcaseOld) }} ราย)',
          ],
        markers: {
          radius: 10,
        },
      }
    }

    var chart = new ApexCharts(document.querySelector("#chartComproOld"), options);

    chart.render();
    
  </script>

  {{-- ยอดเงินประนอมหนี้ใหม่ --}}
  <script>
      var options = {
        title: {
          text: 'ยอดเงินประนอมหนี้ใหม่',
        },
        series: [{
            name: "ยอดเงิน",
            data: [{{$SumNew1}}, {{$SumNewPrice}}, {{$SumNewDiscount}}, {{$SumNew2}} ]
        }],
        chart: {
          height: 250,
          type: 'bar',
          zoom: {
            enabled: true
          },
          fontFamily: 'Prompt,sans-serif'
        },
        colors: ['rgb(245, 227, 15)'],
        plotOptions: {
          bar: {
            borderRadius: 4,
            horizontal: true,
          },
        },
        dataLabels: {
          enabled: true,
          style: {
            colors: ['#000000'],
            fontSize: "10px",
          },
          formatter: function (val) {
            return addCommas(val);
          },
          textAnchor:'start',
        },
        stroke: {
          curve: 'straight'
        },
        xaxis: {
          categories: ['ยอดประนอม', 'ยอดชำระ','ยอดส่วนลด', 'ยอดคงเหลือ'],
          labels: {
            show: false
          },
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return addCommas(val) + " บาท"
            }
          }
        }
      };

      var chart = new ApexCharts(document.querySelector("#chartCapitalNew"), options);
      chart.render();
  </script>

  {{-- ยอดเงินประนอมหนี้เก่า --}}
  <script>
      var options = {
        title: {
          text: 'ยอดเงินประนอมหนี้เก่า',
        },
        series: [{
            name: "ยอดเงิน",
            data: [{{$SumOld1}}, {{$SumOldPrice}}, {{$SumOldDiscount}}, {{$SumOld2}} ]
        }],
        chart: {
          height: 250,
          type: 'bar',
          zoom: {
            enabled: true
          },
          fontFamily: 'Prompt,sans-serif'
        },
        colors: ['rgb(245, 227, 15)'],
        plotOptions: {
          bar: {
            borderRadius: 4,
            horizontal: true,
          },
        },
        dataLabels: {
          enabled: true,
          style: {
            colors: ['#000000'],
            fontSize: "10px",
          },
          formatter: function (val) {
            return addCommas(val);
          },
          textAnchor:'start',
        },
        stroke: {
          curve: 'straight'
        },
        xaxis: {
          categories: ['ยอดประนอม', 'ยอดชำระ','ยอดส่วนลด', 'ยอดคงเหลือ'],
          labels: {
            show: false
          },
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return addCommas(val) + " บาท"
            }
          }
        }
      };

      var chart = new ApexCharts(document.querySelector("#chartCapitalOld"), options);
      chart.render();
  </script>

  {{-- ลูกหนี้ประนอมหนี้ใหม่ percent --}}
  <script>
      var options = {
          title: {
            text: 'รายการรับชำระประนอมหนี้ (%)',
          },
          // subtitle: {
          //   text: 'ลูกหนี้ประนอมหนี้ (เดือน)',
          //   align: 'left'
          // },
          series: [
            {
              name: '% ลูกค้าที่ชำระแล้ว',
              data: [{{$dataPayPranomN}}, {{$dataPayPranomO}}]
            },
            {
              name: '% ลูกค้าที่ต้องชำระ',
              data: [{{ $dataAllPranomN - $dataPayPranomN}}, {{ $dataAllPranomO - $dataPayPranomO }}]
            }
          ],
          chart: {
            type: 'bar',
            height: 250,
            stacked: true,
            stackType: '100%',
            fontFamily: 'Prompt,sans-serif',
            fontsize: '10px',
          },
          responsive: [{
            breakpoint: 480,
            options: {
              legend: {
                position: 'bottom',
                offsetX: -10,
                offsetY: 0
              }
            }
          }],
          colors: ['#00ad00','#d10000'],
          xaxis: {
            categories: ['ประนอมหนี้ใหม่', 'ประนอมหนี้เก่า'],
          },
          fill: {
            opacity: 1
          },
          legend: {
            position: 'right',
            offsetX: 0,
            offsetY: 0
          },
      };

      var chart = new ApexCharts(document.querySelector("#chartComproPercent"), options);
      chart.render();
  </script>

  {{-- ลูกหนี้ประนอมหนี้ใหม่ Amount --}}
  <script>
    var options = {
      title: {
        text: 'รายการรับชำระประนอมหนี้ ({{$dataAllPranomN+$dataAllPranomO}} ราย)',
      },
      // subtitle: {
      //   text: 'ลูกหนี้ประนอมหนี้ (เดือน)',
      //   align: 'left'
      // },
      series: [
        {
          name: 'ลูกค้าที่ชำระแล้ว',
          data: [{{$dataPayPranomN}}, {{$dataPayPranomO}}]
        },
        {
          name: 'ลูกค้าที่ต้องชำระ',
          data: [{{ $dataAllPranomN - $dataPayPranomN}}, {{ $dataAllPranomO - $dataPayPranomO }}]
        }
      ],
      chart: {
      type: 'bar',
      height: 250,
      stacked: true,
      fontFamily: 'Prompt,sans-serif',
      fontsize: '10px',
      toolbar: {
        show: true
      },
      zoom: {
        enabled: true
      }
    },
    colors: ['#00ad00','#d10000'],
    responsive: [{
      breakpoint: 480,
      options: {
        legend: {
          position: 'bottom',
          offsetX: -10,
          offsetY: 0
        }
      }
    }],
    plotOptions: {
      bar: {
        horizontal: false,
        // borderRadius: 10
      },
    },
    xaxis: {
      type: 'text',
      categories: ['ประนอมหนี้ใหม่ ({{$dataAllPranomN}})', 'ประนอมหนี้เก่า ({{ $dataAllPranomO }})'],
    }, 
    legend: {
      position: 'right',
      offsetY: 0
    },
    fill: {
      opacity: 1
    }
    };

    var chart = new ApexCharts(document.querySelector("#chartCompro"), options);
    chart.render();
  </script>

  {{-- ยอดประนอมหนี้ใหม่ประจำเดือน --}}
  {{-- <script>
    var options = {
        title: {
          text: 'ยอดเงินประนอมหนี้ใหม่ (ประจำเดือน)',
        },
        subtitle: {
          text: 'รวมยอดเงินประนอมหนี้ใหม่ประจำเดือน ('+ (addCommas({{$SumNew_All}}))+' บาท)',
          align: 'left'
        },
          series: [{
          data: [{{$SumNew_noPay}}, {{$SumNew_Pay}}]
        }],
          chart: {
          type: 'bar',
          height: 250,
          fontFamily: 'Prompt,sans-serif',
          fontsize: '10px',
        },
        colors: ['#d10000','#00ad00'],
        plotOptions: {
          bar: {
            horizontal: true,
            dataLabels: {
              position: 'top',
            },
            distributed: true,
          }
        },
        dataLabels: {
          enabled: true,
          offsetX: 45,
          style: {
            fontSize: '12px',
            colors: ['#000']
          },
          formatter: function (val) {
            return addCommas(val);
          }
        },
        stroke: {
          show: true,
          width: 1,
          colors: ['#fff']
        },
        tooltip: {
          shared: true,
          intersect: false,
        },
        xaxis: {
          categories: ['ยอดที่ต้องชำระ', 'ยอดชำระแล้ว'],
          labels: {
            show: false
          },
        },
        legend: {
          show: false
        },
        };

        var chart = new ApexCharts(document.querySelector("#chartComproNewcash"), options);
        chart.render();
  </script> --}}

  {{-- ยอดประนอมหนี้เก่าประจำเดือน --}}
  {{-- <script>
    var options = {
        title: {
          text: 'ยอดเงินประนอมหนี้เก่า (ประจำเดือน)',
        },
        subtitle: {
          text: 'รวมยอดเงินประนอมหนี้ใหม่ประจำเดือน ('+ (addCommas({{$SumOld_All}}))+' บาท)',
          align: 'left'
        },
          series: [{
          data: [{{$SumOld_noPay}}, {{$SumOld_Pay}}]
        }],
          chart: {
          type: 'bar',
          height: 250,
          fontFamily: 'Prompt,sans-serif',
          fontsize: '10px',
        },
        colors: ['#d10000','#00ad00'],
        plotOptions: {
          bar: {
            horizontal: true,
            dataLabels: {
              position: 'top',
            },
            distributed: true,
          }
        },
        dataLabels: {
          enabled: true,
          offsetX: 45,
          style: {
            fontSize: '12px',
            colors: ['#000']
          },
          formatter: function (val) {
            return addCommas(val);
          }
        },
        stroke: {
          show: true,
          width: 1,
          colors: ['#fff']
        },
        tooltip: {
          shared: true,
          intersect: false
        },
        xaxis: {
          categories: ['ยอดที่ต้องชำระ', 'ยอดชำระแล้ว'],
          labels: {
            show: false
          },
        },
        legend: {
          show: false
        },
        };

        var chart = new ApexCharts(document.querySelector("#chartComproOldcash"), options);
        chart.render();
  </script> --}}

  {{-- ค่าใช้จ่ายฝ่ายกฏหมาย --}}
  <script>
    var options = {
        title: {
            text: 'รายการค่าใช้จ่าย',
        },
        subtitle: {
            text: 'ทั้งหมด '+( addCommas({{ count($dataInternal_N) + count($dataInternal_Y) + count($dataExtra_N) + count($dataExtra_Y) + count($dataReserve_N) + count($dataReserve_Y) }}) )+' รายการ',
            align: 'left'
        },
        series: [
            {
            name: 'ที่ตั้งเบิก',
            data: [{{count($dataInternal_N)}}, {{count($dataExtra_N)}}, {{count($dataReserve_N)}}, {{count($dataExhibit_N)}}]
          }, {
            name: 'ที่อนุมัติ',
            data: [{{count($dataInternal_Y)}}, {{count($dataExtra_Y)}}, {{count($dataReserve_Y)}}, {{count($dataExhibit_Y)}}]
          }
        ],
        chart: {
          type: 'bar',
          height: 300,
          fontFamily: 'Prompt,sans-serif',
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
          },
        },
        dataLabels: {
          enabled: true,
          style: {
            fontSize: "12px",
            colors: ["#304758"]
          },
          formatter: function (val) {
            return addCommas(val);
          }
        },
        plotOptions: {
          bar: {
            dataLabels: {
              position: "top" // top, center, bottom
            },
          }
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: ['ค่าภายในศาล', 'ค่าพิเศษ', 'ค่าเบิกสำรองจ่าย', 'ค่าของกลาง'],
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return addCommas(val) + " รายการ"
            }
          }
        }
        };

    var chart = new ApexCharts(document.querySelector("#chartExpense"), options);
    chart.render();
  </script>

{{--ลูกหนี้เตรียมฟ้อง--}}
  <script>
    var options = {
      title: {
        text: 'ลูกหนี้เตรียมฟ้อง | ส่งฟ้อง',
      },
      subtitle: {
            text: 'ประจำเดือน',
            align: 'left'
      },
      chart: {
        height: 300,
        type: "bar",
        zoom: {
          enabled: false
        },
        fontFamily: 'Prompt,sans-serif',
        fontsize: '8px',
      },
      plotOptions: {
        bar: {
          dataLabels: {
            position: "top" // top, center, bottom,,
          },
          distributed: true,
        }
      },
      dataLabels: {
        style: {
          colors: ['#000000']
        }
      },
      colors: ['#F54305','#3EA513'],
      series: [{
        name: 'ลูกหนี้',
        data: [
          {{count($dataPrepareLaw)}},
          {{count($dataSentLaw)}},
        ],
      }],
      xaxis: {
        categories: ['เตรียมฟ้อง','ส่งฟ้อง']
      },
      tooltip: {
          y: {
            formatter: function (val) {
              return val + " ราย"
            }
          }
      },
      legend: {
        show: false,
      }
    }

    var chart = new ApexCharts(document.querySelector("#chartPrepare"), options);

    chart.render();
  </script>

  <script>
    var options = {
      title: {
            text: 'ยอดเงินค่าใช้จ่าย',
          },
          subtitle: {
            text: 'ทั้งหมด '+( addCommas({{ $SumInternal_N + $SumInternal_Y + $SumExtra_N + $SumExtra_Y + $SumReserve_N + $SumReserve_Y}}) )+' บาท',
            align: 'left'
          },
      chart: {
        type: "bar",
        height: 300,
        toolbar: {
          show: true
        },
        zoom: {
          enabled: true
        },
        fontFamily: 'Prompt,sans-serif',
      },
      dataLabels: {
        enabled: true,
        // offsetX: 90,
        style: {
          fontSize: "12px",
          colors: ["#304758"]
        },
        textAnchor:'start',
        formatter: function (val) {
          return addCommas(val);
        }
        // formatter: function (value, { seriesIndex, dataPointIndex, w }) {
        //   let indices = w.config.series.map((item, i) => i);
        //   indices = indices.filter(
        //     (i) =>
        //       !w.globals.collapsedSeriesIndices.includes(i) &&
        //       _.get(w.config.series, `${i}.data.${dataPointIndex}`) > 0
        //   );
        //   if (seriesIndex == _.max(indices))
        //     return addCommas(w.globals.stackedSeriesTotals[dataPointIndex]);
        //   return "";
        // }
      },
      plotOptions: {
        bar: {
          horizontal: true,
        }
      },
      tooltip: {
        enabled: true,
        enabledOnSeries: true,
        shared: true,
        followCursor: true,
        intersect: false,
        style: {
          fontSize: '12px',
        },
        y: {
            formatter: function (val) {
              return addCommas(val) + " บาท"
            }
          }
      },
      xaxis: {
        type: "text",
        categories: [
          "ค่าภายในศาล",
          "ค่าพิเศษ",
          "ค่าเบิกสำรองจ่าย",
          "ค่าของกลาง"
        ],
        labels: {
          show: false
        },
      },
      legend: {
        position: "bottom",
      },
      fill: {
        opacity: 1
      },
      series: [
        {
          name: "ที่ตั้งเบิก",
          data: [{{$SumInternal_N}}, {{$SumExtra_N}}, {{$SumReserve_N}}, {{$SumExhibit_N}}]
        },
        {
          name: "ที่อนุมัติ",
          data: [{{$SumInternal_Y}}, {{$SumExtra_Y}}, {{$SumReserve_Y}}, {{$SumExhibit_Y}}]
        }
      ]
    };

    var chart = new ApexCharts(document.querySelector("#chartExpenseMoney"), options);
    chart.render();
  </script>


  {{-- ลูกหนี้ของกลาง --}}
  <script>
    var options = {
      title: {
        text: 'ลูกหนี้ของกลาง',
      },
      subtitle: {
        text: 'ลูกหนี้ของกลางทั้งหมด '+({{count($dataKlang)+ count($dataMatrakarn) + count($dataNotspecific)}})+' ราย',
        align: 'left'
      },
      chart: {
        height: 300,
        type: "bar",
        zoom: {
          enabled: false
        },
        fontFamily: 'Prompt,sans-serif'
      },
      plotOptions: {
        bar: {
          dataLabels: {
            position: "top" // top, center, bottom
          },
        columnWidth: '55%',
        }
      },
      dataLabels: {
          enabled: true,
          style: {
            colors: ['#000000']
          }
      },
      // colors: ['#3EA513'],
      series: [{
        name: 'ลูกหนี้',
        data: [{{count($dataKlang)}}, {{count($dataMatrakarn)}}, {{count($dataNotspecific)}}],
      }],
      xaxis: {
        categories: ['ของกลาง','ยึด(ปปส.)','ไม่ระบุประเภท']
      },
      tooltip: {
          y: {
            formatter: function (val) {
              return val + " ราย"
            }
          }
      }
    }

    var chart = new ApexCharts(document.querySelector("#chartExhibit"), options);

    chart.render();
  </script>

  <script>
    // -------- DataTable ------------
    $(document).ready(function() {
        $('#News').DataTable( {
          "responsive": true,
          "autoWidth": false,
          "ordering": false,
          "searching" : false,
          "lengthChange" : false,
          "info" : false,
          "pageLength": 3,
          "order": [[ 0, "asc" ]]
        });
    });
  </script>

  <script>
    var tabs = document.getElementById('icetab-container').children;
    var tabcontents = document.getElementById('icetab-content').children;

    var myFunction = function() {
      var tabchange = this.mynum;
      for(var int=0;int<tabcontents.length;int++){
        tabcontents[int].className = ' tabcontent';
        tabs[int].className = 'icetab';
      }
      tabcontents[tabchange].classList.add('tab-active');
      this.classList.add('current-tab');
    }	

    for(var index=0;index<tabs.length;index++){
      tabs[index].mynum=index;
      tabs[index].addEventListener('click', myFunction, false);
    }
  </script>

  <script>
    var tabs1 = document.getElementById('icetab-container1').children;
    var tabcontents1 = document.getElementById('icetab-content1').children;

    var myFunction1 = function() {
      var tabchange1 = this.mynum;
      for(var int1=0;int1<tabcontents1.length;int1++){
        tabcontents1[int1].className = ' tabcontent';
        tabs1[int1].className = 'icetab';
      }
      tabcontents1[tabchange1].classList.add('tab-active');
      this.classList.add('current-tab');
    }	

    for(var index1=0;index1<tabs1.length;index1++){
      tabs1[index1].mynum=index1;
      tabs1[index1].addEventListener('click', myFunction1, false);
    }
  </script>

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
    function addcomma(){
      var num11 = document.getElementById('topcar').value;
      var num1 = num11.replace(",","");
      document.form2.topcar.value = addCommas(num1);
    }
  </script>
@endsection

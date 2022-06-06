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
        <a class="text-dark" href="{{ route('index','home') }}">Dashboard & Informations</a>
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

  <div class="py-2 service-24">
      <div class="row wrap-service-24 service-24">
        <div class="col-lg-2 col-md-6">
          <div class="card card-shadow border-0 mb-4">
            <a href="{{ route('MasterCompro.index') }}?type={{4}}" class="card-hover py-4 text-center d-block rounded">
              <span class="bg-success-grediant">{{$MissPay_pranom_new}}</span>
              <h6 class="ser-title">แจ้งเตือนขาดชำระ. ประนอมใหม่</h6>
            </a>
          </div>
        </div>
        <div class="col-lg-2 col-md-6">
          <div class="card rounded card-shadow border-0 mb-4">
            <a href="{{ route('MasterCompro.index') }}?type={{5}}" class="card-hover py-4 text-center d-block rounded">
              <span class="bg-success-grediant">{{$Track_pranom_new}}</span>
              <h6 class="ser-title">แจ้งเตือนติดตาม. ประนอมใหม่</h6>
            </a>
          </div>
        </div>
        <div class="col-lg-2 col-md-6">
          <div class="card card-shadow border-0 mb-4">
            <a href="{{ route('MasterCompro.index') }}?type={{4}}" class="card-hover py-4 text-center d-block rounded">
              <span class="bg-success-grediant">{{$MissPay_pranom_old}}</span>
              <h6 class="ser-title">แจ้งเตือนขาดชำระ. ประนอมเก่า</h6>
            </a>
          </div>
        </div>
        <div class="col-lg-2 col-md-6">
          <div class="card card-shadow border-0 mb-4">
            <a href="{{ route('MasterCompro.index') }}?type={{5}}" class="card-hover py-4 text-center d-block rounded">
              <span class="bg-success-grediant">{{$Track_pranom_old}}</span>
              <h6 class="ser-title">แจ้งเตือนติดตาม. ประนอมเก่า</h6>
            </a>
          </div>
        </div>
        <div class="col-lg-2 col-md-6">
          <div class="card card-shadow border-0 mb-4">
            <a href="{{ route('MasterCompro.index') }}?type={{6}}" class="card-hover py-4 text-center d-block rounded">
              <span class="bg-success-grediant">{{$dataGetpay_new}}</span>
              <h6 class="ser-title">***รายการรับชำระ. ประนอมใหม่</h6>
            </a>
          </div>
        </div>
        <div class="col-lg-2 col-md-6">
          <div class="card card-shadow border-0 mb-4">
            <a href="{{ route('MasterCompro.index') }}?type={{6}}" class="card-hover py-4 text-center d-block rounded">
              <span class="bg-success-grediant">{{$dataGetpay_old}}</span>
              <h6 class="ser-title">***รายการรับชำระ. ประนอมเก่า</h6>
            </a>
          </div>
        </div>
      </div>
  </div>

  <div class="row"  style="font-family: 'Prompt', sans-serif;">
    <section class="col-lg-8 connectedSortable ui-sortable">
        <div class="col-12 card box-shadow">
          <div id="chartLegis"></div>
        </div>
    </section>

    <section class="col-lg-4 connectedSortable ui-sortable">
        <div class="col-12 card box-shadow" style="height:335px;font-size:12px;">
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
    </section>

    <section class="col-lg-8 connectedSortable ui-sortable">
        <div class="col-12">
            <div id="icetab-container">
              <div class="icetab current-tab">ประนอมหนี้ใหม่</div>
              <div class="icetab">ประนอมหนี้เก่า</div>  
            </div>
            
            <div id="icetab-content">
              <div class="tabcontent tab-active">
                <div id="chartComproNew"></div>
              </div> 
              <div class="tabcontent">              
                <div id="chartComproOld"></div>
              </div>
            </div> 
        </div>
    </section>

    <section class="col-lg-4 connectedSortable ui-sortable">
        <div class="col-12 mb-3">
          
            <div id="icetab-container1">
              <div class="icetab current-tab">ยอดประนอมหนี้ใหม่</div>
              <div class="icetab">ยอดประนอมหนี้เก่า</div>  
            </div>
            
            <div id="icetab-content1">
              <div class="tabcontent tab-active">
                <div id="chartCapitalNew"></div>
              </div> 
              <div class="tabcontent">              
                <div id="chartCapitalOld"></div>
              </div>
            </div> 
        </div>
    </section>

    <section class="col-lg-8 connectedSortable ui-sortable">
        <div class="col-12 card box-shadow">
          <div id="chartCourtcase"></div>
        </div>
    </section>

    <section class="col-lg-4 connectedSortable ui-sortable">
        <div class="col-12 card box-shadow">
          <div id="chartExpense"></div>
        </div>
    </section>

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

    {{--<section class="col-lg-4 connectedSortable ui-sortable">
        <div class="col-12 card box-shadow" style="height:285px;font-size:10px;">
              <div class="card-header">
                <h2 class="card-title SizeText"><b>ข่าวสารลูกหนี้ใหม่</b></h2>
              </div>
              <!-- <div class="card-body"> -->
                <table class="table table-bordered table-hover SizeText" id="News">
                  <thead>
                    <tr>
                      <!-- <td>ที่</td> -->
                      <td>เลขที่สัญญา</td>
                      <td>ชื่อ-สกุล</td>
                      <td>ประเภท</td>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($dataTopfive as $key => $row)
                    <tr>
                      <!-- <td>{{$key+1}}.</td> -->
                      <td>{{$row->Contract_legis}}</td>
                      <td>{{$row->Name_legis}}</td>
                      <td>
                        @if($row->Flag == 'Y')
                        <span class="badge bg-danger">งานฟ้องใหม่</span>
                        @else 
                        <span class="badge bg-warning">งานประนอมเก่า</span>
                        @endif
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              <!-- </div> -->
        </div>
    </section>--}}
    
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
      colors: ['#026EE3','#F5E30F','#F54305','#3EA513','#00f8ff'],
      series: [{
        name: 'ลูกหนี้',
        data: [
          {{count($dataPrepare)}},
          {{count($dataSue)+count($dataTestify)+count($dataSubmit_decree)+count($dataSend_warrant)+count($dataSet_staff)+count($dataSet_warrant)}},
          {{count($dataCourtcase1)+count($dataCourtcase2)+count($dataCourtcase3)+count($dataCourtcase4)+count($dataCourtcase5)}},
          {{count($dataEndcase)}},
          {{$dataAsset_yes + $dataAsset_no + count($dataAsset_null)}}
        ],
      }],
      xaxis: {
        categories: ['เตรียมฟ้อง','ลูกหนี้ชั้นศาล','ลูกหนี้ชั้นบังคับคดี','ลูกหนี้ปิดจบงาน','ลูกหนี้สินทรัพย์']
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
        data: [ {{count($dataCourtcase1)}},{{count($dataCourtcase2)}},{{count($dataCourtcase3)}},{{count($dataCourtcase4)}},{{count($dataCourtcase5)}}],
      }],
      xaxis: {
        categories: ['คัดหนังสือรับรองคดี','สืบทรัพย์','คัดโฉนด/ถ่ายภาพ','ตั้งเรื่องยึดทรัพย์','ประกาศขายทอดตลาด']
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
      chart: {
        height: 220,
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
        show: true,
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
      chart: {
        height: 220,
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
        data: [ {{$Old_Count1}}, {{$Old_Count1_1}}, {{$Old_Count1_2}}, {{$Old_Count1_3}}, {{$MissPay_pranom_old}}, {{$Track_pranom_old}}, {{count($dataEndcaseOld)}}],
      }],
      xaxis: {
        categories: ['ชำระปกติ','ขาด1งวด','ขาด2งวด','ขาด3งวด','ค้างเกิน3งวด','งานโทรเคลื่อนไหว','ปิดจบประนอม']
      },
      tooltip: {
          y: {
            formatter: function (val) {
              return val + " ราย"
            }
          }
      },
      legend: {
        show: true,
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
        series: [{
            name: "ยอดเงิน",
            data: [{{$SumNew1}}, {{$SumNewPrice}}, {{$SumNewDiscount}}, {{$SumNew2}} ]
        }],
        chart: {
          height: 220,
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
        series: [{
            name: "ยอดเงิน",
            data: [{{$SumOld1}}, {{$SumOldPrice}}, {{$SumOldDiscount}}, {{$SumOld2}} ]
        }],
        chart: {
          height: 220,
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

  {{-- ค่าใช้จ่ายฝ่ายกฏหมาย --}}
  <script>
    var options = {
      title: {
            text: 'ค่าใช้จ่ายฝ่ายกฏหมาย',
          },
          subtitle: {
            text: 'ค่าใช้จ่ายทั้งหมด '+( {{count($dataInternal_N)+count($dataInternal_Y)+count($dataExtra_N)+count($dataExtra_Y)}} )+' รายการ',
            align: 'left'
          },
      chart: {
        type: "bar",
        height: 300,
        stacked: true,
        toolbar: {
          show: true
        },
        zoom: {
          enabled: true
        },
        fontFamily: 'Prompt,sans-serif'
      },
      dataLabels: {
        enabled: true,
        // offsetX: 25,
        style: {
          fontSize: "12px",
          colors: ["#304758"]
        },
        textAnchor:'middle',
        formatter: function (value, { seriesIndex, dataPointIndex, w }) {
          let indices = w.config.series.map((item, i) => i);
          indices = indices.filter(
            (i) =>
              !w.globals.collapsedSeriesIndices.includes(i) &&
              _.get(w.config.series, `${i}.data.${dataPointIndex}`) > 0
          );
          if (seriesIndex == _.max(indices))
            return addCommas(w.globals.stackedSeriesTotals[dataPointIndex]);
          return "";
        }
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
          "ค่าภายในศาล ( {{count($dataInternal_N)+count($dataInternal_Y)}} )",
          "ค่าพิเศษ  ( {{count($dataExtra_N)+count($dataExtra_Y)}})"
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
          data: [{{$SumInternal_N}}, {{$SumExtra_N}}]
        },
        {
          name: "ที่อนุมัติ",
          data: [{{$SumInternal_Y}}, {{$SumExtra_Y}}]
        }
      ]
    };

    var chart = new ApexCharts(document.querySelector("#chartExpense"), options);
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

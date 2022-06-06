<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Connectdb2;
use App\DataIBM;
use DB;

use App\Legislation;
use App\legispayment;
use App\Legiscompromise;
use App\Legisexhibit;
use App\Legisexpense;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($name, Request $request)
    {
        $dateSearch = NULL;
        $Fdate = NULL;
        $Tdate = NULL;

        if ($request->get('dateSearch')) {
            $dateSearch = $request->dateSearch;

            $SetFdate = substr($dateSearch,0,10);
            $Fdate = date('Y-m-d', strtotime($SetFdate));

            $SetTdate = substr($dateSearch,13,21);
            $Tdate = date('Y-m-d', strtotime($SetTdate));
        }
        else{
            $dateSearch = date('01-m-Y').' - '.date('d-m-Y');
        }

        $dataPrepareLaw = Legislation::where('Flag_status', 1)
                        ->where('Status_legis', NULL)
                        ->whereBetween('Date_legis',[$Fdate,$Tdate])
                        ->get();

        $dataSentLaw = Legislation::where('Flag_status', 2)
                        ->where('Status_legis', NULL)
                        ->whereBetween('Date_legis',[$Fdate,$Tdate])
                        ->get();

        $dataPrepare = Legislation::where('Flag_status', '=', '1') //เตรียมฟ้อง
                        ->where('Flag', 'Y')
                        ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                            return $q->whereBetween('Date_legis',[$Fdate,$Tdate]);
                            })
                        ->get();

        $dataSue =     Legislation::where('Status_legis', NULL) //ฟ้อง
                        ->where('Flag', 'Y')
                        ->where('Flag_Class', 'สถานะส่งฟ้อง')
                        ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                            return $q->whereBetween('DateStatus_legis',[$Fdate,$Tdate]);
                            })
                        ->get();

        $dataTestify = Legislation::where('Status_legis', NULL) //ส่งสืบพยาน
                        ->where('Flag', 'Y')
                        ->where('Flag_Class', 'สถานะส่งสืบพยาน')
                        ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                            return $q->whereBetween('DateStatus_legis',[$Fdate,$Tdate]);
                            })
                        ->get();

        $dataSubmit_decree = Legislation::where('Status_legis', NULL) //ส่งคำบังคับ
                        ->where('Flag', 'Y')
                        ->where('Flag_Class', 'สถานะส่งคำบังคับ')
                        ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                            return $q->whereBetween('DateStatus_legis',[$Fdate,$Tdate]);
                            })
                        ->get();

        $dataSend_warrant = Legislation::where('Status_legis', NULL) //ส่งตรวจผลหมาย
                        ->where('Flag', 'Y')
                        ->where('Flag_Class', 'สถานะส่งตรวจผลหมาย')
                        ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                            return $q->whereBetween('DateStatus_legis',[$Fdate,$Tdate]);
                            })
                        ->get();

        $dataSet_staff = Legislation::where('Status_legis', NULL) //ตั้งเจ้าพนักงาน
                        ->where('Flag', 'Y')
                        ->where('Flag_Class', 'สถานะส่งตั้งเจ้าพนักงาน')
                        ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                            return $q->whereBetween('DateStatus_legis',[$Fdate,$Tdate]);
                            })
                        ->get();

        $dataSet_warrant = Legislation::where('Status_legis', NULL) //ส่งตรวจผลหมายตั้ง
                        ->where('Flag', 'Y')
                        ->where('Flag_Class', 'สถานะส่งตรวจผลหมายตั้ง')
                        ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                            return $q->whereBetween('DateStatus_legis',[$Fdate,$Tdate]);
                            })
                        ->get();

        $dataCourtcase1 = Legislation::where('Status_legis', NULL)
                        ->where('Flag_Class','=', 'สถานะคัดหนังสือรับรองคดี')
                        ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                            return $q->whereBetween('DateStatus_legis',[$Fdate,$Tdate]);
                            })
                        ->get();

        $dataCourtcase2 = Legislation::where('Status_legis', NULL)
                        ->where('Flag_Class','=', 'สถานะสืบทรัพย์บังคับคดี')
                        ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                            return $q->whereBetween('DateStatus_legis',[$Fdate,$Tdate]);
                            })
                        ->get();

        $dataCourtcase3 = Legislation::where('Status_legis', NULL)
                        ->where('Flag_Class','=', 'สถานะคัดโฉนด')
                        ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                            return $q->whereBetween('DateStatus_legis',[$Fdate,$Tdate]);
                            })
                        ->get();

        $dataCourtcase4 = Legislation::where('Status_legis', NULL)
                        ->where('Flag_Class','=', 'สถานะตั้งยึดทรัพย์')
                        ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                            return $q->whereBetween('DateStatus_legis',[$Fdate,$Tdate]);
                            })
                        ->get();

        $dataCourtcase5 = Legislation::where('Status_legis', NULL)
                        ->where('Flag_Class','=', 'ประกาศขายทอดตลาด')
                        ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                            return $q->whereBetween('DateStatus_legis',[$Fdate,$Tdate]);
                            })
                        ->get();

        // $dataSubmit_deed = Legislation::where('Status_legis', NULL) //ส่งคัดโฉนด
        //                 ->where('Flag', 'Y')
        //                 ->where('Flag_Class','=', 'สถานะส่งคัดโฉนด')
        //                 ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
        //                     return $q->whereBetween('DateStatus_legis',[$Fdate,$Tdate]);
        //                     })
        //                 ->get();

        // $dataSet_foreclosure = Legislation::where('Status_legis', NULL) //ตั้งยึดทรัพย์
        //                 ->where('Flag', 'Y')
        //                 ->where('Flag_Class','=', 'สถานะตั้งยึดทรัพย์')
        //                 ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
        //                     return $q->whereBetween('DateStatus_legis',[$Fdate,$Tdate]);
        //                     })
        //                 ->get();

        $dataEndcase = Legislation::where('Status_legis', '!=', NULL) //ปิดจบงานฟ้อง
                        ->where('Flag', 'Y')
                        ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                            return $q->whereBetween('DateStatus_legis',[$Fdate,$Tdate]);
                            })
                        ->get();
        $dataEndcase1 = Legislation::where('Status_legis', '!=',NULL)
                        ->where('Flag', 'Y')
                        ->where('Status_legis','=','ปิดบัญชี')
                        ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                            return $q->whereBetween('DateStatus_legis',[$Fdate,$Tdate]);
                            })
                        ->get();
          
        $dataEndcase2 = Legislation::where('Status_legis', '!=',NULL)
                        ->where('Flag', 'Y')
                        ->where('Status_legis','=','ปิดจบประนอม')
                        ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                            return $q->whereBetween('DateStatus_legis',[$Fdate,$Tdate]);
                            })
                        ->get();
          
        $dataEndcase3 = Legislation::where('Status_legis', '!=',NULL)
                        ->where('Flag', 'Y')
                        ->where('Status_legis','=','ปิดจบรถยึด')
                        ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                            return $q->whereBetween('DateStatus_legis',[$Fdate,$Tdate]);
                            })
                        ->get();
          
        $dataEndcase4 = Legislation::where('Status_legis', '!=',NULL)
                        ->where('Flag', 'Y')
                        ->where('Status_legis','=','ปิดจบถอนบังคับคดี')
                        ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                            return $q->whereBetween('DateStatus_legis',[$Fdate,$Tdate]);
                            })
                        ->get();

        $dataEndcaseNew = Legislation::where('Status_legis', '=', 'ปิดจบประนอม') //ปิดจบงานประนอมใหม่
                        ->where('Flag', 'Y')
                        ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                            return $q->whereBetween('DateStatus_legis',[$Fdate,$Tdate]);
                            })
                        ->get();
        $dataEndcaseOld = Legislation::where('Status_legis', '=', 'ปิดจบประนอม') //ปิดจบงานประนอมเก่า
                        ->where('Flag', 'C')
                        ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                            return $q->whereBetween('DateStatus_legis',[$Fdate,$Tdate]);
                            })
                        ->get();

        $dataAsset = Legislation::where('Status_legis', NULL) //ลูกหนี้มีทรัพย์
                        ->Wherehas('Legisasset',function ($query) {
                            return $query->where('propertied_asset', '!=', NULL);
                        })
                        ->with('Legisasset')
                        ->get();

                        $dataAsset_yes = 0;
                        $dataAsset_no = 0;

                        foreach($dataAsset as $data){
                            if($request->get('dateSearch') == NULL){
                                if($data->Legisasset->propertied_asset == 'Y'){
                                    $dataAsset_yes += 1;
                                }
                                elseif($data->Legisasset->propertied_asset == 'N'){
                                    $dataAsset_no += 1;
                                }
                            }
                            else{
                                if($data->Legisasset->Date_asset >= $Fdate && $data->Legisasset->Date_asset <= $Tdate){
                                    if($data->Legisasset->propertied_asset == 'Y'){
                                        $dataAsset_yes += 1;
                                    }
                                    elseif($data->Legisasset->propertied_asset == 'N'){
                                        $dataAsset_no += 1;
                                    }
                                }
                            }
                        }

        $SubId = Legislation::select('id')
                ->where('Status_legis', NULL)
                ->Wherehas('Legisasset')
                ->groupBy('id')
                ->get();

        $dataAsset_null = Legislation::WhereNotIn('id', $SubId->toArray())
                        ->where('Flag_status', 2)
                        ->where('Status_legis', NULL)
                        ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                            return $q->whereBetween('DateStatus_legis',[$Fdate,$Tdate]);
                            })
                        ->get();

        // $AmountNew_Pay = 0;
        // $AmountNew_noPay = 0;
        // $NewPranom_Month = Legislation::where('Flag', 'Y') //ลูกหนี้ประนอมหนี้ใหม่
        //                 ->where('Status_legis', NULL)
        //                 // ->Wherehas('legispayments',function ($query) {
        //                 //     return $query->whereBetween('DateDue_Payment', [date('Y-m-01'),date('Y-m-31')]);
        //                 // })
        //                 // ->Wherehas('legispayments',function ($query) {
        //                 //     return $query->where('Flag_Payment', 'Y');
        //                 // })
        //                 ->with('legisCompromise')
        //                 ->with('legispayments')
        //                 ->get();

        //                 for ($i=0; $i < count($NewPranom_Month); $i++) { 
        //                     if(@$NewPranom_Month[$i]->legispayments->DateDue_Payment >= date('Y-m-01') && @$NewPranom_Month[$i]->legispayments->DateDue_Payment <= date('Y-m-31')){
        //                         if($NewPranom_Month[$i]->legispayments->Flag_Payment == 'Y'){
        //                             $AmountNew_Pay += 1;
        //                         }
        //                         else{
        //                             $AmountNew_noPay += 1;
        //                         }
        //                     }
        //                 }
        //                 dd($NewPranom_Month,$AmountNew_Pay,$AmountNew_noPay);

        //ยอดเงินประนอมหนี้ใหม่ประจำเดือน
        // $AmountNew_Pay = 0;
        // $AmountNew_noPay = 0;
        // $SumNew_All = 0;
        // $SumNew_Pay = 0;
        // $SumNew_noPay = 0;
        // $dataGet_New = legispayment::whereBetween('DateDue_Payment',[date('Y-m-01'),date('Y-m-31')])
        //         ->Wherehas('PaymentTolegislation',function ($query) {
        //         return $query->where('Flag', 'Y');
        //         })
        //         ->Wherehas('PaymentTolegislation',function ($query) {
        //             return $query->where('Status_legis', NULL);
        //             })
        //         ->with('PaymentToCompro')
        //         ->get();

        //         for ($i=0; $i < count($dataGet_New); $i++) { 
        //             @$SumNew_All += $dataGet_New[$i]->PaymentToCompro->DuePay_Promise;
        //             if($dataGet_New[$i]->Flag_Payment == 'Y'){
        //                 $AmountNew_Pay += 1;
        //                 @$SumNew_Pay += $dataGet_New[$i]->PaymentToCompro->DuePay_Promise;
        //             }
        //             else{
        //                 $AmountNew_noPay += 1;
        //                 @$SumNew_noPay += $dataGet_New[$i]->PaymentToCompro->DuePay_Promise;
        //             }
        //         }

        //ยอดเงินประนอมหนี้เก่าประจำเดือน
        // $AmountOld_Pay = 0;
        // $AmountOld_noPay = 0;
        // $SumOld_All = 0;
        // $SumOld_Pay = 0;
        // $SumOld_noPay = 0;
        // $dataGet_Old = legispayment::whereBetween('DateDue_Payment',[date('Y-m-01'),date('Y-m-31')])
        //         ->Wherehas('PaymentTolegislation',function ($query) {
        //         return $query->where('Flag', 'C');
        //         })
        //         ->Wherehas('PaymentTolegislation',function ($query) {
        //             return $query->where('Status_legis', NULL);
        //             })
        //         ->with('PaymentToCompro')
        //         ->get();

        //         for ($i=0; $i < count($dataGet_Old); $i++) { 
        //             @$SumOld_All += $dataGet_Old[$i]->PaymentToCompro->DuePay_Promise;
        //             if($dataGet_Old[$i]->Flag_Payment == 'Y'){
        //                 $AmountOld_Pay += 1;
        //                 @$SumOld_Pay += $dataGet_Old[$i]->PaymentToCompro->DuePay_Promise;
        //             }
        //             else{
        //                 $AmountOld_noPay += 1;
        //                 @$SumOld_noPay += $dataGet_Old[$i]->PaymentToCompro->DuePay_Promise;
        //             }
        //         }

        $lastday1 = date('Y-m-d', strtotime("-1 month"));
        $lastday2 = date('Y-m-d', strtotime("-2 month"));
        $lastday3 = date('Y-m-d', strtotime("-3 month"));
        $lastday4 = date('Y-m-d', strtotime("-4 month"));
  
        $dataPranom_new = Legislation::where('Flag', 'Y') //ลูกหนี้ประนอมหนี้ใหม่
                    ->where('Status_legis', NULL)
                    ->Wherehas('legispayments',function ($query) {
                    return $query->where('Flag_Payment', 'Y');
                    })
                    ->with(['legispayments' => function ($query) {
                    return $query->where('Flag_Payment', 'Y');
                    }])
                    ->with('legisTrackings')
                    ->get();
              
                        $New_Count1 = 0;
                        $New_Count1_1 = 0;
                        $New_Count1_2 = 0;
                        $New_Count1_3 = 0;
              
                        for($j= 0; $j < count($dataPranom_new); $j++){
                          if (@$dataPranom_new[$j]->legisTrackings->Status_Track != 'Y') {
                              if($request->get('dateSearch') == NULL){
                                  if($dataPranom_new[$j]->legispayments->DateDue_Payment >= date('Y-m-d') or $dataPranom_new[$j]->legispayments->DateDue_Payment > $lastday1) {
                                    $New_Count1 += 1;
                                  }elseif($dataPranom_new[$j]->legispayments->DateDue_Payment > $lastday1 or $dataPranom_new[$j]->legispayments->DateDue_Payment > $lastday2){
                                    $New_Count1_1 += 1;
                                  }elseif($dataPranom_new[$j]->legispayments->DateDue_Payment > $lastday2 or $dataPranom_new[$j]->legispayments->DateDue_Payment > $lastday3){
                                    $New_Count1_2 += 1;
                                  }elseif($dataPranom_new[$j]->legispayments->DateDue_Payment > $lastday3 or $dataPranom_new[$j]->legispayments->DateDue_Payment > $lastday4){
                                    $New_Count1_3 += 1;
                                  }
                              }
                              else{
                                if(@$dataPranom_new[$j]->legispayments->DateDue_Payment >= $Fdate && @$dataPranom_new[$j]->legispayments->DateDue_Payment <= $Tdate){
                                  if($dataPranom_new[$j]->legispayments->DateDue_Payment >= date('Y-m-d') or $dataPranom_new[$j]->legispayments->DateDue_Payment > $lastday1) {
                                    $New_Count1 += 1;
                                  }elseif($dataPranom_new[$j]->legispayments->DateDue_Payment > $lastday1 or $dataPranom_new[$j]->legispayments->DateDue_Payment > $lastday2){
                                    $New_Count1_1 += 1;
                                  }elseif($dataPranom_new[$j]->legispayments->DateDue_Payment > $lastday2 or $dataPranom_new[$j]->legispayments->DateDue_Payment > $lastday3){
                                    $New_Count1_2 += 1;
                                  }elseif($dataPranom_new[$j]->legispayments->DateDue_Payment > $lastday3 or $dataPranom_new[$j]->legispayments->DateDue_Payment > $lastday4){
                                    $New_Count1_3 += 1;
                                  }
                                }
                              }
                          }
                        }

        $dataPranom_old = Legislation::where('Flag', 'C') //ลูกหนี้ประนอมหนี้เก่า
                    ->where('Status_legis', NULL)
                    ->with(['legispayments' => function ($query) {
                        return $query->where('Flag_Payment', 'Y');
                    }])
                    ->with('legisTrackings')
                    ->get();
              
                      $Old_Count1 = 0;
                      $Old_Count1_1 = 0;
                      $Old_Count1_2 = 0;
                      $Old_Count1_3 = 0;
                      $Old_CountNullData = 0;
              
                      for($j= 0; $j < count($dataPranom_old); $j++){
                        if (@$dataPranom_old[$j]->legisTrackings->Status_Track != 'Y') {
                            if($request->get('dateSearch') == NULL){
                                if ($dataPranom_old[$j]->legispayments != NULL) {
                                    if($dataPranom_old[$j]->legispayments->DateDue_Payment >= date('Y-m-d') or $dataPranom_old[$j]->legispayments->DateDue_Payment > $lastday1) {
                                        $Old_Count1 += 1;
                                    }elseif($dataPranom_old[$j]->legispayments->DateDue_Payment > $lastday1 or $dataPranom_old[$j]->legispayments->DateDue_Payment > $lastday2){
                                        $Old_Count1_1 += 1;
                                    }elseif($dataPranom_old[$j]->legispayments->DateDue_Payment > $lastday2 or $dataPranom_old[$j]->legispayments->DateDue_Payment > $lastday3){
                                        $Old_Count1_2 += 1;
                                    }elseif($dataPranom_old[$j]->legispayments->DateDue_Payment > $lastday3 or $dataPranom_old[$j]->legispayments->DateDue_Payment > $lastday4){
                                        $Old_Count1_3 += 1;
                                    }
                                }
                                else {
                                    $Old_CountNullData += 1;
                                }
                            }
                            else{
                                if(@$dataPranom_old[$j]->legispayments->DateDue_Payment >= $Fdate && @$dataPranom_old[$j]->legispayments->DateDue_Payment <= $Tdate){
                                    if ($dataPranom_old[$j]->legispayments != NULL) {
                                        if($dataPranom_old[$j]->legispayments->DateDue_Payment >= date('Y-m-d') or $dataPranom_old[$j]->legispayments->DateDue_Payment > $lastday1) {
                                            $Old_Count1 += 1;
                                        }elseif($dataPranom_old[$j]->legispayments->DateDue_Payment > $lastday1 or $dataPranom_old[$j]->legispayments->DateDue_Payment > $lastday2){
                                            $Old_Count1_1 += 1;
                                        }elseif($dataPranom_old[$j]->legispayments->DateDue_Payment > $lastday2 or $dataPranom_old[$j]->legispayments->DateDue_Payment > $lastday3){
                                            $Old_Count1_2 += 1;
                                        }elseif($dataPranom_old[$j]->legispayments->DateDue_Payment > $lastday3 or $dataPranom_old[$j]->legispayments->DateDue_Payment > $lastday4){
                                            $Old_Count1_3 += 1;
                                        }
                                    }
                                    else {
                                        $Old_CountNullData += 1;
                                    }
                                }
                            }
                        }
                      }


        $dataNewPranom = Legislation::where('Flag', 'Y') //แจ้งเตือนขาดชำระประนอมใหม่
                        ->where('Status_legis', NULL)
                        ->Wherehas('legispayments',function ($query) {
                            return $query->where('Flag_Payment', 'Y');
                        })
                        ->with(['legispayments' => function ($query) {
                            return $query->where('Flag_Payment', 'Y');
                        }])
                        ->with('legisTrackings')
                        ->get();

                        $MissPay_pranom_new = 0;
                        for($k= 0; $k < count($dataNewPranom); $k++){
                            if (@$dataNewPranom[$k]->legisTrackings->Status_Track != 'Y') {
                                if($request->get('dateSearch') == NULL){
                                    if($dataNewPranom[$k]->legispayments->DateDue_Payment <= $lastday4){
                                        $MissPay_pranom_new += 1;
                                    }
                                }
                                else{
                                    if(@$dataNewPranom[$k]->legispayments->DateDue_Payment >= $Fdate && @$dataNewPranom[$k]->legispayments->DateDue_Payment <= $Tdate){
                                        if($dataNewPranom[$k]->legispayments->DateDue_Payment <= $lastday4){
                                            $MissPay_pranom_new += 1;
                                        }
                                    }
                                }
                            }
                        }


        $dataOldPranom = Legislation::where('Flag', 'C') //แจ้งเตือนขาดชำระประนอมเก่า
                    ->where('Status_legis', NULL)
                    ->with(['legispayments' => function ($query) {
                    return $query->where('Flag_Payment', 'Y');
                    }])
                    ->with('legisTrackings')
                    ->get();

                    $MissPay_pranom_old = 0;
                    for($l= 0; $l < count($dataOldPranom); $l++){
                        if (@$dataOldPranom[$l]->legisTrackings->Status_Track != 'Y') {
                            if($dataOldPranom[$l]->legispayments != NULL){
                                if($request->get('dateSearch') == NULL){
                                    if($dataOldPranom[$l]->legispayments->DateDue_Payment <= $lastday4){
                                        $MissPay_pranom_old += 1;
                                    }
                                }
                                else{
                                    if(@$dataOldPranom[$l]->legispayments->DateDue_Payment >= $Fdate && @$dataOldPranom[$l]->legispayments->DateDue_Payment <= $Tdate){
                                        if($dataOldPranom[$l]->legispayments->DateDue_Payment <= $lastday4){
                                            $MissPay_pranom_old += 1;
                                        }
                                    }
                                }
                            }
                        }
                    }

        if ($request->get('dateSearch') != NULL) {
            $SetFdate = substr($dateSearch,0,10);
            $newfdate = date('Y-m-d 00:00:00', strtotime($SetFdate));
            $SetTdate = substr($dateSearch,13,21);
            $newtdate = date('Y-m-d 23:59:59', strtotime($SetTdate));
        }
        else{
            // $newfdate = date('Y-m-01 h:i:s');
            // $newtdate = \Carbon\Carbon::parse(date('Y-m-d h:i:s'))->addDays(1);
            $newfdate = date('2015-01-01 h:i:s');
            $newtdate = \Carbon\Carbon::parse(date('Y-12-31 h:i:s'))->addYears(1);
        }

        $dataTracking_new = Legislation::where('Flag', 'Y') //แจ้งเตือนติดตามประนอมใหม่
                ->where('Status_legis', NULL)
                ->Wherehas('legisTrackings',function ($query) {
                    return $query->where('Status_Track','Y');
                })
                ->get();

                // dd($dataTracking_new);
                
                $Track_pranom_new = 0;
                for($m = 0; $m < count($dataTracking_new); $m++){
                    if(@$dataTracking_new[$m]->legisTrackings->created_at >= $newfdate && @$dataTracking_new[$m]->legisTrackings->created_at <= $newtdate){
                        $Track_pranom_new += 1;
                    }
                }
                // dd($dataTracking_new[0],$Track_pranom_new);
          
        $dataTracking_old = Legislation::where('Flag', 'C') //แจ้งเตือนติดตามประนอมเก่า
                ->where('Status_legis', NULL)
                ->Wherehas('legisTrackings',function ($query) {
                    return $query->where('Status_Track','Y');
                })
                ->get();

                $Track_pranom_old = 0;
                for($m = 0; $m < count($dataTracking_old); $m++){
                    if(@$dataTracking_old[$m]->legisTrackings->created_at >= $newfdate && @$dataTracking_old[$m]->legisTrackings->created_at <= $newtdate){
                        $Track_pranom_old += 1;
                    }
                }

        if ($request->get('dateSearch') != NULL) {
            $SetFdate = substr($dateSearch,0,10);
            $newfdate = date('Y-m-d 00:00:00', strtotime($SetFdate));
            $SetTdate = substr($dateSearch,13,21);
            $newtdate = date('Y-m-d 23:59:59', strtotime($SetTdate));
    
            $dataGetpay_new = legispayment::when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                return $q->whereBetween('created_at',[$newfdate,$newtdate]);
                })
                ->Wherehas('PaymentTolegislation',function ($query) {
                return $query->where('Flag', 'Y');
                })
                ->Wherehas('PaymentTolegislation',function ($query) {
                    return $query->where('DateStatus_legis', NULL);
                })
                ->with(['PaymentToCompro' => function ($query) {
                    return $query->where('Date_Promise', '!=', NULL);
                }])
                ->count();
                
            $dataGetpay_old = legispayment::when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                return $q->whereBetween('created_at',[$newfdate,$newtdate]);
                })
                ->Wherehas('PaymentTolegislation',function ($query) {
                return $query->where('Flag', 'C');
                })
                ->Wherehas('PaymentTolegislation',function ($query) {
                    return $query->where('DateStatus_legis', NULL);
                })
                ->with(['PaymentToCompro' => function ($query) {
                    return $query->where('Date_Promise', '!=', NULL);
                }])
                ->count();

            $dataPayment = legispayment::when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) { //รับชำระ
                            return $q->whereBetween('created_at',[$newfdate,$newtdate]);
                            })
                        ->Wherehas('PaymentTolegislation',function ($query) {
                            return $query->where('DateStatus_legis', NULL);
                            })
                        ->get();
        }
        else{
            // $newfdate = date('Y-m-01 h:i:s');
            // $newtdate = \Carbon\Carbon::parse(date('Y-m-d h:i:s'))->addDays(1);
            $newfdate = date('Y-m-01 h:i:s');
            $newtdate = \Carbon\Carbon::parse(date('Y-m-d h:i:s'))->addDays(1);
    
            $dataGetpay_new = legispayment::whereBetween('created_at',[$newfdate,$newtdate])
                ->Wherehas('PaymentTolegislation',function ($query) {
                return $query->where('Flag', 'Y');
                })
                ->Wherehas('PaymentTolegislation',function ($query) {
                    return $query->where('DateStatus_legis', NULL);
                })
                ->with(['PaymentToCompro' => function ($query) {
                return $query->where('Date_Promise', '!=', NULL);
                }])
                ->count();
    
            $dataGetpay_old = legispayment::whereBetween('created_at',[$newfdate,$newtdate])
                ->Wherehas('PaymentTolegislation',function ($query) {
                return $query->where('Flag', 'C');
                })
                ->Wherehas('PaymentTolegislation',function ($query) {
                    return $query->where('DateStatus_legis', NULL);
                })
                ->with(['PaymentToCompro' => function ($query) {
                return $query->where('Date_Promise', '!=', NULL);
                }])
                ->count();

            $dataPayment = legispayment::whereBetween('created_at',[$newfdate,$newtdate]) //รับชำระ
                        ->Wherehas('PaymentTolegislation',function ($query) {
                            return $query->where('DateStatus_legis', NULL);
                        })
                        ->get();
        }

            $User1 = 0;
            $SumUser1 = 0;
            $User2 = 0;
            $SumUser2 = 0;
            $User3 = 0;
            $SumUser3 = 0;
            $User4 = 0;
            $SumUser4 = 0;
            $UserOther = 0;
            $SumUserOther = 0;
            for ($i=0; $i < count($dataPayment); $i++) { 
                if($dataPayment[$i]->Adduser_Payment == 'บุปผา วงศ์สนิท'){
                    $User1 += 1;
                    $SumUser1 += $dataPayment[$i]->Gold_Payment;
                }
                elseif($dataPayment[$i]->Adduser_Payment == 'ฮานีซะห์ ดือเระ'){
                    $User2 += 1;
                    $SumUser2 += $dataPayment[$i]->Gold_Payment;
                }
                elseif($dataPayment[$i]->Adduser_Payment == 'กรองกาญจน์ เวชรักษ์'){
                    $User3 += 1;
                    $SumUser3 += $dataPayment[$i]->Gold_Payment;
                }
                elseif($dataPayment[$i]->Adduser_Payment == 'ดาริณี ซ่อนกลิ่น'){
                    $User4 += 1;
                    $SumUser4 += $dataPayment[$i]->Gold_Payment;
                }
                else{
                    $UserOther += 1;
                    $SumUserOther += $dataPayment[$i]->Gold_Payment;
                }
            }

        if ($request->get('dateSearch') == NULL) {
            $Fdate = NULL;
            $Tdate = NULL;
        }
        else{
            $dateSearch = $request->dateSearch;
            $SetFdate = substr($dateSearch,0,10);
            $Fdate = date('Y-m-d', strtotime($SetFdate));

            $SetTdate = substr($dateSearch,13,21);
            $Tdate = date('Y-m-d', strtotime($SetTdate));
        }

            $dataCapital_new = Legiscompromise::where('Date_Promise','!=', null) //ยอดประหนี้ใหม่
                    ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                        return $q->whereBetween('Date_Promise',[$Fdate,$Tdate]);
                    })
                    ->Wherehas('ComproTolegislation',function ($query) {
                        return $query->where('Flag', 'Y');
                        })
                    ->get();

            $dataCapital_old = Legiscompromise::where('Date_Promise','!=', null) //ยอดประหนี้เก่า
                    ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                        return $q->whereBetween('Date_Promise',[$Fdate,$Tdate]);
                    })
                    ->Wherehas('ComproTolegislation',function ($query) {
                        return $query->where('Flag', 'C')->where('Flag_status', '3');
                        })
                    // ->Wherehas('ComproTolegislation',function ($query) {
                    //     return $query->where('Flag_status', '3');
                    //     })
                    ->get();

                    $SumNew1 = 0;
                    $SumNew2 = 0;
                    $SumNewPrice = 0;
                    $SumNewDiscount = 0;

                    foreach ($dataCapital_new as $key => $value) {
                        $SumNew1 += $value->Total_Promise;
                        $SumNew2 += $value->Sum_Promise;
                        $SumNewPrice += ($value->Sum_FirstPromise + $value->Sum_DuePayPromise);
                        $SumNewDiscount += $value->Discount_Promise;
                    }

                    $SumOld1 = 0;
                    $SumOld2 = 0;
                    $SumOldPrice = 0;
                    $SumOldDiscount = 0;

                    foreach ($dataCapital_old as $key => $value) {
                        $SumOld1 += $value->Total_Promise;
                        $SumOld2 += $value->Sum_Promise;
                        $SumOldPrice += ($value->Sum_FirstPromise + $value->Sum_DuePayPromise);
                        $SumOldDiscount += $value->Discount_Promise;
                    }

            $dataKlang = Legisexhibit::where('Typeexhibit_legis','ของกลาง') //ลูกหนี้ของกลาง ประเภทที่1
                    ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                        return $q->whereBetween('Dateaccept_legis',[$Fdate,$Tdate]);
                    })
                    ->get();
    
            $dataMatrakarn = Legisexhibit::where('Typeexhibit_legis','ยึดตามมาตราการ(ปปส.)') //ลูกหนี้ของกลาง ประเภทที่2
                    ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                        return $q->whereBetween('Dateaccept_legis',[$Fdate,$Tdate]);
                    })
                    ->get();
    
            $dataNotspecific = Legisexhibit::where('Typeexhibit_legis',NULL) //ลูกหนี้ของกลาง ประเภทที่3
                    ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                        return $q->whereBetween('Dateaccept_legis',[$Fdate,$Tdate]);
                    })
                    ->get();

            $dataInternal_N = Legisexpense::where('Type_expense','=','ภายในศาล')
                    ->where('Flag_expense','=','wait')
                    ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                        return $q->whereBetween('Date_expense',[$Fdate,$Tdate]);
                    })
                    ->get();
            $SumInternal_N = 0;
                for ($i=0; $i < count($dataInternal_N); $i++) { 
                    $SumInternal_N += $dataInternal_N[$i]->Amount_expense;
                }

            $dataInternal_Y = Legisexpense::where('Type_expense','=','ภายในศาล')
                    ->where('Flag_expense','=','complete')
                    ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                        return $q->whereBetween('Date_expense',[$Fdate,$Tdate]);
                    })
                    ->get();
            $SumInternal_Y = 0;
                for ($j=0; $j < count($dataInternal_Y); $j++) { 
                    $SumInternal_Y += $dataInternal_Y[$j]->Amount_expense;
                }
    
            $dataExtra_N = Legisexpense::where('Type_expense','=','ค่าพิเศษ')
                    ->where('Flag_expense','=','wait')
                    ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                        return $q->whereBetween('Date_expense',[$Fdate,$Tdate]);
                    })
                    ->selectRaw('count(id) as Total,Type_expense,Code_expense,Amount_expense,Topic_expense,Note_expense,Receiptno_expense,Flag_expense,Useradd_expense,Date_expense,DateApprove_expense')
                    ->groupBy('Code_expense','Type_expense','Amount_expense','Topic_expense','Note_expense','Receiptno_expense','Flag_expense','Useradd_expense','Date_expense','DateApprove_expense')
                    ->get();
    
            $SumExtra_N = 0;
                for ($j=0; $j < count($dataExtra_N); $j++) { 
                    $SumExtra_N += $dataExtra_N[$j]->Amount_expense * $dataExtra_N[$j]->Total;
                }

            $dataExtra_Y = Legisexpense::where('Type_expense','=','ค่าพิเศษ')
                    ->where('Flag_expense','=','complete')
                    ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                        return $q->whereBetween('Date_expense',[$Fdate,$Tdate]);
                    })
                    ->selectRaw('count(id) as Total,Type_expense,Code_expense,Amount_expense,Topic_expense,Note_expense,Receiptno_expense,Flag_expense,Useradd_expense,Date_expense,DateApprove_expense')
                    ->groupBy('Code_expense','Type_expense','Amount_expense','Topic_expense','Note_expense','Receiptno_expense','Flag_expense','Useradd_expense','Date_expense','DateApprove_expense')
                    ->get();
    
            $SumExtra_Y = 0;
                for ($j=0; $j < count($dataExtra_Y); $j++) { 
                    $SumExtra_Y += $dataExtra_Y[$j]->Amount_expense * $dataExtra_Y[$j]->Total;
                }

            $dataReserve_N = Legisexpense::where('Type_expense','=','เบิกสำรองจ่าย')
                    ->whereIn('Flag_expense',['wait','process'])
                    ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                        return $q->whereBetween('Date_expense',[$Fdate,$Tdate]);
                    })
                    ->get();
            $SumReserve_N = 0;
                for ($i=0; $i < count($dataReserve_N); $i++) { 
                    $SumReserve_N += $dataReserve_N[$i]->Amount_expense;
                }

            $dataReserve_Y = Legisexpense::where('Type_expense','=','เบิกสำรองจ่าย')
                    ->where('Flag_expense','=','complete')
                    ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                        return $q->whereBetween('Date_expense',[$Fdate,$Tdate]);
                    })
                    ->get();
            $SumReserve_Y = 0;
                for ($j=0; $j < count($dataReserve_Y); $j++) { 
                    $SumReserve_Y += $dataReserve_Y[$j]->Amount_expense;
                }

            $dataExhibit_N = Legisexpense::where('Type_expense','=','ค่าของกลาง')
                    ->whereIn('Flag_expense',['wait','process'])
                    ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                        return $q->whereBetween('Date_expense',[$Fdate,$Tdate]);
                    })
                    ->get();
            $SumExhibit_N = 0;
                for ($i=0; $i < count($dataExhibit_N); $i++) { 
                    $SumExhibit_N += $dataExhibit_N[$i]->Amount_expense;
                }

            $dataExhibit_Y = Legisexpense::where('Type_expense','=','ค่าของกลาง')
                    ->where('Flag_expense','=','complete')
                    ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                        return $q->whereBetween('Date_expense',[$Fdate,$Tdate]);
                    })
                    ->get();
            $SumExhibit_Y = 0;
            for ($j=0; $j < count($dataExhibit_Y); $j++) { 
                $SumExhibit_Y += $dataExhibit_Y[$j]->Amount_expense;
            }

            // dd($dataReserve_N,$dataReserve_Y,$dataExternal_N);
            if ($request->get('dateSearch') == NULL) {
                $Fdate = date('Y-m-01');
                $Tdate = date('Y-m-d',strtotime("+1 days"));
            }
            else{
                $dateSearch = $request->dateSearch;
                $SetFdate = substr($dateSearch,0,10);
                $Fdate = date('Y-m-d 00:00:00', strtotime($SetFdate));
                $SetTdate = substr($dateSearch,13,21);
                $Tdate = date('Y-m-d 23:59:59', strtotime($SetTdate));
            }

            $dataAllPranomN = Legislation::where('Status_legis', NULL)
                ->where('Flag', 'Y')
                ->with(['legisCompromise' => function ($query) {
                    return $query->where('Date_Promise', '!=', NULL);
                }])
                ->Wherehas('legisCompromise',function ($query) {
                    return $query->where('Date_Promise', '!=', NULL);
                })
                ->count();

            $dataPayPranomN = Legislation::where('Status_legis', NULL)
                ->where('Flag', 'Y')
                ->with(['legisCompromise' => function ($query) {
                    return $query->where('Date_Promise', '!=', NULL);
                }])
                ->Wherehas('legisCompromise',function ($query) {
                    return $query->where('Date_Promise', '!=', NULL);
                })
                ->Wherehas('legispayments',function ($query) use($Fdate, $Tdate) {
                    return $query->when(!empty($Fdate) && !empty($Tdate), function($q) use($Fdate, $Tdate) {
                      return $q->whereBetween('created_at',[$Fdate,$Tdate]);
                    });
                  })
                ->count();

            $dataAllPranomO = Legislation::where('Status_legis', NULL)
                ->where('Flag', 'C')
                ->with(['legisCompromise' => function ($query) {
                    return $query->where('Date_Promise', '!=', NULL);
                }])
                ->Wherehas('legisCompromise',function ($query) {
                    return $query->where('Date_Promise', '!=', NULL);
                })
                ->count();

            $dataPayPranomO = Legislation::where('Status_legis', NULL)
                ->where('Flag', 'C')
                ->with(['legisCompromise' => function ($query) {
                    return $query->where('Date_Promise', '!=', NULL);
                }])
                ->Wherehas('legisCompromise',function ($query) {
                    return $query->where('Date_Promise', '!=', NULL);
                })
                ->Wherehas('legispayments',function ($query) use($Fdate, $Tdate) {
                    return $query->when(!empty($Fdate) && !empty($Tdate), function($q) use($Fdate, $Tdate) {
                      return $q->whereBetween('created_at',[$Fdate,$Tdate]);
                    });
                  })
                ->count();

                // dd($dataPayPranomN);

            if($request->get('FlagTab') == NULL){
                $FlagTab = NULL;
            }
            else{
                $FlagTab = $request->FlagTab;
            }

        return view($name, compact('dateSearch','FlagTab','dataPrepareLaw','dataSentLaw','dataPrepare','dataSue','dataTestify','dataSubmit_decree','dataSend_warrant',
                                   'dataSet_staff','dataSet_warrant','dataSubmit_deed','dataSet_foreclosure',
                                   'dataEndcase','dataEndcase1','dataEndcase2','dataEndcase3','dataEndcase4','dataEndcaseNew','dataEndcaseOld',
                                   'dataCourtcase1','dataCourtcase2','dataCourtcase3','dataCourtcase4','dataCourtcase5',
                                   'dataAsset_yes','dataAsset_no','dataAsset_null',
                                   'User1','SumUser1','User2','SumUser2','User3','SumUser3','User4','SumUser4','UserOther','SumUserOther',
                                   'New_Count1','New_Count1_1','New_Count1_2','New_Count1_3','dataPayPranomN','dataAllPranomN',
                                   'Old_Count1','Old_Count1_1','Old_Count1_2','Old_Count1_3','Old_CountNullData','dataPayPranomO','dataAllPranomO',
                                   'MissPay_pranom_new','MissPay_pranom_old','Track_pranom_new','Track_pranom_old','dataGetpay_new','dataGetpay_old',
                                   'SumNew1','SumNew2','SumNewPrice','SumNewDiscount',
                                   'SumOld1','SumOld2','SumOldPrice','SumOldDiscount',
                                   'dataKlang','dataMatrakarn','dataNotspecific','dataReserve_N','dataReserve_Y','SumReserve_N','SumReserve_Y','dataExhibit_N','dataExhibit_Y','SumExhibit_N','SumExhibit_Y',
                                   'dataInternal_N','dataInternal_Y','dataExtra_N','dataExtra_Y','SumInternal_N','SumInternal_Y','SumExtra_N','SumExtra_Y',
                                   'dataGet_New','AmountNew_Pay','AmountNew_noPay','SumNew_All','SumNew_Pay','SumNew_noPay',
                                   'dataGet_Old','AmountOld_Pay','AmountOld_noPay','SumOld_All','SumOld_Pay','SumOld_noPay'));
    }

}

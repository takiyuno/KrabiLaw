<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Excel;
use PDF;
use Picqer;
use QrCode;
use Storage;
use Carbon\Carbon;

use App\User;
use App\Legislation;
use App\Legiscompromise;
use App\legispayment;
use App\LegisTrackings;
use App\compromises_paydue;
use App\compromises_firstdue;
class LegisComproController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $Fdate = '';
      $Tdate = '';
      $dateSearch = '';
      if ($request->has('dateSearch')) {
        $dateSearch = $request->get('dateSearch');

        $SetFdate = substr($dateSearch,0,10);
        $Fdate = date('Y-m-d', strtotime($SetFdate));

        $SetTdate = substr($dateSearch,13,21);
        $Tdate = date('Y-m-d', strtotime($SetTdate));
      }

      if ($request->type == 1) {       //หน้าหลัก ประนอมหนี้
          $dataNew = DB::table('legislations')
              ->join('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
              ->where('legislations.Flag_status','=', '3')
              ->where('legislations.Flag','!=', 'C')
              ->get();

              // dd($dataNew);

          $dataOld = DB::table('legislations')
              ->join('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
              ->where('legislations.Flag_status','=', '3')
              ->where('legislations.Flag','=', 'C')
              ->get();

          $data1 = count($dataNew);
          $data2 = count($dataOld);

          $Sum1 = 0;
          $Sum2 = 0;
          $SumPrice1 = 0;
          $SumDiscount1 = 0;

          $Sum3 = 0;
          $Sum4 = 0;
          $SumPrice2 = 0;
          $SumDiscount2 = 0;

          foreach ($dataNew as $key => $value) {
            $Sum1 += $value->Total_Promise;
            $Sum2 += $value->Sum_Promise;
            $SumPrice1 += ($value->Sum_FirstPromise + $value->Sum_DuePayPromise);
            $SumDiscount1 += $value->Discount_Promise;
          }
          foreach ($dataOld as $key => $value) {
            $Sum3 += $value->Total_Promise;
            $Sum4 += $value->Sum_Promise;
            $SumPrice2 += ($value->Sum_FirstPromise + $value->Sum_DuePayPromise);
            $SumDiscount2 += $value->Discount_Promise;
          }

          $type = $request->type;
          return view('legislation.viewCompro', compact('dataNew','dataOld','type','data1','data2',
                                                        'Sum1','Sum2','SumPrice1','SumDiscount1','Sum3','Sum4','SumPrice2','SumDiscount2'));
      }
      elseif ($request->type == 2) {   //ลูกหนี้ประนอมหนี้(ใหม่)
        // dump($request);
          $lastday1 = date('Y-m-d', strtotime("-1 month"));
          $lastday2 = date('Y-m-d', strtotime("-2 month"));
          $lastday3 = date('Y-m-d', strtotime("-3 month"));
          $lastday4 = date('Y-m-d', strtotime("-4 month"));

       


          $dataNormal = Legislation::where('Flag_status',3)
            ->where('Status_legis', NULL)
           
            // ->Wherehas('legispayments',function ($query) {
            //   return $query->where('Flag_Payment', 'Y');
            // })
            ->with(['legispayments' => function ($query) {
              return $query->where('Flag_Payment', 'Y')->selectRaw('*,DATEDIFF(day,  DateDue_Payment ,CONVERT (Date, GETDATE()))/30 as monthdiff');
            }])
            ->Wherehas('legisCompromise',function ($query) use($Fdate, $Tdate) {
              return $query->when(!empty($Fdate) && !empty($Tdate), function($q) use($Fdate, $Tdate) {
                return $q->whereBetween('Date_Promise',[$Fdate,$Tdate]);
              });
              
            })
           
            ->with('legisTrackings')
            ->get();
            $dataEndcaseOld = Legislation::where('Status_legis', '=', 'ปิดจบประนอม') //ปิดจบงานประนอมเก่า
                        ->where('Flag_status',3)
                        ->get();
            // dump($dataNormal);
        
            

          $Count1 = 0;
          $Count1_1 = 0;
          $Count1_2 = 0;
          $Count1_3 = 0;
          $Count1_4 = 0;
          $Count1_5 = 0;
          $CountNullData = 0;
          $data1 = [];
          $data1_1 = [];
          $data1_2 = [];
          $data1_3 = [];
          $data1_4 = []; 
          $data1_5 = []; 
          $NullData = [];  
$numDue = 0;

          for($j= 0; $j < count($dataNormal); $j++){
            
                // $d1 = date_create(@$dataNormal[$j]->legispayments->DateDue_Payment );
                // $d2 = date_create(date('Y-m-d'));
               
           
                // $interval = date_diff($d1,$d2);
              
                // $numMonth = $interval->format('%m');
                // $numYear = $interval->format('%y');
               
             
              //$numDue = @$dataNormal[$j]->legispayments->monthdiff;
              $numDue = @$dataNormal[$j]->legisCompromise->HLDNO;
              $Fpayment = floatval($dataNormal[$j]->legisCompromise->Sum_FirstPromise) - floatval($dataNormal[$j]->legisCompromise->FirstManey_1);
                if ($dataNormal[$j]->legispayments != NULL && $Fpayment>=0) {  
                  
                  if($numDue>3) {
                    $Count1_4 += 1;
                    $data1_4[] = $dataNormal[$j];                    
                  }elseif($numDue>2){  
                    $Count1_3 += 1;
                    $data1_3[] = $dataNormal[$j];
                    
                  }elseif($numDue>1){
                    $Count1_2 += 1;
                    $data1_2[] = $dataNormal[$j];
                  }elseif($numDue>0){
                  $Count1_1 += 1;
                    $data1_1[] = $dataNormal[$j];
                  }else{
                    $Count1 += 1;
                    $data1[] = $dataNormal[$j];
                  }
                }elseif($dataNormal[$j]->legispayments != NULL && $Fpayment<0){
                  $Count1_5 += 1;
                  $data1_5[] = $dataNormal[$j];   
                }                
                else {
                  $CountNullData += 1;
                  $NullData[] = $dataNormal[$j];
                }
          
          }
          $type = $request->type;
          $Flag = $request->Flag;
          return view('legisCompromise.view', compact('type','Flag','data1','data1_1','data1_2','data1_3','data1_4','data1_5','dateSearch','NullData','Count1','Count1_1','Count1_2','Count1_3','Count1_4','Count1_5','CountNullData','dataEndcaseOld'));
      }
      elseif ($request->type == 3) {   //ลูกหนี้ประนอมหนี้(เก่า)
        $lastday1 = date('Y-m-d', strtotime("-1 month"));
        $lastday2 = date('Y-m-d', strtotime("-2 month"));
        $lastday3 = date('Y-m-d', strtotime("-3 month"));
        $lastday4 = date('Y-m-d', strtotime("-4 month"));

        $dataNormal = Legislation::where('Flag', 'C')
          ->where('Status_legis', NULL)
          ->with(['legispayments' => function ($query) {
            return $query->where('Flag_Payment', 'Y');
          }])
          ->Wherehas('legisCompromise',function ($query) use($Fdate, $Tdate) {
            return $query->when(!empty($Fdate) && !empty($Tdate), function($q) use($Fdate, $Tdate) {
              return $q->whereBetween('Date_Promise',[$Fdate,$Tdate]);
            });
          })
          ->with('legisTrackings')
          ->get();
        
        $dataEndcaseOld = Legislation::where('Status_legis', '=', 'ปิดจบประนอม') //ปิดจบงานประนอมเก่า
                        ->where('Flag', 'C')
                        ->get();

        $Count1 = 0;
        $Count1_1 = 0;
        $Count1_2 = 0;
        $Count1_3 = 0;
        $Count1_4 = 0;
        $CountNullData = 0;
        $data1 = [];
        $data1_1 = [];
        $data1_2 = [];
        $data1_3 = [];
        $data1_4 = [];
        $NullData = [];

        for($j= 0; $j < count($dataNormal); $j++){
         // if (@$dataNormal[$j]->legisTrackings->Status_Track != 'Y') {
            if ($dataNormal[$j]->legispayments != NULL) {
              if($dataNormal[$j]->legispayments->DateDue_Payment >= date('Y-m-d') or $dataNormal[$j]->legispayments->DateDue_Payment > $lastday1) {
                $Count1 += 1;
                $data1[] = $dataNormal[$j];
              }elseif($dataNormal[$j]->legispayments->DateDue_Payment > $lastday1 or $dataNormal[$j]->legispayments->DateDue_Payment > $lastday2){
                $Count1_1 += 1;
                $data1_1[] = $dataNormal[$j];
              }elseif($dataNormal[$j]->legispayments->DateDue_Payment > $lastday2 or $dataNormal[$j]->legispayments->DateDue_Payment > $lastday3){
                $Count1_2 += 1;
                $data1_2[] = $dataNormal[$j];
              }elseif($dataNormal[$j]->legispayments->DateDue_Payment > $lastday3 or $dataNormal[$j]->legispayments->DateDue_Payment > $lastday4){
                $Count1_3 += 1;
                $data1_3[] = $dataNormal[$j];
              }else{
                $Count1_4 += 1;
                $data1_4[] = $dataNormal[$j];
              }
            }
            else {
              $CountNullData += 1;
              $NullData[] = $dataNormal[$j];
            }
          //}
        }

        $type = $request->type;
        $Flag = $request->Flag;
        return view('legisCompromise.view', compact('type','Flag','data1','data1_1','data1_2','data1_3','data1_4','dataEndcaseOld','NullData','dateSearch',
                              'Count1','Count1_1','Count1_2','Count1_3','Count1_4','CountNullData'));
      }
      elseif ($request->type == 4) {   //แจ้งเตือนขาดชำระลูกหนี้ 90 วัน
        $lastday = date('Y-m-d', strtotime("-4 month"));
  
        $dataNewPranom = Legislation::where('Flag', 'Y')
          ->where('Status_legis', NULL)
          ->Wherehas('legispayments',function ($query) {
            return $query->where('Flag_Payment', 'Y');
          })
          ->with(['legispayments' => function ($query) {
            return $query->where('Flag_Payment', 'Y');
          }])
          ->with('legisTrackings')
          ->get();

          $Count1 = 0;
          $data1 = [];
          for($i= 0; $i < count($dataNewPranom); $i++){
            //if (@$dataNewPranom[$i]->legisTrackings->Status_Track != 'Y') {
              if($dataNewPranom[$i]->legispayments->DateDue_Payment <= $lastday){
                $Count1 += 1;
                $data1[] = $dataNewPranom[$i];
              }
            //}
          }

        $dataOldPranom = Legislation::where('Flag', 'C')
            ->where('Status_legis', NULL)
            ->with(['legispayments' => function ($query) {
              return $query->where('Flag_Payment', 'Y');
            }])
            ->with('legisTrackings')
            ->get();

          $Count2 = 0;
          $data2 = [];
          for($j= 0; $j < count($dataOldPranom); $j++){
            //if (@$dataOldPranom[$j]->legisTrackings->Status_Track != 'Y') {
              if($dataOldPranom[$j]->legispayments != NULL){
                if($dataOldPranom[$j]->legispayments->DateDue_Payment <= $lastday){
                  $Count2 += 1;
                  $data2[] = $dataOldPranom[$j];
                }
              }
            //}
          }

          $type = $request->type;
          // $Flag = $request->Flag;
          return view('LegisCompromise.viewAlert', compact('type','Flag','data1','data2','Count1','Count2'));
        // return view('options.viewAlert', compact('type','data'));
      }
      elseif ($request->type == 5) {   //รายการติดตามลูกหนี้
        $dataY = Legislation::where('Flag', 'Y')
          ->where('Status_legis', NULL)
          ->Wherehas('legisTrackings',function ($query) {
            return $query->where('Status_Track','Y');
          })
          ->get();

        $dataC = Legislation::where('Flag', 'C')
          ->where('Status_legis', NULL)
          ->Wherehas('legisTrackings',function ($query) {
            return $query->where('Status_Track','Y');
          })
          ->get();

        $type = $request->type;
        $Flag = $request->Flag;
        return view('legisCompromise.viewTrackings', compact('type','Flag','dataY','dataC'));
      }
      elseif ($request->type == 6) {  //รายการรับชำระค่างวด
        if ($dateSearch != NULL) {
          $SetFdate = substr($dateSearch,0,10);
          $newfdate = date('Y-m-d 00:00:00', strtotime($SetFdate));
          $SetTdate = substr($dateSearch,13,21);
          $newtdate = date('Y-m-d 23:59:59', strtotime($SetTdate));

          $data1 = legispayment::when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
              return $q->whereBetween('created_at',[$newfdate,$newtdate]);
            })
            ->Wherehas('PaymentTolegislation',function ($query) {
              return $query->where('Flag', 'Y');
            })
            ->Wherehas('PaymentTolegislation',function ($query) {
              return $query->where('DateStatus_legis', NULL);
            })
            ->Wherehas('PaymentToCompro',function ($query) {
              return $query->where('Date_Promise', '!=', NULL);
            })
            ->with(['PaymentToCompro' => function ($query) {
              return $query->where('Date_Promise', '!=', NULL);
            }])
            ->get();
            
          $data2 = legispayment::when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
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
            ->get();
        }
        else {
          $newfdate = date('Y-m-d h:i:s');
          $newtdate = \Carbon\Carbon::parse(date('Y-m-d h:i:s'))->addDays(1);

          $data1 = legispayment::whereBetween('created_at',[$newfdate,$newtdate])
            ->Wherehas('PaymentTolegislation',function ($query) {
              return $query->where('Flag', 'Y');
            })
            ->Wherehas('PaymentTolegislation',function ($query) {
              return $query->where('DateStatus_legis', NULL);
            })
            ->with(['PaymentToCompro' => function ($query) {
              return $query->where('Date_Promise', '!=', NULL);
            }])
            ->get();

          $data2 = legispayment::whereBetween('created_at',[$newfdate,$newtdate])
            ->Wherehas('PaymentTolegislation',function ($query) {
              return $query->where('Flag', 'C');
            })
            ->Wherehas('PaymentTolegislation',function ($query) {
              return $query->where('DateStatus_legis', NULL);
            })
            ->with(['PaymentToCompro' => function ($query) {
              return $query->where('Date_Promise', '!=', NULL);
            }])
            ->get();
        }

        $SumData1 = 0;
        $SumData2 = 0;
        for ($i=0; $i < count($data1); $i++) { 
          $SumData1 += $data1[$i]->Gold_Payment;
        }
        for ($j=0; $j < count($data2); $j++) { 
          $SumData2 += $data2[$j]->Gold_Payment;
        }

        $type = $request->type;
        return view('LegisCompromise.viewPayments', compact('type','Flag','data1','data2','dateSearch','SumData1','SumData2'));
      }
    }

    public function create(Request $request)
    {
      if ($request->type == 1) {   //Modal รับชำระค่างวด
        $User = User::where('type','=', "แผนก การเงินนอก")->get();

        $type = 7;
        return view('legisCompromise.viewModal',compact('type','User'));
      }
      elseif ($request->type == 2) {

        $type = 8;
        return view('legisCompromise.viewModal',compact('type'));
      }
    }

    public function store(Request $request)
    {
      if ($request->type == 1) {    //create and update LegisCompro
        $dataCompro = Legiscompromise::where('legislation_id',$request->id)
                                        ->where('Flag_Promise','=','Active')->first();
        if ($dataCompro == NULL) {
          DB::beginTransaction();
            try {
              $user = Legislation::find($request->id);
              $user->Flag_status = 3;
              $user->update();
              $LegisCompro = new Legiscompromise([
              'legislation_id' => $request->id,
              'Flag_Promise' => 'Active',
              'Date_Promise' => $request->Dateinsert, 
              'fdate'=>  $request->fdate,                       //วันที่ประนอมหนี้
              'Type_Promise' => $request->TypePromise,
              'IntFatrate'=>($request->IntFatrate != NULL ? str_replace (",","",$request->IntFatrate) : 0),
              'Sum_Promise' => ($request->CompoundTotal_1 != NULL ? str_replace (",","",$request->CompoundTotal_1) : 0),
              'TotalSum_Promise' => ($request->TotalPrice != NULL ? str_replace (",","",$request->TotalPrice) : 0),
              'TotalPaid_Promise' => ($request->TotalPaid != NULL ? str_replace (",","",$request->TotalPaid) : 0),
              'Compen_Promise' => ($request->Compensation != NULL ? str_replace (",","",$request->Compensation) : 0) ,
              'P_Compen_Promise' => ($request->PercentCompensation != NULL ? str_replace (",","",$request->PercentCompensation) : 0),
              'TotalCapital_Promise' =>  ($request->TotalCapital != NULL ? str_replace (",","",$request->TotalCapital) : 0),
              'FeePrire_Promise' => ($request->FeePrire != NULL ? str_replace (",","",$request->FeePrire) : 0),
              'P_FeePrire_Promise' => ($request->PercentFeePrire != NULL ? str_replace (",","",$request->PercentFeePrire) : 0),
              'TotalCost_Promise' => ($request->TotalCost != NULL ? str_replace (",","",$request->TotalCost) : 0),
              'Payall_Promise' => ($request->firstMoney != NULL ? str_replace (",","",$request->firstMoney) : 0),
              'P_Payall_Promise' =>($request->PercentfirstMoney != NULL ? str_replace (",","",$request->PercentfirstMoney) : 0),
              'Total_Promise' => ($request->SHowTotal != NULL ? str_replace (array(","),"",$request->SHowTotal) : 0),
              'DuePay_Promise' => ($request->Installment != NULL ? str_replace (",","",$request->Installment) : 0),
              'P_DuePay_Promise' => ($request->PercentInstallment != NULL ? str_replace (",","",$request->PercentInstallment) : 0),
              'ShowDue_Promise' => ($request->ShowDue != NULL ? str_replace (",","",$request->ShowDue) : 0),
              'ShowPeriod_Promise' => ($request->ShowPeriod != NULL ? str_replace (",","",$request->ShowPeriod) : 0),
              'CompoundTotal_1' => ($request->CompoundTotal_1 != NULL ? str_replace (",","",$request->CompoundTotal_1) : 0),
              'FirstManey_1' => ($request->First_1 != NULL ? str_replace (",","",$request->First_1) : 0),
              'fdate_first' =>$request->fdate_first,
              'FDue_1' => ($request->FDue_1 != NULL ? str_replace (",","",$request->FDue_1) : 0),
              'FPeriod_1' => ($request->FPeriod_1 != NULL ? str_replace (",","",$request->FPeriod_1) : 0),
              'Due_1' => ($request->Due_1 != NULL ? str_replace (",","",$request->Due_1) : 0),
              'Period_1' => ($request->Period_1 != NULL ? str_replace (",","",$request->Period_1) : 0),
              'Profit_1' => ($request->Profit_1 != NULL ? str_replace (",","",$request->Profit_1) : 0),
              'LPAYD' => date('Y-m-d'),
              'PercentProfit_1' => ($request->PercentProfit_1 != NULL ? str_replace (",","",$request->PercentProfit_1) : 0),
              'User_Promise' =>  auth()->user()->name,
            ]);
            $LegisCompro->save();
  
              $loanCode = ['08', '09', '10', '18', '16','P01'];
              if (in_array($user->TypeCon_legis, $loanCode)) {  
                    $lastTotal =  intval($LegisCompro->Due_1)+intval($LegisCompro->TotalSum_Promise);

                    $irrYear = number_format((( intval($LegisCompro->Due_1)/ intval($LegisCompro->TotalSum_Promise)) * 100) / 12, 6);

                      $Paydue = DB::select(
                        "SELECT * FROM dbo.uft_addduelan(?,?,?,?,?,?,?,?,?,?,?,?)",
                        [
                            '',$user->Contract_legis, $LegisCompro->Period_1, $LegisCompro->Due_1, $lastTotal ,'1', $LegisCompro->Date_Promise, $LegisCompro->fdate,
                            $LegisCompro->Sum_Promise,$LegisCompro->TotalSum_Promise,0, $irrYear
                        ]
                    );
                   
                    foreach ($Paydue as $key => $value) {
                      $item = new compromises_paydue;
                        $item->legislation_id = $request->id;
                        $item->legisCompro_id = $LegisCompro->id;
                        $item->contno =  $user->Contract_legis;
                      // $item->locat = $value->locat;
                        $item->nopay = $value->nopay;
                        $item->ddate = $value->ddate;
                        $item->damt = $value->damt;
                        $item->interest = $value->interest;
                        $item->capital = $value->capital;
                        $item->capitalbl = $value->capitalbl;
                        $item->daycalint = $value->daycalint;
                        $item->save();
                    }
                }else {
                  if($LegisCompro->FirstManey_1 == 0){
                
                    $Paydue = DB::select(
                      "SELECT * FROM dbo.uft_addduepay(?,?,?,?,?,?,?,?,?)",
                      [
                          '1',  $LegisCompro->legislation_id, $LegisCompro->Period_1, $LegisCompro->Due_1, '1', $LegisCompro->Date_Promise, $LegisCompro->fdate,
                          '0', $LegisCompro->TotalCapital_Promise
                      ]
                  );


                    foreach ($Paydue as $key => $value) {
                      $item = new compromises_paydue;
                        $item->legislation_id = $request->id;
                        $item->legisCompro_id = $LegisCompro->id;
                        $item->contno =  $user->Contract_legis;
                      // $item->locat = $value->locat;
                        $item->nopay = $value->nopay;
                        $item->ddate = $value->ddate;
                        $item->damt = $value->damt;
                        $item->capitalbl = $value->capitalbl;
                        $item->daycalint = $value->daycalint;
                        $item->save();
                    }
                  }else{
                      $Paydue = DB::select(
                        "SELECT * FROM dbo.uft_addduepay(?,?,?,?,?,?,?,?,?)",
                        [
                            '1',  $LegisCompro->legislation_id, $LegisCompro->FPeriod_1, $LegisCompro->FDue_1, '1', $LegisCompro->Date_Promise, $LegisCompro->fdate_first,
                            '0', $LegisCompro->FirstManey_1
                        ]
                    );


                    foreach ($Paydue as $key => $value) {
                      $item = new compromises_firstdue;
                        $item->legislation_id = $request->id;
                        $item->legisCompro_id = $LegisCompro->id;
                        $item->contno =  $user->Contract_legis;
                      // $item->locat = $value->locat;
                        $item->nopay = $value->nopay;
                        $item->ddate = $value->ddate;
                        $item->damt = $value->damt;
                        $item->capitalbl = $value->capitalbl;
                        $item->daycalint = $value->daycalint;
                        $item->save();
                    }
                  }
                  
                }
                
                DB::commit();
                return redirect()->back()->with('success','บันทึกสำเร็จ');
              } catch (\Exception $e) {
                DB::rollback();

                $message = 'success';
                return response()->json(['message' => $e->getMessage()], 500);
            }
            }else if ($dataCompro != NULL && @$request->typeExten=='2') {
             $Due_1= ($request->Due_1 != NULL ? str_replace (",","",$request->Due_1) : 0);
             $CompoundTotal_1= ($request->CompoundTotal_1 != NULL ? str_replace (",","",$request->CompoundTotal_1) : 0);
             $TotalPrice = ($request->TotalPrice != NULL ? str_replace (",","",$request->TotalPrice) : 0);
             $netprofit = ($request->netprofit != NULL ? str_replace (",","",$request->netprofit) : 0);
              DB::beginTransaction();
              try {
                $user = Legislation::find($request->id);
                $lastTotal =  intval($Due_1)+intval($dataCompro->TotalSum_Promise);
                $irrYear = number_format((( intval($Due_1)/ intval($CompoundTotal_1)) * 100) / 12, 6);
                    $Paydue = DB::select(
                      "SELECT * FROM dbo.uft_adddueExtend(?,?,?,?,?,?,?,?,?,?,?,?,?)",
                      [
                          '',$user->Contract_legis,$dataCompro->Period_1, $request->Period_1, $Due_1, $lastTotal ,'1', $request->fdate, $request->fdate,
                          $CompoundTotal_1,$dataCompro->TotalSum_Promise ,0, $irrYear
                      ]
                  );
                  
                  foreach ($Paydue as $key => $value) {
                    $item = new compromises_paydue;
                      $item->legislation_id = $user->id;
                      $item->legisCompro_id = $dataCompro->id;
                      $item->contno =  $user->Contract_legis;
                    // $item->locat = $value->locat;
                      $item->nopay = $value->nopay;
                      $item->ddate = $value->ddate;
                      $item->damt = $value->damt;
                      $item->interest = $value->interest;
                      $item->capital = $value->capital;
                      $item->capitalbl = $value->capitalbl;
                      $item->daycalint = $value->daycalint;
                      $item->save();
                  }

                  $updateDue = compromises_paydue::where('legisCompro_id', $dataCompro->id)->where('NOPAY', intval($dataCompro->Period_1))->first();
                    $updateDue->capital = $updateDue->N_PAYMENT ?? 0;
                    $updateDue->update();
                  $extendue = $dataCompro->Period_1 + $request->Period_1;
                  $dataCompro->Sum_Promise = ($request->CompoundTotal_1 != NULL ? str_replace (",","",$request->CompoundTotal_1) : 0);
                  $dataCompro->TotalSum_Promise = ($request->TotalPrice != NULL ? str_replace (",","",$request->TotalPrice) : 0);
                  $dataCompro->Due_1 = ($request->Due_1 != NULL ? str_replace (",","",$request->Due_1) : 0);
                  $dataCompro->Period_1 =  $extendue;
                  $dataCompro->Total_Promise = ($request->SHowTotal != NULL ? str_replace (array(","),"",$request->SHowTotal) : 0);
                  $dataCompro->update();

                DB::commit();
                return redirect()->back()->with('success','บันทึกสำเร็จ');
              } catch (\Exception $e) {
                DB::rollback();

                $message = 'success';
                return response()->json(['message' => $e->getMessage()], 500);
              }

            }
        // else {
        //   $user = Legislation::find($request->id);
        //   $user->Flag_status = 3;
        //   $user->update();
        //   $LegisCompro = Legiscompromise::where('legislation_id',$request->id)->first();
        //     if ($LegisCompro->Flag_Promise == NULL) {
        //       $LegisCompro->Flag_Promise = 'Active';
        //     }
        //     $LegisCompro->Type_Promise = $request->TypePromise;
        //     $LegisCompro->Date_Promise = $request->Dateinsert;           //วันที่ประนอมหนี้
        //     $LegisCompro->TotalSum_Promise = ($request->TotalPrice != NULL ? str_replace (",","",$request->TotalPrice) : 0);
        //     $LegisCompro->TotalPaid_Promise = ($request->TotalPaid != NULL ? str_replace (",","",$request->TotalPaid) : 0);
        //     $LegisCompro->Compen_Promise = ($request->Compensation != NULL ? str_replace (",","",$request->Compensation) : 0);
        //     $LegisCompro->P_Compen_Promise = ($request->PercentCompensation != NULL ? str_replace (",","",$request->PercentCompensation) : 0);
        //     $LegisCompro->TotalCapital_Promise = ($request->TotalCapital != NULL ? str_replace (",","",$request->TotalCapital) : 0);
        //     $LegisCompro->FeePrire_Promise = ($request->FeePrire != NULL ? str_replace (",","",$request->FeePrire) : 0);
        //     $LegisCompro->P_FeePrire_Promise = ($request->PercentFeePrire != NULL ? str_replace (",","",$request->PercentFeePrire) : 0);
        //     $LegisCompro->TotalCost_Promise = ($request->TotalCost != NULL ? str_replace (",","",$request->TotalCost) : 0);
        //     $LegisCompro->Payall_Promise = ($request->firstMoney != NULL ? str_replace (",","",$request->firstMoney) : 0);
        //     $LegisCompro->P_Payall_Promise = ($request->PercentfirstMoney != NULL ? str_replace (",","",$request->PercentfirstMoney) : 0);
        //     $LegisCompro->Total_Promise = ($request->SHowTotal != NULL ? str_replace (array(","),"",$request->SHowTotal) : 0);
        //     $LegisCompro->DuePay_Promise = ($request->Installment != NULL ? str_replace (",","",$request->Installment) : 0);
        //     $LegisCompro->P_DuePay_Promise = ($request->PercentInstallment != NULL ? str_replace (",","",$request->PercentInstallment) : 0);
        //     $LegisCompro->ShowDue_Promise = ($request->ShowDue != NULL ? str_replace (",","",$request->ShowDue) : 0);
        //     $LegisCompro->ShowPeriod_Promise = ($request->ShowPeriod != NULL ? str_replace (",","",$request->ShowPeriod) : 0);
        //     $LegisCompro->CompoundTotal_1 = ($request->CompoundTotal_1 != NULL ? str_replace (",","",$request->CompoundTotal_1) : 0);
        //     $LegisCompro->FirstManey_1 = ($request->First_1 != NULL ? str_replace (",","",$request->First_1) : 0);
        //     $LegisCompro->Due_1 = ($request->Due_1 != NULL ? str_replace (",","",$request->Due_1) : 0);
        //     $LegisCompro->Period_1 = ($request->Period_1 != NULL ? str_replace (",","",$request->Period_1) : 0);
        //     $LegisCompro->Profit_1 = ($request->Profit_1 != NULL ? str_replace (",","",$request->Profit_1) : 0);
        //     $LegisCompro->PercentProfit_1 = ($request->PercentProfit_1 != NULL ? str_replace (",","",$request->PercentProfit_1) : 0);
        //     $LegisCompro->User_Promise = $request->Userinsert;
        //   $LegisCompro->update();
        // }
        
      }
    }

    public function show(Request $request, $id)
    {
      if ($request->type == 4) {      //Modal Create LegisCompro
        $data = Legislation::find($id);
        $type = $request->type;

        return view('legisCompromise.viewModal',compact('data','type'));
      }
      elseif ($request->type == 5) {  //Modal LegisPayments
        $data = Legislation::where('id',$id)
          ->with('legisCompromise')
          ->with(['legispayments' => function ($query) {
            return $query->where('Flag_Payment', 'Y');
          }])
          ->first();
        
        $type = $request->type;
        return view('legisCompromise.viewModal',compact('data','id','type'));
      }
      elseif ($request->type == 6) {  //Modal Trackings
        $type = $request->type;
        return view('legisCompromise.viewModal',compact('id','type'));
      }
      elseif ($request->type == 9) {  //Modal Edit Payments
        $data = legispayment::find($id);

        $Paylast = legispayment::where('legislation_id',$data->legislation_id)
          ->where('Flag_Payment', 'N')
          ->latest()
          ->first();

        $type = $request->type;
        return view('legisCompromise.viewModal',compact('data','Paylast','id','type'));
      } 
      elseif ($request->type == 10) { //Report Contract
        $data = Legislation::find($id);

        $ref_price = '0';
        // if ($data->TypeCon_legis == '101') {
        //   $tax_id = '|0945530000098';
        //   $contract = preg_replace("/[^a-z\d]/i", '', substr(@$data->Contract_legis,0));
        //   $Bar = $tax_id."00".chr(13).$contract.chr(13).'006'.chr(13).$ref_price;
        // }else{
        //   $tax_id = '|0815559000291';
        //   $contract = preg_replace("/[^a-z\d]/i", '', substr(@$data->Contract_legis,1));
        //   $Bar = $tax_id."01".chr(13).$contract.chr(13).'006'.chr(13).$ref_price;
        // }
        // $StrConn = $contract;
        
        // $NamepathBr = 'Br_'.$StrConn;
        // $Bc_JPGgenerator = new Picqer\Barcode\BarcodeGeneratorPNG();
        // file_put_contents(public_path().'/cache_barcode/'.$NamepathBr.'.png', $Bc_JPGgenerator->getBarcode($Bar, $Bc_JPGgenerator::TYPE_CODE_128));

        // $NamepathQr = 'Qr_'.$StrConn;
        // $BQ_generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        // file_put_contents(public_path().'/cache_barcode/'.$NamepathQr.'.svg', QrCode::size(100)->generate($Bar));

        $type = $request->type;
        $view = \View::make('legisCompromise.reportContract' ,compact('data','type','Bar','contract'));
        $html = $view->render();
  
        $pdf = new PDF();
        $pdf::SetTitle('แบบฟอร์มสัญญาประนอมหนี้');
        $pdf::AddPage('P', 'A4');
        $pdf::SetMargins(5, 5, 5, 5);
        $pdf::SetFont('thsarabun', '', 11, '', true);
        $pdf::SetAutoPageBreak(TRUE, 10);
        $pdf::WriteHTML($html,true,false,true,false,'');
        $pdf::Output('report.pdf');
      }
      elseif ($request->type == 11) { //Report Payments
        $ItemPay = legispayment::where('id', $id)->with('PaymentTolegislation')->first();
       // $SumItemPay = legispayment::where('legislation_id', $ItemPay->legislation_id)
       $SumItemPay = legispayment::where('legisCompro_id', $ItemPay->legisCompro_id)
            ->where('Period_Payment','<=', (int)$ItemPay->Period_Payment)
            ->where('Flag','<>','C')
            ->sum('Gold_Payment');

      $ItemCompro = Legiscompromise::where('legislation_id',$ItemPay->legislation_id)->whereIN('Flag_Promise',['Active','Complete'])->orderBy('id','DESC')->first();

        $ref_price = '0';
        if ($ItemPay->PaymentTolegislation->TypeCon_legis == 'F01') {
          $tax_id = '|0945530000098';
          $contract = preg_replace("/[^a-z\d]/i", '', substr(@$ItemPay->PaymentTolegislation->Contract_legis,0));
          $Bar = $tax_id."00".chr(13).$contract.chr(13).'006'.chr(13).$ref_price;
        }else{
          $tax_id = '|0815559000291';
          $contract = preg_replace("/[^a-z\d]/i", '', substr(@$ItemPay->PaymentTolegislation->Contract_legis,1));
          $Bar = $tax_id."01".chr(13).$contract.chr(13).'006'.chr(13).$ref_price;
        }
        $StrConn = $contract;
        
        $NamepathBr = 'Br_'.$StrConn;
        $Bc_JPGgenerator = new Picqer\Barcode\BarcodeGeneratorPNG();
        file_put_contents(public_path().'/cache_barcode/'.$NamepathBr.'.png', $Bc_JPGgenerator->getBarcode($Bar, $Bc_JPGgenerator::TYPE_CODE_128));

        $NamepathQr = 'Qr_'.$StrConn;
        $BQ_generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        file_put_contents(public_path().'/cache_barcode/'.$NamepathQr.'.svg', QrCode::size(100)->generate($Bar));
        
        $type = $request->type;
        $view = \View::make('legisCompromise.reportPayments' ,compact('type','ItemPay','SumItemPay','ItemCompro','Bar','contract','NamepathBr','NamepathQr'));
        $html = $view->render();

        $pdf = new PDF();
        $pdf::SetTitle('ใบเสร็จรับชำระค่างวด');
        $pdf::AddPage('P', 'A4');
        $pdf::SetMargins(5, 5, 5, 5);
        $pdf::SetFont('thsarabun', '', 11, '', true);
        $pdf::SetAutoPageBreak(TRUE, 5);
        $pdf::WriteHTML($html,true,false,true,false,'');
        $pdf::Output('Payments.pdf');
      }

      if($request->viewData == 'oldpayment'){
        $dataPay = legispayment::where('legisCompro_id',$id)
                    ->get();

      $type = $request->type;
      return view('legisCompromise.viewModalPay',compact('dataPay'));
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
      if ($request->type == 1 or $request->type == 2 or $request->type == 3) {      //ลูกหนี้ ประนอมหนี้
        if ($request->has('FlagTab')) {
          $FlagTab = $request->get('FlagTab');
        }else {
          $FlagTab = 1;
        }

        
        $data = Legislation::where('id',$id)
          ->with(['legisCompromise' => function ($query) {
            return $query->where('Flag_Promise','<>','InActive');
          }])
          ->with(['legispayments' => function ($query) {
            return $query->where('Flag_Payment', 'Y');
          }])
          ->with('legisTrackings')
          ->first();
        
        $dataOldPromise = Legislation::where('id',$id)
        ->with(['legisCompromiseInact' => function ($query) {
          return $query->where('Flag_Promise','=','InActive');
        }])->first();

        $dataPay  = legisCompromise::where('legislation_id',$id)->whereIn('Flag_Promise',['Active','Complete'])->first();

        $intamtDue = compromises_paydue::where('legisCompro_id', @$dataPay->id)->get();

        $intdue = $intamtDue->sum('intamt');

        $payint = legispayment::where('legisCompro_id', @$dataPay->id)->where('Flag','<>','C')->get();

        $payintamt = $payint->sum('Payintamt');
        $Disintamt = $payint->sum('Disintamt');

        $intamtbl = $intdue-($payintamt+$Disintamt);

        // $dataPay = legispayment::where('legislation_id',$id)
        //   ->where('Count_Promis',NULL)->get();
         // dd($id,$dataPay);
        $dataTrack = LegisTrackings::where('legislation_id',$id)->get();
        
        $type = $request->type;
        return view('legisCompromise.editPranom',compact('data','id','type','FlagTab','dataPay','dataTrack','dataOldPromise','intamtbl'));
      }
      elseif ($request->type == 4) {  //Delete legisCompro & legispay & legisTrack
        $LegisCompro = Legiscompromise::where('legislation_id',$id)->where('Flag_Promise', 'Active')->first();
        
        $LegisCompro->Flag_Promise = 'InActive';
        $LegisCompro->update();
       // $LegisPays = legispayment::where('legislation_id',$id);
        //$LegisTrack = LegisTrackings::where('legislation_id',$id);

       

        $Legislation = Legislation::find($id);
          $Legislation->UseClear_Legiscom = auth()->user()->name;
          $Legislation->DateClear_Legiscom = date('Y-m-d');
          $Legislation->CountClear_Legiscom = $Legislation->CountClear_Legiscom +1;
        $Legislation->update();
        
        return  response()->json(["success" => 'success' ]);
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      if ($request->type == 1) {      //Save Payments
        $ItemPay = legispayment ::where('legislation_id',$id)->where('Flag_Payment', 'Y')->first();
        if ($ItemPay != NULL) {
            $ItemPay->Flag_Payment = 'N';
          $ItemPay->update();

          $GetJob = $ItemPay->Jobnumber_Payment;
          $SetStr = explode("-",$GetJob);
          $SetJobNumber = $SetStr[1] + 1;
  
          // ดึงปีและเดือนปัจจุบัน
          $SetNumDate = substr($SetStr[1],0,2);
          $Years = substr(date('Y'), 2);
          $month = date('m');
  
          $num = "1000";
          $SubStr = substr($num.$SetJobNumber, -4);
          if ($SetNumDate == $Years) {
            $JobCode = $SetStr[0]."-".$Years."".$month."".$SubStr;
          }else {
            $JobCode = $SetStr[0]."-".$Years."".$month."0001";
          }
          
          $NumPeriod = $ItemPay->Period_Payment +1;
        }else {
          $Years = substr(date('Y'), 2);
          $month = date('m');
          $JobCode = "ABL"."-".$Years."".$month."0001";
          $NumPeriod = 1;
        }
        DB::beginTransaction();
        try {
        $LegisPay = new legispayment([
          'legislation_id' => $id,
          'legisCompro_id' => $request->idCompro,
          'DateDue_Payment' => $request->DateDue,
          'Gold_Payment' => str_replace (",","",$request->Cash),
          'Discount_Payment' => str_replace (",","",$request->Discount),
          'Payintamt' => $request->Payintamt!=NULL?floatval(str_replace (",","",$request->Payintamt)):0,
          'Disintamt' => $request->Disintamt!=NULL?floatval(str_replace (",","",$request->Disintamt)):0,
          'Type_Payment' =>  $request->TypePayment,
          'BankIn' =>  $request->BankIn,
          'Adduser_Payment' =>  $request->AdduserPayment,
          'Note_Payment' =>  $request->NotePayment,
          'Flag_Payment' =>  'Y',
          'Flag'=>'H',
          'LPAYD'=>@$ItemPay->Date_Payment,
          'Jobnumber_Payment' => @$JobCode,
          'Period_Payment' => @$NumPeriod,
          'Date_Payment'=>$request->DatePayment,
          ]);
        $LegisPay->save();

        


        //Update Flag LegisCompro
        $FlagTab = 1;
        $LegisCompro = Legiscompromise::where('legislation_id',$id)
                                        ->where('Flag_Promise','Active')->first();

          if ($request->TypePayment == "เงินก้อนแรก(เงินสด)" or $request->TypePayment == "เงินก้อนแรก(เงินโอน)") {
            $LegisCompro->Sum_FirstPromise =  floatval($LegisCompro->Sum_FirstPromise)+floatval(str_replace (",","",$request->Cash));
            $FlagTab = 5;
            if((floatval($LegisCompro->Sum_FirstPromise)-floatval($LegisCompro->FirstManey_1)) >= 0){
              
              $chkDue = compromises_paydue::where("legisCompro_id",$LegisCompro->id)->get();
             
              $nextMonth = date('Y-m',strtotime(date('Y-m') . "+1 month"));

              if(explode("-",$nextMonth)[1] == '02'){
                $nextMonth = $nextMonth.'-28';
              }else{
                $nextMonth = $nextMonth.'-30';
              }

              if($chkDue==NULL||count($chkDue)== 0){
                $Paydue = DB::select(
                    "SELECT * FROM dbo.uft_addduepay(?,?,?,?,?,?,?,?,?)",
                    [
                        '1',  $LegisCompro->legislation_id, $LegisCompro->Period_1, $LegisCompro->Due_1, '1', $LegisCompro->Date_Promise, $LegisCompro->fdate,
                        '0', (floatval($LegisCompro->TotalCapital_Promise)-floatval($LegisCompro->FirstManey_1))
                    ]
                );
    
    
                foreach ($Paydue as $key => $value) {
                  $item = new compromises_paydue;
                    $item->legislation_id = $LegisCompro->legislation_id;
                    $item->legisCompro_id = $LegisCompro->id;
                  // $item->contno = $value->contno;
                  // $item->locat = $value->locat;
                    $item->nopay = $value->nopay;
                    $item->ddate = $value->ddate;
                    $item->damt = $value->damt;
                    $item->capitalbl = $value->capitalbl;
                    $item->daycalint = $value->daycalint;
                    $item->save();
                }
              }
            }

            //Due

            $payCash = floatval(str_replace (",","",$request->Cash))>0?floatval(str_replace (",","",$request->Cash)):0;

            $paydue = 0;

            $updateDue = compromises_firstdue::where("legisCompro_id", $LegisCompro->id)
                ->whereRaw('damt - payment > 0')
                ->orderBy('nopay', 'asc')
                ->get();
            
                foreach ($updateDue as $value) {
                    // คำนวณยอดเงินคงเหลือ
                    $payCash = (floatval($payCash) + floatval($value->payment)) - $paydue;
                
                    if ($payCash >= $value->damt) {
                        // กรณีมียอดเงินพอชำระเต็มจำนวน
                        $value->payment = $value->damt;
                        $paydue = $value->damt;
                        $value->date1 = date('Y-m-d');
                    } elseif ($payCash > 0) {
                        // กรณีชำระได้บางส่วน
                        $value->payment = $payCash;
                        $paydue += $payCash;
                        $payCash = 0;
                        $value->date1 = date('Y-m-d');
                    } else {
                        // กรณีไม่มีเงินเพียงพอ
                        $value->payment = 0;
                    }
                
                    // อัปเดตวันที่เป็นปัจจุบัน
                   
                
                    // บันทึกข้อมูลการอัปเดต
                    $value->update();
                
                    // หยุดลูปเมื่อยอดเงินหมด
                    if ($payCash <= 0) {
                        break;
                    }
                }

          }else {
            $FlagTab = 2;
            $LegisCompro->Sum_DuePayPromise = floatval($LegisCompro->Sum_DuePayPromise)+floatval(str_replace (",","",$request->Cash));
            //Due

                $payCash = floatval(str_replace (",","",$request->Cash))>0?floatval(str_replace (",","",$request->Cash)):0;

                $paydue = 0;

                $updateDue = compromises_paydue::where("legisCompro_id", $LegisCompro->id)
                        ->whereRaw('damt+capital - payment > 0')
                        ->orderBy('nopay', 'asc')
                        ->get();

                // foreach ($updateDue as $key => $value) {
                //   $payCash = (floatval($payCash)+floatval($value->payment))- $paydue;

                //   if ($payCash >=$value->damt) {
                //     $value->payment = $value->damt;
                //     $paydue = $value->damt;
                //   }else{
                //     if($payCash>=0 && $payCash>=$value->damt){
                //       $value->payment = $value->damt;
                //       $paydue = $paydue+$value->damt;
                //     }else{
                //       $value->payment = $payCash;
                //       $payCash=0;
                //     }    
                //   }
                //   $value->date1 = date('Y-m-d'); 
                
                //   if($payCash<=0 && ($value->damt-$payCash) != $value->damt ){ 
                //     $value->update();
                //     break;
                //   }else{
                //     $value->update();
                //   }
                  
                
                // }
                foreach ($updateDue as $value) {
                  // คำนวณยอดที่เหลือหลังการชำระเงิน
                  $payCash = (floatval($payCash) + floatval($value->payment)) - $paydue;
              
                  if ($payCash >= floatval($value->damt)+floatval($value->capital)) {
                      // กรณีที่สามารถชำระเต็มจำนวน
                      $value->payment = floatval($value->damt)+floatval($value->capital);
                      $value->payamt_n =  $value->capital;
                      $paydue =floatval($value->damt)+floatval($value->capital);
                      $value->date1 = date('Y-m-d');
                  } else {
                      if ($payCash > 0) {
                          // กรณีที่ชำระได้บางส่วน
                          $value->payment = $payCash;
                          if($value->capital>0 && $payCash-floatval($value->damt)>0){
                            $value->payamt_n =$payCash-$value->damt ;
                          }
                          $paydue += $payCash;
                          $payCash = 0; // ยอดคงเหลือหมด
                          $value->date1 = date('Y-m-d');
                      } else {
                          // กรณีที่ยอดเงินไม่พอจ่าย
                          $value->payment = 0;
                      }
                  }
              
                  // ตั้งค่าวันที่ชำระ
                 
              
                  // อัปเดตข้อมูลในฐานข้อมูล
                  $value->update();
              
                  // หยุดการวนลูปเมื่อยอดเงินหมด
                  if ($payCash <= 0 && ($value->damt - $payCash) != $value->damt) {
                      break;
                  }
              }
          }

          // เช็คส่วนลด
          if ($request->Discount != NULL) {
            $LegisCompro->Discount_Promise = floatval(str_replace (",","",$request->Discount));
          }
          // เช็คยอดคงเหลือ
          // if ($LegisCompro->ComproTolegislation->TypeCon_legis == 'P01') {
          //   $LegisCompro->Sum_Promise = floatval($LegisCompro->Sum_Promise) +floatval(str_replace (",","",$request->Cash));
          // }
          // else {
            $Setpaid = (floatval(str_replace (",","",$LegisCompro->Sum_FirstPromise)) 
                      + floatval(str_replace (",","",$LegisCompro->Sum_DuePayPromise)) 
                      + floatval(str_replace (",","",$request->Discount))
                      +floatval(str_replace (",","",$request->Cash)));
          
            $LegisCompro->Sum_Promise = (floatval($LegisCompro->Total_Promise) - $Setpaid);
           // }
            // เช็คปิดบัญชี
            if ($LegisCompro->Sum_Promise >= $LegisCompro->Total_Promise) {
              $LegisCompro->Flag_Promise = 'Complete';

              $Legislation = Legislation ::find($id);
                $Legislation->Status_legis = 'ปิดจบประนอม';
                $Legislation->UserStatus_legis = $request->AdduserPayment;
                $Legislation->DateStatus_legis = date('Y-m-d');
              $Legislation->update();
            }
          
        $LegisCompro->LPAYA = str_replace (",","",$request->Cash);
        $LegisCompro->LPAYD = $request->DatePayment;    
        $LegisCompro->update();

        //Update Flag LegisTrack
        $LegisTrack = LegisTrackings::where('legislation_id', $id)->where('Status_Track', 'Y')->first();
        if ($LegisTrack != NULL) {
            $LegisTrack->JobPayment_Track = $JobCode;
            $LegisTrack->Status_Track = 'N';
          $LegisTrack->update();
        }
          
          DB::commit();
              // return redirect()->back()->with('success','รับชำระเรียบร้อย');
        return redirect()->Route('MasterCompro.edit',[$id,'type' => 1,'FlagTab' => $FlagTab  ])->with('success','รับชำระเรียบร้อย');
        } catch (\Exception $e) {
          DB::rollback();

          $message = 'success';
          return response()->json(['message' => $e->getMessage()], 500);
      }
   
      }
      elseif ($request->type == 2) {  //update LegisCompro
        $datapay = legispayment::where('legislation_id',$id)->get();

        $SumFirstPrice = 0;
        $SumPayPrice = 0;
        foreach ($datapay as $key => $value) {
          if ($value->Type_Payment == 'เงินก้อนแรก(เงินสด)' or $value->Type_Payment == 'เงินก้อนแรก(เงินโอน)') {
            $SumFirstPrice =   floatval($SumFirstPrice) +  floatval($value->Gold_Payment);
          }else {
            $SumPayPrice =  floatval($SumPayPrice) +  floatval($value->Gold_Payment);
          }
        }
        
        $dataCompro = Legiscompromise::where('legislation_id',$id)->first();
          $dataCompro->Sum_FirstPromise = @$SumFirstPrice;
          $dataCompro->Sum_DuePayPromise = @$SumPayPrice;
          $dataCompro->Note_Promise = $request->GetNote;

          // เช็คปิดบัญชี หรือจ่ายจบ
          if ($dataCompro->Sum_Promise == 0) {
            $dataCompro->Flag_Promise = 'Complete';

            $Legislation = Legislation ::find($id);
              $Legislation->Status_legis = 'ปิดจบประนอม';
              $Legislation->UserStatus_legis = auth()->user()->name;
              $Legislation->DateStatus_legis = date('Y-m-d');
            $Legislation->update();
          }
          else {
            $dataCompro->Flag_Promise = 'Active';
          }

          if ($dataCompro->ComproTolegislation->TypeCon_legis == 'P01') {
            $dataCompro->Sum_Promise = (@$SumFirstPrice + @$SumPayPrice);
          }else {
            $dataCompro->Sum_Promise = ($dataCompro->Total_Promise - (@$SumFirstPrice + @$SumPayPrice + @$dataCompro->Discount_Promise));
          }
        $dataCompro->update();

        return redirect()->back()->with('success','อัพเดตข้อมูลเรียบร้อย');
      }
      elseif ($request->type == 3) {  //Save LegisTrackings
        $dataTrack = LegisTrackings::where('legislation_id',$id)->latest()->first();
        if ($dataTrack != NULL) {
            $dataTrack->Status_Track = 'N';
          $dataTrack->update();

          $GetJob = $dataTrack->JobNumber_Track;
          $SetStr = explode("-",$GetJob);
          $SetJobNumber = $SetStr[1] + 1;
  
          // ดึงปีและเดือนปัจจุบัน
          $SetNumDate = substr($SetStr[1],0,2);
          $Years = substr(date('Y'), 2);
          $month = date('m');
  
          $num = "1000";
          $SubStr = substr($num.$SetJobNumber, -4);
          if ($SetNumDate == $Years) {
            $JobCode = $SetStr[0]."-".$Years."".$month."".$SubStr;
          }else {
            $JobCode = $SetStr[0]."-".$Years."".$month."0001";
          }
        }else {
          $Years = substr(date('Y'), 2);
          $month = date('m');

          $JobCode = "TRK-".$Years."".$month."0001";
        }

        $LegisTrack = new LegisTrackings([
          'legislation_id' => $id,
          'Status_Track' => 'Y',
          'JobNumber_Track' => $JobCode,
          'Subject_Track' => $request->StatusTrack,
          'Detail_Track' => $request->NoteTrack,
          'DateDue_Track' => $request->DateDueTrack,
          'User_Track' => $request->Users,
          ]);
        $LegisTrack->save();

        return redirect()->Route('MasterCompro.edit',[$id,'type' => 1,'FlagTab' => 3])->with('success','บันทึกข้อมูลเรียบร้อย');
      }
      elseif ($request->type == 4) {  //update item payments
        $ItemPay = legispayment ::find($id);
          $ItemPay->DateDue_Payment = $request->DateDue;
          $ItemPay->Gold_Payment = str_replace (",","",$request->Cash);
          $ItemPay->Discount_Payment = str_replace (",","",$request->Discount);
          $ItemPay->Type_Payment = $request->TypePayment;
          $ItemPay->BankIn = $request->BankIn;
          $ItemPay->Note_Payment = $request->NotePayment;
        $ItemPay->update();

        return redirect()->back()->with('success','อัพเดตข้อมูลเรียบร้อย');
      }
      if($request->process =='caloverdue') {
        try {
         // $statement = DB::statement("EXEC sp_Caloverdue ?", [date('Y-m-d')]);

          $sql = "EXEC dbo.sp_Caloverdue  '" . date('Y-m-d') . "'";
          $statement = DB::unprepared($sql);
                                
          return  response()->json(["message" => 'success' ]);
        } catch (\Exception $e) {

          return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
        }

        
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
      if ($request->type == 1) {      //ลบรายการ(ประนอมหนี้เก่า)ทั้งหมด
          // $item = Legislation::find($id);
          // $item1 = Legiscompromise::where('legisPromise_id',$id);
          // $item2 = legispayment::where('legis_Com_Payment_id',$id);
  
          // $item->Delete();
          // $item1->Delete();
          // $item2->Delete();
      }
      elseif ($request->type == 2) {  //ยกเลิกรายการ Payment
        $itemPay = legispayment::find($id);
          $LegisCompro = Legiscompromise::where('id', $itemPay->legisCompro_id)->first();
            if ($itemPay->Type_Payment == 'เงินก้อนแรก(เงินสด)' || $itemPay->Type_Payment == 'เงินก้อนแรก(เงินโอน)') {
              $LegisCompro->Sum_FirstPromise = floatval($LegisCompro->Sum_FirstPromise)-floatval($itemPay->Gold_Payment);
              $payCash = floatval(str_replace (",","",$itemPay->Gold_Payment))>0?floatval(str_replace (",","",$itemPay->Gold_Payment)):0;

                $payMent = $payCash;
                $payMentDue = 0;
                if($itemPay->Gold_Payment>0){
                  $updateDue = compromises_firstdue::where("legisCompro_id",$LegisCompro->id)->whereRaw('payment >0 order by nopay desc')->get();

                  foreach ($updateDue as $key => $value) {
                  

                    if($payMent>0){
                        $payMent = (floatval($payMent)-floatval($value->payment));

                        if ($payMent >=0) { 
                          $payMentDue = $payMentDue+$value->payment;
                          $value->payment = 0;
                          $value->date1 = NULL ;
                        
                        }else{
                          if($payMent>=0 && $payMent>=$value->payment){
                            $payMentDue = $payMentDue+$value->payment;
                            $value->payment = 0; 
                            $value->date1 = NULL ;                     
                          }else{
                            
                            $value->payment = floatval($value->payment)-(floatval($payCash)-$payMentDue);                      
                            $value->date1 = $LegisCompro->LPAYD ; 
                            $payMentDue = $payMentDue+$value->payment;
                            $payMent=0;
                          }    
                        }
                        


                    }                  
                  
                    if($payMent<=0){ 
                      $value->update();
                      break;
                    }else{
                      $value->update();
                    }
                    
                  
                  }
                }
            }else {
              $LegisCompro->Sum_DuePayPromise = floatval($LegisCompro->Sum_DuePayPromise)- floatval($itemPay->Gold_Payment);

              $payCash = floatval(str_replace (",","",$itemPay->Gold_Payment))>0?floatval(str_replace (",","",$itemPay->Gold_Payment)):0;

                $payMent = $payCash;
                $payMentDue = 0;
                if($itemPay->Gold_Payment>0){
                  $updateDue = compromises_paydue::where("legisCompro_id",$LegisCompro->id)->whereRaw('payment >0 order by nopay desc')->get();

                  foreach ($updateDue as $key => $value) {
                  

                    if($payMent>0){
                        $payMent = (floatval($payMent)-floatval($value->payment));

                        if ($payMent >=0) { 
                          $payMentDue = $payMentDue+$value->payment;
                          $value->payment = 0;
                          $value->date1 = NULL ;
                        
                        }else{
                          if($payMent>=0 && $payMent>=$value->payment){
                            $payMentDue = $payMentDue+$value->payment;
                            $value->payment = 0; 
                            $value->date1 = NULL ;                     
                          }else{
                            
                            $value->payment = floatval($value->payment)-(floatval($payCash)-$payMentDue);                      
                            $value->date1 = $LegisCompro->LPAYD ; 
                            $payMentDue = $payMentDue+$value->payment;
                            $payMent=0;
                          }    
                        }
                        


                    }                  
                  
                    if($payMent<=0){ 
                      $value->update();
                      break;
                    }else{
                      $value->update();
                    }
                    
                  
                  }
                }
            }
            $LegisCompro->Sum_Promise = ($LegisCompro->Sum_FirstPromise + $LegisCompro->Sum_DuePayPromise + $LegisCompro->Discount_Promise);

            // เช็คปิดบัญชี หรือจ่ายจบ
            if ($LegisCompro->Sum_Promise >= $LegisCompro->Total_Promise) {
              $LegisCompro->Flag_Promise = 'Complete';

              $Legislation = Legislation ::find($itemPay->legislation_id);
                $Legislation->Status_legis = 'ปิดจบประนอม';
                $Legislation->UserStatus_legis = auth()->user()->name;
                $Legislation->DateStatus_legis = date('Y-m-d');
              $Legislation->update();
            }
            else {
              $LegisCompro->Flag_Promise = 'Active';
            }
          $LegisCompro->update();

                

          $itemPay->Flag ='C';
        $itemPay->update();

        $LegisPay = legispayment::where('legislation_id',$LegisCompro->legislation_id)->latest()->first();
        if ($LegisPay != NULL) {
          DB::table('legispayments')
            ->where('id', $LegisPay->id)
            ->update([
              'Flag_Payment' => 'Y'
            ]);
        }

        $LegisTrack = LegisTrackings::where('legislation_id', $LegisCompro->legislation_id)->latest()->first();
        if ($LegisTrack != NULL) {
          $LegisTrack->JobPayment_Track = NULL;
            $LegisTrack->Status_Track = 'Y';
          $LegisTrack->update();
        }

      }
      elseif ($request->type == 3) {  //ลบรายการ Trackings
        $itemTrack = LegisTrackings::find($id);
          $SetIDLegis = $itemTrack->legislation_id;
        $itemTrack->Delete();

        $LegisTrack = LegisTrackings::where('legislation_id', $SetIDLegis)->latest()->first();
        if ($LegisTrack != NULL) {
            $LegisTrack->Status_Track = 'Y';
          $LegisTrack->update();
        }

      }

      return redirect()->back()->with('success','ลบข้อมูลเรียบร้อย');
    }

    public function Report(Request $request)
    {
      if ($request->type == 2) {   //รายงาน Excel ลูกหนี้ใหม่
        $data = Legislation::where('Flag','Y')
          ->where('Status_legis', NULL)
          ->with(['legisCompromise' => function ($query) {
            return $query->where('Date_Promise', '!=', NULL);
          }])
          ->Wherehas('legispayments',function ($query) {
            return $query->where('Flag_Payment', 'Y');
          })
          ->with(['legispayments' => function ($query) {
            return $query->where('Flag_Payment', 'Y');
          }])
          ->with('legisTrackings')
          ->get();

        $status = 'ลูกหนี้ประนอมหนี้ใหม่';
        Excel::create('รายงานลูกหนี้ประนอมหนี้ใหม่', function ($excel) use($data,$status) {
          $excel->sheet($status, function ($sheet) use($data,$status) {
              $sheet->prependRow(1, array("บริษัท ชูเกียรติลิสซิ่ง จำกัด"));
              $sheet->prependRow(2, array($status));
              $sheet->cells('A3:P3', function($cells) {
                $cells->setBackground('#FFCC00');
              });
              $row = 3;
              $sheet->row($row, array('เลขที่สัญญา', 'ชื่อ-สกุล','วันที่ฟ้อง','เริ่มประนอมหนี้', 'สถานะลูกหนี้', 
                  'ยอดประนอมหนี้', 'เงินก้อนแรก','สถานะก้อนแรก','จำนวนงวด', 'งวดละ','ยอดชำระรวม', 'ยอดคงเหลือ', 
                  'วันที่ชำระล่าสุด', 'ยอดชำระล่าสุด', 'ประเภทชำระ', 'วันที่ดิวถัดไป','หมายเหตุ'));

              $lastday1 = date('Y-m-d', strtotime("-1 month"));
              $lastday2 = date('Y-m-d', strtotime("-2 month"));
              $lastday3 = date('Y-m-d', strtotime("-3 month"));
              $lastday4 = date('Y-m-d', strtotime("-4 month"));
              
              foreach ($data as $key => $value) {
                $SetStatus = NULL;
                if (@$value->legisTrackings->Status_Track != 'Y') {
                  // if($value->legispayments->DateDue_Payment >= date('Y-m-d') or $value->legispayments->DateDue_Payment > $lastday1) {
                  //   $SetStatus = 'ชำระปกติ';
                  // }elseif($value->legispayments->DateDue_Payment > $lastday1 or $value->legispayments->DateDue_Payment > $lastday2){
                  //   $SetStatus = 'ขาดชำระ 1 งวด';
                  // }elseif($value->legispayments->DateDue_Payment > $lastday2 or $value->legispayments->DateDue_Payment > $lastday3){
                  //   $SetStatus = 'ขาดชำระ 2 งวด';
                  // }elseif($value->legispayments->DateDue_Payment > $lastday3 or $value->legispayments->DateDue_Payment > $lastday4){
                  //   $SetStatus = 'ขาดชำระ 3 งวด';
                  // }

                  if($value->legisCompromise->HLDNO <= 0) {
                    $SetStatus = 'ชำระปกติ';
                  }elseif($value->legisCompromise->HLDNO >0 && $value->legisCompromise->HLDNO <2){
                    $SetStatus = 'ขาดชำระ 1 งวด';
                  }elseif($value->legisCompromise->HLDNO >1 && $value->legisCompromise->HLDNO <3){
                    $SetStatus = 'ขาดชำระ 2 งวด';
                  }elseif($value->legisCompromise->HLDNO >2 && $value->legisCompromise->HLDNO <4){
                    $SetStatus = 'ขาดชำระ 3 งวด';
                  }elseif($value->legisCompromise->HLDNO >3){
                    $SetStatus = 'ขาดชำระมากกว่า 3 งวด';
                  }


                  if ($SetStatus != NULL) {
                    if ($value->legisCompromise->FirstManey_1 != 0) {
                      $SetFirst = $value->legisCompromise->FirstManey_1;
                    }else {
                      $SetFirst = $value->legisCompromise->Payall_Promise;
                    }
                    if ($value->legisCompromise->Sum_FirstPromise == $SetFirst) {
                      $SetFirstMoney = 'ครบชำระก้อนแรก';
                    }else {
                      $SetFirstMoney = 'ขาดชำระก้อนแรก';
                    }
  
                    if ($value->legisCompromise->Due_1 != 0) {
                      $SetDuePrice = $value->legisCompromise->Due_1;
                    }else {
                      $SetDuePrice = $value->legisCompromise->DuePay_Promise;
                    }
  
                    $sheet->row(++$row, array(
                      $value->Contract_legis,
                      $value->Name_legis,
                      $value->legiscourt->fillingdate_court,
                      $value->legisCompromise->Date_Promise,
                      $SetStatus,
                      number_format($value->legisCompromise->Total_Promise, 2),
                      $SetFirst,
                      $SetFirstMoney,
                      $value->legisCompromise->Due_Promise,
                      number_format($SetDuePrice, 0),
                      number_format($value->legisCompromise->Sum_FirstPromise + $value->legisCompromise->Sum_DuePayPromise, 2),
                      number_format($value->legisCompromise->Sum_Promise, 2),
                      substr($value->legispayments->created_at,0,10),
                      number_format($value->legispayments->Gold_Payment, 2),
                      $value->legispayments->Type_Payment,
                      $value->legispayments->DateDue_Payment,
                      $value->legisCompromise->Note_Promise,
                    ));
                  }
                }
              }
          });
        })->export('xlsx');
      }
      elseif ($request->type == 3) {   //รายงาน Excel ลูกหนี้เก่า
        $data = Legislation::where('Flag', 'C')
        ->where('Status_legis', NULL)
        ->with(['legispayments' => function ($query) {
          return $query->where('Flag_Payment', 'Y');
        }])
        ->with('legisCompromise')
        ->with('legisTrackings')
        ->get();


        $status = 'ลูกหนี้ประนอมหนี้เก่า';
        Excel::create('รายงานลูกหนี้ประนอมหนี้เก่า', function ($excel) use($data,$status) {
          $excel->sheet($status, function ($sheet) use($data,$status) {
              $sheet->prependRow(1, array("บริษัท ชูเกียรติลิสซิ่ง จำกัด"));
              $sheet->prependRow(2, array($status));
              $sheet->cells('A3:P3', function($cells) {
                $cells->setBackground('#FFCC00');
              });
              $row = 3;
              $sheet->row($row, array('เลขที่สัญญา', 'ชื่อ-สกุล','เริ่มประนอมหนี้', 'สถานะลูกหนี้', 
                  'ยอดประนอมหนี้', 'เงินก้อนแรก','สถานะก้อนแรก','จำนวนงวด', 'งวดละ','ยอดชำระรวม', 'ยอดคงเหลือ', 
                  'วันที่ชำระล่าสุด', 'ยอดชำระล่าสุด', 'ประเภทชำระ', 'วันที่ดิวถัดไป','หมายเหตุ'));

              $lastday1 = date('Y-m-d', strtotime("-1 month"));
              $lastday2 = date('Y-m-d', strtotime("-2 month"));
              $lastday3 = date('Y-m-d', strtotime("-3 month"));
              $lastday4 = date('Y-m-d', strtotime("-4 month"));
              
              foreach ($data as $key => $value) {
                $SetStatus = NULL;
                if (@$value->legisTrackings->Status_Track != 'Y') {
                  // if($value->legispayments->DateDue_Payment >= date('Y-m-d') or $value->legispayments->DateDue_Payment > $lastday1) {
                  //   $SetStatus = 'ชำระปกติ';
                  // }elseif($value->legispayments->DateDue_Payment > $lastday1 or $value->legispayments->DateDue_Payment > $lastday2){
                  //   $SetStatus = 'ขาดชำระ 1 งวด';
                  // }elseif($value->legispayments->DateDue_Payment > $lastday2 or $value->legispayments->DateDue_Payment > $lastday3){
                  //   $SetStatus = 'ขาดชำระ 2 งวด';
                  // }elseif($value->legispayments->DateDue_Payment > $lastday3 or $value->legispayments->DateDue_Payment > $lastday4){
                  //   $SetStatus = 'ขาดชำระ 3 งวด';
                  // }

                  if($value->legisCompromise->HLDNO <= 0) {
                    $SetStatus = 'ชำระปกติ';
                  }elseif($value->legisCompromise->HLDNO >0 && $value->legisCompromise->HLDNO <2){
                    $SetStatus = 'ขาดชำระ 1 งวด';
                  }elseif($value->legisCompromise->HLDNO >1 && $value->legisCompromise->HLDNO <3){
                    $SetStatus = 'ขาดชำระ 2 งวด';
                  }elseif($value->legisCompromise->HLDNO >2 && $value->legisCompromise->HLDNO <4){
                    $SetStatus = 'ขาดชำระ 3 งวด';
                  }elseif($value->legisCompromise->HLDNO >3){
                    $SetStatus = 'ขาดชำระมากกว่า 3 งวด';
                  }

                  if ($SetStatus != NULL) {
                    if ($value->legisCompromise->FirstManey_1 != 0) {
                      $SetFirst = $value->legisCompromise->FirstManey_1;
                    }else {
                      $SetFirst = $value->legisCompromise->Payall_Promise;
                    }
                    if ($value->legisCompromise->Sum_FirstPromise == $SetFirst) {
                      $SetFirstMoney = 'ครบชำระก้อนแรก';
                    }else {
                      $SetFirstMoney = 'ขาดชำระก้อนแรก';
                    }
  
                    if ($value->legisCompromise->Due_1 != 0) {
                      $SetDuePrice = $value->legisCompromise->Due_1;
                    }else {
                      $SetDuePrice = $value->legisCompromise->DuePay_Promise;
                    }
  
                    $sheet->row(++$row, array(
                      $value->Contract_legis,
                      $value->Name_legis,
                      $value->legisCompromise->Date_Promise,
                      $SetStatus,
                      number_format($value->legisCompromise->Total_Promise, 2),
                      $SetFirst,
                      $SetFirstMoney,
                      $value->legisCompromise->Due_Promise,
                      number_format($SetDuePrice, 0),
                      number_format($value->legisCompromise->Sum_FirstPromise + $value->legisCompromise->Sum_DuePayPromise, 2),
                      number_format($value->legisCompromise->Sum_Promise, 2),
                      substr($value->legispayments->created_at,0,10),
                      number_format($value->legispayments->Gold_Payment, 2),
                      $value->legispayments->Type_Payment,
                      $value->legispayments->DateDue_Payment,
                      $value->legisCompromise->Note_Promise,
                    ));
                  }
                }
              }
          });
        })->export('xlsx');
      }
      elseif ($request->type == 4) {   //รายงาน ตรวจสอบการรับชำระ
        $newfdate = '';
        $newtdate = '';
        $CashReceiver = '';

        if ($request->has('Fdate')) {
          $fdate = $request->get('Fdate');
          $newfdate = date('Y-m-d 00:00:00', strtotime($fdate));
        }
        if ($request->has('Tdate')) {
          $tdate = $request->get('Tdate');
          $newtdate = date('Y-m-d 23:59:59', strtotime($tdate));
        }
        if ($request->has('CashReceiver')) {
          $CashReceiver = $request->get('CashReceiver');
        }

        $data = DB::table('legislations')
          ->leftJoin('Legiscompromises','legislations.id','=','Legiscompromises.legislation_id')
          ->leftJoin('legispayments','legislations.id','=','legispayments.legislation_id')
          ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
            return $q->whereBetween('legispayments.created_at',[$newfdate,$newtdate]);
          })
          ->when(!empty($CashReceiver), function($q) use($CashReceiver){
            return $q->where('legispayments.Adduser_Payment','=',$CashReceiver);
          })
          ->orderBy('legispayments.created_at','ASC')
          ->get();

        if ($request->Flag == 1) {  //Export PDF
          $pdf = new PDF();
          $pdf::SetTitle('รายงานรับชำระค่างวด');
          $pdf::AddPage('L', 'A4');
          $pdf::SetFont('thsarabun', '', 12, '', true);
          $pdf::SetMargins(1, 5, 5, 0);
          $pdf::SetAutoPageBreak(TRUE, 18);

          $type = $request->type;
          $view = \View::make('legisCompromise.report' ,compact('data','type','CashReceiver','newfdate','newtdate'));
          $html = $view->render();
          $pdf::WriteHTML($html,true,false,true,false,'');
          $pdf::Output('report.pdf');
        }
        elseif ($request->Flag == 2) {  //Export Excel
          $SetFdate = date('d-m-Y', strtotime($newfdate));
          $SetTdate = date('d-m-Y', strtotime($newtdate));

          $status = 'รายงานรับชำระค่างวด';
          Excel::create('รายงานรับชำระค่างวด', function ($excel) use($data,$status,$SetFdate,$SetTdate) {
            $excel->sheet($status, function ($sheet) use($data,$status,$SetFdate,$SetTdate) {
                $sheet->prependRow(1, array("บริษัท ชูเกียรติลิสซิ่ง จำกัด"));
                $sheet->prependRow(2, array($status.'  จากวันที่ '.$SetFdate.' ถึงวันที่ '.$SetTdate));
                $sheet->cells('A3:K3', function($cells) {
                  $cells->setBackground('#FFCC00');
                });
                $row = 3;
                $sheet->row($row, array('ลำดับ', 'เลขที่สัญญา', 'ประเภทลูกหนี้', 'ชื่อ-สกุล', 'วันที่รับชำระ', 'ยอดชำระ','ยอดคงเหลือ',
                                        'ประเภทชำระ','เลขที่ใบเสร็จ', 'ผูุ้รับชำระ', 'หมายเหตุ'));
                foreach ($data as $key => $value) {
                  if ($value->Flag == 'C') {
                    $SetStatus = "ลูกหนี้ประนอมเก่า";
                  }else {
                    $SetStatus = "ลูกหนี้ประนอมใหม่";
                  }
  
                  $sheet->row(++$row, array(
                    $key+1,
                    $value->Contract_legis,
                    $SetStatus,
                    $value->Name_legis,
                    substr($value->created_at,0,10),
                    number_format($value->Gold_Payment, 2),
                    number_format($value->Sum_Promise, 2),
                    $value->Type_Payment,
                    $value->Jobnumber_Payment,
                    $value->Adduser_Payment,
                    $value->Note_Payment,
                  ));
                }
            });
          })->export('xlsx');
        }
      }
      elseif ($request->type == 5) {   //รายงาน การชำระค่างวด(บุคคล)
        $dataDB = DB::table('legislations')
          ->join('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
          ->join('legispayments','legislations.id','=','legispayments.legis_Com_Payment_id')
          ->where('legislations.Contract_legis', '=', $request->Contract)
          ->get();

        $dataCount = count($dataDB);

        if ($dataCount != 0) {
          if ($dataDB[0]->Flag == "C") {
            $data = DB::connection('ibmi')
              ->table('ASFHP.ARMAST')
              ->join('ASFHP.INVTRAN','ASFHP.ARMAST.CONTNO','=','ASFHP.INVTRAN.CONTNO')
              ->join('ASFHP.VIEW_CUSTMAIL','ASFHP.ARMAST.CUSCOD','=','ASFHP.VIEW_CUSTMAIL.CUSCOD')
              ->where('ASFHP.ARMAST.CONTNO','=', $dataDB[0]->Contract_legis)
              ->first();
          }else {
            $data = DB::connection('ibmi')
              ->table('SFHP.ARMAST')
              ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
              ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
              ->where('SFHP.ARMAST.CONTNO','=', $dataDB[0]->Contract_legis)
              ->first();
          }
        }else {
          dd('ไม่มีเลขที่สัญญานี้ไม่ระบบประนอมหนี้');
        }

        $pdf = new PDF();
        $pdf::SetTitle('รายงาน การชำระค่างวด(บุคคล)');
        $pdf::AddPage('P', 'A4');
        $pdf::SetMargins(5, 5, 5, 5);
        $pdf::SetFont('freeserif', '', 8, '', true);

        $view = \View::make('legislation.reportCompro' ,compact('data','dataDB','type','dataCount','status','newfdate','newtdate'));
        $html = $view->render();
        $pdf::WriteHTML($html,true,false,true,false,'');
        $pdf::Output('report.pdf');
      }
      elseif ($request->type == 6) {   //รายงาน ลูกหนี้ชำระตามดิว
        $typeCus = $request->typeCus;
        $newfdate = $request->Fdate;
        $newtdate = $request->Tdate;

        $data = legispayment::whereBetween('DateDue_Payment',[$newfdate,$newtdate])
            ->Wherehas('PaymentTolegislation',function ($query) use($typeCus) {
              return $query->when(!empty($typeCus), function($q) use($typeCus) {
                return $q->where('Flag','=', $typeCus);
              });
            })
            ->with('PaymentTolegislation')
            ->with('PaymentToCompro')
            ->get();

        if ($request->FlagDoc == 1) {
          Excel::create('รายงานลูกหนี้ชำระตามดิว', function ($excel) use($data,$typeCus,$newfdate,$newtdate) {
            $excel->sheet('รายงานลูกหนี้ชำระตามดิว', function ($sheet) use($data,$typeCus,$newfdate,$newtdate) {
                $sheet->prependRow(1, array("บริษัท ชูเกียรติลิสซิ่ง จำกัด"));
                $sheet->prependRow(2, array('ลูกหนี้ชำระตามดิว'.'  จากวันที่ '.$newfdate.' ถึงวันที่ '.$newtdate));
                $sheet->cells('A3:L3', function($cells) {
                  $cells->setBackground('#FFCC00');
                });
                $row = 3;
                $sheet->row($row, array('ลำดับ', 'เลขที่สัญญา', 'ชื่อ - สกุล', 'ประเภทลูกหนี้', 'วันดิวชำระ', 'ค่างวด','เลขที่ใบเสร็จ',
                                        'วันที่ชำระ','ประเภท', 'ยอดชำระ', 'ผู้รับชำระ','หมายเหตุ'));

                foreach ($data as $key => $value) {
                  if ($value->PaymentTolegislation->Flag == 'C') {
                    $SetStatus = "ประนอมเก่า";
                  }else {
                    $SetStatus = "ประนอมใหม่";
                  }
  
                  $sheet->row(++$row, array(
                    $key+1,
                    $value->PaymentTolegislation->Contract_legis,
                    $value->PaymentTolegislation->Name_legis,
                    $SetStatus,
                    $value->DateDue_Payment,
                    number_format($value->PaymentToCompro->DuePay_Promise,0),
                    $value->Jobnumber_Payment,
                    substr($value->created_at,0,10),
                    $value->Type_Payment,
                    number_format($value->Gold_Payment,0),
                    $value->Adduser_Payment,
                    $value->Note_Payment,
                  ));
                }
            });
          })->export('xlsx');
        }
        elseif ($request->FlagDoc == 2) {
          $pdf = new PDF();
          $pdf::SetTitle('รายงานลูกหนี้ชำระตามดิว');
          $pdf::AddPage('L', 'A4');
          $pdf::SetFont('thsarabun', '', 12, '', true);
          $pdf::SetMargins(1, 5, 5, 0);
          $pdf::SetAutoPageBreak(TRUE, 18);
  
          $type = $request->type;
          $view = \View::make('legisCompromise.report' ,compact('data','type','typeCus','newfdate','newtdate'));
          $html = $view->render();
          $pdf::WriteHTML($html,true,false,true,false,'');
          $pdf::Output('report.pdf');
        }
      }
      elseif ($request->type == 10) {   //รายงาน Excel ลูกหนี้ประนอมทั้งหมด
        $data = Legislation::where('Status_legis', NULL)
          // ->where('Flag', 'C')
          // ->where('Contract_legis', '=', '05-2561/0084')
          ->with(['legisCompromise' => function ($query) {
            return $query->where('Date_Promise', '!=', NULL);
          }])
          ->Wherehas('legisCompromise',function ($query) {
            return $query->where('Date_Promise', '!=', NULL);
          })
          // ->Wherehas('legispayments',function ($query) {
          //   return $query->where('Flag_Payment', '!=', NULL);
          // })
          // ->with(['legispayments' => function ($query) {
          //   return $query->where('Flag_Payment', '!=', NULL);
          // }])
          // ->Wherehas('legisTrackings',function ($query) {
          //   return $query->where('Status_Track', '!=', NULL);
          // })
          ->with('legispayments')
          ->with('legisTrackings')
          ->orderBy('flag', 'desc')
          ->get();

          // dd($data);

        $status = 'ลูกหนี้ประนอมหนี้ทั้งหมด';
        Excel::create('รายงานลูกหนี้ประนอมหนี้ทั้งหมด', function ($excel) use($data,$status) {
          $excel->sheet($status, function ($sheet) use($data,$status) {
              $sheet->prependRow(1, array("บริษัท ชูเกียรติลิสซิ่ง จำกัด"));
              $sheet->prependRow(2, array($status));
              $sheet->cells('A3:V3', function($cells) {
                $cells->setBackground('#FFCC00');
              });
              $row = 3;
              $sheet->row($row, array('ประเภท','เลขที่สัญญา', 'ชื่อ-สกุล','วันที่ฟ้อง','เริ่มประนอมหนี้', 'สถานะลูกหนี้', 'สถานะติดตาม', 
                  'ยอดประนอมหนี้', 'เงินก้อนแรก','สถานะก้อนแรก','จำนวนงวด', 'งวดละ','ยอดชำระรวม', 'ยอดคงเหลือ', 
                  'วันที่ชำระงวดล่าสุด', 'ยอดชำระงวดล่าสุด', 'ยอดชำระ(สะสมเดือนล่าสุด)', 'ประเภทชำระ', 'วันที่ดิวถัดไป', 'งวดค้าง', 'รวมยอดค้าง', 'หมายเหตุ'));

              $lastday1 = date('Y-m-d', strtotime("-1 month"));
              $lastday2 = date('Y-m-d', strtotime("-2 month"));
              $lastday3 = date('Y-m-d', strtotime("-3 month"));
              $lastday4 = date('Y-m-d', strtotime("-4 month"));
              
              foreach ($data as $key => $value) {

                if($value->legispayments != NULL){
                  $dataPay = legispayment::whereMonth('created_at',substr($value->legispayments->created_at,5,2))
                            ->whereYear('created_at',substr($value->legispayments->created_at,0,4))
                            ->where('legislation_id', $value->id)
                            ->sum('Gold_Payment');
                  $SetStatus = NULL;
                  // if (@$value->legisTrackings->Status_Track != 'Y') {
                    if($value->legispayments->DateDue_Payment >= date('Y-m-d') or $value->legispayments->DateDue_Payment > $lastday1) {
                      $SetStatus = 'ชำระปกติ';
                    }elseif($value->legispayments->DateDue_Payment > $lastday1 or $value->legispayments->DateDue_Payment > $lastday2){
                      $SetStatus = 'ขาดชำระ 1 งวด';
                    }elseif($value->legispayments->DateDue_Payment > $lastday2 or $value->legispayments->DateDue_Payment > $lastday3){
                      $SetStatus = 'ขาดชำระ 2 งวด';
                    }elseif($value->legispayments->DateDue_Payment > $lastday3 or $value->legispayments->DateDue_Payment > $lastday4){
                      $SetStatus = 'ขาดชำระ 3 งวด';
                    }else{
                      $SetStatus = 'ขาดชำระกว่า 3 งวด';
                    }
                }


                  // if ($SetStatus != NULL) {
                    if ($value->legisCompromise->FirstManey_1 != 0) {
                      $SetFirst = $value->legisCompromise->FirstManey_1;
                    }else {
                      $SetFirst = $value->legisCompromise->Payall_Promise;
                    }
                    if ($value->legisCompromise->Sum_FirstPromise == $SetFirst) {
                      $SetFirstMoney = 'ครบชำระก้อนแรก';
                    }else {
                      $SetFirstMoney = 'ขาดชำระก้อนแรก';
                    }
  
                    if ($value->legisCompromise->Due_1 != 0) {
                      $SetDuePrice = $value->legisCompromise->Due_1;
                    }else {
                      $SetDuePrice = $value->legisCompromise->DuePay_Promise;
                    }
  
                    if(($value->Flag == 'Y' || $value->Flag == "W") && $value->Flag_status ==3  ){
                      $SetComproType = 'ประนอม';
                    }elseif($value->Flag == 'C'  && $value->Flag_status ==3 ){
                      $SetComproType = 'ประนอมขายฝาก';
                    }

                    if (@$value->legisTrackings->Status_Track != 'Y') {
                      $SetStatus2 = "";
                    }elseif (@$value->legisTrackings->Status_Track == 'Y') {
                      $SetStatus2 = "โทรติดตาม";
                    }

                    if ($value->legispayments != NULL){
                      if ($value->legispayments->DateDue_Payment < date('Y-m-d')) {
                        $DateDue = date_create($value->legispayments->DateDue_Payment);
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
                        $DueCus = 0;
                      }
                    }
                    else{
                      $DueCus = 0;
                    }
  
                    $sheet->row(++$row, array(
                      $value->legisCompromise->Type_Promise,
                      $value->Contract_legis,
                      $value->Name_legis,
                      @$value->legiscourt->fillingdate_court,
                      $value->legisCompromise->Date_Promise,
                      $SetStatus,
                      $SetStatus2,
                      $value->legisCompromise->Total_Promise,
                      $SetFirst,
                      $SetFirstMoney,
                      $value->legisCompromise->Period_1,
                      $SetDuePrice,
                      ($value->legisCompromise->Sum_FirstPromise + $value->legisCompromise->Sum_DuePayPromise),
                      floatval($value->legisCompromise->Total_Promise)- (floatval($value->legisCompromise->Sum_FirstPromise) + floatval($value->legisCompromise->Sum_DuePayPromise)),
                      @$value->legispayments->Date_Payment,
                      @$value->legispayments->Gold_Payment, //ยอดชำระงวดล่าสุด
                      @$dataPay, //ยอดชำระสะสมในเดือน
                      @$value->legispayments->Type_Payment,
                      @$value->legispayments->DateDue_Payment,
                      $DueCus,
                      ($SetDuePrice * $DueCus),
                      $value->legisCompromise->Note_Promise,
                    ));
                  // }
                // }
              }
          });
        })->export('xlsx');
      }
    }
}

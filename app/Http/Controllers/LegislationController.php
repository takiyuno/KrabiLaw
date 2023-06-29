<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;
use Storage;
use File;
use Carbon\Carbon;
use Exporter;
use Excel;
use Helper;

use App\Legislation;
use App\Legiscourt;
use App\Legiscourtcase;
use App\LegisImage;
use App\Legiscompromise;
use App\legispayment;
use App\legisasset;
use App\legischeat;
use App\Legisexhibit;
use App\Legisland;
use App\Content;
use App\LegisPublishsell;
use App\TB_Billcoll;
class LegislationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $Fdate = NULL;
      $Tdate = NULL;
      $FlagTab = NULL;
      $dateSearch = NULL;
      $Flag = $arrayName = array('W' =>'ลูกหนี้ก่อนฟ้อง' ,'Y'=>'ลูกหนี้ส่งฟ้อง','C'=>'ลูกหนี้หลุดขายฝาก' );
      $Flag_Status = $arrayName = array('1' =>'ไม่ประนอมหนี้' ,'2'=>'ไม่ประนอมหนี้','3'=>'ประนอมหนี้' );
      if ($request->get('dateSearch')) {
        $dateSearch = $request->dateSearch;

        $SetFdate = substr($dateSearch,0,10);
        $Fdate = date('Y-m-d', strtotime($SetFdate));

        $SetTdate = substr($dateSearch,13,21);
        $Tdate = date('Y-m-d', strtotime($SetTdate));
      }
      
      if ($request->has('FlagTab')) {
        $FlagTab = $request->get('FlagTab');
      }
      elseif (session()->has('FlagTab')) {
          $FlagTab = session('FlagTab');
      }
      $pranom_list = Legiscompromise::select(DB::raw("legislation_id"))
      ->where('Flag_Promise','=','Active')->get();
      if($request->type == 1) {        //Popup-รายชื่อลูกหนี้
        $type = $request->type;
        return view('legislation.SearchCustom',compact('type'));
      }
      elseif ($request->type == 2) {   //search
        $Conn = $request->id;
        $data = Legislation::where('legislations.Contract_legis',$Conn)
              ->with('legiscourt')
              ->with('legiscourtCase')
              ->with('legisCompromise')
              ->with('Legisasset')
              ->first();

        $type = $request->type;
        $billcoll = TB_Billcoll::get();
        return response()->view('legislation.dataSearch', compact('data','type','billcoll'));
      }
      elseif ($request->type == 3) {   // View-ลูกหนี้เตรียมฟ้อง
        $FlagStatus = '';
        
        if ($request->get('FlagStatus')){
          $FlagStatus = $request->get('FlagStatus');
        }

        if ($request->searchButton == 1 ) {
          $data = Legislation:://where('Flag_status', $FlagStatus)
                when(!empty($Fdate)  && !empty($Tdate) , function ($q) use ($Fdate, $Tdate) {
                    return $q->whereBetween('Date_legis', [$Fdate, $Tdate]);
                })
                ->when(!empty($FlagStatus), function ($q) use ($FlagStatus) {
                    return $q->where('Flag_status', $FlagStatus);
                })
                  // whereBetween('Date_legis',[$Fdate,$Tdate])
                ->whereIn('Flag', array('Y','W',))
                
                ->get();
        }
        else{
          $data = Legislation:: //where('Flag_status', 1)
              whereIn('Flag',array('W'))->where('Flag_status','<>',3)->get();
        }

        $type = $request->type;
        return view('legislation.viewLegis', compact('type', 'data','dateSearch','FlagStatus','Flag_Status','Flag'));
      }
      elseif ($request->type == 4) {   // View-ลูกหนี้ชั้นศาล
       
        $data1 = Legislation::where('Status_legis', NULL)
              ->where('Flag', 'Y')
              ->where('Flag_Class', 'สถานะส่งฟ้อง')
              //->whereNotIn('id',$pranom_list)
              ->get();

        $data2 = Legislation::where('Status_legis', NULL)
              ->where('Flag', 'Y')
              ->where('Flag_Class', 'สถานะส่งสืบพยาน')
             // ->whereNotIn('id',$pranom_list)
              ->get();

        $data3 = Legislation::where('Status_legis', NULL)
              ->where('Flag', 'Y')
              ->where('Flag_Class', 'สถานะส่งคำบังคับ')
              //->whereNotIn('id',$pranom_list)
              ->get();

        $data4 = Legislation::where('Status_legis', NULL)
              ->where('Flag', 'Y')
              ->where('Flag_Class', 'สถานะส่งตรวจผลหมาย')
              //->whereNotIn('id',$pranom_list)
              ->get();

        $data5 = Legislation::where('Status_legis', NULL)
              ->where('Flag', 'Y')
              ->where('Flag_Class', 'สถานะส่งตั้งเจ้าพนักงาน')
             // ->whereNotIn('id',$pranom_list)
              ->get();

        $data6 = Legislation::where('Status_legis', NULL)
              ->where('Flag', 'Y')
              ->where('Flag_Class', 'สถานะส่งตรวจผลหมายตั้ง')
              //->whereNotIn('id',$pranom_list)
              ->get();

        // dump($data1,$data2);
        $type = $request->type;
        return view('legisCourt.view', compact('type','data1','data2','data3','data4','data5','data6','dateSearch','FlagTab','Flag_Status','Flag' ));
      }
      elseif ($request->type == 5) {   // View-ลูกหนี้ชั้นบังคับคดี
        $data1 = Legislation::where('Status_legis', NULL)
          ->where('Flag_Class','=', 'สถานะคัดหนังสือรับรองคดี')
          //->whereNotIn('id',$pranom_list)
          ->with('legiscourtCase')
          ->get();

        $data2 = Legislation::where('Status_legis', NULL)
          ->where('Flag_Class','=', 'สถานะสืบทรัพย์บังคับคดี')
          //->whereNotIn('id',$pranom_list)
          ->with('legiscourtCase')
          ->get();

        $data3 = Legislation::where('Status_legis', NULL)
          ->where('Flag_Class','=', 'สถานะคัดโฉนด')
          //->whereNotIn('id',$pranom_list)
          ->with('legiscourtCase')
          ->get();

        $data4 = Legislation::where('Status_legis', NULL)
          ->where('Flag_Class','=', 'สถานะตั้งยึดทรัพย์')
          //->whereNotIn('id',$pranom_list)
          ->with('legiscourtCase')
          ->get();

        $data5 = Legislation::where('Status_legis', NULL)
          ->where('Flag_Class','=', 'ประกาศขายทอดตลาด')
         // ->whereNotIn('id',$pranom_list)
          ->with('legiscourtCase')
          ->get();

        $type = $request->type;
        return view('legisCourt.view', compact('type','Flag','data1','data2','data3','data4','data5','dateSearch','FlagTab','Flag_Status','Flag'));
      }
      elseif ($request->type == 6) {   // View-สืบทรัพย์
        $data1 = Legislation::where('Status_legis', NULL)
          ->Wherehas('Legisasset',function ($query) {
            return $query->where('propertied_asset', 'Y');
          })
          ->get();

        $data2 = Legislation::where('Status_legis', NULL)
          ->Wherehas('Legisasset',function ($query) {
            return $query->where('propertied_asset', 'N');
          })
          ->get();

        $SubId = Legislation::select('id')
          ->where('Status_legis', NULL)
          ->Wherehas('Legisasset')
          ->groupBy('id')
          ->get();

        $dataSubId = Legislation::WhereNotIn('id', $SubId->toArray())
          ->where('Flag_status', 2)
          ->where('Status_legis', NULL)
          ->get();

        $Flag = $request->Flag;
        $type = $request->type;
        return view('legisAsset.view', compact('type','Flag','data1','data2','dataSubId','dateSearch'));
      }
      elseif ($request->type == 7 ) {  // View-ปิดจบ
        // DateStatus_legis
        $data1 = Legislation::where('Status_legis', '!=',NULL)
              ->where('Flag', 'Y')
              ->where('Status_legis','=','ปิดบัญชี')
              ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                  return $q->whereBetween('DateStatus_legis',[$Fdate,$Tdate]);
                })
              ->get();

        $data2 = Legislation::where('Status_legis', '!=',NULL)
              ->where('Flag', 'Y')
              ->where('Status_legis','=','ปิดจบประนอม')
              ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                return $q->whereBetween('DateStatus_legis',[$Fdate,$Tdate]);
              })
              ->with('legisCompromise')
              ->get();

        $data3 = Legislation::where('Status_legis', '!=',NULL)
              ->where('Flag', 'Y')
              ->where('Status_legis','=','ปิดจบรถยึด')
              ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                return $q->whereBetween('DateStatus_legis',[$Fdate,$Tdate]);
              })
              ->get();

        $data4 = Legislation::where('Status_legis', '!=',NULL)
              ->where('Flag', 'Y')
              ->where('Status_legis','=','ปิดจบถอนบังคับคดี')
              ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                return $q->whereBetween('DateStatus_legis',[$Fdate,$Tdate]);
              })
              ->get();
          // dd($data);

        $type = $request->type;
        return view('legisCourt.viewComplete', compact('type','data1','data2','data3','data4','dateSearch'));
      }
      elseif ($request->type == 8) {   //ของกลาง
        $data1 = Legisexhibit::where('Typeexhibit_legis','ของกลาง')
                ->with('ExpenseToExhibit')
                // ->whereBetween('Dateaccept_legis',[$Fdate,$Tdate])
                ->get();
                //dump($data1);

        $data2 = Legisexhibit::where('Typeexhibit_legis','ยึดตามมาตราการ(ปปส.)')
                ->with('ExpenseToExhibit')
                // ->whereBetween('Dateaccept_legis',[$Fdate,$Tdate])
                ->get();

        $data3 = Legisexhibit::where('Typeexhibit_legis',NULL)
                // ->whereBetween('Dateaccept_legis',[$Fdate,$Tdate])
                ->get();
                // dump($Fdate,$Tdate,$data1,$data2);

        $type = $request->type;
        return view('LegisExhibit.view', compact('type','data1','data2','data3','dateSearch'));
      }
      elseif ($request->type == 12) {   //ขายฝาก
        $dataLand = DB::table('legislands')
                  ->orderBy('ContractNo_legis', 'ASC')
                  ->get();
        $type = $request->type;
        return view('legislation.view', compact('type','dataLand','Flag_Status'));
      }
      elseif ($request->type == 20) {   //Main legislation
        //ลูกหนี้เตรียมฟ้อง
        $data1 = DB::table('legislations')
          ->where('legislations.Flag_status','=', '1')
          ->count();

        //ลูกหนี้รอฟ้อง
        $data2 = DB::table('legislations')
          ->leftJoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
          ->where('legislations.Status_legis','=', NULL)
          ->where('legislations.Flag_status','=', '2')
          ->where('legislations.Flag_Class','=', 'ลูกหนี้รอฟ้อง')
          ->count();

        //ลูกหนี้ชั้นศาล
        $data3 = DB::table('legislations')
          ->leftJoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
          ->where('legislations.Status_legis','=', NULL)
          ->where('legiscourts.fillingdate_court','!=', NULL)
          ->count();

        //ลูกหนี้ชั้นบังคับคดี
        $data4 = DB::table('legislations')
          ->where('legislations.Flag_Class','=', 'สถานะส่งคัดโฉนด')
          ->orwhere('legislations.Flag_Class','=', 'สถานะส่งยึดทรัพย์')
          ->count();

        //ลูกหนี้โกงเจ้าหนี้
        $data5 = DB::table('legislations')
          ->where('legislations.Flag_Class','=', 'สถานะส่งโกงเจ้าหนี้')
          ->count();

        //ลูกหนี้สืบทรัพย์
        $data6 = DB::table('legisassets')
          ->count();

        //ลูกหนี้ปิดจบงาน
        $data7 = DB::table('legislations')
          ->where('legislations.Status_legis','!=', NULL)
          ->count();
        //ลูกหนี้ประนอมหนี้
        $data8 = DB::table('Legiscompromises')
          ->count();

        $type = $request->type;
        return view('legislation.view', compact('type','data1','data2','data3','data4','data5','data6','data7','data8'));
      }elseif($request->type == 21){
        $FlagStatus = '';
        if ($request->get('FlagStatus')){
          $FlagStatus = $request->get('FlagStatus');
        }

        if ($request->searchButton == 1 ) {
          $data = Legislation:: when(!empty($Fdate)  && !empty($Tdate) , function ($q) use ($Fdate, $Tdate) {
                return $q->whereBetween('Date_legis', [$Fdate, $Tdate]);
                })
                ->when(!empty($FlagStatus), function ($q) use ($FlagStatus) {
                    return $q->where('Flag_status', $FlagStatus);
                })
                ->where('Flag', 'C')
                ->get();
        }
        else{
          $data = Legislation::
                  where('Flag', 'C')
                  ->where('Status_legis','=',NULL)->get();
        }

        $type = $request->type;

      
        return view('legislation.viewLegis', compact('type', 'data','dateSearch','FlagStatus','Flag_Status','Flag'));
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      if ($request->type == 1) {  //Add ลูกหนี้ของกลาง
        $type = $request->type;
        $FlagTab = $request->FlagTab;
        return view('LegisExhibit.Popup',compact('type','FlagTab'));
      }
      elseif ($request->type == 2) {  //modal date report
        $type = $request->type;
        $FlagTab = $request->FlagTab;
        return view('legisCourt.viewReport',compact('type','FlagTab'));
      }
    }

    public function SearchData(Request $request, $type)
    {
      if ($type == 1) {     //Modal-รายชื่อลูกหนี้
        $DB_type = $request->get('DB_type');
        $Contract = $request->get('Contno');

        if ($DB_type == 1) {       //ลูกหนี้เช่าซื้อ

          $data = DB::connection('ibmi2')
              ->table('RSFHP.ARMAST')
              //->leftJoin('RSFHP.INVTRAN','RSFHP.ARMAST.STRNO','=','RSFHP.INVTRAN.STRNO')     
              ->leftJoin('RSFHP.VIEW_CUSTMAIL','RSFHP.ARMAST.CUSCOD','=','RSFHP.VIEW_CUSTMAIL.CUSCOD')                       
              ->where('RSFHP.ARMAST.CONTNO','=',$Contract)
              ->first();
          if( $data==NULL){            
            $data = DB::connection('ibmi2')
            ->table('RSFHP.HARMAST')
            //->leftJoin('RSFHP.INVTRAN','RSFHP.ARMAST.STRNO','=','RSFHP.INVTRAN.STRNO')     
            ->leftJoin('RSFHP.VIEW_CUSTMAIL','RSFHP.HARMAST.CUSCOD','=','RSFHP.VIEW_CUSTMAIL.CUSCOD')                       
            ->where('RSFHP.HARMAST.CONTNO','=',$Contract)
            ->first();
          }
         // dd($data);
          $dataGT = DB::connection('ibmi2')
              ->table('RSFHP.VIEW_ARMGAR')
              ->where('RSFHP.VIEW_ARMGAR.CONTNO','=', $Contract)
              ->first();

          // query ทรัพย์
          $dataAro = DB::connection('ibmi2')
              ->table('RSFHP.ARMAST')
              ->join('RSFHP.AROTHGAR','RSFHP.ARMAST.CONTNO','=','RSFHP.AROTHGAR.CONTNO')
              ->where('RSFHP.ARMAST.CONTNO','=', $Contract)
              ->first();
            if( $dataAro==NULL){
              $dataAro = DB::connection('ibmi2')
              ->table('RSFHP.HARMAST')
              ->join('RSFHP.AROTHGAR','RSFHP.HARMAST.CONTNO','=','RSFHP.AROTHGAR.CONTNO')
              ->where('RSFHP.HARMAST.CONTNO','=', $Contract)
              ->first();
            }
          
          if ($dataAro != NULL) {
            $SetRealty = 'มีทรัพย์';
          }else {
            $SetRealty = 'ไม่มีทรัพย์';
          }
        }
        elseif ($DB_type == 2) {   //ลูกหนี้งาน A
          $data = DB::connection('ibmi2')
              ->table('ASFHP.ARMAST')
              ->leftjoin('ASFHP.INVTRAN','ASFHP.ARMAST.CONTNO','=','ASFHP.INVTRAN.CONTNO')
              ->leftjoin('ASFHP.VIEW_CUSTMAIL','ASFHP.ARMAST.CUSCOD','=','ASFHP.VIEW_CUSTMAIL.CUSCOD')
              ->where('ASFHP.ARMAST.CONTNO','=', $Contract)
              ->first();
          
          // query ทรัพย์
          $dataAro = DB::connection('ibmi2')
              ->table('ASFHP.ARMAST')
              ->join('ASFHP.AROTHGAR','ASFHP.ARMAST.CONTNO','=','ASFHP.AROTHGAR.CONTNO')
              ->where('ASFHP.ARMAST.CONTNO','=', $Contract)
              ->first();
          
          if ($dataAro != NULL) {
            $SetRealty = 'มีทรัพย์';
          }else {
            $SetRealty = 'ไม่มีทรัพย์';
          }
        }
        elseif ($DB_type == 3 or $DB_type == 6) {   //ลูกหนี้เงินกู้/ขายฝาก
          $data = DB::connection('ibmi2')
              ->table('PSFHP.ARMAST')
              ->join('PSFHP.INVTRAN','PSFHP.ARMAST.CONTNO','=','PSFHP.INVTRAN.CONTNO')
              ->join('PSFHP.VIEW_CUSTMAIL','PSFHP.ARMAST.CUSCOD','=','PSFHP.VIEW_CUSTMAIL.CUSCOD')
              ->where('PSFHP.ARMAST.CONTNO','=', $Contract)
              ->first();
            if($data==NULL){
              $data = DB::connection('ibmi2')
              ->table('PSFHP.HARMAST')
              ->join('PSFHP.HINVTRAN','PSFHP.HARMAST.CONTNO','=','PSFHP.HINVTRAN.CONTNO')
              ->join('PSFHP.VIEW_CUSTMAIL','PSFHP.HARMAST.CUSCOD','=','PSFHP.VIEW_CUSTMAIL.CUSCOD')
              ->where('PSFHP.HARMAST.CONTNO','=', $Contract)
              ->first();
            }
              
          $dataGT = DB::connection('ibmi2')
              ->table('PSFHP.VIEW_ARMGAR')
              ->where('PSFHP.VIEW_ARMGAR.CONTNO','=', $Contract)
              ->first();
              
              // query ทรัพย์
          $dataAro = DB::connection('ibmi2')
              ->table('PSFHP.ARMAST')
              ->join('PSFHP.AROTHGAR','PSFHP.ARMAST.CONTNO','=','PSFHP.AROTHGAR.CONTNO')
              ->where('PSFHP.ARMAST.CONTNO','=', $Contract)
              ->first();
          
          if ($dataAro != NULL) {
            $SetRealty = 'มีทรัพย์';
          }else {
            $SetRealty = 'ไม่มีทรัพย์';
          }

        }
        // elseif ($DB_type == 4) {   //ลูกหนี้ขายฝากเก่า
        //   $data = DB::connection('ibmi2')
        //     ->table('LSFHP.ARMAST')
        //     ->leftjoin('LSFHP.INVTRAN','LSFHP.ARMAST.CONTNO','=','LSFHP.INVTRAN.CONTNO')
        //     ->leftjoin('LSFHP.VIEW_CUSTMAIL','LSFHP.ARMAST.CUSCOD','=','LSFHP.VIEW_CUSTMAIL.CUSCOD')
        //     ->where('LSFHP.ARMAST.CONTNO','=', $Contract)
        //     ->first();
        // }
        // elseif ($DB_type == 5) {   //ลูกหนี้หลุดขายฝากเก่า
        //   $data = DB::connection('ibmi')
        //     ->table('LSFHP.ARHOLD')
        //     ->leftjoin('LSFHP.HINVTRAN','LSFHP.ARHOLD.CONTNO','=','LSFHP.HINVTRAN.CONTNO')
        //     ->where('LSFHP.ARHOLD.CONTNO', $Contract)
        //     ->first();
        // }

        $datalegis = Legislation::where('Contract_legis',$Contract)->first();
        $billcoll = TB_Billcoll::get();
        return response()->view('legislation.dataSearch', compact('data','datalegis','SetRealty','DB_type','Contract','type','billcoll'));
      }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if ($request->type == 1) {      //Modal-ปิดบัญชี
        $user = Legislation::find($request->id);
          $user->Status_legis = $request->Status;
          $user->UserStatus_legis = $request->UserCloseAccount;   //user
          $user->DateStatus_legis = $request->DateCloseAccount;   //วันที่ปิดบัญชี
          $user->PriceStatus_legis = str_replace (",","",$request->PriceAccount);
          $user->txtStatus_legis = str_replace (",","",$request->TopCloseAccount);
          $user->Discount_legis = str_replace (",","",$request->DiscountAccount);
          $user->CostPrice_legis = str_replace (",","",$request->Paidamount);
          $user->DateUpState_legis = str_replace (",","",$request->CostPrice);
        $user->update();

        $type = $request->type;
        if($request->Status == 'ปิดบัญชี'){
          $view = \View::make('legislation.reportModals' ,compact('user','type'));
          $html = $view->render();
  
          $pdf = new PDF();
          $pdf::SetTitle('ใบเสร็จปิดบัญชี');
          $pdf::AddPage('L', 'A5');
          $pdf::SetMargins(16, 5, 5, 5);
          $pdf::SetFont('freeserif', '', 11, '', true);
          $pdf::SetAutoPageBreak(TRUE, 5);
          $pdf::WriteHTML($html,true,false,true,false,'');
          $pdf::Output('report.pdf');
        }else{
          return redirect()->back()->with(['success' => 'บันทึกข้อมูลเรียบร้อยแล้ว']);
        }
      }
      elseif ($request->type == 2){ //เพิ่มข้อของกลาง
        $Dateresult = NULL;
        if($request->get('DategetResult1') != Null){
          $Dateresult = $request->get('DategetResult1');
        }
        if($request->get('DategetResult2') != Null){
          $Dateresult = $request->get('DategetResult2');
        }
        $LegisExhibit = new Legisexhibit([
          'Contract_legis' => $request->get('ContractNo'),
          'Dateaccept_legis' => $request->get('DateExhibit'),
          'Name_legis' =>  $request->get('NameContract'),
          'Policestation_legis' =>  $request->get('PoliceStation'),
          'Suspect_legis' =>  $request->get('NameSuspect'),
          'Plaint_legis' =>  $request->get('PlaintExhibit'),
          'Inquiryofficial_legis' =>  $request->get('InquiryOfficial'),
          'Inquiryofficialtel_legis' =>  $request->get('InquiryOfficialtel'),
          'Terminate_legis' =>  $request->get('TerminateExhibit'),
          'DateLawyersend_legis' =>  $request->get('DateLawyersend'),
          'Typeexhibit_legis' =>  $request->get('TypeExhibit'),
          'Currentstatus_legis' =>  $request->get('Currentstatus'),
          'Nextstatus_legis' =>  $request->get('Nextstatus'),
          'Noteexhibit_legis' =>  $request->get('NoteExhibit'),
          'Dategiveword_legis' =>  $request->get('DateGiveword'),
          'Typegiveword_legis' =>  $request->get('TypeGiveword'),
          'Datepreparedoc_legis' =>  $request->get('DatePreparedoc'),
          'Dateinvestigate_legis' =>  $request->get('DateInvestigate'),
          'Datecheckexhibit_legis' =>  $request->get('DateCheckexhibit'),
          'Datesendword_legis' =>  $request->get('DateSendword'),
          'Resultexhibit1_legis' =>  $request->get('ResultExhibit1'),
          'Processexhibit1_legis' =>  $request->get('ProcessExhibit1'),
          'Datesenddetail_legis' =>  $request->get('DateSenddetail'),
          'Resultexhibit2_legis' =>  $request->get('ResultExhibit2'),
          'Processexhibit1_legis' =>  $request->get('ProcessExhibit2'),
          'Dategetresult_legis' =>  $Dateresult,
        ]);
        $LegisExhibit->save();

        $FlagTab = $request->FlagTab;
        return redirect()->back()->with(['FlagTab' => $FlagTab,'success' => 'บันทึกข้อมูลเรียบร้อยแล้ว']);
      }
      elseif ($request->type == 3){ //เพิ่มวันประกาศขายทอดตลาด
        $legis_id = $request->get('legis_id');
        $datePublish[1] = $request->get('datePublish1');
        $datePublish[2] = $request->get('datePublish2');
        $datePublish[3] = $request->get('datePublish3');
        $datePublish[4] = $request->get('datePublish4');
        $datePublish[5] = $request->get('datePublish5');
        $datePublish[6] = $request->get('datePublish6');
        $Note[1] = $request->get('Note1');
        $Note[2] = $request->get('Note2');
        $Note[3] = $request->get('Note3');
        $Note[4] = $request->get('Note4');
        $Note[5] = $request->get('Note5');
        $Note[6] = $request->get('Note6');

        $Legiscourtcase = Legiscourtcase::where('legislation_id',$legis_id)->first();
        $Legiscourtcase->datePublicsell_case = $datePublish[1];
        $Legiscourtcase->update();
        
        $data = LegisPublishsell::where('legislation_id',$legis_id)->orderBy('id','desc')->first();
          if($data == NULL){
            $Round = 1;
          }else{
            $Round = $data->Round_publish + 1;
          }
        for ($i=1; $i <= 6; $i++) {
          $Num_id = LegisPublishsell::orderBy('id','desc')->first();
          if($Num_id == NULL){
            $id = 1;
          }else{
            $id = $Num_id->id + 1;
          }

          $LegisPublish = new LegisPublishsell([
            'id' => $id,
            'legislation_id' => $legis_id,
            'Dateset_publish' => $datePublish[$i],
            'Note_publish' =>  $Note[$i],
            'Useradd_publish' =>  $request->get('Nameuser'),
            'Round_publish' =>  $Round,
            'Flag_publish' =>  'NOW',
          ]);
          $LegisPublish->save();
        }

        $data = LegisPublishsell::where('legislation_id',$legis_id)->orderBy('id','desc')->first();
          if($data != NULL){
            if($data->Round_publish > 1){
              $user = LegisPublishsell::where('legislation_id',$legis_id)->where('Round_publish','<',$data->Round_publish)->update(['Flag_publish' => 'PASSED']);
            }
          }

        

        return redirect()->back()->with(['success' => 'บันทึกข้อมูลเรียบร้อยแล้ว']);
      }
    }

    public function Savestore(Request $request)
    {
      if ($request->Contno != '') {
        $SetStrConn = $request->Contno;
      }

      if ($request->type == 1) {       //ลูกหนี้เช่าซื้อ
        $SetTypeDB = 'RSFHP';
        $SetTypeConn = '101';

        $data = DB::connection('ibmi2')
          ->table('RSFHP.ARMAST')
          ->join('RSFHP.INVTRAN','RSFHP.ARMAST.CONTNO','=','RSFHP.INVTRAN.CONTNO')
          ->join('RSFHP.VIEW_CUSTMAIL','RSFHP.ARMAST.CUSCOD','=','RSFHP.VIEW_CUSTMAIL.CUSCOD')
          ->where('RSFHP.ARMAST.CONTNO','=', $SetStrConn)
          ->first();

        // query ทรัพย์
        $dataAro = DB::connection('ibmi2')
          ->table('RSFHP.ARMAST')
          ->join('RSFHP.AROTHGAR','RSFHP.ARMAST.CONTNO','=','RSFHP.AROTHGAR.CONTNO')
          ->where('RSFHP.ARMAST.CONTNO','=', $SetStrConn)
          ->first();

        $dataGT = DB::connection('ibmi2')
          ->table('RSFHP.VIEW_ARMGAR')
          ->where('RSFHP.VIEW_ARMGAR.CONTNO','=', $SetStrConn)
          ->first();
      }
      elseif ($request->type == 2) {   //ลูกหนี้เช่าซื้อเก่า
        $SetTypeDB = 'ASFHP';
        $SetTypeConn = substr($SetStrConn,0,3);
        
        $data = DB::connection('ibmi2')
          ->table('ASFHP.ARMAST')
          ->leftjoin('ASFHP.INVTRAN','ASFHP.ARMAST.CONTNO','=','ASFHP.INVTRAN.CONTNO')
          ->leftjoin('ASFHP.VIEW_CUSTMAIL','ASFHP.ARMAST.CUSCOD','=','ASFHP.VIEW_CUSTMAIL.CUSCOD')
          ->where('ASFHP.ARMAST.CONTNO','=', $SetStrConn)
          ->first();

        // query ทรัพย์
        $dataAro = DB::connection('ibmi2')
          ->table('ASFHP.ARMAST')
          ->join('ASFHP.AROTHGAR','ASFHP.ARMAST.CONTNO','=','ASFHP.AROTHGAR.CONTNO')
          ->where('ASFHP.ARMAST.CONTNO','=', $SetStrConn)
          ->first();
        
        $dataGT = DB::connection('ibmi2')
          ->table('ASFHP.VIEW_ARMGAR')
          ->where('ASFHP.VIEW_ARMGAR.CONTNO','=', $SetStrConn)
          ->first();
      }
      elseif ($request->type == 3) {   //ลูกหนี้เงินกู้
        $SetTypeDB = 'PSFHP';
        $SetTypeConn = substr($SetStrConn,0,3);

        $data = DB::connection('ibmi2')
          ->table('PSFHP.ARMAST')
          ->join('PSFHP.INVTRAN','PSFHP.ARMAST.CONTNO','=','PSFHP.INVTRAN.CONTNO')
          ->join('PSFHP.VIEW_CUSTMAIL','PSFHP.ARMAST.CUSCOD','=','PSFHP.VIEW_CUSTMAIL.CUSCOD')
          ->where('PSFHP.ARMAST.CONTNO','=', $SetStrConn)
          ->first();
          if($data==NULL){
            $data = DB::connection('ibmi2')
          ->table('PSFHP.HARMAST')
          ->join('PSFHP.HINVTRAN','PSFHP.HARMAST.CONTNO','=','PSFHP.HINVTRAN.CONTNO')
          ->join('PSFHP.VIEW_CUSTMAIL','PSFHP.HARMAST.CUSCOD','=','PSFHP.VIEW_CUSTMAIL.CUSCOD')
          ->where('PSFHP.HARMAST.CONTNO','=', $SetStrConn)
          ->first();
          }

        // query ทรัพย์
        $dataAro = DB::connection('ibmi2')
          ->table('PSFHP.ARMAST')
          ->join('PSFHP.AROTHGAR','PSFHP.ARMAST.CONTNO','=','PSFHP.AROTHGAR.CONTNO')
          ->where('PSFHP.ARMAST.CONTNO','=', $SetStrConn)
          ->first();
          if( $dataAro==NULL){
            $dataAro = DB::connection('ibmi2')
            ->table('PSFHP.HARMAST')
            ->join('PSFHP.AROTHGAR','PSFHP.HARMAST.CONTNO','=','PSFHP.AROTHGAR.CONTNO')
            ->where('PSFHP.HARMAST.CONTNO','=', $SetStrConn)
            ->first();
          }
        
        $dataGT = DB::connection('ibmi2')
          ->table('PSFHP.VIEW_ARMGAR')
          ->where('PSFHP.VIEW_ARMGAR.CONTNO','=', $SetStrConn)
          ->first();
      }
      // elseif ($request->type == 4) {    //ลูกหนี้ขายฝากเก่า
      //   $SetTypeDB = 'LSFHP';
      //   $SetTypeConn = 'P01';

      //   $data = DB::connection('ibmi')
      //     ->table('LSFHP.ARMAST')
      //     ->join('LSFHP.INVTRAN','LSFHP.ARMAST.CONTNO','=','LSFHP.INVTRAN.CONTNO')
      //     ->join('LSFHP.VIEW_CUSTMAIL','LSFHP.ARMAST.CUSCOD','=','LSFHP.VIEW_CUSTMAIL.CUSCOD')
      //     ->where('LSFHP.ARMAST.CONTNO','=', $SetStrConn)
      //     ->first();
      // }
      // elseif ($request->type == 5) {   //ลูกหนี้หลุดขายฝากเก่า
      //   $SetTypeDB = 'LSFHP';
      //   $SetTypeConn = 'P01';

      //   $data = DB::connection('ibmi')
      //     ->table('LSFHP.ARHOLD')
      //     ->leftjoin('LSFHP.VIEW_CUSTMAIL','LSFHP.ARHOLD.CUSCOD','=','LSFHP.VIEW_CUSTMAIL.CUSCOD')
      //     ->leftjoin('LSFHP.HINVTRAN','LSFHP.ARHOLD.CONTNO','=','LSFHP.HINVTRAN.CONTNO')
      //     ->where('LSFHP.ARHOLD.CONTNO', $SetStrConn)
      //     ->first();
      // }
        elseif ($request->type == 6) {    //ลูกหนี้ขายฝาก
          $SetTypeDB = 'PSFHP';
          $SetTypeConn = 'P01';

          $data = DB::connection('ibmi2')
            ->table('P132SFHP.ARMAST')
            ->join('P132SFHP.INVTRAN','P132SFHP.ARMAST.CONTNO','=','P132SFHP.INVTRAN.CONTNO')
            ->join('P132SFHP.VIEW_CUSTMAIL','P132SFHP.ARMAST.CUSCOD','=','P132SFHP.VIEW_CUSTMAIL.CUSCOD')
            ->where('P132SFHP.ARMAST.CONTNO','=', $SetStrConn)
            ->first();
          if($data==NULL){
            $data = DB::connection('ibmi2')
            ->table('PSFHP.HARMAST')
            ->join('PSFHP.HINVTRAN','PSFHP.HARMAST.CONTNO','=','PSFHP.HINVTRAN.CONTNO')
            ->join('PSFHP.VIEW_CUSTMAIL','PSFHP.HARMAST.CUSCOD','=','PSFHP.VIEW_CUSTMAIL.CUSCOD')
            ->where('PSFHP.HARMAST.CONTNO','=', $SetStrConn)
            ->first();
          }

          $dataGT = DB::connection('ibmi2')
            ->table('PSFHP.VIEW_ARMGAR')
            ->where('PSFHP.VIEW_ARMGAR.CONTNO','=', $SetStrConn)
            ->first();
        }

      //ประเภทลูกหนี้ 
      if($dataAro!=NULL){
          $FlagAsset = true;
        }else{
          $FlagAsset = false;
        }
      if ($request->TypeCus_Flag == 'Y' || $request->TypeCus_Flag=='W') {        //ลูกหนี้เตรียมฟ้อง
        $SetFalg = 2;
        $FlagCompro = false;
      }elseif ($request->TypeCus_Flag == 'C') {   //ขายฝาก
        $SetFalg = 2;
        $FlagCompro = false;
      }

      if ($request->type == 1 or $request->type == 2 or $request->type == 3) {
        if (@$dataGT != Null) {
          $SetGTAddress = (iconv('TIS-620', 'utf-8', str_replace(" ","",$dataGT->ADDRES))." ต.".iconv('TIS-620', 'utf-8', str_replace(" ","",$dataGT->TUMB))." อ.".iconv('TIS-620', 'utf-8', str_replace(" ","",$dataGT->AUMPDES))." จ.".iconv('TIS-620', 'utf-8', str_replace(" ","",$dataGT->PROVDES))."  ".iconv('TIS-620', 'utf-8', str_replace(" ","",$dataGT->ZIP)));
        }
       
        $dataLegis = new Legislation([
          'TypeDB_Legis' => @$SetTypeDB,
          'Date_legis' => date('Y-m-d'),
          'Contract_legis' => str_replace(" ","",$data->CONTNO),
          'TypeCon_legis' => @$SetTypeConn,
          'DateCon_legis' => $data->SDATE,
          'Name_legis' => (iconv('TIS-620', 'utf-8', str_replace(" ","",$data->SNAM)." ".str_replace(" ","",$data->NAME1)."  ".str_replace(" ","",$data->NAME2))),
          'Idcard_legis' => (str_replace(" ","",$data->IDNO)),
          'Address_legis' => (iconv('TIS-620', 'utf-8', str_replace(" ","",$data->ADDRES))." ต.".iconv('TIS-620', 'utf-8', str_replace(" ","",$data->TUMB))." อ.".iconv('TIS-620', 'utf-8', str_replace(" ","",$data->AUMPDES))." จ.".iconv('TIS-620', 'utf-8', str_replace(" ","",$data->PROVDES))."  ".iconv('TIS-620', 'utf-8', str_replace(" ","",$data->ZIP))),
          'BrandCar_legis' => (iconv('Tis-620','utf-8',str_replace(" ","",$data->TYPE))),
          'register_legis' => (iconv('Tis-620','utf-8',str_replace(" ","",$data->REGNO))),
          'YearCar_legis' => $data->MANUYR,
          'Category_legis' => (iconv('Tis-620','utf-8',str_replace(" ","",$data->BAAB))),
          'DateDue_legis' => $data->FDATE,
          'Pay_legis' => (@$data->STDPRC != NULL ?@$data->STDPRC : NULL),                       //ยอดเงินต้น
          'TopPrice_legis' => (@$data->TOTPRC != NULL ?@$data->TOTPRC : NULL),                  //ยอดทั้งสัญญา
          'DateVAT_legis' => (@$data->DTSTOPV != NULL ? $data->DTSTOPV : NULL),
          'NameGT_legis' => (@$dataGT != NULL ? (iconv('Tis-620','utf-8',$dataGT->NAME)) : NULL),
          'IdcardGT_legis' => (@$dataGT != NULL ? (iconv('Tis-620','utf-8',$dataGT->IDNO)) : NULL),
          'AddressGT_legis' => @$SetGTAddress,
          'Realty_legis' => (@$dataAro != NULL ? 'มีทรัพย์' : 'ไม่มีทรัพย์'),
          'Mile_legis' => $data->MILERT,
          'Period_legis' => $data->TOT_UPAY,
          'Countperiod_legis' => $data->T_NOPAY,
          'Interest_legis' => $data->DSCPRC,        //ดอกเบี้ย ต่อปี
          'Beforeperiod_legis' => $data->EXP_FRM,
          'Beforemoey_legis' => $data->SMPAY,
          'Remainperiod_legis' => $data->EXP_TO,
          'Staleperiod_legis' => $data->EXP_PRD,    //ค้าง
          'Realperiod_legis' => $data->HLDNO,       //ค้างงวดจริง
          'Sumperiod_legis' => $data->BALANC - $data->SMPAY,
          'Flag' => $request->TypeCus_Flag,
          'Phone_legis' => (iconv('Tis-620','utf-8',$data->TELP)),
          'BILLCOLL' => $request->BILLCOLL,
          'Flag_status' => $SetFalg,
          'UserSend1_legis' => auth()->user()->name,
        ]);
        $dataLegis->save();
      }
      elseif ($request->type == 4 or $request->type == 5 or $request->type == 6) {
        if (@$dataGT != Null) {
          $SetGTAddress = (iconv('TIS-620', 'utf-8', str_replace(" ","",$dataGT->ADDRES))." ต.".iconv('TIS-620', 'utf-8', str_replace(" ","",$dataGT->TUMB))." อ.".iconv('TIS-620', 'utf-8', str_replace(" ","",$dataGT->AUMPDES))." จ.".iconv('TIS-620', 'utf-8', str_replace(" ","",$dataGT->PROVDES))."  ".iconv('TIS-620', 'utf-8', str_replace(" ","",$dataGT->ZIP)));
        }

         $dataLegis = new Legislation([
          'TypeDB_Legis' => @$SetTypeDB,
          'Date_legis' => date('Y-m-d'),
          'Contract_legis' => str_replace(" ","",$data->CONTNO),
          'TypeCon_legis' => @$SetTypeConn,
          'DateCon_legis' => $data->SDATE,
          'Name_legis' => (iconv('TIS-620', 'utf-8', str_replace(" ","",$data->SNAM)." ".str_replace(" ","",$data->NAME1)."  ".str_replace(" ","",$data->NAME2))),
          'Idcard_legis' => (str_replace(" ","",$data->IDNO)),
          'Address_legis' => (iconv('TIS-620', 'utf-8', str_replace(" ","",$data->ADDRES))." ต.".iconv('TIS-620', 'utf-8', str_replace(" ","",$data->TUMB))." อ.".iconv('TIS-620', 'utf-8', str_replace(" ","",$data->AUMPDES))." จ.".iconv('TIS-620', 'utf-8', str_replace(" ","",$data->PROVDES))."  ".iconv('TIS-620', 'utf-8', str_replace(" ","",$data->ZIP))),
          'Phone_legis' => (iconv('Tis-620','utf-8',$data->TELP)),
          'NameGT_legis' => (@$dataGT != NULL ? (iconv('Tis-620','utf-8',$dataGT->NAME)) : NULL),
          'IdcardGT_legis' => (@$dataGT != NULL ? (iconv('Tis-620','utf-8',$dataGT->IDNO)) : NULL),
          'AddressGT_legis' => @$SetGTAddress,
          'BrandCar_legis' => (iconv('Tis-620','utf-8',str_replace(" ","",$data->COLOR))),          //ประเภทโฉนด
          'register_legis' => (iconv('Tis-620','utf-8',str_replace(" ","",$data->STRNO))),          //เลขที่โฉนด
          'YearCar_legis' => (iconv('Tis-620','utf-8',str_replace(" ","",$data->MILERT))),          //เลขทีดิน
          'Category_legis' => (iconv('Tis-620','utf-8',str_replace(" ","",$data->KEYNO))),          //หน้าสำรวจ
          'Mile_legis' => (iconv('Tis-620','utf-8',str_replace(" ","",$data->ENGNO))),              //เล่ม-หน้า
          'Realty_legis' => (iconv('Tis-620','utf-8',str_replace(" ","",$data->MANUYR)."/".iconv('TIS-620', 'utf-8', str_replace(" ","",$data->REGNO))."/".iconv('TIS-620', 'utf-8', str_replace(" ","",$data->DORECV)))),            //ที่ดิน
          'Pay_legis' => (@$data->STDPRC != NULL ?@$data->STDPRC : NULL),                       //ยอดเงินต้น
          'TopPrice_legis' => (@$data->TOTPRC != NULL ?@$data->TOTPRC : NULL),                  //ยอดทั้งสัญญา
          'Period_legis' => (@$data->TOT_UPAY != NULL ?@$data->TOT_UPAY : NULL),                //ค่างวด
          'Countperiod_legis' => (@$data->T_NOPAY != NULL ?@$data->T_NOPAY : NULL),             //งวดทั้งสัญญา
          'Interest_legis' => (@$data->DSCPRC != NULL ?@$data->DSCPRC : @$data->EFRATE),        //ดอกเบี้ย ต่อปี
          'Beforeperiod_legis' => (@$data->EXP_FRM != NULL ?@$data->EXP_FRM : NULL),            //ค้างงวดที่
          'Beforemoey_legis' => (@$data->SMPAY != NULL ?@$data->SMPAY : NULL),                  //ยอดชำระแล้ว
          'Remainperiod_legis' => (@$data->EXP_TO != NULL ?@$data->EXP_TO : NULL),              //จากงวดที่
          'Staleperiod_legis' => (@$data->EXP_PRD != NULL ?@$data->EXP_PRD : NULL),             //ถึงงวดที่
          'Realperiod_legis' => (@$data->HLDNO != NULL ?@$data->HLDNO : NULL),                  //จำนวนงวดที่ค้างจริง
          'Sumperiod_legis' => (@$data->TOTPRC != NULL && @$data->SMPAY != NULL ?(@$data->TOTPRC - @$data->SMPAY) : NULL), //เหลือเป็นจำนวนเงิน
          'Flag' => $request->TypeCus_Flag,
          'BILLCOLL' => $request->BILLCOLL,
          'Flag_status' => $SetFalg,
          'UserSend1_legis' => auth()->user()->name,
        ]);
        $dataLegis->save();
      }

      if ($FlagAsset == true) {
        $LegisAsset = new legisasset([
          'legislation_id' => $dataLegis->id,
          'Date_asset' => date('Y-m-d'),
          'propertied_asset' => (@$dataAro != NULL ? 'มีทรัพย์' : 'ไม่มีทรัพย์'),
          'User_asset' =>  auth()->user()->name,
        ]);
        $LegisAsset->save();
      }

      if ($FlagCompro == true) {
        $LegisCompro = new Legiscompromise([
          'legislation_id' => $dataLegis->id,     
          // 'Date_Promise' => date('Y-m-d'),          //วันที่ประนอมหนี้
          // 'User_Promise' =>  auth()->user()->name,  //คนส่งประนอม
        ]);
        $LegisCompro->save();
      }

      return redirect()->back()->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
      if ($request->type == 1 or $request->type == 2 or $request->type == 7) {    //Modal-ยื่นฟ้อง && Modal-ปิดบัญชี
        $datalegis = Legislation::where('id',$id)->with('legisCompromise')->first();

        $type = $request->type;
        return view('legislation.viewModal', compact('datalegis','type'));
      }
      elseif ($request->type == 3) {    //Modal-ตารางชำระ ปิดจบประนอม
        $datalegis = Legislation::where('id',$id)->with('legisCompromise')->first();
        $dataPayment = legispayment::where('legislation_id',$id)->get();

        $type = $request->type;
        return view('legislation.viewModal', compact('datalegis','dataPayment','type'));
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
      $FlagTab = NULL;
      $FlagPage = NULL;
      $dateSearch = NULL;
      $Fdate = NULL;
      $Tdate = NULL;
      $Flag = $arrayName = array('W' =>'ลูกหนี้ก่อนฟ้อง' ,'Y'=>'ลูกหนี้ส่งฟ้อง','C'=>'ลูกหนี้หลุดขายฝาก' );
      $Flag_Status = $arrayName = array('1' =>'ไม่ประนอมหนี้' ,'2'=>'ไม่ประนอมหนี้','3'=>'ประนอมหนี้' );
      if ($request->get('FlagTab')) {
        $FlagTab = $request->get('FlagTab');
        $FlagPage = $request->get('FlagPage');
      }

      if ($request->get('dateSearch')) {
        $dateSearch = $request->dateSearch;

        $SetFdate = substr($dateSearch,0,10);
        $Fdate = date('Y-m-d', strtotime($SetFdate));

        $SetTdate = substr($dateSearch,13,21);
        $Tdate = date('Y-m-d', strtotime($SetTdate));
      }

      if ($request->type == 3) {      //ลูกหนี้เตรียมฟ้อง
        $data = Legislation::find($id);
        $billcoll = TB_Billcoll::get();
        $type = $request->type;
        return view('legislation.editProfiles',compact('data','id','type','billcoll','Flag_Status','Flag'));
      }
      elseif ($request->type == 4) {  //ลูกหนี้ชั้นศาล
        $data = Legislation::find($id);

        if($data->Flag_Class == "สถานะส่งฟ้อง"){
          $FlagTab = 1;
        }elseif($data->Flag_Class == "สถานะส่งสืบพยาน"){
          $FlagTab = 2;
        }elseif($data->Flag_Class == "สถานะส่งคำบังคับ"){
          $FlagTab = 3;
        }elseif($data->Flag_Class == "สถานะส่งตรวจผลหมาย"){
          $FlagTab = 4;
        }elseif($data->Flag_Class == "สถานะส่งตั้งเจ้าพนักงาน"){
          $FlagTab = 5;
        }elseif($data->Flag_Class == "สถานะส่งตรวจผลหมายตั้ง" or $data->Flag_Class == "สถานะคัดหนังสือรับรองคดี" 
                or $data->Flag_Class == "สถานะสืบทรัพย์บังคับคดี" or $data->Flag_Class == "สถานะคัดโฉนด"
                or $data->Flag_Class == "สถานะตั้งยึดทรัพย์" or $data->Flag_Class == "ประกาศขายทอดตลาด"){
          $FlagTab = 6;
        }

        $type = $request->type;
        return view('legisCourt.editCourt',compact('data','id','type','FlagTab','FlagPage','dateSearch','Flag_Status','Flag'));
      }
      elseif ($request->type == 5) {  //ลูกหนี้ชั้นบังคับคดี
        $data = Legislation::find($id);
        $dataPublish = LegisPublishsell::where('legislation_id',$data->id)->where('Flag_publish','=','NOW')->get();
        $data = Legislation::where('id',$id)->with('legiscourt')->first();
        $dataImages = LegisImage::where('legislation_id',$id)
            ->whereIn('type_image',[1,11])
            ->get();
          
          if($data->legiscourt != null){
            $lat = $data->legiscourt->latitude_court;
            $long = $data->legiscourt->longitude_court;
          }
        
        if($data->Flag_Class == "สถานะคัดหนังสือรับรองคดี"){
          $FlagTab = 1;
        }elseif($data->Flag_Class == "สถานะสืบทรัพย์บังคับคดี"){
          $FlagTab = 2;
        }elseif($data->Flag_Class == "สถานะคัดโฉนด"){
          $FlagTab = 3;
        }elseif($data->Flag_Class == "สถานะตั้งยึดทรัพย์"){
          $FlagTab = 4;
        }elseif($data->Flag_Class == "ประกาศขายทอดตลาด" or $data->Flag_Class == "จบงานชั้นบังคับคดี"){
          $FlagTab = 5;
        }

        $type = $request->type;
        return view('legisCourt.editCourtcase',compact('data','dataPublish','dataImages','id','type','FlagTab','FlagPage','dateSearch','lat','long','Flag_Status','Flag'));
      }
      elseif ($request->type == 6) {  //ชั้นสืบทรัพย์ //รูปโฉนด-แผนที่
        if ($request->has('flag')) {
          $Flag = $request->get('flag');
        }
        elseif (session()->has('flag')) {
          $Flag = session('Flag');
        }

        $data = Legislation::where('id',$id)->with('legiscourt')->with('Legisasset')->first();

        $dataImages = LegisImage::where('legislation_id',$id)
            ->whereIn('type_image',[1,11])
            ->get();

            // dd($dataImages);
          
          if($data->legiscourt != null){
            $lat = $data->legiscourt->latitude_court;
            $long = $data->legiscourt->longitude_court;

            $lat2 = $data->legiscourt->latitude_court2;
            $long2 = $data->legiscourt->longitude_court2;
          }

        $type = $request->type;
        $Flag = $request->Flag;
        return view('legisAsset.editAsset',compact('data','id','type','Flag','dataImages','lat','long','lat2','long2','Flag_Status','Flag'));

      }
      elseif ($request->type == 7) {   //เอกสารประกอบ
        $data = Legislation::find($id);
        
        $dataImages = LegisImage::where('legislation_id',$id)
          ->where('type_image', 2)
          ->get();

        if($request->preview == 1){
          $dataFile = LegisImage::where('id',$request->file_id)
            ->where('type_image', 2)
            ->orderBy('legislation_id', 'ASC')
            ->first();

          $contractNo = str_replace("/","",$data->Contract_legis);
          return view('legisDocument.preview',compact('dataFile','contractNo'));
        }

        $Flag = $request->Flag;
        return view('legisDocument.documents',compact('data','id','type','Flag','dataImages'));
      }
      elseif ($request->type == 8) { //ของกลาง
        $data = DB::table('legisexhibits')
                  ->where('id', $id)
                  ->first();
        $type = $request->type;
        return view('LegisExhibit.Popup',compact('data','id','type','FlagTab'));
      }
      elseif ($request->type == 12) { //ขายฝาก
        $data = DB::table('legislands')
                  ->where('Legisland_id', $id)
                  ->first();
        $StrCon = explode("/",$data->ContractNo_legis);
        $SetStr1 = $StrCon[0];
        $SetStr2 = $StrCon[1];
        $SetStrConn = $SetStr1."/".$SetStr2;
        $data1 = DB::connection('ibmi')
                  ->table('LSFHP.ARMAST')
                  ->join('LSFHP.INVTRAN','LSFHP.ARMAST.CONTNO','=','LSFHP.INVTRAN.CONTNO')
                  ->join('LSFHP.VIEW_CUSTMAIL','LSFHP.ARMAST.CUSCOD','=','LSFHP.VIEW_CUSTMAIL.CUSCOD')
                  ->where('LSFHP.ARMAST.CONTNO','=', $SetStrConn)
                  ->first();
        return view('legislation.editmore',compact('data','data1','id','type'));
      }
      elseif ($request->type == 13) { //ลบลูกหนี้ ทั้งหมด
        $item = Legislation::find($id)->Delete();

        if (@$item->legiscourt != NULL) {
          $item2 = Legiscourt::where('legislation_id',$id)->Delete();
        }
        if (@$item->legiscourtCase != NULL) {
          $item3 = Legiscompromise::where('legisPromise_id',$id)->Delete();
        }
        if (@$item->legispayments != NULL) {
          $item4 = legispayment::where('legislation_id', $id)->Delete();
        }
        if (@$item->Legisasset != NULL) {
          $item5 = legisasset::where('legislation_id',$id)->Delete();
        }
        if (@$item->legisTrackings != NULL) {
          $item6 = Legiscourtcase::where('legislation_id',$id)->Delete();
        }

        return redirect()->Route('MasterLegis.index',['type' => 3])->with('success','ลบข้อมูลเรียบร้อย');
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
      $FlagTab = NULL;
      $Fdate = NULL;
      $Tdate = NULL;

      if ($request->get('FlagTab')) {
          $FlagTab = $request->get('FlagTab');
      }
      if ($request->get('Fdate')) {
          $Fdate = $request->get('Fdate');
      }
      if ($request->get('Tdate')) {
          $Tdate = $request->get('Tdate');
      }

      if ($request->type == 1) {      //Modal-ยื่นฟ้อง (หน้าลูกหนี้เตรียมฟ้อง)
        $user = Legislation::find($id);
          $user->Flag_status = 2;
          $user->Flag_Class = "สถานะส่งฟ้อง";
          $user->UserSend2_legis = auth()->user()->name;
          $user->Datesend_Flag = date('Y-m-d');
        $user->update();
        
        // ชั้นศาล
        $Legiscourt = new Legiscourt([
          'legislation_id' => $id,
          'fillingdate_court' => $request->DateCourt,
          'User_court' => $request->Plaintiff,
        ]);
        $Legiscourt->save();

        return redirect()->back()->with('success','ยื่นฟ้องเรียบร้อย');
      }
      elseif ($request->type == 3) {  //เตรียมฟ้อง
        $user = Legislation::find($id);
          $user->Phone_legis = $request->get('phone');
          $user->Address_legis = $request->get('address');
          $user->TopPrice_legis = str_replace(",","",$request->get('TopPrice_legis'));
          $user->Pay_legis = floatval($request->get('Pay_legis') == NULL ? 0 : str_replace(",","",$request->get('Pay_legis')));
          $user->Interest_legis = str_replace(",","",$request->get('Interest_legis'));
          $user->Period_legis = str_replace(",","",$request->get('Period_legis'));
          $user->Countperiod_legis = str_replace(",","",$request->get('Countperiod_legis'));
          $user->Beforemoey_legis = str_replace(",","",$request->get('Beforemoey_legis'));
          $user->Sumperiod_legis = str_replace(",","",$request->get('Sumperiod_legis'));
          $user->Noteby_legis = $request->get('Noteby_legis');
          $user->Twodue_list = $request->get('Twoduelist');                           //หนังสือ 2 งวด
          $user->AcceptTwodue_list = $request->get('AcceptTwoduelist');               //ใบตอบรับหนังสือ 2 งวด
          $user->Terminatebuyer_list = $request->get('Terminatebuyerlist');           //สัญญาบอกเลิกผู้ซื้อ - ผู้ค้ำ
          $user->Acceptbuyerandsup_list = $request->get('Acceptbuyerandsuplist');     //ใบตอบรับผู้ซื้อ - ผู้ค้ำ
          $user->Notice_list = $request->get('Noticelist');                           //หนังสือโนติสผู้ซื้อ - ผู้ค้ำ
          $user->AcceptTwoNotice_list = $request->get('AcceptTwoNoticelist');         //ใบตอบรับโนติสผู้ซื้อ - ผู้ค้ำ
          $user->dateStopRev = $request->get('dateStopRev');         //หยุดรับรู้รายได้
          $user->dateCutOff = $request->get('dateCutOff');    //ตัดหนี้ 0
          $user->BILLCOLL = $request->get('BILLCOLL');         

          if ($request->get('TypeCus_Flag') == 'C') {
            $user->Flag = $request->get('TypeCus_Flag');
            $user->Flag_status = 3;
          }elseif($request->get('TypeCus_Flag') == 'W' &&  $user->legisCompromise !=NULL ){
            $user->Flag = $request->get('TypeCus_Flag');
            $user->Flag_status = 3;
          }else {
            if ($user->Flag_Class != NULL) {
              $user->Flag = $request->get('TypeCus_Flag');
              $user->Flag_status = 2;
            }else {
              $user->Flag = $request->get('TypeCus_Flag');
              $user->Flag_status = 2;
            }
          }
        $user->update();

        return redirect()->back()->with('success','บันทึกข้อมูลเรียบร้อย');
      }
      elseif ($request->type == 4) { //ชั้นศาล(หน้าลูกหนี้ชั้นศาล)
        $Legiscourt = Legiscourt::where('legislation_id',$id)->first();
          $Legiscourt->fillingdate_court = $request->get('fillingdatecourt');
          $Legiscourt->law_court = $request->get('lawcourt');                  
          $Legiscourt->bnumber_court = $request->get('bnumbercourt');
          $Legiscourt->rnumber_court = $request->get('rnumbercourt');
          $Legiscourt->capital_court = floatval($request->get('capitalcourt') == NULL ? 0 : str_replace (",","",$request->get('capitalcourt')));
          $Legiscourt->indictment_court = floatval($request->get('indictmentcourt') == NULL ? 0 : str_replace (",","",$request->get('indictmentcourt')));
          $Legiscourt->pricelawyer_court = floatval($request->get('pricelawyercourt') == NULL ? 0 : str_replace (",","",$request->get('pricelawyercourt')));
          $Legiscourt->adjudicate_price = floatval($request->get('adjudicate_price') == NULL ? 0 :str_replace (",","",$request->get('adjudicate_price')));
          $Legiscourt->examiday_court = $request->get('examidaycourt');
          $Legiscourt->fuzzy_court = $request->get('fuzzycourt');
          $Legiscourt->examinote_court = $request->get('examinotecourt');
          $Legiscourt->orderday_court = $request->get('orderdaycourt');
          $Legiscourt->ordersend_court = $request->get('ordersendcourt');
          $Legiscourt->checkday_court = $request->get('checkdaycourt');
          $Legiscourt->checksend_court = $request->get('checksendcourt');
          $Legiscourt->buyer_court = $request->get('buyercourt');
          $Legiscourt->support_court = $request->get('supportcourt');
          $Legiscourt->support1_court = $request->get('support1court');
          $Legiscourt->note_court = $request->get('notecourt');
          $Legiscourt->social_flag = $request->get('socialflag');
          $Legiscourt->setoffice_court = $request->get('setofficecourt');
          $Legiscourt->sendoffice_court = $request->get('sendofficecourt');
          $Legiscourt->checkresults_court = $request->get('checkresultscourt');
          $Legiscourt->sendcheckresults_court = $request->get('sendcheckresultscourt');
          $Legiscourt->received_court = $request->get('radio-receivedflag');
          $Legiscourt->telresults_court = $request->get('telresultscourt');
          $Legiscourt->dayresults_court = $request->get('dayresultscourt');
          $Legiscourt->SueNote_court = $request->get('suenotecourt');
          $Legiscourt->Consent_court = $request->get('Consent');
        $Legiscourt->update();

        if ($request->FlagClass != NULL) {
          if ($request->Consent != NULL and $request->FlagClass == 'สถานะส่งสืบพยาน') {
            $SetFlagClass = 'สถานะส่งตั้งเจ้าพนักงาน';
          }else {
            $SetFlagClass = $request->FlagClass;
          }
          $Legislation = Legislation::find($id);
            $Legislation->Flag_Class = $SetFlagClass;
          $Legislation->update();

          if ($request->checkresultscourt != NULL) {
            if ($request->sendcheckresultscourt >= $request->checkresultscourt) {
              $SetDateCourtCase = $request->sendcheckresultscourt;
            }else {
              $SetDateCourtCase = $request->checkresultscourt;
            }
            if ($SetFlagClass == 'สถานะคัดหนังสือรับรองคดี' and $Legislation->legiscourtCase == NULL) {
              $Legiscourtcase = new Legiscourtcase([
                'legislation_id' => $id,
                'datepreparedoc_case' => date('Y-m-d', strtotime($SetDateCourtCase. '+45 days')),
              ]);
                $Legiscourtcase->save();
            }
            elseif ($SetFlagClass == 'สถานะคัดหนังสือรับรองคดี' and $Legislation->legiscourtCase != NULL) {
              $Legiscourtcase = Legiscourtcase::where('legislation_id',$id)->first();
                $Legiscourtcase->datepreparedoc_case = date('Y-m-d', strtotime($SetDateCourtCase. '+45 days'));
              $Legiscourtcase->update();
            }
          }
        }

        return redirect()->back()->with('success','บันทึกเรียบร้อย');
      }
      elseif ($request->type == 5) { //ชั้นบังคับคดี
        $Legiscourtcase = Legiscourtcase::where('legislation_id',$id)->first();
          $Legiscourtcase->dateCertificate_case = $request->get('dateCertificate'); //วันที่คัดหนังสือรับรองคดีที่สุด
          $Legiscourtcase->datePredict_case = $request->get('Date_predict'); //วันที่ทำหนังสือประเมิณ
          $Legiscourtcase->pricePredict_case = $request->get('Price_predict'); //ราคาประเมิณ
          $Legiscourtcase->datepreparedoc_case = $request->get('datepreparedoc');
          // $Legiscourtcase->datesetsequester_case = $request->get('DateSequester');
          $Legiscourtcase->datePublicsell_case = $request->get('datePublicsell');
          $Legiscourtcase->dateSequester_case = $request->get('dateSequester');
          $Legiscourtcase->Status_case = $request->get('StatusCase');
          $Legiscourtcase->resultsequester_case = $request->get('ResultSequester');
          $Legiscourtcase->paidsequester_case = str_replace (",","",$request->get('Paidseguester'));
          $Legiscourtcase->datenextsequester_case = $request->get('DatenextSequester');
          $Legiscourtcase->resultsell_case = $request->get('ResultSell');
          $Legiscourtcase->datesoldout_case = $request->get('Datesoldout');
          $Legiscourtcase->amountsequester_case = str_replace (",","",$request->get('Amountsequester'));
          $Legiscourtcase->NumAmount_case = $request->get('CountSeliing');
          $Legiscourtcase->noteprepare_case = $request->get('noteprepare');
        $Legiscourtcase->update();

        if ($request->FlagClass != NULL) {
          $user = Legislation::find($id); //update status
            $user->Flag_Class = $request->FlagClass;
            if ($request->StatusCase != NULL) {
              $user->Flag_Class = 'จบงานชั้นบังคับคดี';
              $user->Status_legis = 'ปิดจบถอนบังคับคดี';
              $user->UserStatus_legis = auth()->user()->name;
              $user->DateStatus_legis = date('Y-m-d');
            }
          $user->update();
        }

        $Legiscourt = Legiscourt::where('legislation_id',$id)->first();
          $Legiscourt->latitude_court = $request->get('latitude');
          $Legiscourt->longitude_court = $request->get('longitude');
        $Legiscourt->update();

        if ($request->hasFile('file_image')) {
          $image_array = $request->file('file_image');
          $contractNo = str_replace("/","",$request->contract);
          $array_len = count($image_array);
          // dd($array_len);
          for ($i=0; $i < $array_len; $i++) {
            $image_size = $image_array[$i]->getClientSize();
            $image_lastname = $image_array[$i]->getClientOriginalExtension();
            $image_new_name = str_random(10).time(). '.' .$image_array[$i]->getClientOriginalExtension();

            $destination_path = public_path().'/legislation/'.$contractNo;
            $image_array[$i]->move($destination_path,$image_new_name);

            $Uploaddb = new LegisImage([
              'legislation_id' => $id,
              'name_image' => $image_new_name,
              'size_image' => $image_size,
              'type_image' => '1', //ข้อมูลโฉนดที่ 1
              'useradd_image' => $request->get('useradd'),
            ]);
            // dd($Uploaddb);
            $Uploaddb ->save();
          }
        }

        $data = DB::table('legisassets')
                  ->where('legislation_id', $id)->latest('id')->first();
       // dd(($data == Null || (@$data->sendsequester_asset=='สืบทรัพย์ไม่เจอ' && @$data->sendsequester_asset != NULL)),@$data->sendsequester_asset);
        if ($data == Null || (@$data->sendsequester_asset=='สืบทรัพย์ไม่เจอ'&& @$data->sendsequester_asset != NULL)) {
          $NewDate_asset =  date('Y-m-d',strtotime("+6 month", strtotime($request->get('sequesterasset')))); 	

          //dd($NewDate_asset);
            $LegisAsset = new legisasset([
              'legislation_id' => $id,
              'Date_asset' => $request->get('Dateasset'),
              'Status_asset' => $request->get('statusasset'),
              'propertied_asset' => $request->get('radio_propertied'),
              'sequester_asset' =>  $request->get('sequesterasset'),
              'sendsequester_asset' => '',
              'Dateresult_asset' => Null,
              'NewpursueDate_asset' =>  $NewDate_asset,
              'Notepursue_asset' =>  $request->get('Notepursueasset'),
              'User_asset' =>  auth()->user()->name,
              'DateTakephoto_asset' =>  $request->get('Date_Takephoto'),
              'DateGetphoto_asset' =>  $request->get('Date_Getphoto'),
            ]);
            $LegisAsset->save();
        }
        else 
        {
          if ($request->get('sendsequesterasset') == "สืบทรัพย์เจอ" or $request->get('sendsequesterasset') == "หมดอายุความคดี" or $request->get('sendsequesterasset') == "จบงานสืบทรัพย์") {
            $Dateresult = date('Y-m-d');
          }else {
            $Dateresult = Null;
            if ($request->get('radio_propertied') == "Y") {
              $Dateresult = date('Y-m-d');
            }else {
              $Dateresult = Null;
            }
          }

          $LegisAsset = legisasset::where('legislation_id',$id)->latest('id')->first();
            $NewDate_asset =  date('Y-m-d',strtotime("+6 month", strtotime($request->get('sequesterasset')))); 	
            $LegisAsset->Date_asset = $request->get('Dateasset');
            $LegisAsset->Status_asset = $request->get('statusasset');
            $LegisAsset->propertied_asset = $request->get('radio_propertied');
            $LegisAsset->sequester_asset = $request->get('sequesterasset');
            $LegisAsset->sendsequester_asset = $request->get('sendsequesterasset');
            $LegisAsset->Dateresult_asset = $Dateresult;
            $LegisAsset->NewpursueDate_asset =  $NewDate_asset;
            $LegisAsset->Notepursue_asset =  $request->get('Notepursueasset');
            $LegisAsset->DateTakephoto_asset =  $request->get('Date_Takephoto');
            $LegisAsset->DateGetphoto_asset =  $request->get('Date_Getphoto');
          $LegisAsset->update();
        }

        return redirect()->back()->with('success','บันทึกเรียบร้อย');
      }
      elseif ($request->type == 8) { //สืบทรัพย์
        if ($request->has('flag')) {
          $Flag = $request->get('flag');
        }
        elseif (session()->has('flag')) {
            $Flag = session('Flag');
        }

        $data = DB::table('legisassets')
                  ->where('legislation_id', $id)->first();

        $SetPriceasset = str_replace (",","",$request->get('Priceasset'));

        if ($data == Null) {
            $LegisAsset = new legisasset([
              'legislation_id' => $id,
              'Date_asset' => $request->get('Dateasset'),
              'Status_asset' => $request->get('statusasset'),
              'Price_asset' => $SetPriceasset,
              'propertied_asset' => $request->get('radio_propertied'),
              'sequester_asset' =>  $request->get('sequesterasset'),
              'sendsequester_asset' => $request->get('sendsequesterasset'),
              'Dateresult_asset' => Null,
              'NewpursueDate_asset' => $request->get('NewpursueDateasset'),
              'Notepursue_asset' =>  $request->get('Notepursueasset'),
              'User_asset' =>  auth()->user()->name,
              'DateTakephoto_asset' =>  $request->get('Date_Takephoto'),
              'DateGetphoto_asset' =>  $request->get('Date_Getphoto'),
            ]);
            $LegisAsset->save();
        }
        else 
        {
          if ($request->get('sendsequesterasset') == "สืบทรัพย์เจอ" or $request->get('sendsequesterasset') == "หมดอายุความคดี" or $request->get('sendsequesterasset') == "จบงานสืบทรัพย์") {
            $Dateresult = date('Y-m-d');
          }else {
            $Dateresult = Null;
            if ($request->get('radio_propertied') == "Y") {
              $Dateresult = date('Y-m-d');
            }else {
              $Dateresult = Null;
            }
          }
          // dd($request->get('NewpursueDateasset'));

          $LegisAsset = legisasset::where('legislation_id',$id)->first();
            $LegisAsset->Date_asset = $request->get('Dateasset');
            $LegisAsset->Status_asset = $request->get('statusasset');
            $LegisAsset->Price_asset = $SetPriceasset;
            $LegisAsset->propertied_asset = $request->get('radio_propertied');
            $LegisAsset->sequester_asset = $request->get('sequesterasset');
            $LegisAsset->sendsequester_asset = $request->get('sendsequesterasset');
            $LegisAsset->Dateresult_asset = $Dateresult;
            $LegisAsset->NewpursueDate_asset = $request->get('NewpursueDateasset');
            $LegisAsset->Notepursue_asset =  $request->get('Notepursueasset');
            $LegisAsset->DateTakephoto_asset =  $request->get('Date_Takephoto');
            $LegisAsset->DateGetphoto_asset =  $request->get('Date_Getphoto');
          $LegisAsset->update();
        }

        $Flag = $request->get('flag');

        return redirect()->back()->with(['Flag' => $Flag,'success' => 'อัพเดตข้อมูลเรียบร้อย']);
        
      }
      elseif ($request->type == 9){ //ของกลาง
          $Dateresult = NULL;
          if($request->get('TypeExhibit') == 'ของกลาง'){
            $Dateresult = $request->get('DategetResult1');
          }
          if($request->get('TypeExhibit') == 'ยึดตามมาตราการ(ปปส.)'){
            $Dateresult = $request->get('DategetResult2');
          }
          $LegisExhibit = Legisexhibit::where('id',$id)->first();
            $LegisExhibit->Contract_legis = $request->get('ContractNo');
            $LegisExhibit->Dateaccept_legis = $request->get('DateExhibit');
            $LegisExhibit->Name_legis =  $request->get('NameContract');
            $LegisExhibit->Policestation_legis =  $request->get('PoliceStation');
            $LegisExhibit->Suspect_legis =  $request->get('NameSuspect');
            $LegisExhibit->Plaint_legis =  $request->get('PlaintExhibit');
            $LegisExhibit->Inquiryofficial_legis =  $request->get('InquiryOfficial');
            $LegisExhibit->Inquiryofficialtel_legis =  $request->get('InquiryOfficialtel');
            $LegisExhibit->Terminate_legis =  $request->get('TerminateExhibit');
            $LegisExhibit->DateLawyersend_legis =  $request->get('DateLawyersend');
            $LegisExhibit->Typeexhibit_legis =  $request->get('TypeExhibit');
            $LegisExhibit->Currentstatus_legis =  $request->get('Currentstatus');
            $LegisExhibit->Nextstatus_legis =  $request->get('Nextstatus');
            $LegisExhibit->Noteexhibit_legis =  $request->get('NoteExhibit');
            $LegisExhibit->Dategiveword_legis =  $request->get('DateGiveword');
            $LegisExhibit->Typegiveword_legis =  $request->get('TypeGiveword');
            $LegisExhibit->Datepreparedoc_legis =  $request->get('DatePreparedoc');
            $LegisExhibit->Dateinvestigate_legis =  $request->get('DateInvestigate');
            $LegisExhibit->Datecheckexhibit_legis =  $request->get('DateCheckexhibit');
            $LegisExhibit->Datesendword_legis =  $request->get('DateSendword');
            $LegisExhibit->Resultexhibit1_legis =  $request->get('ResultExhibit1');
            $LegisExhibit->Processexhibit1_legis =  $request->get('ProcessExhibit1');
            $LegisExhibit->Datesenddetail_legis =  $request->get('DateSenddetail');
            $LegisExhibit->Resultexhibit2_legis =  $request->get('ResultExhibit2');
            $LegisExhibit->Processexhibit2_legis =  $request->get('ProcessExhibit2');
            $LegisExhibit->Dategetresult_legis =  $Dateresult;
          $LegisExhibit->update();
          // return redirect()->back()->with('success','อัพเดทข้อมูลเรียบร้อย');
          return redirect()->back()->with(['FlagTab' => $FlagTab,'success' => 'อัพเดตข้อมูลเรียบร้อย']);
      }
      elseif ($request->type == 11) { //รูปโฉนดและแผนที่ //เอกสารประกอบลูกหนี้
        
        if ($request->has('flag')) {
          $Flag = $request->get('flag');
        }
        elseif (session()->has('flag')) {
            $Flag = session('Flag');
        }

        if ($request->hasFile('file_image')) {
          $image_array = $request->file('file_image');
          $contractNo = str_replace("/","",$request->contract);
          $array_len = count($image_array);
          // dd($array_len);
          for ($i=0; $i < $array_len; $i++) {
            $image_size = $image_array[$i]->getClientSize();
            // $image_lastname = $image_array[$i]->getClientOriginalExtension();
            $image_new_name = $image_array[$i]->getClientOriginalName();

            $destination_path = public_path().'/legislation/'.$contractNo;
            $image_array[$i]->move($destination_path,$image_new_name);

            $Uploaddb = new LegisImage([
              'legislation_id' => $id,
              'name_image' => $image_new_name,
              'size_image' => $image_size,
              'type_image' => '1', //ข้อมูลโฉนดที่ 1
              'useradd_image' => $request->get('useradd'),
            ]);
            // dd($Uploaddb);
            $Uploaddb ->save();
          }
        }
        if ($request->hasFile('file_image2')) {
          $image_array = $request->file('file_image2');
          $contractNo = str_replace("/","",$request->contract);
          $array_len = count($image_array);
          // dd($array_len);
          for ($i=0; $i < $array_len; $i++) {
            $image_size = $image_array[$i]->getClientSize();
            // $image_lastname = $image_array[$i]->getClientOriginalExtension();
            $image_new_name = $image_array[$i]->getClientOriginalName();

            $destination_path = public_path().'/legislation/'.$contractNo;
            $image_array[$i]->move($destination_path,$image_new_name);

            $Uploaddb = new LegisImage([
              'legislation_id' => $id,
              'name_image' => $image_new_name,
              'size_image' => $image_size,
              'type_image' => '11', //ข้อมูลโฉนดที่ 2
              'useradd_image' => $request->get('useradd'),
            ]);
            // dd($Uploaddb);
            $Uploaddb ->save();
          }
        }
        if ($request->hasFile('filePDF')) {
          $image_array = $request->file('filePDF');
          $contractNo = str_replace("/","",$request->contract);
          $array_len = count($image_array);
          // dd($array_len);
          for ($i=0; $i < $array_len; $i++) {
            $image_size = $image_array[$i]->getClientSize();
            $image_new_name = $image_array[$i]->getClientOriginalName();

            $destination_path = public_path().'/legislation/'.$contractNo;
            $image_array[$i]->move($destination_path,$image_new_name);

            $Uploaddb = new LegisImage([
              'legislation_id' => $id,
              'name_image' => $image_new_name,
              'size_image' => $image_size,
              'type_image' => '2', //ข้อมูลเอกสารทั่วไป
              'useradd_image' => $request->get('useradd'),
            ]);
            // dd($Uploaddb);
            $Uploaddb ->save();
          }
        }
        $type = $request->type;
        $Flag = $request->flag;

        return redirect()->back()->with(['Flag' => $Flag,'success' => 'อัพเดตข้อมูลเรียบร้อย']);
      }
      elseif ($request->type == 12) {  //ขายฝาก
        $LegisLand = Legisland::where('Legisland_id',$id)->first();
          $LegisLand->Beforemoney_legis = str_replace(",","",$request->get('Beforemoneylegis'));
          $LegisLand->Sumperiod_legis = str_replace(",","",$request->get('Sumperiodlegis'));
          $LegisLand->Realperiod_legis =  $request->get('Realperiodlegis');
          $LegisLand->Datenotice_legis =  $request->get('DateNotice');
          $LegisLand->Dategetnotice_legis =  $request->get('DateGetNotice');
          $LegisLand->Datepetition_legis =  $request->get('DatePetition');
          $LegisLand->Dateinvestigate_legis =  $request->get('DateInvestigate');
          $LegisLand->Dateadjudicate_legis =  $request->get('DateAdjudicate');
          $LegisLand->Dateeviction_legis =  $request->get('DateEviction');
          $LegisLand->Datepost_legis =  $request->get('DatePost');
          $LegisLand->Datecheckasset_legis =  $request->get('DateCheckAsset');
          $LegisLand->Resultcheck_legis =  $request->get('ResultCheck');
          $LegisLand->Datearrest_legis =  $request->get('DateArrest');
          $LegisLand->Datestaffarrest_legis =  $request->get('DateStaffArrest');
          $LegisLand->Noteland_legis =  $request->get('NoteLand');
          $LegisLand->Statusland_legis =  $request->get('Statuslandlegis');
          $LegisLand->Datestatusland_legis =  $request->get('DateStatuslandlegis');
        $LegisLand->update();

        return redirect()->back()->with('success','อัพเดทข้อมูลเรียบร้อย');
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
      if ($request->type == 1) { //ลบลูกหนี้ ทั้งหมด
        $item = Legislation::find($id)->Delete();

        if (@$item->legiscourt != NULL) {
          $item2 = Legiscourt::where('legislation_id',$id)->Delete();
        }
        if (@$item->legiscourtCase != NULL) {
          $item3 = Legiscompromise::where('legisPromise_id',$id)->Delete();
        }
        if (@$item->legispayments != NULL) {
          $item4 = legispayment::where('legislation_id', $id)->Delete();
        }
        if (@$item->Legisasset != NULL) {
          $item5 = legisasset::where('legislation_id',$id)->Delete();
        }
        if (@$item->legisTrackings != NULL) {
          $item6 = Legiscourtcase::where('legislation_id',$id)->Delete();
        }
      }
      elseif ($request->type == 3) { //ลบตาราง ของกลาง Exhibit
        $FlagTab = NULL;
        if ($request->get('FlagTab')) {
            $FlagTab = $request->get('FlagTab');
        }
        $item = Legisexhibit::where('id',$id);
        $item->Delete();
        return redirect()->back()->with(['FlagTab' => $FlagTab,'success' => 'ลบข้อมูลเรียบร้อย']);
      }
      elseif ($request->type == 4) { //ลบตาราง ขายฝาก Legisland
        $item = Legisland::where('legisland_id',$id);
        $item->Delete();
      }
      elseif ($request->type == 5 or $request->type == 6) { //ลบไฟล์อัพโหลดเอกสาร
        $contractNo = str_replace("/","",$request->contract);
        $item1 = LegisImage::where('image_id','=', $request->file_id)->first();
        $itemPath = public_path().'/Legislation/'.$contractNo.'/'.$item1->name_image;
        // dd($itemPath);
        File::delete($itemPath);
        $item1->Delete();
      }
      elseif ($request->type == 7) { //ลบตาราง สารบัญ
        $item = Content::where('Content_id',$id);
        $item->Delete();
      }
      return redirect()->back()->with('success','ลบข้อมูลเรียบร้อย');
    }

    public function deleteImageAll(Request $request, $id)
    {
      $contractNo = str_replace("/","",$request->contract);
      if($request->type == 1){ //ลบรูปข้อมูลโฉนดที่ 1
        $item = LegisImage::where('legislation_id','=',$id)->where('type_image', '=', 1)->get();
        foreach ($item as $key => $value) {
          $itemID = $value->legislation_id;
          $itemPath = public_path().'/Legislation/'.$contractNo.'/'.$value->name_image;
          File::delete($itemPath);
        }
        $deleteItem = LegisImage::where('legislation_id',$itemID)->where('type_image', '=', 1);

      }
      elseif($request->type == 2){ //ลบรูปข้อมูลโฉนดที่ 2
        $item = LegisImage::where('legislation_id','=',$id)->where('type_image', '=', 11)->get();
        foreach ($item as $key => $value) {
          $itemID = $value->legislation_id;
          $itemPath = public_path().'/Legislation/'.$contractNo.'/'.$value->name_image;
          File::delete($itemPath);
        }
        $deleteItem = LegisImage::where('legislation_id',$itemID)->where('type_image', '=', 11);

      }
      elseif($request->type ==3){ //ลบเอกสารทั่วไป
        $deleteItem = LegisImage::where('id','=', $request->file_id)->first();
        $itemPath = public_path().'/Legislation/'.$contractNo.'/'.$deleteItem->name_image;
        File::delete($itemPath);
      }
      $deleteItem->Delete();

      return redirect()->back()->with('success','ลบเรียบร้อยแล้ว');
    }

    public function Report(Request $request)
    {
      if ($request->type == 1) {        //รายงาน ลูกหนี้เตรียมฟ้อง
        $status = 'ลูกหนี้เตรียมฟ้อง';   
        $data = Legislation::where('Flag_Class','=', NULL)
              ->where('Flag', 'Y')              
              ->whereNull('Status_legis')
              ->where('Flag_status', 1)
              ->get();
        Excel::create('รายงานลูกหนี้เตรียมฟ้อง', function ($excel) use($data,$status) {
          $excel->sheet($status, function ($sheet) use($data,$status) {
              $sheet->prependRow(1, array("บริษัท ชูเกียรติลิสซิ่ง จำกัด"));
              $sheet->prependRow(2, array($status));
              $sheet->cells('A3:W3', function($cells) {
                $cells->setBackground('#FFCC00');
              });
              $row = 3;
              $sheet->row($row, array('ลำดับ', 'เลขที่สัญญา', 'ประเภทสัญญา',
              'ชื่อ-สกุล', 'เบอร์ติดต่อ','ยอดเงิน','งวด','วันที่เข้าระบบ',
              'สถานะ','หมายเหตุ'));

           

              foreach ($data as $key => $value) {
                $sheet->row(++$row, array(
                  $key+1,
                  $value->Contract_legis,
                  $value->TypeCon_legis,
                  $value->Name_legis,
                  $value->Phone_legis,
                  number_format($value->TopPrice_legis, 2),
                  '',
                  $value->DateCon_legis,
                  'ลูกหนี้เตรียมฟ้อง',            
                  $value->Note,
                ));
              }
          });
        })->export('xlsx');
      }
      elseif ($request->type == 2) {    //รายงาน ลูกหนี้ Non-Vat
        $data = DB::connection('ibmi')
          ->table('SFHP.ARMAST')
          ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
          ->whereBetween('SFHP.ARMAST.HLDNO',[3.00,8.00])
          ->where('SFHP.ARMAST.LPAYD','<', date('Y-m-d', strtotime('-1 month')))
          ->where('SFHP.ARMAST.CONTNO','not like', '10%')
          ->where('SFHP.ARMAST.CONTNO','not like', '11%')
          ->where('SFHP.ARMAST.CONTNO','not like', '12%')
          ->where('SFHP.ARMAST.CONTNO','not like', '22%')
          ->where('SFHP.ARMAST.DTSTOPV', NULL)
          ->get();

        $SetFdate = date('d-m-Y');
        $SetTdate = date('d-m-Y');

        $status = 'รายงานลูกหนี้ Non-Vat';
        Excel::create('รายงานลูกหนี้ Non-Vat', function ($excel) use($data,$status,$SetFdate,$SetTdate) {
          $excel->sheet($status, function ($sheet) use($data,$status,$SetFdate,$SetTdate) {
              $sheet->prependRow(1, array("บริษัท ชูเกียรติลิสซิ่ง จำกัด"));
              $sheet->prependRow(2, array($status.'  จากวันที่ '.$SetFdate.' ถึงวันที่ '.$SetTdate));
              $sheet->cells('A3:H3', function($cells) {
                $cells->setBackground('#FFCC00');
              });
              $row = 3;
              $sheet->row($row, array('ลำดับ', 'เลขที่สัญญา','ชื่อ-สกุล','วันที่ทำสัญญา','วันที่ชำระล่าสุด','ยอดค้างจริง','ยอดคงเหลือ','สถานะ'));
              foreach ($data as $key => $value) {

                $sheet->row(++$row, array(
                  $key+1,
                  (iconv('TIS-620', 'utf-8', str_replace(" ","",$value->CONTNO))),
                  (iconv('TIS-620', 'utf-8', str_replace(" ","",$value->SNAM)))." ".(iconv('TIS-620', 'utf-8', str_replace(" ","",$value->NAME1)))." ".(iconv('TIS-620', 'utf-8', str_replace(" ","",$value->NAME2))),
                  $value->ISSUDT,
                  $value->LPAYD,
                  $value->HLDNO,
                  number_format($value->BALANC - $value->SMPAY,2),
                  (iconv('TIS-620', 'utf-8', str_replace(" ","",$value->CONTSTAT))),
                ));
              }
          });
        })->export('xlsx');
      }
      elseif ($request->type == 3) {    //รายงาน ลูกหนี้ชั้นศาล
        // $data = Legislation::where('Status_legis', NULL)
        //   ->where('Flag', 'Y')
        //   ->where(function ($query) {
        //     return $query->where('Flag_Class', 'สถานะส่งฟ้อง')
        //     ->orwhere('Flag_Class', 'สถานะส่งสืบพยาน')
        //     ->orwhere('Flag_Class', 'สถานะส่งคำบังคับ')
        //     ->orwhere('Flag_Class', 'สถานะส่งตรวจผลหมาย')
        //     ->orwhere('Flag_Class', 'สถานะส่งตั้งเจ้าพนักงาน')
        //     ->orwhere('Flag_Class', 'สถานะส่งตรวจผลหมายตั้ง');
        //   })
        //   ->get();
        
        // $status = 'ลูกหนี้ชั้นศาล';
        // Excel::create('รายงานลูกหนี้ชั้นศาล', function ($excel) use($data,$status) {
        //   $excel->sheet($status, function ($sheet) use($data,$status) {
        //       $sheet->prependRow(1, array("บริษัท ชูเกียรติลิสซิ่ง จำกัด"));
        //       $sheet->prependRow(2, array($status));
        //       $sheet->cells('A3:F3', function($cells) {
        //         $cells->setBackground('#FFCC00');
        //       });
        //       $row = 3;
        //       $sheet->row($row, array('ลำดับ','เลขที่สัญญา','ชื่อ-สกุล','เบอร์ติดต่อ','ชั้นลูกหนี้','หมายเหตุ'));

        //       foreach ($data as $key => $value) {
        //         $sheet->row(++$row, array(
        //           $key+1,
        //           $value->Contract_legis,
        //           $value->Name_legis,
        //           $value->Phone_legis,
        //           $value->Flag_Class,
        //           $value->Note,
        //         ));
        //       }
        //   });
        // })->export('xlsx');

          $data = Legislation::where('Status_legis','=', NULL)
              ->where('Flag', 'Y')
              ->where(function ($query) {
                    return $query->where('Flag_Class', 'สถานะส่งฟ้อง')
                    ->orwhere('Flag_Class', 'สถานะส่งสืบพยาน')
                    ->orwhere('Flag_Class', 'สถานะส่งคำบังคับ')
                    ->orwhere('Flag_Class', 'สถานะส่งตรวจผลหมาย')
                    ->orwhere('Flag_Class', 'สถานะส่งตั้งเจ้าพนักงาน')
                    ->orwhere('Flag_Class', 'สถานะส่งตรวจผลหมายตั้ง');
                  })
              // ->Wherehas('legiscourt',function ($query) {
              //   return $query->where('fillingdate_court','!=', NULL);
              // })
              ->with('legiscourt')
              ->with('legiscourtCase')
              ->with('legisCompromise')
              ->with('Legisasset')
              ->get();
          $status = 'ลูกหนี้ชั้นศาล';
          // dd($data[0]);

          Excel::create('รายงานลูกหนี้งานกฏหมาย', function ($excel) use($data,$status) {
            $excel->sheet($status, function ($sheet) use($data,$status) {
                //$sheet->prependRow(1, array("บริษัท ชูเกียรติลิสซิ่ง จำกัด"));
                $sheet->prependRow(2, array($status));
                $sheet->cells('A3:Z3', function($cells) {
                  $cells->setBackground('#FFCC00');
                });
                $row = 3;
                $sheet->row($row, array('ลำดับ', 'เลขที่สัญญา', 'ชื่อ-สกุล', 'เบอร์ติดต่อ',
                    'สถานะลูกหนี้','ผู้ส่งฟ้อง', 'ศาล', 'เลขคดีดำ', 'เลขคดีแดง', 'วันที่ฟ้อง', 'ยอดคงเหลือ', 'ยอดตั้งฟ้อง', 'ยอดค่าฟ้อง','ยอดศาลสั่ง',
                    'วันสืบพยาน', 'วันส่งคำบังคับ', 'วันตรวจผลหมาย', 'วันตั้งเจ้าพนักงาน', 'วันตรวจผลหมายตั้ง',
                    'วันที่สืบทรัพย์', 'สถานะทรัพย์', 'สถานะประนอมหนี้', 
                    'วันที่ปิดบัญชี','ยอดปิดบัญชี','ยอดชำระ','ส่วนลด','หมายเหตุ','หยุดรับรู้รายได้','ตัดหนี้0'));
  
                foreach ($data as $key => $value) {
                  //วันสืบพยาน
                  if (@$value->legiscourt->fuzzy_court != NULL) {
                    $Setexamiday = @$value->legiscourt->fuzzy_court;
                  }else {
                    $Setexamiday = @$value->legiscourt->examiday_court;
                  }
                  //วันส่งคำบังคับ
                  if (@$value->legiscourt->ordersend_court != NULL) {
                    $Setordersend = @$value->legiscourt->ordersend_court;
                  }else {
                    $Setordersend = @$value->legiscourt->orderday_court;
                  }
                  //วันตรวจผลหมาย
                  if (@$value->legiscourt->checksend_court != NULL) {
                    $Setchecksend = @$value->legiscourt->checksend_court;
                  }else {
                    $Setchecksend = @$value->legiscourt->checkday_court;
                  }
                  //วันตั้งเจ้าพนักงาน
                  if (@$value->legiscourt->sendoffice_court != NULL) {
                    $Setsendoffice = @$value->legiscourt->sendoffice_court;
                  }else {
                    $Setsendoffice = @$value->legiscourt->setoffice_court;
                  }
                  //วันตรวจผลหมายตั้ง
                  if (@$value->legiscourt->sendcheckresults_court != NULL) {
                    $Setsendcheckresults = @$value->legiscourt->sendcheckresults_court;
                  }else {
                    $Setsendcheckresults = @$value->legiscourt->checkresults_court;
                  }
                  //สถานะลูกหนี้
                  if (@$value->Status_legis != NULL) {
                    $SetStatus = @$value->Status_legis;
                  }else {
                    if ($value->Flag_Class != NULL) {
                      $SetStatus = @$value->Flag_Class;
                    }
                  }
                  //สถานะสืบทรัพย์
                  if (@$value->Legisasset->propertied_asset == "Y") {
                    $SetTextAsset = "มีทรัพย์";
                  }elseif (@$value->Legisasset->propertied_asset == "N") {
                    $SetTextAsset = "ไม่มีทรัพย์";
                  }else {
                    $SetTextAsset = "ไม่มีข้อมูล";
                  }
                  //สถานะประนอมหนี้
                  if (@$value->Legisasset->Date_Promise != NULL) {
                    $SetTextCompro = "ประนอมหนี้";
                  }else {
                    $SetTextCompro = "ไม่มีข้อมูล";
                  }
                  //ยอดตั้งฟ้อง
                  if(@$value->legiscourt->capital_court != NULL and @$value->legiscourt->indictment_court != NULL and @$value->legiscourt->pricelawyer_court != NULL){
                    $SetCourtPrice = @$value->legiscourt->capital_court + @$value->legiscourt->indictment_court + @$value->legiscourt->pricelawyer_court;
                  }else if(@$value->legiscourt->capital_court != NULL and @$value->legiscourt->indictment_court != NULL and @$value->legiscourt->pricelawyer_court == NULL){
                    $SetCourtPrice = @$value->legiscourt->capital_court + @$value->legiscourt->indictment_court;
                  }else if(@$value->legiscourt->capital_court != NULL and @$value->legiscourt->indictment_court == NULL and @$value->legiscourt->pricelawyer_court == NULL){
                    $SetCourtPrice = @$value->legiscourt->capital_court;
                  }else{
                    $SetCourtPrice = 0;
                  }
                  //ยอดค่าฟ้อง
                  if(@$value->legiscourt->indictment_court != NULL){
                    $SetPrice = @$value->legiscourt->indictment_court;
                  }else{
                    $SetPrice = 0;
                  }
                  //ยอดศาลสั่ง
                  if(@$value->legiscourt->adjudicate_price != NULL){
                    $SetPriceAdjud = @$value->legiscourt->adjudicate_price;
                  }else{
                    $SetPriceAdjud = 0;
                  }
                  $sheet->row(++$row, array(
                    $key+1,
                    @$value->Contract_legis,
                    @$value->Name_legis,
                    @$value->Phone_legis,
                    $SetStatus,
                    @$value->legiscourt->User_court,
                    @$value->legiscourt->law_court,
                    @$value->legiscourt->bnumber_court,
                    @$value->legiscourt->rnumber_court,
                    @$value->legiscourt->fillingdate_court,
                    number_format(@$value->Sumperiod_legis, 2),
                    number_format(@$SetCourtPrice, 2),
                    number_format(@$SetPrice, 2),
                    number_format(@$SetPriceAdjud, 2),
                    
                    $Setexamiday,
                    $Setordersend,
                    $Setchecksend,
                    $Setsendoffice,
                    $Setsendcheckresults,
                    @$value->Date_asset,
                    $SetTextAsset,
                    $SetTextCompro,
                    @$value->DateStatus_legis,
                    number_format(@$value->PriceStatus_legis, 2),
                    number_format(@$value->txtStatus_legis, 2),
                    number_format(@$value->Discount_legis, 2),
                    @$value->Note,
                    @$value->dateStopRev,
                    @$value->dateCutOff,
                  ));
                }
            });
          })->export('xlsx');
      }
      elseif ($request->type == 4) {    //รายงาน ลูกหนี้ชั้นบังคับคดี
        $data = Legislation::where('Status_legis', NULL)
        ->where('Flag', 'Y')
        ->where(function ($query) {
          return $query->where('Flag_Class', 'สถานะคัดหนังสือรับรองคดี')
            ->orwhere('Flag_Class', 'สถานะสืบทรัพย์บังคับคดี')
            ->orwhere('Flag_Class', 'สถานะคัดโฉนด')
            ->orwhere('Flag_Class', 'สถานะตั้งยึดทรัพย์')
            ->orwhere('Flag_Class', 'ประกาศขายทอดตลาด');
        })
        ->get();

        $status = 'ลูกหนี้ชั้นบังคับคดี';
        Excel::create('รายงานลูกหนี้ชั้นบังคับคดี', function ($excel) use($data,$status) {
          $excel->sheet($status, function ($sheet) use($data,$status) {
              $sheet->prependRow(1, array("บริษัท ชูเกียรติลิสซิ่ง จำกัด"));
              $sheet->prependRow(2, array($status));
              $sheet->cells('A3:F3', function($cells) {
                $cells->setBackground('#FFCC00');
              });
              $row = 3;
              $sheet->row($row, array('ลำดับ','เลขที่สัญญา','ชื่อ-สกุล','เบอร์ติดต่อ','ชั้นลูกหนี้','หมายเหตุ'));
              foreach ($data as $key => $value) {
                $sheet->row(++$row, array(
                  $key+1,
                  $value->Contract_legis,
                  $value->Name_legis,
                  $value->Phone_legis,
                  $value->Flag_Class,
                  $value->Note,
                ));
              }
          });
        })->export('xlsx');
      }
      elseif ($request->type == 5) {    //รายงาน ลูกหนี้ปิดจบงานฟ้อง
        $data = Legislation::where('Status_legis', '!=',NULL)
              ->where('Flag', 'Y')
              ->where(function ($query) {
              return $query->where('Status_legis', 'ปิดบัญชี')
                  ->orwhere('Status_legis', 'ปิดจบประนอม')
                  ->orwhere('Status_legis', 'ปิดจบรถยึด')
                  ->orwhere('Status_legis', 'ปิดจบถอนบังคับคดี');
              })
              ->get();

        $status = 'ลูกหนี้ปิดจบงานฟ้อง';
        Excel::create('รายงานลูกหนี้ปิดจบงานฟ้อง', function ($excel) use($data,$status) {
          $excel->sheet($status, function ($sheet) use($data,$status) {
              $sheet->prependRow(1, array("บริษัท ชูเกียรติลิสซิ่ง จำกัด"));
              $sheet->prependRow(2, array($status));
              $sheet->cells('A3:Q3', function($cells) {
                $cells->setBackground('#FFCC00');
              });
              $row = 3;
              $sheet->row($row, array('ลำดับ','เลขที่สัญญา','ชื่อ-สกุล','เบอร์ติดต่อ','สถานะลูกหนี้','ผู้ส่งฟ้อง', 'ศาล', 'เลขคดีดำ', 'เลขคดีแดง', 'วันที่ฟ้อง', 'ยอดคงเหลือ', 'ยอดตั้งฟ้อง', 'ยอดค่าฟ้อง','สถานะปิดงาน','ผู้ปิดงาน','วันที่ปิดจบงาน','หมายเหตุ'));
              foreach ($data as $key => $value) {

                //ยอดตั้งฟ้อง
                if(@$value->legiscourt->capital_court != NULL and @$value->legiscourt->indictment_court != NULL and @$value->legiscourt->pricelawyer_court != NULL){
                  $SetCourtPrice = @$value->legiscourt->capital_court + @$value->legiscourt->indictment_court + @$value->legiscourt->pricelawyer_court;
                }else if(@$value->legiscourt->capital_court != NULL and @$value->legiscourt->indictment_court != NULL and @$value->legiscourt->pricelawyer_court == NULL){
                  $SetCourtPrice = @$value->legiscourt->capital_court + @$value->legiscourt->indictment_court;
                }else if(@$value->legiscourt->capital_court != NULL and @$value->legiscourt->indictment_court == NULL and @$value->legiscourt->pricelawyer_court == NULL){
                  $SetCourtPrice = @$value->legiscourt->capital_court;
                }else{
                  $SetCourtPrice = 0;
                }
                //ยอดค่าฟ้อง
                if(@$value->legiscourt->indictment_court != NULL){
                  $SetPrice = @$value->legiscourt->indictment_court;
                }else{
                  $SetPrice = 0;
                }

                if($value->legiscourt->fillingdate_court != NULL){
                    $fillingdate_court = date('d-m-Y', strtotime(@$value->legiscourt->fillingdate_court));
                }else{
                  $fillingdate_court = NULL;
                }

                $sheet->row(++$row, array(
                  $key+1,
                  $value->Contract_legis,
                  $value->Name_legis,
                  $value->Phone_legis,
                  $value->Flag_Class,
                  @$value->legiscourt->User_court,
                  @$value->legiscourt->law_court,
                  @$value->legiscourt->bnumber_court,
                  @$value->legiscourt->rnumber_court,
                  $fillingdate_court,
                  number_format(@$value->Sumperiod_legis, 2),
                  number_format(@$SetCourtPrice, 2),
                  number_format(@$SetPrice, 2),
                  $value->Status_legis,
                  $value->UserStatus_legis,
                  date('d-m-Y', strtotime($value->DateStatus_legis)),
                  $value->Note,
                ));
              }
          });
        })->export('xlsx');
      }
      elseif ($request->type == 7) {    //รายงาน ลูกหนี้ทั้งหมด
        // $data = Legislation::where('Status_legis', NULL)
        //   ->where('Flag', 'Y')
        //   ->where(function ($query) {
        //     return $query->where('Flag_Class', 'สถานะส่งฟ้อง')
        //     ->orwhere('Flag_Class', 'สถานะส่งสืบพยาน')
        //     ->orwhere('Flag_Class', 'สถานะส่งคำบังคับ')
        //     ->orwhere('Flag_Class', 'สถานะส่งตรวจผลหมาย')
        //     ->orwhere('Flag_Class', 'สถานะส่งตั้งเจ้าพนักงาน')
        //     ->orwhere('Flag_Class', 'สถานะส่งตรวจผลหมายตั้ง');
        //   })
        //   ->get();
        
        // $status = 'ลูกหนี้ชั้นศาล';
        // Excel::create('รายงานลูกหนี้ชั้นศาล', function ($excel) use($data,$status) {
        //   $excel->sheet($status, function ($sheet) use($data,$status) {
        //       $sheet->prependRow(1, array("บริษัท ชูเกียรติลิสซิ่ง จำกัด"));
        //       $sheet->prependRow(2, array($status));
        //       $sheet->cells('A3:F3', function($cells) {
        //         $cells->setBackground('#FFCC00');
        //       });
        //       $row = 3;
        //       $sheet->row($row, array('ลำดับ','เลขที่สัญญา','ชื่อ-สกุล','เบอร์ติดต่อ','ชั้นลูกหนี้','หมายเหตุ'));

        //       foreach ($data as $key => $value) {
        //         $sheet->row(++$row, array(
        //           $key+1,
        //           $value->Contract_legis,
        //           $value->Name_legis,
        //           $value->Phone_legis,
        //           $value->Flag_Class,
        //           $value->Note,
        //         ));
        //       }
        //   });
        // })->export('xlsx');

          $data = Legislation::where('Status_legis','=', NULL)
              ->where('Flag', 'Y')
              // ->where(function ($query) {
              //       return $query->where('Flag_Class', 'สถานะส่งฟ้อง')
              //       ->orwhere('Flag_Class', 'สถานะส่งสืบพยาน')
              //       ->orwhere('Flag_Class', 'สถานะส่งคำบังคับ')
              //       ->orwhere('Flag_Class', 'สถานะส่งตรวจผลหมาย')
              //       ->orwhere('Flag_Class', 'สถานะส่งตั้งเจ้าพนักงาน')
              //       ->orwhere('Flag_Class', 'สถานะส่งตรวจผลหมายตั้ง');
              //     })
              // ->Wherehas('legiscourt',function ($query) {
              //   return $query->where('fillingdate_court','!=', NULL);
              // })
              ->with('legiscourt')
              ->with('legiscourtCase')
              ->with('legisCompromise')
              ->with('Legisasset')
              ->get();
          $status = 'ลูกหนี้ชั้นศาล';
          // dd($data[0]);

          Excel::create('รายงานลูกหนี้งานกฏหมาย', function ($excel) use($data,$status) {
            $excel->sheet($status, function ($sheet) use($data,$status) {
                //$sheet->prependRow(1, array("บริษัท ชูเกียรติลิสซิ่ง จำกัด"));
                $sheet->prependRow(2, array($status));
                $sheet->cells('A3:Z3', function($cells) {
                  $cells->setBackground('#FFCC00');
                });
                $row = 3;
                $sheet->row($row, array('ลำดับ', 'เลขที่สัญญา', 'ชื่อ-สกุล', 'เบอร์ติดต่อ',
                    'สถานะลูกหนี้','ผู้ส่งฟ้อง', 'ศาล', 'เลขคดีดำ', 'เลขคดีแดง', 'วันที่ฟ้อง', 'ยอดคงเหลือ', 'ยอดตั้งฟ้อง', 'ยอดค่าฟ้อง','ยอดศาลสั่ง',
                    'วันสืบพยาน', 'วันส่งคำบังคับ', 'วันตรวจผลหมาย', 'วันตั้งเจ้าพนักงาน', 'วันตรวจผลหมายตั้ง',
                    'วันที่สืบทรัพย์', 'สถานะทรัพย์', 'สถานะประนอมหนี้', 
                    'วันที่ปิดบัญชี','ยอดปิดบัญชี','ยอดชำระ','ส่วนลด','หมายเหตุ','หยุดรับรู้รายได้','ตัดหนี้0'));
  
                foreach ($data as $key => $value) {
                  //วันสืบพยาน
                  if (@$value->legiscourt->fuzzy_court != NULL) {
                    $Setexamiday = @$value->legiscourt->fuzzy_court;
                  }else {
                    $Setexamiday = @$value->legiscourt->examiday_court;
                  }
                  //วันส่งคำบังคับ
                  if (@$value->legiscourt->ordersend_court != NULL) {
                    $Setordersend = @$value->legiscourt->ordersend_court;
                  }else {
                    $Setordersend = @$value->legiscourt->orderday_court;
                  }
                  //วันตรวจผลหมาย
                  if (@$value->legiscourt->checksend_court != NULL) {
                    $Setchecksend = @$value->legiscourt->checksend_court;
                  }else {
                    $Setchecksend = @$value->legiscourt->checkday_court;
                  }
                  //วันตั้งเจ้าพนักงาน
                  if (@$value->legiscourt->sendoffice_court != NULL) {
                    $Setsendoffice = @$value->legiscourt->sendoffice_court;
                  }else {
                    $Setsendoffice = @$value->legiscourt->setoffice_court;
                  }
                  //วันตรวจผลหมายตั้ง
                  if (@$value->legiscourt->sendcheckresults_court != NULL) {
                    $Setsendcheckresults = @$value->legiscourt->sendcheckresults_court;
                  }else {
                    $Setsendcheckresults = @$value->legiscourt->checkresults_court;
                  }
                  //สถานะลูกหนี้
                  if (@$value->Status_legis != NULL) {
                    $SetStatus = @$value->Status_legis;
                  }else {
                    if ($value->Flag_Class != NULL) {
                      $SetStatus = @$value->Flag_Class;
                    }
                  }
                  //สถานะสืบทรัพย์
                  if (@$value->Legisasset->propertied_asset == "Y") {
                    $SetTextAsset = "มีทรัพย์";
                  }elseif (@$value->Legisasset->propertied_asset == "N") {
                    $SetTextAsset = "ไม่มีทรัพย์";
                  }else {
                    $SetTextAsset = "ไม่มีข้อมูล";
                  }
                  //สถานะประนอมหนี้
                  if (@$value->Legisasset->Date_Promise != NULL) {
                    $SetTextCompro = "ประนอมหนี้";
                  }else {
                    $SetTextCompro = "ไม่มีข้อมูล";
                  }
                  //ยอดตั้งฟ้อง
                  if(@$value->legiscourt->capital_court != NULL and @$value->legiscourt->indictment_court != NULL and @$value->legiscourt->pricelawyer_court != NULL){
                    $SetCourtPrice = @$value->legiscourt->capital_court + @$value->legiscourt->indictment_court + @$value->legiscourt->pricelawyer_court;
                  }else if(@$value->legiscourt->capital_court != NULL and @$value->legiscourt->indictment_court != NULL and @$value->legiscourt->pricelawyer_court == NULL){
                    $SetCourtPrice = @$value->legiscourt->capital_court + @$value->legiscourt->indictment_court;
                  }else if(@$value->legiscourt->capital_court != NULL and @$value->legiscourt->indictment_court == NULL and @$value->legiscourt->pricelawyer_court == NULL){
                    $SetCourtPrice = @$value->legiscourt->capital_court;
                  }else{
                    $SetCourtPrice = 0;
                  }
                  //ยอดค่าฟ้อง
                  if(@$value->legiscourt->indictment_court != NULL){
                    $SetPrice = @$value->legiscourt->indictment_court;
                  }else{
                    $SetPrice = 0;
                  }
                  //ยอดศาลสั่ง
                  if(@$value->legiscourt->adjudicate_price != NULL){
                    $SetPriceAdjud = @$value->legiscourt->adjudicate_price;
                  }else{
                    $SetPriceAdjud = 0;
                  }
                  $sheet->row(++$row, array(
                    $key+1,
                    @$value->Contract_legis,
                    @$value->Name_legis,
                    @$value->Phone_legis,
                    $SetStatus,
                    @$value->legiscourt->User_court,
                    @$value->legiscourt->law_court,
                    @$value->legiscourt->bnumber_court,
                    @$value->legiscourt->rnumber_court,
                    @$value->legiscourt->fillingdate_court,
                    number_format(@$value->Sumperiod_legis, 2),
                    number_format(@$SetCourtPrice, 2),
                    number_format(@$SetPrice, 2),
                    number_format(@$SetPriceAdjud, 2),
                    
                    $Setexamiday,
                    $Setordersend,
                    $Setchecksend,
                    $Setsendoffice,
                    $Setsendcheckresults,
                    @$value->Date_asset,
                    $SetTextAsset,
                    $SetTextCompro,
                    @$value->DateStatus_legis,
                    number_format(floatval(@$value->PriceStatus_legis), 2),
                    @$value->txtStatus_legis,
                    number_format(floatval(@$value->Discount_legis), 2),
                    @$value->Note,
                    @$value->dateStopRev,
                    @$value->dateCutOff,
                  ));
                }
            });
          })->export('xlsx');
      }
      elseif ($request->type == 8) {    //รายงาน ลูกหนี้ทั้งหมด
        // $data = Legislation::where('Status_legis', NULL)
        //   ->where('Flag', 'Y')
        //   ->where(function ($query) {
        //     return $query->where('Flag_Class', 'สถานะส่งฟ้อง')
        //     ->orwhere('Flag_Class', 'สถานะส่งสืบพยาน')
        //     ->orwhere('Flag_Class', 'สถานะส่งคำบังคับ')
        //     ->orwhere('Flag_Class', 'สถานะส่งตรวจผลหมาย')
        //     ->orwhere('Flag_Class', 'สถานะส่งตั้งเจ้าพนักงาน')
        //     ->orwhere('Flag_Class', 'สถานะส่งตรวจผลหมายตั้ง');
        //   })
        //   ->get();
        
        // $status = 'ลูกหนี้ชั้นศาล';
        // Excel::create('รายงานลูกหนี้ชั้นศาล', function ($excel) use($data,$status) {
        //   $excel->sheet($status, function ($sheet) use($data,$status) {
        //       $sheet->prependRow(1, array("บริษัท ชูเกียรติลิสซิ่ง จำกัด"));
        //       $sheet->prependRow(2, array($status));
        //       $sheet->cells('A3:F3', function($cells) {
        //         $cells->setBackground('#FFCC00');
        //       });
        //       $row = 3;
        //       $sheet->row($row, array('ลำดับ','เลขที่สัญญา','ชื่อ-สกุล','เบอร์ติดต่อ','ชั้นลูกหนี้','หมายเหตุ'));

        //       foreach ($data as $key => $value) {
        //         $sheet->row(++$row, array(
        //           $key+1,
        //           $value->Contract_legis,
        //           $value->Name_legis,
        //           $value->Phone_legis,
        //           $value->Flag_Class,
        //           $value->Note,
        //         ));
        //       }
        //   });
        // })->export('xlsx');

          $data = Legislation::where('Status_legis','=', NULL)
              ->where('Flag', 'C')
              // ->where(function ($query) {
              //       return $query->where('Flag_Class', 'สถานะส่งฟ้อง')
              //       ->orwhere('Flag_Class', 'สถานะส่งสืบพยาน')
              //       ->orwhere('Flag_Class', 'สถานะส่งคำบังคับ')
              //       ->orwhere('Flag_Class', 'สถานะส่งตรวจผลหมาย')
              //       ->orwhere('Flag_Class', 'สถานะส่งตั้งเจ้าพนักงาน')
              //       ->orwhere('Flag_Class', 'สถานะส่งตรวจผลหมายตั้ง');
              //     })
              // ->Wherehas('legiscourt',function ($query) {
              //   return $query->where('fillingdate_court','!=', NULL);
              // })
              ->with('legiscourt')
              ->with('legiscourtCase')
              ->with('legisCompromise')
              ->with('Legisasset')
              ->get();
          $status = 'ลูกหนี้ชั้นศาล';
          // dd($data[0]);

          Excel::create('รายงานลูกหนี้งานกฏหมาย', function ($excel) use($data,$status) {
            $excel->sheet($status, function ($sheet) use($data,$status) {
                //$sheet->prependRow(1, array("บริษัท ชูเกียรติลิสซิ่ง จำกัด"));
                $sheet->prependRow(2, array($status));
                $sheet->cells('A3:Z3', function($cells) {
                  $cells->setBackground('#FFCC00');
                });
                $row = 3;
                $sheet->row($row, array('ลำดับ', 'เลขที่สัญญา', 'ชื่อ-สกุล', 'เบอร์ติดต่อ',
                    'สถานะลูกหนี้','ผู้ส่งฟ้อง', 'ศาล', 'เลขคดีดำ', 'เลขคดีแดง', 'วันที่ฟ้อง', 'ยอดคงเหลือ', 'ยอดตั้งฟ้อง', 'ยอดค่าฟ้อง','ยอดศาลสั่ง',
                    'วันสืบพยาน', 'วันส่งคำบังคับ', 'วันตรวจผลหมาย', 'วันตั้งเจ้าพนักงาน', 'วันตรวจผลหมายตั้ง',
                    'วันที่สืบทรัพย์', 'สถานะทรัพย์', 'สถานะประนอมหนี้', 
                    'วันที่ปิดบัญชี','ยอดปิดบัญชี','ยอดชำระ','ส่วนลด','หมายเหตุ','หยุดรับรู้รายได้','ตัดหนี้0'));
  
                foreach ($data as $key => $value) {
                  //วันสืบพยาน
                  if (@$value->legiscourt->fuzzy_court != NULL) {
                    $Setexamiday = @$value->legiscourt->fuzzy_court;
                  }else {
                    $Setexamiday = @$value->legiscourt->examiday_court;
                  }
                  //วันส่งคำบังคับ
                  if (@$value->legiscourt->ordersend_court != NULL) {
                    $Setordersend = @$value->legiscourt->ordersend_court;
                  }else {
                    $Setordersend = @$value->legiscourt->orderday_court;
                  }
                  //วันตรวจผลหมาย
                  if (@$value->legiscourt->checksend_court != NULL) {
                    $Setchecksend = @$value->legiscourt->checksend_court;
                  }else {
                    $Setchecksend = @$value->legiscourt->checkday_court;
                  }
                  //วันตั้งเจ้าพนักงาน
                  if (@$value->legiscourt->sendoffice_court != NULL) {
                    $Setsendoffice = @$value->legiscourt->sendoffice_court;
                  }else {
                    $Setsendoffice = @$value->legiscourt->setoffice_court;
                  }
                  //วันตรวจผลหมายตั้ง
                  if (@$value->legiscourt->sendcheckresults_court != NULL) {
                    $Setsendcheckresults = @$value->legiscourt->sendcheckresults_court;
                  }else {
                    $Setsendcheckresults = @$value->legiscourt->checkresults_court;
                  }
                  //สถานะลูกหนี้
                  if (@$value->Status_legis != NULL) {
                    $SetStatus = @$value->Status_legis;
                  }else {
                    if ($value->Flag_Class != NULL) {
                      $SetStatus = @$value->Flag_Class;
                    }
                  }
                  //สถานะสืบทรัพย์
                  if (@$value->Legisasset->propertied_asset == "Y") {
                    $SetTextAsset = "มีทรัพย์";
                  }elseif (@$value->Legisasset->propertied_asset == "N") {
                    $SetTextAsset = "ไม่มีทรัพย์";
                  }else {
                    $SetTextAsset = "ไม่มีข้อมูล";
                  }
                  //สถานะประนอมหนี้
                  if (@$value->Legisasset->Date_Promise != NULL) {
                    $SetTextCompro = "ประนอมหนี้";
                  }else {
                    $SetTextCompro = "ไม่มีข้อมูล";
                  }
                  //ยอดตั้งฟ้อง
                  if(@$value->legiscourt->capital_court != NULL and @$value->legiscourt->indictment_court != NULL and @$value->legiscourt->pricelawyer_court != NULL){
                    $SetCourtPrice = @$value->legiscourt->capital_court + @$value->legiscourt->indictment_court + @$value->legiscourt->pricelawyer_court;
                  }else if(@$value->legiscourt->capital_court != NULL and @$value->legiscourt->indictment_court != NULL and @$value->legiscourt->pricelawyer_court == NULL){
                    $SetCourtPrice = @$value->legiscourt->capital_court + @$value->legiscourt->indictment_court;
                  }else if(@$value->legiscourt->capital_court != NULL and @$value->legiscourt->indictment_court == NULL and @$value->legiscourt->pricelawyer_court == NULL){
                    $SetCourtPrice = @$value->legiscourt->capital_court;
                  }else{
                    $SetCourtPrice = 0;
                  }
                  //ยอดค่าฟ้อง
                  if(@$value->legiscourt->indictment_court != NULL){
                    $SetPrice = @$value->legiscourt->indictment_court;
                  }else{
                    $SetPrice = 0;
                  }
                  //ยอดศาลสั่ง
                  if(@$value->legiscourt->adjudicate_price != NULL){
                    $SetPriceAdjud = @$value->legiscourt->adjudicate_price;
                  }else{
                    $SetPriceAdjud = 0;
                  }
                  $sheet->row(++$row, array(
                    $key+1,
                    @$value->Contract_legis,
                    @$value->Name_legis,
                    @$value->Phone_legis,
                    $SetStatus,
                    @$value->legiscourt->User_court,
                    @$value->legiscourt->law_court,
                    @$value->legiscourt->bnumber_court,
                    @$value->legiscourt->rnumber_court,
                    @$value->legiscourt->fillingdate_court,
                    number_format(@$value->Sumperiod_legis, 2),
                    number_format(@$SetCourtPrice, 2),
                    number_format(@$SetPrice, 2),
                    number_format(@$SetPriceAdjud, 2),
                    
                    $Setexamiday,
                    $Setordersend,
                    $Setchecksend,
                    $Setsendoffice,
                    $Setsendcheckresults,
                    @$value->Date_asset,
                    $SetTextAsset,
                    $SetTextCompro,
                    @$value->DateStatus_legis,
                    number_format(floatval(@$value->PriceStatus_legis), 2),
                    @$value->txtStatus_legis,
                    number_format(floatval(@$value->Discount_legis), 2),
                    @$value->Note,
                    @$value->dateStopRev,
                    @$value->dateCutOff,
                  ));
                }
            });
          })->export('xlsx');
      }
      if($request->FlagTab == 6){
        $datefrom = $request->Fdate ;//"2022-01-01";
        $dateto = $request->Tdate;//"2023-02-28";
  

        return view('legisCourt.reportCourt', compact('datefrom','dateto'));
    }

    }

    public function download(Request $request,$file)
    {   
      $contractNo = str_replace("/","",$request->contractNo);
      $destination_path = public_path('legislation');

        return response()->download($destination_path. '/' .$contractNo. '/' .$file);
    }
}

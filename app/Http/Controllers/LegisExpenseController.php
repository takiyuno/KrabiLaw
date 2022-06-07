<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;
use Storage;
use File;
use Carbon\Carbon;
use Excel;
use Helper;

use App\Legislation;
use App\Legisexpense;
use App\Legisexhibit;

class LegisExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $FlagTab = NULL;
        $FlagPage = NULL;
        $dateSearch = NULL;
        $Fdate = NULL;
        $Tdate = NULL;

        if ($request->get('FlagTab')) {
            $FlagTab = $request->get('FlagTab');
            $FlagPage = $request->get('FlagPage');
        }

        if ($request->get('dateSearch') == NULL) {
            $dateSearch = $request->dateSearch;

            $data1 = Legisexpense::where('Type_expense','=','ภายในศาล')
                    ->where('Flag_expense','=','wait')
                    ->get();
            $data2 = Legisexpense::where('Type_expense','=','ค่าพิเศษ')
                    ->where('Flag_expense','=','wait')
                    ->selectRaw('count(id) as Total,Type_expense,Code_expense,Amount_expense,Topic_expense,Note_expense,Receiptno_expense,Flag_expense,Useradd_expense,Date_expense,DateApprove_expense')
                    ->groupBy('Code_expense','Type_expense','Amount_expense','Topic_expense','Note_expense','Receiptno_expense','Flag_expense','Useradd_expense','Date_expense','DateApprove_expense')
                    ->get();
            $data3 = Legisexpense::where('Type_expense','=','เบิกสำรองจ่าย')
                    ->whereIn('Flag_expense',['wait','process'])
                    ->get();

            $data4 = Legisexpense::where('Type_expense','=','ค่าของกลาง')
                    ->where('Flag_expense','=','wait')
                    ->get();
        }
        else
        {
            $dateSearch = $request->dateSearch;

            $SetFdate = substr($dateSearch,0,10);
            $Fdate = date('Y-m-d', strtotime($SetFdate));

            $SetTdate = substr($dateSearch,13,21);
            $Tdate = date('Y-m-d', strtotime($SetTdate));

            $data1 = Legisexpense::whereBetween('Date_expense',[$Fdate,$Tdate])
                    ->where('Type_expense','=','ภายในศาล')
                    ->get();
            $data2 = Legisexpense::whereBetween('Date_expense',[$Fdate,$Tdate])
                    ->where('Type_expense','=','ค่าพิเศษ')
                    ->selectRaw('count(id) as Total,Type_expense,Code_expense,Amount_expense,Topic_expense,Note_expense,Receiptno_expense,Flag_expense,Useradd_expense,Date_expense,DateApprove_expense')
                    ->groupBy('Code_expense','Type_expense','Amount_expense','Topic_expense','Note_expense','Receiptno_expense','Flag_expense','Useradd_expense','Date_expense','DateApprove_expense')
                    ->get();
            $data3 = Legisexpense::whereBetween('Date_expense',[$Fdate,$Tdate])
                    ->where('Type_expense','=','เบิกสำรองจ่าย')
                    ->get();

            $data4 = Legisexpense::whereBetween('Date_expense',[$Fdate,$Tdate])
                    ->where('Type_expense','=','ค่าของกลาง')
                    ->get();
        }

        $Sum1 = 0;
        for ($i=0; $i < count($data1); $i++) { 
            $Sum1 += $data1[$i]->Amount_expense;
        }

        $Sum2 = 0;
        for ($j=0; $j < count($data2); $j++) { 
            $Sum2 += $data2[$j]->Amount_expense * $data2[$j]->Total;
        }

        $Sum3 = 0;
        for ($k=0; $k < count($data3); $k++) { 
            $Sum3 += $data3[$k]->Amount_expense;
        }

        $Sum4 = 0;
        for ($m=0; $m < count($data4); $m++) { 
            $Sum4 += $data4[$m]->Amount_expense;
        }

        $type = $request->type;
        return response()->view('legisExpense.view', compact('dataGroup','data1','data2','data3','data4','Sum1','Sum2','Sum3','Sum4','type','dateSearch','FlagTab'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->get('TypeExpense') == 'ภายในศาล'){
            if($request->get('TopicExpense1') == 'ลูกหนี้ฟ้องเก่า'){
                $Contract_array = $request->get('Contract5');
            }
            else{
                $Contract_array = $request->get('Contract1');
            }
        }
        elseif($request->get('TypeExpense') == 'ค่าพิเศษ'){
            if($request->get('TopicExpense2') == 'ลูกหนี้ฟ้องเก่า'){
                $Contract_array = $request->get('Contract5');
            }
            else{
                $Contract_array = $request->get('Contract2');
            }
        }
        elseif($request->get('TypeExpense') == 'เบิกสำรองจ่าย'){
          $Contract_array = $request->get('Contract3');
        }
        elseif($request->get('TypeExpense') == 'ค่าของกลาง'){
            $Contract_array = $request->get('Contract4');
        }

        // dd(count($Contract_array));
        $dataCode = Legisexpense::select('Code_expense')->orderBy('id','desc')->first();
        $dataReceiptno = Legisexpense::orderBy('Receiptno_expense','desc')->first();

        if($dataCode == NULL){
            $Code = '01';
        }
        else{
            $Code = $dataCode->Code_expense;
        }

        if($dataReceiptno == NULL){
            $Receiptno = 'LAW-'.date('Y').date('m').'0001';
        }
        else{
            $StrNum = substr($dataReceiptno->Receiptno_expense, -4) + 1;
            $num = "1000";
            $SubStr = substr($num.$StrNum, -4);
            $Receiptno = 'LAW-'.date('Y').date('m').$SubStr;
        }

        for ($i=0; $i < count($Contract_array); $i++) {
            $StrCon = explode("|",$Contract_array[$i]);
            $SetID = $StrCon[0];
            $SetContract = $StrCon[1];
            
            if(count($Contract_array) > 1){
                $Setcode = $Code + 1;
                $Amountall = $request->get('AmountExpense') / count($Contract_array);
            }else{
                $Setcode = $Code + ($i+1);
                $Amountall = $request->get('AmountExpense');
            }

            if($request->get('TypeExpense') == 'ภายในศาล'){
                $FlagTab = 1;
                $Topic = $request->get('TopicExpense1');
                $PayAmount = $Amountall;
            }elseif($request->get('TypeExpense') == 'ค่าพิเศษ'){
                $FlagTab = 2;
                $Topic = $request->get('TopicExpense2');
                $PayAmount = $Amountall;
            }elseif($request->get('TypeExpense') == 'เบิกสำรองจ่าย'){
                $FlagTab = 3;
                $Topic = $request->get('TypeExpense');
                $PayAmount = $request->get('EditAmountExpense');
            }elseif($request->get('TypeExpense') == 'ค่าของกลาง'){
                $FlagTab = 4;
                $Topic = $request->get('TypeExpense');
                $PayAmount = $Amountall;
            }

                $Num_id = Legisexpense::orderBy('id','desc')->first();
                if($Num_id == NULL){
                    $id = 1;
                }else{
                    $id = $Num_id->id + 1;
                }

            $LegisExpense = new Legisexpense([
                'id' => $id,
                'legislation_id' => $SetID,
                'Date_expense' => $request->get('DateExpense'),
                'Type_expense' =>  $request->get('TypeExpense'),
                'Topic_expense' =>  $Topic,
                'Amount_expense' =>  $Amountall,
                'Note_expense' =>  $request->get('NoteExpense'),
                'Contract_expense' =>  $SetContract,
                'Code_expense' =>  $Setcode,
                'Flag_expense' =>  'wait',
                'Useradd_expense' =>  $request->get('UseraddExpense'),
                'Receiptno_expense' =>  $Receiptno,
                'PayAmount_expense' =>  $PayAmount,
                'LawyerName_expense' =>  $request->get('LawyerName'),
              ]);
            $LegisExpense->save();
        }

        return redirect()->back()->with(['FlagTab' => $FlagTab,'success' => 'อัพเดตข้อมูลเรียบร้อย']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $FlagTab = NULL;        
        if ($request->has('FlagTab')) {
            $FlagTab = $request->get('FlagTab');
        }
        elseif (session()->has('FlagTab')) {
            $FlagTab = session('FlagTab');
        }

        if($request->type == 1){ //popup เพิ่มค่าใช่จ่าย
            $data = Legislation::where('Status_legis', NULL)
                ->select('id','Contract_legis')
                ->get();

            $dataExhibit = Legisexhibit::select('Legisexhibit_id','Contract_legis')
                ->get();

        }
        elseif($request->type == 2){ //popup รายละเอียดค่าใช่จ่าย
            $data = Legisexpense::where('Code_expense','=',$request->Groupcode)
                ->get();

            $topic = $data[0]->Topic_expense;
            $receoitNo = $data[0]->Receiptno_expense;
        }
        elseif($request->type == 3){ //popup แก้ไขค่าใช่จ่าย
            if($request->Flagtype == 1){
                $data = Legisexpense::where('id',$id)
                    ->where('Type_expense','=','ภายในศาล')
                    ->first();
            }
            elseif($request->Flagtype == 2){
                $data = Legisexpense::where('Code_expense','=',$id)
                    ->where('Type_expense','=','ค่าพิเศษ')
                    ->selectRaw('count(id) as Total,Date_expense,Type_expense,Code_expense,Amount_expense,Topic_expense,Note_expense,LawyerName_expense')
                    ->groupBy('Code_expense','Type_expense','Amount_expense','Topic_expense','Note_expense','Date_expense','LawyerName_expense')
                    ->get();
                    // dd($data);
            }
            elseif($request->Flagtype == 3){
                $data = Legisexpense::where('id',$id)
                    ->where('Type_expense','=','เบิกสำรองจ่าย')
                    ->first();
            }
            elseif($request->Flagtype == 4){
                $data = Legisexpense::where('id',$id)
                    ->where('Type_expense','=','ค่าของกลาง')
                    ->first();
            }
            // dd($data);
        }
        elseif($request->type == 4){ //PDF ใบเสร็จค่าใช้จ่าย
            // dd($request);
            if($request->Flagtype == 1){
                $data = Legisexpense::where('id',$id)
                      ->with('ExpenseTolegislation')
                      ->with('ExpenseTolegiscourt')
                      ->first();
                $type = 1;
                // dd($data);
            }
            elseif($request->Flagtype == 2){
                $data = Legisexpense::where('Code_expense','=',$request->Groupcode)
                      ->with('ExpenseTolegislation')
                      ->with('ExpenseTolegiscourt')
                      ->get();
                $type = 2;
            }
            elseif($request->Flagtype == 3){
                $data = Legisexpense::where('id',$id)
                      ->with('ExpenseTolegislation')
                      ->with('ExpenseTolegiscourt')
                      ->first();
                $type = 3;
            }
            elseif($request->Flagtype == 4){
                $data = Legisexpense::where('id',$id)
                      ->with('ExpenseToExhibit')
                      ->first();
                $type = 4;
            }

            $view = \View::make('LegisExpense.viewPDF' ,compact('data','type'));
            $html = $view->render();

            $pdf = new PDF();
            $pdf::SetTitle('ใบเสร็จค่าใช้จ่าย');
            $pdf::AddPage('P', 'A5');
            $pdf::SetMargins(16, 5, 5, 5);
            $pdf::SetFont('thsarabunpsk', '', 14, '', true);
            $pdf::SetAutoPageBreak(TRUE, 5);
            $pdf::WriteHTML($html,true,false,true,false,'');
            $pdf::Output('Expenses.pdf');
        }
        
        $type = $request->type;
        $Flagtype = $request->Flagtype;
        $FlagTab = $request->FlagTab;

        return view('LegisExpense.viewModal',compact('data','type','Flagtype','FlagTab','topic','receoitNo','dataExhibit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        // dd($request);
        $data = Legislation::find($id);
        $dataExpense = Legisexpense::where('legislation_id',$id)->get();

        $Sum = 0;
        for ($i=0; $i < count($dataExpense); $i++) { 
            $Sum += $dataExpense[$i]->Amount_expense;
        }

        $type = $request->type;
        return view('LegisExpense.editExpense',compact('data','dataExpense','id','type','Sum'));
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
        if($request->type == 1){ //อัพเดทค่าใช้จ่าย ภายในศาล
            $dataExpense = Legisexpense::find($id);
                $dataExpense->Type_expense = $request->get('TypeExpense');
                $dataExpense->Topic_expense = $request->get('TopicExpense');
                $dataExpense->Amount_expense = $request->get('AmountExpense');
                $dataExpense->Note_expense = $request->get('NoteExpense');
                $dataExpense->Useredit_expense = $request->get('UserEditExpense');
                $dataExpense->LawyerName_expense = $request->get('LawyerName');
            $dataExpense->update();
        }
        elseif($request->type == 2){ //อัพเดทค่าใช้จ่าย ค่าพิเศษ
            $Amountall = $request->get('AmountExpense') / $request->get('TotalExpense');
            $data = Legisexpense::where('Code_expense','=',$id)
            ->update([
                'Amount_expense' => $Amountall,
                'Type_expense' => $request->get('TypeExpense'),
                'Topic_expense' => $request->get('TopicExpense'),
                'Note_expense' => $request->get('NoteExpense'),
                'Useredit_expense' => $request->get('UserEditExpense'),
                'LawyerName_expense' => $request->get('LawyerName'),
             ]);
        }
        elseif($request->type == 3){
            $dataExpense = Legisexpense::find($id);
                $dataExpense->Type_expense = $request->get('TypeExpense');
                $dataExpense->Amount_expense = $request->get('AmountExpense');
                $dataExpense->PayAmount_expense = $request->get('EditAmountExpense');
                $dataExpense->BalanceAmount_expense = $request->get('BalanceExpense');
                $dataExpense->Note_expense = $request->get('NoteExpense');
                $dataExpense->Useredit_expense = $request->get('UserEditExpense');
                $dataExpense->LawyerName_expense = $request->get('LawyerName');
            $dataExpense->update();
        }

        $FlagTab = $request->FlagTab;
        return redirect()->back()->with(['FlagTab' => $FlagTab,'success' => 'อัพเดตข้อมูลเรียบร้อย']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if($request->type == 1){ //ลบค่าใช้จ่ายเป็นรายบุคคล
            $item = Legisexpense::find($id);
            $item->Delete();
        }
        elseif($request->type == 2){ //ลบค่าใช้จ่ายเป็นกลุ่ม
            $item2 = Legisexpense::where('Code_expense',$id);
            $item2->Delete();
        }

        $FlagTab = $request->FlagTab;
        return redirect()->back()->with(['FlagTab' => $FlagTab,'success' => 'ลบข้อมูลเรียบร้อย']);
    }
}

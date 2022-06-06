<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use DB;

use App\Legislation;
use App\Legisexpense;

class TreasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dateSearch = NULL;
        $Fdate = NULL;
        $Tdate = NULL;

        if ($request->has('FlagTab')) {
           $FlagTab = $request->get('FlagTab');
        }
        elseif (session()->has('FlagTab')) {
           $FlagTab = session('FlagTab');
        }
        else {
            $FlagTab = NULL;
        }

        if ($request->has('dateSearch')) {
            $dateSearch = $request->dateSearch;

            $SetFdate = substr($dateSearch,0,10);
            $Fdate = date('Y-m-d', strtotime($SetFdate));

            $SetTdate = substr($dateSearch,13,21);
            $Tdate = date('Y-m-d', strtotime($SetTdate));
        }

        if ($request->type == 1) {  //รายการตั้งเบิก
            if ($dateSearch != NULL) {
                $data1 = Legisexpense::whereBetween('Date_expense', [$Fdate,$Tdate])
                    ->where('Type_expense','=','ภายในศาล')
                    ->get();
                $data2 = Legisexpense::whereBetween('Date_expense',[$Fdate,$Tdate])
                    ->where('Type_expense','=','ค่าพิเศษ')
                    ->selectRaw('count(id) as Total,Type_expense,Code_expense,Amount_expense,Topic_expense,Note_expense,Receiptno_expense,Flag_expense,Useradd_expense,Date_expense,DateApprove_expense')
                    ->groupBy('Code_expense','Type_expense','Amount_expense','Topic_expense','Note_expense','Receiptno_expense','Flag_expense','Useradd_expense','Date_expense','DateApprove_expense')
                    ->get();
            }else {
                $data1 = Legisexpense::where('Type_expense','=','ภายในศาล')
                    ->where('Flag_expense','=', 'wait')
                    ->get();
                $data2 = Legisexpense::where('Type_expense','=','ค่าพิเศษ')
                    ->where('Flag_expense','=', 'wait')
                    ->selectRaw('count(id) as Total,Type_expense,Code_expense,Amount_expense,Topic_expense,Note_expense,Receiptno_expense,Flag_expense,Useradd_expense,Date_expense,DateApprove_expense')
                    ->groupBy('Code_expense','Type_expense','Amount_expense','Topic_expense','Note_expense','Receiptno_expense','Flag_expense','Useradd_expense','Date_expense','DateApprove_expense')
                    ->get();
            }
            // dd($data2);

            $Sum1 = 0;
            for ($i=0; $i < count($data1); $i++) { 
                $Sum1 += $data1[$i]->Amount_expense;
            }

            $Sum2 = 0;
            for ($j=0; $j < count($data2); $j++) { 
                $Sum2 += $data2[$j]->Amount_expense * $data2[$j]->Total;
            }
            // dd($Sum1);
            $type = $request->type;
            return view('treasury.view', compact('type','FlagTab','data1','data2','Sum1','Sum2','dateSearch'));
        }
        elseif ($request->type == 2) {  //รายการขอเบิกสำรองจ่าย
            if ($dateSearch != NULL) {
                $data = Legisexpense::whereBetween('Date_expense', [$Fdate,$Tdate])
                    ->where('Type_expense','=','เบิกสำรองจ่าย')
                    ->get();
            }else {
                $data = Legisexpense::where('Type_expense','=','เบิกสำรองจ่าย')
                    ->whereIn('Flag_expense',['wait','process'])
                    ->get();
            }

            $Sum = 0;
            for ($i=0; $i < count($data); $i++) { 
                $Sum += $data[$i]->Amount_expense;
            }

            $type = $request->type;
            return view('treasury.view', compact('type','FlagTab','data','Sum','dateSearch'));
        }
        elseif ($request->type == 3) {  //รายการตั้งเบิกของกลาง
            if ($dateSearch != NULL) {
                $data = Legisexpense::whereBetween('Date_expense', [$Fdate,$Tdate])
                    ->where('Type_expense','=','ค่าของกลาง')
                    ->get();
            }else {
                $data = Legisexpense::where('Type_expense','=','ค่าของกลาง')
                    ->where('Flag_expense','=', 'wait')
                    ->get();
            }
            // dd($data2);

            $Sum = 0;
            for ($i=0; $i < count($data); $i++) { 
                $Sum += $data[$i]->Amount_expense;
            }
            // dd($Sum1);
            $type = $request->type;
            return view('treasury.view', compact('type','FlagTab','data','Sum','dateSearch'));
        }
        elseif ($request->type == 4) {  //view report

            $type = $request->Flag;
            return view('treasury.viewReport', compact('type'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->has('FlagTab')) {
            $FlagTab = $request->get('FlagTab');
        }else {
            $FlagTab = NULL;
        }

        if ($request->type == 1) {  //อัพเดต คชจ.ภายในศาล
            $id = $request->IDApp;
            $item = Legisexpense::where('Type_expense','=','ภายในศาล')
                    ->where(function ($query) use ($id) {
                    $query->whereIn('id',$id)
                    ->where('NameApprove_expense','=',NULL)
                    ->update(['Flag_expense' => 'complete',
                              'DateApprove_expense' => date('Y-m-d'),
                              'NameApprove_expense' => auth()->user()->name]);
                    });
        }
        elseif ($request->type == 2) {  //อัพเดต คชจ.ค่าพิเศษ
            $id = $request->IDApp2;
            // dd($id);
            $item = Legisexpense::where('Type_expense','=','ค่าพิเศษ')
                ->where(function ($query) use ($id) {
                $query->whereIn('Code_expense',$id)
                ->where('NameApprove_expense','=',NULL)
                ->update(['Flag_expense' => 'complete',
                            'DateApprove_expense' => date('Y-m-d'),
                            'NameApprove_expense' => auth()->user()->name]);
                });
        }
        elseif ($request->type == 3) {  //อนุมัติเงินสำรองจ่าย เช็ครอบแรก
            $id = $request->IDApp;
            $item = Legisexpense::where('Type_expense','=','เบิกสำรองจ่าย')
                    ->where(function ($query) use ($id) {
                    $query->whereIn('id',$id)
                    ->where('NameApprove_expense','=',NULL)
                    ->update(['Flag_expense' => 'process',
                              'Transfer_expense' => date('Y-m-d')]);
                    });
        }
        elseif ($request->type == 4) {  //อัพเดต คชจ.ของกลาง
            $id = $request->IDApp;
            $item = Legisexpense::where('Type_expense','=','ค่าของกลาง')
                    ->where(function ($query) use ($id) {
                    $query->whereIn('id',$id)
                    ->where('NameApprove_expense','=',NULL)
                    ->update(['Flag_expense' => 'complete',
                            'DateApprove_expense' => date('Y-m-d'),
                            'NameApprove_expense' => auth()->user()->name]);
                    });
        }
        return redirect()->back()->with(['FlagTab' => $FlagTab,'success'=>'บันทึกข้อมูลเรียบร้อย']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if ($request->type == 1) {
            $data = Legisexpense::where('id',$id)
                    ->where('Type_expense','=','เบิกสำรองจ่าย')
                    ->first();
            // dd($data);
        } 
        elseif($request->type == 2) {
            //
        }

        $type = $request->type;
        $Flagtype = $request->Flagtype;
        $FlagTab = $request->FlagTab;

        return view('treasury.viewModal',compact('data','type','Flagtype','FlagTab'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        if ($request->type == 1) {  //อัพเดต คชจ.เบิกสำรองจ่าย
            $item = Legisexpense::where('Type_expense','=','เบิกสำรองจ่าย')
                    ->where(function ($query) use ($id) {
                    $query->where('id',$id)
                    ->where('NameApprove_expense','=',NULL)
                    ->update(['Flag_expense' => 'complete',
                              'DateApprove_expense' => date('Y-m-d'),
                              'NameApprove_expense' => auth()->user()->name]);
                    });
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
    public function destroy($id)
    {
        //
    }
}

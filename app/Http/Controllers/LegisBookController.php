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

use App\Content;
use App\Legisbook;

class LegisBookController extends Controller
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

        if ($request->get('dateSearch')) {
            $dateSearch = $request->dateSearch;

            $SetFdate = substr($dateSearch,0,10);
            $Fdate = date('Y-m-d', strtotime($SetFdate));

            $SetTdate = substr($dateSearch,13,21);
            $Tdate = date('Y-m-d', strtotime($SetTdate));
        }

        if ($request->type == 1) {   //Main หนังสือสารบัญ
            $data = DB::table('contents')
                ->get();

            $type = $request->type;
            return view('LegisBook.viewContent', compact('type','data','dateSearch'));
        }
        elseif ($request->type == 2) {   //Main หนังสือ-เข้า
            $data = DB::table('legisbooks')
                  ->where('Type_book', '=', 'หนังสือเข้า')
                  ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                    return $q->whereBetween('Datecreate_book',[$Fdate,$Tdate]);
                    })
                  ->get();

            $data2 = DB::table('legisbooks')
                  ->where('Type_book', '=', 'หนังสือออก')
                  ->when(!empty($Fdate)  && !empty($Tdate), function($q) use ($Fdate, $Tdate) {
                    return $q->whereBetween('Datecreate_book',[$Fdate,$Tdate]);
                    })
                  ->get();

            $type = $request->type;
            return view('LegisBook.viewBook', compact('type','data','data2','dateSearch'));
        }
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
        if ($request->type == 1){ //เพิ่มสารบัญลูกหนี้
            $Contractno = $request->get('Contract_no');
            $array_len = count($Contractno);
            $Sname = $request->get('Sname');
            $Fname =  $request->get('Fname');
            $Lname =  $request->get('Lname');
            $Casenumber =  $request->get('Casenumber');
            $Filepath =  $request->get('File_path');
    
            $data = DB::table('contents')
              ->orderBy('Locat','desc')
              ->first();
              
            for ($i=0; $i < $array_len; $i++) {
                
                $Content = new Content([
                    'Locat' => ($data->Locat+($i+1)),
                    'Contractno' => $Contractno[$i],
                    'Sname' => $Sname[$i],
                    'Fname' =>  $Fname[$i],
                    'Lname' =>  $Lname[$i],
                    'Casenumber' =>  $Casenumber[$i],
                    'Filepath' =>  $Filepath[$i],
                    'Dateadd' =>  date('Y-m-d'),
                    'Useradd' =>  $request->get('Nameuser'),
                ]);
                $Content->save();
            }
        }
        elseif ($request->type == 2){ //เพิ่มหนังสือเข้า-ออก
            // dd($request);
            $DateBook = $request->get('DateBook');
            $array_len = count($DateBook);
            $TypeBook = $request->get('TypeBook');
            $TitleBook =  $request->get('TitleBook');
            $FromWhere =  $request->get('FromWhere');
            $ToWhere =  $request->get('ToWhere');
            $NoteBook =  $request->get('NoteBook');

            $data = DB::table('legisbooks')
              ->where('Type_book',$TypeBook)
              ->orderBy('OrdinalNumber_book','desc')
              ->first();
            if($data == NULL){
                $OrdinalNo = '00';
            }else{
                $OrdinalNo = explode("/",$data->OrdinalNumber_book);
            }

            for ($i=0; $i < $array_len; $i++) {

                $Number = $OrdinalNo[0] + ($i+1) .'/'.substr((date('Y')+543),2,3);
                
                $Book = new Legisbook([
                    'OrdinalNumber_book' => $Number,
                    'Datecreate_book' => $DateBook[$i],
                    'Type_book' => $TypeBook[$i],
                    'Title_book' =>  $TitleBook[$i],
                    'Fromwhere_book' =>  $FromWhere[$i],
                    'Towhere_book' =>  $ToWhere[$i],
                    'Note_book' =>  $NoteBook[$i],
                    'Dateadd' =>  date('Y-m-d'),
                    'Useradd' =>  $request->get('Nameuser'),
                ]);
                $Book->save();
            }
        }
        return redirect()->back()->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if ($request->type == 1) { //สารบัญลูกหนี้
            $data = Content::where('Content_id',$id)->first();
              // dd($data);
    
            $type = $request->type;
        }
        elseif ($request->type == 2) { //หนังสือเข้า-ออก
            $data = Legisbook::where('id',$id)->first();
              // dd($data);
    
            $type = $request->type;
        }
        return view('LegisBook.PopUp',compact('data','id','type'));
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
        if ($request->type == 1) {  //สารบัญลูกหนี้
            $Content = Content::where('Content_id',$id)->first();
              $Content->Locat = $request->get('Locat');
              $Content->Contractno = $request->get('Contract_no');
              $Content->Sname = $request->get('Sname');
              $Content->Fname =  $request->get('Fname');
              $Content->Lname =  $request->get('Lname');
              $Content->Casenumber =  $request->get('Casenumber');
              $Content->Filepath =  $request->get('File_path');
              $Content->Userupdate =  $request->get('Nameuser');
              $Content->Usertake =  $request->get('Usertake');
              if($Content->Datetake == NULL){
                  $Content->Datetake =  date('Y-m-d');
              }
            $Content->update();
        }
        elseif ($request->type == 2) {  //หนังสือเข้า-ออก
            $Book = Legisbook::where('id',$id)->first();
              $Book->Datecreate_book = $request->get('DateBook');
              $Book->Type_book = $request->get('TypeBook');
              $Book->Title_book = $request->get('TitleBook');
              $Book->Fromwhere_book =  $request->get('FromWhere');
              $Book->Towhere_book =  $request->get('ToWhere');
              $Book->Note_book =  $request->get('NoteBook');
              $Book->Userupdate =  $request->get('Nameuser');
            $Book->update();
    
        }
        return redirect()->back()->with('success','อัพเดทข้อมูลเรียบร้อย');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // dd($request);
        if ($request->type == 1) { //ลบตาราง สารบัญ
            $item = Content::where('Content_id',$id);
            $item->Delete();
        }
        elseif ($request->type == 2) { //ลบตาราง หนังสือเข้า-ออก
            $item = Legisbook::where('id',$id);
            $item->Delete();
        }
        // return redirect()->back()->with('success','ลบข้อมูลเรียบร้อย');
        return redirect()->back();
    }
}

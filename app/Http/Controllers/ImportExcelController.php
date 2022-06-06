<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Excel;

class ImportExcelController extends Controller
{
    function index()
    {
     $data = DB::table('tbl_customer')->orderBy('CustomerID', 'DESC')->get();
     return view('import_excel', compact('data'));
    }

    function import(Request $request)
    {
     $this->validate($request, [
      'select_file'  => 'required|mimes:xls,xlsx'
     ]);

     $path = $request->file('select_file')->getRealPath();

     $data = Excel::load($path)->get();
    //  dd($data);

     if($data->count() > 0)
     {
      foreach($data->toArray() as $key => $row)
      {

        $insert_data[] = array(
         'Locat'  => $row['locat'],
         'Contractno'   => $row['contractno'],
         'Sname'   => $row['sname'],
         'Fname'    => $row['fname'],
         'Lname'  => $row['lname'],
         'Casenumber'   => $row['casenumber'],
         'Filepath'   => $row['filepath'],
         'Dateadd'   => date('Y-m-d'),
         'Useradd'   => 'อารีฟ สนิ',
        );

      }

      if(!empty($insert_data))
      {
       DB::table('contents')->insert($insert_data);
      }
     }
     return back()->with('success', 'Excel Data Imported successfully.');
    }
}
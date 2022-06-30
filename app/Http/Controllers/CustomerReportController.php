<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\sections;
use App\Models\invoices;

class CustomerReportController extends Controller
{
    public function index() {
        $sections = sections::all();
        return view('customers_reports.index', compact('sections'));
    }
    
    public function search(Request $request) {
        
        if ($request->Section && $request->product && $request->start_at =='' && $request->end_at=='') {
            
            $invoices = invoices::select('*')->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
            $sections = sections::all();
            return view('customers_reports.index',compact('sections'))->withDetails($invoices);
     }


  // في حالة البحث بتاريخ
     
     else {
       
       $start_at = date($request->start_at);
       $end_at = date($request->end_at);

      $invoices = invoices::whereBetween('invoice_date',[$start_at,$end_at])->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
       $sections = sections::all();
       return view('customers_reports.index',compact('sections'))->withDetails($invoices);

      
     }
    }
}

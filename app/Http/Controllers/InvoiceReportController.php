<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoices;

class InvoiceReportController extends Controller
{
    public function index() {
        return view('invoices_reports.index');
    }
    public function search(Request $request) {
       // dd($request->all());
        
        $type = $request->type;
        $start_at = $request->start_at;
        $end_at = $request->end_at;
        $invoice_number = $request->invoice_number;
        
        
        if($request->rdio == '1'){
             if($type && $start_at == '' && $end_at == ''){
                 $invoices = invoices::select('*')->where('status', '=', $type)->get();
                 return view('invoices_reports.index', compact('type'))->withDetails($invoices);
             }else{            
            $invoices = invoices::whereBetween('invoice_date', [date($request->start_at), date($request->end_at)])
                    ->where('status', '=', $type)->get();
            
            return view('invoices_reports.index', compact('type','start_at','end_at'))->withDetails($invoices);

        }
        }else{
            $invoices = invoices::select('*')->where('invoice_number', '=', $invoice_number)->get();
            return view('invoices_reports.index')->withDetails($invoices);
        }
    }
}

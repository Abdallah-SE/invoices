<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\Sections;
use App\Models\invoices_details;

use App\Mail\invoiceMail;
use Illuminate\Support\Facades\Mail;

use App\Models\invoices_attachments;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

use App\Notifications\InvoiceNotifier;
use App\Models\User;
use Illuminate\Support\Facades\Notification;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InvoicesExport;

use Illuminate\Support\Facades\Storage;


use App\Notifications\InvoiceAlert;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function __construct() {
       // $this->middleware('permission:invoices', ['only' => ['index']]);
        // $this->middleware('permission:invoices_list', ['only' => ['index']]);
        // $this->middleware('permission:paid_invoices_list', ['only' => ['paid']]);
        // $this->middleware('permission:unpaid_invoices_list', ['only' => ['unpaid']]);
        // $this->middleware('permission:partial_paid_invoices_list', ['only' => ['partial']]);
        // $this->middleware('permission:trashed_invoices', ['only' => ['trash']]);
    }
    public function index()
    {
        $invoices = invoices::all();
        return view('invoices.invoices', compact('invoices'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProducts($id)
    {
        $products = DB::table('products')->where('section_id',$id)->pluck('product_name', 'id');
        return json_encode($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = Sections::all();
        return view('invoices.create', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'status' => 'غير مدفوعة',
            'Value_Status' => 3,
            'note' => $request->note,
        ]);

        $invoice_id = invoices::latest()->first()->id;

        invoices_details::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 3,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        if ($request->hasFile('pic')) {

            $invoice_id = Invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoices_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }
        $cuser = User::first();
        
       // $cuser->notify(new InvoiceNotifier($invoice_id));

       // Notification::send($cuser, new InvoiceNotifier($invoice_id));
        $url = 'http://laravel-invoice-app-system-000.herokuapp.com/' . $invoice_id;//'http://localhost:8000/InvoicesDetails/' . $invoice_id;
        Mail::to($cuser)->send(new invoiceMail($url));
        
        
        $user = \App\Models\User::get();
        //// $user = \App\Models\User::find(Auth::user()->id); ///For the authenticated user
        $last_invoice = invoices::latest()->first();

        
    foreach ($user as $u) {
    $u->notify(new InvoiceAlert($last_invoice));
}
    
        
        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return back();
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoices = invoices::where('id', $id)->first();
        $sections = Sections::all();
        return view('invoices.edit_invoice', compact('sections', 'invoices'));
    }
     /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $invoices = invoices::where('id', $id)->first();
        return view('invoices.update_status', compact('invoices'));
    }
    public function statusUpdate($id, Request $request) {
        $invoices = invoices::findOrFail($id);

        if($request->status === 'مدفوعة'){
            $invoices->update([
                'Value_Status' => 1,
                'status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);

            invoices_Details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 1,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }else {
            $invoices->update([
                'Value_Status' => 3,
                'status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_Details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 3,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }

        session()->flash('Status_Update', 'تم تحديث حالة الدفع بنجاح');
        return redirect('/invoices');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $invoices = invoices::findOrFail($request->invoice_id);
        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_date,
            'Due_date' => $request->due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,
        ]);

        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $id = $request->invoice_id;
        $invoices = invoices::where('id', $id)->first();

        $Details = invoices_attachments::where('invoice_id', $id)->first();
        if($request->id_page == 2){
            $invoices->delete();
            session()->flash('trash_invoice', 'تم ارشفة الفاتوره بنجاح');
            return back();
        } else {
            if (!empty($Details->invoice_number)) {

            Storage::disk('public_attach')->deleteDirectory($Details->invoice_number);
        }
        
        $invoices->forceDelete();

        session()->flash('delete_invoice', 'تم حذف الفاتوره بنجاح');
        return back();
        }
        
    }


    ////Specially for status of the invoice
    
    public function paid()
    {
        $invoices = invoices::where('Value_Status', 1)->get();
        return view('invoices.paid_invoices', compact('invoices'));
    }  
    public function unpaid()
    {
        $invoices = invoices::where('Value_Status', 2)->get();
        return view('invoices.unpaid_invoices', compact('invoices'));
    }  
    public function partial()
    {
        $invoices = invoices::where('Value_Status', 3)->get();
        return view('invoices.partial_invoices', compact('invoices'));
    }
    
    public function trash() {
        $invoices = invoices::onlyTrashed()->get();
        return view('invoices.trashed_invoices', compact('invoices'));
    }
    
    
    
    public function cancel_trash(Request $request) {
        $id = $request->invoice_id;
         $invoice = Invoices::withTrashed()->where('id', $id)->restore();
         session()->flash('restore_invoice');
         return redirect('/invoices');
    }
    public function destroyTrash(Request $request) {
        
        $invoices = invoices::withTrashed()->where('id',$request->invoice_id)->first();
        $invoices->forceDelete();
        session()->flash('delete_invoice');
        return redirect('/trashed_invoice');
    }
    
    public function printInvoice($id) {
        $invoices = invoices::where('id', $id)->first();
        return view('invoices.print_invoice', compact('invoices'));
    }
    
    public function export() 
    {
        return Excel::download(new InvoicesExport, 'invoices.xlsx');
    }
    
    
    
    /// Notification
    
   public function markAsRead(){

	auth()->user()->unreadNotifications->markAsRead();
	return redirect()->back();
        
   }
}

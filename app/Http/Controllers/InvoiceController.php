<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Mail;
use App\Mail\InvoiceMail;
class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::all();
        return view('invoice.index', compact('invoices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_name' => 'required',
            'invoice_email' => 'required',
            'invoice_number' => 'required|unique:invoices,invoice_number',
            'invoice_file' => 'required|mimes:png,jpeg,jpg,pdf|max:500',
            'invoice_rating' => 'required'           
        ]);
        
        $invoices = Invoice::create([
            'invoice_name' => $request->invoice_name,
            'invoice_email' => $request->invoice_email,
            'invoice_number' => $request->invoice_number,
            'invoice_file' => $request->file('invoice_file')->storeAs('invoice/'.$request->invoice_number, $request->invoice_number.'.'.$request->invoice_file->extension(), 'public'),
            'invoice_rating' => $request->invoice_rating
        ]);
        return redirect('invoice')->with('message', 'Invoice saved successfully');
    }

    public function edit($id)
    {
        $invoice = Invoice::find($id);
        return view('invoice.edit', compact('invoice'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'invoice_name' => 'required',
            'invoice_email' => 'required',
            'invoice_number' => 'required',
            'invoice_rating' => 'required'           
        ]);

        $invoices = Invoice::where('id', $id)->update([
            'invoice_name' => $request->invoice_name,
            'invoice_email' => $request->invoice_email,
            'invoice_number' => $request->invoice_number,
            'invoice_file' => $request->invoice_file ? $request->file('invoice_file')->storeAs('invoice/'.$request->invoice_number, $request->invoice_number.'.'.$request->invoice_file->extension(), 'public') : NULL,
            'invoice_rating' => $request->invoice_rating
        ]);
        return redirect('invoice')->with('message', 'Invoice updated successfully');
    }

    public function destroy($id)
    {
        $invoices = Invoice::where('id', $id)->delete();
        return redirect('invoice')->with('message', 'Invoice deleted successfully');
    }

    public function mail($id)
    {
        $invoice = Invoice::where('id', $id);
        $invoice->update(['invoice_mail' => '1']);
        Mail::to($invoice->get()->first()->invoice_email)->send(new InvoiceMail($invoice->get()->first()));
        return redirect('invoice')->with('message', 'Invoice Sent successfully');
    }
}

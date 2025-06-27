<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceRequest;
use App\Services\InvoiceService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\invoice;
use App\Http\Requests\StoreCustomerRequest;

class InvoiceController extends Controller
{

    public function store(StoreInvoiceRequest $request, InvoiceService $invoiceService)
    {
        try {
            $userId = Auth::id();

          $validated= $request->validated();
    
            $invoice = $invoiceService->store($validated, $userId);

            if($invoice){
                return response()->json([
                    'status' => true,
                    'message' => 'Invoice created successfully.',
                    'invoice' => $invoice
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Failed To create Invoice.',
                ]);
            }
           
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error creating invoice: ' . $e->getMessage()
            ], 500);
        }
    }



    //generate pdf
    public function generatePdf(){

        $invoice = invoice::with('items')->latest('invoice_id')->first();

        if (!$invoice) {
            return response()->json(['message' => 'No invoice found.'], 404);
        }

        $pdf = Pdf::loadView('invoicePdf', ['invoice' => $invoice]);

        return $pdf->download('invoice-' . $invoice->invoice_no . '.pdf');
    }


    //store customer
    public function storeCustomerData(StoreCustomerRequest $request, InvoiceService $invoiceService){

    try {

        $userId = Auth::id();

        $validated = $request->validated();

        $customer = $invoiceService->storeCustomerWithAddress($validated, $userId);

        return response()->json([
            'status' => true,
            'message' => 'Customer created successfully',
            'data' => $customer,
        ]);

    } catch (Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Something went wrong.',
            'error' => $e->getMessage(), 
        ], 500);
    }
}

}

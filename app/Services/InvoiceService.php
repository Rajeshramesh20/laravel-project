<?php

namespace App\Services;

use App\Models\invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Carbon;
use App\Models\Customers;
use App\Models\Addresses;

class InvoiceService
{

    public function store($data, $userId)
    {
       


        $totalAmount = 0;

        foreach ($data['items'] as $item) {
            $netAmount = $item['quantity'] * $item['unit_price'];
            $gstPercent = $item['gst_percent'] ?? 0;
            $gstAmount = $netAmount * $gstPercent / 100;
            $total = $netAmount + $gstAmount;
            $totalAmount += $total;
        }
        //invoice table data
        $invoice =  invoice::create([
            'invoice_no' => $this->generateInvoiceNumber($data['invoice_date']??now()),
            'invoice_date' => $data['invoice_date'] ?? now(),
            'customer_id' => $data['customer_id'],
            'invoice_due_date' => $data['invoice_due_date'] ?? null,
            'total_amount'=> $totalAmount,
            'additional_text' => $data['additional_text'] ?? null,
            'created_by' => $userId,
        ]);

         //item table data
        foreach ($data['items'] as $item) {
            $netAmount = $item['quantity'] * $item['unit_price'];
            $gstPercent = $item['gst_percent'] ?? 0;
            $gstAmount = $netAmount * $gstPercent/100;
            $total =  $netAmount + $gstAmount;
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'item_name' => $item['item_name'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'net_amount' => $netAmount,
                'gst_percent'=> $gstPercent,
                'gst_amount'=> $gstAmount,
                'total'=> $total,
                'created_by' => $userId,
            ]);
        }
        
        return $invoice;
    }


    //generate invoice id month wise
    public function generateInvoiceNumber( $invoiceDate)
    {
        // $date = $invoiceDate;
        $date = Carbon::parse($invoiceDate);
        $datePart = $date->format('Y-m');

        $count = invoice::whereYear('invoice_date', $date->year)
            ->whereMonth('invoice_date', $date->month)
            ->count() + 1;

        return 'INV-' . $datePart . '-' . $count;
    }



    public function storeCustomerWithAddress( $customerData,$userId)
    {

        //customer table data
        $customer = Customers::create([
            'customer_name' => $customerData['customer_name'],
            'customer_email' => $customerData['customer_email'],
            'contact_name' => $customerData['contact_name'] ?? null,
            'contact_number' => $customerData['contact_number'] ?? null,
            'created_by' => $userId,
        ]);

        //address table data
        $address = Addresses::create([
            'reference_id' => $customer->customer_id,
            'reference_name' => 'Customer',
            'line1' => $customerData['line1'],
            'line2' => $customerData['line2'] ?? null,
            'line3' => $customerData['line3'] ?? null,
            'line4' => $customerData['line4'] ?? null,
            'pincode' => $customerData['pincode'],
            'created_by' => $userId,
        ]);
       
        $customer = Customers::latest()->first();
        $address = Addresses::latest()->first();

        $customer->address_id = $address->address_id;
        
        return $customer->fresh(['address']);
    }

    //get customer data
    public function getAllCostomer(){
        $coustomer = Customers::all();
        return $coustomer;
    }
}

<?php

namespace App\Services;

use App\Models\invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceStatus;
use Illuminate\Support\Carbon;
use App\Models\Customers;
use App\Models\Addresses;

class InvoiceService
{

    public function store($data, $userId)
    {
        $draftStatusId = InvoiceStatus::where('invoice_status', 'draft')->value('invoice_status_id');

        //invoice table data
        $invoice =  invoice::create([
            'invoice_no' => $this->generateInvoiceNumber($data['invoice_date']??now()),
            'invoice_date' => $data['invoice_date'] ?? now(),
            'con_org_id' => $data['con_org_id'],
            'invoice_due_date' => $data['invoice_due_date'] ?? null,
            'payment_terms' => $data['payment_terms'] ?? null,
            'invoice_status_id'=> $draftStatusId ,
            'created_by' => $userId,

        ]);

         //item table data
        foreach ($data['items'] as $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'item_name' => $item['item_name'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total' => $item['quantity'] * $item['unit_price'],
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
}

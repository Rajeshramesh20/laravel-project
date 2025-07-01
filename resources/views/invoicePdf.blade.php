<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        @page {
            size: A4;
            margin: 20mm;
        }
    
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #000;
        }
    
        .container {
            width: 100%;
            margin: auto;
        }
/*     
        .flex_container {
            margin-bottom: 20px;
        }
     */
        .flex_container::after {
            content: "";
            display: table;
            clear: both;
        }
    
        .flex_container .left {
            float: left;
            width: 60%;
        }
    
        .flex_container .right {
            float: right;
            width: 38%;
            text-align: right;
        }
    
    
        .bold {
            font-weight: bold;
            text-align: right;
        }
    
        .logo {
            width: 180px;
            margin-top: 14px;
        }
    
        .address {
            margin-bottom: 8px;
        }
    
        .border-top {
            border-top: 1px solid #000;
            margin-top: 20px;
        }
    
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
    
        .table th,
        .table td {
            padding: 8px 10px;
        }
    
        .table thead {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
        }
    
        .footer {
            margin-top: 40px;
            font-size: 12px;
        }
    
        .title_section {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 6px;
        }
    
        .payment_detail {
            width: 100%;
            margin-top: 10px;
        }
    
        .payment_detail td {
            padding: 4px 0;
        }
    
        .border-bottom-total {
            border-bottom: 1px solid #000;
        }
    
        .no-border td {
            border: none;
        }
    
        .align {
            text-align: center;
        }
      
    </style>
</head>

<body>
    <div class="container">

        <!-- Header -->
        <div class="flex_container">
            <div class="flex_container">
                <div class="left">
                    <img src="images/twigik.png" class="logo " alt="Twigik Logo">
                </div>
                
                <h2 class="bold right ">INVOICE</h2>
            </div>
            <div class="left">
                {{-- <img src="{{ public_path('images/twigik.png') }}" class="logo" alt="Twigik Logo"> --}}
                <p class="address">Plot No 69, 3rd Floor, 11th Cross Street,<br>
                    Sai Ganesh Nagar, Pallikaranai,<br>
                    Chennai - 600100<br>
                    Phone no: +91-6383707076<br>
                    GSTIN: 33AALCT4631L1Z3</p>
            </div>
            <div class="right">
                {{-- <h2 class="bold">INVOICE</h2> --}}
                <p><strong>Invoice #:</strong>{{ $invoice->invoice_no }}</p>
                <p><strong>Invoice date:</strong>{{ $invoice->invoice_date }}</p>
                <p><strong>Bill to:</strong>{{$invoice->customer->customer_name }}</p>
                <p><strong>Address:</strong>{{ $invoice->customer->address->line1 }}
                    {{ $invoice->customer->address->line2 }}, {{ $invoice->customer->address->line3 }},{{
                    $invoice->customer->address->line4 }} -
                    {{ $invoice->customer->address->pincode }}</p>
                <p><strong>Phone:</strong> +91-{{ $invoice->customer->contact_number}}</p>
            </div>
        </div>

        <!-- Table -->
        <table class="table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Unit price</th>
                    <th>GST(18%)</th>
                    <th></th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                <tr>
                    <td class="align">{{ $item->item_name }}</td>
                    <td class="align">{{ $item->quantity }}</td>
                    <td class="align">₹ {{ number_format($item->unit_price, 2) }}</td>
                    <td class="align">₹ {{ number_format($item->gst_amount, 2) }}</td>
                    <td class="align"></td>
                    <td class="align">₹ {{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
                <tr class="no-border">
                    <td colspan="3"></td>
                    <td></td>
                    <td class="align"><strong>Discount</strong></td>

                    <td class="align">₹0.00</td>
                </tr>
                <tr class="no-border">
                    <td colspan="3"></td>
                    <td></td>
                    <td class="align"><strong>Advance (-)</strong></td>
                    <!-- <td>(-)</td> -->
                    <td class="align">₹ 0.00</td>
                </tr>
                <tr class="border-bottom-total">
                    <td colspan="3"></td>
                    <td></td>
                    <td class="align"><strong>TOTAL</strong></td>
                    <td class="align"><strong>₹{{ $invoice->total_amount}} </strong></td>
                </tr>
            </tbody>
        </table>

        <!-- Footer -->
        <div class="footer align">

            <p>(Amount in words: Two Thousand Rupees Only)</p>
            <p>Please make all payments payable to Twigik Technologies Private Limited.</p>
            <p>info@twigik.com | www.twigik.com</p>
        </div>

        <!-- Payment Details -->
        <div>
            <div class="title_section">Payment Details</div>
            <table class="payment_detail">
                <tr>
                    <td><strong>Account name:</strong></td>
                    <td>TWIGIK TECHNOLOGIES PRIVATE LIMITED</td>
                </tr>
                <tr>
                    <td><strong>Account number:</strong></td>
                    <td>50200106313602</td>
                </tr>
                <tr>
                    <td><strong>Account type:</strong></td>
                    <td>Current</td>
                </tr>
                <tr>
                    <td><strong>Branch:</strong></td>
                    <td>Pallikaranai</td>
                </tr>
                <tr>
                    <td><strong>IFSC:</strong></td>
                    <td>HDFC0001880</td>
                </tr>
            </table>
        </div>

    </div>
</body>

</html>
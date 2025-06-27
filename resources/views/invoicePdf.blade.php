<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twigik-Invoice</title>
    <!-- favicon -->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <!-- bs5 css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- bs5 js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        /* ti-Twigik invoice */
        .ti_heading {
            font-size: 1.125rem;
        }

        .ti_subHeading {
            font-size: 1rem;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row py-5">
            <!-- logo -->
            <div class="col-md-6">
                {{-- <img src="images/twigik.png" alt="Twigik-logo"> --}}
            </div>
            <!-- heading -->
            <div class="col-md-6 d-flex justify-content-end align-items-center">
                <div class="fw-bold fs-4 text-uppercase">Invoice</div>
            </div>
        </div>
        <div class="row pb-5">
            <div class="col-md-6">
                <!-- address -->
                <div class="d-flex flex-column">
                    <span>Plot No 69, 3rd Floor, 11th Cross Street,</span>
                    <span>Sai Ganesh Nagar, Pallikaranai,</span>
                    <span>Chennai - 600100</span>
                </div>
                <!-- phone number -->
                <div class="pb-3">
                    Phone no:
                    <a href="tel:+91-6383707076" class="text-decoration-none text-black">+91-6383707076</a>
                </div>
                <!-- gst no -->
                <div class="text-uppercase">GSTIN: 33AALCT4631L1Z3</div>
            </div>
            <!-- address -->
            <div class="col-md-6">

                <!-- Invoice details section -->
                <div class="row">
                    <div class="col-md-3 fw-semibold d-flex justify-content-end align-items-center ti_heading">Invoice #:</div>
                    <div class="col-md-9 text-uppercase d-flex align-items-center ti_subHeading">{{ $invoice->invoice_no }}</div>
                </div>

                <!-- Invoice date -->
                <div class="row pb-3">
                    <div class="col-md-3 fw-semibold d-flex justify-content-end align-items-center ti_heading">Invoice date:</div>
                    <div class="col-md-9 d-flex align-items-center ti_subHeading "> {{ $invoice->invoice_date }}</div>
                </div>

                <!-- Billing details -->
                <div class="row">
                    <div class="col-md-3 fw-semibold d-flex justify-content-end align-items-center ti_heading">Bill to:</div>
                    <div class="col-md-9 d-flex align-items-center ti_subHeading">{{ $invoice->bill_to }}</div>
                </div>

                <!-- Billing address -->
                <div class="row pb-3">
                    <div class="col-md-3 fw-semibold d-flex justify-content-end align-items-start ti_heading">Address:</div>
                    <div class="col-md-9 d-flex align-items-center ti_subHeading">
                        10/176, Anjaneyar Kovil street, Santhosapuram,
                        Vengaivasal, Chennai - 600073
                    </div>
                </div>

                <!-- Billing phone number -->
                <div class="row">
                    <div class="col-md-3 fw-semibold d-flex justify-content-end align-items-center ti_heading">Phone:</div>
                    <div class="col-md-9 d-flex align-items-center ti_subHeading">
                        <a href="tel:+91-6383707076" class="text-decoration-none text-black">+91-6383707076</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- table -->
        <table class="table table-hover table-responsive table-borderless">
            <thead class="border-top border-bottom border-black">
                <tr>
                    <th scope="col" class="ti_heading">Description </th>
                    <th scope="col" class="ti_heading">Qty</th>
                    <th scope="col" class="ti_heading">Unit price</th>
                    <th scope="col" class="ti_heading">Discount</th>
                    <th scope="col" class="ti_heading">Price</th>
                </tr>
            </thead>
            <tbody class="pb-5">
                @foreach($invoice->items as $item)
                <tr>
                    <th scope="row">{{ $item->item_name }}</th>
                    <td>{{ $item->quantity }}</td>
                    <td>₹ {{ number_format($item->unit_price, 2) }}</td>
                    <td>-</td>
                    <td>₹ {{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach
        
            </tbody>
            <tfoot class="border-bottom border-black">
                <tr>
                    <th scope="row"></th>
                    <td></td>
                    <td></td>
                    <td> GST (18%)</td>
                    <td>305.08</td>
                </tr>

                <tr>
                    <th scope="row"></th>
                    <td></td>
                    <td></td>
                    <td>Advance</td>
                    <td>₹ 0.00 </td>
                </tr>
                <tr>
                    <th scope="row"></th>
                    <td></td>
                    <td></td>
                    <td class="text-uppercase fw-bold">TOTAL</td>
                    <td class="fw-bold"></td>
                </tr>
            </tfoot>
        </table>
        <div class="row pb-5">
            <div class="text-center pb-4 ti_heading">(Amount in words: Two Thousand Rupees Only)</div>
            <div class="text-center ti_heading">Please make all payments payable to Twigik Technologies Private Limited.</div>
            <div class="d-flex gap-2 justify-content-center align-items-center ti_heading">
                <a href="mailto:info@twigik.com" class="text-decoration-none text-black">info@twigik.com</a>
                <span>|</span>
                <a href="mailto:www.twigik.com" class="text-decoration-none text-black">www.twigik.com</a>
            </div>
        </div>

        <!-- payment details -->
        <div class="fw-semibold ti_heading lh-lg pb-2">Payment Details</div>
        <div class="row">
            <div class="col-3 ti_heading">Account name</div>
            <div class="col-6 text-uppercase ti_heading">TWIGIK TECHNOLOGIES PRIVATE LIMITED</div>
        </div>
        <div class="row">
            <div class="col-3 ti_heading">Account number</div>
            <div class="col-6 ti_heading">50200106313602</div>
        </div>
        <div class="row">
            <div class="col-3 ti_heading">Account type</div>
            <div class="col-6 ti_heading">Current</div>
        </div>
        <div class="row">
            <div class="col-3 ti_heading">Branch</div>
            <div class="col-6 ti_heading">Pallikaranai</div>
        </div>
        <div class="row">
            <div class="col-3 ti_heading text-uppercase">IFSC</div>
            <div class="col-6 text-uppercase ti_heading">HDFC0001880</div>
        </div>
    </div>
</body>

</html>
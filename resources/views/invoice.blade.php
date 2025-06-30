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
            <!-- heading -->
            <div class="col-md-6 d-flex justify-content-end align-items-center">
                <div class="fw-bold fs-4 text-uppercase"></div>
            </div>
        </div>

        <div class="row pb-5">
            <div class="col-md-6">

            </div>

            <div class="col-md-6">

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
                <tr>
                    <th scope="row">Hosting (28/05/2025 - 27/05/2026)</th>
                    <td>1</td>
                    <td>₹ 1,694.92</td>
                    <td>-</td>
                    <td>₹ 1,694.92</td>
                </tr>
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
                    <td class="fw-bold">₹ 2,000.00 </td>
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
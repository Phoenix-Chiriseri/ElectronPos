<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .receipt {
            width: 80mm; /* Standard receipt width */
            margin: 0 auto;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #fff;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 10px;
        }

        .receipt-header h4 {
            margin: 0;
            font-size: 16px; /* Adjusted font size */
        }

        .receipt-details p {
            margin: 5px 0;
            font-size: 12px; /* Adjusted font size */
        }

        .receipt-items th, .receipt-items td {
            border: none;
            padding: 5px 0; /* Reduced padding */
            text-align: left;
            font-size: 12px; /* Adjusted font size */
        }

        .receipt-items th {
            font-weight: bold;
        }

        .receipt-totals p {
            margin: 5px 0;
            font-size: 12px; /* Adjusted font size */
        }

        .receipt-footer {
            text-align: center;
            margin-top: 10px;
            font-size: 12px; /* Adjusted font size */
        }

        .hidden-print {
            text-align: center;
            margin-top: 10px;
        }

        .hidden-print button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .hidden-print button:hover {
            background-color: #0056b3;
        }

        @media print {
            body * {
                visibility: hidden;
            }
            .receipt, .receipt * {
                visibility: visible;
            }
            .receipt {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
    </style>
    <script>
        function printReceipt() {
            window.print();
        }

        document.addEventListener('DOMContentLoaded', function() {
            printReceipt();
        });
    </script>
</head>
<body>
    <div class="receipt">
        <div class="receipt-header">
            <h4>{{ $details->name }}</h4>
        </div>
        <div class="receipt-details">
            <p>TIN: {{ $details->tinnumber }}</p>
            <p>VAT: {{ $details->vatnumber }}</p>
            <p>Phone: {{ $details->phone_number }}</p>
            <p>Email: {{ $details->email }}</p>
            <p>Payment Method: {{ $paymentMethod }}</p>
            <p>Invoice #: {{ $sale->id }}</p>
            <p>Date: {{ date('d/m/y') }}</p>
        </div>
        <div class="receipt-items">
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>{{ number_format($item['unitPrice'], 2) }}</td>
                        <td>{{ number_format($item['total'], 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="receipt-totals">
            <p>Total Excluding VAT: <span>{{ number_format($sale->total - $sale->total * 0.16, 2) }}</span></p>
            <p>VAT Total: <span>{{ number_format($sale->total * 0.16, 2) }}</span></p>
            <p>Sub Total: <span>{{ number_format($sale->total, 2) }}</span></p>
            <p>Amount Paid: <span>{{ number_format($amountPaid, 2) }}</span></p>
        </div>
        <div class="receipt-footer">
            <p>Thank you for shopping with us!</p>
        </div>
    </div>
    <div class="hidden-print">
        <button onclick="printReceipt()">Print Receipt</button>
    </div>
</body>
</html>
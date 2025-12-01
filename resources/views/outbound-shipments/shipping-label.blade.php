<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Label - {{ $outboundShipment->tracking_number }}</title>
    <!-- JsBarcode Library -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <style>
        @page {
            size: 4in 6in;
            margin: 0.1in;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            font-size: 8px;
            line-height: 1.3;
            color: #1a1a1a;
            background: white;
            width: 4in;
            height: 6in;
        }

        .label-container {
            width: 100%;
            height: 100%;
            max-width: 4in;
            max-height: 6in;
            border: 2px solid #1a1a1a;
            padding: 5px;
            page-break-after: always;
            background: white;
            display: flex;
            flex-direction: column;
            box-sizing: border-box;
        }

        /* Header Section */
        .header-section {
            border-bottom: 1px solid #1a1a1a;
            padding-bottom: 5px;
            margin-bottom: 5px;
            text-align: center;
        }

        .company-brand {
            margin-bottom: 3px;
        }

        .company-logo {
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 1px;
            color: #1a1a1a;
            margin-bottom: 1px;
        }

        .company-tagline {
            font-size: 6px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 4px;
        }

        .tracking-section {
            background: #f5f5f5;
            border: 1px solid #1a1a1a;
            padding: 4px;
            margin: 4px 0;
        }

        .tracking-label {
            font-size: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
            color: #666;
        }

        .tracking-number {
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 1px;
            font-family: 'Courier New', monospace;
            color: #1a1a1a;
        }

        .barcode-container {
            background: #fff;
            border: 1px solid #1a1a1a;
            padding: 4px;
            margin: 4px 0;
        }

        .barcode-container svg {
            max-width: 100%;
            height: 40px;
            display: block;
            margin: 0 auto;
        }

        .barcode-text {
            font-size: 8px;
            font-weight: 600;
            letter-spacing: 1.5px;
            margin-top: 2px;
            text-align: center;
            font-family: 'Courier New', monospace;
            color: #1a1a1a;
        }

        /* Address Sections */
        .address-section {
            border: 1px solid #ddd;
            padding: 4px;
            margin-bottom: 4px;
            background: #fafafa;
        }

        .section-header {
            background: #1a1a1a;
            color: #fff;
            padding: 2px 4px;
            font-size: 7px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin: -4px -4px 3px -4px;
        }

        .address-content {
            font-size: 7px;
            line-height: 1.3;
            color: #1a1a1a;
        }

        .address-content strong {
            font-size: 8px;
            text-transform: uppercase;
            display: block;
            margin-bottom: 1px;
            color: #1a1a1a;
        }

        .address-line {
            margin-bottom: 0.5px;
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3px;
            margin-top: 3px;
        }

        .info-item {
            background: #fff;
            border: 1px solid #e5e5e5;
            padding: 2px 4px;
        }

        .info-label {
            font-size: 5px;
            color: #666;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 0.5px;
        }

        .info-value {
            font-size: 7px;
            font-weight: 600;
            color: #1a1a1a;
        }

        /* Package List - Compact for many items */
        .package-section {
            border: 1px solid #ddd;
            padding: 4px;
            margin-bottom: 4px;
            background: #fff;
            flex: 1;
            min-height: 0;
            overflow-y: auto;
        }

        .package-section::-webkit-scrollbar {
            width: 2px;
        }

        .package-section::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .package-section::-webkit-scrollbar-thumb {
            background: #888;
        }

        .package-list {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2px;
        }

        .package-item {
            background: #f9f9f9;
            border-left: 2px solid #1a1a1a;
            padding: 2px 4px;
            font-size: 6px;
            line-height: 1.3;
        }

        .package-header {
            display: flex;
            align-items: center;
            gap: 3px;
            margin-bottom: 1px;
        }

        .package-number {
            background: #1a1a1a;
            color: #fff;
            padding: 0.5px 2px;
            font-weight: 700;
            font-size: 5px;
        }

        .package-name {
            font-weight: 600;
            color: #1a1a1a;
            font-size: 6px;
        }

        .package-details {
            font-size: 5px;
            color: #666;
            margin-left: 15px;
        }

        /* Customs Section */
        .customs-section {
            background: #f9f9f9;
            border: 1px solid #ddd;
            padding: 4px;
            margin-bottom: 4px;
        }

        .customs-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4px;
            margin-top: 3px;
        }

        .customs-item {
            background: #fff;
            border: 1px solid #e5e5e5;
            padding: 3px;
            text-align: center;
        }

        .customs-label {
            font-size: 5px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 1px;
            font-weight: 600;
        }

        .customs-value {
            font-size: 8px;
            font-weight: 700;
            color: #1a1a1a;
        }

        /* Footer */
        .footer {
            background: #1a1a1a;
            color: #fff;
            padding: 4px;
            text-align: center;
            margin-top: 4px;
        }

        .footer-title {
            font-size: 6px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 2px;
        }

        .footer-content {
            font-size: 6px;
            line-height: 1.3;
        }

        .footer-tracking {
            font-size: 8px;
            font-weight: 700;
            letter-spacing: 0.8px;
            margin: 2px 0;
            font-family: 'Courier New', monospace;
        }

        .footer-meta {
            font-size: 4px;
            color: #999;
            margin-top: 2px;
            padding-top: 2px;
            border-top: 1px solid #333;
        }

        /* Summary for many packages */
        .package-summary {
            background: #f5f5f5;
            border: 1px solid #ddd;
            padding: 2px 4px;
            margin-bottom: 3px;
            font-size: 6px;
            font-weight: 600;
            color: #1a1a1a;
        }

        /* Print Styles */
        @media print {
            body {
                background: white;
            }

            .no-print {
                display: none !important;
            }

            .label-container {
                border: 2px solid #1a1a1a;
                box-shadow: none;
            }

            .package-section {
                max-height: none;
                overflow: visible;
            }
        }

        @media screen {
            body {
                background: #f5f5f5;
                padding: 30px 20px;
                min-height: 100vh;
                width: auto;
                height: auto;
            }

            .label-container {
                background: white;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                margin: 0 auto;
                width: 4in;
                height: 6in;
                max-width: 4in;
                max-height: 6in;
            }
        }

        .print-controls {
            text-align: center;
            margin-bottom: 25px;
            padding: 25px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .print-controls h1 {
            margin-bottom: 15px;
            color: #1a1a1a;
            font-size: 24px;
            font-weight: 600;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
            border: 1px solid #ddd;
        }

        .btn-primary {
            background: #1a1a1a;
            color: white;
            border-color: #1a1a1a;
        }

        .btn-primary:hover {
            background: #333;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .btn-secondary {
            background: #fff;
            color: #1a1a1a;
            border-color: #ddd;
            margin-left: 10px;
        }

        .btn-secondary:hover {
            background: #f5f5f5;
        }
    </style>
</head>

<body>
    <div class="no-print print-controls">
        <h1>Shipping Label</h1>
        <button onclick="window.print()" class="btn btn-primary">
            🖨️ Print Label
        </button>
        <a href="{{ route('outbound-shipments.show', $outboundShipment) }}" class="btn btn-secondary">
            ← Back to Shipment
        </a>
    </div>

    <div class="label-container">
        <!-- Header Section -->
        <div class="header-section">
            <div class="company-brand">
                <div class="company-logo">FIA EXPRESS</div>
                <div class="company-tagline">International Shipping & Logistics</div>
            </div>

            <div class="tracking-section">
                <div class="tracking-label">Tracking Number</div>
                <div class="tracking-number">{{ $outboundShipment->tracking_number }}</div>
            </div>

            <!-- Barcode -->
            <div class="barcode-container">
                <svg id="barcode"></svg>
                <div class="barcode-text">{{ $outboundShipment->tracking_number }}</div>
            </div>
        </div>

        <!-- From Address -->
        <div class="address-section">
            <div class="section-header">FROM</div>
            <div class="address-content">
                <strong>FIA EXPRESS</strong>
                <div class="address-line">Warehouse Management System</div>
                <div class="address-line">Indonesia</div>
                <div class="address-line" style="font-size: 7px; margin-top: 3px; color: #666;">Tel: +62 XXX XXX XXXX</div>
            </div>
        </div>

        <!-- To Address -->
        <div class="address-section">
            <div class="section-header">TO</div>
            <div class="address-content">
                <strong>{{ strtoupper($outboundShipment->customer->name) }}</strong>
                @if($outboundShipment->customer->address)
                <div class="address-line">{{ $outboundShipment->customer->address }}</div>
                @endif
                @if($outboundShipment->customer->phone)
                <div class="address-line">Tel: {{ $outboundShipment->customer->phone }}</div>
                @endif
                <div class="address-line" style="margin-top: 3px;">
                    <strong>{{ strtoupper(config('countries.countries')[$outboundShipment->destination_country] ?? $outboundShipment->destination_country) }}</strong>
                </div>
            </div>
        </div>

        <!-- Shipping Information -->
        <div class="address-section">
            <div class="section-header">SHIPPING INFORMATION</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Carrier</div>
                    <div class="info-value">{{ $outboundShipment->carrier ?: 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Zone</div>
                    <div class="info-value">{{ $outboundShipment->shippingZone ? $outboundShipment->shippingZone->name : 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Date</div>
                    <div class="info-value">{{ $outboundShipment->shipping_date->format('M d, Y') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Packages</div>
                    <div class="info-value">{{ $outboundShipment->packages->count() }} pcs</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Total Weight</div>
                    <div class="info-value">{{ number_format($outboundShipment->packages->sum('weight'), 2) }} kg</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Value</div>
                    <div class="info-value">${{ number_format($outboundShipment->customs_value, 2) }}</div>
                </div>
            </div>
        </div>

        <!-- Package Details -->
        @if($outboundShipment->packages->count() > 0)
        <div class="package-section">
            <div class="section-header">PACKAGE DETAILS</div>
            @if($outboundShipment->packages->count() > 5)
            <div class="package-summary">
                Total: {{ $outboundShipment->packages->count() }} packages |
                Weight: {{ number_format($outboundShipment->packages->sum('weight'), 2) }} kg
            </div>
            @endif
            <div class="package-list">
                @foreach($outboundShipment->packages as $index => $package)
                <div class="package-item">
                    <div class="package-header">
                        <span class="package-number">#{{ $index + 1 }}</span>
                        <span class="package-name">{{ $package->product ? $package->product->name : 'Package' }}</span>
                    </div>
                    <div class="package-details">
                        Qty: {{ $package->quantity }} |
                        Wt: {{ $package->weight ? number_format($package->weight, 2) . 'kg' : 'N/A' }}
                        @if($package->customs_info && !empty($package->customs_info['hs_code']))
                        | HS: {{ $package->customs_info['hs_code'] }}
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Customs Information -->
        @if($outboundShipment->customs_value > 0)
        <div class="customs-section">
            <div class="section-header">CUSTOMS DECLARATION</div>
            <div class="customs-grid">
                <div class="customs-item">
                    <div class="customs-label">Customs Value</div>
                    <div class="customs-value">${{ number_format($outboundShipment->customs_value, 2) }}</div>
                </div>
                <div class="customs-item">
                    <div class="customs-label">Shipping Cost</div>
                    <div class="customs-value">${{ number_format($outboundShipment->shipping_cost, 2) }}</div>
                </div>
            </div>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <div class="footer-title">Track Your Package</div>
            <div class="footer-content">
                <div>www.fiaexpress.com/track</div>
                <div class="footer-tracking">{{ $outboundShipment->tracking_number }}</div>
            </div>
            <div class="footer-meta">
                Generated: {{ now()->format('M d, Y H:i') }} |
                Label ID: {{ strtoupper(substr(md5($outboundShipment->tracking_number), 0, 8)) }}
            </div>
        </div>
    </div>

    <script>
        // Generate Barcode
        document.addEventListener('DOMContentLoaded', function() {
            const trackingNumber = '{{ $outboundShipment->tracking_number }}';

            // Generate Code128 barcode
            JsBarcode("#barcode", trackingNumber, {
                format: "CODE128",
                width: 2,
                height: 50,
                displayValue: false,
                margin: 5,
                background: "#ffffff",
                lineColor: "#000000"
            });
        });
    </script>
</body>

</html>
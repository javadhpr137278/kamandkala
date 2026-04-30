<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فاکتور سفارش #{{ $order->order_number }}</title>
    <style>
        @media print {
            .no-print { display: none; }
            body { margin: 0; padding: 0; }
        }
        body {
            font-family: Tahoma, 'IRANSans', sans-serif;
            padding: 20px;
            direction: rtl;
            background: #fff;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 14px;
            line-height: 24px;
            background: #fff;
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: right;
            border-collapse: collapse;
        }
        .invoice-box table td {
            padding: 8px 5px;
            vertical-align: top;
        }
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }
        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }
        .invoice-box table tr.heading td {
            background: #f8f9fa;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
        .btn-print {
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-bottom: 20px;
            font-size: 16px;
            border-radius: 5px;
        }
        .btn-print:hover {
            background: #45a049;
        }
        .text-center {
            text-align: center;
        }
        .text-left {
            text-align: left;
        }
        .text-right {
            text-align: right;
        }
        .bold {
            font-weight: bold;
        }
        .mt-20 {
            margin-top: 20px;
        }
        .mb-20 {
            margin-bottom: 20px;
        }
        .border-bottom {
            border-bottom: 1px solid #ddd;
        }
        .total-row {
            background-color: #d4edda;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="no-print" style="text-align: center; margin-bottom: 20px;">
    <button class="btn-print" onclick="window.print();">چاپ فاکتور</button>
    <button class="btn-print" onclick="window.close();" style="background: #6c757d;">بستن</button>
</div>

<div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="2">
                <table>
                    <tr>
                        <td class="title">
                            <h2 style="margin: 0; color: #4CAF50;">فاکتور خرید</h2>
                            <small style="color: #999;">شماره ثبت: {{ $order->order_number }}</small>
                        </td>
                        <td class="text-left">
                            <strong>تاریخ:</strong> {{ verta($order->created_at)->format('Y/m/d H:i') }}<br>
                            <strong>شماره فاکتور:</strong> {{ $order->order_number }}<br>
                            <strong>وضعیت:</strong>
                            @if($order->status == 'pending')
                                <span style="color: #ffc107;">در انتظار پرداخت</span>
                            @elseif($order->status == 'processing')
                                <span style="color: #17a2b8;">در حال پردازش</span>
                            @elseif($order->status == 'completed')
                                <span style="color: #28a745;">تکمیل شده</span>
                            @elseif($order->status == 'cancelled')
                                <span style="color: #dc3545;">لغو شده</span>
                            @else
                                <span style="color: #6c757d;">ناموفق</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="2">
                <table>
                    <tr>
                        <td style="width: 50%;">
                            <strong>اطلاعات صورتحساب</strong><br>
                            {{ $order->billing_first_name }} {{ $order->billing_last_name }}<br>
                            تلفن: {{ $order->billing_phone }}<br>
                            ایمیل: {{ $order->billing_email ?? '-' }}<br>
                            آدرس: {{ $order->billing_address_1 ?? '-' }}<br>
                            @if($order->billing_city) شهر: {{ $order->billing_city }}<br> @endif
                            @if($order->billing_postcode) کدپستی: {{ $order->billing_postcode }} @endif
                        </td>
                        <td style="width: 50%;">
                            <strong>اطلاعات ارسال</strong><br>
                            @if($order->address_choice == 'shipping' && $order->shipping_first_name)
                                {{ $order->shipping_first_name }} {{ $order->shipping_last_name }}<br>
                                تلفن: {{ $order->shipping_phone ?? '-' }}<br>
                                آدرس: {{ $order->shipping_address_1 ?? '-' }}<br>
                                @if($order->shipping_city) شهر: {{ $order->shipping_city }}<br> @endif
                            @elseif($order->address_choice == 'custom')
                                آدرس: {{ $order->custom_address ?? '-' }}<br>
                                @if($order->custom_city) شهر: {{ $order->custom_city }}<br> @endif
                                @if($order->custom_postcode) کدپستی: {{ $order->custom_postcode }} @endif
                            @else
                                همان آدرس صورتحساب
                            @endif
                            @if($order->shipping_date)
                                <br><strong>تاریخ ارسال:</strong> {{ verta($order->shipping_date)->format('Y/m/d') }}
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="heading">
            <td style="width: 60%;">شرح</td>
            <td style="width: 40%;">مبلغ</td>
        </tr>

        @php
            // تبدیل JSON string به آرایه
            $orderItems = json_decode($order->order_items, true) ?? [];
            $itemsCount = count($orderItems);
        @endphp

        @foreach($orderItems as $index => $item)
            <tr class="item {{ $loop->last ? 'last' : '' }}">
                <td>
                    {{ $item['product_name'] ?? $item['name'] ?? '-' }}
                    @if(!empty($item['color_name']))
                        <br><small style="color: #666;">رنگ: {{ $item['color_name'] }}</small>
                    @endif
                    <br><small>تعداد: {{ $item['quantity'] ?? 1 }} عدد</small>
                </td>
                <td>
                    {{ number_format($item['total_price'] ?? ($item['price'] ?? 0) * ($item['quantity'] ?? 1)) }} تومان
                </td>
            </tr>
        @endforeach

        <tr class="total">
            <td class="text-left bold">جمع جزء</td>
            <td>{{ number_format($order->subtotal) }} تومان</td>
        </tr>

        @if($order->discount_amount > 0)
            <tr class="total">
                <td class="text-left bold">تخفیف</td>
                <td style="color: #28a745;">-{{ number_format($order->discount_amount) }} تومان</td>
            </tr>
        @endif

        <tr class="total">
            <td class="text-left bold">هزینه ارسال</td>
            <td>{{ number_format($order->shipping_cost) }} تومان</td>
        </tr>

        @if($order->gift_card_amount > 0)
            <tr class="total">
                <td class="text-left bold">کارت هدیه</td>
                <td style="color: #28a745;">-{{ number_format($order->gift_card_amount) }} تومان</td>
            </tr>
        @endif

        <tr class="total total-row">
            <td class="text-left bold">جمع کل</td>
            <td class="bold">{{ number_format($order->total) }} تومان</td>
        </tr>
    </table>

    <div style="margin-top: 30px; text-align: center; font-size: 12px; color: #999;">
        <hr>
        با تشکر از خرید شما<br>
        فروشگاه اینترنتی کمند
    </div>

    @if($order->notes)
        <div style="margin-top: 20px; padding: 10px; background: #f8f9fa; border-radius: 5px;">
            <strong>یادداشت:</strong><br>
            {{ $order->notes }}
        </div>
    @endif
</div>
</body>
</html>

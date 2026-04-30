<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;

class PaymentGatewayController extends Controller
{
    // GET: لیست درگاه‌ها
    public function index()
    {
        $gateways = PaymentGateway::orderBy('id', 'desc')->get();
        return view('admin.payment_gateways.list', compact('gateways'));
    }

    // GET: فرم ایجاد
    public function create()
    {
        return view('admin.payment_gateways.create');
    }

    // POST: ذخیره درگاه جدید
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:payment_gateways',
            'title' => 'required|string',
            'merchant' => 'required|string',
            'callback_url' => 'required|url'
        ]);

        PaymentGateway::create([
            'name' => $request->name,
            'title' => $request->title,
            'is_active' => $request->is_active ? true : false,
            'config' => [
                'merchant' => $request->merchant,
                'callback_url' => $request->callback_url
            ]
        ]);

        return redirect()->route('payment-gateways.index')
            ->with('success', 'درگاه با موفقیت ایجاد شد');
    }

    // GET: فرم ویرایش
    public function edit(PaymentGateway $payment_gateway)
    {
        return view('admin.payment_gateways.edit', compact('payment_gateway'));
    }

    // PUT: به‌روزرسانی درگاه
    public function update(Request $request, PaymentGateway $payment_gateway)
    {
        $request->validate([
            'title' => 'required|string',
            'merchant' => 'required|string',
            'callback_url' => 'required|url'
        ]);

        $payment_gateway->update([
            'title' => $request->title,
            'is_active' => $request->is_active ? true : false,
            'config' => [
                'merchant' => $request->merchant,
                'callback_url' => $request->callback_url
            ]
        ]);

        return redirect()->route('payment-gateways.index')
            ->with('success', 'درگاه با موفقیت ویرایش شد');
    }

    // DELETE: حذف درگاه
    public function destroy(PaymentGateway $payment_gateway)
    {
        $payment_gateway->delete();

        return redirect()->route('payment-gateways.index')
            ->with('success', 'درگاه حذف شد');
    }

    // فعال‌سازی یک درگاه (و غیرفعال کردن سایرین)
    public function activate(PaymentGateway $payment_gateway)
    {
        PaymentGateway::where('id', '!=', $payment_gateway->id)
            ->update(['is_active' => false]);

        $payment_gateway->update(['is_active' => true]);

        return redirect()->back()->with('success', 'درگاه فعال شد');
    }
}

<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;

class PublicDonateController extends Controller
{
    public function index()
    {
        // Get donation options from config
        $paypalEnabled = config('donate.paypal_enable');
        $bankEnabled = config('donate.bank_enable');
        $paymentwallEnabled = config('donate.paymentwall_enable');
        $ipaymuEnabled = config('donate.ipaymu_enable');
        
        // Get currency and rates
        $currency = config('pw-config.currency_name', 'Points');
        
        return view('website.donate', [
            'paypalEnabled' => $paypalEnabled,
            'bankEnabled' => $bankEnabled,
            'paymentwallEnabled' => $paymentwallEnabled,
            'ipaymuEnabled' => $ipaymuEnabled,
            'currency' => $currency
        ]);
    }
}
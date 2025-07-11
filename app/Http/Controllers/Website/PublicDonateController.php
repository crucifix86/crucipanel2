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
        
        // Get donation configurations
        $paypalConfig = [
            'enabled' => $paypalEnabled,
            'currency' => config('donate.paypal_currency'),
            'minimum' => config('donate.paypal_min'),
            'maximum' => config('donate.paypal_max'),
            'rate' => config('donate.paypal_rate'),
            'double' => config('donate.paypal_double')
        ];
        
        $bankConfig = [
            'enabled' => $bankEnabled,
            'minimum' => config('donate.bank_mini'),
            'rate' => config('donate.bank_price'),
            'double' => config('donate.bank_double'),
            'banks' => []
        ];
        
        // Get bank accounts
        for ($i = 1; $i <= 3; $i++) {
            if (config("donate.bank_use{$i}")) {
                $bankConfig['banks'][] = [
                    'name' => config("donate.bank_name{$i}"),
                    'owner' => config("donate.bank_owner{$i}"),
                    'number' => config("donate.bank_number{$i}")
                ];
            }
        }
        
        return view('website.donate', [
            'paypalConfig' => $paypalConfig,
            'bankConfig' => $bankConfig,
            'paymentwallEnabled' => $paymentwallEnabled,
            'ipaymuEnabled' => $ipaymuEnabled,
            'currency' => $currency
        ]);
    }
}
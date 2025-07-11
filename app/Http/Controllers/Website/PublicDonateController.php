<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;

class PublicDonateController extends Controller
{
    public function index()
    {
        // Get donation options from config
        $paypalEnabled = config('pw-config.payment.paypal.status');
        $bankEnabled = config('pw-config.payment.bank_transfer.status');
        $paymentwallEnabled = config('pw-config.payment.paymentwall.status');
        $ipaymuEnabled = config('ipaymu.status');
        
        // Get currency and rates
        $currency = config('pw-config.currency_name', 'Points');
        
        // Get donation configurations
        $paypalConfig = [
            'enabled' => $paypalEnabled,
            'currency' => config('pw-config.payment.paypal.currency'),
            'minimum' => config('pw-config.payment.paypal.minimum'),
            'maximum' => config('pw-config.payment.paypal.maximum'),
            'rate' => config('pw-config.payment.paypal.currency_per'),
            'double' => config('pw-config.payment.paypal.double')
        ];
        
        $bankConfig = [
            'enabled' => $bankEnabled,
            'minimum' => config('pw-config.payment.bank_transfer.minimum_dp'),
            'rate' => config('pw-config.payment.bank_transfer.pay'),
            'double' => config('pw-config.payment.bank_transfer.double'),
            'currency' => config('pw-config.payment.bank_transfer.currency'),
            'banks' => []
        ];
        
        // Get bank accounts
        for ($i = 1; $i <= 3; $i++) {
            if (config("pw-config.payment.bank_transfer.bank_{$i}_use")) {
                $bankConfig['banks'][] = [
                    'name' => config("pw-config.payment.bank_transfer.bank_{$i}_name"),
                    'owner' => config("pw-config.payment.bank_transfer.bank_{$i}_owner"),
                    'number' => config("pw-config.payment.bank_transfer.bank_{$i}_number")
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
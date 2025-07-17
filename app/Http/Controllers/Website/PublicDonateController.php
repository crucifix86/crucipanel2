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
        $ipaymuEnabled = config('pw-config.payment.ipaymu.status');
        
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
            'minimum' => 10, // Default minimum since it's not in config
            'rate' => config('pw-config.payment.bank_transfer.multiply'), // Using multiply as rate
            'double' => config('pw-config.payment.bank_transfer.double'),
            'currency' => config('pw-config.payment.bank_transfer.CurrencySign'),
            'banks' => []
        ];
        
        // Get bank accounts - using the actual config structure
        if (config('pw-config.payment.bank_transfer.bankAccountNo1')) {
            $bankConfig['banks'][] = [
                'name' => config('pw-config.payment.bank_transfer.bankName1'),
                'owner' => config('pw-config.payment.bank_transfer.accountOwner'),
                'number' => config('pw-config.payment.bank_transfer.bankAccountNo1')
            ];
        }
        if (config('pw-config.payment.bank_transfer.bankAccountNo2')) {
            $bankConfig['banks'][] = [
                'name' => config('pw-config.payment.bank_transfer.bankName2'),
                'owner' => config('pw-config.payment.bank_transfer.accountOwner'),
                'number' => config('pw-config.payment.bank_transfer.bankAccountNo2')
            ];
        }
        if (config('pw-config.payment.bank_transfer.bankAccountNo3')) {
            $bankConfig['banks'][] = [
                'name' => config('pw-config.payment.bank_transfer.bankName3'),
                'owner' => config('pw-config.payment.bank_transfer.accountOwner'),
                'number' => config('pw-config.payment.bank_transfer.bankAccountNo3')
            ];
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
<?php




/*
 * @author Harris Marfel <hrace009@gmail.com>
 * @link https://youtube.com/c/hrace009
 * @copyright Copyright (c) 2022.
 */

return [
    'chat_log_path' => '/home/hrace009/Core/Wanmei2015/logs/',
    'currency_name' => 'Coin',
    'encryption_type' => 'base64',
    'level_up_cap' => '150',
    'logo' => 'img/logo/crucifix_logo.svg',
    'header_logo' => 'img/logo/haven_perfect_world_logo.svg',
    'badge_logo' => 'img/logo/crucifix_logo.svg',
    'server_ip' => '127.0.0.1',
    'server_name' => 'Haven Perfect World',
    'gmwa' => '62879456123',
    'fakeonline' => '',
    'server_version' => '156',
    'teleport_world_tag' => '1',
    'teleport_x' => '1280.6788',
    'teleport_y' => '219.61784',
    'teleport_z' => '1021.2097',
    'version' => '1.0',
    'ignoreRoles' => '1024,1040',
    'ignoreFaction' => '16,60',
    'cubi_transfer_method' => 'transfer', // Options: 'transfer' (uses pwp_transfer table), 'direct' (uses usecash directly), 'auto' (tries both)
    'system' => [
        'apps' => [
            'news' => true,
            'shop' => true,
            'donate' => true,
            'voucher' => true,
            'inGameService' => true,
            'ranking' => true,
            'vote' => true,
            'captcha' => false
        ],
    ],
    'news' => [
        'page' => '15',
        'default_og_logo' => 'img/logo/crucifix_logo.svg',
    ],
    'shop' => [
        'page' => '15'
    ],
    'payment' => [
        'paymentwall' => [
            'status' => false,
            'widget_code' => 'p4_1',
            'widget_width' => '371',
            'widget_high' => '450',
            'project_key' => '',
            'secret_key' => '',
            'pingback_path' => 'pingback/paymentwall'
        ],
        'bank_transfer' => [
            'status' => false,
            'double' => false,
            'accountOwner' => '',
            'bankAccountNo1' => '',
            'bankName1' => '',
            'bankAccountNo2' => '',
            'bankName2' => '',
            'bankAccountNo3' => '',
            'bankName3' => '',
            'multiply' => '100000',
            'limit' => '5000000',
            'CurrencySign' => 'Rp.',
            'payment_price' => '1750',
        ],
        'paypal' => [
            'status' => false,
            'double' => false,
            'client_id' => '',
            'secret' => '',
            'currency' => 'USD',
            'currency_per' => '1',
            'minimum' => '1',
            'maximum' => '50',
            'mingetbonus' => '500',
            'bonusess' => '10',
            'sandbox' => true
        ],
        'ipaymu' => [
            'status' => false,
            'double' => false,
            'va' => '',
            'apikey' => '',
            'sandbox' => true
        ]
    ],
    'discord' => 'link here'
];

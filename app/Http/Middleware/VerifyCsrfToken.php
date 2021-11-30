<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        'admin/pics/upload',
        'admin/pics/crop',
        'admin/pics/wangeditor_upload',
        'shop/GetUserChooseLogistcs',
        'shop/checkoutCallback',
        'shop/checkoutServerCallback',
        'member/payAgain/*'
    ];
}

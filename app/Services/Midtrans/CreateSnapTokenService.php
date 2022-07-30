<?php

namespace App\Services\Midtrans;

use Midtrans\Snap;

class CreateSnapTokenService extends Midtrans
{

    public function getSnapToken($params)
    {

        $snapToken = Snap::getSnapToken($params);

        return $snapToken;
    }
}
<?php

namespace App\Http\Controllers\PayCallBack;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // 回调处理
    public function payment($name, $device)
    {
        return $this->getService('Payment')->payment($name, $device);
    }

    public function paypal(){
        echo 1;die;

        return $this->getService('Payment')->paypal_cb();


    }
}

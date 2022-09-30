<?php

// 简体中文

return [
    'error'                             =>  'error.',
    'success'                           =>  'success.',
    'failed'                            =>  'failed.',
    'loginOk'                           =>  'loginOk.',
    'loginErr'                          =>  'loginErr.',
    'loginThr'                          =>  'loginThr.',
    'loginOut'                          =>  'loginOut.',
    'loginInv'                          =>  'loginInv.',
    'pmsThr'                            =>  'pmsThr.',
    'pwdErr'                            =>  'pwdErr.',
    'userThr'                           =>  'userThr.',
    'oauthThr'                          =>  'oauthThr.',
    'configThr'                         =>  'configThr.',
    'phoneThr'                          =>  'phoneThr.',
    'userExist'                         =>  'userExist.',
    'phoneExist'                        =>  'phoneExist.',

    // 订单状态
    'orderCancel'                                  =>   'orderCancel',
    'waitPay'                                      =>   'waitPay',
    'waitSend'                                     =>   'waitSend',
    'waitRec'                                      =>   'waitRec',
    'orderConfirm'                                 =>   'orderConfirm', // 确认收货
    'waitComment'                                  =>   'waitComment',
    'orderRefund'                                  =>   'orderRefund',
    'orderReturned'                                =>   'orderReturned',
    'orderRefundOver'                              =>   'orderRefundOver',
    'orderCompletion'                              =>   'orderCompletion',

    'systemHandleMoney'                            =>   'systemHandleMoney',

    // 支付类型
    'paymentWechat'                                =>   'paymentWechat',
    'paymentAli'                                   =>   'paymentAli',
    'paymentMoney'                                 =>   'paymentMoney',


    // 权限的一些中文
    'permission' => [
        'view'      =>  '查看',
        'store'     =>  '添加',
        'update'    =>  '编辑',
        'destroy'   =>  '删除',
        'index'     =>  '列表',
    ],

    // 上传的错误信息
    'upload' => [
        'fileNotFound'  =>  '没有找到上传文件.',
        'invalidFile'   =>  '无效文件上传.',
        'notAllow'      =>  '文件类型不允许上传.',
        'uploadThr'     =>  '上传异常.',
    ],

    // 短信相关sms
    'sms' => [
        'phoneError'    =>  'phoneError.',
        'signEmpty'     =>  'signEmpty.',
        'sendErr'       =>  'sendErr.',
        'smsErr'        =>  'smsErr.',
        'smsInvalid'    =>  'smsInvalid.',
        'reSend'        =>  'reSend.',
        'phoneExists'   =>  'phoneExists.',
        'phoneNoExists' =>  'phoneNoExists.',
    ],

    // 支付相关payment
    'payment' => [
        'orderErr'          =>  '订单信息错误.',
        'onlineRecharge'    =>  '在线充值',
        'orderPay'          =>  '订单支付',
        'paymentFailed'     =>  '调取支付失败.',
    ],

    // 店铺相关
    'store' => [
        'defined'       =>  '店铺已经存在.',
        'notMall'       =>  '您不是店铺拥有者.',
        'subLimit'      =>  '子账户不允许开设店铺.',
    ],

    // 提现
    'cash' => [
        'notCheck'          =>  '请先用户认证填写银行信息.',
        'moneyZero'         =>  '金额不能为0.',
        'moneyNotEnough'    =>  '提现余额不足.',
    ],

    // 商品
    'goods' => [
        'checkSku'          =>  '请选择商品规格.',
    ],

    // 营销
    'discount' => [
        'over100'           =>  '折扣不能超过100.',
        'need'              =>  '成团人数不能低于2.',
        'couponStockErr'    =>  '优惠劵已经领完.',
        'couponExists'      =>  '优惠劵不存在.',
        'couponHas'         =>  '优惠劵已经领取过.',
    ],

    // 订单
    'order' => [
        'error'     =>  'error.',
        'empty'     =>  'empty.',
        'handleErr' =>  'handleErr.',
        'stockErr'  =>  'stockErr.',
        'addrErr'   =>  'addrErr.',
        'paymentErr' =>  'paymentErr.',
        'payed'     =>  'payed.',
        'payErr'    =>  'Fail.',
        'moneyNotEnough'    =>  'money Not Enough.',
        'moneyPay'  =>  '重复创建支付订单.',
        'deliveryEmpty'  =>  'delivery is empty.',
        'orderSettlement'  =>  '系统结算.',
        'orderSettlementHandle'  =>  '手动结算.',
        'goodsCommission'  =>  '商品分佣',
    ]
];

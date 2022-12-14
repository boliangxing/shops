<?php

namespace App\Http\Resources;

use App\Qingwuit\Services\OrderService;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $orderService = new OrderService();
        return [
            'data'=>$this->collection->map(function ($item) use ($orderService) {
                return [
                    'id'                    =>  $item->id,
                    'order_no'              =>  $item->order_no,
                    'order_name'            =>  $item->order_name,
                    'order_image'           =>  $item->order_image,
                    'total_price'           =>  $item->total_price,
                    'store_name'            =>  $item->store->store_name,
                    'buyer_name'            =>  $item->user->nickname??'',
                    'refund_id'             =>  empty($item->refund)?0:$item->refund->id??'',
                    'refund_status_cn'      =>  empty($item->refund)?'':$this->refundStatusCn($item),
                    'refund_step'           =>  empty($item->refund)?0:$item->refund->refund_step??'',
                    'order_status'          =>  $item->order_status,
                    'refund_status'         =>  $item->refund_status,
                    'order_status_cn'       =>  $orderService->getOrderStatusCn($item),
     
             
                    'pay_time'              =>  $item->pay_time,
                    'delivery_time'         =>  $item->delivery_time,
                    'receipt_time'          =>  $item->receipt_time,
                    'comment_time'          =>  $item->comment_time,
                    'created_at'            =>  $item->created_at->format('Y-m-d H:i:s'),
                    'updated_at'            =>  $item->updated_at->format('Y-m-d H:i:s'),
                ];
            }),
            'total'=>$this->total(), // ????????????
            'per_page'=>$this->perPage(), // ????????????
            'last_page'=>$this->lastPage(), // ????????????
            'current_page'=>$this->currentPage(), // ????????????
        ];
    }

    public function refundStatusCn($info)
    {
        $cn = '';
        if ($info->refund->refund_verify == 0) {
            $cn = '????????????';
        }
        if ($info->refund->refund_verify == 2) {
            $cn = '????????????';
        }
        if ($info->refund->refund_verify == 1 && $info->refund->refund_step==0) {
            $cn = '??????????????????';
        }
        if ($info->refund->refund_step==1) {
            $cn = '??????????????????';
        }
        if ($info->refund->refund_step==2) {
            $cn = '??????????????????';
        }
        if ($info->refund->refund_step==3) {
            $cn = '??????????????????';
        }
        return $cn;
    }
}

<?php

namespace App\Services\order;

use App\Http\Requests\order\StoreOrderPostRequest;
use App\Models\Item;
use App\Models\Orders;
use Exception;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function Create(StoreOrderPostRequest $request)
    {
        $data = collect($request->all())->sortBy('id');
        $items=Item::whereIn('id',$data['id'])->get();

        if (count($items)==count($data['id'])) {
            $result=$this->checkQuantity($items,$data['quantity']);
            
            if ($result) {
                throw new Exception("quantity insufficient ".$result);
            }
            
            for ($i=0; $i < count($items); $i++) { 
                $items[$i]->decrement('quantity', $data['quantity'][$i]); 
            }

            $handledData=$this->handleData($items,$data);
            $order=$this->storeOrder();
            $order->items()->attach($handledData,[],false);

            return $order;
            
        }else{
            throw new Exception("Items Not found", 1);
        }
    }

    public function checkQuantity($items,$quantity)
    {
        $insufficient=array();
        for ($i=0; $i < count($quantity); $i++) { 
            if (($items[$i]->quantity - $quantity[$i])<0) {
                array_push($insufficient,$items[$i]);    
            }
        }
        $msg="";
        foreach ($insufficient as $item) {
            $msg.=" {".$item["name"]."} ";
        }
        return $msg;
    }


    public function storeOrder()
    {
        $order=new Orders();
        $order->type="Purchase";
        $order->status=1;
        $order->userId=Auth::user()->id;
        $order->save();
        return $order;
    }

    public function handleData($items,$data)
    {
        $x=array();
        for ($i=0; $i < count($items); $i++) { 
            $x[$items[$i]->id]=[
                "price"=>$data['priceAfterDiscount'][$i],
                "quantity"=>$data['quantity'][$i],
            ];
        }
        return $x;
    }
}











?>